<?php

namespace App;

use Carbon\Carbon;
use Google_Client;
use Illuminate\Support\Facades\Cache;

/**
 * Abstraction around the set of stored tokens in Redis
 */
class StoredTokens
{
    private static $cacheKey = 'oauth.tokens';
    private static $lockKey = 'oauth_tokens_lock';

    public static function store(string $token, string $refreshToken, Carbon $expiresAt): void
    {
        Cache::lock(static::$lockKey, 5)->get(function () use ($token, $refreshToken, $expiresAt) {
            $tokens = Cache::get(static::$cacheKey, []);
            $tokens[] = (object) compact('token', 'refreshToken', 'expiresAt');
            Cache::forever(static::$cacheKey, $tokens);
        });
    }

    public static function validToken(): ?string
    {
        // If we have zero tokens on file -> null
        $tokens = Cache::get(self::$cacheKey);
        if (!is_array($tokens) || count($tokens) < 1) {
            return null;
        }

        // Find the tokens that are fresh for atleast one more minute
        $freshTokens = array_values(array_filter($tokens, function ($token) {
            return $token->expiresAt > Carbon::now()->addMinute();
        }));

        if (count($freshTokens)) {
            return $freshTokens[0]->token;
        }
        return null;
    }

    /**
     * Refresh all tokens in cache
     */
    public static function refreshTokens(): void
    {
        Cache::lock(static::$lockKey, 30)->get(function () {
            $tokens = Cache::get(self::$cacheKey) ?? [];

            foreach ($tokens as $token) {
                // Only refresh tokens that are going to expire in the next fifteen minutes
                if ($token->expiresAt > Carbon::now()->addMinutes(15)) {
                    continue;
                }

                // Laravel Socialite doesn't include functionality to refresh tokens,
                // so we instantiate the Google API Client with only the refresh
                // token to do that for us.
                $client = new Google_Client();
                $client->setClientId(config('services.google.client_id'));
                $client->setClientSecret(config('services.google.client_secret'));
                $client->setAccessType('offline');
                $client->refreshToken($token->refreshToken);

                // Store the new details on the existing token (preserving the refresh token)
                $newToken = (object) $client->getAccessToken();
                $token->token = $newToken->access_token;
                $token->expiresAt = Carbon::createFromTimestamp($newToken->created)->addSeconds($newToken->expires_in - 100);
            }

            Cache::forever(static::$cacheKey, $tokens);
        });
    }
}
