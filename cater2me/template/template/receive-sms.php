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
//$phone = $_REQUEST['From'];
$to = $_REQUEST['To'];
$body=$_REQUEST['Body'];

//date now
$datetimeday = date("Y-m-d H:i:s");
$datetimeday=time("Y-m-d H:i:s");
$datetimeday=$datetimeday-600;
$datetimeday=date("Y-m-d H:i:s",$datetimeday);

$order_id = $body - 5;
$order_id = strrev($order_id);
$order_id = str_pad($order_id, 4,0, STR_PAD_RIGHT);

	$res = mysql_query("SELECT id_order,order_for, companies.name, vendors.names, delivery_difficulty   FROM order_requests, clients, companies, vendors, order_proposals
	where order_requests.client_id = clients.id_client
AND clients.company_id = companies.id_company
AND order_proposals.vendor_id=vendors.id_vendor
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
			}

if ($difficulty == '1')
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
else 
{
list($year,$month,$day,$h,$m,$s)=sscanf($timeorder,"%d-%d-%d %d:%d:%d");
$s-=1200;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeearly=date('Y-m-d H:i:s',$timestamp);
//order +5'
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
		$dest= "pbecchetti@gmail.com";
		$exp   = "popline7@hotmail.com";
		$reponse      = $exp;
		$html=
		"<html><body>" .
		"<h1>The vendor ".$vendor." is too early for the order ".$idorder." </h1>".
		"</body></html>";
		mail($dest,
		"Delivery Notification",$html,
		"From: $exp\r\n".
		"Reply-To: $reponse\r\n".
		"Content-Type: text/html; charset=\"iso-8859-1\"\r\n");
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
			$dest = "pbecchetti@gmail.com";
			$exp   = "popline7@hotmail.com";
			$reponse      = $exp;
			$html= 
			"<html><body>" .
			"<h1>The vendor ".$vendor." is too late for the order ".$idorder."  </h1>".
			"</body></html>";
			mail($dest,
			"Delivery Notification",$html,
			"From: $exp\r\n".
			"Reply-To: $reponse\r\n".
			"Content-Type: text/html; charset=\"iso-8859-1\"\r\n");
			 }}
	}		 
?>
