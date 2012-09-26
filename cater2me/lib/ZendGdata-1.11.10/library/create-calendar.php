<?
      // load classes
      require_once 'Zend/Loader.php';
      Zend_Loader::loadClass('Zend_Gdata');
      Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
      Zend_Loader::loadClass('Zend_Gdata_Calendar');
      Zend_Loader::loadClass('Zend_Http_Client');
      
      // connect to service
      $gcal = Zend_Gdata_Calendar::AUTH_SERVICE_NAME;
      $user = "vedlen@penpal-gate.com";
      $pass = "muta92tion";
      $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $gcal);
      $gcal = new Zend_Gdata_Calendar($client);


 
$calendarName = 'My Calendar ZF Example';
$useCalendarFeed = FALSE;
 
try {
// Let's get the calendar list from Google calendar API
$listFeed= $gcal->getCalendarListFeed();
} catch (Zend_Gdata_App_Exception $e) {
echo "Error: " . $e->getMessage();
}
 
/**
* Need to run through all the array to search for our calendar name
* Calendar Listing Feed is available on $listFeed variable
*/
 
foreach ($listFeed as $calendar) {
if($calendar->title == $calendarName)
$useCalendarFeed = $calendar->content->src;
}
 
/**
* If we have not found the calendar we want to use,
* we need to create a new one
*/
if(FALSE === $useCalendarFeed)
{
$appCal = $gcal->newListEntry();
$appCal->title = $gcal->newTitle($calendarName);
$own_cal = "http://www.google.com/calendar/feeds/default/owncalendars/full";
$gcal->insertEvent($appCal, $own_cal);
 
/**
* Need to grab the Google Calendar feed again, with the newly inserted calendar
* We'll need the refreshed feed in order to get the newly added calendar ID in order
* to add the event into the created calendar
*/
try {
$listFeed= $gcal->getCalendarListFeed();
} catch (Zend_Gdata_App_Exception $e) {
echo "Error: " . $e->getMessage();
}
 
}
