<?php

namespace App\Calendar;

use App\Person;
use App\Time;
use Carbon\CarbonImmutable;
use Google_Service_Calendar;

/**
 * Abstraction over a Google Calendar
 */
class Calendar
{
    private $now;
    private $events;

    public function __construct(string $calendarIdentifier)
    {
        // Allow time-shifting for easier testing
        $this->now = app(Time::class)->now();
        $this->loadEvents($calendarIdentifier);
    }

    /**
     * Load all relevant events for today
     */
    private function loadEvents(string $calendarIdentifier): void
    {
        // Load the events for today in this class
        $calendar = app(Google_Service_Calendar::class);
        $query = [
            'timeMin' => $this->now->startOfDay()->toRfc3339String(),
            'timeMax' => $this->now->endOfDay()->toRfc3339String(),
            'singleEvents' => true, // Expand recurring events into separate instances
        ];
        $events = collect($calendar->events->listEvents($calendarIdentifier, $query)->items);

        // Filter out events created by Timewax
        $events = $events->filter(function ($event) {
            $noDescription = empty($event->description);
            $timewaxEvent = strpos($event->description, 'Timewax boeking') !== false;
            return $noDescription || !$timewaxEvent;
        })->values();

        $this->events = $events;
    }

    public function currentEvent(): ?Event
    {
        $currentEvent = $this->events->first(function ($event) {
            $start = CarbonImmutable::parse($event->start->dateTime);
            $end = CarbonImmutable::parse($event->end->dateTime);

            return $this->now >= $start && $this->now <= $end;
        });

        return $currentEvent ? new Event($currentEvent) : null;
    }
}
