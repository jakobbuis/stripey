<?php

namespace App\Locator;

use App\Calendar\Calendar;
use App\Person;

class Locator
{
    private $person;

    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    public function status(): Status
    {
        $calendar = new Calendar($this->person->email);

        $event = $calendar->currentEvent();
        if ($event) {
            return Status::inMeeting(
                $event->until(),
                $event->location(),
                $event->summary()
            );
        }

        return Status::atOffice();
    }
}
