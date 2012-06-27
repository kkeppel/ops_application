<?

// sends individual email for each order that needs to be confirmed

require '../lib/core.php';

//if($_GET['auth']!='ok') notif('Sorry, you are not supposed to be here.');
if(!isset($_GET['ahead'])) notif('I need GET[ahead] to be 1, 2, or 3 (days ahead).');

$now=time();


switch($_GET['ahead'])
{
case 3: // notify 3 business days ahead

	switch(date('l')) {
	case 'Monday': //orders on thurs
	case 'Tuesday': //fri
	$range=array(date('Y-m-d',$now+60*60*24*3), date('Y-m-d', $now+60*60*24*4));
	break;
	case 'Wednesday': //mon
	case 'Thursday': //tues
	case 'Friday': //wed
	$range=array(date('Y-m-d',$now+60*60*24*5), date('Y-m-d', $now+60*60*24*6));
	break;
	case 'Saturday': //week end skipped
	case 'Sunday':
	die;
	break;
	}
	
	$subject_template = 'CONFIRMATION NEEDED: Order #{{id_order_proposal}} in 3 business days ({{order_for}}) not yet confirmed';
break;
case 2:

	switch(date('l')) {
	case 'Monday': //orders on wed
	case 'Tuesday': //thus
	case 'Wednesday': //fri
	$range=array(date('Y-m-d',$now+60*60*24*2), date('Y-m-d', $now+60*60*24*3));
	break;
	case 'Thursday': //mon
	case 'Friday': //tues
	$range=array(date('Y-m-d',$now+60*60*24*4), date('Y-m-d', $now+60*60*24*5));
	break;
	case 'Saturday': //week end skipped
	case 'Sunday':
	die;
	break;
	}
	
	$subject_template = 'CONFIRMATION NEEDED: Order #{{id_order_proposal}} in 2 business days ({{order_for}}) not yet confirmed';
break;
case 1:

	switch(date('l')) {
	case 'Monday': //orders on tues
	case 'Tuesday': //wed
	case 'Wednesday': //thurs
	case 'Thursday': //fri
	$range=array(date('Y-m-d',$now+60*60*24*1), date('Y-m-d', $now+60*60*24*2));
	break;
	case 'Friday': //mon
	$range=array(date('Y-m-d',$now+60*60*24*3), date('Y-m-d', $now+60*60*24*4));
	break;
	case 'Saturday': //week end skipped
	case 'Sunday':
	die;
	break;
	}
	
	$subject_template = 'URGENT: CONFIRMATION NEEDED: Order #{{id_order_proposal}} tomorrow (next business day) ({{order_for}}) not yet confirmed';
break;
default:
die;
break;
}

$email_template=file_get_contents('../template/emails/confirmation-reminders-day'.$_GET['ahead'].'.html');

	$res = mysql_query('SELECT id_order, order_for, label, u.vendor_id, first_name, email, id_order_proposal, id_user, created
				  FROM order_requests o_r, order_proposals o_p, order_status o_s, users u   , tmp_vendors v
				  
				  WHERE id_order = o_p.order_id
				  AND id_order_status = order_status_id
				  AND u.vendor_id = o_p.vendor_id
				  
				  AND order_status_id = 4 /* fix for new statuses */
				  AND selected
				  
				  AND v.vendor_id = u.vendor_id
				  AND v.opt_out_confirm_notif < 1
				  
				  AND order_for BETWEEN "'.$range[0].'" AND "'.$range[1].'" ORDER BY vendor_id, order_for, created DESC'); //next week
$order_old = '0';
	if(mysql_num_rows($res)) {
		while($log=mysql_fetch_assoc($res)) {
			//TEMPORARY, until confirmation status is merged with order_status in order_requests tbl
			if ($log['id_order'] == $order_old ){}
		else {

			if(!mysql_num_rows(mysql_query('SELECT 1 FROM tmp_vendor_confirmations WHERE order_id = '.$log['id_order'])))
			{
				$body_email = $email_template;
				$body_email = str_replace('{{first_name}}',$log['first_name'],$body_email);
				$body_email = str_replace('{{id_order_proposal}}',$log['id_order_proposal'],$body_email);
				$body_email = str_replace('{{order_for}}',date('h:i A', strtotime($log['order_for'])),$body_email);
				$body_email = str_replace('{{link}}','http://cater2.me/dashboard/confirm/?oid='.$log['id_order'].'&hash='.round(((($log['id_order'] + 5)*152) -2)/2),$body_email);
				
				$subject_email = $subject_template;
				$subject_email = str_replace('{{order_for}}', date('m/d', strtotime($log['order_for'])), $subject_email);
				$subject_email = str_replace('{{id_order_proposal}}', $log['id_order_proposal'], $subject_email);
			
				if(strpos($log['email'],'efaxsend.com')===false)
				sendMail($log['email'],$subject_email,$body_email, true);
				//sendMail($config['staff_notifications']['default'],$subject_email,$body_email, true); die;
				//echo '-------------------<br />'.$log['email'].' - '.$subject_email.'<br /><br />'.$body_email.'<br />';
			}}
			$order_old  = $log['id_order'];
		}
	}
	else
		echo 'nothing';

