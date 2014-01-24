<?php

namespace MESD\Presentation\CalendarBundle\Entity;

use MESD\Presentation\CalendarBundle\Entity\CalendarEvent;

class CalendarEventCollection
{
    private $events;

    public function __construct($extraDayOptions = false)
    {
        $this->events = new \ArrayObject();
    }

    public function getEvents()
    {
        $this->events->uasort(
            function($a, $b)
            {
                if ($a->getStartDate() == $b->getStartDate()) 
                    {
                        if ($a->getGroupId() == $b->getGroupId()) {
                            return 0;
                        }
                        return ($a->getGroupId() < $b->getGroupId()) ? -1 : 1;
                    } 
                return ($a->getStartDate() < $b->getStartDate()) ? -1 : 1;});
        return $this->events->getArrayCopy();
    }

    public function addEvent(CalendarEvent $event) 
    {
        $this->events->append($event);
    }
}