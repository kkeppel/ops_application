<?
/******* Google Calendar (start) *******/

/*
list resources:
http://code.google.com/apis/calendar/data/2.0/developers_guide_protocol.html#RetrievingEvents
http://www.ibm.com/developerworks/library/x-googleclndr/      #useful
http://framework.zend.com/manual/en/zend.gdata.calendar.html     #useful
http://code.google.com/apis/gdata/docs/2.0/reference.html#Queries
http://code.google.com/apis/calendar/data/1.0/developers_guide_php.html#RetrievingWithQuery
*/


//CAL ID EXAMPLE     http://www.google.com/calendar/feeds/default/cater2.me_9sft1ecr9me24tfa7tvpkmnmf0%40group.calendar.google.com
//EVENT ID EXAMPLE   http://www.google.com/calendar/feeds/cater2.me_9sft1ecr9me24tfa7tvpkmnmf0%40group.calendar.google.com/private/full/8r3m69dfk0lkffidiho0rn8p6k


class gCal {

	var $gcal;
	
	function __construct() {

		global $config;
	
		// load classes
		set_include_path(__DIR__.'/ZendGdata-1.11.10/library'.PATH_SEPARATOR.get_include_path());
		require_once 'Zend/Loader.php';
		Zend_Loader::loadClass('Zend_Gdata');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		Zend_Loader::loadClass('Zend_Gdata_Calendar');
		Zend_Loader::loadClass('Zend_Http_Client');
		
		// connect to service
		$this->gcal = Zend_Gdata_Calendar::AUTH_SERVICE_NAME;
		$client = Zend_Gdata_ClientLogin::getHttpClient($config['gcal']['login'], $config['gcal']['pwd'], $this->gcal);
		$this->gcal = new Zend_Gdata_Calendar($client);
	}
	
	function createEvent($when, $title, $desc, $toCalendar=null) {

		$start = date('Y-m-d\TH:i:sP', $when);
		$end = date('Y-m-d\TH:i:sP', $when);
	
		if($toCalendar)
			$toCalendar=$toCalendar->getLink('alternate')->getHref();
	
		// Get calendar from its name
		/*
		    try {
			$listFeed = $gcal->getCalendarListFeed();
		    } catch (Zend_Gdata_App_Exception $e) {
			echo "Error: " . $e->getResponse();
			}
		
			foreach ($listFeed as $calendar) {
			    if($calendar->title == 'My Calendar ZF Example')
				   $toCalendar=$calendar->getLink('alternate')->getHref();
			}
		*/
	
		// construct event object
		// save to server      
		try {
		  $event = $this->gcal->newEventEntry();   
		  $event->title = $this->gcal->newTitle($title);      
		     $event->content = $this->gcal->newContent($desc);  
		  $when = $this->gcal->newWhen();
		  $when->startTime = $start;
		  $when->endTime = $end;
		  $event->when = array($when);        
		  $newEvent = $this->gcal->insertEvent($event, $toCalendar);
		  
		  return $this->getUniqueEventId($newEvent->id->text);
		  
		  
		} catch (Zend_Gdata_App_Exception $e) {
		  return "Error: " . $e->getResponse();
		}
		
	}
	
	function deleteEvent($calID, $eventID) {
	
		try {          
		    $event = $this->gcal->getCalendarEventEntry('http://www.google.com/calendar/feeds/cater2.me_'.$calID.'%40group.calendar.google.com/private/full/'.$eventID);
		    $event->delete();
		    return true;
		} catch (Zend_Gdata_App_Exception $e) {
		    return 'Error: '.$e->getResponse();
		}
	}
	
	function getCalendarByName($calendarName) {
		 
		try {
		// Let's get the calendar list from Google calendar API
		$listFeed= $this->gcal->getCalendarListFeed();
		} catch (Zend_Gdata_App_Exception $e) {
		return "Error: " . $e->getMessage();
		}
		 
		/**
		* Need to run through all the array to search for our calendar name
		* Calendar Listing Feed is available on $listFeed variable
		*/
		 
		foreach ($listFeed as $calendar) {
		if($calendar->title == $calendarName)
		return $calendar;
		}
	
		return false;
	}
	
	// NOT EFFICIENT : REMAKE FOLLOWING FUNCTION QUERYING DIRECT CAL ID INSTEAD OF LOOPING
	function getCalendarById($calendarId) {
		 
		try {
		// Let's get the calendar list from Google calendar API
		$listFeed= $this->gcal->getCalendarListFeed();
		} catch (Zend_Gdata_App_Exception $e) {
		return "Error: " . $e->getMessage();
		}
		 
		/**
		* Need to run through all the array to search for our calendar name
		* Calendar Listing Feed is available on $listFeed variable
		*/
		 
		foreach ($listFeed as $calendar) {
		if($calendar->id == 'http://www.google.com/calendar/feeds/default/cater2.me_'.$calendarId.'%40group.calendar.google.com')
		return $calendar;
		}
	
		return false;
	}
	
	function getCalendarByCompanyId($companyId) {
	
		global $config;
		 
		$res=mysql_query('SELECT gcal_id FROM calendars WHERE company_id = '.(int)$companyId);
		if(!mysql_num_rows($res)) return false;
		
		$cals=array();
		while($log=mysql_fetch_row($res)) { //normally 1, special case; several calendars
			$cals[]=$this->getCalendarById($log[0]);
		}
		return $cals;
	}
	
	function createCalendar($company_id) {
	
		global $config;
	
			//get company info
			$res = mysql_query('SELECT id_company, name FROM companies WHERE id_company = '.(int)$company_id);
			$log = mysql_fetch_assoc($res);
			
			
			$calendarName = str_replace('{vendor_name}',$log['name'],$config['gcal']['cal_name']); //get title formatting
		

		//we assume the calendar doesn't exist; should have been checked beforehand	
		$appCal = $this->gcal->newListEntry();
		$appCal->title = $this->gcal->newTitle($calendarName);
		$own_cal = 'http://www.google.com/calendar/feeds/default/owncalendars/full';
		$this->gcal->insertEvent($appCal, $own_cal);
	
		//get ID of newly created calendar
		$cal = $this->getCalendarByName($calendarName);
		$uniqueID = $this->getUniqueCalendarId($cal->id);
	
		//updating c2me database
		mysql_query('INSERT INTO calendars SET gcal_id = "'.mysql_real_escape_string($uniqueID).'", company_id = '.(int)$company_id) or die(mysql_error());
	}
	
	function getUniqueCalendarId($fullCalID) {
		// example: http://www.google.com/calendar/feeds/default/cater2.me_26s06d0b2chjj1a47qj98fcics%40group.calendar.google.com => 26s06d0b2chjj1a47qj98fcics
	
		//preg_match('/penpal\-gate\.com_(.*)%40/', $fullCalID, $matches);
		preg_match('/cater2\.me_(.*)%40/', $fullCalID, $matches);
		return $matches[1];
	}
	
	function getUniqueEventId($fullEventID) {
		// example: http://www.google.com/calendar/feeds/cater2.me_9sft1ecr9me24tfa7tvpkmnmf0%40group.calendar.google.com/private/full/8r3m69dfk0lkffidiho0rn8p6k => 8r3m69dfk0lkffidiho0rn8p6k
	
		preg_match('/full\/(.*)/', $fullEventID, $matches);
		return $matches[1];
	}
}

/******* Google Calendar (end) *******/

