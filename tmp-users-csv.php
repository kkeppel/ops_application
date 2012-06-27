<?


require 'lib/core.php';
header('Content-Type: application/force-download');

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser)!='staff') notif('Sorry, you are not supposed to be here.');


echo '"id_user","username","vendor_id","client_id","employee_id","staff","first_name","last_name","title","email","email2","phone_number","personal_number","extension","fax_number","last_visit","created","notes","nb_visits","deactivated"'."\n";

$res = mysql_query('SELECT * FROM users ORDER BY id_user');
while($log = mysql_fetch_assoc($res))
{
	echo '"'.$log['id_user'].'","'.utf8_decode($log['username']).'","'.$log['vendor_id'].'","'.$log['client_id'].'","'.$log['employee_id'].'","'.$log['staff'].'","'.utf8_decode($log['first_name']).'","'.utf8_decode($log['last_name']).'","'.utf8_decode($log['title']).'","'.$log['email'].'","'.$log['email2'].'","'.$log['phone_number'].'","'.$log['personal_number'].'","'.$log['extension'].'","'.$log['fax_number'].'","'.$log['last_visit'].'","'.$log['created'].'","'.$log['notes'].'","'.$log['nb_visits'].'","'.$log['deactivated'].'"'."\n";
}

