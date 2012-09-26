<?

require 'config.php';

$curUser=false;
$location='SF';

function connect_mysql() {

	global $config;

	if(!@mysql_connect($config['db']['host'], $config['db']['user'], $config['db']['pwd'])) return mysql_error();
	if(!mysql_select_db($config['db']['db'])) return mysql_error();
	if(!mysql_set_charset($config['db']['charset'])) return mysql_error();
	
	return true;
}

function genBreadcrumb($a) {

	$tmp='';
	foreach($a as $label=>$url) {
		$tmp.='<a href="'.$url.'">'.$label.'</a> &nbsp; &#62; &nbsp; ';
	}
	
	return substr($tmp, 0, -21);
}

function getUser($username)
{ return $username;
}

function authenticate($username, $hash, $writeCookies=true) {

	global $config,$curUser,$location;
	
	$res = mysql_query('SELECT * FROM users u WHERE (u.username = "'.mysql_real_escape_string($username).'" OR u.email = "'.mysql_real_escape_string($username).'") AND u.password = "'.mysql_real_escape_string($hash).'" AND deactivated = 0');
	if(mysql_num_rows($res))
	{
		$curUser=mysql_fetch_assoc($res);
		
		if($writeCookies) {
			$exp=time()+$config['sess_length'];
			@setcookie('sess_username', $username, $exp, '/');
			@setcookie('sess_hash', $hash, $exp, '/');
            @setcookie('sess_location', 'SF', $exp, '/');
		}
	}//Try to connect on the NY DB if the User is not in SF 
    else if ($location == 'SF'){
        //connect to NY Database
        if(!mysql_select_db($config['db']['dbNY'])) return mysql_error();
        $res = mysql_query('SELECT * FROM users u WHERE (u.username = "'.mysql_real_escape_string($username).'" OR u.email = "'.mysql_real_escape_string($username).'") AND u.password = "'.mysql_real_escape_string($hash).'" AND deactivated = 0');
	    if(mysql_num_rows($res)){  	
            $curUser=mysql_fetch_assoc($res);	
            $location = 'NY';  
            if($writeCookies) {
			$exp=time()+$config['sess_length'];
			@setcookie('sess_username', $username, $exp, '/');
			@setcookie('sess_hash', $hash, $exp, '/');
            @setcookie('sess_location', 'NY', $exp, '/');
		}
            //return to initial state
            if(!mysql_select_db($config['db']['db'])) return mysql_error();
        }  
    }

	else //sess invalid
	{
		$curUser=false;
		
		if($writeCookies) {
			@setcookie('sess_username', '', 0, '/');
			@setcookie('sess_hash', '', 0, '/');
            @setcookie('sess_location', '', $exp, '/');
		}
	}
}

function logout() {
	@setcookie('sess_username', '', 0, '/');
	@setcookie('sess_hash', '', 0, '/');
    @setcookie('sess_location', '', $exp, '/');
}


function checkCookies() {

	global $curUser;
	
	if(isset($_COOKIE['sess_username']) && isset($_COOKIE['sess_hash'])) //session exists
		authenticate($_COOKIE['sess_username'],$_COOKIE['sess_hash']);
}

function notif($msg) {
	global $curUser;
	
	$template['menu_selected']='home';
	$template['breadcrumb']=array('Home'=>'/','/!\\'=>'#');
	include __DIR__.'/../header.php';
	?>
	<div class="grid_8 prefix_2 suffix_2">
	<div id="notifBox">
	<?
	echo $msg;
	?>
	</div>
	</div>
	<?
	include __DIR__.'/../footer.php';
	die;
}

function redirect($url) {
	header('Location: '.$url);
	die;
}

function getUserGroup($user) {
	
	if(!$user) return 'visitor';
	
	if($user['staff']) return 'staff';
	
	if($user['vendor_id']) return 'vendor';
	
	if($user['client_id']) return 'client';
	
	if($user['employee_id']) return 'employee';
}

function sendMail($to,$subject,$body,$html=false) {

	if(!$to) return false;

	global $config;

$header  = 'From: Cater2.me <'.$config['mailer_from'].'>
Bcc:serveremail@cater2.me
Reply-To: <'.$config['mailer_from'].'>
Return-Path: <'.$config['mailer_from'].'>
Envelope-from: <'.$config['mailer_from'].'>
MIME-Version: 1.0
Content-type: text/';
	
$header.= ($html) ? 'html' : 'plain';
$header.= '; charset=UTF-8'; //iso-8859-1

	return mail($to,$subject,$body,$header);
}

function sendNewsletter($to,$subject,$body,$html=false) {

	if(!$to) return false;

	global $config;

$header  = 'From: Cater2.me <'.$config['newsletter_from'].'>
Reply-To: <'.$config['newsletter_from'].'>
Return-Path: <'.$config['newsletter_from'].'>
Envelope-from: <'.$config['newsletter_from'].'>
MIME-Version: 1.0
Content-type: text/';
	
$header.= ($html) ? 'html' : 'plain';
$header.= '; charset=UTF-8'; //iso-8859-1

	return mail($to,$subject,$body,$header);
}


function plain2Html($s) {
	$order=array("\r\n", "\n", "\r");
	$s = str_replace($order, '<br />', $s);
	
	
	//$s = preg_replace("/(?<!http:\/\/)www\./","http://www.",$s);
	//$s = preg_replace( "/((http|ftp)+(s)?:\/\/[^<>\s]+)/i", "<a href=\"\\0\" target=\"_new\">\\0</a>",$s);
	
	$s = str_replace('href=', 'target="_new" href=', $s);
	
	return $s;
}

function c2me_decrypt($s) {
	global $config;
	return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($config['secret']), base64_decode($s), MCRYPT_MODE_CBC, md5(md5($config['secret']))), "\0");
}

function c2me_encrypt($s) {
	global $config;
	return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($config['secret']), $s, MCRYPT_MODE_CBC, md5(md5($config['secret']))));
}



if(!$config['www']&&substr($_SERVER['HTTP_HOST'],0,4)=='www.') redirect('http://cater2.me'.$_SERVER['REQUEST_URI']);



$lnk=connect_mysql();
if($lnk!==true) notif('<b>Database error</b>: '.$lnk);


checkCookies();


