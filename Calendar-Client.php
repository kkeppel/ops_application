<?
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
	$type = $_POST['type'];
	$company = $_POST['company'];
	$ip=$_SERVER['REMOTE_ADDR'];
	$date = date("Y-m-d H:i:s");
$sql = "INSERT INTO referral_email(id_ref, name_ref, email_ref, fr_name_ref, fr_email_ref, company_ref, type_ref, ip_address, page, date) VALUES ('','$name1','$email1','$name2','$email2','$company','$type','$ip', 'Calendar Vendor Referral', '$date')";mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	

	$send = 1;

sendMail('pauline@cater2.me','Referral E-mail from dashboard Vendor Page','E-mail: '.$_POST['email2']."\nName: ".$_POST['name2']."\nCompany: ".$_POST['company']."\nType Company: ".$_POST['type']."\nFrom: ".$curUser['username'].' ('.$curUser['first_name'].' '.$curUser['last_name'].")\nIP: ".$_SERVER['REMOTE_ADDR']);

	}
		
}


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

	function afficher1(i)
		{
		document.getElementById(id).style.display="block";
		document.getElementById(fb2).style.display="none";
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
.customacc .ui-widget { font-family: Verdana,Arial,sans-serif; font-size: 1.1em; }
.customacc .ui-widget .ui-widget { font-size: 1em; }
.customacc .ui-widget input,.customacc .ui-widget select,.customacc .ui-widget textarea,.customacc .ui-widget button { font-family: Verdana,Arial,sans-serif; font-size: 1em; }
.customacc .ui-widget-content { border: 1px solid red; background: red url(images/ui-bg_flat_75_ffffff_40x100.png) 50% 50% repeat-x; color: red; }
.customacc .ui-widget-content a { color: red; }
.customacc .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { border: 1px solid red; background: red url(images/ui-bg_flat_75_96bade_40x100.png) 50% 50% repeat-x; font-weight: normal; color: red; }
.customacc .ui-widget-header { border: 1px solid red; background: red url(images/ui-bg_flat_0_ffffff_40x100.png) 50% 50% repeat-x; color: red; font-weight: bold;
border-bottom-color: red; }
.customacc .ui-widget-header a { color: red; }
.customacc .ui-state-hover,.customacc .ui-widget-content .ui-state-hover,.customacc .ui-widget-header .ui-state-hover,.customacc .ui-state-focus,.customacc .ui-widget-content .ui-state-focus,.customacc .ui-widget-header .ui-state-focus { border: 1px solid red; background: red url(images/ui-bg_flat_75_a1effc_40x100.png) 50% 50% repeat-x; font-weight: normal; color: red; }
.customacc .ui-state-active,.customacc .ui-widget-content .ui-state-active,.customacc .ui-widget-header .ui-state-active { border: 0px solid red; background: red url(images/ui-bg_flat_65_bfbfbf_40x100.png) 50% 50% repeat-x; font-weight: normal; color: red; }


*/

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

/* CSS feedback tab */
div#leftFbk {
	float:left;
	width:180px;
	height:400px;
	padding-right: 15px;
	}
	
#feedb1 {
	width: 700px;
}
#feedb1 td.title {
   background:#BFBFBF !important;
   color: white;
  font-size:15px;
}

#feedb2 td.title {
   background:#C0E6EF !important;
   color: black;
   font-size:13px;
}
#feedb2 tr.title {
  border-top : 0;
  border-bottom : 0;
  }
#feedb2 tr {
   font-size:13px;
   border-bottom : 2px dashed;
}

div#leftInfo {
	float:left;
	width:270px;
	height:600px;
	padding-right: 40px;
	}
div#middleInfo {
	float:left;
	width:270px;
	height:600px;
	padding-right: 40px;
	}
div#rightInfo {
	float:left;
	width:270px;
	height:900px;
	padding-right: 25px;
	}	
	
