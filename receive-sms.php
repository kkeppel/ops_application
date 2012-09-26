<?php
require_once 'lib/core.php';
function datetimeUS2Time($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($hour, $minute, $second) = explode(':', $time);
  list($year, $month, $day) = explode('-', $date);
  $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
	$dateUS = date('h:i:s a', $timestamp);
	return $dateUS;  
}


$phone = $_REQUEST['From'];
$to = $_REQUEST['To'];
$body=$_REQUEST['Body'];

//date now
$datetimeday = date("Y-m-d H:i:s");
list($year,$month,$day,$h,$m,$s)=sscanf($datetimeday,"%d-%d-%d %d:%d:%d");
$s+=300;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeearly=date('Y-m-d H:i:s',$timestamp);
$datetimeday = $timeearly;


$dateday = date("Y-m-d");
$date1 = $dateday.' 00:00:01';
$date2 = $dateday.' 23:59:59';


$hashcode = $body;
$dateday = date("Y-m-d");
$date1 = $dateday.' 00:00:01';
$date2 = $dateday.' 23:59:59';

$res = mysql_query(" SELECT id_order 
FROM order_requests, hash
WHERE order_for BETWEEN  '$date1' AND '$date2'
AND code_hash = '$hashcode'
AND order_hash = id_order" );
$tmp = mysql_fetch_assoc($res);
$order_id =  $tmp['id_order'];


$res = mysql_query("SELECT id_order,order_for, companies.name, vendors.name, delivery_difficulty, special_delivery   
FROM order_requests, clients, companies, vendors, order_proposals
	where order_requests.client_id = clients.id_client
AND clients.company_id = companies.id_company
AND order_proposals.vendor_id=vendors.id_vendor
AND order_for between  '$date1' and  '$date2'
AND order_requests.id_order='$order_id' and order_proposals.order_id ='$order_id' " );

	if(mysql_num_rows($res)==0) { ?>
	<Response>
	<Sms>
	Sorry, the code you sent is incorrect, please try again. If you don't know your code, call 415-781-5500.
	</Sms>
	</Response>
	<? } 
	else  {  while($order=mysql_fetch_row($res))
			{
			$idorder = $order['0'];
			$timeorder = $order['1'];
			$client = $order['2'];
			$vendor = $order['3'];
			$difficulty = $order['4'];
			$special_delivery = $order['5'];
			}

if ($difficulty == 'Easy' ) 
{
// order -10'
list($year,$month,$day,$h,$m,$s)=sscanf($timeorder,"%d-%d-%d %d:%d:%d");
$s-=600;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeearly=date('Y-m-d H:i:s',$timestamp);
//order +5'
list($year,$month,$day,$h,$m,$s)=sscanf($timeorder,"%d-%d-%d %d:%d:%d");
$s+=300;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeelate=date('Y-m-d H:i:s',$timestamp);
}
else if ($difficulty == 'Hard')
{
list($year,$month,$day,$h,$m,$s)=sscanf($timeorder,"%d-%d-%d %d:%d:%d");
$s-=1200;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeearly=date('Y-m-d H:i:s',$timestamp);
list($year,$month,$day,$h,$m,$s)=sscanf($timeorder,"%d-%d-%d %d:%d:%d");
$s+=300;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeelate=date('Y-m-d H:i:s',$timestamp);
}
else if ($difficulty == 'Special')
{
list($year,$month,$day,$h,$m,$s)=sscanf($timeorder,"%d-%d-%d %d:%d:%d");
$before = $special_delivery * 60;
$s-= $before;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeearly=date('Y-m-d H:i:s',$timestamp);
list($year,$month,$day,$h,$m,$s)=sscanf($timeorder,"%d-%d-%d %d:%d:%d");
$s+=300;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeelate=date('Y-m-d H:i:s',$timestamp);
}
else
{
list($year,$month,$day,$h,$m,$s)=sscanf($timeorder,"%d-%d-%d %d:%d:%d");
$s-=600;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeearly=date('Y-m-d H:i:s',$timestamp);
list($year,$month,$day,$h,$m,$s)=sscanf($timeorder,"%d-%d-%d %d:%d:%d");
$s+=300;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeelate=date('Y-m-d H:i:s',$timestamp);
}


$dateWait = datetimeUS2Time($timeearly);

	$res2 = mysql_query("SELECT  id_text  FROM text_vendor where order_id_t= '$order_id' " );
	if(mysql_num_rows($res2)!=0) {
	?> 
	<Response>
	<Sms>
	Sorry, this code has already been sent for this order. If you haven't already sent this code, please call 415-781-5500.
	</Sms>
	</Response>
	<? }
	else {
	
	$sql = "INSERT INTO text_vendor(id_text, order_id_t, text, number_phone, datetime_t, code_text) VALUES ('','$order_id','1',$phone,'$datetimeday','$body')";
	mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>

<?
if ($datetimeday < $timeearly )	
	{ ?>
	<Response>
	<Sms>
	You are too early to deliver to <? echo $client?>, please wait until <? echo $dateWait ?> to begin delivery.
	</Sms>
	</Response>
	<? 
		
	} 
	else if ($datetimeday < $timeelate  and $datetimeday > $timeearly )		
		{ ?>
		<Response>
		<Sms>
		Thanks, proceed with the delivery to <? echo $client?>.
		</Sms>
		</Response>
		<? }
			else if ($datetimeday > $timeelate )	
			{ ?>
			<Response>
			<Sms>
			Thanks, this delivery to <? echo $client?> is late, if we haven't already spoken to you, please call us immediately at 415-781-5500.
			</Sms>
			</Response>
			<?
			 }}
	}		 
?>
