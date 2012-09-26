<?

require 'lib/core.php';
header('Content-Type: application/force-download');

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser)!='staff') notif('Sorry, you are not supposed to be here.');


echo '"email"'."\n";

	$res = mysql_query('SELECT email FROM referrals ORDER BY id_referral');
	while($log = mysql_fetch_assoc($res))
	{
		echo '"'.$log['email'].'"'."\n";
	}

