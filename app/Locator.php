<?php

namespace App;

use App\Calendar\Calendar;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Support\Facades\Session;

class Locator
{
    public function locate(Person $person) : string
    {
        $calendar = Calendar::forPerson($person);

        $event = $calendar->currentEvent();
        if ($event) {
            return "in a meeting until {$event->until()}";
        }

        return 'op kantoor';
    }
}
