<?

require 'lib/core.php';

	session_start();
	//if user comes from referral link
	if(isset($_SESSION['ref'])) {
		$ref="\nReferral: ".$_SESSION['ref'];
	}
	else
		$ref='';


//Ajax email submission
if(isset($_POST['signupEmail']))
{
	$_SESSION['signup_email']=$_POST['signupEmail'];
	
	if($curUser) //referral
	{
	$ip=$_SERVER['REMOTE_ADDR'];
	$date = date("Y-m-d H:i:s");
	$name = $curUser['username'];
	$email = $_POST['signupEmail'];
		//sendMail($config['staff_notifications']['default'],'Referral E-mail','E-mail: '.$_POST['signupEmail']."\nFrom: ".$curUser['username'].' ('.$curUser['first_name'].' '.$curUser['last_name'].")\nIP: ".$_SERVER['REMOTE_ADDR']);
		$sql = "INSERT INTO referral_email(id_ref, name_ref, email_ref, fr_name_ref, company_ref, ip_address, page, date) VALUES ('','$name','$email','','','$ip', 'Public Page Submission', '$date')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	
	}
	else //email signup
	{		
	$email=$_POST['signupEmail'];
	$ip=$_SERVER['REMOTE_ADDR'];
	$date = date("Y-m-d H:i:s");
	$cookie = $_POST['campaign'];
	//$page = $_POST['page_name'];
	//sendMail($config['staff_notifications']['default'],'Public Page Submission','E-mail: '.$_POST['signupEmail'].$ref."\nIP: ".$_SERVER['REMOTE_ADDR']);
		$sql = "INSERT INTO info_email(id_info, page_info, email_info, ip_info, date_info, cookie_track) VALUES ('','Public Page Submission', '$email','$ip','$date','$cookie')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());		
	}
	
	die('ok');
}
else //Signup box 2nd form
{	
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
	td:last-child {
	text-align:left;
	}
	a {
	color:#C82B2B;
	}
</style>
<script type="text/javascript">

function validateSignup() {

	if(document.getElementById("name").value=="")
	{
	alert("Please enter your name");
	return false;
	}
	if(!validatePhoneNumber(document.getElementById("phone").value))
	{
	alert("Please enter a valid phone number");
	return false;
	}
	
	return true;
}

function validateReferral() {

	if(document.getElementById("name").value=="")
	{
	alert("Please enter your friend's name");
	return false;
	}
	if(document.getElementById("company").value=="")
	{
	alert("Please enter your friend's company");
	return false;
	}
	
	return true;
}

function validatePhoneNumber(elementValue){  
    var phoneNumberPattern = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;  
    return phoneNumberPattern.test(elementValue);  
}  
</script>
</head>
<body>

	<?
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$tmp='Original e-mail: '.$_SESSION['signup_email']."\nIP: ".$_SERVER['REMOTE_ADDR']."\n";
		foreach($_POST['info'] as $field=>$val) {
			$tmp.="$field: $val\n";
			
		}
		if($curUser)
		{
		$email=$_SESSION['signup_email'];
		$name = $_POST['info']['Name'];
		$company = $_POST['info']['Company'];
		mysql_query("UPDATE referral_email SET fr_name_ref = '$name' WHERE email_ref = '$email'");	
		mysql_query("UPDATE referral_email SET company_ref = '$company' WHERE email_ref = '$email'");
		$respage = mysql_query("SELECT page from referral_email where  email_ref = '$email'");
		$infopage = mysql_fetch_assoc($respage);
		$page= $infopage['page'];
		sendMail($config['staff_notifications']['default'],'Additional information from '.$page,$tmp);
		}
		else {
		$email=$_SESSION['signup_email'];
		$ip=$_SERVER['REMOTE_ADDR'];
		$date = date("Y-m-d H:i:s");
		$name = $_POST['info']['Name'];
		$tel = $_POST['info']['Phone'];
		$ref = $_POST['info']['Referral'];
		mysql_query("UPDATE info_email SET name_email = '$name' WHERE email_info = '$email'");	
		mysql_query("UPDATE info_email SET tel_email = '$tel' WHERE email_info = '$email'");	
		mysql_query("UPDATE info_email SET refer_email = '$ref' WHERE email_info = '$email'");
		$respage = mysql_query("SELECT page_info from info_email where  email_info = '$email'");
		$infopage = mysql_fetch_assoc($respage);
		$page= $infopage['page_info'];
		sendMail($config['staff_notifications']['default'],'Additional information from '.$page,$tmp);

	
		}
		?>
		<h1>Thank you</h1>
		<p>You may now <a href="javascript:void(0)" onclick="parent.$.modal.close();">close</a> this window.</p>
		<?
	}
	else
	{
		if($curUser)
		{
			?>
			<h1>A little more about your friend</h1>

			<form method="post" name="f" onsubmit="return validateReferral();">
			<table>
			<tr><td> Your friend's name: </td><td> <input type="text" id="name" name="info[Name]" /> </td></tr>
			<tr><td> Your friend's company: </td><td> <input type="tel" id="company" name="info[Company]" /> </td></tr>
			</table>

			<p><input type="submit" value="Send" /></p>
			</form>
			<?
		}
		else
		{
			?>
			<h1>A little more about you</h1>

			<form method="post" name="f" onsubmit="return validateSignup();">
			<table>
			<tr><td> Your name: </td><td> <input type="text" id="name" name="info[Name]" /> </td></tr>
			<tr><td> Your phone number: </td><td> <input type="tel" id="phone" name="info[Phone]" /> </td></tr>
			<tr><td> How did you hear about us? </td><td>
				<select name="info[Referral]">
				<option value="-">-- optional --</option>
				<?
				$res=mysql_query('SELECT * FROM website_referral_types');
				while($log = mysql_fetch_assoc($res)) {
					echo '<option>'.$log['label'].'</option>';
				}
				?>
				</select>
			</td></tr>
			</table>

			<p><input type="submit" value="Send" /></p>
			</form>
			<?
		}
	}
	?>

</body>
</html>
<?
}

?>
