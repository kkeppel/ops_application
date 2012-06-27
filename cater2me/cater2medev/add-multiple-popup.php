<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');

if($_SERVER['REQUEST_METHOD']=='POST')
{
	foreach($_POST['form'] as $id=>$fields) {
		
		$bio = mysql_real_escape_string(stripslashes($fields['bio']));
		$id = mysql_real_escape_string(stripslashes($fields['id'])); 
		$name = mysql_real_escape_string(stripslashes($fields['name']));
		
 		if(strlen($bio) > 0) {
			$sql = "INSERT INTO popup(id_popup, name_popup, date_popup, bio_popup, menu_popup, order_popup, id_vendor_p) VALUES ('','$name','', '$bio','','0','$id')";
	mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());			
		}
		else {			
		}
			
			}
	redirect('/manage-popup.php');
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
	
	'grey_bar' => 'Add multiple PopUp'
	);

require 'header.php';


?>

<div>
<form method="post"  name="f" enctype="multipart/form-data">

<table id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th width="20%">Vendor name</th>  
    <th width="65%">Biography</th> 

</tr> 
</thead> 
<tbody> 
<?
$res = mysql_query('SELECT name,id_vendor FROM vendors WHERE id_vendor NOT 
IN (
SELECT id_vendor_p
FROM popup
) order by name asc	');
$i = 0;
while($popup = mysql_fetch_assoc($res))
{

?>
<tr> 
 <td id="vnd_name<?=$popup['id_vendor']?>"><?=$popup['name']?></td>
 <td id="vnd_bio>"><textarea name="form[<?=$popup['id_vendor']?>][bio]" style="width:90%; height:70px"></textarea>
 </td>
<input type="hidden" name="form[<?=$popup['id_vendor']?>][id]" value="<?=$popup['id_vendor']?>" />
<input type="hidden" name="form[<?=$popup['id_vendor']?>][name]" value="<?=$popup['name']?>" />
</tr> 

<? } ?>
</tbody> 
</table> 


<div class="grid_7" id="contact-page">
<p style="margin:30px; text-align:center"><input type="submit" value="Add" /></p>
</form> </div>
</div>
<?
require 'footer.php';

?>