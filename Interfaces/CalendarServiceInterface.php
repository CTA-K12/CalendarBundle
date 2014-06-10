<?php

namespace Mesd\CalendarBundle\Interfaces;

interface CalendarServiceInterface
{
    /*
     * This event should be called by the calendar controller (any class implementing
     * this interface should be a service) and return a collection of events (strings attached
     * to dates)
     * @return CalendarEventCollection
     */
    public function getEvents(\DateTime $startDate, \DateTime $endDate, $params);
}