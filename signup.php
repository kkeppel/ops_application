<?
require 'lib/core.php';
function VerifierAdresseMail($adresse) 
{ 
   $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
   if(preg_match($Syntaxe,$adresse)) 
      return true; 
   else 
     return false; 
}

if(isset($_POST['email'])) //common to both step when form submitted
{	
	//check that domain isn't public provider
	$forbidden=array('@yahoo.','@ymail.','@mail.','@hotmail.','@gmail.','@aol.','@comcast.','@live.');
	foreach($forbidden as $f) {
		if(strpos($_POST['email'],$f) !== false) notif('Sorry, public e-mail providers cannot be used. Please use your company e-mail address.');
	}
	
$adresse=htmlentities($_POST['email']); 
if(VerifierAdresseMail($adresse)) {} else { notif('Please enter a valid email address.');
}
	
	$domain=stristr($_POST['email'],'@'); //search for existing clients using same email domain
	
	//removes TLD
	$pos=strrpos($domain,'.');
	$domain=substr($domain,0,$pos+1);
	
	$existing = mysql_query('SELECT client_id FROM users WHERE email LIKE "%'.mysql_real_escape_string($domain).'%" AND client_id AND deactivated = 0');
	
if(!mysql_num_rows($existing)) {
	$existing = mysql_query('SELECT id_client FROM subdomain,clients WHERE domain LIKE "%'.mysql_real_escape_string($domain).'%" AND company_id = id_company_sub');
	}

	//if(!mysql_num_rows($existing)) notif('We could not find any client in our database using an e-mail address <b><i>'.$domain.'</i></b>.<br /><br />Please <a href="'.$config['public_email'].'">contact us</a> and we will create an account for you.');
	
	//check email not in use
	if(mysql_num_rows(mysql_query('SELECT 1 FROM users WHERE email = "'.mysql_real_escape_string(stripslashes($_POST['email'])).'"')))
		notif('This e-mail address is already in our database. This form is for new users to sign up only. Please <a href="/login/">sign in</a> to access your account.');
}


