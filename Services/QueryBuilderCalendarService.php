<?php

namespace MESD\Presentation\CalendarBundle\Services;

use MESD\Presentation\CalendarBundle\Interfaces\CalendarServiceInterface;
use MESD\Presentation\CalendarBundle\Entity\CalendarEvent;
use MESD\Presentation\CalendarBundle\Entity\CalendarEventCollection;

class QueryBuilderCalendarService
{
    private $em;
    private $getDateMethod;
    private $getEndDateMethod;
    private $toStringMethod;
    private $getUrlMethod;
    private $colorsArray;
    private $colorIndex;
    private $isMultiDay;

    public function __construct($em, $getDateMethod = null, $getEndDateMethod = null, $toStringMethod = null, 
        $getUrlMethod = null, $colorsArray = null)
    {
        $this->em = $em;
        $this->getDateMethod = $getDateMethod;
        $this->getEndDateMethod = $getEndDateMethod;
        $this->toStringMethod = $toStringMethod;
        $this->colorsArray = $colorsArray;
        $this->colorIndex = 0;
        $this->isMultiDay = false;

        //If a date method was given, check if there is an end date also and set multiday to be true
        if ($this->getDateMethod != null) {
            if ($this->getEndDateMethod == null) {
                $this->getEndDateMethod = $this->getDateMethod;
            }
            else {
                $this->isMultiDay = true;
            }
        }

        //Check if there is a colors array and then check its validity
        if ($this->colorsArray != null) {
            foreach($colorsArray as $tuple) {
                if (!is_array($tuple)) {
                    echo 'not array';
                    $this->colorsArray = null;
                    break;
                }
                elseif (count($tuple) != 2) {
                    var_dump(count($tuple));
                    echo 'not pair';
                    $this->colorsArray = null;
                    break;
                }
            }
        }
    }

    public function getEvents(\DateTime $startDate, \DateTime $endDate, $params)
    {
        //First build the QueryBuilder from the params variable and check its validity 
        //AND CHECK THAT IT IS A SELECT STATEMENT!!!
        $query = $this->em->createQuery($params);
        if ($query->contains('update') || $query->contains('delete') || $query->contains('insert')) {
            return new CalendarEventCollection();
        }

        if ($query == null) {
            return new CalendarEventCollection();
        }

        //Next get the result from the query and check if objects came back
        $objects = $query->getResult();

        if (count($objects) < 1) {
            return new CalendarEventCollection();
        }

        if ($this->getDateMethod == null) {
            //Next get the methods associated with the given class and check if dates and toString are available
            $methods = get_class_methods(get_class($objects[0]));

            //Now look through the methods for getDate methods
            $isMultiDay = false;
            foreach ($methods as $method) {
                if (preg_match('/^get.*?StartDate$/', $method)) {
                    $this->getDateMethod = $method;
                    $this->isMultiDay = true;
                }
                elseif (preg_match('/^get.*?EndDate$/', $method) == 1) {
                    $this->getEndDateMethod = $method;
                    $this->isMultiDay = true;
                }
                elseif (preg_match('/^get.*?Date$/', $method) == 1) {
                    $this->getDateMethod = $method;
                }
                elseif (preg_match('/.*?toString$/', $method) == 1) {
                    if ($this->toStringMethod == null) {
                        $this->toStringMethod = $method;
                    }
                }
            }

            if ($this->toStringMethod == null) {
                return new CalendarEventCollection();
            }

            if ($this->isMultiDay) {
                if ($this->getDateMethod == null || $this->getEndDateMethod == null) {
                    return new CalendarEventCollection();
                }
            }
            else {
                if ($this->getDateMethod == null) {
                    return new CalendarEventCollection();
                }
                $this->getEndDateMethod = $this->getDateMethod;
            }
        }
        //Check validity of everything
        if (!method_exists($objects[0], $this->getDateMethod)) {
            return new CalendarEventCollection();
        }
        if (!method_exists($objects[0], $this->getEndDateMethod)) {
            return new CalendarEventCollection();
        }
        if (!method_exists($objects[0], $this->toStringMethod)) {
            return new CalendarEventCollection();
        }
        if ($this->getUrlMethod != null) {
            if (!method_exists($objects[0], $this->toStringMethod)){
                return new CalendarEventCollection();
            }
        }

        $events = new CalendarEventCollection();

        foreach($objects as $obj) {
            $event = new CalendarEvent(call_user_func(
                array($obj, $this->getDateMethod)), call_user_func(array($obj, $this->getEndDateMethod)));
            if ($this->getUrlMethod != null) {
                $url = call_user_func(array($obj, $this->getUrlMethod));
            }
            else {
                $url = '';
            }

            if ($this->colorsArray == null) {
                $event->createEvent(call_user_func(array($obj, $this->toStringMethod)), $url);
            }
            else {
                $event->createEvent(call_user_func(array($obj, $this->toStringMethod)), $url, 
                    $this->colorsArray[$this->colorIndex][0], $this->colorsArray[$this->colorIndex][1]);
                $this->colorIndex = ($this->colorIndex + 1) % count($this->colorsArray);
            }
            
            $events->addEvent($event);
        }
        
        return $events;
    }
}