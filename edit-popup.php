<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');

if($_SERVER['REQUEST_METHOD']=='POST')
{
	$name_pic= $_POST['name_pic'];
	$delete = 'template/images/popup/'.$name_pic;
	
	
	$name_p=$_POST['name'];
	$new_pic =strtolower($name_p);
	$new_pic = str_replace(' ','',$new_pic);
	$new_pic = $new_pic.'_popup.jpg';
	
	$rename = 'template/images/popup/'.$new_pic;
	$bio=$_POST['bio'];
	$menu=$_POST['menu'];	
	$id = $_POST['id'];		
	$date = $_POST['date'];	  
	
			$content_dir = 'template/images/popup/'; // directory to keep picture
			$tmp_file = $_FILES['picture']['tmp_name'];
		     if( !is_uploaded_file($tmp_file) ) //check the file exists
		    {
				rename($delete, $renamet);
		    }
		    else 
		    {
				unlink($delete); 
				$type_file = $_FILES['picture']['type']; // check the extension
			    if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') )
			    {
			        notif("The file is not an image, please try again.");
			    }	
			    // copy the file into the directory
			    $name = $name_p.'_popup.jpg';
			    $urltp = strtolower($name);
			    $name_file=str_replace(' ','',$urltp); // remove the space from the name
			    if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
			    {
			        notif("Problem to upload the picture");
			    }
				    
		    }

			
$sql = "Update popup set name_popup='".$name_p."',date_popup='".$date."', bio_popup='".$bio."',menu_popup='".$menu."'  WHERE id_popup='".$id."'";
	    mysql_query($sql);
	
// supprimer photo : unlink($file_name);


redirect('/manage-popup.php');


	}

?>
<?
$template = array(
	'title' => 'Cater2.me | Add PopUp',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Edit PopUp '=>'/dashboard/edit-popup/'),
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
	
	'grey_bar' => 'Edit a PopUp'
	);

require 'header.php';
$tmp=$_GET["a"];
$res = mysql_query("SELECT * FROM vendors where id_vendor = '$tmp'");
$popup = mysql_fetch_assoc($res);
$name_popup= $popup['name'];
$bio_popup= $popup['bio_popup'];

$name_pic =strtolower($name_popup);
$name_pic = str_replace(' ','',$name_pic);
$name_pic = $name_pic.'_popup.jpg';

?>
<div>
<form method="post"  name="f" enctype="multipart/form-data">
		<table>
		<tr>
		<td width="10%">Name </td><td><input type="text" name="name" placeholder="name" value="<?=$name_popup?>" style="width:70%" /></td></tr>
		<tr>
		<td>Date </td><td> <input type="text" name="date" placeholder="date" value="<?=$date_popup?>" style="width:70%" /></td></tr>
		<tr>
		
		</table>
		<fieldset><legend>Bio</legend>
		<textarea name="bio" style="width:100%; height:70px"><?=$bio_popup?></textarea></fieldset>
		<fieldset><legend>Menu</legend>
		<textarea name="menu" style="width:100%; height:70px"><?=$menu_popup?></textarea></fieldset>
		
		Picture <input type="file" name="picture" placeholder="picture" /> (.jpg) <br>		 <input type="hidden" name="id"  value="<?=$tmp?>" />
		 <input type="hidden" name="name_pic"  value="<?=$name_pic?>" />
		<p style="margin:30px; text-align:center"><input type="submit" value="Update" /></p>
</form>
	</div>


<?
require 'footer.php';

?>