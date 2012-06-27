<?
function formatdate($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($year, $month, $day) = explode('-', $date);
  $timestamp = mktime( $year ,$month, $day);
	$dateUS = date('m/d', $timestamp);
	return $month.'/'.$day;
}
//get Google Calendar ID

if($curUser['client_id'])
	$sql='SELECT gcal_id FROM calendars ca, clients cl WHERE ca.company_id = cl.company_id AND id_client = '.$curUser['client_id'];
else //employee
	$sql='SELECT gcal_id FROM calendars ca, employees em WHERE ca.company_id = em.company_id AND id_employee = '.$curUser['employee_id'];

$log = mysql_fetch_row(mysql_query($sql));

if(!$log[0]) notif('Sorry, your company\'s calendar is currently unavailable.');


$template = array(
	'title' => 'Cater2.me | Calendar',
	'menu_selected' => 'dashboard',
	'breadcrumb' => array('Home'=>'/','Dashboard'=>'/dashboard/','Calendar'=>'/home/dashboard/calendar/'),
	
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
		<script src="/template/js/custom/jquery.ui.tabs.js"></script>


		<script>
		$(function() {
			$( ".accordion" ).accordion({
				autoHeight: false,
				navigation: true,
				collapsible: true,
				active: false
			});
		});
		
		function deleteResource(res_type, id) {
			document.f.delete_resource.value=res_type;
			document.f.id_resource.value=id;
			document.f.submit();
		}
		</script>
		',
	
	'grey_bar' => 'Your Catering Calendar',
	);


require 'header.php';
?>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
	</script>

<div class="demo">
<div id="tabs">
	<ul>
