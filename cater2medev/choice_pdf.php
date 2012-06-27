<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');
	
	if($_SERVER['REQUEST_METHOD']=='POST')
{
if (isset($_POST['checkbox']))
	{
		$tabCheckbox = $_POST['checkbox'];
 
		mysql_query('TRUNCATE show_pdf;');	
		
		foreach ($tabCheckbox as $checkbox) 
		{
			$idVnd = addslashes($checkbox);
		
$sql = "INSERT INTO show_pdf(id_vendor_pdf, showp) VALUES ('$idVnd','1')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());		
		}
	}
	else {mysql_query('TRUNCATE show_pdf;');}
}
?>
<?
$template = array(
	'title' => 'Cater2.me | Manage Pdf Client',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/'),
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
	
	'grey_bar' => 'Manage PDF Menu Access'
	);

require 'header.php';


?>
<script language="javascript">
function toutcocher()
{
	for(i=0;i<document.F1.length;i++)
	{
	if(document.F1.elements[i].type=="checkbox")
	document.F1.elements[i].checked=true;
	}	
}
function toutdecocher()
{
	for(i=0;i<document.F1.length;i++)
	{
	if(document.F1.elements[i].type=="checkbox")
	document.F1.elements[i].checked=false;
	}	
}
</script>
<form name="F1" method="post">
<input type='button'   value='Pick all vendors' onclick='toutcocher();'>
<input type='button'   value='Unpick all vendors' onclick='toutdecocher();'>
<br><br>

<table width="60%" id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th width="30%">Vendor name</th> 
    <th width="10%">Vendor ID</th> 
	<th width="10%">PDF</th> 

</tr> 
</thead> 
<tbody> 
<?
$res = mysql_query('SELECT id_vendor, public_name FROM vendors  ORDER BY 2');
while($log = mysql_fetch_assoc($res))
{
$idtmp = $log['id_vendor'];
$res2 = mysql_query("SELECT id_vendor_pdf FROM show_pdf  where id_vendor_pdf= '$idtmp' and showp=1 ");
$arrayid = mysql_fetch_assoc($res2);
$id = $arrayid['id_vendor_pdf'];
?>
<tr> 
 <td><?=$log['public_name']?></td>
  <td><?=$log['id_vendor']?></td>
<td> <input type="checkbox" name="checkbox[]" value= <?php echo $log['id_vendor'];?><?php if ($log['id_vendor']==$id){echo ' checked="checked"';} ?></td>
    </tr> 
<? } ?>
</tbody> 
</table> 
<input type="submit" value="Update" />

</form>


<?
require 'footer.php';

?>