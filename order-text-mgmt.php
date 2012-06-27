<?
require 'lib/core.php';
function datetimeUS2Time($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($hour, $minute, $second) = explode(':', $time);
  list($year, $month, $day) = explode('-', $date);
  $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
	$dateUS = date('h:i:s a', $timestamp);
	return $dateUS;
  
}


if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}
$name= $curUser['first_name'];

if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');


if($_SERVER['REQUEST_METHOD']=='POST')
{
if (isset($_POST['date'])) 
{ 
$dateday = $_POST['date1'];
$date1 = $dateday.' 00:00:01';
$date2 = $dateday.' 23:59:59';	
}
else if (isset($_POST['delivery'])) 
{ 
$datetimeday = date("Y-m-d H:i:s");
list($year,$month,$day,$h,$m,$s)=sscanf($datetimeday,"%d-%d-%d %d:%d:%d");
$s+=300;
$timestamp=mktime($h,$m,$s,$month,$day,$year);
$timeearly=date('Y-m-d H:i:s',$timestamp);
$datetimeday = $timeearly;$orderidtext = $_POST['order_id'];
$sql = "INSERT INTO text_vendor(id_text, order_id_t, text, number_phone, datetime_t,code_text) VALUES ('','$orderidtext','2','','$datetimeday','')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());

$dateday = date("Y-m-d");
$date1 = $dateday.' 00:00:01';
$date2 = $dateday.' 23:59:59';
}
}
else {
$dateday = date("Y-m-d");
$date1 = $dateday.' 00:00:01';
$date2 = $dateday.' 23:59:59';
}
		 
$template = array(
	'title' => 'Cater2.me | Order management',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Order management'=>'/dashboard/vendor-page-mgmt/'),
	'menu_selected' => 'dashboard',
	'header_resources' => '
		<script src="/template/js/custom/user-mgmt.js"></script>
		
		<link rel="stylesheet" href="/template/css/custom/tablesorter/style.css" />
		<script type="text/javascript" src="/template/js/custom/jquery.tablesorter.min.js"></script>
		<script src="/template/js/custom/jquery.ui.datepicker.js"></script>
		
		<script type="text/javascript">
		$(document).ready(function() {
			  $("#tblUsers").tablesorter();
		    }
		);
		
		$(function()
{
var date1 = $("#date1").datepicker({ dateFormat: "yy/mm/dd" });
$("#date1").datepicker();

});


		</script>
	',
	
	'grey_bar' => 'Order management'
	);

require 'header.php';
?>

<div align="left">
<form method="post">
<a href="http://cater2.me/order-text-mgmt.php">refresh the page</a> 

<table id="tblUsers" class="tablesorter"> 
<thead> 
<tr>
<th width="5%">OK</th> 
    <th width="10%">Order Status</th>
    <th width="10%">Order Time</th>
    <th width="10%">Time Vendor Text</th>
    <th width="10%">Order Id</th> 
    <th width="10%">Text Code</th> 
    <th width="10%">Vendor Name</th>  
    <th width="10%">Vendor Contact Number</th> 
	<th width="10%">Vendor Personal Contact Number</th>
	<th width="10%">Vendor Secondary Contact Number</th>
	<th width="10%">Client Name</th>
	<th width="10%">Client Contact Name</th>
	<th width="10%">Client Contact Number</th>
	<th width="10%">Client Email Address</th>
	<th width="10%">Client Address</th>
	<th width="10%">Client City</th>
<!-- 	<th width="10%">Actions</th>  -->
 
</tr> 
</thead> 
<tbody> 
<?
//date now
$datetimeday = date("Y-m-d H:i:s");
$datetimeday=time("Y-m-d H:i:s");
$datetimeday=$datetimeday;
$datetimeday=date("Y-m-d H:i:s",$datetimeday);
//$dateday = date("Y-m-d");
//$date1 = $dateday.' 00:00:01';
//$date2 = $dateday.' 23:59:59';
$text='0';

