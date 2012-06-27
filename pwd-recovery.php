<?
require 'lib/core.php';


	//for direct links from emails
	if(isset($_GET['recover'])) {
		$_POST['input']=$_GET['recover'];
	}
	


if(isset($_POST['input'])) //1st step
{
	$_POST['input']=mysql_real_escape_string(stripslashes($_POST['input']));
	$user = mysql_query('SELECT email, first_name, username FROM users WHERE email = "'.$_POST['input'].'" OR username = "'.$_POST['input'].'"');
	if(!mysql_num_rows($user)) notif('We could not find any user in our database. Please <a href="mailto:'.$config['public_email'].'">contact us</a> for help.');
	$user=mysql_fetch_assoc($user);
	
	//send recovery link to user
	$tpl=file_get_contents('template/emails/pwd-recovery.html');
	$body=str_replace(array('{{first_name}}','{{link}}','{{username}}'),array($user['first_name'],'http://cater2.me/pwd-recovery/?email='.urlencode($user['email']).'&hash='.md5($config['secret'].stripslashes($user['email'])),$user['username']),$tpl);
	
	sendMail($user['email'], 'Password recovery', $body);
	
	notif('We just sent you an e-mail, please check your inbox.');
}


if(isset($_GET['email']) && isset($_GET['hash'])) //2nd step
{
	if(md5($config['secret'].stripslashes($_GET['email'])) != $_GET['hash']) notif('It seems that your link is invalid.');


	if($_SERVER{'REQUEST_METHOD'} == 'POST') //updates password and signs user in
	{
		$pwd=md5(mysql_real_escape_string(stripslashes($_POST['pwd'])));
		mysql_query('UPDATE users SET users.password = "'.$pwd.'" WHERE email = "'.mysql_real_escape_string(stripslashes($_GET['email'])).'"');
		
		$user = mysql_query('SELECT username FROM users WHERE email = "'.mysql_real_escape_string(stripslashes($_GET['email'])).'"');
		$user = mysql_fetch_assoc($user);
		
		authenticate($user['username'], $pwd);
		
		notif('Your password has been updated. <a href="/dashboard/">Click here to proceed</a>.');
	}
}


$template = array(
	'title' => 'Cater2.me',
	'menu_selected' => 'home',
	'breadcrumb' => array('Home'=>'/', 'Password recovery'=>'/pwd-recovery/'),
	
	'grey_bar' => 'Password recovery'
	);

require 'header.php';

?>
<div class="grid_7" id="contact-page">
            
            <? if(isset($_GET['email']) && isset($_GET['hash'])) { //2nd step ?>
            
            <form method="post" name="f" onsubmit="return checkPwdRecovery();">
            <fieldset>
                    
            <legend>Please create a new password</legend>
            
                   
            <label for="pwd">Password</label>
            <input type="password" size="53" name="pwd">
            
			<br>            
            <label for="pwd2">(Confirmation)</label>
            <input type="password" size="53" name="pwd2">

			
			<div class="grid_4 omega alpha">
            <input type="submit" value="Submit" id="submit" class="submit">
			</div>
            
            </fieldset>
            </form>
            
            <? } else { //1st step ?>
            
            <form method="post">
            <fieldset>
                    
            <legend>Please enter your username or company e-mail</legend>
        
            <label for="input">Username/E-mail</label>
            <input type="text" value="" size="53" name="input"> 
			
			<div class="grid_4 omega alpha">
            <input type="submit" value="Submit" id="submit" class="submit">
			</div>
            
            </fieldset>
            </form>
            
            <? } ?>
        
</div>
<?

require 'footer.php';
