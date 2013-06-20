<?php

namespace MESD\Presentation\CalendarBundle\Services;

use MESD\Presentation\CalendarBundle\Interfaces\CalendarServiceInterface;
use MESD\Presentation\CalendarBundle\Entity\CalendarEvent;
use MESD\Presentation\CalendarBundle\Entity\CalendarEventCollection;

class ExampleCalendarService
{

    private $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function getEvents(\DateTime $startDate, \DateTime $endDate, $params)
    {
        $exampleEvent = new CalendarEvent($startDate, $startDate);
        $exampleEvent->createEvent($this->string);
        $exampleEvent->setIsAllDay(true);

        $exampleEvent2 = new CalendarEvent(new \DateTime(), new \DateTime());
        $exampleEvent2->createEvent('This is today!', 
            'rgb(167, 15, 90)', 'rgb(219, 177, 119)');

        $tomorrow = new \DateTime();
        $tomorrow->modify('+1 day');
        $rawEvent = new CalendarEvent($tomorrow, $tomorrow);
        $rawEvent->setEvent('<button>This is a raw event</button>');

        $yesterday = new \DateTime();
        $yesterday->modify('-1 day');
        $rawEvent2 = new CalendarEvent($yesterday, $yesterday);
        $rawEvent2->setEvent("<a href='http://www.google.com'>This is a raw event</a>");

        //This is here to make the samples work with single day view
        if ($startDate->diff($endDate)->days < 1) {
            $begin = new \DateTime();
            $begin->setTimestamp(0);
            $exampleMultiDay = new CalendarEvent($begin, $endDate);
            if ($endDate->diff(new \DateTime)->days < 1) {
                $exampleMultiDay2 = new CalendarEvent(new \DateTime(), $tomorrow);
            }
            else {
                $exampleMultiDay2 = new CalendarEvent(new \DateTime(), $endDate);
            }
        }
        else {
            $exampleMultiDay = new CalendarEvent($startDate, $endDate);
            $exampleMultiDay2 = new CalendarEvent(new \DateTime(), $endDate);
        }
        $exampleMultiDay->createEvent('Multiday Event!');
        $exampleMultiDay2->createEvent('Note: if using raw multiday events, 
            some theming may not stretch the whole width', 'rgb(199,159,16)', 
            'rgb(255, 255, 255)');

        $events = new CalendarEventCollection();
        $events->addEvent($exampleEvent);
        $events->addEvent($exampleEvent2);
        $events->addEvent($rawEvent);
        $events->addEvent($rawEvent2);
        $events->addEvent($exampleMultiDay);
        $events->addEvent($exampleMultiDay2);
        return $events;
    }


}