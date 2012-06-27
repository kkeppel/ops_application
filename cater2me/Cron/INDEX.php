<?

// dispatches c2me cron jobs



require '../lib/core.php';

if($_GET['auth']!='ok') notif('Sorry, you are not supposed to be here.');



$now=time();

$date_params=array('G','i','N','j','n');

foreach($config['scheduled_jobs'] as $job) {
	$criteria_ok=0;
	foreach($date_params as $key=>$val) {
		if($job[$key]=='*' || $job[$key]==date($date_params[$key],$now)) $criteria_ok++;
	}
	
	
	if($criteria_ok == count($date_params)) file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/Cron/'.$job[5]);
}

