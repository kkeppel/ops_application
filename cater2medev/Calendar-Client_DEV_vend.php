<?
function formatdate($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($year, $month, $day) = explode('-', $date);
  $timestamp = mktime( $month, $day, $year );
	$dateUS = date('n/d', $timestamp);
	$month = date('n',$timestamp);
	return $month.'/'.$day;
}
function datetimeUS2Time($datetime)
{
  list($date, $time) = explode(' ', $datetime);
  list($hour, $minute, $second) = explode(':', $time);
  list($year, $month, $day) = explode('-', $date);
  $Arialtamp = mktime($hour, $minute, $second, $month, $day, $year);
	$dateUS = date('g:i:s a', $Arialtamp);
	return $dateUS; 
}


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
		<script src="/template/js/custom/jquery.ui.datepicker.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>

		<script>
		$(function() {
			$( ".accordion" ).accordion({
				autoHeight: false,
				navigation: true,
				collapsible: true,
				active: false
			});
		});
	
		
		function deleteResource(  res_type, id) {
			document.f.delete_resource.value=res_type;
			document.f.id_resource.value=id;
			document.f.submit();
		}
		
		function disclaimer() {
	simpleModal("/disclaimer.php",530,340);
		}
		
		function choose_menu(a) {
	simpleModal("/choose_menu.php",530,340);
		}


	$(function()
{
var date1 = $("#date1").datepicker({ dateFormat: "yy-mm-dd" });
$("#date1").datepicker();

var date2 = $("#date2").datepicker({ dateFormat: "yy-mm-dd" });
$("#date2").datepicker();
});

		</script>
		
		<style type="text/css">
		#tabs .ui-widget-header { color:green ; }
		
		table{
		border-width : 0px;
				}
		td {
		border-width : 0px;
		}
		
		</style>
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
if ($company == '273' or $company == '279')
{

$res4 = mysql_query ( "SELECT DISTINCT  id_client 
FROM  clients , order_requests
WHERE order_requests.client_id = clients.id_client
AND  `company_id` =  '$company'");

$legend = '<br><b>Allergen Key:</b> *Vegetarian, **Vegan, (G) Gluten Safe, (D) Dairy Safe, (N) Nut Safe, (E) Egg Safe, (S) Soy Safe.';

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
$client10= $idclient[9];

$dateday = date("Y-m-d");

$res = mysql_query(
"SELECT id_vendor, vendors.name as vname, id_order, order_for, client_profiles.name as cname
FROM order_requests, order_proposals, vendors, client_profiles
WHERE order_requests.id_order = order_proposals.order_id
AND client_profile_id = id_profile
AND client_profiles.client_id = order_requests.client_id
AND order_requests.order_status_id =4
AND order_for >  '$dateday'
AND order_proposals.selected =1
AND order_proposals.vendor_id = vendors.id_vendor
AND (
order_requests.client_id =  '$client1'
OR order_requests.client_id =  '$client2' OR order_requests.client_id =  '$client3' OR order_requests.client_id =  '$client4' OR order_requests.client_id =  '$client5' OR order_requests.client_id =  '$client6' OR order_requests.client_id =  '$client7' OR order_requests.client_id =  '$client8' OR order_requests.client_id =  '$client9' OR order_requests.client_id =  '$client10'
)
ORDER BY order_for
LIMIT 0 , 5 ");


while($vendornext = mysql_fetch_assoc($res))
{
$nb ++ ;
$name_vnd= $vendornext['vname'];

$profile_cl= $vendornext['cname'];
$name_vndtb[]=$vendornext['vname'];
$vnd[] = $vendornext['id_vendor'];
$order_id[] = $vendornext ['id_order'];
$datetmp = $vendornext ['order_for'];
$date = formatdate($datetmp);
$day  = date('D', strtotime($datetmp));
$timeorder10 = datetimeUS2Time($datetmp);
$timeorder20= explode(':',$timeorder10);
$timeorder30 = $timeorder20[0].':'.$timeorder20[1];
$time10 = $timeorder20[2];
$time20 =  explode(' ',$time10);
$time30 = $time20[1];
$time = $timeorder30.' '.$time30;
?> 
<li><a href="#tabs-<?=$nb?>"><?=$name_vnd?><br><?=$day.' '.$date?><br><?=$time?></a></li>
<? }
$nbend=$nb+1;
$nbend2=$nb+2;
$nbend3=$nb+3;?>


<li><a href="#tabs-<?=$nbend?>"><br>Your <br>calendar </a></li>
<li><a href="#tabs-<?=$nbend2?>">Print menus,<br> labels and <br>schedule </a></li> 
<li><a href="#tabs-<?=$nbend3?>"><br><br>Chart</a></li> 
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
<? echo nl2br(htmlentities($popup2['bio_popup']));?> <br><br>

<?
$order1 = $order_id[0];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol
FROM order_proposal_items, vendor_items, popup, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND vendor_items.vendor_id = popup.id_vendor_p
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND list_order < 19
AND order_proposals.order_id ='$order1'
order by food_categories.list_order, quantity DESC , menu_name, description DESC ");
?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	<? $lastCategory='-';
	$description.='<a href="http://cater2.me/dashboard/feedback/?oid='.$order1.'" target="_blank">'.$name_vndtb[0].' Feedback</a>'."<br>";
	
while($item = mysql_fetch_assoc($res2))
{

		$veg = '';
		$glu= '';
		$dai= '';
		$vegan= '';
		$nut= '';
		$egg= '';
		$soy= '';
		$hon= '';
		$she= '';
		$alc= '';

		if ($item['vegetarian']=='1')
		{ $veg = '*';}	
		if ($item['gluten_safe']=='1')
		{ $glu = '(G)';}	
		if ($item['dairy_safe']=='1')
		{ $dai = '(D)';}	
		if ($item['vegetarian'] =='1' && $item['dairy_safe']=='1' && $item['egg_safe']=='1')
		{ $vegan = '*';}
		if ($item['nut_safe']=='1')
		{ $nut = '(N)';}	
		if ($item['egg_safe']=='1')
		{ $egg = '(E)';}	
		if ($item['soy_safe']=='1')
		{ $soy = '(S)';}	
		if ($item['contains_honey']=='1')
		{ $hon = '(Contains honey)';}
		if ($item['contains_shellfish']=='1')
		{ $she = '(Contains shellfish)';}
		if ($item['contains_alcohol']=='1')
		{ $alc = '(Contains alcohol)';}
				
			if($lastCategory!=$item['food_category'])
			{
				$description.="<br><b>".$item['food_category']."</b><br>";
				$lastCategory=$item['food_category'];
			}
			
			$tmp='';
			$tmp.=(($item['description'])? ': '.$item['description']: '');
			$description.= $item['menu_name'].$veg.$vegan.$tmp.'  <span style="font-size:9px; color:#990066" >'.$glu.$dai.$nut.$egg.$soy.$hon.$she.$alc."</span><br>";			
		
} $description.= 	$legend;
echo $description;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. Click <a href="#" onclick="javascript:disclaimer(); return false;">here </a>for full disclaimer. ';
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
<? echo nl2br(htmlentities($popup2['bio_popup']));?> <br><br>

<?
$order2 = $order_id[1];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol
FROM order_proposal_items, vendor_items, popup, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND vendor_items.vendor_id = popup.id_vendor_p
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND list_order < 19
AND id_food_category = food_category_id
AND order_proposals.order_id ='$order2'
order by  food_categories.list_order, quantity DESC , menu_name, description DESC ");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	<? $lastCategory1='-';
	$description1.='<a href="http://cater2.me/dashboard/feedback/?oid='.$order2.'">'.$name_vndtb[1].' Feedback</a>'."<br>";
while($item = mysql_fetch_assoc($res2))
{
		$veg = '';
		$glu= '';
		$dai= '';
		$vegan= '';
		$nut= '';
		$egg= '';
		$soy= '';
		$hon= '';
		$she= '';
		$alc= '';

		if ($item['vegetarian']=='1')
		{ $veg = '*';}	
		if ($item['gluten_safe']=='1')
		{ $glu = '(G)';}	
		if ($item['dairy_safe']=='1')
		{ $dai = '(D)';}	
		if ($item['vegetarian'] =='1' && $item['dairy_safe']=='1' && $item['egg_safe']=='1')
		{ $vegan = '*';}
		if ($item['nut_safe']=='1')
		{ $nut = '(N)';}	
		if ($item['egg_safe']=='1')
		{ $egg = '(E)';}	
		if ($item['soy_safe']=='1')
		{ $soy = '(S)';}	
		if ($item['contains_honey']=='1')
		{ $hon = '(Contains honey)';}
		if ($item['contains_shellfish']=='1')
		{ $she = '(Contains shellfish)';}
		if ($item['contains_alcohol']=='1')
		{ $alc = '(Contains alcohol)';}
		
			if($lastCategory1!=$item['food_category'])
			{
				$description1.="<br><b>".$item['food_category']."</b><br>";
				$lastCategory1=$item['food_category'];
			}
			
			$tmp='';
			$tmp.=(($item['description'])? ': '.$item['description']: '');
			$description1.= $item['menu_name'].$veg.$vegan.$tmp.'  <span style="font-size:9px; color:#990066" >'.$glu.$dai.$nut.$egg.$soy.$hon.$she.$alc."</span><br>";
			
} $description1.= 	$legend;
echo $description1;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. Click <a href="#" onclick="javascript:disclaimer(); return false;">here </a>for full disclaimer. ';


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
<? echo nl2br(htmlentities($popup2['bio_popup']));?> <br><br>


<?
$order3 = $order_id[2];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol
FROM order_proposal_items, vendor_items, popup, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND vendor_items.vendor_id = popup.id_vendor_p
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND list_order < 19
AND order_proposals.order_id ='$order3'
order by  food_categories.list_order, quantity DESC , menu_name, description DESC ");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	<? $lastCategory2='-';
	$description2.='<a href="http://cater2.me/dashboard/feedback/?oid='.$order3.'">'.$name_vndtb[2].' Feedback</a>'."<br>";
while($item = mysql_fetch_assoc($res2))
{
				$veg = '';
		$glu= '';
		$dai= '';
		$vegan= '';
		$nut= '';
		$egg= '';
		$soy= '';
		$hon= '';
		$she= '';
		$alc= '';

		if ($item['vegetarian']=='1')
		{ $veg = '*';}	
		if ($item['gluten_safe']=='1')
		{ $glu = '(G)';}	
		if ($item['dairy_safe']=='1')
		{ $dai = '(D)';}	
		if ($item['vegetarian'] =='1' && $item['dairy_safe']=='1' && $item['egg_safe']=='1')
		{ $vegan = '*';}
		if ($item['nut_safe']=='1')
		{ $nut = '(N)';}	
		if ($item['egg_safe']=='1')
		{ $egg = '(E)';}	
		if ($item['soy_safe']=='1')
		{ $soy = '(S)';}	
		if ($item['contains_honey']=='1')
		{ $hon = '(Contains honey)';}
		if ($item['contains_shellfish']=='1')
		{ $she = '(Contains shellfish)';}
		if ($item['contains_alcohol']=='1')
		{ $alc = '(Contains alcohol)';}
		
			if($lastCategory2!=$item['food_category'])
			{
				$description2.="<br><b>".$item['food_category']."</b><br>";
				$lastCategory2=$item['food_category'];
			}
			
			$tmp='';
			$tmp.=(($item['description'])? ': '.$item['description']: '');
			$description2.= $item['menu_name'].$veg.$vegan.$tmp.'  <span style="font-size:9px; color:#990066" >'.$glu.$dai.$nut.$egg.$soy.$hon.$she.$alc."</span><br>";
								
} $description2.= 	$legend;
echo $description2;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. Click <a href="#" onclick="javascript:disclaimer(); return false;">here </a>for full disclaimer. ';

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
<? echo nl2br(htmlentities($popup2['bio_popup']));?> <br><br>

<?
$order4 = $order_id[3];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol
FROM order_proposal_items, vendor_items, popup, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND vendor_items.vendor_id = popup.id_vendor_p
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND list_order < 19
AND order_proposals.order_id ='$order4'
order by  food_categories.list_order, quantity DESC , menu_name, description DESC ");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	<? $lastCategory3='-';
	$description3.='<a href="http://cater2.me/dashboard/feedback/?oid='.$order4.'">'.$name_vndtb[3].' Feedback</a>'."<br>";
while($item = mysql_fetch_assoc($res2))
{
				$veg = '';
		$glu= '';
		$dai= '';
		$vegan= '';
		$nut= '';
		$egg= '';
		$soy= '';
		$hon= '';
		$she= '';
		$alc= '';

		if ($item['vegetarian']=='1')
		{ $veg = '*';}	
		if ($item['gluten_safe']=='1')
		{ $glu = '(G)';}	
		if ($item['dairy_safe']=='1')
		{ $dai = '(D)';}	
		if ($item['vegetarian'] =='1' && $item['dairy_safe']=='1' && $item['egg_safe']=='1')
		{ $vegan = '*';}
		if ($item['nut_safe']=='1')
		{ $nut = '(N)';}	
		if ($item['egg_safe']=='1')
		{ $egg = '(E)';}	
		if ($item['soy_safe']=='1')
		{ $soy = '(S)';}	
		if ($item['contains_honey']=='1')
		{ $hon = '(Contains honey)';}
		if ($item['contains_shellfish']=='1')
		{ $she = '(Contains shellfish)';}
		if ($item['contains_alcohol']=='1')
		{ $alc = '(Contains alcohol)';}
		
			if($lastCategory3!=$item['food_category'])
			{
				$description3.="<br><b>".$item['food_category']."</b><br>";
				$lastCategory3=$item['food_category'];
			}
			
			$tmp='';
			$tmp.=(($item['description'])? ': '.$item['description']: '');
			$description3.= $item['menu_name'].$veg.$vegan.$tmp.'  <span style="font-size:9px; color:#990066" >'.$glu.$dai.$nut.$egg.$soy.$hon.$she.$alc."</span><br>";
								
} $description3.= 	$legend;
echo $description3;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. Click <a href="#" onclick="javascript:disclaimer(); return false;">here </a>for full disclaimer. ';


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
<? echo nl2br(htmlentities($popup2['bio_popup']));?> <br><br>

<?
$order5 = $order_id[4];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol
FROM order_proposal_items, vendor_items, popup, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND vendor_items.vendor_id = popup.id_vendor_p
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND list_order < 19
AND order_proposals.order_id ='$order5'
order by  food_categories.list_order, quantity DESC , menu_name, description DESC ");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	<? $lastCategory4='-';
	$description4.='<a href="http://cater2.me/dashboard/feedback/?oid='.$order5.'">'.$name_vndtb[4].' Feedback</a>'."<br>";
while($item = mysql_fetch_assoc($res2))
{
		$veg = '';
		$glu= '';
		$dai= '';
		$vegan= '';
		$nut= '';
		$egg= '';
		$soy= '';
		$hon= '';
		$she= '';
		$alc= '';

		if ($item['vegetarian']=='1')
		{ $veg = '*';}	
		if ($item['gluten_safe']=='1')
		{ $glu = '(G)';}	
		if ($item['dairy_safe']=='1')
		{ $dai = '(D)';}	
		if ($item['vegetarian'] =='1' && $item['dairy_safe']=='1' && $item['egg_safe']=='1')
		{ $vegan = '*';}
		if ($item['nut_safe']=='1')
		{ $nut = '(N)';}	
		if ($item['egg_safe']=='1')
		{ $egg = '(E)';}	
		if ($item['soy_safe']=='1')
		{ $soy = '(S)';}	
		if ($item['contains_honey']=='1')
		{ $hon = '(Contains honey)';}
		if ($item['contains_shellfish']=='1')
		{ $she = '(Contains shellfish)';}
		if ($item['contains_alcohol']=='1')
		{ $alc = '(Contains alcohol)';}
		
			if($lastCategory4!=$item['food_category'])
			{
				$description4.="<br><b>".$item['food_category']."</b><br>";
				$lastCategory4=$item['food_category'];
			}
			
			$tmp='';
			$tmp.=(($item['description'])? ': '.$item['description']: '');
			$description4.= $item['menu_name'].$veg.$vegan.$tmp.'  <span style="font-size:9px; color:#990066" >'.$glu.$dai.$nut.$egg.$soy.$hon.$she.$alc."</span><br>";
					
} $description4.= 	$legend;
echo $description4;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. Click <a href="#" onclick="javascript:disclaimer(); return false;">here </a>for full disclaimer. ';


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
<p>Click <a href='#' onclick="javascript:disclaimer(); return false;">here </a>for full disclaimer. </p>
</div>	

<div id="tabs-<?=$nbend2?>">
<table>
<td width = 60%>

<? 
$order1= $order_id[0];
$res200 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[0] '");
$popup = mysql_fetch_assoc($res200);
$name_popup= $popup['name_popup'];

?> 
<form method="post" target="_blank">
<? echo $name_popup ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Print Menu" OnClick="window.open('../../menu-pdf.php?a=<?=$order1?>')">
<input type="button" value="Print Labels" OnClick="window.open('../../label-pdf.php?a=<?=$order1?>')">
</form>


</td>
<td>

<form method="post" action ="../../menu_client.php"  target="_blank">
<center>
Pick a date and print <br><br>
<input type="text" id="date1" name="date1" placeholder="Date Begin aaaa-mm-dd" value="" style="width:35%" /><br><br>
<input type="text" id="date2" name="date2" placeholder="Date End aaaa-mm-dd" value="" style="width:35%" /><br><br>
<input type="hidden" name="company_id" value="<?=$company?>" style="width:20%" /><br><br>
<input type="submit" name="menu-wk" value="Print Menu Weekly" />
<input type="submit" name="menu-dy" value="Print Menu Daily" />
<input type="submit" name="label" value="Print Label Daily" /></center>
</form>
<!--
<p>Click <a href='#' onclick="javascript:choose_menu('<?=$company?>') ;return false;">here </a>to print your menu. </p>
-->
</td>
</table>

</div>	
<div id="tabs-<?=$nbend3?>">
 chart
</div>	
<!-- End div tabs -->
<? } 
else { 
?>

<li><a href="#tabs-1">Your <br>calendar </a></li>
<li><a href="#tabs-2">Print menus, labels and schedule</a></li>
<li><a href="#tabs-3"><br>Chart</a></li>
 	</ul> 

<div id="tabs-1">
<?
$areas=array();
$res = mysql_query('SELECT label, value FROM website_editable_areas WHERE label LIKE "calendar_client_%"');
while($tmp = mysql_fetch_assoc($res)) {
	$areas[$tmp['label']]=$tmp['value'];
}

?>

<p><?=plain2Html($areas['calendar_client_top'])?></p>
<iframe src="https://www.google.com/calendar/hosted/cater2.me/embed?mode=AGENDA&amp;showTitle=0&amp;showNav=0&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=cater2.me_<?=$log[0]?>%40group.calendar.google.com&amp;color=%23060D5E&amp;ctz=America%2FLos_Angeles" style=" border-width:0 " width="100%" height="600" frameborder="0" scrolling="no"></iframe>
<p>Click <a href='#' onclick="javascript:disclaimer(); return false;">here </a>for full disclaimer. </p>


</div>	
<div id="tabs-2">
<form method="post" action ="../../menu_client.php"  target="_blank">
<center>

<input type="text" id="date1" name="date1" placeholder="Date Begin aaaa-mm-dd" value="" style="width:20%" /><br><br>
<input type="text" id="date2" name="date2" placeholder="Date End aaaa-mm-dd" value="" style="width:20%" /><br><br>
<input type="hidden" name="company_id" value="<?=$company?>" style="width:20%" /><br><br>
<input type="submit" name="menu-wk" value="Print Menu Weekly" />
<input type="submit" name="menu-dy" value="Print Menu Daily" />
<input type="submit" name="label" value="Print Label Daily" /></center>
</form>
<!--
<p>Click <a href='#' onclick="javascript:choose_menu('<?=$company?>') ;return false;">here </a>to print your menu. </p>
-->


</div>	
<div id="tabs-3">
<?
for ($i=1; $i<13; $i++)
{
$date1 = '2012-'.$i.'-01 00:00:00' ;
$date2 = '2012-'.$i.'-31 23:59:59';
 $res10 = mysql_query("SELECT count(id_order) as nb FROM order_requests WHERE client_id = '$client' and order_for between '$date1' and '$date2' ");
while($tmp = mysql_fetch_assoc($res10)) {
	//$areas[$tmp['label']]=$tmp['value'];
	$nb_month = $tmp['nb'];
	$nb_array[] = $nb_month;
	}
}  

$res20 = mysql_query("SELECT COUNT( vendor_id ) as nb_vnd , id_order, vendor_id, order_for, name
FROM order_requests, order_proposals, vendors
WHERE client_id =  '$client'
AND id_order = order_id
AND selected =1
AND vendor_id = id_vendor
and order_for between '2012-01-01 00:00:00' and '2012-12-31 23:59:59'
GROUP BY vendor_id ");

	
	?>

 <script type="text/javascript">
    
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart);

     function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Month');
      data.addColumn('number', 'Number orders');
      data.addRows([
        ['January', <?=$nb_array[0]?>],
        ['February',<?=$nb_array[1]?>],
        ['March', <?=$nb_array[2]?>], 
        ['April', <?=$nb_array[3]?>],
        ['May',<?=$nb_array[4]?>],
        ['June',<?=$nb_array[5]?>],
        ['July',<?=$nb_array[6]?>],
        ['August',<?=$nb_array[7]?>],
        ['September',<?=$nb_array[8]?>],
		['October',<?=$nb_array[9]?>],
		['November',<?=$nb_array[10]?>],
		['December',<?=$nb_array[11]?>],
      ]);
      
       var data2 = new google.visualization.DataTable();
      data2.addColumn('string', 'Month');
      data2.addColumn('number', 'Number orders');
      data2.addRows([
        ['Jan', <?=$nb_array[0]?>],
        ['Feb',<?=$nb_array[1]?>],
        ['March', <?=$nb_array[2]?>], 
        ['April', <?=$nb_array[3]?>],
        ['May',<?=$nb_array[4]?>],
        ['June',<?=$nb_array[5]?>],
        ['July',<?=$nb_array[6]?>],
        ['August',<?=$nb_array[7]?>],
        ['Sept',<?=$nb_array[8]?>],
		['Oct',<?=$nb_array[9]?>],
		['Nov',<?=$nb_array[10]?>],
		['Dec',<?=$nb_array[11]?>],
      ]);

	 var data3 = new google.visualization.DataTable();
      data3.addColumn('string', 'Month');
      data3.addColumn('number', 'Number orders');
      data3.addRows([
     <? $k=0;  
     while($tmp2 = mysql_fetch_assoc($res20)) {
	$nbvnd_array[] = $tmp2['nb_vnd'];
	 
	$name=$tmp2['name'];
	$nbname_array[] =  addslashes($name);  
	?>
	  ['<?=$nbname_array[$k]?>' , <?=$nbvnd_array[$k]?>],
	 <? $k ++;
	 } ?> 
       ]);

      // Set chart options
      var options = {'title':'Order in 2012',
                     'width':400,
                     'height':300,
                      'colors': ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6']
                     };
      var options2 = {'title':'Order in 2012',
                     'width':800,
                     'height':300};
      var options3 = {'title':'Vendor average 2012',
                     'width':800,
                     'height':300};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);
      var chart2 = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
      chart2.draw(data2, options2);
      var chart3 = new google.visualization.ColumnChart(document.getElementById('chart_div3'));
      chart3.draw(data3, options3);
      
    }
    
    </script>
      <div id="chart_div" style="width:400; height:300"></div>
      <div id="chart_div2" style="width:400; height:300"></div>
      <div id="chart_div3" style="width:400; height:300"></div>
</div>	
<? } ?>

</div>
<!-- End demo -->
</div>

