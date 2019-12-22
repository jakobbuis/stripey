<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Abstraction around the set of stored tokens in Redis
 */
class StoredTokens
{
    private static $cacheKey = 'oauth.tokens';

    public static function store(string $token, Carbon $expiresAt): void
    {
        Cache::lock('oauth', 5)->get(function () use ($token, $expiresAt) {
            $tokens = Cache::get(static::$cacheKey, []);
            $tokens[] = (object) compact('token', 'expiresAt');
            Cache::put(static::$cacheKey, $tokens);
        });
    }

    public static function validToken(): ?string
    {
        self::cleanTokens();

        $tokens = Cache::get(self::$cacheKey);
        if (!is_array($tokens) || count($tokens) < 1) {
            return null;
        }

        return $tokens[0]->token;
    }

    private static function cleanTokens(): void
    {
        Cache::lock('oauth', 5)->get(function () {
            $tokens = Cache::get(static::$cacheKey, []);

            $now = Carbon::now();
            $freshTokens = array_filter($tokens, function ($token) use ($now) {
                return $token->expiresAt > $now;
            });

            // Sort tokens freshest first
            usort($freshTokens, function ($a, $b) {
                return $a->expiresAt <=> $b->expiresAt;
            });

            Cache::put(static::$cacheKey, $freshTokens);
        });
    }
}
