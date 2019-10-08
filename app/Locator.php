<?php

namespace App;

use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Support\Facades\Session;

class Locator
{
    private $calendar;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setAccessToken(Session::get('oauth.token'));
        $this->calendar = new Google_Service_Calendar($client);
    }

    public function locate(Person $person) : string
    {
        if ($this->isOutSick($person)) {
            return 'ziek thuis';
        }

        return 'onbekend';
    }

    private function isOutSick(Person $person) : bool
    {
        $query = [
            'timeMin' => Carbon::now()->startOfDay()->toRfc3339String(),
            'timeMax' => Carbon::now()->endOfDay()->toRfc3339String(),
            'singleEvents' => true, // Expand recurring events into separate instances
        ];
        $results = $this->calendar->events->listEvents(config('calendars.afwezig'), $query);
        $events = collect($results->getItems())->mapWithKeys(function ($event) {
            return [$event->getSummary() => [$event->start->dateTime ?? $event->start->date, $event->end->dateTime ?? $event->end->date]];
        });

        dd($query, $events);

        // $calendarId = 'primary';
        // $optParams = [
        //     'maxResults' => 10,
        //     'orderBy' => 'startTime',
        //     'singleEvents' => true,
        //     'timeMin' => date('c'),
        // ];

        // dd($events);
    }
}
