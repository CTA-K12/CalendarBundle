<?php

namespace Mesd\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CalendarController extends Controller
{
    /*
     *  Display Calendar Action
     *  This action takes in the name for the service from where the
     *  calendar will draw its events from, and the parameters that will
     *  be passed to that service.  It doesn't do anything directly with
     *  those parameters, but this function is used to serve as a gateway
     *  to pass those parameters to the other display functions.  It also
     *  sets the scope (day, week, month, etc) (default is month) and the
     *  starting timestamp (the current time).
     */
    public function displayCalendarAction($calendarService, $params = 'null', $scope = 'Month', $timestamp = null)
    {
        if ($timestamp == null) {
            $originTime = new \DateTime();
        }
        else {
            $originTime = new \DateTime();
            $originTime->setTimestamp($timestamp);
        }

        return $this->render('MesdCalendarBundle:Calendar:calendar.html.twig',
            array(
                'time' => $originTime,
                'scope' => $scope,
                'calendar_service' => $calendarService,
                'params' => $params,
        ));
    }

    /*
     *  Display Day
     *  This takes in a php date object and displays that date through
     *  the day.html.twig file.  THIS IS A WIP, I plan to add a way to attach
     *  event and format data to this soon.
     */
    public function displayDayAction($calendarService, $params, $timestamp)
    {
        //Generate the start and end dates from the timestamp, startdate is just
        //the timestamp date with the hours/minutes/seconds dropped, and end date
        //is the start date plus one day
        $startDate = new \DateTime();
        $startDate->setTimestamp($timestamp);
        $startDate->setTime(0, 0, 0);
        $endDate = new \DateTime();
        $endDate->setTimestamp($startDate->getTimestamp());
        $endDate->setTime(23, 59, 59);

        //Get the events from the given calendar service
        $service = $this->get($calendarService);
        $events = $service->getEvents($startDate, $endDate, $params);

        return $this->render('MesdCalendarBundle:Calendar:day.html.twig',
            array(
                'day' => $startDate,
                'events' => $events->getEvents(),
        ));
    }

    public function displayWeekAction($calendarService, $params, $timestamp)
    {
        $startDate = new \DateTime();
        $startDate->setTimestamp(strtotime('this week -1 day', $timestamp));
        $startDate->setTime(0, 0, 0);
        $endDate = new \DateTime();
        $endDate->setTimestamp(strtotime('next week -2 day', $timestamp));
        $endDate->setTime(23, 59, 59);

        $service = $this->get($calendarService);
        $events = $service->getEvents($startDate, $endDate, $params);

        return $this->render('MesdCalendarBundle:Calendar:week.html.twig',
            array(
                'start' => $startDate,
                'end' => $endDate,
                'today' => new \DateTime(),
                'events' => $events->getEvents(),
        ));
    }

    public function displayMonthAction($calendarService, $params, $timestamp)
    {
        $monthStart = new \DateTime();
        $monthStart->setTimestamp(strtotime('first day of this month', $timestamp));
        $monthStart->setTime(0, 0, 0);
        $monthEnd = new \DateTime();
        $monthEnd->setTimestamp(strtotime('last day of this month', $timestamp));
        $monthEnd->setTime(23, 59, 59);
        $startDate = new \DateTime();
        $startDate->setTimestamp(strtotime('last Sunday', $monthStart->getTimestamp()));
        $startDate->setTime(0, 0, 0);
        $endDate = new \DateTime();
        $endDate->setTimestamp(strtotime('next Saturday', $monthEnd->getTimestamp()));
        $endDate->setTime(23, 59, 59);


        $service = $this->get($calendarService);
        $events = $service->getEvents($monthStart, $monthEnd, $params);

        return $this->render('MesdCalendarBundle:Calendar:month.html.twig',
            array(
                'month_start' => $monthStart,
                'month_end' => $monthEnd,
                'start' => $startDate,
                'end' => $endDate,
                'today' => new \DateTime(),
                'events' => $events->getEvents(),
                'current' => $timestamp,
        ));
    }
}