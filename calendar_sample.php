<?
require 'lib/core.php';
if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');
	
$send = 0;
$textreferral = "Know a friend or colleague that would benefit from our service?<br>
		  Invite them! And you'll both receive $50!";
if($_SERVER['REQUEST_METHOD']=='POST')
{

if (isset($_POST['Send'])) 
{ 
	$email1= $_POST['email1'];
	$email2= $_POST['email2'];
	$name1= $_POST['name1'];
	$name2= $_POST['name2'];
	$company = $_POST['company'];
	$ip=$_SERVER['REMOTE_ADDR'];
	$date = date("Y-m-d H:i:s");
$sql = "INSERT INTO referral_email(id_ref, name_ref, email_ref, fr_name_ref, fr_email_ref, company_ref, ip_address, page, date) VALUES ('','$name1','$email1','$name2','$email2','$company','$ip', 'Calendar Client Referral', '$date')";mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	

	$send = 1;

sendMail($config['staff_notifications']['default'],'Referral E-mail from dashboard Client Page','E-mail: '.$_POST['email2']."\nName: ".$_POST['name2']."\nCompany: ".$_POST['company']."\nFrom: ".$curUser['username'].' ('.$curUser['first_name'].' '.$curUser['last_name'].")\nIP: ".$_SERVER['REMOTE_ADDR']);

	}
if (isset($_POST['choiceC'])) 
{ 
$company = ($_POST['company']);	
}		
}
else $company ='177';


function formatdate($datetime)
{
   $day = date("d", strtotime($datetime));
  $month =  date("n", strtotime($datetime));
	return $month.'/'.$day;;
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




$template = array(
	'title' => 'Cater2.me | Calendar',
	'menu_selected' => 'dashboard',
	'breadcrumb' => array('Home'=>'/','Dashboard'=>'/dashboard/','Calendar'=>'/home/dashboard/calendar/'),
	
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>
		

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
		
		<script src="/template/js/custom/jquery.ui.tabs.js"></script>
		<script src="/template/js/custom/jquery.cookie.js"></script>

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
	
		
		function disclaimer() {
	simpleModal("/disclaimer.php",530,340);
		}
		function thanks_referral() {
	simpleModal("/thanks_referral.php",330,130);
		}

		
	function validaterefer() {

	if(document.getElementById("email2").value =="")
	{
	alert("Please enter an email address");
	return false;
	}
	if(!validateEmail(document.getElementById("email2").value))
	{
	alert("Please enter a valid email address");
	return false;
	}

	return true;	
	}
	
	function validateEmail(elementValue)

	{
	var reg = new RegExp("^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$", "i");
	return(reg.test(elementValue));
	}

	
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

.ui-widget-header a { 

/* color: #9C1C22 !important/*{fcHeader}*/;  */
color: #9C1C22 !important/*{fcHeader}*/; 
/* couleur tab  */
/*  background: #9C1C22;  */
		 	}
#ref .td{
		valign : center;
		padding-left:30px;
		padding-top:2px;
}		 	
		 				
#post-content-wrap a {
/* text color */
/*    color: white; */
    color: #000000;
/* 	bords arrondis */

/* 	-moz-border-radius: 0px; */
/* 	-webkit-border-radius: 3px; */
    }

#post-content-wrap a:hover{
    color: #458ab3;
    }
#main-nav a {
   color:#000 !important;
}
div#frame {
margin-top: 15px;
margin-left: 10px;
} 
div#frame2 {
margin-top: 290px;
margin-left: 90px;
position: absolute;
} 
div#frame1 {
margin-top: 150px;
margin-left: 90px;
position: absolute;
line-height:30px;
} 

div#fb{
margin-top: 300px;
margin-left: 600px;
position: absolute;
}
  
