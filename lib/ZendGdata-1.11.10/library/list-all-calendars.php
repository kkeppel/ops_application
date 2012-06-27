<!DOCTYPE html 
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Listing calendar contents</title>
    <style>
    body {
      font-family: Verdana;      
    }
    li {
      border-bottom: solid black 1px;      
      margin: 10px; 
      padding: 2px; 
      width: auto;
      padding-bottom: 20px;
    }
    h2 {
      color: red; 
      text-decoration: none;  
    }
    span.attr {
      font-weight: bolder;  
    }
    </style>    
  </head>
  <body>
    <?php
    // load library
    require_once 'Zend/Loader.php';
    Zend_Loader::loadClass('Zend_Gdata');
    Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
    Zend_Loader::loadClass('Zend_Gdata_Calendar');
    Zend_Loader::loadClass('Zend_Http_Client');
    
    // create authenticated HTTP client for Calendar service
    $gcal = Zend_Gdata_Calendar::AUTH_SERVICE_NAME;
    $user = "vedlen@penpal-gate.com";
    $pass = "muta92tion";
    $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $gcal);
    $gcal = new Zend_Gdata_Calendar($client);
    
    // generate query to get event list
    /*$query = $gcal->newEventQuery();
    $query->setUser('default');
    $query->setVisibility('private');
    $query->setProjection('basic');*/
    
    // get and parse calendar feed
    // print output
    try {
      $listFeed = $gcal->getCalendarListFeed($query);
    } catch (Zend_Gdata_App_Exception $e) {
      echo "Error: " . $e->getResponse();
    }

	echo "<h1>Calendar List Feed</h1>";
	echo "<ul>";
	foreach ($listFeed as $calendar) {
	    echo "<li>" . $calendar->title .
		   " (Event Feed: " . $calendar->id . ")</li>";
	}
	echo "</ul>";
    ?>
    </ol>

  </body>
</html>

<!--
createCalendar() -- used?
deleteCalendar() -- never?
createEvent() -- used
deleteEvent() 
-->
