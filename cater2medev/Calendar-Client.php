
<?
if($_SERVER['REQUEST_METHOD']=='POST')
{
if (isset($_POST['comment'])) 
{ 
$comment = $_POST['com_fb'];
$ordidcom =  $_POST['orderidcomment'];
$userfb = $_POST['useridcomment'];
$sql = "INSERT INTO comment_feedback(id_cfb, comment, fb_id, fb_user) VALUES ('','$comment','$ordidcom','$userfb')";
		mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());
}
if (isset($_POST['Send'])) 
{ 
	$email1= $_POST['email1'];
	$email2= $_POST['email2'];
	$name1= $_POST['name1'];
	$name2= $_POST['name2'];
	//$sql = "Update users set email='".$email."',phone_number='".$phone."', newsletter='".$news."'  WHERE id_user='".$id."'";
echo $email1.'-'.$email2.'-'.$name1.'-'.$name2;
//$sql = "INSERT INTO referral_email(id_ref, name_ref, email_ref, fr_name_ref, fr_email_ref) VALUES ('','$name1','$email1','$name2','$name2')";
//mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	

$destinataire = "info@cater2.me";
$expediteur   = "social@cater2.me";
$reponse      = $expediteur;

$codehtml=
"<html><body>" .
"<h1>Someone referre Cater2me</h1>".
"Referring Name: ".$name_r."<br>".
"Referring Email: ".$email_r."<br>".
"Referring IP Address: [".$ip."]<br>".
"Friend Name: ".$namef_r."<br>".
"Friend Email: ".$emailf_r."<br>".
   
"</body></html>";
/*
	mail($destinataire,
	     "Referral",
	     $codehtml,
	     "From: $expediteur\r\n".
	        "Reply-To: $reponse\r\n".
	        "Content-Type: text/html; charset=\"iso-8859-1\"\r\n");
*/
	}
if (isset($_POST['Update'])) 
{ 
	$email= $_POST['email'];
	$phone = $_POST['phone'];
	$id = $_POST['id'];
	$news = $_POST['news'];
	
//$sql = "Update users set email='".$email."',phone_number='".$phone."', newsletter='".$news."'  WHERE id_user='".$id."'";
echo $email.'-'.$phone.'-'.$id.'-'.$news;
	  //  mysql_query($sql);
	}
	
	
if (isset($_POST['Sub_order'])) 
{ 
	$nb = $_POST['nb_emp'];
	$order_for = $_POST['order_for'];
	$client_id = $_POST['client_id'];
	$price = $_POST['price'];
	$meal = $_POST['meal_type'];
	$notes = $_POST['notes'];
	$order_created = date('Y-m-d H:i:s');
	$request = $_POST['text_request'];
	
	// SI Request envoi de mail 
	// SI données rentrées ds formulaire -> insertion ds db ou mail ?
	
//$sql = "Update users set email='".$email."',phone_number='".$phone."', newsletter='".$news."'  WHERE id_user='".$id."'";
echo $nb.'-'.$order_for.'-'.$client_id.'-'.$price.'-'.$meal.'-'.$order_created.'-'.$request;
	  //  mysql_query($sql);
	}

		
}


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
$user =  $curUser['id_user']; 
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
		
	
	
	function validate() {

	if(document.getElementById("date1").value > document.getElementById("date2").value)
	{
	alert("Please pick a start date prior to the end date");
	return false;
	}
	if(document.getElementById("date1").value == document.getElementById("date2").value)
	{
	alert("Please pick a start date different to the end date");
	return false;
	}	
	return true;
	
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
		 
		
		table{
		border-width : 0px;
				}
		td {
		border-width : 0px;
		}
		
		</style>
		',
	
	'grey_bar' => 'Your Catering Calendar',
	
	'slider_open' => true
	);


require 'header.php';
?>
<style type="text/css">
.ui-widget-header a { color: #9C1C22 !important/*{fcHeader}*/; 
		 				}
#post-content-wrap a {
    color: #9C1C22;
    }
.ui-widget-header {
		 		border: 0px solid;				}
.ui-widget-content{
		 		border: 0px solid;				}
.ui-widget-overlay { opacity: .90;filter:Alpha(Opacity=70); }
/* Vertical Tabs
--------------------------------*/
.ui-tabs-vertical { width: 80em; }
.ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 14em; background: white; }
.ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; margin:3px; }
.ui-tabs-vertical .ui-tabs-nav li a { display:block; }
.ui-tabs-vertical .ui-tabs-nav li.ui-tabs-selected { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
.ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: left; width: 60em;}

</style> 

<script>
   $(document).ready(function() {
   $("#tabs").tabs();
     /*
  $("#tabs").tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
       $("#tabs li").removeClass('ui-corner-top').addClass('ui-corner-left');
*/
       

   });
</script>


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
And order_requests.show = 1
AND order_proposals.vendor_id = vendors.id_vendor
AND (
order_requests.client_id =  '$client1'
OR order_requests.client_id =  '$client2' OR order_requests.client_id =  '$client3' OR order_requests.client_id =  '$client4' OR order_requests.client_id =  '$client5' OR order_requests.client_id =  '$client6' OR order_requests.client_id =  '$client7' OR order_requests.client_id =  '$client8' OR order_requests.client_id =  '$client9' OR order_requests.client_id =  '$client10'
)
ORDER BY order_for
LIMIT 0 , 5 ");


