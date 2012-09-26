<?
require 'lib/core.php';
$id_user= $curUser['vendor_id'];
//echo $name_user;
if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');

if($_SERVER['REQUEST_METHOD']=='POST')
{
	$text_event=$_POST['text_e'];
	$date=date("Y-m-d");
	$id_v=$id_user;
	
$sql = "INSERT INTO events(id_event, text_e, datecreation_e,id_vendor_e) VALUES ('','$text_event','$date','$id_v')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());
redirect('/dashboard/');
}

?>
<?
$template = array(
	'title' => 'Cater2.me | Add Events Page',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Add Vendor Page '=>'/dashboard/add-event/'),
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
	
	'grey_bar' => 'Add Event Page'
	);

require 'header.php';
?>
<script language="javascript" type="text/javascript" src="/template/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
        theme : "simple",
        mode : "textareas"
});
</script>



	<div>
<form method="post"  name="f" enctype="multipart/form-data">
		

		<fieldset><legend>Description</legend>
		<textarea name="text_e" style="width:100%; height:70px"></textarea></fieldset>
		
		<p style="margin:30px; text-align:center"><input type="submit" value="Add" /></p>
</form>
	</div>




<?
require 'footer.php';

?>