.ui-corner-all, .ui-corner-top, .ui-corner-left, .ui-corner-tl { -moz-border-radius-topleft: 0px; -webkit-border-top-left-radius: 0px; -khtml-border-top-left-radius: 0px; border-top-left-radius: 0px; }
.ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr { -moz-border-radius-topright: 0px; -webkit-border-top-right-radius: 0px; -khtml-border-top-right-radius: 0px; border-top-right-radius: 0px; }
.ui-corner-all, .ui-corner-bottom, .ui-corner-left, .ui-corner-bl { -moz-border-radius-bottomleft: 0px; -webkit-border-bottom-left-radius: 0px; -khtml-border-bottom-left-radius: 0px; border-bottom-left-radius: 0px; }
.ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br { -moz-border-radius-bottomright: 0px; -webkit-border-bottom-right-radius: 0px; -khtml-border-bottom-right-radius: 0px; border-bottom-right-radius: 0px; }
/* changer couleur texte contenu   .ui-tabs-panel{    } */
    
.ui-widget-header {
/* tab derriere */
		 	border: 0px solid;	
			background: white;
/* 	background: #9C1C22; */
		 		}


 		
.ui-widget-overlay { opacity: .90;filter:Alpha(Opacity=70); }
.ui-widget { font-family: Verdana,Arial,sans-serif; font-size: 1.1em; }
.ui-widget .ui-widget { font-size: 1em; }
.ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button { font-family: Verdana,Arial,sans-serif; font-size: 1em; }
.ui-widget-content { border: 1px solid #ffffff; background: #ffffff url(images/ui-bg_flat_75_ffffff_40x100.png) 50% 50% repeat-x; color: #000000; }
.ui-widget-content a { color: #000000; }
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { border: 1px solid #ffffff; background: #96bade url(images/ui-bg_flat_75_96bade_40x100.png) 50% 50% repeat-x; font-weight: normal; color: black; }
.ui-widget-header { border: 1px solid #ffffff; background: #ffffff url(images/ui-bg_flat_0_ffffff_40x100.png) 50% 50% repeat-x; color: #a12926; font-weight: bold;
border-bottom-color: black; }
.ui-widget-header a { color: #a12926; }
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { border: 1px solid #ffffff; background: #C0E6EF url(images/ui-bg_flat_75_a1effc_40x100.png) 50% 50% repeat-x; font-weight: normal; color: black; }
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active { border: 0px solid #bfbfbf; background: #bfbfbf url(images/ui-bg_flat_65_bfbfbf_40x100.png) 50% 50% repeat-x; font-weight: normal; color: #bfbfbf; }

/* Custom tabs vendors */
.custom .ui-widget-header { border: 0px solid white; background: white url(images/ui-bg_flat_0_ffffff_40x100.png) 50% 50% repeat-x; color: #a12926; font-weight: bold; }
.custom .ui-widget-header a{ border: 1px solid white; background: white url(images/ui-bg_flat_0_ffffff_40x100.png) 50% 50% repeat-x; color: #a12926;  
/* border-top: 1px solid black; border-bottom: 1px solid black; */
}
/* Color border tab title */
.custom .ui-state-default, .custom .ui-widget-content .ui-state-default, .custom .ui-widget-header .ui-state-default{ border: 1px solid white; }
.custom .ui-state-active, .custom .ui-widget-content .ui-state-active, .custom .ui-widget-header .ui-state-active { border-top: 1px solid #bfbfbf;border-bottom: 1px solid #bfbfbf;}

/*
.custom .ui-state-hover, .custom .ui-widget-content .ui-state-hover, .custom .ui-widget-header .ui-state-hover, .custom .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { border: 1px solid #999999; background: #eab3b3 url(images/ui-bg_glass_75_eab3b3_1x400.png) 50% 50% repeat-x; font-weight: normal; color: #2941b3; }
.custom .ui-state-hover a, .custom .ui-state-hover a:hover { color: #2941b3; text-decoration: none; }

*/

.candybox {
background: #FEFEFF url(/static/images/shadow_gradient.gif) bottom repeat-x;
border: 3px solid #807e7f;
padding: 10px 20px 20px 20px;
margin: 0 0 2em 0;
margin-left: 14px;
margin-top: 20px;
}

.candybox {
border-radius: 5px;
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
box-shadow: 0 1px 1px #dfdfdf;
-webkit-box-shadow: 0 1px 1px #dfdfdf;
-moz-box-shadow: 0 1px 1px #dfdfdf;
}


</style> 

<script>
var date = new Date();
 date.setTime(date.getTime() + (10 * 60 * 1000));
   $(document).ready(function() {
 $( "#tabs" ).tabs({
			cookie: {
				// store cookie for a day, without, it would be a session cookie
				expires: date
			}
		});
  
    $("#tabs_vnd").tabs();
     /*
  $("#tabs").tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
       $("#tabs li").removeClass('ui-corner-top').addClass('ui-corner-left');
*/
  });
 
</script>

<form method="post" action ="">
Choose a company to display the calendar  
<? $select_companies = '<select name = "company"><option value="">-- company --</option>';
$res = mysql_query('SELECT id_company, name FROM companies order by name');
while($log = mysql_fetch_assoc($res)) {
	$select_companies.='<option value="'.$log['id_company'].'">'.$log['id_company'].' - '.$log['name'].'</option>';
}
$select_companies.= '<select>'
		?>
		<?= $select_companies ?>
		<input type="submit" value="Submit" name = "choiceC" />
</form>

<?
$sql="SELECT gcal_id FROM calendars ca WHERE ca.company_id = '$company'";
$log = mysql_fetch_row(mysql_query($sql));
$res2 = "SELECT name FROM companies where id_company = '$company'";
$log2 = mysql_fetch_assoc(mysql_query($res2));
$com_name= $log2['name'];
echo 'Calendar for company: '.$com_name;

/* if(!$log[0]) notif('Sorry, your company\'s calendar is currently unavailable.'); */


if($send ==1)
{

$textreferral = "Thank You!<br> We'll let you know when they sign up!";

}



	
$res4 = mysql_query ( "SELECT DISTINCT  id_client 
FROM  clients , order_requests
WHERE order_requests.client_id = clients.id_client
AND  `company_id` =  '$company'");

$res40 = mysql_query ( "SELECT print
FROM  calendar_version
WHERE id_company_v =  '$company'");
$printarray  = mysql_fetch_assoc($res40);
$print = $printarray['print'];

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
"SELECT id_vendor, vendors.public_name as vname, id_order, order_for, client_profiles.name as cname
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

if ($vnd[0] == ''){$tab1 = "Check back soon!"; }
else {
$tab1 = "Upcoming 5 meals"; }

?>

<br>
<div class="demo">
<div id="tabs">
	<ul>
<!-- GERER LES DIV SELON CLIENT OU EMPLOYEE, DONC PLUS DE TAB-1 etc -->
<li><a href="#tabs-1"><?=$tab1?></a></li>
<li><a href="#tabs-2">Full calendar</a></li>
<li><a href="#tabs-3">Print manager</a></li> 
<li><a href="#tabs-4">Refer a friend</a></li>

 	</ul> 

 <div id="tabs-1"> 

<div  class="demo2">
<div class="custom" id="tabs_vnd">

	<ul class="custom">
	<?
	$res = mysql_query(
"SELECT id_vendor, vendors.public_name as vname, id_order, order_for, client_profiles.name as cname
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
$nb ++ ;
$name_vnd= $vendornext['vname'];
$date = $vendornext ['order_for'];
$date = formatdate($date);
$day  = date('D', strtotime($date));
$datetmp = $vendornext['order_for'];
$timeorder10 = datetimeUS2Time($datetmp);
$timeorder20= explode(':',$timeorder10);
$timeorder30 = $timeorder20[0].':'.$timeorder20[1];
$time10 = $timeorder20[2];
$time20 =  explode(' ',$time10);
$time30 = $time20[1];
$time = $timeorder30.' '.$time30;
?>
<li class="custom"><a href="#tabs_vnd-<?=$nb?>"><?=$name_vnd?><br><?=$day.' '.$date?><br><?=$time?></a></li>
<? } ?>
 	</ul> 


	<br>	<br>


	<? $res2 = mysql_query("SELECT * FROM vendors where id_vendor = '$vnd[0]'");
		if ($vnd[0] == '') {} else { ?>
		<div id="tabs_vnd-1" >
<?	$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic); 
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo nl2br($popup2['VendorBioField1']);?> <br><br>
<? if ($popup2['VendorBioField2']==''){ } else {echo nl2br($popup2['VendorBioField2']);?> <br><br> <? }
if ($popup2['VendorBioField3']==''){ } else {echo nl2br($popup2['VendorBioField3']);?> <br><br> <? }

$order1 = $order_id[0];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol,  order_proposal_items.notes as notes
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND id_food_category = food_category_id
AND list_order < 19
AND order_proposals.order_id ='$order1'
order by food_categories.list_order, quantity DESC , menu_name, description DESC ");
?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
		
	<? $lastCategory1='-';
	$description1.=' <u><a href="http://cater2.me/dashboard/feedback/?oid='.$order1.'" target="_blank">'.$name_vndtb[0].' Feedback</a></u>'."<br>";
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
			$tmp.=(($item['notes'])? ' ('.$item['notes'].')': '');
			$description1.= $item['menu_name'].$veg.$vegan.$tmp.'  <span style="font-size:9px; color:#990066" >'.$glu.$dai.$nut.$egg.$soy.$hon.$she.$alc."</span><br>";
			
} $description1.= 	$legend;
echo $description1;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. Click<b> <a href="#" onclick="javascript:disclaimer(); return false;">here </a></b>for full disclaimer. ';


?>
	</div> 
</div>
</div><? } ?>


	<? $res2 = mysql_query("SELECT * FROM vendors where id_vendor = '$vnd[1] '");
	if ($vnd[1] == '') {} else { ?>
	<div id="tabs_vnd-2" >
<?	$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic); 
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo nl2br($popup2['VendorBioField1']);?> <br><br>
<? if ($popup2['VendorBioField2']==''){ } else {echo nl2br($popup2['VendorBioField2']);?> <br><br><? }
if ($popup2['VendorBioField3']==''){ } else {echo nl2br($popup2['VendorBioField3']);?> <br><br> <? }

$order2 = $order_id[1];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol,  order_proposal_items.notes as notes
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND list_order < 19
AND id_food_category = food_category_id
AND order_proposals.order_id ='$order2'
order by  food_categories.list_order, quantity DESC , menu_name, description DESC ");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	
	<? $lastCategory2='-';
	$description2.='<u><a href="http://cater2.me/dashboard/feedback/?oid='.$order2.'" target="_blank">'.$name_vndtb[1].' Feedback</a></u>'."<br>";
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
			$tmp.=(($item['notes'])? ' ('.$item['notes'].')': '');
			$description2.= $item['menu_name'].$veg.$vegan.$tmp.'  <span style="font-size:9px; color:#990066" >'.$glu.$dai.$nut.$egg.$soy.$hon.$she.$alc."</span><br>";
			
} $description2.= 	$legend;
echo $description2;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. Click<b> <a href="#" onclick="javascript:disclaimer(); return false;">here </a></b>for full disclaimer. ';
?>
	</div> 
</div>	

</div><? }  ?>

	<? $res2 = mysql_query("SELECT * FROM vendors where id_vendor = '$vnd[2] '");
	if ($vnd[2] == '') {} else { ?>
	<div id="tabs_vnd-3" >
<?	$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic); 
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo nl2br($popup2['VendorBioField1']);?> <br><br>
<? if ($popup2['VendorBioField2']==''){ } else {echo nl2br($popup2['VendorBioField2']);?> <br><br><? }
if ($popup2['VendorBioField3']==''){ } else {echo nl2br($popup2['VendorBioField3']);?> <br><br> <? }

$order3 = $order_id[2];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol,  order_proposal_items.notes as notes
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND list_order < 19
AND id_food_category = food_category_id
AND order_proposals.order_id ='$order3'
order by  food_categories.list_order, quantity DESC , menu_name, description DESC ");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	

	<? $lastCategory3='-';
	$description3.='<u><a href="http://cater2.me/dashboard/feedback/?oid='.$order3.'" target="_blank">'.$name_vndtb[2].' Feedback</a></u>'."<br>";
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
			$tmp.=(($item['notes'])? ' ('.$item['notes'].')': '');
			$description3.= $item['menu_name'].$veg.$vegan.$tmp.'  <span style="font-size:9px; color:#990066" >'.$glu.$dai.$nut.$egg.$soy.$hon.$she.$alc."</span><br>";
			
} $description3.= 	$legend;
echo $description3;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens.Click<b> <a href="#" onclick="javascript:disclaimer(); return false;">here </a></b>for full disclaimer. ';
?>
	</div> 
</div>	

</div><? }  ?>

	<? $res2 = mysql_query("SELECT * FROM vendors where id_vendor = '$vnd[3] '");
	if ($vnd[3] == '') {} else { ?>
	<div id="tabs_vnd-4" >
<?	$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic); 
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo nl2br($popup2['VendorBioField1']);?> <br><br>
<? if ($popup2['VendorBioField2']==''){ } else {echo nl2br($popup2['VendorBioField2']);?> <br><br><? }
if ($popup2['VendorBioField3']==''){ } else {echo nl2br($popup2['VendorBioField3']);?> <br><br> <? }

$order4 = $order_id[3];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol,  order_proposal_items.notes as notes
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND list_order < 19
AND id_food_category = food_category_id
AND order_proposals.order_id ='$order4'
order by  food_categories.list_order, quantity DESC , menu_name, description DESC ");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>


	<? $lastCategory4='-';
	$description4.='<u><a href="http://cater2.me/dashboard/feedback/?oid='.$order4.'" target="_blank">'.$name_vndtb[3].' Feedback</a></u>'."<br>";
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
			$tmp.=(($item['notes'])? ' ('.$item['notes'].')': '');
			$description4.= $item['menu_name'].$veg.$vegan.$tmp.'  <span style="font-size:9px; color:#990066" >'.$glu.$dai.$nut.$egg.$soy.$hon.$she.$alc."</span><br>";
			
} $description4.= 	$legend;
echo $description4;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens.Click<b> <a href="#" onclick="javascript:disclaimer(); return false;">here </a></b>for full disclaimer. ';
?>
	</div> 
</div>	

</div><? }  ?>

	<? $res2 = mysql_query("SELECT * FROM vendors where id_vendor = '$vnd[4] '");
	if ($vnd[4] == '') {} else { ?>
	<div id="tabs_vnd-5" >
<?	$popup2 = mysql_fetch_assoc($res2);
$name_popup2= $popup2['name'];
$name_pic =strtolower($name_popup2);
$name_pic = str_replace(' ','',$name_pic); 
?>
<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo nl2br($popup2['VendorBioField1']);?> <br><br>
<? if ($popup2['VendorBioField2']==''){ } else {echo nl2br($popup2['VendorBioField2']);?> <br><br><? }
if ($popup2['VendorBioField3']==''){ } else {echo nl2br($popup2['VendorBioField3']);?> <br><br> <? }

$order5 = $order_id[4];
$res2 = mysql_query("
SELECT menu_name, description, label food_category, quantity, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol,  order_proposal_items.notes as notes
FROM order_proposal_items, vendor_items, order_proposals, food_categories
WHERE vendor_item_id = id_vendor_item
AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
AND list_order < 19
AND id_food_category = food_category_id
AND order_proposals.order_id ='$order5'
order by  food_categories.list_order, quantity DESC , menu_name, description DESC ");

?>
<div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>


	<? $lastCategory5='-';
	$description5.='<u><a href="http://cater2.me/dashboard/feedback/?oid='.$order5.'" target="_blank">'.$name_vndtb[4].' Feedback</a></u>'."<br>";
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
			$tmp.=(($item['notes'])? ' ('.$item['notes'].')': '');
			$description5.= $item['menu_name'].$veg.$vegan.$tmp.'  <span style="font-size:9px; color:#990066" >'.$glu.$dai.$nut.$egg.$soy.$hon.$she.$alc."</span><br>";
			
} $description5.= 	$legend;
echo $description5;
echo '<br>Items have been prepared in facilities that may contain trace amounts of common allergens. Click<b> <a href="#" onclick="javascript:disclaimer(); return false;">here </a></b>for full disclaimer. ';
?>
	</div> 
</div>	

</div><? }  ?>

<!-- end tabs_vnd -->
 </div>
<!-- end tab demo2 -->
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
	
	
	<div id="tabs-3">
	<div id="frame" style="background-image: url(/template/images/frame-print.png); height: 240px; width: 900px; border: 0px ;">
		<div id="frame1" style="height: 90px; width: 700px;" >
		  <span style="font-size:16px;">Print your upcoming 5 meals.</span>
		</div></div>
<div class="grid_7" id="contact-page"> 
<div class="candybox" style="width: 830px;">
<div id="frame3" style=" width: 850px; margin-left:50px" >
<table width ="	90%">

<br>
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
$datetmp = $datetmparray[0];
$timeorder10 = datetimeUS2Time($datetmp);
$timeorder20= explode(':',$timeorder10);
$timeorder30 = $timeorder20[0].':'.$timeorder20[1];
$time10 = $timeorder20[2];
$time20 =  explode(' ',$time10);
$time30 = $time20[1];
$time = $timeorder30.' '.$time30;
$dateVend = $day2.', '.$date.' ('.$time.')';

?> 
<form method="post" action ="../../menu_client_day.php"  target="_blank">
<!--
<td  width="35%" style="vertical-align:middle;">>
<td width="45%" style="vertical-align:middle;">
<input type="hidden" name="order_id" value=
<td width="10%"><input type="submit" name="menu" value="Print menu" /></td>
<td width="10%"><input type="submit" name="label" value="Print labels" /></td>
-->
<td  width="20%" style="vertical-align:middle;"><? echo $name_popup ?></td>
<td width="30%" style="vertical-align:middle;"><? echo $dateVend ?></td>
<input type="hidden" name="order_id" value="<?=$order1?>" />
<td width="20%"><input type="submit" name="menu" value="Print menu" /></td>
<td width="20%"><input type="submit" name="label" value="Print labels" /></td>
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
$datetmp = $datetmparray[1];
$timeorder10 = datetimeUS2Time($datetmp);
$timeorder20= explode(':',$timeorder10);
$timeorder30 = $timeorder20[0].':'.$timeorder20[1];
$time10 = $timeorder20[2];
$time20 =  explode(' ',$time10);
$time30 = $time20[1];
$time = $timeorder30.' '.$time30;
$dateVend = $day2.', '.$date.' ('.$time.')';
?> 
<form method="post" action ="../../menu_client_day.php"  target="_blank">
<td style="vertical-align:middle;"><? echo $name_popup ?></td>
<td style="vertical-align:middle;"><? echo $dateVend ?></td>
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
$datetmp = $datetmparray[2];
$timeorder10 = datetimeUS2Time($datetmp);
$timeorder20= explode(':',$timeorder10);
$timeorder30 = $timeorder20[0].':'.$timeorder20[1];
$time10 = $timeorder20[2];
$time20 =  explode(' ',$time10);
$time30 = $time20[1];
$time = $timeorder30.' '.$time30;
$dateVend = $day2.', '.$date.' ('.$time.')';
?>
<form method="post" action ="../../menu_client_day.php"  target="_blank">
<td style="vertical-align:middle;"><? echo $name_popup ?></td>
<td style="vertical-align:middle;"><? echo $dateVend ?></td>
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
$datetmp = $datetmparray[3];
$timeorder10 = datetimeUS2Time($datetmp);
$timeorder20= explode(':',$timeorder10);
$timeorder30 = $timeorder20[0].':'.$timeorder20[1];
$time10 = $timeorder20[2];
$time20 =  explode(' ',$time10);
$time30 = $time20[1];
$time = $timeorder30.' '.$time30;
$dateVend = $day2.', '.$date.' ('.$time.')';?>
<form method="post" action ="../../menu_client_day.php"  target="_blank">
<td style="vertical-align:middle;"><? echo $name_popup ?></td>
<td style="vertical-align:middle;"><? echo $dateVend ?></td>
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
$datetmp = $datetmparray[4];
$timeorder10 = datetimeUS2Time($datetmp);
$timeorder20= explode(':',$timeorder10);
$timeorder30 = $timeorder20[0].':'.$timeorder20[1];
$time10 = $timeorder20[2];
$time20 =  explode(' ',$time10);
$time30 = $time20[1];
$time = $timeorder30.' '.$time30;
$dateVend = $day2.', '.$date.' ('.$time.')';

?> 
<form method="post" action ="../../menu_client_day.php"  target="_blank">
<td style="vertical-align:middle;"><? echo $name_popup ?></td>
<td style="vertical-align:middle;"><? echo $dateVend ?></td>
<input type="hidden" name="order_id" value="<?=$order5?>" />
<td><input type="submit" name="menu" value="Print menu" /></td>
<td><input type="submit" name="label" value="Print labels" /></td>

</tr>
</form>
<? } ?>
</table>
<form method="post" action ="../../menu_client.php"  target="_blank"  onsubmit="return validate();">
<input type="hidden" name="company_id" value="<?=$company?>" />
<input type="submit" name="menu-wk" value="Print this week's summary menus" /><br>
<input type="submit" name="menu-dy" value="Print this week's detailed menus" />
</div></div></div>

	</div> 
	

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=172716656150201";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

	<div id="tabs-4">
	<div id="frame" style="background-image: url(/template/images/frame_ref2.png); height: 560px; width: 900px; border: 0px ;">
		<div id="frame1" style="height: 200px; width: 900px;" >
		  <span style="font-size:16px;"> <?=$textreferral?></span>
		</div>
		
 		<div id="frame2" style="height: 200px; width: 900px;" >
	<div class="grid_7" id="contact-page"> 
	  <form method="post"  onsubmit="return validaterefer();">
	  		<table class="tableref" align="left" width="800px" >
		</tr><td width="310px"  style="border:0px; vertical-align:middle;"><span style="font-size:18px;">   Your friend's name</span></label></td>
			<td  width="300px"  style="border:0px"><input type="text" tabindex="1" name="name2"  placeholder="friend's name" /></td>
			<td  width="200px" style="border:0px; vertical-align:middle;"><span style="font-size:18px;">Like us on Facebook !</td>
			</tr>
			</tr><td style="border:0px; vertical-align:middle;"><span style="font-size:18px;"> Your friend's email</span></label></td>
			<td style="border:0px"><input type="email" tabindex="2" name="email2" id="email2" placeholder="friend's company email" /></td>
			<td rowspan="2" ><div class="fb-like-box" data-href="https://www.facebook.com/C2meSF" data-width="292" data-show-faces="false" data-stream="false" data-header="true"></div></td>
			</tr>
			</tr><td  style="border:0px ;vertical-align:middle;"><span style="font-size:18px;"> Your friend's company </span></label></td>
			<td style="border:0px"><input type="text" tabindex="3" name="company"  placeholder="friend's company name" /></td>
			</tr>
			
			 <input type="hidden" name="name1"  value="<?=$curUser['first_name'];?>" />
	 		<input type="hidden" name="email1"  value="<?=$curUser['email'];?>" />
		<tr><td></td><td style="border:0px"><input type="submit" tabindex="4" name = "Send"  value="Send"  /></td></tr>
		</table>
		
			</form>
			</div>
		</div>
	</div>	
	
	</div>
	
<!- End div tabs -->


</div>
<!-- End demo -->
</div>
<?
require 'footer.php';
?>
