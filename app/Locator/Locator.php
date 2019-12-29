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
        $calendar = new Calendar($this->person->id, $this->person->email);

        if ($calendar->isOutSick()) {
            return Status::outSick();
        }

        if ($calendar->hasDayOff()) {
            return Status::dayOff();
        }

        if ($calendar->onVacation()) {
            return Status::onVacation();
        }

        $event = $calendar->currentEvent();
        if ($event) {
            if ($event->isWorkingFromHome()) {
                return Status::workingFromHome($event->until());
            } else {
                return Status::inMeeting($event->until(), $event->location(), $event->summary());
            }
        }

        return Status::atOffice();
    }
}