while($vendornext = mysql_fetch_assoc($res))
{
$name_vndtb[]=$vendornext['vname'];
$vnd[] = $vendornext['id_vendor'];
$order_id[] = $vendornext ['id_order'];
$datetmparray[] = $vendornext ['order_for'];
$datetmp = $vendornext ['order_for'];
$date = formatdate($datetmp);
$day  = date('D', strtotime($datetmp));
$day2  = date('l', strtotime($datetmp));
$year =  date('y', strtotime($datetmp));
$timeorder10 = datetimeUS2Time($datetmp);
$timeorder20= explode(':',$timeorder10);
$timeorder30 = $timeorder20[0].':'.$timeorder20[1];
$time10 = $timeorder20[2];
$time20 =  explode(' ',$time10);
$time30 = $time20[1];
$time = $timeorder30.' '.$time30;
}
?>

<div class="demo">
<div id="tabs">
	<ul>

<!-- GERER LES DIV SELON CLIENT OU EMPLOYEE, DONC PLUS DE TAB-1 etc -->
<? if($curUser['client_id']) { ?> 
<li><a href="#tabs-1">Upcoming vendors</a></li>
<li><a href="#tabs-2">Full calendar</a></li>
<li><a href="#tabs-3">Print manager</a></li>
<li><a href="#tabs-4">Feedback</a></li>
<li><a href="#tabs-5">Referral</a></li>
<li><a href="#tabs-6">Account management</a></li>
<li><a href="#tabs-7">New order request</a></li>
<? }
else { ?>
<li><a href="#tabs-1">Upcoming vendors</a></li>
<li><a href="#tabs-2">Full calendar</a></li>
<li><a href="#tabs-5">Referral</a></li>
<? } ?>
 	</ul> 


	<?
	//if ( // employee ) {} else { client
	?> <div id="tabs-1"> <?
	//} else {
	?>
	
<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[0] '");
	if ($vnd[0] == '') {} else { ?> 	
<input type="button" name="vnd1" value="<?=$name_vndtb[0].' - '.$day.' '.$date.' - '.$time?>"
onclick="if(document.getElementById('vnd1').style.display=='none'){
document.getElementById('vnd1').style.display='block';
document.getElementById('vnd2').style.display='none';
document.getElementById('vnd3').style.display='none';
document.getElementById('vnd4').style.display='none';
document.getElementById('vnd5').style.display='none';}" />
<? } ?>

<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[1] '");
	if ($vnd[1] == '') {} else { ?> 
<input type="button" name="vnd2" value="<?=$name_vndtb[1]?>"
onclick="if(document.getElementById('vnd2').style.display=='none'){
document.getElementById('vnd2').style.display='block';
document.getElementById('vnd1').style.display='none';
document.getElementById('vnd4').style.display='none';
document.getElementById('vnd5').style.display='none';
document.getElementById('vnd3').style.display='none';}" />
<? } ?>

<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[2] '");
	if ($vnd[2] == '') {} else { ?> 
<input type="button" name="vnd3" value="<?=$name_vndtb[2]?>"
onclick="if(document.getElementById('vnd3').style.display=='none'){
document.getElementById('vnd3').style.display='block';
document.getElementById('vnd1').style.display='none';
document.getElementById('vnd4').style.display='none';
document.getElementById('vnd5').style.display='none';
document.getElementById('vnd2').style.display='none';}" />
<? } ?>

<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[3] '");
	if ($vnd[3] == '') {} else { ?> 
<input type="button" name="vnd4" value="<?=$name_vndtb[3]?>"
onclick="if(document.getElementById('vnd4').style.display=='none'){
document.getElementById('vnd4').style.display='block';
document.getElementById('vnd1').style.display='none';
document.getElementById('vnd3').style.display='none';
document.getElementById('vnd5').style.display='none';
document.getElementById('vnd2').style.display='none';}" />
<? } ?>

<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[4] '");
	if ($vnd[4] == '') {} else { ?> 
<input type="button" name="vnd5" value="<?=$name_vndtb[4]?>"
onclick="if(document.getElementById('vnd5').style.display=='none'){
document.getElementById('vnd5').style.display='block';
document.getElementById('vnd1').style.display='none';
document.getElementById('vnd4').style.display='none';
document.getElementById('vnd3').style.display='none';
document.getElementById('vnd2').style.display='none';}" />
						<? } ?>
	
	<br>	<br>
<div id="vnd1">
	<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[0]'");
	$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name_popup'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic); 
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo nl2br($popup2['bio_popup']);?> <br><br>
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
	<form method="post" action ="../../menu_client_day.php"  target="_blank">
	<input type="hidden" name="order_id" value="<?=$order1?>" />
	<input type="submit" name="menu" value="Print menu" />
	<input type="submit" name="label" value="Print labels" />
</form>

	<? $lastCategory1='-';
	$description1.='<a href="http://cater2.me/dashboard/feedback/?oid='.$order1.'">'.$name_vndtb[0].' Feedback</a>'."<br>";
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
</div>
</div>
<div id="vnd2" style="display:none">
<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[1]'");
	$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name_popup'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic); 
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo nl2br($popup2['bio_popup']);?> <br><br>
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
	<form method="post" action ="../../menu_client_day.php"  target="_blank">
	<input type="hidden" name="order_id" value="<?=$order2?>" />
	<input type="submit" name="menu" value="Print menu" />
	<input type="submit" name="label" value="Print labels" />
