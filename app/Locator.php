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
        $calendar = new Calendar($person->email);

        $event = $calendar->currentEvent();
        if ($event) {
            $output = "in a meeting until {$event->until()}";
            if ($event->summary()) {
                $output .= " ({$event->summary()})";
            }
            return  $output;
        }

        return 'op kantoor';
    }
}