$res = mysql_query("SELECT id_vendor, name, phone_number, personal_number, order_for, order_id
FROM users, vendors, order_proposals, order_requests
WHERE id_vendor = users.vendor_id
AND id_vendor = order_proposals.vendor_id
AND order_id = id_order
AND order_status_id = 4
AND selected = 1
AND order_for between  '$date1' and  '$date2'
GROUP BY order_id, id_vendor
order by order_for desc, name
");
while($order = mysql_fetch_assoc($res))
{
$orderid=$order['order_id'];
$res2 = mysql_query("SELECT users.client_id, companies.name, first_name, phone_number, email, address, delivery_difficulty, special_delivery,  id_user, delivery_address, city
FROM order_requests, companies, clients, users, client_profiles p
WHERE order_requests.id_order =  '$orderid'
AND id_client = p.client_id
AND client_profile_id = id_profile
AND companies.id_company = clients.company_id
AND clients.id_client = order_requests.client_id
AND users.client_id = clients.id_client
ORDER BY id_user DESC 
");
$order2=mysql_fetch_row($res2);

//$order2 = mysql_fetch_assoc($res2);
$res3 = mysql_query("SELECT text, datetime_t FROM text_vendor where order_id_t= '$orderid'");
$order3 = mysql_fetch_assoc($res3);


$company=$order2['1'];
$first_name=$order2['2'];
$phone_number=$order2['3'];
$email=$order2['4'];
$address=$order2['5'];
$address2 = $order2['9'];
if ($address2 == '' ) {
$address=$order2['5'];
}
else $address=$address2;
$city=$order2['10'];
$difficulty = $order2['6'];
$special_delivery = $order2['7'];

$res4 = mysql_query("SELECT client_id, companies.name, first_name, phone_number, email
FROM companies, clients, users
WHERE companies.id_company = clients.company_id
AND users.client_id = clients.id_client
AND companies.name = '$company'
ORDER BY client_id DESC  ");
$order4 = mysql_fetch_assoc($res4);

//if ($phone_number == '' ) { 
//$first_name=$order4['first_name'];
//$email=$order4['email'];
//$phone_number = $order4['phone_number'] ;}

$vendorid=$order['id_vendor'];
$res5 = mysql_query("SELECT id_user, phone_number
FROM users
WHERE vendor_id ='$vendorid' order by id_user desc  ");
$order5 = mysql_fetch_assoc($res5);
if ($order5['phone_number'] == $order['phone_number'] ) { $phone2 = ''; } 
else { $phone2 = $order5['phone_number'] ;}



if(mysql_num_rows($res3)==0) { 
$text = '0';
$timeText2 ='';
}
else { $text = $order3['text']; 
$timeText = $order3['datetime_t'];
$timeText2=datetimeUS2Time($timeText);
}


$timeorder= $order['order_for'];
if ($difficulty == '' or $difficulty =='Easy' )
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
//order +5'
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


if ($text=='2')
{
		$status='c2me confirmed';
		$color='white';
}

else if ($datetimeday < $timeearly and  $text=='0' )
{
		$status='outstanding';
		$color='white';
}
	else if ($timeText < $timeearly and  $text=='1' )
	{
			$status='delivered early';
			$color='white';
	}
	
	else if ($datetimeday < $timeelate  and $datetimeday > $timeearly and $text=='0' )		
		{ $status ='at risk';
		$color='orange';	
		}
		
		else if ($timeText < $timeelate  and $timeText > $timeearly and $text=='1' )		
		{ $status ='delivered on time';
		$color='white';	
		}

	else if ($timeText > $timeelate and $text=='1' )		{
		$status ='delivered late';
		$color='white';
		}
		else if ($datetimeday > $timeelate and $text=='0')
		{
			$status ='late';
			$color='red';
		}
$timeorder = datetimeUS2Time($timeorder);
$timeorder2 = explode(':',$timeorder);
$timeorder3 = $timeorder2[0].':'.$timeorder2[1];
$time1 = $timeorder2[2];
$time2 =  explode(' ',$time1);
$time3 = $time2[1];
$newtimeorder = $timeorder3.' '.$time3;
$neworder = $order['order_id'];
$neworder = ((($neworder * 45)+165)/2) ;
$textCode = floor( $neworder);
 if(strlen($textCode)>4)
 { 
 $textCode = substr($textCode, -4);   }
 else  {
	 	if(strlen($textCode)==3)
	 	{ 
	 	$textCode = '1'.$textCode;}  
 		}


?>
<tr > 
    <td><form method="post" action ="">
<input type="hidden" name="order_id" value="<?=$order['order_id']?>" />
<input type="submit" name="delivery" value="OK" />
</form></td>
    <td id="name" bgcolor=<?=$color?>><?=$status?></td>
    <td id="name"><?=$newtimeorder?></td>
    <td id="name"><?=$timeText2?></td>
    <td id="name"><?=$order['order_id']?></td>
    <td id="name"><?=$textCode?></td>
	<td id="name"><?=$order['name']?></td>
    <td id="name"><?=$order['phone_number']?></td>
    <td id="name"><?=$order['personal_number']?></td>
    <td id="name"><?=$phone2?></td>
    <td id="name"><?=$company?></td>
    <td id="name"><?=$first_name?></td>
    <td id="name"><?=$phone_number?></td>
    <td id="name"><?=$email?></td>
    <td id="name"><?=$address?></td>
	<td id="name"><?=$city?></td>
	
<!-- 	<td> <INPUT type="button" value="deliver" onClick="window.alert('Hello');return(false)"></td> -->
</tr> 
<?  }?>
 

</tbody> 
</table> 
<form method="post" action =""  target="_blank">
<a href="http://cater2.me/order-text-mgmt.php">refresh the page</a><br>
See the order status for <input type="text" id="date1" name="date1" placeholder="Date Begin aaaa-mm-dd" value="" style="width:20%" /><br>
<input type="submit" name ="date" value="Submit" /></form>
<br>
</div>
</div>
<?
require 'footer.php';

?>