if(isset($_GET['email']) && isset($_GET['hash'])) //2nd step of signup (getting or submitting form)
{
	if(md5($config['secret'].stripslashes($_GET['email'])) != $_GET['hash']) notif('It seems that your link is invalid.');


	if($_SERVER{'REQUEST_METHOD'} == 'POST') //form submitted
	{

			//check username not in use
			if(mysql_num_rows(mysql_query('SELECT 1 FROM users WHERE username = "'.mysql_real_escape_string(stripslashes($_POST['username'])).'"')))
				notif('This username is already taken. Please pick another one. <a href="javascript:void(0)" onclick="history.back()">Go back</a>');
	
	
		//fetch company id from existing contact
		$existing = mysql_fetch_row($existing);
		/*
if ($existing=='') 
		{
		$company = mysql_query('SELECT id_company_sub FROM subdomain WHERE domain = LIKE "%'.mysql_real_escape_string($domain).'%"');
		$company = mysql_fetch_row($company);	
		}
		
*///else {
		$company = mysql_query('SELECT company_id FROM clients WHERE id_client = '.$existing[0]);
		$company = mysql_fetch_row($company);	
		//}
	
		//add user (as employee)
		mysql_query('
		INSERT INTO employees (company_id)
		VALUES
		('.$company[0].')');
	
		mysql_query('
		INSERT INTO users (username, email, password, employee_id, first_name, last_name, created)
		VALUES
		("'.mysql_real_escape_string(stripslashes($_POST['username'])).'", "'.mysql_real_escape_string(stripslashes($_GET['email'])).'", "'.md5(stripslashes($_POST['pwd'])).'", '.mysql_insert_id().', "'.mysql_real_escape_string(stripslashes($_POST['first_name'])).'", "'.mysql_real_escape_string(stripslashes($_POST['last_name'])).'", "'.date('Y-m-d H:i:s').'")');
	

		//send notification to user
		$tpl=file_get_contents('template/emails/signup-account-created.html');
		$body=str_replace(array('{{first_name}}','{{username}}'),array($_POST['first_name'],stripslashes($_POST['username'])),$tpl);
	
		sendMail($_POST['email'], 'Thanks for creating a Cater2.me account', $body);
		
		
		//remove email from signup attempts
		mysql_query('DELETE FROM website_signup_attempts WHERE email = "'.mysql_real_escape_string(stripslashes($_GET['email'])).'"');
		
		
		authenticate(stripslashes($_POST['username']), md5(stripslashes($_POST['pwd'])));
		
		
		session_start(); //fetches redirect url in case user sign up to view a specific page
		if(isset($_SESSION['redirect']))
		{
			$redirect='<br /><br /><a href="'.$_SESSION['redirect'].'">You may click here to resume your browsing.</a>';
			unset($_SESSION['redirect']);
		}
		else
			$redirect='';
		
		notif('Thank you, your account has been created.'.$redirect);
		
	}
}
elseif($_SERVER['REQUEST_METHOD']=='POST') //1st step of signup submitted
{

	if(mysql_num_rows($existing)) { //company in database ; send visitor link to sign up
	
		$tpl=file_get_contents('template/emails/signup-registration-link.html');
		$body=str_replace(array('{{link}}'),array('http://cater2.me/signup/?email='.urlencode(stripslashes($_POST['email'])).'&hash='.md5($config['secret'].stripslashes($_POST['email']))),$tpl);
	
		sendMail($config['staff_notifications']['default'], 'Someone requested a signup link', 'E-mail: '.$_POST['email']);
		

		//store email to send reminder later if they end up not signing up
		mysql_query('REPLACE INTO website_signup_attempts (email, `when`) VALUES ("'.mysql_real_escape_string(stripslashes($_POST['email'])).'", "'.date('Y-m-d H:i:s').'")');
		

	} else { //company not registered
		
		$tpl=file_get_contents('template/emails/signup-rejected.html');
		$body=str_replace(array('{{public_email}}'),array($config['public_email']),$tpl);
	
		sendMail($config['staff_notifications']['default'], 'Someone tried to sign up for Cater2.me', '...but no domain match in database: '.$_POST['email']."\nIP: ".$_SERVER['REMOTE_ADDR']);	
	}

		
	sendMail($_POST['email'], 'Create your Cater2.me account', $body);
	
		
	notif('We just e-mailed <b>'.$_POST['email'].'</b>, please check your inbox.');
}


if($curUser)
{
	if(isset($_GET['url']))
		redirect($_GET['url']);
	else
		redirect('/dashboard/');
}



$template = array(
	'title' => 'Cater2.me',
	'menu_selected' => 'home',
	'breadcrumb' => array('Home'=>'/', 'Sign up'=>'/signup/'),
	
	'grey_bar' => 'Sign up'
	);

require 'header.php';

?>
<div class="grid_7" id="contact-page">
            
            <? if(isset($_GET['email']) && isset($_GET['hash'])) { //2nd step ?>
            
            <form method="post" name="f" onsubmit="return checkSignup();">
            <fieldset>
                    
            <legend>Please fill out the following form</legend>
        
            <label for="username">Username</label>
            <input type="text" size="53" name="username"> 


            <input type="hidden" name="email" value="<?=$_GET['email']?>" />
            
			<br>            
            <label for="pwd">Password</label>
            <input type="password" size="53" name="pwd">
            
			<br>            
            <label for="pwd2">(Confirmation)</label>
            <input type="password" size="53" name="pwd2">
            
			<br>            
            <label for="first_name">First name</label>
            <input type="text" size="53" name="first_name">
            
			<br>            
            <label for="last_name">Last name</label>
            <input type="text" size="53" name="last_name">
			
			<div class="grid_4 omega alpha">
            <input type="submit" value="Submit" id="submit" class="submit">
			</div>
            
            </fieldset>
            </form>
            
            <? } else { //1st step ?>
            
            <form method="post">
            <fieldset>
                    
            <legend>Please enter your company e-mail</legend>
        
            <label for="email">E-mail</label>
            <input type="email" value="" size="53" id="email" name="email"> 
			
			<div class="grid_4 omega alpha">
            <input type="submit" value="Submit" id="submit" class="submit">
			</div>
            
            </fieldset>
            </form>
            
            <? } ?>
        
</div>
<?

require 'footer.php';
