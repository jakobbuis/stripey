<?php

namespace App\Providers;

use App\StoredTokens;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class GoogleCalendarProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Google_Client::class, function ($app) {
            $client = new Google_Client();
            $token = StoredTokens::validToken();
            if (!$token) {
                throw new RuntimeException('Cannot initialize Google_Client without having atleast one valid token available');
            }
            $client->setAccessToken($token);
            return $client;
        });

        $this->app->bind(Google_Service_Calendar::class, function ($app) {
            $client = app(Google_Client::class);
            return new Google_Service_Calendar($client);
        });
    }
}
