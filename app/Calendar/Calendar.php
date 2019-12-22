<?php

namespace App\Calendar;

use App\Time;
use Google_Service_Calendar;

/**
 * Abstraction over a Google Calendar
 */
class Calendar
{
    private $calendarIdentifier;
    private $now;
    private $events;

    public function __construct(string $calendarIdentifier)
    {
        // Allow time-shifting for easier testing
        $this->now = app(Time::class)->now();

        $this->calendarIdentifier = $calendarIdentifier;
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
        $this->events = new Events($calendar->events->listEvents($calendarIdentifier, $query)->items);
    }

    public function currentEvent(): ?Event
    {
        $event = $this->events
                    ->at($this->now)
                    ->notTimewax()
                    ->attending($this->calendarIdentifier)
                    ->first();

        return $event ? new Event($event) : null;
    }

    public function isOutSick(): bool
    {
        return $this->events
                    ->onAfwezig()
                    ->startsWith('Ziek:')
                    ->count() > 0;
    }

    public function hasDayOff(): bool
    {
        return $this->events
                    ->onAfwezig()
                    ->startsWith('Vrij:')
                    ->count() > 0;
    }

    public function onVacation(): bool
    {
        return $this->events
                    ->onAfwezig()
                    ->startsWith('Vakantie:')
                    ->count() > 0;
    }
}
