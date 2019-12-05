<?php

namespace App\Calendar;

use App\Person;
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
        $this->now = $this->determineNow();
        $this->loadEvents($calendarIdentifier);
    }

    /**
     * Allow time-shifting for easier testing
     */
    private function determineNow(): CarbonImmutable
    {
        $override = config('time.carbon_override');
        return $override ? CarbonImmutable::parse($override) : CarbonImmutable::now();
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
            if (empty($event->description)) {
                return true;
            }
            return strpos($event->description, 'Timewax boeking') === 0;
        });

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
