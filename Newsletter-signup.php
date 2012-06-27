<?

require 'lib/core.php';


	session_start();
	//if user comes from referral link
	if(isset($_SESSION['ref'])) {
		$res=mysql_query('SELECT * FROM users WHERE id_user =  '.(int)$_SESSION['ref']);
		$log=mysql_fetch_assoc($res);
		$ref="\nReferral: ".$log['username'].' ('.$log['first_name'].' '.$log['last_name'].')';
	}
	else
		$ref='';


?><!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"> 
<head>
<style>
	body {
	font-family:"Trebuchet MS", Arial;
	color:#C4C4C4;
	text-align:center;
	background-color:#222;
	}
	h1 {
	text-align:center;
	font-size:24px;
	margin:30px;
	}
	
	table {
	margin:5px auto
	}
	td {
	padding:12px;
	text-align:right;
	}
	td input {
	width:200px;
	}
	a {
	color:#C82B2B;
	}
</style>
<script type="text/javascript">

function checkEmail(email) {
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(email))
		return false;
	
	return true;
}

function validate() {

	if(document.getElementById("name").value=="")
	{
	alert("Please enter your name");
	return false;
	}
	if(!checkEmail(document.getElementById("email").value))
	{
	alert("Please enter a valid e-mail address");
	return false;
	}
	if(document.getElementById("company").value=="")
	{
	alert("Please enter your company");
	return false;
	}
	
	return true;
}

</script>
</head>
<body>

	<?
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$tmp='';
		foreach($_POST['info'] as $field=>$val) {
			$tmp.="$field: $val\n";
		}
		
		$email_w=$_POST['info']['Email'];
		$name_w=$_POST['info']['Name'];
		$company_w=$_POST['info']['Company'];
		//mysql_query('REPLACE INTO website_newsletter_emails SET email = "'.mysql_real_escape_string(stripslashes($_POST['info']['Email'])).'"');
	$sql = "SELECT email_w FROM website_newsletter_emails WHERE email_w='$email_w'"; 
    $req = mysql_query($sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error());  
     $sql2 = "SELECT email FROM users WHERE email='$email_w'"; 
    $req2 = mysql_query($sql2) or die('Erreur SQL !'.$sql.'<br>'.mysql_error()); 
    $res = mysql_num_rows($req); 
	$res2 = mysql_num_rows($req2); 

    if($res!=0 or $res2!=0)   // l'url existe déjà, on affiche un message d'erreur 
        { 
        echo '<p>You had already signup for our newsletter</p>'; 
        } 
    else { 
		$ip=$_SERVER['REMOTE_ADDR'];
		$date = date("Y-m-d H:i:s");
		$sql = "INSERT INTO website_newsletter_emails(email_w, name_w, company_w, newsletter_w, page, ip_news, date_news, beta_news) VALUES ('$email_w','$name_w','$company_w','1','Events Page','$ip','$date','0')";
		mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());
		
		sendMail($config['staff_notifications']['default'],'Newsletter signup from Events Page',$tmp.$ref."\nIP: ".$_SERVER['REMOTE_ADDR']);
		?>
		<h1>Thank you</h1>
		<p>You may now <a href="javascript:void(0)" onclick="parent.$.modal.close();">close</a> this window.</p>
		<? }
	}
	else
	{
		?>
		<h1>Who are you?</h1>

		<form method="post" name="f" onsubmit="return validate();">
		<table>
		<tr><td> Your name: </td><td> <input type="text" id="name" name="info[Name]" /> </td></tr>
		<tr><td> Your e-mail: </td><td> <input type="email" id="email" name="info[Email]" /> </td></tr>
		<tr><td> Your company: </td><td> <input type="text" id="company" name="info[Company]" /> </td></tr>
		</table>

		<p><input type="submit" value="Send" /></p>
		</form>
		<?
	}
	?>

</body>
</html>
