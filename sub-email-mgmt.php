<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');
$message ='';

if($_SERVER['REQUEST_METHOD']=='POST')
{
	$email = mysql_real_escape_string($_POST['email']);
	$company = ($_POST['company']);		    
		    
//echo $email.' --- '.$company;					    
$sql = "INSERT INTO subdomain(domain, id_company_sub) VALUES ('$email','$company')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());		

redirect('/sub-email-mgmt.php');

}

?>
<?
$template = array(
	'title' => 'Cater2.me | Manage subEmail',
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
	
	'grey_bar' => 'Manage Address delegation'
	);

require 'header.php';


?>
<div>
<form method="post"  name="f">
		<table>
<tr><td>
	Email domain to allow	</td><td><input type="text" name="email" placeholder="sub domain address" value="" style="width:80%" /></td></tr>		
<tr><td>Delegate this email to this company:</td>
<td><? $select_companies = '<select name = "company"><option value="">-- company --</option>';
$res = mysql_query('SELECT id_company, name FROM companies order by name');
while($log = mysql_fetch_assoc($res)) {
	$select_companies.='<option value="'.$log['id_company'].'">'.$log['id_company'].' - '.$log['name'].'</option>';
}
$select_companies.= '<select>'
		?>
		<?= $select_companies ?></td></tr>		
</table>
		<p style="margin:30px; text-align:center"><input type="submit" value="Add" /></p>
</form>

<table id="tblUsers"> 
<thead> 
<tr> 
    <th>domain Name</th> 
    <th>Company Id</th> 
    <th>Company Name</th> 
</tr> 
<? $res3 = mysql_query("SELECT * FROM subdomain, companies
WHERE id_company_sub = id_company");
while($domain = mysql_fetch_assoc($res3))
{
?>
<tr> 
    <td ><?=$domain['domain']?></td>
    <td><?=$domain['id_company']?></td>
    <td><?=$domain['name']?></td>

</tr>
<? } ?>
</table>

	</div>
<?
require 'footer.php';

?>