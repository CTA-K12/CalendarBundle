[<- Back to Contents](table_of_contents.md)

Getting Started using the MESD Calendar Bundle
==============================================

**This is a work in progress**

NOTE
----

Since the Calendar Bundle is currently a work in progress, and is still attached to the dev branch of the hospital bundle, this documentation is still early, and is only a rough draft, and as a result may not be useful to you, as things in the calendar bundle have yet to fully take shape, and the features, functions, and look of the calendar bundle can change drastically at any time. 

Also note, though the goal is to make the calendar independent from various frameworks like bootstrap, this current version still makes use of bootstrap's button groups for the scope (day/week/month) and time buttons.


Installing the Calendar Bundle
------------------------------

The calendar bundle is still attached the hospital bundle, so this section will be worthless until it is seperated and fully usable.  For now, the calendar bundle can be installed by including the link to the hospital bundle's repository (*NOTE: the calendar bundle is only in the dev branch of the hospital bundle*)

Add the calendar bundle's routing to your main routing file in the config folder.


Display the Example Calendar
----------------------------

To display the example calendar to prep yourself with working with the calendar bundle then first add a render tag to the template you wish it to display on:

`<div class='calendar-widget'>
{% render url('calendar_display', {'calendarService': 'calendar_example_service'}) %}
</div>`

Now, add the example calendar service to your services file:

`calendar_example_service:  
    class: MESD\Presentation\CalendarBundle\Services\ExampleCalendarService  
    arguments: ['Hello']`

Now finally add the **MESD/Calendar/CalendarBundle/Resources/public/css/Calendar.css** file to the page who wish the calendar to appear on.

Load the page, and if everything is setup correctly, you should see a calendar in month view of the current month with some various test events placed on it


The Basics
----------

The calendar bundle works by using services to get events between specified dates and returns them to a controller that will render them to a set of twig files (one for month, one for week, and one for day).  To create a calendar, you extend the calendar service interface which includes a function called `getEvents(\DateTime $startDate, \DateTime $endDate, $params)` which takes in a start date which is the first date that will be shown on the calendar, an end date that is the last date to be shown, and a set of parameters in the form of a string (more on this later).  It is then expected that this function returns an object called CalendarEventCollection which contains a series of CalendarEvents which will be displayed on the calendar.  In the getEvents function, you can place any events that you need to be displayed by creating a new CalendarEvent `$event = new CalendarEvent($start, $end);` where the start and end parameters are the start and end dates of the event.  If the start date and end date are on different days, then the CalendarEvent will be set to say that it is a multiday event and will display on the multiple days on the calendar in a special section between the day header and the day body.  After the creation of an event object, you can give it the actualy event data that it will display, either by giving a string to the `createEvent($string)` function which will display your event with preformatted styling.  The createEvent function will also accept colors as input with the second parameter being background color and the third parameter being the color of the string's text, thus to display an event with a black background with white text, call `$myCalendarEvent->createEvent($myString, 'rgb(0, 0, 0)', 'rgb(255, 255, 255)');`.  Events can also be entered in as just a string that will be displayed as raw html on the calendar by `$myCalendarEvent->setEvent("<a href='www.google.com'>Link to Google</a>");`.  This requires a bit more care, but in return provides greater flexibility, and since render(twig) returns a string, you can display twigs as events on the calendar.

To display your calendar, add a render twig tag to the template you want the calendar to display one with paramters that include the name of the service that the calendar will pull events from, and the set of optional paramaters in the form of a string that the service you made can make use of if needed:  

`{% render url('calendar_display',  
{'calendarService': 'NAME_OF_YOUR_SERVICE',  
'params': 'PARAMETER_STRING_FOR_YOUR_SERVICE_IF_NEEDED'})  
%}`

You can also set the default time and scope if needed.

**remember to add your service to your services.yml file!**


Adding Custom Parameters to Your Service
----------------------------------------

The calendar service interface and the calendar controller take into account that you might want to send more information to your service than just a time range.  By filling out the params parameter in the render tag to the calendar display, you can send your service a string of serialized parameters which you can then read in your service and have the service act accordingly.  For example, the hospital bundle makes use of this feature by sending its calendar service an id that is attached to a stay object, so that the service can return events pertaining to that one particular stay.


Theming the Calendar
--------------------

There is currently one css file the calendar can use (and depends on) located in the Resources folder under src in the CalendarBundle titled Calendar.css.  You can copy the file into your own project and make edits and then just change which css sheet you're linking to the page to give the calendar different theming.  Hopefully I can flesh this part of the documentation out a bit more at a later point.