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
	{$i=0;
		$tabCheckbox = $_POST['checkbox'];
 		$tabCheckbox2 = $_POST['checkbox2'];
 		
 		mysql_query('TRUNCATE calendar_version;');	
		foreach ($tabCheckbox as $checkbox) 
		{
			$idComp = addslashes($checkbox);

			$sql = "INSERT INTO calendar_version(id_company_v, version, print) VALUES ('$idComp','1','0')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());
		
		}
		if (isset($_POST['checkbox2'])) {
		foreach ($tabCheckbox2 as $checkbox2) 
		{
		$idComp2 = addslashes($checkbox2);
		$sql = "Update  calendar_version set print='1' where id_company_v ='$idComp2'";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());
			}	
		}
	}
	else {mysql_query('TRUNCATE calendar_version;');}

}
?>
<?
$template = array(
	'title' => 'Cater2.me | Manage Calendar Version',
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
	
	'grey_bar' => 'Manage Calendar Version'
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
<input type='button'   value='Pick all companies for version' onclick='toutcocher();'>
<input type='button'   value='Unpick all companies for version' onclick='toutdecocher();'>

<br><br>
<table width="60%" id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th width="30%">Company name</th> 
    <th width="10%">Company ID</th> 
	<th width="10%">Calendar Version</th> 
	<th width="10%">Print</th> 
</tr> 
</thead> 
<tbody> 
<?
$res = mysql_query('SELECT id_company, name FROM companies ORDER BY 2');
while($log = mysql_fetch_assoc($res))
{
$idtmp = $log['id_company'];
$res2 = mysql_query("SELECT id_company_v, version FROM calendar_version  where id_company_v= '$idtmp' and version=1 ");
$arrayid = mysql_fetch_assoc($res2);
$id = $arrayid['id_company_v'];
$res22 = mysql_query("SELECT id_company_v FROM calendar_version  where id_company_v= '$idtmp' and print=1 ");
$arrayid2 = mysql_fetch_assoc($res22);
$id2 = $arrayid2['id_company_v'];
?>
<tr> 
 <td><?=$log['name']?></td>
  <td><?=$log['id_company']?></td>
<td> <input type="checkbox" name="checkbox[]" value= <?php echo $log['id_company'];?><?php if ($log['id_company']==$id){echo ' checked="checked"';} ?></td>

<td> <input type="checkbox" name="checkbox2[]" value= <?php echo $log['id_company'];?><?php if ($log['id_company']==$id2){echo ' checked="checked"';} ?></td>
    </tr> 
<? } ?>
</tbody> 
</table> 
<input type="submit" value="Update" />

</form>


<?
require 'footer.php';

?>