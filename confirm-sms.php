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



	$res = mysql_query('SELECT 1 FROM tmp_sms_confirmations WHERE order_id = '.$_GET['oid']) or die(mysql_error());
	if(mysql_num_rows($res)) notif('This order has already been confirmed.');
	
	mysql_query('REPLACE INTO tmp_sms_confirmations SET order_id = '.$_GET['oid']) or die(mysql_error());
	
	
	//get order info
	$res = mysql_query('SELECT companies.name cname, order_for, order_status_id, vendors.name vname
						FROM companies, clients, order_requests, order_proposals, vendors
						WHERE client_id = id_client
						AND company_id = id_company
						AND id_order = order_id
						AND selected
						AND id_vendor = vendor_id 
						AND id_order = '.$_GET['oid']);
	$order = @mysql_fetch_assoc($res);

sendMail($config['staff_notifications']['vendor_confirmations'], 'Text msg confirmation #'.$_GET['oid'], 'Order ID:'.$_GET['oid']."\nClient: ".$order['cname']."\nVendor: ".$order['vname']."\nWhen: ".$order['order_for']);

notif('Thank you for confirming this order.');
