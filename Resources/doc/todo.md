[<- Back to README](README.md)

TODO List for the CalendarBundle
================================
--------------------------------

### High Priority
* Move the calendar bundle out of the Hospital Bundle and make it stand alone
* Add functions to the service interface that will be called when a day is clicked or an event is dragged to a new spot

### Mid Priority
* Allow a special type of event to rendered that changes the background color of a selection of days3558168orange15!


### Low Priority
* More Styles!
* Code cleanup

### Completed Tasks
* ~~Remove the styling attributes from the html tags and start a css sheet to put all style content in that (as a result the naming conventions from the mid priorities is now high priority) --- this will help with making the process to make the calendar more adaptive easier~~ **COMPLETE** Styling is now in a Calendar.css file
* ~~Fix the layout and theming to prevent degradation to an unusable state when the calendar is display on smaller screens~~ **COMPLETE** Calendar is now responsive and has 6 different sizes that it will change to dynamically
* ~~Fix the day display screen so that it does not look terrible~~ **COMPLETE** Well, atleast complete in terms of why I put this on the todo list, the lack of hourly times still makes the day view look awkward.
* ~~Make it not look amateurish~~ **COMPLETE** I based the theme off of somebody's responsive calendar and it looks pretty now.
* ~~Add in more features to the calendar event class to auto generate some event styles, so that only a string has to be passed into it to display a decent standard event~~ **COMPLETE** You can now use a createEvent function with a string to get an prethemed event.
* ~~Highlight the current date~~ **COMPLETE** It's highlighted now