</form>
	<? $lastCategory2='-';
	$description2.='<a href="http://cater2.me/dashboard/feedback/?oid='.$order2.'">'.$name_vndtb[1].' Feedback</a>'."<br>";
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
</div>	

</div>


<div id="vnd3" style="display:none">
<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[2]'");
	$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name_popup'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic); 
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo nl2br($popup2['bio_popup']);?> <br><br>

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
	<form method="post" action ="../../menu_client_day.php"  target="_blank">
	<input type="hidden" name="order_id" value="<?=$order3?>" />
	<input type="submit" name="menu" value="Print menu" />
	<input type="submit" name="label" value="Print labels" />
</form>
	<? $lastCategory3='-';
	$description3.='<a href="http://cater2.me/dashboard/feedback/?oid='.$order3.'">'.$name_vndtb[2].' Feedback</a>'."<br>";
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
</div>
</div>
<div id="vnd4" style="display:none">
<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[3]'");
	$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name_popup'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic); 
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo nl2br($popup2['bio_popup']);?> <br><br>
<?
$order4 = $order_id[3];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol
FROM order_proposal_items, vendor_items, popup, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND vendor_items.vendor_id = popup.id_vendor_p
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND list_order < 19
AND id_food_category = food_category_id
AND order_proposals.order_id ='$order4'
order by  food_categories.list_order, quantity DESC , menu_name, description DESC ");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	<form method="post" action ="../../menu_client_day.php"  target="_blank">
	<input type="hidden" name="order_id" value="<?=$order4?>" />
	<input type="submit" name="menu" value="Print menu" />
	<input type="submit" name="label" value="Print labels" />
</form>
	<? $lastCategory4='-';
	$description4.='<a href="http://cater2.me/dashboard/feedback/?oid='.$order4.'">'.$name_vndtb[3].' Feedback</a>'."<br>";
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
</div>	

</div>
<div id="vnd5" style="display:none">
<? $res2 = mysql_query("SELECT * FROM popup where id_vendor_p = '$vnd[4]'");
$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name_popup'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic); 
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo nl2br($popup2['bio_popup']);?> <br><br>
<?
$order5 = $order_id[4];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol
FROM order_proposal_items, vendor_items, popup, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND vendor_items.vendor_id = popup.id_vendor_p
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND list_order < 19
AND id_food_category = food_category_id
AND order_proposals.order_id ='$order5'
order by  food_categories.list_order, quantity DESC , menu_name, description DESC ");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	<form method="post" action ="../../menu_client_day.php"  target="_blank">
	<input type="hidden" name="order_id" value="<?=$order5?>" />
	<input type="submit" name="menu" value="Print menu" />
	<input type="submit" name="label" value="Print labels" />
</form>
	<? $lastCategory5='-';
	$description5.='<a href="http://cater2.me/dashboard/feedback/?oid='.$order5.'">'.$name_vndtb[4].' Feedback</a>'."<br>";
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
		
			if($lastCategory5!=$item['food_category'])
			{
				$description5.="<br><b>".$item['food_category']."</b><br>";
				$lastCategory5=$item['food_category'];
			}
			
			$tmp='';
			$tmp.=(($item['description'])? ': '.$item['description']: '');
			$description5.= $item['menu_name'].$veg.$vegan.$tmp.'  <span style="font-size:9px; color:#990066" >'.$glu.$dai.$nut.$egg.$soy.$hon.$she.$alc."</span><br>";
			
} $description5.= 	$legend;
echo $description5;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. Click <a href="#" onclick="javascript:disclaimer(); return false;">here </a>for full disclaimer. ';
?>
	</div> 
</div>	

</div>

	
<!-- 	Tabbed javascript , voir header ou tabs jquery -->
	</div>


		<div id="tabs-2">
<? $areas=array();
$res = mysql_query('SELECT label, value FROM website_editable_areas WHERE label LIKE "calendar_client_%"');
while($tmp = mysql_fetch_assoc($res)) {
	$areas[$tmp['label']]=$tmp['value'];
}

?>

<p><?=plain2Html($areas['calendar_client_top'])?></p>
<iframe src="https://www.google.com/calendar/hosted/cater2.me/embed?mode=AGENDA&amp;showTitle=0&amp;showNav=0&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=cater2.me_<?=$log[0]?>%40group.calendar.google.com&amp;color=%23060D5E&amp;ctz=America%2FLos_Angeles" style=" border-width:0 " width="100%" height="600" frameborder="0" scrolling="no"></iframe>
<p>Click <a href='#' onclick="javascript:disclaimer(); return false;">here </a>for full disclaimer. </p>

	</div>
