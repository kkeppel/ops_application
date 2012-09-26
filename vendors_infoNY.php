<?
require 'lib/core.php';
echo $form;


$redbar = 'Getting started';



$hash = $_GET['a'];
$id = ((((( $hash *2)+2) /152)-5));
$resfee = mysql_query("SELECT fee1, fee2, fee3, fee4, email_vndform from vendor_form where id_vndform = '$id'");
$feetmp = mysql_fetch_assoc($resfee);

$fee1 = number_format($feetmp['fee1']);
$fee2 = number_format($feetmp['fee2']);
$fee3 = number_format($feetmp['fee3']);
$fee4 = number_format($feetmp['fee4']);
$emaildb = $feetmp['email_vndform'];


if ( !mysql_num_rows($resfee)) {
notif('Link invalid: arguments missing. Please check your link.');
}


if($_SERVER['REQUEST_METHOD']=='POST')
{

if (isset($_POST['Submitemail'])) 
{ 
$emailsend = $_POST['email_form'];
$emailsend = STRTOLOWER($emailsend);
$emaildb = $_POST['emaildb'];
$emaildb = STRTOLOWER($emaildb);
$id = $_POST['id'];
$resmail = mysql_query("SELECT email_vndform from vendor_form where id_vndform = '$id'");
$mailtmp = mysql_fetch_assoc($resmail);
$emailtest = $mailtmp['email_vndform'];
//echo $emaildb.'--'.$emailsend.'--'.$fee2;/*

if ($emailtest == $emailsend ) {
$form=3;
$redbar = 'New vendor contact information';

}
else {
notif('Email invalid. Please check your email.'); }

}

if (isset($_POST['Send'])) 
{ 
$form=1;
$redbar = 'New vendor profile information';

//$body =  'Thank you, we will contact you soon';
//$bname = $_POST['bname'];
$bname = mysql_real_escape_string(stripslashes($_POST['bname']));
$fname = mysql_real_escape_string(stripslashes($_POST['fname']));
$lname = mysql_real_escape_string(stripslashes($_POST['lname']));

$email  = $_POST['email'];
$email = STRTOLOWER($email);
//$area1 = $_POST['areaphone1'];
$primphone = $_POST['phone1'];
//$primphone  = $area1.'-'.$phone1;
$primtype  = $_POST['phoneType1'];
//$area2 = $_POST['areaphone1'];
$secphone = $_POST['phone2'];
//$secphone  = $area2.'-'.$phone2;
$sectype  = $_POST['phoneType2'];
$st1  = $_POST['street1'];
$st2  = $_POST['street2'];
$city  = $_POST['city'];
$zip  = $_POST['zip'];
$state  = $_POST['state'];
$country  = $_POST['country'];
$date = date("Y-m-d H:i:s");


$sql = "INSERT INTO `vendor_infoNY`(`vendinfo_id`, `vendinfo_bname`, `vendinfo_fname`, `vendorinfo_lname`, `vendinfo_email`, `vendinfo_primphone`, `vendinfo_primtype`, `vendinfo_secphone`, `vendinfo_sectype`, `vendinfo_str1`, `vendinfo_str2`, `vendinfo_city`, `vendinfo_zip`, `vendinfo_state`, `vendinfo_country`, `vendinfo_date`) VALUES('','$bname','$fname','$lname','$email','$primphone','$primtype','$secphone','$sectype','$st1','$st2','$city','$zip','$state','$country','$date')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	
}
if (isset($_POST['Send2'])) 
{ 
$form=2;
$body =  "Thanks! We'll get back in touch with you soon and will start planning orders!";


$email =  $_POST['email1'];
$deliver = $_POST['deliverNY'];
$speczonechoice = $_POST['speczonechoice'];
if ($deliver == 1) {$delivermail = 'yes';}  else {$delivermail = 'no';}
if ($speczonechoice == 1) {$speczonemail = 'yes';}  else {$speczonemail = 'no';}  

$zone1 = mysql_real_escape_string(stripslashes($_POST['zone1']));
$zone2 = mysql_real_escape_string(stripslashes($_POST['zone2']));
$zone3 = mysql_real_escape_string(stripslashes($_POST['zone3']));
$zone4 = mysql_real_escape_string(stripslashes($_POST['zone4']));

$orderminNY  = $_POST['orderminNY'];
$delfee  = $_POST['delfee'];
$typefee  = $_POST['typefee'];
$delfeeNY  = $_POST['delfeeNY'];
$typefeeNY  = $_POST['typefeeNY'];
$deliverBQB = $_POST['deliverBQB'];
if ($deliverBQB == 1) {$deliverBQBmail = 'yes';}  else {$deliverBQBmail = 'no';}
$delfeeBQB = $_POST['delfeeBQB'];
$typefeeBQB  = $_POST['typefeeBQB'];
$limitBQB = $_POST['limitBQB'];
$deliverWJ = $_POST['deliverWJ'];
if ($deliverWJ == 1) {$deliverWJmail = 'yes';}  else {$deliverWJmail = 'no';}
$delfeeWJ = $_POST['delfeeWJ'];
$typefeeWJ  = $_POST['typefeeWJ'];
$limitWJ = $_POST['limitWJ'];

$capacity = mysql_real_escape_string(stripslashes($_POST['capacity']));

$notice  = $_POST['notice'];
if ($notice == 1) {$noticemail = 'yes';}  else {$noticemail = 'no';}  
$chafdis  = $_POST['chafdis'];
if ($chafdis == 1) {$chafdismail = 'yes';}  else {$chafdismail = 'no';}  
$chargedis  = $_POST['chargedis'];
$utens  = $_POST['utens'];
if ($utens == 1) {$utensmail = 'yes';}  else {$utensmail = 'no';}  
$fullserv  = $_POST['fullservice'];
if ($fullserv == 1) {$fullservmail = 'yes';}  else {$fullservmail = 'no';}
$servicecharge = mysql_real_escape_string(stripslashes($_POST['servicecharge']));

$transport  = $_POST['transport'];
if ($transport == 1) {$transportmail = 'yes';}  else {$transportmail = 'no';}  
$paper = $_POST['paper'];
if ($paper == 1) {$papermail = 'yes';}  else {$papermail = 'no';} ;

$rfname1 =  $_POST['rfname1'];
$rlname1 = $_POST['rlname1'];
$remail1  = $_POST['remail1'];
//$rareaphone1  = $_POST['rareaphone1'];
$refphone1 = $_POST['rphone1'];
//$refphone1=  $rareaphone1.'-'.$rphone1;
$rfname2 = $_POST['rfname2'];
$rlname2  = $_POST['rlname2'];
$remail2  = $_POST['remail2'];
$rareaphone2  = $_POST['rareaphone2'];
$refphone2  = $_POST['rphone2'];
//$refphone2 =  $rareaphone2.'-'.$rphone2;
$rfname3  = $_POST['rfname3'];
$rlname3  = $_POST['rlname3'];
$remail3  = $_POST['remail3'];
$rareaphone3 = $_POST['rareaphone3'];
$refphone3 = $_POST['rphone3'];
$notes = $_POST['notes'];
$notes = mysql_real_escape_string(stripslashes($_POST['notes']));
$ingredients = mysql_real_escape_string(stripslashes($_POST['ingredients']));
//$refphone3 =  $rareaphone3.'-'.$rphone3;

$bmond =  $_POST['bmond'];
if ($bmond == 1) {$bmondmail = 'yes';}  else {$bmondmail = 'no';}  
$btuesd = $_POST['btuesd'];
if ($btuesd == 1) {$btuesdmail = 'yes';}  else {$btuesdmail = 'no';}  
$bwedn  = $_POST['bwedn'];
if ($bwedn == 1) {$bwednmail = 'yes';}  else {$bwednmail = 'no';}  
$bthurs  = $_POST['bthurs'];
if ($bthurs == 1) {$bthursmail = 'yes';}  else {$bthursmail = 'no';}  
$bfrid = $_POST['bfrid'];
if ($bfrid == 1) {$bfridmail = 'yes';}  else {$bfridmail = 'no';}  
$bsat = $_POST['bsat'];
if ($bsat == 1) {$bsatmail = 'yes';}  else {$bsatmail = 'no';}  
$bsund  = $_POST['bsund'];
if ($bsund == 1) {$bsundmail = 'yes';}  else {$bsundmail = 'no';}  
$lmond =  $_POST['lmond'];
if ($lmond == 1) {$lmondmail = 'yes';}  else {$lmondmail = 'no';}  
$ltuesd = $_POST['ltuesd'];
if ($ltuesd == 1) {$ltuesdmail = 'yes';}  else {$ltuesdmail = 'no';}  
$lwedn  = $_POST['lwedn'];
if ($lwedn == 1) {$lwednmail = 'yes';}  else {$lwednmail = 'no';}  
$lthurs  = $_POST['lthurs'];
if ($lthurs == 1) {$lthursmail = 'yes';}  else {$lthursmail = 'no';}  
$lfrid = $_POST['lfrid'];
if ($lfrid == 1) {$lfridmail = 'yes';}  else {$lfridmail = 'no';}  
$lsat = $_POST['lsat'];
if ($lsat == 1)  {$lsatmail = 'yes';}  else {$lsatmail = 'no';}  
$lsund  = $_POST['lsund'];
if ($lsund == 1) {$lsundmail = 'yes';}  else {$lsundmail = 'no';}  
$dmond =  $_POST['dmond'];
if ($dmond == 1) {$dmondmail = 'yes';}  else {$dmondmail = 'no';}  
$dtuesd = $_POST['dtuesd'];
if ($dtuesd == 1) {$dtuesdmail = 'yes';}  else {$dtuesdmail = 'no';}  
$dwedn  = $_POST['dwedn'];
if ($dwedn == 1) {$dwednmail = 'yes';}  else {$dwednmail = 'no';}  
$dthurs  = $_POST['dthurs'];
if ($dthurs == 1) {$dthursmail = 'yes';}  else {$dthursmail = 'no';}  
$dfrid = $_POST['dfrid'];
if ($dfrid == 1) {$dfridmail = 'yes';}  else {$dfridmail = 'no';}  
$dsat = $_POST['dsat'];
if ($dsat == 1) {$dsatmail = 'yes';}  else {$dsatmail = 'no';}  
$dsund  = $_POST['dsund'];
if ($dsund == 1) {$dsundmail = 'yes';}  else {$dsundmail = 'no';}  


$sql2 = "UPDATE `vendor_infoNY` SET `vendinfo_delNY`='$deliver',`vendinfo_speczone`='$speczone',`vendinfo_zone1`='$zone1',`vendinfo_zone2`='$zone2',`vendinfo_zone3`='$zone3',`vendinfo_zone4`='$zone4',`vendinfo_delfee`='$delfee',`vendinfo_typefee`='$typefee' ,`vendinfo_ordminNY`='$orderminNY',`vendinfo_delfeeNY`='$delfeeNY',`vendinfo_typefeeNY`='$typefeeNY' ,`vendinfo_delBQB`='$deliverBQB',`vendinfo_delfeeBQB`='$delfeeBQB',`vendinfo_typefeeBQB`='$typefeeBQB',`vendinfo_limitBQB`='$limitBQB',`vendinfo_delWJ`='$deliverWJ',`vendinfo_delfeeWJ`='$delfeeWJ',`vendinfo_typefeeWJ`='$typefeeWJ',`vendinfo_limitWJ`='$limitWJ', `vendinfo_delcap`='$capacity',`vendinfo_notice`='$notice',`vendinfo_chafdis`='$chafdis',`vendinfo_charge`='$chargedis',`vendinfo_utens`='$utens',`vendinfo_fullserv`='$fullserv',`vendinfo_servcharge`='$servicecharge',`vendinfo_transport`='$transport', `notes`='$notes',`vendinfo_paper`='$paper',`ingredients`='$ingredients' WHERE vendinfo_email = '$email'
";
mysql_query($sql2) or die('SQL error !'.$sql2.'<br>'.mysql_error());


$res = mysql_query("SELECT * FROM vendor_infoNY where vendinfo_email = '$email'");
$idtmp = mysql_fetch_assoc($res);
$id= $idtmp['vendinfo_id'];
$bname = $idtmp['vendinfo_bname'];
$fnamemail = $idtmp['vendinfo_fname'];
$lnamemail= $idtmp['vendorinfo_lname'];
$primphonemail = $idtmp['vendinfo_primphone'];
$primtypemail = $idtmp['vendinfo_primtype'];
$secphonemail = $idtmp['vendinfo_secphone'];
$sectypemail = $idtmp['vendinfo_sectype'];
$str1mail = $idtmp['vendinfo_str1'];
$str2mail = $idtmp['vendinfo_str2'];
$citymail = $idtmp['vendinfo_city'];
$zipmail = $idtmp['vendinfo_zip'];
$statemail = $idtmp['vendinfo_state'];
$countrymail = $idtmp['vendinfo_country'];
	
if ($rfname1 != '') {
$sql3 = "INSERT INTO `vendor_info_refNY`(`ref_id`, `fname_ref`, `lname_ref`, `email_ref`, `phone_ref`, `id_vendor_info`) VALUES ('','$rfname1','$rlname1','$remail1','$refphone1','$id')";
mysql_query($sql3) or die('SQL error !'.$sql3.'<br>'.mysql_error());	
}
if ($rfname2 != '') {
$sql3 = "INSERT INTO `vendor_info_refNY`(`ref_id`, `fname_ref`, `lname_ref`, `email_ref`, `phone_ref`, `id_vendor_info`) VALUES ('','$rfname2','$rlname2','$remail2','$refphone2','$id')";
mysql_query($sql3) or die('SQL error !'.$sql3.'<br>'.mysql_error());	
}
if ($rfname3 != '') {
$sql3 = "INSERT INTO `vendor_info_refNY`(`ref_id`, `fname_ref`, `lname_ref`, `email_ref`, `phone_ref`, `id_vendor_info`) VALUES ('','$rfname3','$rlname3','$remail3','$refphone3','$id')";
mysql_query($sql3) or die('SQL error !'.$sql3sql.'<br>'.mysql_error());	
}

if ($bmond == '1' or $btuesd == '1' or $bwedn == '1' or $bthurs == '1' or $bfrid == '1' or $bsat == '1' or $bsund == '1'  ) {
$sql3 = "INSERT INTO `vendor_info_availNY`(`id_vnd_avail`, `type_avail`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `vnd_info_id`) VALUES ('','breakfast','$bmond','$btuesd','$bwedn','$bthurs','$bfrid','$bsat','$bsund','$id')";
mysql_query($sql3) or die('SQL error !'.$sql3sql.'<br>'.mysql_error());	
}	
if ($lmond == '1' or $ltuesd == '1' or $lwedn == '1' or $lthurs == '1' or $lfrid == '1' or $lsat == '1' or $lsund == '1'  ) {
$sql3 = "INSERT INTO `vendor_info_availNY`(`id_vnd_avail`, `type_avail`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `vnd_info_id`) VALUES ('','lunch','$lmond','$ltuesd','$lwedn','$lthurs','$lfrid','$lsat','$lsund','$id')";
mysql_query($sql3) or die('SQL error !'.$sql3sql.'<br>'.mysql_error());	
}	
if ($dmond == '1' or $dtuesd == '1' or $dwedn == '1' or $dthurs == '1' or $dfrid == '1' or $dsat == '1' or $bsund == '1'  ) {
$sql3 = "INSERT INTO `vendor_info_availNY`(`id_vnd_avail`, `type_avail`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `vnd_info_id`) VALUES ('','dinner','$dmond','$dtuesd','$dwedn','$dthurs','$dfrid','$dsat','$dsund','$id')";
mysql_query($sql3) or die('SQL error !'.$sql3sql.'<br>'.mysql_error());	
}


$body2='<h3>New vendor from New York</h3><br />
Email: '.$email.'<br />
Business Name: '.$bname.'<br />
First name: '.$fnamemail.'<br />
Last name: '.$lnamemail.'<br />
Primary Phone Number: '.$primphonemail.'<br />
Primary Phone Type: '.$primtypemail.'<br />
Secondary Phone Number: '.$secphonemail.'<br />
Secondary Phone Type: '.$sectypemail.'<br />
Street: '.$str1mail.'<br />
Street 2nd line: '.$str2mail.'<br />
City: '.$citymail.'<br />
Zip Code: '.$zipmail.'<br />
State: '.$statemail.'<br />
<br /><br />



<h3>Delivery Area & Order Sizes</h3><br />
Delivery to NY: '.$delivermail.'<br />';
if ($delivermail=='yes') {
$body2.='Delivery charge within Manhattan: '.$delfee." ".$typefee.'<br />';
if ($speczonechoice=='1'){ 
if ($zone1!=''){ 
$body2.='Delivery specific zone for NY: '.$zone1.'<br />'; }
if ($zone2!=''){ 
$body2.='Delivery specific zone for NY: '.$zone2.'<br />'; }
if ($zone3!=''){ 
$body2.='Delivery specific zone for NY: '.$zone3.'<br />'; }
if ($zone4!=''){ 
$body2.='Delivery specific zone for NY: '.$zone4.'<br />'; }
}
if ($delfeeNY!=''){ 
$body2.='Order Mimimum NY: '.$orderminNY.'<br />
Delivery fees for NY: '.$delfeeNY." ".$typefeeNY.'<br />'
; }}

$body2.='Delivery to Brooklyn/Queens/the Bronx: '.$deliverBQBmail.'<br />';
if ($deliverBQBmail=='yes') {
if ($delfeeBQB!=''){ 
$body2.='Delivery charge for Brooklyn/Queens/the Bronx: '.$delfeeBQB." ".$typefeeBQB.'<br />
Upper limit for this delivery fee for Brooklyn/Queens/the Bronx: '.$limitBQB.'<br />'; }}

$body2.='Delivery to outside the city, to Westchester or Jersey City:'.$deliverWJmail.'<br />';
if ($deliverWJmail=='yes') {
if ($delfeeWJ!=''){ 
$body2.='Delivery charge for outside the city, to Westchester or Jersey City: '.$delfeeWJ." ".$typefeeWJ.'<br />
Upper limit for this delivery fee for outside the city, to Westchester or Jersey City: '.$limitWJ.'<br />'; }}


$body2.='<h3>Capacity</h3><br />
Number of simultaneous deliveries : '.$capacity.'<br />
orders with less than 24 hours notice: '.$noticemail.'<br />
<h3>Catering materials</h3><br />
Providing chafing dishes: '.$chafdismail.'<br />';
if ($chafdismail=='yes'){ 
$body2.='Charge extra for the chafing dishes: '.$chargedis.'<br /> '; }
$body2.='
Providing full service catering: '.$fullservmail.'<br />';
if ($fullservmail=='yes'){ 
$body2.='Service charges involved: '.$servicecharge.'<br /> '; }
$body2.='
Providing plastic serving utensils for all orders : '.$utensmail.'<br />
Ability to transport a large order : '.$transportmail.'<br />
Providing paperware & utensils upon request : '.$papermail.'<br />

<h3>Delivery Availability</h3><br />
<table border="1">
<tr><td></td><td>Monday</td><td> Tuesday</td><td> Wednesday</td><td>Thursday</td><td>Friday</td><td> Saturday</td><td>Sunday</td>
</tr>
<tr>
<td>Breakfast</td><td>'.$bmondmail.'</td><td>'.$btuesdmail.'</td><td>'.$bwednmail.'</td><td>'.$bthursmail.'</td><td>'.$bfridmail.'</td><td>'.$bsatmail.'</td><td>'.$bsundmail.'</td></tr>

<tr><td>Lunch</td><td>'.$lmondmail.'</td><td>'.$ltuesdmail.'</td><td>'.$lwednmail.'</td><td>'.$lthursmail.'</td><td>'.$lfridmail.'</td><td>'.$lsatmail.'</td><td>'.$lsundmail.'</td></tr>

<tr><td>Dinner</td><td>'.$dmondmail.'</td><td>'.$dtuesdmail.'</td><td>'.$dwednmail.'</td><td>'.$dthursmail.'</td><td>'.$dfridmail.'</td><td>'.$dsatmail.'</td><td>'.$dsundmail.'</td></tr>
</tr>
</table>
<br /><br />

<h3>References</h3><br />';
if ($rfname1!=''){ 
$body2.='
Reference 1 name : '.$rfname1.' '.$rlname1.'<br />
Reference 1 email: '.$remail1.'<br />
Reference 1 phone number: '.$refphone1.'<br />'; }
if ($rfname2!=''){ 
$body2.='
Reference 2 name: '.$rfname2.' '.$rlname2.'<br />
Reference 2 email: '.$remail2.'<br />
Reference 2 phone number: '.$refphone1.'<br />'; }
if ($rfname3!=''){ 
$body2.='
Reference 3 name: '.$rfname3.' '.$rlname3.'<br />
Reference 3 email: '.$remail3.'<br />
Reference 3 phone number: '.$refphone3.'<br />'; }
if ($notes!='' or ingredients !='' ){
$body2.='
<h3>Notes</h3><br />
Sources of ingredients :'.$ingredients.'<br />
Notes:'.$notes.'
'; }
$body2.='


<h3>Fees</h3><br />
 charged as follows: 1-10 people: '.$fee1.'% of pretax total, 11-25 people: '.$fee2.'% of pre-tax total, 26+ people: '.$fee3.'% of pre-tax total.';
 if  ($fee4 == '0' ) {} else {
$fee5 = $fee4 - $fee3;
$body2.='Orders over 100 people will be charged a '.$fee5.'% client management fee.'; }
$body2.='
';


sendMail('pauline@cater2.me','New vendor profile information - New York',$body2,true);		
sendMail('alex@cater2.me','New vendor profile information - New York',$body2,true);		
sendMail('emma@cater2.me','New vendor profile information - New York',$body2,true);		

}


}

?> 
<?
$template = array(
	'title' => 'Cater2.me | Vendor Information',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Signup Information '=>'/dashboard/vendors_info/'),
	'menu_selected' => 'dashboard',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
				<script src="/js/custom/jquery.js"></script>


		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
	
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
		
			$(function()
		{
		var date1 = $("#date1").datepicker({ dateFormat: "yy-mm-dd" });
		$("#date1").datepicker();
		});
		
		function afficher(id)
		{
		document.getElementById(id).style.display="block";
		}
		function terms() {
	simpleModal("/termsNY.php",900,500);
		}

		</script>
		
		<style>
		
		table {
		border:0px;
		}
		td{
		vertical-align:middle;
		border:0px;}
		
		.container_12 .grid_7 {
   		 width: 900px;
}
		.container_12 .grid_6 {
		  width:600px;
		}
		.indent
		{
		padding-left:40px;
		}
		
		</style>
	',
	
	'grey_bar' => $redbar
	);

require 'header.php';


?>


<script type="text/javascript">

$(document).ready(function(e) {

			var checkedAttrValue = 'checked';
			var weekdays         = $('#checkbox-container input[type="checkbox"]');
			var weekenddays      = $('#checkbox-container input[type="checkbox"]:not(.weekend-day)');
			
			var checkTargets = function(checkboxes) {
					checkboxes.map(function() {
						var checkbox = $(this);
						if(checkbox.attr('checked') == checkedAttrValue) {
							checkbox.removeAttr('checked');
						}
						else {
							checkbox.attr('checked', 'checked');
						}
					});			
			};			
			$('#checkbox-toggle-d-a-m').click( function() { checkTargets(weekdays); });
		
			$('#checkbox-toggle-w-a-m').click( function() { checkTargets(weekenddays); });	
			
		});

function checkEmail(email) {
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(email))
		return false;
	
	return true;
}

function checkNb(text) {
	if (isNaN(text) ==true )
		return false;
	return true;
}

function checkSizeNb(text) {
	if (text.length > 5  )
		return false;
	return true;
}
function checkSizeNb2(text) {
	if (text.length > 15 )
		return false;
	return true;
}

function validate() {

	if(document.getElementById("bname").value=="")
	{
	alert("Please enter your business name");
	return false;
	}
	if(document.getElementById("fname").value=="")
	{
	alert("Please enter your first name");
	return false;
	}
	if(document.getElementById("lname").value=="")
	{
	alert("Please enter your last name");
	return false;
	}
	if(!checkSizeNb2(document.getElementById("phone1").value))
	{
	alert("Please indicate a valid phone number");
	return false;
	}
	if(document.getElementById("phone1").value=="")
	{
	alert("Please enter your phone number");
	return false;
	}

	if(document.getElementById("phoneType1").value=="")
	{
	alert("Please enter your phone type");
	return false;
	}
	if(document.getElementById("street1").value=="")
	{
	alert("Please enter your street address");
	return false;
	}
	if(document.getElementById("city").value=="")
	{
	alert("Please enter your city");
	return false;
	}
	if(document.getElementById("state").value=="")
	{
	alert("Please enter your state");
	return false;
	}
	if(!checkSizeNb(document.getElementById("zip").value))
	{
	alert("Please enter a valid zip");
	return false;
	}
	if(document.getElementById("zip").value=="")
	{
	alert("Please enter your zip code");
	return false;
	}
	if(!checkEmail(document.getElementById("email").value))
	{
	alert("Please enter a valid e-mail address");
	return false;
	}
	if(document.getElementById("country").value=="")
	{
	alert("Please enter your country");
	return false;
	}

	return true;
}



function validate2() {

	if(!checkNb(document.getElementById("orderminNY").value))
	{
	alert("Please indicate a number for order minimum for NY orders ");
	return false;
	}
	if(!checkNb(document.getElementById("delfee").value))
	{
	alert("Please indicate a number for delivery fee within Manhattan ");
	return false;
	}
	if(!checkNb(document.getElementById("delfeeNY").value))
	{
	alert("Please indicate a number for delivery fee for NY ");
	return false;
	}
	if(!checkNb(document.getElementById("limitBQB").value))
	{
	alert("Please indicate a number for the upper limit for Brooklyn/Queens/the Bronx orders ");
	return false;
	}
	if(!checkNb(document.getElementById("delfeeBQB").value))
	{
	alert("Please indicate a number for delivery fee for Brooklyn/Queens/the Bronx ");
	return false;
	}
	if(!checkNb(document.getElementById("limitWJ").value))
	{
	alert("Please indicate a number for the upper limit for outside the city, Westchester or Jersey City orders ");
	return false;
	}
	if(!checkNb(document.getElementById("delfeeWJ").value))
	{
	alert("Please indicate a number for delivery fee for outside the city, Westchester or Jersey City");
	return false;
	}
	if(!checkNb(document.getElementById("capacity").value))
	{
	alert("Please indicate a number for the number of simultaneous deliveries you're capable of");
	return false;
	}
	
	if(!checkNb(document.getElementById("chargedis").value))
	{
	alert("Please indicate a number for the charge extra for the chafing dishes");
	return false;
	}
	
	return true;
}


function show_divNY1(id)
{
for (var i = 1; i <= 4; i++) {
if (i == id) {
document.getElementById('divNY_' + i).style.display = 'block';
} else
{
document.getElementById('divNY_' + i).style.display = 'none';
}}}

function show_divNY2(id)
{
for (var i = 1; i <= 4; i++) {
if (i == id) {
document.getElementById('divNY2_' + i).style.display = 'block';
} else
{
document.getElementById('divNY2_' + i).style.display = 'none';
}}}

function show_divNY3(id)
{
for (var i = 1; i <= 4; i++) {
if (i == id) {
document.getElementById('divNY3_' + i).style.display = 'block';
} else
{
document.getElementById('divNY3_' + i).style.display = 'none';
}}}

function show_divNY4(id)
{
for (var i = 1; i <= 4; i++) {
if (i == id) {
document.getElementById('divNY4_' + i).style.display = 'block';
} else
{
document.getElementById('divNY4_' + i).style.display = 'none';
}}}

function show_divBQB1(id)
{
for (var i = 1; i <= 4; i++) {
if (i == id) {
document.getElementById('divBQB_' + i).style.display = 'block';
} else
{
document.getElementById('divBQB_' + i).style.display = 'none';
}}}
function show_divBQB2(id)
{
for (var i = 1; i <= 4; i++) {
if (i == id) {
document.getElementById('divBQB2_' + i).style.display = 'block';
} else
{
document.getElementById('divBQB2_' + i).style.display = 'none';
}}}

function show_divWJ1(id)
{
for (var i = 1; i <= 4; i++) {
if (i == id) {
document.getElementById('divWJ_' + i).style.display = 'block';
} else
{
document.getElementById('divWJ_' + i).style.display = 'none';
}}}
function show_divWJ2(id)
{
for (var i = 1; i <= 4; i++) {
if (i == id) {
document.getElementById('divWJ2_' + i).style.display = 'block';
} else
{
document.getElementById('divWJ2_' + i).style.display = 'none';
}}}
function show_divmat(id)
{
for (var i = 1; i <= 4; i++) {
if (i == id) {
document.getElementById('divmat_' + i).style.display = 'block';
} else
{
document.getElementById('divmat_' + i).style.display = 'none';
}}}

function show_divmatserv(id)
{
for (var i = 1; i <= 4; i++) {
if (i == id) {
document.getElementById('divmatserv_' + i).style.display = 'block';
} else
{
document.getElementById('divmatserv_' + i).style.display = 'none';
}}}

function ValideForm() {
	if(document.getElementById('btnaccepte').checked == true) {document.getElementById('btmvalide').disabled = false }
	if(document.getElementById('btnaccepte').checked == false) {document.getElementById('btmvalide').disabled = true }
}

</script>

<?

if ($form==2){
echo $body;}
else if ($form==3 or $form==1){

if ($form==1){
?>
<form method="post"  onsubmit="return validate2();">
<div class="grid_7" id="contact-page">

<input type="hidden" name="email1" value="<?=$email?>" />
<b>Delivery Area & Order Sizes</b><br><br>

<table width="100%">
<tr>
<td width="40%">Can you deliver to Manhattan? </td><td><input type="radio" name="deliverNY" value="1" onclick="show_divNY1(1)" > yes
<input type="radio" name="deliverNY" value="0" checked="checked" onclick="show_divNY1(2)"> no</td>
</tr>
</table>


<div id="divNY_1" style="display: none">
<table width="100%">
<tr>
<td class="indent" width="40%">If yes, do you have a specific delivery zone for normal deliveries?</td><td><input type="radio" name="speczonechoice" value="1" onclick="show_divNY3(1)" > yes<input type="radio" name="speczonechoice" onclick="show_divNY3(2)" checked="checked" value="no"  > No</td></tr></table>
<div id="divNY3_1" style="display: none">
<table width="100%">
<tr>
<td width="40%"><input type="text" id="zone1" name="zone1" placeholder="North Boundary"/>&nbsp;&nbsp;<input type="text" id="zone2" name="zone2" placeholder="East Boundary"/>&nbsp;&nbsp;<input type="text" id="zone3" name="zone3" placeholder="South Boundary"/>&nbsp;&nbsp;<input type="text" id="zone4" name="zone4" placeholder="West Boundary"/>
</td>
</tr>
</table>
</div>
<div id="divNY3_2" style="display:block"></div>
</table>
<table width="100%">
<tr>
<td width="40%" class="indent">Do you have a delivery charge within Manhattan?</td><td><input type="radio" name="delfeechoiceNY" value="1"  onclick="show_divNY4(1)"> yes
<input type="radio" name="delfeechoiceNY"  checked="checked" value="0"  onclick="show_divNY4(2)"> no </td></tr>
</table>
<div id="divNY4_1" style="display: none">
<table width="100%">
<tr><td width="40%" class="indent">What is the delivery charge?</td><td><input type="text" name="delfee" id="delfee" /> <select name = "typefee">
<option>$</option>
<option>%</option>
</select></td>
</tr>
</table>
</div>
<div id="divNY4_2" style="display:block"></div>
<table width="100%">
<tr>
<td width="40%" class="indent">If you have a limited delivery boundary, would you deliver for an increased delivery fee or a large order?</td><td><input type="radio" name="delboundNY" value="1" onclick="show_divNY2(1)" > yes
<input type="radio" name="delboundNY"  checked="checked" value="0" onclick="show_divNY2(2)"> no </td></tr>
</table>

<div id="divNY2_1" style="display: none">
<table width="100%">
<tr><td width="40%" class="indent">Specify the minimum for orders outside delivery zone in Manhattan</td><td><input type="text" name="orderminNY" id="orderminNY"/></td>
</tr>
<tr><td width="40%" class="indent">Specify the delivery fee for orders in Manhattan outside of normal delivery zone</td><td><input type="text" name="delfeeNY" id="delfeeNY" /> <select name = "typefeeNY">
<option>$</option>
<option>%</option>
</select></td>
</tr>
</table>
</div>

<div id="divNY2_2" style="display:block"></div>
</table>
</div>
<div id="divNY_2" style="display: block"></div>


<table width="100%">
<tr>
<td width="40%">Can you deliver to Brooklyn/Queens/the Bronx? </td><td><input type="radio" name="deliverBQB" value="1"  onclick="show_divBQB1(1)" > yes
<input type="radio" name="deliverBQB" value="0" checked="checked" onclick="show_divBQB1(2)"> no</td>
</tr>
</table>

<div id="divBQB_1" style="display: none">
<table width="100%">
<tr>
<td width="40%" class="indent">Do you have a delivery fees for orders in Brooklyn/Queens/the Bronx?</td><td><input type="radio" name="delfeechoiceBQB" value="1" onclick="show_divBQB2(1)" > yes
<input type="radio" name="delfeechoiceBQB"  checked="checked" value="0" onclick="show_divBQB2(2)"> no </td></tr>
</table>
<div id="divBQB2_1" style="display: none">
<table width="100%">
<tr>
<td width="40%" class="indent"> What is your delivery charge?</td><td><input type="text" name="delfeeBQB" id="delfeeBQB" /> <select name = "typefeeBQB">
<option>$</option>
<option>%</option>
</select></td>
</tr>
<tr>
<td width="40%" class="indent">What is the upper limit for this delivery fee?</td><td><input type="text" name="limitBQB" id="limitBQB"/></td></tr>
</table>
</div>

<div id="divBQB2_2" style="display:block"></div>
</table>
</div>
<div id="divBQB_2" style="display: block"></div>

<table width="100%">
<tr>
<td width="40%">Can you deliver outside the city, to Westchester or Jersey City? </td><td><input type="radio" name="deliverWJ" value="1"  onclick="show_divWJ1(1)" > yes
<input type="radio" name="deliverWJ" value="0" checked="checked" onclick="show_divWJ1(2)"> no</td>
</tr>
</table>
<div id="divWJ_1" style="display: none">
<table width="100%">
<tr>
<td width="40%" class="indent">Do you have a delivery fees for outside the city, to Westchester or Jersey City?</td><td><input type="radio" name="delfeechoiceWJ" value="1" onclick="show_divWJ2(1)" > yes
<input type="radio" name="delfeechoiceWJ"  checked="checked" value="0" onclick="show_divWJ2(2)"> no </td></tr>
</table>
<div id="divWJ2_1" style="display: none">
<table width="100%">
<tr>
<td width="40%" class="indent"> What is your delivery charge?</td><td><input type="text" name="delfeeWJ" id="delfeeWJ"/> <select name = "typefeeWJ">
<option>$</option>
<option>%</option>
</select></td>
</tr>
<tr>
<td width="40%" class="indent">What is the upper limit for this delivery fee?</td><td><input type="text" name="limitWJ" id="limitWJ"/></td></tr>
</table>
</div>
<div id="divWJ2_2" style="display:block"></div>
</table>
</div>
<div id="divWJ_2" style="display: block"></div>


<b>Delivery Availability</b><br><br>

	<div id="checkbox-header">
			<input type="checkbox" id="checkbox-toggle-d-a-m"/>&nbsp;&nbsp;All days and meals
			<input type="checkbox" id="checkbox-toggle-w-a-m"/>&nbsp;&nbsp;All weekdays and meals
		</div></td>
<table id="checkbox-container"  width="100%">

<tr>
<td></td><td>Monday</td><td> Tuesday</td><td> Wednesday</td><td>Thursday</td><td>Friday</td><td> Saturday</td><td>Sunday</td>
</tr>
<tr>
				<td>Breakfast</td>
				<td><input type="checkbox" name="bmond"  value="1"/></td>
				<td><input type="checkbox" name="btuesd" value="1"/></td>
				<td><input type="checkbox" name="bwedn"  value="1"/></td>
				<td><input type="checkbox" name="bthurs" value="1"/></td>
				<td><input type="checkbox" name="bfrid"  value="1"/></td>
				<td><input type="checkbox" name="bsat"   value="1" class="weekend-day"/></td>
				<td><input type="checkbox" name="bsund"  value="1" class="weekend-day"/></td>
			</tr>

			<tr>
				<td>Lunch</td>
				<td><input type="checkbox" name="lmond"  value="1"/></td>
				<td><input type="checkbox" name="ltuesd" value="1"/></td>
				<td><input type="checkbox" name="lwedn"  value="1"/></td>
				<td><input type="checkbox" name="lthurs" value="1"/></td>
				<td><input type="checkbox" name="lfrid"  value="1"/></td>
				<td><input type="checkbox" name="lsat"   value="1" class="weekend-day"/></td>
				<td><input type="checkbox" name="lsund"  value="1" class="weekend-day"/></td>
			</tr>

			<tr>
				<td>Dinner</td>
				<td><input type="checkbox" name="dmond"  value="1"/></td>
				<td><input type="checkbox" name="dtuesd" value="1"/></td>
				<td><input type="checkbox" name="dwedn"  value="1"/></td>
				<td><input type="checkbox" name="dthurs" value="1"/></td>
				<td><input type="checkbox" name="dfrid"  value="1"/></td>
				<td><input type="checkbox" name="dsat"   value="1" class="weekend-day"/></td>
				<td><input type="checkbox" name="dsund"  value="1" class="weekend-day"/></td>
			</tr>	

</table>

<b>Capacity</b><br><br>
<table width="100%">
<tr><td width="40%">Number of simultaneous deliveries you're capable of:</td><td><input type="text" name="capacity" placeholder="e.g. 3" id="capacity"/></td></tr>
<tr><td>Can you perform orders with less than 24 hours' notice?</td><td><input type="radio" name="notice" value="1" checked="checked" > yes
<input type="radio" name="notice" value="0"> no</td></tr>
</table>

<b>Catering materials</b><br><br>
<table width="100%">
<tr><td width="40%">Can you provide meals served in chafing dishes?:</td><td><input type="radio" name="chafdis" value="1"  onclick="show_divmat(1)" > yes
<input type="radio" name="chafdis" value="0"  checked="checked"  onclick="show_divmat(2)" > no</td></tr>
</table>
<div id="divmat_1" style="display: none">
<table width="100%">
<tr><td width="40%" class="indent">If you charge extra for the chafing dishes, please indicate here:</td><td><input type="text" name="chargedis" id="chargedis"/></td></tr>
</table>
</div>
<div id="divmat_2" style="display: block"></div>
<table width="100%">
<tr><td width="40%">Can you provide plastic serving utensils for all orders (required for service)?</td><td><input type="radio" name="utens" value="1" checked="checked" > yes
<input type="radio" name="utens" value="0"> no</td></tr>
<tr><td width="40%">Can you do full service catering (e.g. servers, rentals, bar, etc.)??</td><td><input type="radio" name="fullservice" value="1"  onclick="show_divmatserv(1)"> yes
<input type="radio" name="fullservice" value="0" checked="checked" onclick="show_divmatserv(2)"> no</td></tr>
</table>
<div id="divmatserv_1" style="display: none">
<table width="100%">
<tr><td width="40%" class="indent">What are the service charges involved?</td><td><input type="text" name="servicecharge"/></td></tr>
</table>
</div>
<div id="divmatserv_2" style="display: block"></div>
<table width="100%">
<tr><td width="40%">Do you have a cart or the ability to transport a large order from your car to the client's kitchen in one trip (required for service)?</td><td><input type="radio" name="transport" value="1" checked="checked" > yes
<input type="radio" name="transport" value="0"> no</td></tr>
<tr><td>Can you provide paperware & utensils upon request (required for service)?</td><td><input type="radio" name="paper" value="1" checked="checked" > yes
<input type="radio" name="paper" value="0"> no</td></tr>


<table width="100%">
<b>References</b><br>
Please provide 3 references that can recommend our services<br><br>
<table>
<tr>
<td width="40%">Reference 1</td><td><input type="text" name="rfname1" placeholder="First name"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="rlname1" placeholder="Last name"/></td>
</tr>
<tr>
<td>Reference 1 Email</td><td><input type="email" name="remail1" placeholder="Email address"/></td>
</tr>
<tr>
<td>Reference 1 Phone Number</td><td><input type="text" name="rphone1" placeholder="Phone Number"/></td>
</tr>
<tr>
<td>Reference 2</td><td><input type="text" name="rfname2" placeholder="First name"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="rlname2" placeholder="Last name"/></td>
</tr>
<tr>
<td>Reference 2 Email</td><td><input type="email" name="remail2" placeholder="Email address"/></td>
</tr>
<tr>
<td>Reference 2 Phone Number</td><td><input type="text" name="rphone2" placeholder="Phone Number"/></td>
</tr>
<tr>
<td>Reference 3</td><td><input type="text" name="rfname3" placeholder="First name"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="rlname3" placeholder="Last name"/></td>
</tr>
<tr>
<td>Reference 3 Email</td><td><input type="email" name="remail3" placeholder="Email address"/></td>
</tr>
<tr>
<td>Reference 3 Phone Number</td><td><input type="text" name="rphone3" placeholder="Phone Number"/></td>
</tr>
</table>
<b>Notes</b><br>
<table width="100%">	<tr><td width="40%">Where do you source a majority of your ingredients?</td><td><textarea placeholder="e.g. commercial distributor, local farms, restaurant supply company" rows="2" cols="40" name="ingredients"> 
	</textarea></td></tr>
<tr><td width="40%">Please use this text box to clarify any of the responses to the questions above</td><td><textarea rows="2" cols="40" name="notes"> 
</textarea></td></tr>


<tr>
<td colspan="2">Summary of terms:
<ul>
<li><b>Fees:</b> charged as follows: 1-10 people: <?=$fee1?>% of pretax total, 11-25 people: <?=$fee2?>% of pre-tax total, 26+ people: <?=$fee3?>% of pre-tax total.
<? if  ($fee4 == '0' ) {} else {?>
 Orders over 100 people will be charged a <?=$fee4 - $fee3?>% client management fee. <? } ?>
</li>
<li><b>Payment terms:</b> We will pay you, net of our fee, on a monthly basis, by the 15th of the month following an order.
</li>
<li><b>Sales tax:</b> We pay sales tax on all orders (per the mandate of the tax authority). Resale certificate available upon request. 
</li>
<li><b>Credit cards:</b> For orders paid by credit card (small portion of overall orders), credit card fees are charged and we split the credit card fees with you.
</li>
</ul>
</td></tr>
<tr><td></td></tr>
<tr><td colspan="2">By clicking this box, I accept Cater2.me's terms outlined above and <a href="#" onclick="javascript:terms(); return false;">terms of service.</a> *&nbsp;&nbsp;<input type="checkbox" id="btnaccepte" value="valeur" onClick="ValideForm()" /> 
</td></tr>
<tr><td></td></tr>
</table>
<input type="submit"  id="btmvalide" name = "Send2"  value="Send"  disabled/>
</div>
</form>
<? }
 else { ?>
<form method="post" onsubmit="return validate();">
<div class="grid_7" id="contact-page">
<!-- <form method="post"> -->
Please fill out all of the information below so we can set up your Cater2.me profile<br><br>
<b>Vendor Contact Info</b>
<table>
<tr>
<td>Business Name *</td><td><input type="text" id="bname" name="bname" placeholder="Business name"/></td>
</tr>
<tr>
<td>Contact Name *</td><td><input type="text" id="fname" name="fname" placeholder="First name"/>&nbsp;&nbsp;<input type="text" id="lname" name="lname" placeholder="Last name"/></td>
</tr>
<tr>
<td>Email *</td><td><input type="email"  id="email"  name="email" placeholder="Email"/></td>
</tr>
<tr>
<td>Primary Phone Number *</td><td> <input type="text" id="phone1" name="phone1" placeholder="i.e (555) 555-5555"/>&nbsp;&nbsp;
Primary Phone Type *&nbsp;&nbsp;<select id="phoneType1" name = "phoneType1">
<option></option>
<option>Restaurant</option>
<option>Cell Phone</option>
</select> </td>
</tr>
<tr>
<td>Secondary Phone Number</td><td><input type="text" name="phone2" placeholder="i.e (555) 555-5555"/>&nbsp;&nbsp;Secondary Phone Type&nbsp;&nbsp;<select name = "phoneType2">
<option></option>
<option>Restaurant</option>
<option>Cell Phone</option>
</select> </td>
</tr>
<tr>
<td>Address *</td><td><input type="text" id="street1" style="width:510px;" name="street1" placeholder="Street Address"/></td>
</tr>
<tr>
<td></td><td><input type="text" name="street2" style="width:510px;" placeholder="Street Address Line 2"/></td>
</tr>
<tr>
<td></td><td><input type="text" id="city" name="city" placeholder="City"/>&nbsp;&nbsp;
<select name="state" id="state">
	<option value="AL">Alabama</option>
	<option value="AK">Alaska</option>
	<option value="AZ">Arizona</option>
	<option value="AR">Arkansas</option>
	<option value="CA">California</option>
	<option value="CO">Colorado</option>
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="DC">District of Columbia</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="HI">Hawaii</option>
	<option value="ID">Idaho</option>
	<option value="IL">Illinois</option>
	<option value="IN">Indiana</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="MT">Montana</option>
	<option value="NE">Nebraska</option>
	<option value="NV">Nevada</option>
	<option value="NH">New Hampshire</option>
	<option value="NJ">New Jersey</option>
	<option value="NM">New Mexico</option>
	<option selected="NY" value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="ND">North Dakota</option>
	<option value="OH">Ohio</option>
	<option value="OK">Oklahoma</option>
	<option value="OR">Oregon</option>
	<option value="PA">Pennsylvania</option>
	<option value="RI">Rhode Island</option>
	<option value="SC">South Carolina</option>
	<option value="SD">South Dakota</option>
	<option value="TN">Tennessee</option>
	<option value="TX">Texas</option>
	<option value="UT">Utah</option>
	<option value="VT">Vermont</option>
	<option value="VA">Virginia</option>
	<option value="WA">Washington</option>
	<option value="WV">West Virginia</option>
	<option value="WI">Wisconsin</option>
	<option value="WY">Wyoming</option>
</select>
&nbsp;&nbsp;
<input type="text" id="zip" name="zip" placeholder="Postal/Zip Code"/></td>
</tr>
<tr><td></td><td><input type="submit" name = "Send"  value="Proceed to page 2 (of 2)" style="cursor:pointer;" />
</td></tr>
</table>

</div>
</form>
<? }}

else {?>
<h2>Please enter the email address to which Cater2.me sent this link</h2>
<form method="post">
<div class="grid_7" id="contact-page">
<input type="email" id="" name="email_form" placeholder="email"/>
<input type="hidden" name="emaildb" value="<?=$emaildb?>" />
<input type="hidden" name="id" value="<?=$id?>" />
<input type="submit"  name = "Submitemail"  value="Submit" style="cursor:pointer;" />
</form>

</div>

<? }
require 'footer.php';

?>