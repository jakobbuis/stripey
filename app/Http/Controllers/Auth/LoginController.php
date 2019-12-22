<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\StoredTokens;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Socialite;

class LoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToProvider() : RedirectResponse
    {
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/calendar.events.readonly'])
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleProviderCallback() : RedirectResponse
    {
        $user = Socialite::driver('google')->user();
        $token = $user->token;
        $expiresAt = Carbon::now()->addSeconds($user->expiresIn);

        Session::put('oauth', compact('token', 'expiresAt', 'user'));

        // Store the token in cache for use in background jobs
        StoredTokens::store($token, $expiresAt);

        return redirect()->route('people.index');
    }

    public function logout() : RedirectResponse
    {
        Session::forget('oauth');
        return redirect()->route('people.index');
    }
}
