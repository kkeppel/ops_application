<?

require 'lib/core.php';


if($_SERVER['REQUEST_METHOD']=='POST')
{
	authenticate(stripslashes($_POST['username']), md5(stripslashes($_POST['pwd']))); //updates $curUser accordingly
	
	if(!$curUser)
		$err='Sorry: login failed.';
	else
	{
	
				/*** temporary ***/
				if($curUser['username']==$curUser['email'])
				{
					@setcookie('sess_username', '', 0, '/');
					@setcookie('sess_hash', '', 0, '/');
					redirect('/update-account.php?email='.urlencode($curUser['email']).'&hash='.md5($config['secret'].stripslashes($curUser['email'])));
				}
				/*** temporary ***/
	
		mysql_query('UPDATE users SET last_visit = NOW(), nb_visits=nb_visits+1 WHERE id_user = '.$curUser['id_user']);
	}
}

if($curUser)
{    
	if(isset($_GET['url'])){
	   $url = $_GET['url'];
       $path = parse_url($url, PHP_URL_PATH);
		//patch NY
        if (($_COOKIE['sess_location'] == 'NY')|| $location == 'NY'){
          redirect($config['NYurl'].$path); 
        }
        else{
          redirect($_GET['url']);  
        }
	}else{
	   if (($_COOKIE['sess_location'] == 'NY')|| $location == 'NY'){
	      $email = $curUser['email'];
          $pwd = $curUser['password'];
          $curUser = false;
		 redirect($config['NYurl'].'/dashboard?email='.urlencode($email).'&hash='.urlencode($pwd));
       }else{
         redirect('/dashboard/');
       }
    }
}

if(isset($_GET['url'])) {
	session_start(); //to save redirect url and redirect back once user signs up, if they do
	$_SESSION['redirect']=$_GET['url'];
	$err='You have to sign in to view this page, or <a href="/signup/">sign up</a>.';
}



$template = array(
	'title' => 'Cater2.me',
	'menu_selected' => 'home',
	'breadcrumb' => array('Home'=>'/', 'Login'=>'/login/'),
	
	'grey_bar' => 'Log in'
	);

require 'header.php';

?>
<div class="grid_7" id="contact-page">
<form method="post">
            
            <fieldset>
                    
            <legend>Sign in below, or <a href="/signup/">click here to sign up</a></legend>
        
        	<? if(isset($err)) { ?>
        		<div class="error_message"><?=$err?></div>
        	<? } ?>
        
            <label for="username">Username/E-mail</label>
            <input type="text" value="" style="width:500px" id="username" name="username"> 
        
            <br>
            <label for="pwd">Password</label>
            <input type="password" value="" style="width:500px" id="pwd" name="pwd">
        
        

			<div style="margin:20px 0;" class="grid-hr"></div>
			
			<div class="grid_3 alpha">
            		<input type="submit" value="Submit" id="submit" class="submit">
			</div>
			<div class="grid_3 prefix_1 omega">
            		<a href="/pwd-recovery/">Forgot password?</a>
			</div>
            
            </fieldset>
        
</form>
<? echo($curUser) ?>
</div>
<div class="grid_5 signup">
	 <!-- -->
</div>
<?

require 'footer.php';
