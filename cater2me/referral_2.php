<?
require 'lib/core.php';
$msg="If you have any friends or colleagues who would benefit from our service, please let us know and we'll send you <b>$100</b> when they place their first order!";

if($_SERVER['REQUEST_METHOD']=='POST')
	{
	$name_r=$_POST['name'];
	$email_r=$_POST['email'];
	$namef_r=$_POST['namef'];
	$emailf_r=$_POST['emailf'];
	$ip=$_SERVER["REMOTE_ADDR"];

$sql = "INSERT INTO referral_email(id_ref, name_ref, email_ref, fr_name_ref, fr_email_ref, ip_address, page) VALUES ('','$name_r','$email_r','$namef_r','$emailf_r', '$ip', 'Referral Page')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	

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
mail($destinataire,
     "Referral",
     $codehtml,
     "From: $expediteur\r\n".
        "Reply-To: $reponse\r\n".
        "Content-Type: text/html; charset=\"iso-8859-1\"\r\n");



}

?>
<?
$template = array(
	'title' => 'Cater2.me | Referral',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Referral '=>'/dashboard/referral/'),
	'menu_selected' => 'dashboard',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>

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
		</script>
		
		<style>
		
		#tblHTML td {
		  height: 35px;
		  vertical-align: middle;
		}
		#tblHomeSlider {
		border:0;
		width:100%;
		}
		#tblHomeSlider td {
		border:0;
		}
		
		fieldset {
		border:1px #777 solid;
		padding:10px;
		}
		fieldset legend {
		margin-left:2px;
		}
		.del {
		color:red !important;
		}
		
		h3 {
		margin-top:10px;
		margin-bottom:30px;
		}
		label {
		font-size:1.3em
		}

		</style>
	',
	
	'grey_bar' => 'Refer a friend'
	);

require 'header.php';
?>



	<div>
<form method="post"  name="f" onsubmit="return checkEmailContact(document.f.email.value) &&  checkEmailContact(document.f.emailf.value);">

<h3>If you have any friends or colleagues who would benefit from our service, please let us know and we'll send you <b>$100</b> when they place their first order!</h3>
		
		<table style="border:0px">
		<tr></tr><td style="border:0px"><label for="email">Your name:</label></td>
		<td style="border:0px"><input type="text" name="name" placeholder="name" /></td> </tr>
		</tr><td style="border:0px"><label for="email">Your company email:</label></td>
		<td style="border:0px"><input type="email" name="email" placeholder="company email" /></td></tr>
		</tr><td style="border:0px"><label for="email">Your friend's name:</label></td>
		<td style="border:0px"><input type="text" name="namef" placeholder="friend's name" /></td></tr>
		</tr><td style="border:0px"><label for="email">Your friend's company email :</label></td>
		<td style="border:0px"><input type="email" name="emailf" placeholder="friend's company email" /></td></tr>
		
		</tr><td style="border:0px"><p style="margin:30px; text-align:center"><input type="submit" value="Submit" /></p>
					</td></tr></table>
</form>
	</div>




<?
require 'footer.php';

?>