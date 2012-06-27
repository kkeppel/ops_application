<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');

if($_SERVER['REQUEST_METHOD']=='POST')
{
			
	$id='1';	
	$name_v=$_POST['name_v'];
	$desc_v=$_POST['desc_v'];
	$twit_v=$_POST['twit'];
	$fb_v=$_POST['fb'];
	$color_v=$_POST['color'];
	$pos_v=$_POST['position'];
	$url=$_POST['name_v'];
	$urltp = strtolower($url);
	$url_v=str_replace(' ','',$urltp); //remove the space
					    

		$sql = "Update Vendor set name_v='".$name_v."',desc_v='".$desc_v."',twitter_v='".twit_v."', facebook_v='".$fb_v."', color_v='".$color_v."', position_v='".$pos_v."', url_v='".$url_v."'  WHERE id_v=$id";
	    mysql_query($sql);


}

?>
<?
$template = array(
	'title' => 'Cater2.me | Manage Vendor Page',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Add Vendor Page '=>'/dashboard/manage-vendor/'),
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
	
	'grey_bar' => 'Manage Vendor Page'
	);

require 'header.php';
$vendor=array();
$res = mysql_query('SELECT * FROM Vendor where id_v=1');
while($log = mysql_fetch_assoc($res)) {
$vendor[$log['label']]=$log['value'];
$name_v=$log['name_v'];
$desc_v=$log['desc_v'];
$twit=$log['twitter_v'];
$fb=$log['facebook_v'];
$color_vendor=$log['color_v'];
$position_vendor=$log['position_v'];
}

?>

<div class="accordion">
<h3><a href="#"><b>Basic Info</b></a></h3>
	<div>
<form method="post"  name="f" enctype="multipart/form-data">
		<input type="text" name="name_v"  value="<?=$name_v?>" style="width:100%" />
 </td>
		<fieldset><legend>Description</legend>
		<textarea name="desc_v" style="width:100%; height:70px"><?=$desc_v?></textarea>
</fieldset>
		
		<input type="text" name="twit" placeholder="twitter username" value="<?=$twit?>"  style="width:100%" />
		<input type="text" name="fb" placeholder="facebook url" value="<?=$fb?>" style="width:100%" />

	<table>
	<tr><td>Title Color</td><td><select name="color"><option selected><?=$color_vendor?></option>
  <option value="black">black</option>
  <option value="white">white</option>
  <option value="blue">blue</option>
  <option value="red">red</option>
</select></td></tr>
<tr><td>Position of the content</td><td><select name="position"><option selected><?=$position_vendor?></option>
  <option value="right">right</option>
  <option value="left">left</option>
</select></td></tr>
 </table>

		<fieldset><legend>Images</legend>
		<table><tr><td>Background Image</td><td><input type="file" name="picture" placeholder="background image"/> (.jpg) <!-- make HTML 5 filter only jpg here --></td></tr>		<br>
		<tr><td>Logo</td><td><input type="file" name="logo" placeholder="logo" /> (.jpg)</td> <!-- make HTML 5 filter only jpg here -->
</table>
		</fieldset>

		<p style="margin:30px; text-align:center"><input type="submit" value="Update" /></p>
</form>
	</div>





</div>

<? 
require 'footer.php';

?>