<?
require 'lib/core.php';

function VerifEmail($address) 
{ 
   $Syntax='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
   if(preg_match($Syntax,$address)) 
      return true; 
   else 
     return false; 
}

 $email=$_POST['email'];
 $ip=$_SERVER['REMOTE_ADDR'];
 $date = date("Y-m-d H:i:s");

$sql = "SELECT email_w FROM website_newsletter_emails WHERE email_w='$email'"; 
$req = mysql_query($sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error());  
$sql2 = "SELECT email FROM users WHERE email='$email'"; 
$req2 = mysql_query($sql2) or die('Erreur SQL !'.$sql.'<br>'.mysql_error()); 
$res = mysql_num_rows($req); 
$res2 = mysql_num_rows($req2); 

$address=htmlentities($_POST['email']); 
	if(VerifEmail($address)) {} else { notif('Please enter a valid email address.');
	}


    if($res!=0 or $res2!=0)   // l'url existe dŽjˆ, on affiche un message d'erreur 
        { 
        redirect('betakitchen');
        } 
    else {
if ($email == "" ){
redirect('betakitchen');
}
		else {$sql = "INSERT INTO website_newsletter_emails(email_w, name_w, company_w, newsletter_w, page, ip_news, date_news, beta_news ) VALUES ('$email','','','0', 'BetaKitchen Page','$ip','$date','1')";
		mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());
		sendMail($config['staff_notifications']['default'], 'Newsletter signup from BetaKitchen', 'E-mail: '.$email."\nIP: ".$_SERVER['REMOTE_ADDR']);	

		redirect('betakitchen');
		
		}}
				
				?>
		