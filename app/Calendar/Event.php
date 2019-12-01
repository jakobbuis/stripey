<?php

namespace App\Calendar;

use Carbon\Carbon;
use Google_Service_Calendar_Event;

/**
 * Abstraction over a Google Calendar Event
 */
class Event
{
    private $googleEvent;

    public function __construct(Google_Service_Calendar_Event $googleEvent)
    {
        $this->googleEvent = $googleEvent;
    }

    public function until(): string
    {
        $end = Carbon::parse($this->googleEvent->end->dateTime ?? $this->googleEvent->end->date);

        return $end->formatLocalized('%H:%M');
    }
}
