<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');

if($_SERVER['REQUEST_METHOD']=='POST')
{ 
		
	$name_p=$_POST['name'];
	$date_p=$_POST['date'];
	//$bio = str_replace("\n", "<br>", $bio);
	$bio=mysql_real_escape_string(stripslashes($_POST['bio']));
	//$bio = str_replace("\n", "<br>", $bio);

	$menu=mysql_real_escape_string(stripslashes($_POST['menu']));	
	$id = $_POST['id'];		
	
if ($menu == '')
{
$sql = "Update betakitchen set name_beta='".$name_p."', bio_beta='".$bio."',date_beta='".$date_p."'   WHERE id_beta='".$id."'";
	    mysql_query($sql);
	}
else {			
$sql = "Update betakitchen set name_beta='".$name_p."', bio_beta='".$bio."',menu_beta='".$menu."',date_beta='".$date_p."'   WHERE id_beta='".$id."'";
	    mysql_query($sql)  or die (mysql_error());
	}
// supprimer photo : unlink($file_name);

redirect('/manage-betakitchen.php');


	}

?>
<?
$template = array(
	'title' => 'Cater2.me | Edit BetaKitchen',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Edit BetaKitchen '=>'/dashboard/edit-beta/'),
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
		
		table{
		border-width : 0px;
		width: 50%;
		}
		td {
		border-width : 0px;
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
	
	'grey_bar' => 'Edit a BetaKitchen Vendor'
	);

require 'header.php';
$tmp=$_GET["a"];
$res = mysql_query("SELECT * FROM betakitchen where id_beta = '$tmp'");
$popup = mysql_fetch_assoc($res);
$name_popup= $popup['name_beta'];
$date_popup= $popup['date_beta'];
$bio_popup= $popup['bio_beta'];
$menu_popup= $popup['menu_beta'];

?>

<div>
<form method="post"  name="f" enctype="multipart/form-data">
		<table>
		<tr>
		<td width="10%">Name </td><td><input type="text" name="name" placeholder="name" value="<?=$name_popup?>" style="width:70%" /></td></tr>
<td width="10%">Date </td><td><input type="text" name="date" placeholder="date" value="<?=$date_popup?>" style="width:70%" /></td></tr>
		</table>
		<fieldset><legend>Bio</legend>
		<textarea name="bio" style="width:100%; height:70px"><?=$bio_popup?></textarea></fieldset>
		<fieldset><legend>Menu</legend>
		<textarea name="menu" style="width:100%; height:70px"><?=$menu_popup?></textarea></fieldset>
		 <input type="hidden" name="id"  value="<?=$tmp?>" />
		
		<p style="margin:30px; text-align:center"><input type="submit" value="Update" /></p>
</form>
	</div>


<?
require 'footer.php';

?>