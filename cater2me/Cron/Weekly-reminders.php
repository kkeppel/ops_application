<?

// sends weekly (Sunday) email to vendors, containing information about upcoming orders

require '../lib/core.php';

//if($_GET['auth']!='ok') notif('Sorry, you are not supposed to be here.');

	$res = mysql_query('SELECT id_order, order_for, label, u.vendor_id, first_name, email, id_order_proposal, created
				  FROM order_requests o_r, order_proposals o_p, order_status o_s, users u   , tmp_vendors v
				  
				  WHERE id_order = o_p.order_id
				  AND id_order_status = order_status_id
				  AND u.vendor_id = o_p.vendor_id
				  
				  AND order_status_id = 4 /* fix for new statuses */
				  AND selected
				  
				  AND v.vendor_id = u.vendor_id
				  AND v.opt_out_weekly_notif < 1
				  
				  AND order_for BETWEEN "'.date('Y-m-d',time()+60*60*24*1).'" AND "'.date('Y-m-d', time()+60*60*24*8).'" ORDER BY u.vendor_id, order_for, created desc'); //next week

$lastVendor['id']=0;
$body_email='';
if(mysql_num_rows($res)) {
	while($log=mysql_fetch_assoc($res)) {
		if ($log['id_order'] == $order_old ){}
		else {
		if($lastVendor['id'] != $log['vendor_id'])
		{
			$body_email.='<br />These orders can also be confirmed by clicking the following link to access your schedule online: <br / >http://cater2.me/dashboard/calendar/ <br /><br /> If you have any question, please contact us immediately at <a href="mailto:proposals@cater2.me">proposals@cater2.me</a> <br /><br /> Thanks, <br /><br /> The Cater2.me team';
			if($lastVendor['id']) sendMail($lastVendor['email'],'Upcoming Week\'s Orders as of '.date('m/d/Y'),$body_email, true); //skip first loop
			//if($lastVendor['id']) { sendMail($config['staff_notifications']['default'],'Upcoming Week\'s Orders as of '.date('m/d/Y'),$body_email, true); }
			//if($lastVendor['id']) echo '<br />--------------------------<br />'.$lastVendor['email'].' - Upcoming Week\'s Orders as of '.date('m/d/Y').' - '.$body_email;
			$body_email='Hi '.$log['first_name'].','.'<br /><br /> We\'ve included below a summary of your current schedule for this week as of '.date('m/d/Y').'. Please make sure you have detailed order confirmations for the orders listed below.<br /><br />';
			$lastVendor=array('id'=>$log['vendor_id'], 'email'=>$log['email']);
		}
		
		
		//TEMPORARY, until confirmation status is merged with order_status in order_requests tbl
			if(mysql_num_rows(mysql_query('SELECT 1 FROM tmp_vendor_confirmations WHERE order_id = '.$log['id_order'])))
				$confirmed=' [<span style="color:blue">confirmed</span>]';
			else
				$confirmed=' [<span style="color:red">NOT CONFIRMED</span>: <a href="http://cater2.me/dashboard/confirm/?oid='.$log['id_order'].'&hash='.round(((($log['id_order'] + 5)*152) -2)/2).'">click here to confirm</a>]';
		
		$body_email.='- ['.date('D, m/d - h:i A', strtotime($log['order_for'])).']: OrderID #'.$log['id_order_proposal'].''.$confirmed.'<br />';
			$order_old  = $log['id_order'];	
	}

	}
	
	$body_email.='<br />These orders can also be confirmed by clicking the following link to access your schedule online: <br / >http://cater2.me/dashboard/calendar/ <br /><br /> If you have any question, please contact us immediately <a href="mailto:proposals@cater2.me">proposals@cater2.me</a> <br /><br /> Thanks, <br /><br /> The Cater2.me team';
	
	sendMail($lastVendor['email'],'Upcoming Week\'s Orders as of '.date('m/d/Y'),$body_email, true);
	//sendMail($config['staff_notifications']['default'],'Upcoming Week\'s Orders as of '.date('m/d/Y'),$body_email, true);
	//echo '<br />--------------------------<br />'.$lastVendor['email'].' - Upcoming Week\'s Orders as of '.date('m/d/Y').' - '.$body_email;
}

