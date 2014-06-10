<?php

namespace Mesd\CalendarBundle\Entity;

class CalendarEvent
{
    private $startDate;
    private $endDate;
    private $event;
    private $isAllDay;
    private $isMultiDay;
    private $objRef;
    private $groupId;

    public function __construct(\DateTime $startDate, \DateTime $endDate, $objRef = null, $groupId = 0)
    {
        $this->startDate = clone $startDate;
        $this->endDate = clone $endDate;
        $this->isAllDay = false;
        $this->calcIsMultiDay();
        $this->objRef = $objRef;
        $this->groupId = $groupId;
    }

    public function createEvent($eventString, $url = '#', $bgColor = null, $txtColor = null, $borderColor = null, $class = ' ') {
        if ($bgColor == null || $txtColor == null) {
            $this->event = "<a href='" . $url . "' class='calendar-message-box-defaultcolor " . $class . "'
            style='display: block;'>"
                . $eventString . "</a>";
        }
        else {
            if ($borderColor == null) {
                $this->event = "<a href='" . $url . "' class='calendar-message-box " . $class . "'
                style='background-color: " . $bgColor .
                "; color: " . $txtColor . "; display: block;'>" . $eventString .
                "</a>";
            }
            else {
                $this->event = "<a href='" . $url . "' class='calendar-message-box " . $class . "'
                style='background-color: " . $bgColor .
                "; color: " . $txtColor . "; display: block; border-style:solid; border-color: " . $borderColor
                . ";'>" . $eventString . "</a>";
            }
        }
    }

    public function createClickableDay($url) {
        if (!$this->isMultiDay) {
            $this->event = "<a href='" . $url . "' style='position: absolute;
            width: 100%; height: 100%; top: 0; left: 0; text-decoration: none;
            z-index: 10; background-color: white; opacity: 0; filter: alpha(opacity=1)
            ></a>";
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

    public function getGroupId() {
        return $this->groupId;
    }

    public function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    //This will override the multiday calculation in createEvent,
    //**BUT** if the dates change **THIS VALUE WILL BE OVERWRITTEN**
    public function setIsMultiDay($isMultiDay)
    {
        $this->isMultiDay = $isMultiDay;
    }

    public function setObjRef($objRef) {
        $this->objRef = $objRef;
    }

    public function getObjRef() {
        return $this->objRef;
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