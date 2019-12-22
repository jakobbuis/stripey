<?php

namespace App\Console\Commands;

use App\Person;
use App\Time;
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
        $now = $this->now;
        $start = $now->startOfDay()->toRfc3339String();
        $end = $now->endOfDay()->toRfc3339String();

        Log::debug("Start loading calendars", ['now' => $now]);

        Person::all()->each(function ($person) use ($start, $end) {
            // Load the events for today
            $events = app(Google_Service_Calendar::class)->events->listEvents($person->email, [
                'timeMin' => $start,
                'timeMax' => $end,
                'singleEvents' => true, // Expand recurring events into separate instances
            ])->items;

            Cache::put("person.{$person->id}.calendar", $events);
            Log::debug("Loaded calendar", ['person' => $person->id, 'events_count' => count($events)]);
        });

        Log::debug('Completed loading calendars');
    }
}
