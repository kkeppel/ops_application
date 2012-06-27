<?

require 'lib/core.php';

if(!isset($_GET['oid']) || !isset($_GET['hash'])) {
	notif('Link invalid: arguments missing. Please check your link.');
}
//if(md5($config['secret'].$_GET['oid']) != $_GET['hash']) {
if(round(((($_GET['oid'] + 5)*152) -2)/2) != $_GET['hash']) {
	notif('Link invalid: hash is incorrect. Please check your link.');
}

$_GET['oid']=(int)$_GET['oid'];


	//***************
	// HERE CHECK THAT ORDER STATUS CAN LOGICALLY BE SWITCHED AS CONFIRMED
	//***************
	$res = mysql_query('SELECT 1 FROM tmp_vendor_confirmcancel WHERE order_id = '.$_GET['oid']) or die(mysql_error());
	if(mysql_num_rows($res)) notif('This cancellation has already been confirmed.');
	
	
	//get order info
	$res = mysql_query('SELECT companies.name cname, order_for, order_status_id, vendors.name vname, id_order_proposal
						FROM companies, clients, order_requests, order_proposals, vendors
						WHERE client_id = id_client
						AND company_id = id_company
						AND id_order = order_id
						AND selected
						AND id_vendor = vendor_id 
						AND id_order = '.$_GET['oid']);
	$order = @mysql_fetch_assoc($res);

	//if(!$log['order_status_id'] != 9999 || strtotime($log['order_for']) < time()) notif('The status of this order can no longer but changed.');
	
	
	//***************
	// CHANGE ORDER STATUS AS CONFIRMED HERE
	//***************
	// mysql_query('UPDATE order_requests SET order_status_id = 9999 WHERE id_order = '.$_GET['oid']);
	$datetimeday = date("Y-m-d H:i:s");
	mysql_query('REPLACE INTO tmp_vendor_confirmcancel (order_id, date) Values ("'.$_GET['oid'].'","'.$datetimeday.'")' );

	
	
sendMail($config['staff_notifications']['vendor_confirmations'],'Cancellation confirmed by vendor','Order ID:'.$_GET['oid']."\nClient: ".$order['cname']."\nVendor: ".$order['vname']."\nWhen: ".$order['order_for']);


if(isset($_GET['ajax'])) die('ok');

		/*** temporary: when database is not up to date but client hits confirm link from email ***/
		if($order=='') //MySQL query failed
		notif('Thank you for confirming this cancellation.');
		/*** temporary ***/


$template = array(
	'title' => 'Cater2.me | Cancellation confirmation',
	'menu_selected' => 'home',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
	
		<script>
		$(function() {
			$( ".accordion" ).accordion({
				autoHeight: false,
				navigation: true,
				collapsible: true,
				active: false
			});
		});
		</script>
	',
	'breadcrumb' => array('Home'=>'/','Dashboard'=>'/dashboard/','Cancellation conformation (#'.$_GET['oid'].')'=>$_SERVER['REQUEST_URI']),
	
	'grey_bar' => 'Cancellation #'.$order['id_order_proposal'],
	);


require 'header.php';

?>
<h1>Thank you. This cancellation has been confirmed.</h1>

<table>
<tr><th>Order to</th><th><?=$order['cname']?></th></tr>
<tr><td>Date time</td><td><?=date('l M j Y @ g:i A',strtotime($order['order_for']))?></td></tr>
<tr><td>Order ID</td><td><?=$order['id_order_proposal']?></td></tr>
</table>


<p><a href="/login/">Please log in to access your calendar</p>


<?
require 'footer.php';
