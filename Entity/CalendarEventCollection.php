<?php

namespace MESD\Presentation\CalendarBundle\Entity;

use MESD\Presentation\CalendarBundle\Entity\CalendarEvent;
use MESD\Presentation\CalendarBundle\Entity\CalendarDayOption;

class CalendarEventCollection
{
    private $events;
    private $dayOptions;

    public function __construct($extraDayOptions = false)
    {
        $this->events = new \ArrayObject();
        $this->dayOptions = new \ArrayObject();
    }

    public function getEvents()
    {
        $this->events->uasort(
            function($a, $b)
            {
                if ($a->getStartDate() == $b->getStartDate()) 
                    {
                        return 0;
                    } 
                return ($a->getStartDate() < $b->getStartDate()) ? -1 : 1;});
        return $this->events->getArrayCopy();
    }

    public function getDayOptions() {
        return $this->dayOptions->getArrayCopy();
    }

    public function addEvent(CalendarEvent $event) 
    {
        $this->events->append($event);
    }

    public function addDayOption(CalendarDayOption $cdo) {
        $this->dayOptions->append($cdo);
    }
}