<?php

namespace App\Locator;

use App\Calendar\Calendar;
use App\Person;
use Carbon\CarbonImmutable;

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
            return Status::fromEvent($event);
        }

        return Status::atOffice();
    }
}
