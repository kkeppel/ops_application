<?

// sends daily emails to C2me staff, containing information about upcoming orders (tomorrow)
// Friday = sends for Saturday, Sunday, Monday

require '../lib/core.php';

//if($_GET['auth']!='ok') notif('Sorry, you are not supposed to be here.');


switch(date('l')) {
case 'Monday':
case 'Tuesday':
case 'Wednesday':
case 'Thursday':
$range=array(date('Y-m-d',time()+60*60*24*1), date('Y-m-d', time()+60*60*24*2));  //tomorrow
$subject='Tomorrow\'s orders ('.date('m/d/Y',time()+60*60*24*1).')';
break;
case 'Friday':
$range=array(date('Y-m-d',time()+60*60*24*1), date('Y-m-d', time()+60*60*24*4));  //week-end + Monday
$subject='Orders for next 3 days (starting '.date('m/d/Y',time()+60*60*24*1).')';
break;
case 'Saturday':
case 'Sunday':
die;
break;
}


	$res = mysql_query('SELECT id_order, order_for, phone_number, v.name vname, co.name cname, id_order_proposal,created
				  FROM order_requests o_r, order_proposals o_p, order_status o_s, users u, vendors v, companies co, clients cl
				  WHERE id_order = o_p.order_id
				  AND id_order_status = order_status_id
				  AND o_p.vendor_id = u.vendor_id
				  AND o_p.vendor_id = id_vendor
				  AND o_r.client_id = id_client
				  AND company_id = id_company
				  AND order_status_id =4/* fix for new statuses */
				  AND selected
				  AND order_for BETWEEN "'.$range[0].'" AND "'.$range[1].'" ORDER BY order_for, o_p.vendor_id, vname, cname ');


if(mysql_num_rows($res)) {
	while($log=mysql_fetch_assoc($res)) {
		if ($log['id_order'] == $order_old ){}
		else {
		//TEMPORARY, until confirmation status is merged with order_status in order_requests tbl
			if(mysql_num_rows(mysql_query('SELECT 1 FROM tmp_vendor_confirmations WHERE order_id = '.$log['id_order'])))
				$confirmed=' [<span style="color:blue">confirmed</span>]';
			else
				$confirmed=' [<span style="color:red">not confirmed</span>]';
		
		
		$body_email.='<tr><td> '.$log['vname'].' </td><td> '.$log['cname'].' </td><td> '.date('D - h:i A', strtotime($log['order_for'])).' </td><td> #'.$log['id_order_proposal'].' </td><td> '.$log['phone_number'].' </td><td> '.$confirmed.'</td></tr>';
		}
		$order_old  = $log['id_order'];		
		}
		
	
	sendMail($config['staff_notifications']['default'],$subject,'<table border=1><tr><th> Vendor </th><th> Client </th><th> When </th><th> Order ID </th><th> Vendor # </th><th> Status </th></tr>'.$body_email.'</table>', true);
	//echo '<br />--------------------------<br />'.'<table border=1><tr><th> Vendor </th><th> Client </th><th> When </th><th> Order ID </th><th> Vendor # </th><th> Status </th></tr>'.$body_email.'</table>';
}

