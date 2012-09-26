<?

require_once 'lib/core.php';

session_start();

if(isset($_POST['email']))
{
	if(!$curUser && isset($_SESSION['user_referral'])) //try temporary session from feedback form
	{
		$user=mysql_query('SELECT u.username, u.password FROM users u WHERE id_user = '.$_SESSION['user_referral']);
		$user=mysql_fetch_row($user);
		authenticate($user[0],$user[1],false);
	}
	
	if(!$curUser) notif('Sorry, an error has occured. You cannot view this page.'); // most likely session expired. or account maybe deactivated in the mean time
	
	mysql_query('INSERT INTO referrals
	(order_id, user_id, email)
	VALUES
	("'.(int)$_SESSION['order_referral'].'","'.$curUser['id_user'].'",'.mysql_real_escape_string(stripslashes($_POST['email'])).')');
	
	if(!sendMail($config['staff_notifications']['default'],'Referral','E-mail: '.$_POST['email']."\nOrder ID (if available): ".$_SESSION['order_referral']."\nFrom: ".$curUser['username'].' ('.$curUser['first_name'].' '.$curUser['last_name'].')')) notif('We encountered an error sending your mail');
}



/*
if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


switch(getUserGroup($curUser))
{
case 'employee':
case 'client':
break;
default:
	notif('Sorry, you are not allowed here.');
break;
}
*/


$template = array(
	'title' => 'Cater2.me | Referral',
	'header_resources' => '
		<style>
		h3 {
		margin-top:10px;
		margin-bottom:30px;
		}
		label {
		font-size:1.3em
		}
		</style>
	',
	'menu_selected' => 'home',

	'breadcrumb' => array('Home'=>'/','Dashboard'=>'/dashboard/','Referral'=>'#'),
	
	'grey_bar' => 'Refer a friend',
	);


require 'header.php';

?>
<h1>Thanks!</h1>

<h3><?=((isset($refMsg))?$refMsg:'If there is another person you would like to refer, please enter their information below')?></h3>

<form method="post" name="f" action="/dashboard/referral/" onsubmit="return checkEmailContact(document.f.email.value);">
	<label for="email">Your colleague's email:</label>
	<input type="email" name="email" placeholder="Referral email address" />
	
	<input type="submit" value="Send" />
</form>

<?
require 'footer.php';
