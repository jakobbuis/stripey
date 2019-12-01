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
    public static function forPerson(Person $person): self
    {
        return new self($person->email);
    }

    private $now;
    private $events;

    public function __construct(string $calendarIdentifier)
    {
        // Allow time-shifting for easier testing
        $this->now = $this->determineNow();

        // Load the events for today in this class
        $calendar = app(Google_Service_Calendar::class);
        $query = [
            'timeMin' => $this->now->startOfDay()->toRfc3339String(),
            'timeMax' => $this->now->endOfDay()->toRfc3339String(),
            'singleEvents' => true, // Expand recurring events into separate instances
        ];
        $this->events = collect($calendar->events->listEvents($calendarIdentifier, $query)->items);
    }

    private function determineNow(): CarbonImmutable
    {
        $override = config('calendars.carbon_override');
        return $override ? CarbonImmutable::parse($override) : CarbonImmutable::now();
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