<? if($curUser['employee_id']) {} else {?>
	<div id="tabs-3">
<table width ="	100%">
<td width = "65%">
<center>Your next meals<br><br>
<table>
<tr>
<?

$order1= $order_id[0];
$res200 = mysql_query("SELECT * FROM vendors where id_vendor = '$vnd[0] '");
if ($vnd[0] == '') {} else { 
//$res2000 =  mysql_query("SELECT order_for FROM order_requests where order_id = '$order1'");
$popup = mysql_fetch_assoc($res200);
$name_popup= $popup['public_name'];
$dateVend = $datetmparray[0];
$date = formatdate($dateVend);
$day2  = date('l', strtotime($dateVend));
$year =  date('y', strtotime($dateVend));
$dateVend = $day2.' '.$date.'/'.$year;
?> 
<form method="post" action ="../../menu_client_day.php"  target="_blank">
<td><? echo $dateVend ?></td>
<td><? echo $name_popup ?></td>
<input type="hidden" name="order_id" value="<?=$order1?>" />
<td><input type="submit" name="menu" value="Print menu" /></td>
<td><input type="submit" name="label" value="Print labels" /></td>
</tr>
</form>
<? } ?>
</tr>
<tr>

<? 
$order2= $order_id[1];
$res200 = mysql_query("SELECT * FROM vendors where id_vendor = '$vnd[1] '");
if ($vnd[1] == '') {} else { 
$popup = mysql_fetch_assoc($res200);
$name_popup= $popup['public_name'];
$dateVend = $datetmparray[1];
$date = formatdate($dateVend);
$day2  = date('l', strtotime($dateVend));
$year =  date('y', strtotime($dateVend));
$dateVend = $day2.' '.$date.'/'.$year;
?> 
<form method="post" action ="../../menu_client_day.php"  target="_blank">
<td><? echo $dateVend ?></td>
<td><? echo $name_popup ?></td>
<input type="hidden" name="order_id" value="<?=$order2?>" />
<td><input type="submit" name="menu" value="Print menu" /></td>
<td><input type="submit" name="label" value="Print labels" /></td>
</tr>
</form>
<? } ?>
</tr>
<tr>
<? 
$order3= $order_id[2];
$res200 = mysql_query("SELECT * FROM vendors where id_vendor = '$vnd[2] '");
if ($vnd[2] == '') {} else { 
$popup = mysql_fetch_assoc($res200);
$name_popup= $popup['public_name'];
$dateVend = $datetmparray[2];
$date = formatdate($dateVend);
$day2  = date('l', strtotime($dateVend));
$year =  date('y', strtotime($dateVend));
$dateVend = $day2.' '.$date.'/'.$year;?> 
<form method="post" action ="../../menu_client_day.php"  target="_blank">
<td><? echo $dateVend ?></td>
<td><? echo $name_popup ?></td>
<input type="hidden" name="order_id" value="<?=$order3?>" />
<td><input type="submit" name="menu" value="Print menu" /></td>
<td><input type="submit" name="label" value="Print labels" /></td>
</tr>
</form>
<? } ?>
</tr>
<tr>
<? 
$order4= $order_id[3];
$res200 = mysql_query("SELECT * FROM vendors where id_vendor = '$vnd[3] '");
if ($vnd[3] == '') {} else { 
$popup = mysql_fetch_assoc($res200);
$name_popup= $popup['public_name'];
$dateVend = $datetmparray[3];
$date = formatdate($dateVend);
$day2  = date('l', strtotime($dateVend));
$year =  date('y', strtotime($dateVend));
$dateVend = $day2.' '.$date.'/'.$year;?> 
<form method="post" action ="../../menu_client_day.php"  target="_blank">
<td><? echo $dateVend ?></td>

<td><? echo $name_popup ?></td>
<input type="hidden" name="order_id" value="<?=$order4?>" />
<td><input type="submit" name="menu" value="Print menu" /></td>
<td><input type="submit" name="label" value="Print labels" /></td>
</tr>
</form>
<? } ?>
</tr>
<tr>
<? 
$order5= $order_id[4];
$res200 = mysql_query("SELECT * FROM vendors where id_vendor = '$vnd[4] '");
	if ($vnd[4] == '') {} else { 
$popup = mysql_fetch_assoc($res200);
$name_popup= $popup['public_name'];
$dateVend = $datetmparray[4];
$date = formatdate($dateVend);
$day2  = date('l', strtotime($dateVend));
$year =  date('y', strtotime($dateVend));
$dateVend = $day2.' '.$date.'/'.$year;?> 
<form method="post" action ="../../menu_client_day.php"  target="_blank">
<td><? echo $dateVend ?></td>
<td><? echo $name_popup ?></td>
<input type="hidden" name="order_id" value="<?=$order5?>" />
<td><input type="submit" name="menu" value="Print menu" /></td>
<td><input type="submit" name="label" value="Print labels" /></td>
</tr>
</form>
<? } ?>
</table>
</center>

</td>
<td width="40%">

<form method="post" action ="../../menu_client.php"  target="_blank"  onsubmit="return validate();">
<center>
Print Multiple Days <br><br>
Start date <input type="text" id="date1" name="date1" placeholder="yy-mm-dd" value=""  /><br><br>
&nbsp;&nbsp;End date <input type="text" id="date2" name="date2" placeholder="yy-mm-dd" value=""  /><br><br>
<input type="hidden" name="company_id" value="<?=$company?>" />
<input type="submit" name="menu-wk" value="Print simple menus" /><br>
<input type="submit" name="menu-dy" value="Print detailed menus" />
<!-- <input type="submit" name="label" value="Print Label Daily" /></center> -->
</form>
<!--
<p>Click <a href='#' onclick="javascript:choose_menu('<?=$company?>') ;return false;">here </a>to print your menu. </p>
-->
</td>
</table>
	</div> <? } ?>	
	<? if($curUser['employee_id']) {} else {?>
	<div id="tabs-4">
<b> Your five latest feedback history </b><br>
<? 
$resFb = mysql_query("SELECT order_feedback.order_id as orderid, food_rating, feedback_private, order_for, public_name, order_feedback.order_id, service_rating, c2me_rating, feedback_public,portioning
FROM order_feedback, vendors, order_proposals, order_requests
WHERE order_feedback.order_id = order_proposals.order_id
AND order_proposals.vendor_id = vendors.id_vendor
AND order_proposals.selected =1
AND order_feedback.order_id = order_requests.id_order
AND order_feedback.user_id =1018
Limit 0,5");

$resavg1 = mysql_query("SELECT AVG( food_rating ) as food_rating 
FROM order_feedback
WHERE user_id =1018");
$avgtmp  = mysql_fetch_assoc($resavg1);
$food_rating_avg = $avgtmp['food_rating'];

$resavg2 = mysql_query("SELECT AVG( portioning ) as portioning
FROM order_feedback
WHERE user_id =1018 ");
$avgtmp  = mysql_fetch_assoc($resavg2);
$portioning_avg = $avgtmp['portioning'];

$resavg3 = mysql_query("SELECT AVG( service_rating) as service_rating
FROM order_feedback
WHERE user_id =1018");
$avgtmp  = mysql_fetch_assoc($resavg3);
$service_rating_avg = $avgtmp['service_rating'];

$resavg4 = mysql_query("SELECT AVG( c2me_rating ) as c2me_rating
FROM order_feedback
WHERE user_id =1018");
$avgtmp  = mysql_fetch_assoc($resavg4);
$c2me_rating_avg = $avgtmp['c2me_rating'];
?>
<table>
<tr>
<td>Order ID</td><td>Order Date</td><td>Vendor</td><td>Food rating</td><td>Portionning</td><td>Service rating</td><td>c2me_rating</td><td>Feedbacks</td>
</tr>
<?
while($tmp = mysql_fetch_assoc($resFb)) {
	$order_id=$tmp['orderid'];
	$order_for=$tmp['order_for'];
	$public_name=$tmp['public_name'];
	$public_feedback=$tmp['feedback_public'];
	$food_rating=$tmp['food_rating'];
	$portioning=$tmp['portioning'];
	$service_rating=$tmp['service_rating'];
	$c2me_rating=$tmp['c2me_rating'];
	$request = $tmp['feedback_private'];
	//$order_id=$tmp['feedback_private'];
	//$order_id=$tmp['feedback_public'];
?>
<tr> 
<td><?=$order_id?></td><td><?=$order_for?></td><td><?=$public_name?></td><td><?=$food_rating?></td>
<td><?=$portioning?></td><td><?=$service_rating?></td><td><?=$c2me_rating?></td><td>
<? if ($public_feedback == '') { echo 'no feedback'; } else {?>
<a href="#" onclick="$('<div></div>').dialog({ width: 600 , position: 'top' ,modal: true,autoLoad : true}).load('/dialog_feedback.php?order=<?php echo $order_id;?>&user=<?=$userfb_id?>');">see feedbacks</a><? } ?></td>
</tr>
<? }?>
<tr> 
<td>Average</td></td><td></td><td></td><td><?=number_format($food_rating_avg,2)?></td>
<td><?=number_format($portioning_avg,2)?></td><td><?=number_format($service_rating_avg,2)?></td><td><?=number_format($c2me_rating_avg,2)?></td><td></td>
</tr>
</table>
<div class="accordion">

	<h3><a href="#">See more</a></h3>
	<div>
<? $resFb2 = mysql_query("SELECT order_feedback.order_id as orderid, food_rating, feedback_private, order_for, public_name, order_feedback.order_id, service_rating, c2me_rating, feedback_public,portioning
FROM order_feedback, vendors, order_proposals, order_requests
WHERE order_feedback.order_id = order_proposals.order_id
AND order_proposals.vendor_id = vendors.id_vendor
AND order_proposals.selected =1
AND order_feedback.order_id = order_requests.id_order
AND order_feedback.user_id =1018
Limit 5,5
");

$resavg1 = mysql_query("SELECT AVG( food_rating ) as food_rating 
FROM order_feedback
WHERE user_id =1018");
$avgtmp  = mysql_fetch_assoc($resavg1);
$food_rating_avg = $avgtmp['food_rating'];

$resavg2 = mysql_query("SELECT AVG( portioning ) as portioning
FROM order_feedback
WHERE user_id =1018 ");
$avgtmp  = mysql_fetch_assoc($resavg2);
$portioning_avg = $avgtmp['portioning'];

$resavg3 = mysql_query("SELECT AVG( service_rating) as service_rating
FROM order_feedback
WHERE user_id =1018");
$avgtmp  = mysql_fetch_assoc($resavg3);
$service_rating_avg = $avgtmp['service_rating'];

$resavg4 = mysql_query("SELECT AVG( c2me_rating ) as c2me_rating
FROM order_feedback
WHERE user_id =1018");
$avgtmp  = mysql_fetch_assoc($resavg4);
$c2me_rating_avg = $avgtmp['c2me_rating'];
?>
<table>
<tr>
<td>Order ID</td><td>Order Date</td><td>Vendor</td><td>Food rating</td><td>Portionning</td><td>Service rating</td><td>c2me_rating</td><td>Feedbacks</td>
</tr>
<?
while($tmp = mysql_fetch_assoc($resFb2)) {
	$order_id=$tmp['orderid'];
	$order_for=$tmp['order_for'];
	$public_name=$tmp['public_name'];
	$public_feedback=$tmp['feedback_public'];
	$food_rating=$tmp['food_rating'];
	$portioning=$tmp['portioning'];
	$service_rating=$tmp['service_rating'];
	$c2me_rating=$tmp['c2me_rating'];
	$request = $tmp['feedback_private'];
	//$order_id=$tmp['feedback_private'];
	//$order_id=$tmp['feedback_public'];
?>
<tr> 
<td><?=$order_id?></td><td><?=$order_for?></td><td><?=$public_name?></td><td><?=$food_rating?></td>
<td><?=$portioning?></td><td><?=$service_rating?></td><td><?=$c2me_rating?></td><td><? if ($public_feedback == '') { echo 'no feedback'; } else {?>
<a href="#" onclick="$('<div></div>').dialog({ width: 600 , position: 'top' ,modal: true,autoLoad : true}).load('/dialog_feedback.php?order=<?php echo $order_id;?>&user=<?=$userfb_id?>');">see feedbacks</a><? } ?></td>
</tr>
<? }?>
<tr> 
<td>Average</td></td><td></td><td></td><td><?=number_format($food_rating_avg,2)?></td>
<td><?=number_format($portioning_avg,2)?></td><td><?=number_format($service_rating_avg,2)?></td><td><?=number_format($c2me_rating_avg,2)?></td><td></td>
</tr>
</table>
</div></div>	

	<br>
<br>


	<b>Your five latest employee's feedback history</b> <br>
	
	<? $resFbemp = mysql_query("SELECT order_feedback.order_id AS orderid, food_rating, feedback_private, order_for, public_name, service_rating, c2me_rating, feedback_public, portioning, first_name, user_id
FROM order_feedback, vendors, order_proposals, order_requests, users, clients
WHERE order_feedback.order_id = order_proposals.order_id
AND order_proposals.vendor_id = vendors.id_vendor
AND order_proposals.selected =1
AND order_feedback.order_id = order_requests.id_order
AND order_requests.client_id = clients.id_client
AND order_feedback.user_id = users.id_user
AND company_id =247
Limit 0,5 ");
?>
<table>
<tr>
<td>Order ID</td><td>Employee</td><td>Order Date</td><td>Vendor</td><td>Food rating</td><td>Portionning</td><td>Service rating</td><td>c2me_rating</td><td>Feedbacks</td>
</tr>
<?
while($tmp = mysql_fetch_assoc($resFbemp)) {
	$order_id=$tmp['orderid'];
	$userfb_id=$tmp['user_id'];
	$name=$tmp['first_name'];
	$order_for=$tmp['order_for'];
	$public_name=$tmp['public_name'];
	$food_rating=$tmp['food_rating'];
	$public_feedback=$tmp['feedback_public'];
	$portioning=$tmp['portioning'];
	$service_rating=$tmp['service_rating'];
	$c2me_rating=$tmp['c2me_rating'];
	$request = $tmp['feedback_public'];
	//$order_id=$tmp['feedback_private'];
	//$order_id=$tmp['feedback_public'];
?>
<tr> 
<td><?=$order_id?></td><td><?=$name?></td><td><?=$order_for?></td><td><?=$public_name?></td><td><?=$food_rating?></td>
<td><?=$portioning?></td><td><?=$service_rating?></td><td><?=$c2me_rating?></td><td><? if ($public_feedback == '') { echo 'no feedback'; } else {?>
<a href="#" onclick="$('<div></div>').dialog({ width: 600 , position: 'top' ,modal: true,autoLoad : true}).load('/dialog_feedback.php?order=<?php echo $order_id;?>&user=<?=$userfb_id?>');">see feedbacks</a><? } ?></td>
</tr>
<? }?>
</table>
<div class="accordion">

	<h3><a href="#">See more</a></h3>
	
	<div>
	<? $resFbemp2 = mysql_query("SELECT order_feedback.order_id AS orderid, food_rating, feedback_private, order_for, public_name, service_rating, c2me_rating, feedback_public, portioning, first_name, user_id
FROM order_feedback, vendors, order_proposals, order_requests, users, clients
WHERE order_feedback.order_id = order_proposals.order_id
AND order_proposals.vendor_id = vendors.id_vendor
AND order_proposals.selected =1
AND order_feedback.order_id = order_requests.id_order
AND order_requests.client_id = clients.id_client
AND order_feedback.user_id = users.id_user
AND company_id =247
Limit 5,5 ");
?>
<table>
<tr>
<td>Order ID</td><td>Employee</td><td>Order Date</td><td>Vendor</td><td>Food rating</td><td>Portionning</td><td>Service rating</td><td>c2me_rating</td><td>Feedbacks</td>
</tr>
<?
while($tmp = mysql_fetch_assoc($resFbemp2)) {
	$order_id=$tmp['orderid'];
	$userfb_id=$tmp['user_id'];
	$name=$tmp['first_name'];
	$order_for=$tmp['order_for'];
	$public_name=$tmp['public_name'];
	$public_feedback=$tmp['feedback_public'];
	$food_rating=$tmp['food_rating'];
	$portioning=$tmp['portioning'];
	$service_rating=$tmp['service_rating'];
	$c2me_rating=$tmp['c2me_rating'];
	$request = $tmp['feedback_public'];
	//$order_id=$tmp['feedback_private'];
	//$order_id=$tmp['feedback_public'];
?>
<tr> 
<td><?=$order_id?></td><td><?=$name?></td><td><?=$order_for?></td><td><?=$public_name?></td><td><?=$food_rating?></td>
<td><?=$portioning?></td><td><?=$service_rating?></td><td><?=$c2me_rating?></td><td><? if ($public_feedback == '') { echo 'no feedback'; } else {?>
<a href="#" onclick="$('<div></div>').dialog({ width: 600 , position: 'top' ,modal: true,autoLoad : true}).load('/dialog_feedback.php?order=<?php echo $order_id;?>&user=<?=$userfb_id?>');">see feedbacks</a><? } ?></td>
</tr>
<? }?>
</table>

</div></div>

<?
$res20 = mysql_query("SELECT AVG( food_rating ) as avg_food , first_name, user_id
FROM order_feedback, vendors, order_proposals, order_requests, users, clients
WHERE order_feedback.order_id = order_proposals.order_id
AND order_proposals.vendor_id = vendors.id_vendor
AND order_proposals.selected =1
AND order_feedback.order_id = order_requests.id_order
AND order_requests.client_id = clients.id_client
AND order_feedback.user_id = users.id_user
AND company_id =247
GROUP BY user_id ");
$res30 = mysql_query("SELECT AVG( service_rating ) as avg_service , first_name, user_id
FROM order_feedback, vendors, order_proposals, order_requests, users, clients
WHERE order_feedback.order_id = order_proposals.order_id
AND order_proposals.vendor_id = vendors.id_vendor
AND order_proposals.selected =1
AND order_feedback.order_id = order_requests.id_order
AND order_requests.client_id = clients.id_client
AND order_feedback.user_id = users.id_user
AND company_id =247
GROUP BY user_id ");
$res40 = mysql_query("SELECT AVG( food_rating ) AS food_rating, order_feedback.order_id, public_name
FROM order_feedback, vendors, order_proposals, order_requests, users, clients
WHERE order_feedback.order_id = order_proposals.order_id
AND order_proposals.vendor_id = vendors.id_vendor
AND order_proposals.selected =1
AND order_feedback.order_id = order_requests.id_order
AND order_requests.client_id = clients.id_client
AND order_feedback.user_id = users.id_user
AND company_id =247
GROUP BY order_id");
?>


<script type="text/javascript">
    
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart);

     function drawChart() {
      
	 var data = new google.visualization.DataTable();
      data.addColumn('string', 'user');
      data.addColumn('number', 'Avg');
      data.addRows([
     <? $k=0;  
     while($tmp2 = mysql_fetch_assoc($res20)) {
	$nb_array[] = $tmp2['avg_food'];
	$name=$tmp2['first_name'];
	$nbname_array[] =  addslashes($name);  
	?>
	  ['<?=$nbname_array[$k]?>' , <?=$nb_array[$k]?>],
	 <? $k ++;
	 } ?> 
       ]);
       
       var data2 = new google.visualization.DataTable();
      data2.addColumn('string', 'user');
      data2.addColumn('number', 'Avg');
      data2.addRows([
     <? $l=0;  
     while($tmp3 = mysql_fetch_assoc($res30)) {
	$nb_array2[] = $tmp3['avg_service'];
	$name2=$tmp3['first_name'];
	$nbname_array2[] =  addslashes($name2);  
	?>
	  ['<?=$nbname_array2[$l]?>' , <?=$nb_array2[$l]?>],
	 <? $l ++;
	 } ?> 
       ]);
       
        var data3 = new google.visualization.DataTable();
      data3.addColumn('string', 'user');
      data3.addColumn('number', 'Avg');
      data3.addRows([
     <? $m=0;  
     while($tmp4 = mysql_fetch_assoc($res40)) {
	$nb_array3[] = $tmp4['food_rating'];
	$name3=$tmp4['public_name'];
	$nbname_array3[] =  addslashes($name3);  
	?>
	  ['<?=$nbname_array3[$m]?>' , <?=$nb_array3[$m]?>],
	 <? $m ++;
	 } ?> 
       ]);
       

      // Set chart options
      var options = {'title':'Avg food rating',
                     'width':1000,
                     'height':300,
                      'colors': ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6']
                     };

		var options2 = {'title':'Avg service rating',
                     'width':1000,
                     'height':300,
                      'colors': ['#BC3E07', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6']
                     };
      var options3= {'title':'Avg service rating by vendor',
                     'width':1000,
                     'height':300,
                      'colors': ['#BC1907']
                     };
               

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);
      var chart2 = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
      chart2.draw(data2, options2);
      var chart3 = new google.visualization.ColumnChart(document.getElementById('chart_div3'));
      chart3.draw(data3, options3);
    }
    
    </script>
      <div id="chart_div" style="width:400; height:300"></div>
      <div id="chart_div2" style="width:400; height:300"></div>
      <div id="chart_div3" style="width:400; height:300"></div><br>
 
 <script type="text/javascript">
    google.load('visualization', '1', {packages: ['geochart']});
 function drawVisualization() {
      var data = new google.visualization.DataTable();
      data.addRows(6);
      data.addColumn('string', 'Country');
      data.addColumn('number', 'Number Order');
      data.setValue(0, 0, 'Argentina');
      data.setValue(0, 1, 2);
      data.setValue(1, 0, 'United States');
      data.setValue(1, 1, 8);
      data.setValue(2, 0, 'Japan');
      data.setValue(2, 1, 4);
      data.setValue(3, 0, 'Italy');
      data.setValue(3, 1, 2);
      data.setValue(4, 0, 'France');
      data.setValue(4, 1, 6);
      data.setValue(5, 0, 'China');
      data.setValue(5, 1, 2);
     
        
      var geochart = new google.visualization.GeoChart(
          document.getElementById('visualization'));
      geochart.draw(data, {width: 556, height: 347});
    }
    

    google.setOnLoadCallback(drawVisualization);
  </script>
<center>
Vendor provenance
<div id="visualization"></div>
</center>
	</div>
	<? } ?>

	<div id="tabs-5">
	If you have any friends or colleagues who would benefit from our service, please let us know and we'll send you <b>$100</b> when they place their first order!<br><br>
	<form method="post" onsubmit="return checkEmailContact(document.f.emailreferral.value);">
	<table>
	</tr><td style="border:0px"><label for="email">Your friend's name:</label></td>
		<td style="border:0px"><input type="text" name="name2" placeholder="friend's name" /></td></tr>
		</tr><td style="border:0px"><label for="email">Your friend's company email :</label></td>
		<td style="border:0px"><input type="email" name="email2" placeholder="friend's company email" /></td></tr>
		</table>
		 <input type="hidden" name="name1"  value="<?=$curUser['first_name'];?>" />
 		<input type="hidden" name="email1"  value="<?=$curUser['email'];?>" />
	<center><input type="submit" name = "Send"  value="Send" /></center>
</form>
<? $resref = mysql_query("SELECT fr_email_ref, fr_name_ref
FROM referral_email
WHERE email_ref =  'pauline@cater2.me'");
?>
Your references: <br>
<table>

<?
while($tmp = mysql_fetch_assoc($resref)) {
	$name_ref=$tmp['fr_name_ref'];
	$email_ref=$tmp['fr_email_ref'];
	?>
<tr> 
<td><?=$name_ref?></td><td><?=$email_ref?></td></tr>
<? }?>
</table>

<!-- Plugin Linkedin, voir les differents choix -->
Recommend Cater2.me on LinkedIn <script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/RecommendProduct" data-company="1447110" data-product="1447110" data-counter="right"></script> <br>
Follow us on LinkedIn
<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/FollowCompany" data-id="1447110" data-counter="right"></script><br>
Share our website<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/Share" data-url="www.cater2.me" data-counter="right"></script><br>
	</div>
	
	<? if($curUser['employee_id']) {} else {?>
	<div id="tabs-6">
	Change your information <br><br>
	
<?	
$resinfo = mysql_query("select * from users where id_user = '$user'");
$info = mysql_fetch_assoc($resinfo);
$email= $info['email'];
$phone= $info['phone_number'];
$news= $info['newsletter']
?>
<div>
<form method="post" >
		<table>
		<tr>
		<td width="10%">Email </td><td><input type="text" name="email" placeholder="email" value="<?=$email?>" style="width:70%" /></td></tr>
		<tr>
		<td>Phone number </td><td> <input type="text" name="phone" placeholder="phone number" value="<?=$phone?>" style="width:70%" /></td></tr>
		<tr>
		<tr>
		<td>Sign newsletter </td><td> 
		<select name="news">
            <option value="0" 
<?php if($news == "0"){ echo 'selected = "selected"';} ?>>
<?php if($news == "0"){ echo 'no';}  else { echo 'no';} ?> </option>
 
<option value="1"
<?php if($news == "1"){ echo 'selected = "selected"';} ?>>
<?php if($news =="1"){ echo 'yes';} else { echo 'yes';} ?> </option>          
            </select>
		</td></tr>
		
		
		</table>
		 <input type="hidden" name="id"  value="<?=$user?>" />
		<p style="margin:30px; text-align:center">
		<input type="submit" name = "Update" value="Update" /></p>
</form>
	</div>
	
	</div>
	<? } ?>
	<? if($curUser['employee_id']) {} else {?>
	<div id="tabs-7">
	<form method="post" >
	<b>Tell us what do you want to eat in the future</b>
	<textarea name="text_request" style="width:90%; height:70px"></textarea><br>
	<br>
	<form method="post" >
	<b>Or Make an order request</b><br><br>
	<table>
	<tr>
		<td width="20%">Order Date </td><td><input type="text" placeholder="mm/dd/yy 00:00" name="order_for" value="" style="width:30%" /></td></tr>
		<tr>
		<td>Nb of employees </td><td> <input type="text" name="nb_emp"  value="" style="width:30%" /></td></tr>
		<tr>
		<tr>
		<td>Max Price</td><td> <input type="text" name="price"  value="" style="width:30%" /></td></tr>
		<td>Notes</td><td> <textarea name="notes" style="width:90%; height:70px"></textarea></td></tr>
		<td>Meal Type</td><td>
		<select name="meal_type">
            <option value="bkfst">Breakfast</option>
         	<option value="lunch">Lunch</option>
         	<option value="dinner">Dinner</option>
         	<option value="app">Appetizer</option>
         	<option value="event">Event</option>
            </select>
		</td></tr>
		 <input type="hidden" name="client_id"  value="<?=$client?>" />
		 
	</table>
	<input type="submit" name = "Sub_order" value="Submit" />
	
	</div>
	<? } ?>
<!-- End div tabs -->


</div>
<!-- End demo -->
</div>

