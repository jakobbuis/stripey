<?php

namespace App\Console\Commands;

use App\Person;
use App\StoredTokens;
use App\Time;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LoadCalendars extends Command
{
    protected $signature = 'calendars:load';
    protected $description = 'Load all calendars for known users';

    private $now;

    public function __construct(Time $time)
    {
        parent::__construct();
        $this->now = $time->now();
    }

    public function handle()
    {
        // Get a token from storage
        $token = StoredTokens::validToken();
        if (!$token) {
            Log::info('Cannot load calendar data: no valid token on file');
            return;
        }

        // Construct the client
        $client = new Google_Client();
        $client->setAccessToken($token);
        $calendar = new Google_Service_Calendar($client);

        // Determine search boundaries (today)
        $now = $this->now;
        $start = $now->startOfDay()->toRfc3339String();
        $end = $now->endOfDay()->toRfc3339String();

        Log::debug("Start loading calendars", ['now' => $now]);

        Person::all()->each(function ($person) use ($calendar, $start, $end) {
            // Load the events for today
            $events = $calendar->events->listEvents($person->email, [
                'timeMin' => $start,
                'timeMax' => $end,
                'singleEvents' => true, // Expand recurring events into separate instances
            ])->items;

            Cache::forever("person.{$person->id}.calendar", $events);
            Log::debug("Loaded calendar", ['person' => $person->id, 'events_count' => count($events)]);
        });

        Log::debug('Completed loading calendars');
    }
}
