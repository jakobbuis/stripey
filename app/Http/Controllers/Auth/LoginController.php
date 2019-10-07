<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

        Session::put('oauth', [
            'token' => $user->token,
            'expiresAt' => Carbon::now()->addSeconds($user->expiresIn),
            'user' => $user,
        ]);

        return redirect()->route('people.index');
    }
}
