<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}
$name= $curUser['first_name'];

if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');


if($_SERVER['REQUEST_METHOD']=='POST')
{
			
}
		 
$template = array(
	'title' => 'Cater2.me | Order management',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Order management'=>'/dashboard/vendor-page-mgmt/'),
	'menu_selected' => 'dashboard',
	'header_resources' => '
		<script src="/template/js/custom/user-mgmt.js"></script>
		
		<link rel="stylesheet" href="/template/css/custom/tablesorter/style.css" />
		<script type="text/javascript" src="/template/js/custom/jquery.tablesorter.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			  $("#tblUsers").tablesorter();
		    }
		);
		</script>
	',
	
	'grey_bar' => 'Order management'
	);

require 'header.php';


?>
<div class="grid_7" id="contact-page">
<form method="post">

<table id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th width="10%">Order Status</th>
    <th width="10%">Order Id</th> 
    <th width="10%">Vendor Name</th> 
    <th width="10%">Order Time</th> 
    <th width="10%">Vendor Contact Number</th> 
	<th width="10%">Vendor Personal Contact Number</th>
	<th width="10%">Vendor Secondary Contact Number</th>
	<th width="10%">Client Name</th>
	<th width="10%">Client Contact Name</th>
	<th width="10%">Client Contact Number</th>
	<th width="10%">Client Email Address</th>
	<th width="10%">Client Address</th>
	
 
</tr> 
</thead> 
<tbody> 
<?
$date= date("Y-m-d H:i:s");
$date_test = '2012-02-09 00:00:00';
$date_test_30m = '2012-02-08 10:00:00';
$date_test_bef = '2012-01-05';
$res = mysql_query("SELECT id_vendor, name, phone_number, personal_number, order_for, order_id
FROM users, vendors, order_proposals, order_requests
WHERE id_vendor = users.vendor_id
AND id_vendor = order_proposals.vendor_id
AND order_id = id_order
AND order_for between '2012-02-05 00:00:00' and '2012-02-09 00:00:00'
GROUP BY order_id, id_vendor
order by order_for
");
while($order = mysql_fetch_assoc($res))
{
if ($order['order_for'] < $date_test )
{
	$status='outstanding';
	$color='white';
}
else if ($order['order_for'] < $date_test_30m )
{
	$status ='at risk';
	$color='orange'
}
 
else $status ='on time';
$color='white';
?>
<tr bgcolor=<?=$color?>> 
    
    <td id="name"><?=$status?></td>
    <td id="name"><?=$order['order_id']?></td>
	<td id="name"><?=$order['name']?></td>
	<td id="name"><?=$order['order_for']?></td>
    <td id="name"><?=$order['phone_number']?></td>
    <td id="name"><?=$order['personal_number']?></td>
 

</tr> 
<? } ?>
</tbody> 
</table> 


</div>
<?
require 'footer.php';

?>