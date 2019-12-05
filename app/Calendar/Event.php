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

    public function location(): ?string
    {
        $location = $this->googleEvent->location;
        if (!$location) {
            return null;
        }

        // Every meeting room starts with "IN10 | ", which we remove if applicable
        $matches = [];
        preg_match('/^IN10 \| (.*)$/', $location, $matches);
        $room = $matches[1] ?? null;

        return $room !== 'Evoko' ? $room : null;
    }
}
