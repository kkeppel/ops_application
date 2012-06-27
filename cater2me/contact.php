<?
require 'lib/core.php';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{


	//if user comes from referral link
	session_start();
	if(isset($_SESSION['ref'])) {
		$ref="\nReferral: ".$_SESSION['ref'];
	}
	else
		$ref='';
		
	$date = date("Y-m-d H:i:s");
	
	if($_POST['catering_buyer'])
	{
	 $email=$_POST['catering_buyer'];
 	 $ip=$_SERVER['REMOTE_ADDR'];
 
		$_SESSION['signup_email']=$_POST['catering_buyer'];
		sendMail($config['staff_notifications']['default'],'New Catering Buyer Email',"From: Contact Us page\nEmail: ".$_POST['catering_buyer'].$ref."\nIP: ".$_SERVER['REMOTE_ADDR']);
		$sql = "INSERT INTO info_email(id_info, page_info, email_info, ip_info, date_info) VALUES ('','Buyer Contact Us page', '$email','$ip','$date')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());		

	}
	else
	{
	 $email=$_POST['catering_provider'];
	 $ip=$_SERVER['REMOTE_ADDR'];

		$_SESSION['signup_email']=$_POST['catering_provider'];
		sendMail($config['staff_notifications']['default'],'New Catering Provider Email',"From: Contact Us page\nEmail: ".$_POST['catering_provider'].$ref."\nIP: ".$_SERVER['REMOTE_ADDR']);
		$sql = "INSERT INTO info_email(id_info, page_info, email_info, ip_info, date_info) VALUES ('','Provider Contact Us page', '$email','$ip','$date')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	
	}
	
	notif('Thank you. We will get back to you shortly.<script type="text/javascript"> $(document).ready(function() { simpleModal("/Signup-Email.php",530,330); }); </script>');
}


$template = array(
	'title' => 'Cater2.me | Contact Us - Your catering is our business',
	'menu_selected' => 'contact',
	'breadcrumb' => array('Home'=>'/', 'Contact Us'=>'/contact/'),
	'meta_name' => 'Need lunch catering in San Francisco for 140 people? We got you covered, contact us!',

	'grey_bar' => 'Contact Us',
	'slider_open' => true
	);

require 'header.php';


$areas=array();
$res = mysql_query('SELECT label, value FROM website_editable_areas WHERE label LIKE "contact_us_%"');
while($log = mysql_fetch_assoc($res)) {
	$areas[$log['label']]=$log['value'];
}

?>

<div class="grid_12" id="divContactInfo">
	<?=plain2Html($areas['contact_us_top'])?>
</div>



<div class="grid_12">
<div class="grid_5 alpha">
	<h1>Catering Buyers</h1>
	<p><?=plain2Html($areas['contact_us_buyers'])?></p>
</div>
<div class="grid_5 prefix_1 omega">
	<h1>Catering Providers</h1>
	<p><?=plain2Html($areas['contact_us_providers'])?></p>
</div>
</div>


<div class="grid_12" id="divContactNiftyBoxes">
<div class="grid_5 alpha">
	<form method="post" name="fb" onsubmit="return checkEmailContact(document.fb.catering_buyer.value) ">
	<div class="niftyBox"> <input type="email" name="catering_buyer" class="niftyTextfield" placeholder="Company E-mail Address" maxlength="30" /> <input type="submit" value=" " class="niftySubmit" onclick="_gaq.push(['_trackEvent', 'form', 'buyers']);"/> </div>
  
	</form>
</div>
<div class="grid_5 prefix_1 omega">
	<form method="post" name="fp" onsubmit="return checkEmailContact(document.fp.catering_provider.value)">
	<div class="niftyBox"> <input type="email" name="catering_provider" class="niftyTextfield" placeholder="Provider E-mail Address" maxlength="30" /> <input type="submit"  value=" " class="niftySubmit" onclick="_gaq.push(['_trackEvent', 'form', 'providers']);"/> </div>
	</form>
</div>
</div>

<?

require 'footer.php';
