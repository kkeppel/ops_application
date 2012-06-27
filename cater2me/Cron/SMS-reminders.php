<?

// sends text messages for orders of the day

require '../lib/core.php';
require '../lib/gshortener.php';

function phone2email($number,$carrier) {
	
	switch($carrier) {
	case 'ATT':
	$suffix='txt.att.net';
	break;
	case 'Verizon':
	$suffix='vtext.com';
	break;
	case 'T-Mobile':
	$suffix='tmomail.net';
	break;
	case 'Sprint':
	$suffix='messaging.sprintpcs.com';
	break;
	case 'Metro PCS':
	$suffix='mymetropcs.com';
	break;
	default:
		return false;
	break;
	}
	
	$number = preg_replace('/[^0-9]/', '', $number);
	
	if(strlen($number) < 10) return false;
	
	return $number.'@'.$suffix;
}



$sms_template=file_get_contents('../template/emails/SMS-reminders.html');

$googer = new GoogleURLAPI($config['gshortener_key']);



	$now=time();
	$range=array(date('Y-m-d'), date('Y-m-d', $now+60*60*24*1));



	$res = mysql_query('SELECT id_order, order_for, u.vendor_id, first_name, email, co.address, co.city, personal_number, carrier
				  FROM order_requests o_r, order_proposals o_p, order_status o_s, users u, tmp_vendors v, clients cl, companies co
				  
				  WHERE id_order = o_p.order_id
				  AND id_order_status = order_status_id
				  AND u.vendor_id = o_p.vendor_id
				  
				  AND order_status_id = 4 /* fix for new statuses */
				  AND selected
				  
				  AND v.vendor_id = u.vendor_id
				  AND v.opt_out_sms_notif < 1
				  
				  AND o_r.client_id = id_client
				  AND id_company = company_id
				  
				  AND order_for BETWEEN "'.$range[0].'" AND "'.$range[1].'" ORDER BY vendor_id, order_for');





	if(mysql_num_rows($res)) {
		while($log=mysql_fetch_assoc($res)) {
			
			$body_sms = $sms_template;
			$body_sms = str_replace('{{id_order}}',$log['id_order'],$body_sms);
			$body_sms = str_replace('{{order_for}}',date('h:i A', strtotime($log['order_for'])),$body_sms);
			$body_sms = str_replace('{{address}}',$log['address'],$body_sms);
			$body_sms = str_replace('{{city}}',$log['city'],$body_sms);
			$body_sms = str_replace('{{link}}',$googer->shorten('http://cater2.me/dashboard/confirm-sms/?oid='.$log['id_order'].'&hash='.round(((($log['id_order'] + 5)*152) -2)/2)),$body_sms);
			
			$recipient = phone2email($log['personal_number'],$log['carrier']);
			if($recipient) sendMail($recipient,'',$body_sms);
			//echo $recipient."\n".$body_sms; die;
		}
	}
	else
		echo 'nothing';




