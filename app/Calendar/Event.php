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
        if (!empty($this->googleEvent->end->dateTime)) {
            // If an end time is set, use that
            $end = Carbon::parse($this->googleEvent->end->dateTime);
        } else {
            // Otherwise use COB
            $end = Carbon::parse($this->googleEvent->end->date);
            $end->setTime(config('time.cob'));
        }

        return $end->formatLocalized('%H:%M');
    }

    public function summary(): ?string
    {
        return $this->googleEvent->summary;
    }
}
