

<?

require_once 'lib/core.php';

session_start();

if($_SERVER['REQUEST_METHOD']=='POST')
{

	if($_POST['unsign']) 
	{
	$email = $_POST['email'];
	mysql_query("UPDATE users SET newsletter = '0' WHERE email = '$email'");
	mysql_query("UPDATE website_newsletter_emails SET newsletter_w = 0 WHERE email_w =  '$email'");
	$destinataire = "help@cater2.me";
		$expediteur   = "info@cater2.me";
		$reponse      = $expediteur;
		$codehtml=
		"<html><body>" .
		"<h1>".$email." unsubscribed from the newsletter</h1>".
		"</body></html>";
		mail($destinataire,
		"Newsletter Unsubscribe",$codehtml,
		"From: $expediteur\r\n".
		"Reply-To: $reponse\r\n".
		"Content-Type: text/html; charset=\"iso-8859-1\"\r\n");


	notif("Thanks, you'll no longer receive the newsletter. If you would like to resubscribe, please contact us at <A HREF='mailto:social@cater2.me'>social@cater2.me");
	}
	else 
	{
	$email_w = $_POST['email'];
	$sql = "INSERT INTO website_newsletter_emails(email_w, name_w, company_w, newsletter_w) VALUES ('$email_w','','','0')";
		mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());
			$destinataire = "help@cater2.me";
			$expediteur   = "info@cater2.me";
			$reponse      = $expediteur;
			$codehtml=
			"<html><body>" .
			"<h1>".$email_w." is not in the database and wants to be unsubscribed.</h1>".
			"</body></html>";
			mail($destinataire,
			"Newsletter signup",$codehtml,
			"From: $expediteur\r\n".
			"Reply-To: $reponse\r\n".
			"Content-Type: text/html; charset=\"iso-8859-1\"\r\n");

		notif("Thanks, you'll no longer receive the newsletter. If you would like to resubscribe, please contact us at <A HREF='mailto:social@cater2.me'>social@cater2.me");

}
	
	}


$template = array(
	'title' => 'Cater2.me | Unsubscribe',
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

	'breadcrumb' => array('Home'=>'/','Dashboard'=>'/dashboard/','Unsubscribe'=>'#'),
	
	'grey_bar' => 'Unsubscribe',
	);


require 'header.php';
$hash_post = $_GET['id'];
$res = mysql_query("SELECT email, email_w  FROM users, website_newsletter_emails" );
		while($email=mysql_fetch_row($res))
			{

			$mail2= $email['0'];
			$mail3= $email['1'];
			if ($hash_post == md5($mail2))
			{
			$email_post=$mail2;
			}
			else if ($hash_post == md5($mail3))
			{ 
			$email_post=$mail3; }
			}
if ($email_post != '')
{
$message = 'Are you sure you want to unsubscribe '.$email_post.' from our newsletter? </A>';
?>
<h3><? echo $message ?></h3>

<form method="post" name="f" >
<input type="hidden" name="email" value=<? echo $email_post ?> >	
<center><input type="submit" value="Yes" name="unsign" ></center>
</form>

<?
}
else 
{ ?>
<h3> Hmmm...It appears your email address is not in our system. Please enter your email address below, click Submit, and we'll make sure you don't receive the newsletter again. </h3>
<form method="post" name="f" >
<input type="text" name="email" value="" >	
<input type="submit" value="Submit" name="sign" >
</form>

<? }
require 'footer.php';
