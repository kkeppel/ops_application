<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');

if($_SERVER['REQUEST_METHOD']=='POST')
{

	
	$name = mysql_real_escape_string($_POST['name']);
	$date = mysql_real_escape_string($_POST['date']);
	$bio = mysql_real_escape_string(stripslashes($_POST['bio']));
	$menu = mysql_real_escape_string(stripslashes($_POST['menu']));
	
		    
					
	if($name=='') { notif('Sorry, you have to fill the field name, please try again.');}
	    	
	else {
$sql = "INSERT INTO betakitchen(id_beta, name_beta, menu_beta, bio_beta, date_beta, order_beta) VALUES ('','$name', '$menu', '$bio','$date','0')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());		

redirect('/manage-betakitchen.php');
}
}

?>
<?
$template = array(
	'title' => 'Cater2.me | Add BetaKitchen Vendor',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Add Betakitchen '=>'/dashboard/add-beta/'),
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
		</style>
	',
	
	'grey_bar' => 'Add BetaKitchen Vendor'
	);

require 'header.php';


?>
<div>
<form method="post"  name="f" enctype="multipart/form-data">
		
		<input type="text" name="name" placeholder="name" value="" style="width:20%" /><br><br>
		<input type="text" name="date" placeholder="date betakitchen" value="" style="width:20%" /><br><br>
		
		<fieldset><legend>Bio</legend>
		<textarea name="bio" style="width:100%; height:70px"></textarea></fieldset>
		<fieldset><legend>Menu </legend>
		<textarea name="menu" style="width:100%; height:70px"></textarea></fieldset>
		<p style="margin:30px; text-align:center"><input type="submit" value="Add" /></p>
</form>
	</div>


<?
require 'footer.php';

?>