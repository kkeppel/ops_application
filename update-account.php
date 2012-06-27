<?
require 'lib/core.php';

if(isset($_GET['email']) && isset($_GET['hash'])) //2nd step
{
	if(md5($config['secret'].stripslashes($_GET['email'])) != $_GET['hash']) notif('It seems that your link is invalid.');

	if($_SERVER{'REQUEST_METHOD'} == 'POST') //updates password and signs user in
	{
			//check username not in use
			if(mysql_num_rows(mysql_query('SELECT 1 FROM users WHERE username = "'.mysql_real_escape_string(stripslashes($_POST['username'])).'"')))
				notif('This username is already taken. Please pick another one. <a href="javascript:void(0)" onclick="history.back()">Go back</a>');
	
		$username=mysql_real_escape_string(stripslashes($_POST['username']));
		$pwd=md5(mysql_real_escape_string(stripslashes($_POST['pwd'])));
		mysql_query('UPDATE users SET users.username = "'.$username.'", users.password = "'.$pwd.'" WHERE email = "'.mysql_real_escape_string(stripslashes($_GET['email'])).'"');
		
		authenticate($username, $pwd);
		
		notif('Your account has been updated. <a href="/dashboard/">Click here to proceed</a>.');
	}
}


$template = array(
	'title' => 'Cater2.me',
	'menu_selected' => 'home',
	'header_resources' => '
		<script type="text/javascript">
		
		function checkUpdate() {

			if(document.f.username.value=="") {
				alert("Please pick a username");
				return false;
			}
			if(checkEmail(document.f.username.value)) {
				alert("Please pick a username; you cannot use an e-mail address");
				return false;
			}
			if(document.f.pwd.value=="") {
				alert("Please provide a password");
				return false;
			}
			if(document.f.pwd.value != document.f.pwd2.value) {
				alert("Passwords don\'t match!");
				return false;
			}
			
			return true;
		}
		
		</script>
	',
	
	
	'grey_bar' => 'Please update your account'
	);

require 'header.php';

?>
<div class="grid_7" id="contact-page">
            
			<p>
			</p>
            
            <form method="post" name="f" onsubmit="return checkUpdate();">
            <fieldset>
                    
            <legend>Thanks for signing in! Please select a new username (different from your email address) and password.</legend>
			
            <label for="pwd">New username</label>
            <input type="text" size="53" name="username">
            
            <br>         
            <label for="pwd">New password</label>
            <input type="password" size="53" name="pwd">
            
			<br>            
            <label for="pwd2">(Confirmation)</label>
            <input type="password" size="53" name="pwd2">

			
			<div class="grid_4 omega alpha">
            <input type="submit" value="Submit" id="submit" class="submit">
			</div>
            
            </fieldset>
            </form>
            
        
</div>
<?

require 'footer.php';
