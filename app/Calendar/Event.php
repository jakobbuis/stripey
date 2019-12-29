<?php

namespace App\Calendar;

use Carbon\CarbonImmutable;
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

    public function isAllDay(): bool
    {
        return $this->googleEvent->start->dateTime === null
                && $this->googleEvent->end->dateTime === null;
    }

    public function until(): ?CarbonImmutable
    {
        if ($this->isAllDay()) {
            return CarbonImmutable::parse($this->googleEvent->end);
        }

        return CarbonImmutable::parse($this->googleEvent->end->dateTime);
    }

    public function summary(): ?string
    {
        return $this->googleEvent->summary;
    }

    public function location(): ?string
    {
        $location = $this->googleEvent->location;

        // If one or more rooms are attending, the meeting is there
        $rooms = config('calendars.rooms');
        $roomsTaken = array_filter($this->googleEvent->attendees, function ($attendee) use ($rooms) {
            return isset($rooms[$attendee->email]);
        });
        if (count($roomsTaken) > 0) {
            $roomNames = array_map(function ($room) use ($rooms) {
                return $rooms[$room->email];
            }, $roomsTaken);
            sort($roomNames);
            return implode(', ', $roomNames);
        }

        // Otherwise, check the location string
        $location = $this->googleEvent->location;
        if (!$location) {
            return null; // unknown
        }

        // "Evoko" is a bluetooth-speaker listed as a room, ignore it
        if (strpos($location, 'IN10 | Evoko') !== false) {
            return null;
        }

        return $location;
    }

    public function isWorkingFromHome(): bool
    {
        return strpos(strtolower($this->summary()), 'thuiswerken') !== false;
    }
}