<?
$client = $curUser['client_id'];
$employee = $curUser['employee_id'];

	if ($client == '0') 
	{
	$res2 = mysql_query ( "SELECT company_id
	FROM employees
	WHERE id_employee = '$employee'");
	$companyarray  = mysql_fetch_assoc($res2);
	$company = $companyarray['company_id'];
	}
	else 
	{
	$res3 = mysql_query ( "SELECT company_id
	FROM clients
	WHERE id_client = '$client'");
	$companyarray  = mysql_fetch_assoc($res3);
	$company = $companyarray['company_id'];
	}
// echo $company;

$res4 = mysql_query ( "SELECT DISTINCT  id_client 
FROM  clients , order_requests
WHERE order_requests.client_id = clients.id_client
AND  `company_id` =  '$company'");

while($clients = mysql_fetch_assoc($res4))
{
$idclient[] = $clients['id_client'];
}

$client1 = $idclient[0];
$client2 = $idclient[1];
$client3 = $idclient[2];
$client4 = $idclient[3];
$client5 = $idclient[4];
$client6 = $idclient[5];
$client7 = $idclient[6];
$client8 = $idclient[7];
$client9 = $idclient[8];
$client10 = $idclient[9];

$dateday = date("Y-m-d");

$res = mysql_query("SELECT id_vendor, name, id_order, order_for
FROM order_requests, order_proposals, vendors
WHERE  order_requests.id_order = order_proposals.order_id
AND order_requests.order_status_id =4
AND order_for >  '$dateday'
AND order_proposals.selected =1
AND order_proposals.vendor_id = vendors.id_vendor
AND (
client_id =  '$client1'
OR client_id =  '$client2' OR client_id =  '$client3' OR client_id =  '$client4' OR client_id =  '$client5' OR client_id =  '$client6' OR client_id =  '$client7' OR client_id =  '$client8' OR client_id =  '$client9' OR client_id =  '$client10'
)
ORDER BY order_for
LIMIT 0 , 5 ");




while($vendornext = mysql_fetch_assoc($res))
{
$nb ++ ;
$name_vnd= $vendornext['name'];
$vnd[] = $vendornext['id_vendor'];
$order_id[] = $vendornext ['id_order'];
$date = $vendornext ['order_for'];
$date = formatdate($date);
$day  = date('D', strtotime($date));

?> 
<li><a href="#tabs-<?=$nb?>"><?=$name_vnd?><br><?=$day.' '.$date?></a></li>
<? }
$nbend=$nb+1;?>
<li><a href="#tabs-<?=$nbend?>">Your <br>calendar </a></li>
 	</ul> 

	<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[0] '");
	if ($vnd[0] == '') {} else {
	if(mysql_num_rows($res2)==0) { ?><div id="tabs-1"> No info posted yet </div><? } else {?>
	<div id="tabs-1">
<?
$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name_popup'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic);
?>


<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo $popup2['bio_popup'];?> <br><br>

<?
$order1 = $order_id[0];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity
FROM order_proposal_items, vendor_items, popup, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND vendor_items.vendor_id = popup.id_vendor_p
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND order_proposals.order_id ='$order1'
order by  food_category, quantity DESC , menu_name, description DESC ");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	<? $lastCategory='-';
while($item = mysql_fetch_assoc($res2))
{
			
			if($lastCategory!=$item['food_category'])
			{
				$description.="<br><b>".$item['food_category']."</b><br>";
				$lastCategory=$item['food_category'];
			}
			
			$tmp='';
			$tmp.=(($item['description'])? ': '.$item['description']: '');
			$description.= '* '.$item['menu_name'].$tmp."<br>";
} echo $description;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. See below for full disclaimer.';

?>
	</div> 
</div>	</div><? } } ?>


	<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[1] '");
	if ($vnd[1] == '') {} else {
	if(mysql_num_rows($res2)==0) { ?><div id="tabs-2"> No info posted yet </div><? } else {?>
		<div id="tabs-2">
<?
$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name_popup'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic);
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo $popup2['bio_popup'];?> <br><br>

<?
$order2 = $order_id[1];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity
FROM order_proposal_items, vendor_items, popup, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND vendor_items.vendor_id = popup.id_vendor_p
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND order_proposals.order_id ='$order2'
order by  food_category, quantity DESC , menu_name, description DESC    ");


?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	<? $lastCategory1='-';
while($item = mysql_fetch_assoc($res2))
{
			
			if($lastCategory1!=$item['food_category'])
			{
				$description1.="\n<b>".$item['food_category']."</b><br>";
				$lastCategory1=$item['food_category'];
			}
			
			$tmp='';
			$tmp.=(($item['description'])? ': '.$item['description']: '');
			$description1.= '* '.$item['menu_name'].$tmp."<br>";
} echo $description1;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. See below for full disclaimer.';

?>
	</div> 
</div>	</div><? } } ?>

	
	<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[2] '");
	if ($vnd[2] == '') {} else {
	if(mysql_num_rows($res2)==0 ) { ?><div id="tabs-3"> No info posted yet </div><? } else {?>
	<div id="tabs-3">
<?
$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name_popup'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic);
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo $popup2['bio_popup'];?> <br><br>


<?
$order3 = $order_id[2];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity
FROM order_proposal_items, vendor_items, popup, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND vendor_items.vendor_id = popup.id_vendor_p
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND order_proposals.order_id ='$order3'
order by  food_category, quantity DESC , menu_name, description DESC ");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	<? $lastCategory2='-';
while($item = mysql_fetch_assoc($res2))
{
			
			if($lastCategory2!=$item['food_category'])
			{
				$description2.="\n<b>".$item['food_category']."</b><br>";
				$lastCategory2=$item['food_category'];
			}
			
			$tmp='';
			$tmp.=(($item['description'])? ': '.$item['description']: '');
			$description2.= '* '.$item['menu_name'].$tmp."<br>";
} echo $description2;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. See below for full disclaimer.';

?>
	</div> 
</div>	</div><? } } ?>

	<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[3] '");
	if ($vnd[3] == '') {} else {
	if(mysql_num_rows($res2)==0) { ?><div id="tabs-4"> No info posted yet </div><? } else {?>
	<div id="tabs-4">
<?
$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name_popup'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic);
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo $popup2['bio_popup'];?> <br><br>

<?
$order4 = $order_id[3];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity
FROM order_proposal_items, vendor_items, popup, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND vendor_items.vendor_id = popup.id_vendor_p
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND order_proposals.order_id ='$order4'
order by  food_category, quantity DESC , menu_name, description DESC ");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	<? $lastCategory3='-';
while($item = mysql_fetch_assoc($res2))
{
			
			if($lastCategory3!=$item['food_category'])
			{
				$description3.="\n<b>".$item['food_category']."</b><br>";
				$lastCategory3=$item['food_category'];
			}
			
			$tmp='';
			$tmp.=(($item['description'])? ': '.$item['description']: '');
			$description3.= '* '.$item['menu_name'].$tmp."<br>";
} echo $description3;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. See below for full disclaimer.';

?>
	</div> 
</div>	</div><? } } ?>

<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[4] '");
	if ($vnd[4] == '') {} else {
	if(mysql_num_rows($res2)==0) { ?><div id="tabs-5"> No info posted yet </div><? } else {?>
	<div id="tabs-5">
<?
$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name_popup'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic);
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo $popup2['bio_popup'];?> <br><br>

<?
$order5 = $order_id[4];
$res2 = mysql_query("
SELECT menu_name, description, label food_category
FROM order_proposal_items, vendor_items, popup, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND vendor_items.vendor_id = popup.id_vendor_p
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND order_proposals.order_id ='$order5'
order by food_categories.list_order");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	<? $lastCategory4='-';
while($item = mysql_fetch_assoc($res2))
{
			
			if($lastCategory4!=$item['food_category'])
			{
				$description4.="\n<b>".$item['food_category']."</b><br>";
				$lastCategory4=$item['food_category'];
			}
			
			$tmp='';
			$tmp.=(($item['description'])? ': '.$item['description']: '');
			$description4.= '* '.$item['menu_name'].$tmp."<br>";
} echo $description4;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. See below for full disclaimer.'; 

?>
	</div> 
</div>	</div><? } } ?>

<div id="tabs-<?=$nbend?>">
<?
$areas=array();
$res = mysql_query('SELECT label, value FROM website_editable_areas WHERE label LIKE "calendar_client_%"');
while($tmp = mysql_fetch_assoc($res)) {
	$areas[$tmp['label']]=$tmp['value'];
}

?>

<p><?=plain2Html($areas['calendar_client_top'])?></p>
<iframe src="https://www.google.com/calendar/hosted/cater2.me/embed?mode=AGENDA&amp;showTitle=0&amp;showNav=0&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=cater2.me_<?=$log[0]?>%40group.calendar.google.com&amp;color=%23060D5E&amp;ctz=America%2FLos_Angeles" style=" border-width:0 " width="100%" height="600" frameborder="0" scrolling="no"></iframe>
<p>Items have been prepared in facilities that may contain trace amounts of common allergens. See below for full disclaimer.</p>

</div>	
<!-- End div tabs -->
</div>
<!-- End demo -->
</div>

