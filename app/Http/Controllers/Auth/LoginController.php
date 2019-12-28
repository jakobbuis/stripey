<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Person;
use App\StoredTokens;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Socialite;

class LoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/calendar.events.readonly'])
            ->with(['access_type' => 'offline', 'prompt' => 'consent'])
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleProviderCallback(): RedirectResponse
    {
        $socialUser = Socialite::driver('google')->user();

        // Find or create an related user
        $internalUser = User::firstOrNew(['email' => $socialUser->email]);
        $internalUser->name = $socialUser->name;
        $internalUser->photo = $socialUser->avatar;
        $internalUser->save();
        Auth::login($internalUser);

        // If this user is not a person yet, create it
        $person = Person::firstOrNew(['email' => $socialUser->email]);
        $person->name = $socialUser->name;
        $person->email = $socialUser->email;
        $person->photo = $socialUser->avatar;
        $person->save();

        // Store the token in cache for use in background jobs
        $token = $socialUser->token;
        $refreshToken = $socialUser->refreshToken;
        $expiresAt = Carbon::now()->addSeconds($socialUser->expiresIn);
        StoredTokens::store($token, $refreshToken, $expiresAt);

        return redirect()->route('people.index');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('info');
    }
}
