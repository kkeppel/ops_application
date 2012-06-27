<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');
$message ='';

if($_SERVER['REQUEST_METHOD']=='POST')
{
 
$form=1;
//$body =  'Thank you, we will contact you soon';

$email  = $_POST['email'];
$location = $_POST['location'];
$fee1  = $_POST['fee1'];
$fee2  = $_POST['fee2'];
$fee3  = $_POST['fee3'];
$managfee = $_POST['managfee'];
if ($managfee == 1)
{
$fee4  = $_POST['fee4'];
} else {$fee4  = '0';}

$idres = mysql_query("SELECT max(id_vndform) as id from vendor_form		");
$idtmp = mysql_fetch_assoc($idres);
$id = number_format($idtmp['id']);
$id2 = $id + 1 ;
//$hash =((((( $id2 *2)+2) /152)-5));
$hash =((((( $id2 +5)*152) -2)/2));

$sql = "INSERT INTO `vendor_form`(`id_vndform`, `email_vndform`, `location`, `fee1`, `fee2`, `fee3`, `fee4`, `hash`) VALUES('','$email','$location','$fee1','$fee2','$fee3','$fee4','$hash')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	

if ($location == 'NY')
{ $body = 'Thanks, you can send this link : http://cater2.me/vendors_infoNY.php?a='.$hash; }
else if ($location == 'SF')
{ $body = 'Thanks, you can send this link : http://cater2.me/vendors_infoSF.php?a='.$hash; }
else if ($location == 'SB')
{ $body = 'Thanks, you can send this link : http://cater2.me/vendors_infoSB.php?a='.$hash; }

}

?> 
<?
$template = array(
	'title' => 'Cater2.me | Vendor Information',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Signup Information '=>'/dashboard/send_VForm/'),
	'menu_selected' => 'dashboard',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>

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
		</style>
	',
	
	'grey_bar' => 'Send Vendor Form'
	);

require 'header.php';


?>


<script type="text/javascript">

function checkEmail(email) {
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!filter.test(email))
		return false;
	
	return true;
}

function validate() {

	if(!checkEmail(document.getElementById("email").value))
	{
	alert("Please enter a valid e-mail address");
	return false;
	}		
	return true;
}

function show_div(id)
{
for (var i = 1; i <= 2; i++)
{
if (i == id)
{
document.getElementById('div_' + i).style.display = 'block';
}
else
{
document.getElementById('div_' + i).style.display = 'none';
}
}
}

</script>
<?
if ($form==1){
echo $body;}
else {
?>
<form method="post" onsubmit="return validate();" action="">
<div class="grid_7" id="contact-page">

<b>Select options before to send the form to vendors</b><br><br>
<table width="100%">
<tr>
<td width="35%">Email address of vendor</td><td width="60%"><input type="email" id="email" name="email"/></td>
</tr>
<tr>
<td width="35%">Location </td><td width="60%"><input type="radio" name="location" value="SF" checked="checked" > San Francisco&nbsp;&nbsp;&nbsp;
<input type="radio" name="location" value="SB" > South Bay&nbsp;&nbsp;&nbsp;<input type="radio" name="location" value="NY" > New York</td>
</tr>
</table>
<b>Fees</b>
<table width="100%">
<tr>
<td width="35%">10 or fewer people: </td><td width="60%"><input type="text" name="fee1" value="10"/> %</td></tr>
<tr><td width="35%">11 - 25 people:     </td><td width="60%"> <input type="text" name="fee2" value="15"/> % </td></tr>
<tr><td width="35%">26+ people:  </td><td width="60%"> <input type="text" name="fee3" value="20"/>       % </td></tr>
<tr><td width="35%">Client management fee over 100 people? </td><td width="60%"><input type="radio" name="managfee" value="1"  onclick="show_div(1)" > Yes&nbsp;&nbsp;&nbsp;<input type="radio" name="managfee" value="0" checked="checked" onclick="show_div(2)" > No</td></tr></table>
<div id="div_1" style="display: none">
<table width="100%">
<tr><td width="35%">100+ people:  </td><td width="60%"><input type="text" name="fee4" value="22"/>       %  </td>
</tr></table>
</div>
<div id="div_2" style="display: none"></div>


<tr><td></td><td><input type="submit"  name = "Send"  value="Send" />
</td></tr>
</table>

</div>
</form>

<? }
require 'footer.php';

?>