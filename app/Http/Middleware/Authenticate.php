<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Authenticate
{
    /**
     * Force a user to the homepage, unless logged-in
     */
    public function handle(Request $request, Closure $next)
    {
        // Must have a token
        if (!Session::has('oauth.token')) {
            Session::forget('oauth');
            return redirect()->route('login');
        }

        // Token must still be fresh
        $expiry = Session::get('oauth.expiresAt');
        if ($expiry <= Carbon::now()) {
            Session::forget('oauth');
            return redirect()->route('login');
        }

        return $next($request);
    }
}
