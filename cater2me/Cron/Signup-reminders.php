<?

// sends email atfer #### time to remind users who didn't go through the entire signup process

require '../lib/core.php';

//if($_GET['auth']!='ok') notif('Sorry, you are not supposed to be here.');


	die('deactivated');

$now=time();

$emails=mysql_query('SELECT email FROM website_signup_attempts wsa WHERE wsa.when BETWEEN "'.date('Y-m-d H:i:s',$now-($config['signup_reminder']+86400)).'" AND "'.date('Y-m-d H:i:s',$now-$config['signup_reminder']).'"');

if(mysql_num_rows($emails)) {
	while($email=mysql_fetch_row($emails)) {
		sendMail($email[0], 'Don\'t forget to create your Cater2.me account','Hello,

We\'d love to share all the goodness of your catering calendar with you! Please use the following link to sign up for Cater2.me:

http://cater2.me/signup/?email='.urlencode($email[0]).'&hash='.md5($config['secret'].stripslashes($email[0])).'

Thanks!

The Cater2.me team');
	}
}
else echo 'nothing';