div#chart_div
{
padding-left: 140px;
width: 695px;
height: 395px;
}
.hr-pattern {
height:2px;
padding-bottom: 5px;
margin-bottom: 5px;
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
<?
if($send ==1)
{

$textreferral = "Thank You!<br> We'll let you know when they sign up!";

}


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

<div class="demo">
<div id="tabs">
	<ul>
<!-- GERER LES DIV SELON CLIENT OU EMPLOYEE, DONC PLUS DE TAB-1 etc -->
<? if($curUser['client_id']) { ?> 
<li><a href="#tabs-1"><?=$tab1?></a></li>
<li><a href="#tabs-2">Full calendar</a></li>
<? if($print==0) { ?>
<li><a href="#tabs-3">Print manager</a></li> <? }?>
<li><a href="#tabs-4">Refer a friend</a></li>
<li><a href="#tabs-5">Feedback</a></li>
<li><a href="#tabs-6">Infographic</a></li>
<? }
else { ?>
<li><a href="#tabs-1"><?=$tab1?></a></li>
<li><a href="#tabs-2">Full calendar</a></li>
<li><a href="#tabs-4">Refer a friend</a></li>
<li><a href="#tabs-6">Infographic</a></li>
<? } ?>
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
AND order_proposals.selected =1
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
AND order_proposals.selected =1
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
AND order_proposals.selected =1
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
AND order_proposals.selected =1
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
AND order_proposals.selected =1
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
	
	<? if($curUser['employee_id']) {} else {
	 if($print==1) {} else { 
	?>
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
<td width="20%"><input type="submit" name="menu" value="Print menu" style="cursor:pointer;" /></td>
<td width="20%"><input type="submit" name="label" value="Print labels" style="cursor:pointer;" /></td>
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
<td><input type="submit" name="menu" value="Print menu" style="cursor:pointer;" /></td>
<td><input type="submit" name="label" value="Print labels" style="cursor:pointer;"/></td>
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
<td><input type="submit" name="menu" value="Print menu" style="cursor:pointer;"/></td>
<td><input type="submit" name="label" value="Print labels" style="cursor:pointer;"/></td>
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
<td><input type="submit" name="menu" value="Print menu" style="cursor:pointer;"/></td>
<td><input type="submit" name="label" value="Print labels" style="cursor:pointer;"/></td>
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
<td><input type="submit" name="menu" value="Print menu" style="cursor:pointer;"/></td>
<td><input type="submit" name="label" value="Print labels" style="cursor:pointer;"/></td>

</tr>
</form>
<? } ?>
</table>
<form method="post" action ="../../menu_client.php"  target="_blank"  onsubmit="return validate();">
<input type="hidden" name="company_id" value="<?=$company?>" />
<input type="submit" name="menu-wk" value="Print this week's summary menus" style="cursor:pointer;" /><br>
<input type="submit" name="menu-dy" value="Print this week's detailed menus" style="cursor:pointer;"/>
</div></div></div>

	</div> <? }} ?>	
	

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
		<tr><td></td><td style="border:0px"><input type="submit" tabindex="4" name = "Send"  value="Send" style="cursor:pointer;" /></td></tr>
		</table>
		
			</form>
			</div>
		</div>
	</div>	
	
	</div>
	
	<!-- 	Div Feedback -->
	<? if($curUser['employee_id']) {} else {?>
	<div id="tabs-5">
	
<?	

	$datefbc = $date2 = date( "Y-m-d", time() - 7 * 24 * 60 * 60 );
	$datefbc1 = $date2 = date( "Y-m-d", time() - 30 * 24 * 60 * 60 );
	$datefbc = $datefbc.' 00:00:00';
	$datefbc1 = $datefbc1.' 00:00:00';
	$datefbc2 = date("Y-m-d H:i:s");
	// Nb employee
	$resNbEmp = mysql_query("SELECT MAX( client_profiles.employees ) AS nb
FROM client_profiles, clients, order_requests
WHERE client_profiles.client_id = clients.id_client
AND company_id =$company
AND client_profile_id = id_profile
AND order_for
BETWEEN  '$datefbc'
AND  '$datefbc2'
	");
	$nbEmp = mysql_fetch_assoc($resNbEmp);
	$nbEmp = round($nbEmp['nb']);
	
	// Nb employee signup
	$resSign = mysql_query("SELECT  count(id_user) as count, name
	FROM users, employees, companies
	WHERE employee_id = id_employee
	AND company_id = id_company
	and company_id = $company");
	$nbSign = mysql_fetch_assoc($resSign);
	$nbSign = $nbSign['count'];

	// % employee signed 
	$PercSign = round(($nbSign * 100)/ $nbEmp);
	if ($PercSign>100)
	{ $PercSign = 100;
	}
	
	
	// Allergens Chart, a voir creer la table
	
	// Avg rating
	
	
		
		$resrevieuwnb = mysql_query("SELECT COUNT( feedback_id ) AS count
		FROM order_feedback, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.client_id = clients.id_client
		AND order_feedback.user_id = users.id_user
		AND order_requests.order_status_id =4
		AND food_rating >0
		AND company_id =$company
		AND order_for
		BETWEEN  '$datefbc1'
		AND  '$datefbc2'");
		$reviewtmp = mysql_fetch_assoc($resrevieuwnb);
		$review =number_format($reviewtmp['count']);


		$nbfeedb = mysql_query("SELECT COUNT( DISTINCT order_feedback.order_id ) AS countfb
		FROM order_feedback, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.client_id = clients.id_client
		AND order_requests.order_status_id =4
		AND order_feedback.user_id = users.id_user
		and id_user = '$user'
		AND company_id =$company");
		$nbfeedbacktmp = mysql_fetch_assoc($nbfeedb);
		$nbfeedback =number_format($nbfeedbacktmp['countfb']);
		
		$nborder = mysql_query("SELECT COUNT( DISTINCT order_proposals.order_id ) AS countorder
		FROM order_proposals, order_requests, users, clients
		WHERE order_proposals.selected =1
		AND order_proposals.order_id = order_requests.id_order
		AND order_requests.order_status_id =4
		AND order_requests.client_id = clients.id_client
				and id_user = '$user'
		AND company_id  = $company");
		$nbordertmp = mysql_fetch_assoc($nborder);
		$nborder =$nbordertmp['countorder'];
		$percfborder = round(($nbfeedback * 100)/ $nborder);
			
		$resavgfood = mysql_query("SELECT AVG( food_rating ) AS avg_food
		FROM order_feedback, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.client_id = clients.id_client
		AND order_feedback.user_id = users.id_user
		AND order_requests.order_status_id =4
		and food_rating>0
		AND order_for
		BETWEEN  '$datefbc1'
		AND  '$datefbc2'
		AND company_id =$company
		");
		$resavgport = mysql_query("SELECT AVG( portioning ) AS portioning
		FROM order_feedback, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.client_id = clients.id_client
		AND order_requests.order_status_id =4
		AND order_feedback.user_id = users.id_user
		and portioning>0
		AND order_for
		BETWEEN  '$datefbc1'
		AND  '$datefbc2'
		AND company_id =$company
		");
		$resavgserv = mysql_query("SELECT  AVG( service_rating ) AS service
		FROM order_feedback, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.order_status_id =4
		AND order_requests.client_id = clients.id_client
		AND order_feedback.user_id = users.id_user
		and service_rating>0
		AND order_for
		BETWEEN  '$datefbc1'
		AND  '$datefbc2'
		AND company_id =$company
		");
		$resavgc2me = mysql_query("SELECT AVG( c2me_rating) as c2me
		FROM order_feedback, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.order_status_id =4
		AND order_requests.client_id = clients.id_client
		AND order_feedback.user_id = users.id_user
		and c2me_rating>0
		AND order_for
		BETWEEN  '$datefbc1'
		AND  '$datefbc2'
		AND company_id =$company
		");
	//AND order_feedback.user_id = users.id_user
		$avgfood = mysql_fetch_assoc($resavgfood);
		$foodtot =number_format($avgfood['avg_food'],1);
		$avgserv = mysql_fetch_assoc($resavgserv);
		$servicetot = number_format($avgserv['service'],1);
		$avgport = mysql_fetch_assoc($resavgport);
		$porttot = number_format($avgport['portioning'],1);
		$avgc2me = mysql_fetch_assoc($resavgc2me);
		$c2metot = number_format($avgc2me['c2me'],1);
	
	/*
$resavg = mysql_query("SELECT AVG( food_rating ) AS avg_food, vendors.name AS name, order_for, AVG( portioning ) AS portioning, AVG( service_rating ) AS service, order_feedback.order_id as orderid, vendors.id_vendor as vendorid
		FROM order_feedback, vendors, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.vendor_id = vendors.id_vendor
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.client_id = clients.id_client
		AND order_feedback.user_id = users.id_user
		AND company_id =$company
		GROUP BY order_feedback.order_id
		ORDER BY order_for DESC 
		LIMIT 0 , 5");
*/
		$datedayfbck =  date("Y-m-d H:i:s");
		$resorder = mysql_query("SELECT id_order, order_for, public_name
		FROM order_requests, clients, order_proposals, vendors
		WHERE order_requests.client_id = clients.id_client
		AND clients.company_id = '$company'
		AND order_for <  '$datedayfbck'
		AND vendor_id = id_vendor
		AND order_proposals.order_id = order_requests.id_order
		AND order_requests.order_status_id =4
		AND selected =1
		ORDER BY order_for desc
		LIMIT 0 , 5");

		$resavgfoodtot = mysql_query("SELECT AVG( food_rating ) as avgtot
		FROM  `order_feedback`		WHERE food_rating >0	");
		$avgfoodtot = mysql_fetch_assoc($resavgfoodtot);
		$avgfood =number_format($avgfoodtot['avgtot'],1);
		$resavgservtot = mysql_query("SELECT AVG( service_rating ) as avgtot
		FROM  `order_feedback`	WHERE service_rating >0		");
		$avgservtot = mysql_fetch_assoc($resavgservtot);
		$avgserv =number_format($avgservtot['avgtot'],1);
		$resavgporttot = mysql_query("SELECT AVG( portioning ) as avgtot
		FROM  `order_feedback`	WHERE portioning >0");
		$avgporttot = mysql_fetch_assoc($resavgporttot);
		$avgport =number_format($avgporttot['avgtot'],1);
		$resavgc2mtot = mysql_query("SELECT AVG( c2me_rating ) as avgtot
		FROM  `order_feedback`	WHERE c2me_rating >0");
		$avgc2mtot = mysql_fetch_assoc($resavgc2mtot);
		$avgc2m =number_format($avgc2mtot['avgtot'],1);


		
?>
	<div id="leftFbk">
	<b>Number of employees: </b><br><br><span style="font-size:35px" ><?=$nbEmp?></span><br><br><br><br>
	<b>Number of employees signed up with account: </b><br><br><span style="font-size:35px" ><?=$nbSign?> <br><br> <?=$PercSign?> %</span><br><br><br>
	<b>Meals receiving feedback : </b><br><br><span style="font-size:35px" ><?=$percfborder?> %</span><br><br>	
	</div>
	
	<table>
	<tr>
	<td width="10%" rowspan="2"><b>Average ratings</b> (<?=$review?> reviews) (Last 30 days)</td>
	<td  height="40px"><b>FOOD:</b></td><td><b>SERVICE:</b></td><td><b>PORTIONING:</b></td><td><b>CATER2.ME:</b></td></tr>
	<tr>
	<td valign="bottom"><span style="font-size:60px" >
	<? if ($foodtot=='0.0') {echo  '--'; } else { ?>
	<?=$foodtot?></span><span style="vertical-align:text-bottom;font-size:20px " >/5</span><br>
	<? if ($foodtot > $avgfood	)
	{  $diff = $foodtot- $avgfood; ?> 
	<span style="color:blue " >( <?=$diff?> above avg )</span>
	<? }
	else if ($foodtot < $avgfood	)
	{  $diff = $avgfood - $foodtot ; ?> 
	<span style="color:red " >( <?=$diff?> below avg )</span>
	<? }
	else{ ?> (equal to avg ) <? } ?>
	 <? } ?> 
	</td>
	<td valign="bottom"><span style="font-size:60px" >
	<? if ($servicetot=='0.0') {echo  '--'; } else { ?><?=$servicetot?></span><span style="vertical-align:text-bottom;font-size:20px " >/5</span><br>
	<? if ($servicetot > $avgserv	)
	{  $diff = $servicetot- $avgserv; ?> 
	<span style="color:blue " >( <?=$diff?> above avg )</span>
	<? }
	else if ($servicetot < $avgserv	)
	{  $diff = $avgserv - $servicetot ; ?> 
	<span style="color:red " >( <?=$diff?> below avg )</span>
	<? }
	else{ ?> (equal to avg ) <? } ?>
	 <? } ?>
	</td>
	<td valign="bottom"><span style="font-size:60px" >
	<? if ($porttot=='0.0') {echo  '--'; } else { ?><?=$porttot?></span><span style="vertical-align:text-bottom;font-size:20px " >/5</span><br>
	<? if ($porttot > $avgport	)
	{  $diff = $porttot- $avgport; ?> 
	<span style="color:blue " >( <?=$diff?> above avg )</span>
	<? }
	else if ($porttot < $avgport	)
	{  $diff = $avgport - $porttot ; ?> 
	<span style="color:red " >( <?=$diff?> below avg )</span>
	<? }
	else{ ?> (equal to avg ) <? } ?>
	 <? } ?> 
	</td>
	<td valign="bottom"><span style="font-size:60px" >
	<? if ($c2metot=='0.0') {echo  '--'; } else { ?><?=$c2metot?></span><span style="vertical-align:text-bottom;font-size:20px " >/5</span><br>
	<? if ($c2metot > $avgc2m	)
	{  $diff = $c2metot- $avgc2m; ?> 
	<span style="color:blue " >( <?=$diff?> above avg )</span>
	<? }
	else if ($c2metot < $avgc2m	)
	{  $diff = $avgc2m - $c2metot ; ?> 
	<span style="color:red " >( <?=$diff?> below avg )</span>
	<? }
	else{ ?> (equal to avg ) <? } ?>
	 <? } ?>
	</td></tr>
	</table>

	<br><b>Feedback on the last 5 vendors	</b>
	<table id="feedb1">

	<tr><td class="title">Vendor</td><td class="title">Date</td><td class="title">Food</td><td class="title">Service</td><td class="title">Portioning</td><td class="title">Timing</td></tr>
	<? $i=1;
	$early=0; $ontime=0; $late=0;
	
	 while($order = mysql_fetch_assoc($resorder)) { 
	 
	 $orderid = $order['id_order'];
	 $vendor = $order['public_name'];
	 
	 $resavgfd = mysql_query("SELECT AVG( food_rating ) AS avg_food, vendors.name AS name, order_for, order_feedback.order_id as orderid, vendors.id_vendor as vendorid
		FROM order_feedback, vendors, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.vendor_id = vendors.id_vendor
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.order_status_id =4
		AND order_requests.client_id = clients.id_client
		AND order_feedback.user_id = users.id_user
		AND company_id =$company
		AND order_feedback.order_id =  $orderid
		and food_rating>0
		ORDER BY order_for DESC ");
		 $resavgpt = mysql_query("SELECT vendors.name AS name, order_for, AVG( portioning ) AS portioning, order_feedback.order_id as orderid, vendors.id_vendor as vendorid
		FROM order_feedback, vendors, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.vendor_id = vendors.id_vendor
		AND order_requests.order_status_id =4
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.client_id = clients.id_client
		AND order_feedback.user_id = users.id_user
		AND company_id =$company
		and portioning>0
		AND order_feedback.order_id =  $orderid
		ORDER BY order_for DESC ");
		 $resavgsr = mysql_query("SELECT  vendors.name AS name, order_for, AVG( service_rating ) AS service, order_feedback.order_id as orderid, vendors.id_vendor as vendorid
		FROM order_feedback, vendors, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.vendor_id = vendors.id_vendor
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.order_status_id =4
		AND order_requests.client_id = clients.id_client
		AND order_feedback.user_id = users.id_user
		and service_rating>0
		AND company_id =$company
		AND order_feedback.order_id =  $orderid
		ORDER BY order_for DESC ");
		
		/*
$resClientFb = mysql_query("SELECT order_feedback.order_id AS orderid, food_rating, feedback_private, order_for, public_name, service_rating, c2me_rating, feedback_public, portioning, first_name, user_id
		FROM order_feedback, vendors, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.vendor_id = vendors.id_vendor
		AND order_feedback.order_id  = '$orderid'
		and order_requests.client_id = '$client'
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.client_id = clients.id_client
		AND order_feedback.user_id = users.id_user
		");
*/
	 
/*
	 	 $clientfbtmp = mysql_fetch_assoc($resClientFb);
		 $clientfbserv = $clientfbtmp['service_rating'];
		 if ($clientfbserv == 0 ) {$clientfbserv ='--';} else {$clientfbserv = number_format($clientfbserv,1);}
		 $clientfbfood = $clientfbtmp['food_rating'];
		 if ($clientfbfood == 0 ) {$clientfbfood ='--';} else {$clientfbfood = number_format($clientfbfood,1);}
		 $clientfbport = $clientfbtmp['portioning'];
		 if ($clientfbport == 0 ) {$clientfbport ='--';} else {$clientfbport = number_format($clientfbport,1);}
		 $clientfbpub = $clientfbtmp['feedback_public'];
*/
	 
		 $avgfd = mysql_fetch_assoc($resavgfd);
		 $avgpt = mysql_fetch_assoc($resavgpt);
		 $avgsr = mysql_fetch_assoc($resavgsr);
		 $avgfood = number_format($avgfd['avg_food'],1);
		 $avgser = number_format($avgsr['service'],1);
		 $avgpor = number_format($avgpt['portioning'],1);
		 $vendorid = $avgfd['vendorid'];
		 //$vendor = $avg['name'];
		 $datefeedtmp = $avgfd['order_for'];
		 $datefeed = formatdate($datefeedtmp);
		$dayfeed  = date('D', strtotime($datefeedtmp));
		$dateVend = $dayfeed.', '.$datefeed;
		 
		 $restext = mysql_query("SELECT datetime_t
			FROM text_vendor
			WHERE order_id_t = '$orderid'
			");
		$texttmp = mysql_fetch_assoc($restext);
		$timeText20 = $texttmp['datetime_t'];
		list($year,$month,$day,$h,$m,$s)=sscanf($timeText20,"%d-%d-%d %d:%d:%d");
		$timeTextstamp = mktime($h,$m,$s,$month,$day,$year);

		$timeorder2 =$avgfd['order_for'];
		list($year,$month,$day,$h,$m,$s)=sscanf($timeorder2,"%d-%d-%d %d:%d:%d");
		$s-=600;
		$timestamp2=mktime($h,$m,$s,$month,$day,$year);
		$timeearly2=date('Y-m-d H:i:s',$timestamp2);
		list($year,$month,$day,$h,$m,$s)=sscanf($timeorder2,"%d-%d-%d %d:%d:%d");
		$s+=300;
		$timestamp3=mktime($h,$m,$s,$month,$day,$year);
		$timeelate2=date('Y-m-d H:i:s',$timestamp3);
		//$timeText20 = $avg['datetime_t'];	
		if ($timeText20 == '') {$timing = 'unknow';}
		else if ($timeText20  < $timeearly2) 
			{ 
			$timing = 'Early';
			}
		else if ($timeText20  < $timeelate2 and  $timeText20 > $timeearly2) 
			{
			$timing = 'On-time';
			}
		else if ($timeText20  > $timeelate2) 
			{ 
			$timing = 'Late';
			}

		$resEmp = mysql_query("SELECT order_feedback.order_id AS orderid, food_rating, feedback_private, order_for, public_name, service_rating, c2me_rating, feedback_public, portioning, first_name, user_id, order_requests.client_id
		FROM order_feedback, vendors, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.vendor_id = vendors.id_vendor
		AND order_feedback.order_id  = '$orderid'
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.client_id = clients.id_client
		AND order_requests.order_status_id =4
		AND order_feedback.user_id = users.id_user
		AND company_id =$company
		and order_requests.client_id
		");	
		$rescli = mysql_query("SELECT order_feedback.order_id AS orderid, food_rating, feedback_private, order_for, public_name, service_rating, c2me_rating, feedback_public, portioning, first_name, user_id, order_requests.client_id
		FROM order_feedback, vendors, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.vendor_id = vendors.id_vendor
		AND order_feedback.order_id  = '$orderid'
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.order_status_id =4
		AND order_requests.client_id = clients.id_client
		AND order_feedback.user_id = users.id_user
		AND company_id =$company
		and order_requests.client_id
		and users.id_user = $user 
		");	
 		
 		$client = mysql_fetch_assoc($rescli);
		$clientfbfood = $client['food_rating'];
		$clientfbserv = $client['service_rating'];
		$clientfbport = $client['portioning'];
		 if ($clientfbserv == 0 or $clientfbserv == '' ) {$clientfbserv ='--';} else {$clientfbserv = number_format($clientfbserv,1);}
		 if ($clientfbfood == 0 or $clientfbfood == '') {$clientfbfood ='--';} else {$clientfbfood = number_format($clientfbfood,1);}
		 if ($clientfbport == 0 or $clientfbport == '') {$clientfbport ='--';} else {$clientfbport = number_format($clientfbport,1);}

	?>
 		
	 
	 <tr>
	<td>
	  <? echo $vendor;?> </td><td> <? echo $dateVend;?> </td><td> <? echo $clientfbfood;?> </td><td> <? echo $clientfbserv;?> </td><td> <? echo $clientfbport;?> </td><td> <? echo $timing;?> </td></tr>
	  
	<tr> <td colspan="6">
	<? if (!mysql_num_rows($resEmp)) {}
	else { ?> 
	<div class="customacc">
  	<div class="accordion">

	<h3><a href="#">Company's feedback</a></h3>
	<div>
		<table id="feedb2"><tr  class="title"><td class="title" width="25%">Employee Name</td><td class="title" width="10%">Food</td><td class="title" width="10%">Service</td><td class="title" width="10%">Portioning</td><td class="title" width="45%">Comments</td></tr>
		<? 
		if(!mysql_num_rows($rescli)) {} else {?>
		<tr><td>You</td><td><?=$clientfbfood?></td><td><?=$clientfbserv?></td><td><?=$clientfbport?></td><td><?=$Emp['feedback_public']?></td>
		</tr> <? 
		}
		
		while($Emp = mysql_fetch_assoc($resEmp)) {

		 if ($Emp['food_rating'] == 0 or $Emp['food_rating'] == '' ) {$empfr ='--';} else {$empfr = number_format($Emp['food_rating'],1);}
		 if ($Emp['service_rating'] == 0 or $Emp['service_rating'] == '') {$empsr ='--';} else {$empsr = number_format($Emp['service_rating'],1);}
		 if ($Emp['portioning'] == 0 or $Emp['portioning'] == '') {$emppt ='--';} else {$emppt = number_format($Emp['portioning'],1);}

		
		if( $Emp['user_id'] == $user) {} else {	?>
		<tr><td><?=$Emp['first_name']?></td><td><?=$empfr?></td><td><?=$empsr?></td><td><?=$emppt?></td><td><?=$Emp['feedback_public']?></td>
		</tr> <? 
		}}?>
		<tr><td><?=Average?></td><td><?=$avgfood?></td><td><?=$avgser?></td><td><?=$avgpor?></td><td></td>
		</tr>
		</table>
	</div></div></div> <? } ?>
  </td></tr>
	 <? $i++; }
	?>
	</table>
	
	<?  
		$resavg2 = mysql_query("SELECT order_id_t, datetime_t, order_for
		FROM text_vendor, order_requests, companies, clients
		WHERE  order_id_t = id_order
		and client_id = id_client 
		and company_id =  id_company
		AND company_id ='$company'
		");
		
		$late5 = 0; $late10= 0; $late15=0;
	while($avg = mysql_fetch_assoc($resavg2)) { 
		 $orderid = $avg['order_id_t'];
		 $restext = mysql_query("SELECT datetime_t
			FROM text_vendor
			WHERE order_id_t = '$orderid'
			");
		$texttmp = mysql_fetch_assoc($restext);
		$timeText20 = $texttmp['datetime_t'];
		list($year,$month,$day,$h,$m,$s)=sscanf($timeText20,"%d-%d-%d %d:%d:%d");
		$timeTextstamp = mktime($h,$m,$s,$month,$day,$year);

		$timeorder2 =$avg['order_for'];
		list($year,$month,$day,$h,$m,$s)=sscanf($timeorder2,"%d-%d-%d %d:%d:%d");
		$s-=600;
		$timestamp2=mktime($h,$m,$s,$month,$day,$year);
		$timeearly2=date('Y-m-d H:i:s',$timestamp2);
		list($year,$month,$day,$h,$m,$s)=sscanf($timeorder2,"%d-%d-%d %d:%d:%d");
		$s+=300;
		$timestamp3=mktime($h,$m,$s,$month,$day,$year);
		$timeelate2=date('Y-m-d H:i:s',$timestamp3);
		//$timeText20 = $avg['datetime_t'];	
		if ($timeText20 == '') {$timing = 'unknow';}
		else if ($timeText20  < $timeearly2) 
			{ 
			$early ++;
			}
		else if ($timeText20  < $timeelate2 and  $timeText20 > $timeearly2) 
			{
			$ontime ++;
			}
		else if ($timeText20  > $timeelate2) 
			{ 
			$timediff  =  $timeTextstamp - $timestamp3 ;
			$timediff = round($timediff/60);
			if ($timediff <=5)
			{$late5++ ;
			 }
			else if(5<$timediff and $timediff<=10)
			{$late10++ ; }
			else if(10<$timediff and $timediff<=15)
			{$late15++ ; }
			else 
			{$late++ ; }
			}
		}
		$total = $early + $ontime + $late5 +$late10 + $late15 + $late;
		$Perctime = round(($ontime * 100)/ $total);
		$Percearly = round(($early * 100)/ $total);
		$Perclate5 = round(($late5 * 100)/ $total);
		$Perclate10 = round(($late10 * 100)/ $total);
		$Perclate15 = round(($late15 * 100)/ $total);
		$Perclate = round(($late * 100)/ $total);
	?>
	
	
	<script type="text/javascript">
    
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', ''],
          ['Ontime', <?=$Perctime?>],
          ['Early',  <?=$Percearly?>],
     	  ['0 - 5 minutes late', <?=$Perclate5?>],
     	  ['6 - 10 minutes late', <?=$Perclate10?>],
          ['11 - 15 minutes late',  <?=$Perclate15?>],
          ['More than 15 minutes late',  <?=$Perclate?>]
        ]);

        var options = {
          title: 'Delivery punctuality %',
           legend: {position: 'none'},
           vAxis: {maxValue: '100'},
           width:900, height:300,
			colors: ['#96BADE']
          };
          
        

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);

    }
    
    </script>
      <div id="chart_div" style="width: 900px; height: 395px;"></div>
      
	</div>
	<? } ?>
	
	
	<div id="tabs-6">
	<? 
	$dateinfoday = date('Y-m-d H:i:s');
	$dated1 = date('Y-m-d');
	$dated1 = $dated1.' 00:00:00';
	$dated2 = date('Y-m-d');
	$dated2=$dated2.' 23:59:59';
	
	$resorder = mysql_query("SELECT order_id, public_name
		FROM order_requests, order_proposals, clients, vendors
		WHERE   order_proposals.selected =1
		and order_requests.client_id = clients.id_client
		and vendor_id = id_vendor
		AND order_proposals.order_id = order_requests.id_order 
		AND order_requests.order_status_id =4
		AND company_id ='$company'
		and order_for between '$dated1' and '$dated2'
		order by order_for desc
		limit 0,1
		");
	$ordertmp = mysql_fetch_assoc($resorder);
	$order = $ordertmp['order_id'];
	$vendor = $ordertmp['public_name'];

	$resinfotime = mysql_query("SELECT order_for, order_id
		FROM order_requests, order_proposals, clients
		WHERE   order_proposals.selected =1
		and order_requests.client_id = clients.id_client
		AND order_requests.order_status_id =4
		AND order_proposals.order_id = order_requests.id_order 
		AND company_id ='$company'
		and order_for > '$dateinfoday'
		order by order_for
		limit 0,1
		");
	
	$timetmp = mysql_fetch_assoc($resinfotime);
	$orderfor = $timetmp['order_for'];
	
	
	$daydate = date('w');
	if ($daydate == 6) {
	$datequote = $dated1 = date( "Y-m-d", time() - 1 * 24 * 60 * 60 );
	$datequote = $datequote.' 00:00:00';
	}
	else if($daydate == 0) {
	$datequote = $dated1 = date( "Y-m-d", time() - 2 * 24 * 60 * 60 );
	$datequote = $datequote.' 00:00:00';	
	}
	else { 
	$datequote = $dated1; }
	$resquote = mysql_query("SELECT Quote, Author
	FROM quote
	WHERE   Quote_date = '$datequote'	");
	
	
	$quotetmp = mysql_fetch_assoc($resquote);
	$quote = $quotetmp['Quote'];
	$author = $quotetmp['Author'];

	
	list($year,$month,$day,$h,$m,$s)=sscanf($orderfor,"%d-%d-%d %d:%d:%d");
	$timeorderfor = mktime($h,$m,$s,$month,$day,$year);
	list($year,$month,$day,$h,$m,$s)=sscanf($dateinfoday,"%d-%d-%d %d:%d:%d");
	$timetoday = mktime($h,$m,$s,$month,$day,$year);
	$timenext  =   $timeorderfor - $timetoday;
	$total = $timenext;
	$heure = intval(abs($total / 3600));
	$total = $total - ($heure * 3600);
	$minute = intval(abs($total / 60));
	$minute = $minute-3;
	$total = $total - ($minute * 60);
	
	$resall = mysql_query("SELECT  vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol
	FROM order_proposal_items, vendor_items, order_proposals, food_categories
	WHERE vendor_item_id = id_vendor_item
	AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
	AND list_order < 19
	AND order_proposals.selected =1
	AND id_food_category = food_category_id
	AND order_proposals.order_id ='$order'
	order by  food_categories.list_order, quantity DESC , menu_name, description DESC ");
	$rescount = mysql_query("SELECT  COUNT( menu_name ) as count
	FROM order_proposal_items, vendor_items, order_proposals, food_categories
	WHERE vendor_item_id = id_vendor_item
	AND order_proposal_items.order_proposal_id = order_proposals.id_order_proposal
	AND list_order < 19
	AND order_proposals.selected =1
	AND id_food_category = food_category_id
	AND order_proposals.order_id ='$order' ");
	$counttmp = mysql_fetch_assoc($rescount);
	$count = $counttmp['count'];

		$veg1 = '0';
		$glu1= '0';
		$dai1= '0';
		$vegan1= '0';
		$nut1= '0';
		$egg1= '0';
		$soy1= '0';
		$hon1= '0';
		$she1= '0';
		$alc1= '0';	
	while($items = mysql_fetch_assoc($resall))
{

		if ($items['vegetarian']=='1')
		{ $veg1++; }	
		if ($items['gluten_safe']=='1')
		{ $glu1++ ;}	
		if ($items['dairy_safe']=='1')
		{ $dai1++;}	
		if ($items['vegetarian'] =='1' && $items['dairy_safe']=='1' && $items['egg_safe']=='1')
		{ $vegan1++;}
		if ($items['nut_safe']=='1')
		{ $nut1++ ;}	
		if ($items['egg_safe']=='1')
		{ $egg1++;}	
		if ($items['soy_safe']=='1')
		{ $soy1++ ;}	
					
}


if ($glu1==0){ $percglu=0; }else {$percglu = number_format((($glu1 * 100)/ $count),1);} 
if ($dai1==0){ $percdai=0 ;}else {$percdai = number_format((($dai1 * 100)/ $count),1);} 
if ($veg1==0){ $percveg=0 ;}else {$percveg = number_format((($veg1 * 100)/ $count),1);} 
if ($nut1==0){ $percnut=0 ;}else {$percnut = number_format((($nut1 * 100)/ $count),1);} 
if ($egg1==0){ $percegg=0 ;}else {$percegg = number_format((($egg1 * 100)/ $count),1);} 
if ($soy1==0){ $percsoy=0 ;}else {$percsoy = number_format((($soy1 * 100)/ $count),1);}
if ($vegan1==0){ $percvegan=0 ;}else {$percvegan = number_format((($vegan1 * 100)/ $count),1);}


$avgfd = mysql_query("SELECT AVG( food_rating ) AS avg_food
		FROM order_feedback, order_proposals, order_requests, users, clients
		WHERE order_feedback.order_id = order_proposals.order_id
		AND order_proposals.selected =1
		AND order_feedback.order_id = order_requests.id_order
		AND order_requests.client_id = clients.id_client
		AND order_requests.order_status_id =4
		AND order_feedback.user_id = users.id_user
		and food_rating>0
		AND company_id =$company
		");
$avgtmp = mysql_fetch_assoc($avgfd);
$avginfo = number_format($avgtmp['avg_food'],1);		

	$restextinfo = mysql_query("SELECT datetime_t
	FROM text_vendor
	WHERE order_id_t = '$order'
	");	
	$texttmp = mysql_fetch_assoc($restextinfo);
	$txtinfo = $texttmp['datetime_t'];	

	list($year,$month,$day,$h,$m,$s)=sscanf($txtinfo,"%d-%d-%d %d:%d:%d");
	$timeTextstamp = mktime($h,$m,$s,$month,$day,$year);

	list($year,$month,$day,$h,$m,$s)=sscanf($orderfor,"%d-%d-%d %d:%d:%d");
	$s-=600;
	$timestamp2=mktime($h,$m,$s,$month,$day,$year);
	$timeearly2=date('Y-m-d H:i:s',$timestamp2);
	list($year,$month,$day,$h,$m,$s)=sscanf($orderfor,"%d-%d-%d %d:%d:%d");
	$s+=300;
	$timestamp3=mktime($h,$m,$s,$month,$day,$year);
	$timeelate2=date('Y-m-d H:i:s',$timestamp3);
	
	if ($txtinfo=='') {$statusdel = 'not delivered';}
	else if ($txtinfo  < $timeearly2) 
			{ 
			$statusdel = 'delivered early';
			}
		else if ($txtinfo  < $timeelate2 and  $txtinfo > $timeearly2) 
			{
			$statusdel = 'delivered on time';
			}
		else if ($txtinfo  > $timeelate2) 
			{ 
			$statusdel = 'delivered late';
			}
			
		$resadd = mysql_query("SELECT address, city, public_name, order_for, website
FROM order_requests, order_proposals, clients, vendors
WHERE order_proposals.selected =1
AND order_requests.client_id = clients.id_client
AND vendor_id = id_vendor
AND order_requests.order_status_id =4
AND order_proposals.order_id = order_requests.id_order
AND company_id = '$company'
AND order_for <  '$dateinfoday'
ORDER BY order_for  desc
LIMIT 0 , 5
");
	while($add = mysql_fetch_assoc($resadd))
{
	$city[]= $add['city'];
	$arrayAdress[] = $add['address'].','.$add['city'];
	$arrayweb[]=$add['website'];
	$vndname[] = $add['public_name'];
}
			
	function getCoordonnees($add){
    $apiKey = "ABQIAAAAkMZZeqQ64x8q-Fzvqxz3hhR5UcgDXbjkQl2wNLLk4konkWYROxQQvB_ayskBUDKt0M7sJqTVgNXO0A";
    $url = "http://maps.google.com/maps/geo?q=".urlencode($add).
"&output=csv&key=".$apiKey;
    $csv = file($url);
    $donnees = explode(",",$csv[0]);
    return $donnees[2].",".$donnees[3];
}	


$coor1=  getCoordonnees($arrayAdress[0]);
$coor2=  getCoordonnees($arrayAdress[1]);
$coor3=  getCoordonnees($arrayAdress[2]);
$coor4=  getCoordonnees($arrayAdress[3]);
$coor5=  getCoordonnees($arrayAdress[4]);
if ($city[0] != 'San Francisco' or $city[1] != 'San Francisco' or $city[2] != 'San Francisco' or $city[3] != 'San Francisco' or $city[4] != 'San Francisco' )
{
$zoom=  8.6;
} else {
$zoom=  12;
}
$coor=  getCoordonnees('San Francisco');
$vendor1 = $vndname[0];
$vendor2 = $vndname[1];
$vendor3 = $vndname[2];
$vendor4 = $vndname[3];
$vendor5 = $vndname[4];

?>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Allergen', ''],
          ['Gluten Safe',     <?=$percglu?>],
          ['Dairy Safe', <?=$percdai?>     ],
          ['Nut Safe',  <?=$percnut?>],
          ['Soy Safe', <?=$percsoy?>],
          ['Egg Safe',    <?=$percegg?>],
          ['Vegetarian',    <?=$percveg?>],
          ['Vegan',    <?=$percvegan?>]
        ]);

        var options = {
         legend: {position: 'none'},
           hAxis: {maxValue: '100',maxTextLines:'2'},
			colors: ['#96BADE'],
			 width:270, height:195,
			 hAxis: {title: 'Percentage'},
			  chartArea:{top:15}

        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div_all'));
        chart.draw(data, options);
      }
    </script>

	
	They said WHAT?<br>
	"<?=$quote?>" - "<?=$author?>"<br><br>
	<div id="leftInfo">
	<b>Most recent vendor:</b><br><div class="hr-pattern"></div> <?=$vendor?><br><br>
	
	<b>WHEN is your next meal arriving?</b> <div class="hr-pattern"></div> <br> 
	<? if ($heure >='24') { ?>
	In more than one day.
	<? } 
	else if ($heure=='0') { ?>
	In <span style="font-size:35px" ><?=$minute?></span> minutes.
	<? } else {?>
	In <span style="font-size:35px" > <?=$heure?></span> hours and <span style="font-size:35px" ><?=$minute?></span> minutes. <? } ?><br><br>

	<b>Today's meal includes items that are...</b><div class="hr-pattern"></div>
	<div id="chart_div_all" style="width: 300px; height: 200px;"></div><br>
	<b>WHERE can you find your vendors?</b><div class="hr-pattern"></div><br>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false">
</script>
<div id="map_canvas" style="width: 250px; height: 250px"></div><br><br>
 <script type="text/javascript">


 var locations = [
      ['<b><?=$vendor1?></b><br><?=$arrayAdress[0]?><br><a href="http://<?=$arrayweb[0]?>" target="_blank"><?=$arrayweb[0]?></a>',<?=$coor1?>],
      ['<b><?=$vendor2?></b><br><?=$arrayAdress[1]?><br><a href="http://<?=$arrayweb[1]?>" target="_blank"><?=$arrayweb[1]?></a>',<?=$coor2?>],
      ['<b><?=$vendor3?></b><br><?=$arrayAdress[2]?><br><a href="http://<?=$arrayweb[2]?>" target="_blank"><?=$arrayweb[2]?></a>',<?=$coor3?>],
      ['<b><?=$vendor4?></b><br><?=$arrayAdress[3]?><br><a href="http://<?=$arrayweb[3]?>" target="_blank"><?=$arrayweb[3]?></a>',<?=$coor4?>],
      ['<b><?=$vendor5?></b><br><?=$arrayAdress[4]?><br><a href="http://<?=$arrayweb[4]?>" target="_blank"><?=$arrayweb[4]?></a>',<?=$coor5?>],
    ];


 var map = new google.maps.Map(document.getElementById('map_canvas'), {
      zoom: <?=$zoom?>,
      center: new google.maps.LatLng(<?=$coor?>),
       mapTypeId: google.maps.MapTypeId.ROADMAP
    });
 
    var infowindow = new google.maps.InfoWindow();
 
    var marker, i;
 
   for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });
 
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }

  
    </script><br>
	
	</div> 
		
	<div id="middleInfo">
	<b>What's the status of your delivery?</b><div class="hr-pattern"></div><br>
	<span style="font-size:25px" ><?=$statusdel?></span> <br><br>
	
	<b>Average food rating for this vendor:</b> <div class="hr-pattern"></div><br><br> 
	<? if ($avginfo == '0.0')  { ?>
	<span style="font-size:55px" >--</span>
	<? }
	else { ?>
	<span style="font-size:55px" ><?=$avginfo?></span>/5 <? } ?>
	<br><br>
	<b>Follow us:</b><br><div class="hr-pattern"></div>
	<script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 2,
  interval: 30000,
  width: "80%",
  height: 300,
  theme: {
    shell: {
	background: 'white',
	color: 'black'
    },
    tweets: {
	background: 'white',
	color: 'black',
	links: '#96BADE'
    }
  },
  features: {
    scrollbar: false,
    loop: false,
    live: false,
    hashtags: true,
    timestamp: true,
    avatars: false,
    behavior: 'all'
  }
}).render().setUser('Cater2me').start();
</script>
	<br>
<div class="fb-like-box" data-href="https://www.facebook.com/C2meSF?ref=ts" data-width="292" data-show-faces="false" data-border-color="white" data-stream="true" data-header="false"></div>

	</div>
<?
$resMap = mysql_query("SELECT COUNT( FoodGeo ) as count2 , FoodGeo
FROM order_feedback, order_proposals, order_requests, users, clients, vendors
WHERE order_feedback.order_id = order_proposals.order_id
AND order_proposals.selected =1
AND order_feedback.order_id = order_requests.id_order
AND order_requests.client_id = clients.id_client
AND order_feedback.user_id = users.id_user
AND order_requests.order_status_id = 4
AND id_vendor = order_proposals.vendor_id
AND company_id = 116
GROUP BY FoodGeo
");
?>	
	
 <script type="text/javascript">
    google.load('visualization', '1', {packages: ['geochart']});
 function drawVisualization() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Country');
      data.addColumn('number', 'Number Order');
     data.addRows([
        <?php

        // Boucle de la requête SQL
        while ($donnees = mysql_fetch_array($resMap))
            {
            $country3 = addslashes($donnees['FoodGeo']);
            $count3 = intval($donnees['count2']);
            $data3 .= "['".$country3." : ".$count3."', ".$count3."],"; 
            }
        echo $data3;
        ?>
        ]);
       
       var options = {
        colorAxis: {colors: ['#C0E6EF','red']},
        width: 350, 
        height: 230
      };
        
      var geochart = new google.visualization.GeoChart(
          document.getElementById('visualization'));
      geochart.draw(data, options);
    }
    

    google.setOnLoadCallback(drawVisualization);
  </script>
  <div id="rightInfo">
  
<b>You’ve got a WORLDY palette:</b><div class="hr-pattern"></div>
<div id="visualization"></div>


	<? $query = mysql_query("SELECT COUNT( vendor_type ) AS count, vendor_type, 
type 
FROM order_requests, order_proposals, clients, vendors, SubType
WHERE order_proposals.selected =1
AND order_requests.client_id = clients.id_client
AND vendor_type = SubType.SubType_Id
AND vendor_id = id_vendor
AND order_requests.order_status_id =4
AND order_proposals.order_id = order_requests.id_order
AND company_id =  '$company'
AND order_for
BETWEEN  '$datefbc1'
AND  '$datefbc2'
and SubType.Type_id <> 12
and SubType.Type_id <> 17
and SubType.Type_id <> 16
GROUP BY vendor_type");
$name_chart = "Country_vendors";
?>

<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(<?php echo $name_chart; ?>);
      function <?php echo $name_chart; ?>() {
        var data = new google.visualization.DataTable();
        // Nous n'avons que 2 légendes : le nom d'utilisateur (type string) et son nombre de posts (type number)
        data.addColumn('string', 'Country');
        data.addColumn('number', 'Count');
        data.addRows([
        <?php
 
        // Boucle de la requête SQL
        while ($donnees3 = mysql_fetch_array($query))
            {
            $country = addslashes($donnees3['type']); // On oublie pas addslashes pour éviter qu'un guillemet provoque une erreur
            $count = intval($donnees3['count']);
            $data .= "['".$country." : ".$count."', ".$count."],"; // J'ai choisi d'afficher la valeur directement dans la légende en écrivant '".$username." : ".$nb_posts."'
            }
        echo $data;
        ?>
        ]);
        // Modifiez les options à votre convenance
        var options = {
          width: 250, height: 200,
           legend: {position: 'bottom',textStyle: { fontSize: 12}},
          title: '',
           chartArea:{top:10}
        };
 
        // Affichage du camembert généré dans le div défini au début
        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $name_chart; ?>'));
        chart.draw(data, options);
      }
    </script>
    <br>
    <b>WHAT have you been eating? </b><div class="hr-pattern"></div>
    
<!--     Chart displaying country  -->
    <div id="<?php echo $name_chart; ?>"></div>
    
    <? $resCountry = mysql_query("SELECT AVG( food_rating ) AS avg_food, zip
FROM order_feedback, order_proposals, order_requests, users, clients, vendors
WHERE order_feedback.order_id = order_proposals.order_id
AND order_proposals.selected =1
AND order_feedback.order_id = order_requests.id_order
AND order_requests.client_id = clients.id_client
AND order_feedback.user_id = users.id_user
AND order_requests.order_status_id =4
AND id_vendor = order_proposals.vendor_id
AND food_rating >0
AND company_id =  '$company'
GROUP BY zip
limit 0,10");
$name_chart2 = "avg_by_country";

$resType = mysql_query("SELECT AVG( food_rating ) AS avg_food, Type 
FROM order_feedback, order_proposals, order_requests, users, clients, vendors, SubType
WHERE order_feedback.order_id = order_proposals.order_id
AND order_proposals.selected =1
AND vendor_type = SubType.SubType_Id
AND order_feedback.order_id = order_requests.id_order
AND order_requests.client_id = clients.id_client
AND order_feedback.user_id = users.id_user
AND order_requests.order_status_id =4
and SubType.Type_id <> 12
and SubType.Type_id <> 17
and SubType.Type_id <> 16
AND id_vendor = order_proposals.vendor_id
AND food_rating >0
AND company_id =  '$company'
GROUP BY vendor_type
");
?>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(<?php echo $name_chart2; ?>);
      function <?php echo $name_chart2; ?>() {
        var data = new google.visualization.DataTable();
        // Nous n'avons que 2 légendes : le nom d'utilisateur (type string) et son nombre de posts (type number)
        data.addColumn('string', 'Cuisine Type');
        data.addColumn('number', 'Avg');
        data.addRows([
        <?php
 
        // Boucle de la requête SQL
        while ($donnees2 = mysql_fetch_array($resType))
            {
            $country2 = addslashes($donnees2['Type']); // On oublie pas addslashes pour éviter qu'un guillemet provoque une erreur
            $count2 = number_format($donnees2['avg_food'],1);
            $data2 .= "['".$country2."', ".$count2."],"; // J'ai choisi d'afficher la valeur directement dans la légende en écrivant '".$username." : ".$nb_posts."'
            }
        echo $data2;
 
        
        ?>
        ]);
        // Modifiez les options à votre convenance
        var options = {
          width: 250, height: 300,
           hAxis: {maxValue: '5'},
           colors: ['#96BADE'],
          title: '',
           legend: {position: 'none'},
           chartArea:{top:10}
        };
 
        // Affichage du camembert généré dans le div défini au début
        var chart = new google.visualization.BarChart(document.getElementById('avg_by_country'));
        chart.draw(data, options);
      }
    </script>
   <b> Average rating by type</b><div class="hr-pattern"></div>
    <center><div id="avg_by_country"></div></center>
     </div>
    
 
    
	</div>
<!- End div tabs -->


</div>
<!-- End demo -->
</div>
