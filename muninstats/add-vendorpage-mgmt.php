<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');

if($_SERVER['REQUEST_METHOD']=='POST')
{
	$name_v=$_POST['name'];
	$desc_v=$_POST['desc'];
	$twit_v=$_POST['twit'];
	$fb_v=$_POST['fb'];
	$color_v=$_POST['color'];
	$pos_v=$_POST['position'];
	$url=$_POST['name'];
	$urltp = strtolower($url);
	$url_v=str_replace(' ','',$urltp); //remove the space
	
	$content_dir = 'vendor_page/upload/'; // directory to keep picture
			$tmp_file = $_FILES['pic']['tmp_name'];
		    if( !is_uploaded_file($tmp_file) ) //check the file exists
		    {
		        exit("The file does not exist");
		    }
			
			$type_file = $_FILES['pic']['type']; // check the extension
		    if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') )
		    {
		        exit("The file is not an image");
		    }
		
		    // copy the file into the directory
		    $name = $name_v.'_pic.jpg';
		    $urltp = strtolower($name);
		    $name_file=str_replace(' ','',$urltp); // remove the space from the name
		    if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
		    {
		        exit("Problem to upload the picture");
		    }
		    
		    	$tmp_file2 = $_FILES['logo']['tmp_name'];
			    if( !is_uploaded_file($tmp_file2) ) //check the file exists
			    {
			        exit("The file does not exist");
			    }
				
				$type_file2 = $_FILES['logo']['type']; // check the extension
			    if( !strstr($type_file2, 'jpg') && !strstr($type_file2, 'jpeg') && !strstr($type_file2, 'bmp') && !strstr($type_file2, 'gif') )
			    {
			        exit("The file is not an image");
			    }
			
			    // copy the file into the directory
			    $name2 = $name_v.'_logo.jpg';
			    $urltp = strtolower($name2);
			    $name_file2=str_replace(' ','',$urltp); // remove the space from the name
			    if( !move_uploaded_file($tmp_file2, $content_dir . $name_file2) )
			    {
			        exit("Problem to upload the picture");
			    }

$sql = "INSERT INTO Vendor(id_v, name_v, desc_v, twitter_v, facebook_v, color_v, position_v, url_v) VALUES ('','$name_v','$desc_v','$twit_v','$fb_v','$color_v','$pos_v','$url_v')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());

}

?>
<?
$template = array(
	'title' => 'Cater2.me | Add Vendor Page',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Add Vendor Page '=>'/dashboard/add-vendorpage-mgmt/'),
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
	
	'grey_bar' => 'Add Vendor Page'
	);

require 'header.php';
?>

<div class="accordion">

<h3><a href="#"><b>Basic Info</b></a></h3>
	<div>
<form method="post">
		
		<input type="text" name="name" placeholder="name" value="" style="width:100%" />
		<fieldset><legend>Description</legend>
		<textarea name="desc" style="width:100%; height:70px"></textarea></fieldset>
		
		<input type="text" name="twit" placeholder="twitter username"  style="width:100%" />
		<input type="text" name="fb" placeholder="facebook url" style="width:100%" />

	<table>
	<tr><td>Title Color</td><td><select name="color">
  <option value="black">black</option>
  <option value="white">white</option>
  <option value="blue">blue</option>
  <option value="red">red</option>
</select></td></tr>
<tr><td>Position of the content</td><td><select name="position">
  <option value="right">right</option>
  <option value="left">left</option>
</select></td></tr>
 </table>

		<fieldset><legend>Images</legend>
		<table><tr><td>Background Image</td><td><input type="file"  placeholder="background image"/> (.jpg) <!-- make HTML 5 filter only jpg here --></td></tr>		<br>
		<tr><td>Logo</td><td><input type="logo" placeholder="logo" /> (.jpg)</td> <!-- make HTML 5 filter only jpg here -->
</table>
		</fieldset>

		<p style="margin:30px; text-align:center"><input type="submit" value="Add" /></p>
</form>
	</div>





</div>

<?
require 'footer.php';

?>