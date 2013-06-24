<?php

namespace MESD\Presentation\CalendarBundle\Entity;

class CalendarEvent 
{
    private $startDate;
    private $endDate;
    private $event;
    private $isAllDay;
    private $isMultiDay;

    public function __construct(\DateTime $startDate, \DateTime $endDate)
    {
        $this->startDate = clone $startDate;
        $this->endDate = clone $endDate;
        $this->isAllDay = false;
        $this->calcIsMultiDay();
    }

    public function createEvent($eventString, $bgColor = null, $txtColor = null, $url = '#') {
        if ($bgColor == null || $txtColor == null) {
            $this->event = "<a href='" . $url . "' class='calendar-message-box-defaultcolor' 
            style='display: block;'>" 
                . $eventString . "</a>";
        }
        else {
            $this->event = "<a href='" . $url . "' class='calendar-message-box' 
            style='background-color: " . $bgColor .
            "; color: " . $txtColor . "; display: block;'>" . $eventString .
            "</a>";
        }
    }

    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;
        $this->calcIsMultiDay();
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setEndDate(\DateTime $endDate)
    {
        $this->endDate = $endDate;
        $this->calcIsMultiDay();
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEvent($event)
    {
        $this->event = $event;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function setIsAllDay($isAllDay)
    {
        $this->isAllDay = $isAllDay;
    }

    public function getIsAllDay()
    {
        return $this->isAllDay;
    }

    public function getIsMultiDay()
    {
        return $this->isMultiDay;
    }

    protected function calcIsMultiDay()
    {
        $difference = $this->startDate->diff($this->endDate);
        if ($difference->d != 0 || $difference->m != 0 || $difference->y != 0)
        {
            $this->isMultiDay = true;
        }
        else 
        {
            $this->isMultiDay = false;
        }
    }
}