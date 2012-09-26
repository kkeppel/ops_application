<?

// sends daily emails to C2me staff, containing information about upcoming orders (tomorrow)
// Friday = sends for Saturday, Sunday, Monday

require '../lib/core.php';
//if($_GET['auth']!='ok') notif('Sorry, you are not supposed to be here.');



$subject='Today\'s orders not confirmed ('.date('Y-m-d').')';
$dated1 = date('Y-m-d');
$date1 = $dated1.' 00:00:00';
$dated2 = date('Y-m-d');
$date2=$dated2.' 23:59:59';



	$res = mysql_query('SELECT id_order, order_for, phone_number, v.name vname, co.name cname, id_order_proposal,created, order_status_id, last_updated
				  FROM order_requests o_r, order_proposals o_p, order_status o_s, users u, vendors v, companies co, clients cl
				  WHERE id_order = o_p.order_id
				  AND id_order_status = order_status_id
				  AND o_p.vendor_id = u.vendor_id
				  AND o_p.vendor_id = id_vendor
				  AND o_r.client_id = id_client
				  AND company_id = id_company
				  AND order_status_id =4/* fix for new statuses */
				  AND selected
					AND id_vendor <>38
					AND id_vendor <>16				  
				AND order_for BETWEEN "'.$date1.'" AND "'.$date2.'" ORDER BY order_for, o_p.vendor_id, vname, cname ');

			if(mysql_num_rows($res)) {
				while($log=mysql_fetch_assoc($res)) {
					if ($log['id_order'] == $order_old ){}
					else {

							if ($log['order_status_id'] == 2 )
							{
								if(mysql_num_rows(mysql_query('SELECT 1 FROM tmp_vendor_confirmcancel WHERE order_id = '.$log['id_order'])))
									{$confirmed=' [<span style="color:blue">cancellation confirmed</span>]';}
								else {
									$confirmed=' [<span style="color:red">unconfirmed cancellation</span>]'; 
									$body_email.='<tr><td> '.$log['vname'].' </td><td> '.$log['cname'].' </td><td> '.date('D - h:i A', strtotime($log['order_for'])).' </td><td> #'.$log['id_order_proposal'].' </td><td> '.$log['phone_number'].' </td><td> '.$confirmed.'</td></tr>';
									}
							}
						else	if($log['last_updated'] != '0000-00-00 00:00:00')
							{
									if(mysql_num_rows(mysql_query('SELECT 1 FROM tmp_vendor_confirmupdate WHERE order_id = '.$log['id_order'])))
										{$confirmed=' [<span style="color:blue">update confirmed</span>]';							
												}
									else {
										$confirmed=' [<span style="color:red">unconfirmed update</span>]'; 
												$body_email.='<tr><td> '.$log['vname'].' </td><td> '.$log['cname'].' </td><td> '.date('D - h:i A', strtotime($log['order_for'])).' </td><td> #'.$log['id_order_proposal'].' </td><td> '.$log['phone_number'].' </td><td> '.$confirmed.'</td></tr>';
												}
							}					
							else if(mysql_num_rows(mysql_query('SELECT 1 FROM tmp_vendor_confirmations WHERE order_id = '.$log['id_order'])))

							{$confirmed=' [<span style="color:blue">confirmed</span>]';
							}
						else {
							$confirmed=' [<span style="color:red">not confirmed</span>]';
									$body_email.='<tr><td> '.$log['vname'].' </td><td> '.$log['cname'].' </td><td> '.date('D - h:i A', strtotime($log['order_for'])).' </td><td> #'.$log['id_order_proposal'].' </td><td> '.$log['phone_number'].' </td><td> '.$confirmed.'</td></tr>';
							}



					}
					$order_old  = $log['id_order'];		
					}


	
	sendMail($config['staff_notifications']['default'],$subject,'<table border=1><tr><th> Vendor </th><th> Client </th><th> When </th><th> Order ID </th><th> Vendor # </th><th> Status </th></tr>'.$body_email.'</table>', true);
	//echo '<br />--------------------------<br />'.'<table border=1><tr><th> Vendor </th><th> Client </th><th> When </th><th> Order ID </th><th> Vendor # </th><th> Status </th></tr>'.$body_email.'</table>';
}

