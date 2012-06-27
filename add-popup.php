<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');

if($_SERVER['REQUEST_METHOD']=='POST')
{

	$name_picture1 = ($_POST['name']);
	$name_p = mysql_real_escape_string($_POST['name']);
	$desc_p = mysql_real_escape_string($_POST['description']);
	$bio = mysql_real_escape_string(stripslashes($_POST['bio']));
	$bio = mysql_real_escape_string(stripslashes($_POST['menu']));
	$date_popup = $_POST['date'];				    
		    
			$content_dir = 'template/images/popup/'; // directory to keep picture
			$tmp_file = $_FILES['picture']['tmp_name'];
		     if( !is_uploaded_file($tmp_file) ) //check the file exists
		    {
		        notif('Sorry, the file does not exist, please try again.');
		    }
			
			$type_file = $_FILES['picture']['type']; // check the extension
		    if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') )
		    {
		        notif("Sorry, the file is not an image, please try again.");
		    }
		
		    // copy the file into the directory
		    $name = $name_picture1.'_popup.jpg';
		    $urltp = strtolower($name);
		    $name_file=str_replace(' ','',$urltp); // remove the space from the name
		    if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
		    {
		        notif("Problem to upload the picture, please try again.");
		    }
		
	if($name_p=='') { notif('Sorry, you have to fill the field name, please try again.');}
	    	
	else {
$sql = "INSERT INTO popup(id_popup, name_popup, desc_popup, date_popup, bio_popup, menu_popup, order_popup, id_vendor_p) VALUES ('','$name_p','$desc_p','$date_popup', '$bio','$menu','','')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());		

redirect('/manage-popup.php');
}
}

?>
<?
$template = array(
	'title' => 'Cater2.me | Add PopUp',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Add PopUp '=>'/dashboard/add-popup/'),
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
	
	'grey_bar' => 'Add a PopUp'
	);

require 'header.php';


?>
<div>
<form method="post"  name="f" enctype="multipart/form-data">
		
		<input type="text" name="name" placeholder="name" value="" style="width:20%" /><br><br>
		<input type="text" name="description" placeholder="description" value="" style="width:20%" /><br><br>

		<input type="text" name="date" placeholder="date : AAAA-mm-dd" value="" style="width:20%" /><br><br>
		<fieldset><legend>Bio</legend>
		<textarea name="bio" style="width:100%; height:70px"></textarea></fieldset>
		<fieldset><legend>Menu </legend>
		<textarea name="menu" style="width:100%; height:70px"></textarea></fieldset>
		
		Picture <input type="file" name="picture" placeholder="picture" /> (.jpg) 		
		<p style="margin:30px; text-align:center"><input type="submit" value="Add" /></p>
</form>
	</div>


<?
require 'footer.php';

?>