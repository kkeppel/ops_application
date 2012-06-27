<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');

if($_SERVER['REQUEST_METHOD']=='POST')
{

	$orderid = ($_POST['order-id']);
	$date1 = $_POST['date'];
	$date2 = $_POST['time'];				    				    
	$date = $date1.' '.$date2;
    $vendorid = ($_POST['vendor']);
    $companyid = ($_POST['company']);
        
		   
$sql = "INSERT INTO tmp_order(id_tmp_order, order_id_tmp, date_order, vendor_id, company_id) VALUES ('','$orderid', '$date','$vendorid','$companyid')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());		

//redirect('/manage-popup.php');
}


?>
<?
$template = array(
	'title' => 'Cater2.me | Add PopUp',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Add Tmp order '=>'/dashboard/add-order-tmp/'),
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
	
	'grey_bar' => 'Add a temporary order'
	);

require 'header.php';


?>


<div>
<form method="post">
		
		<input type="text" name="order-id" placeholder="Order  ID" value="" style="width:20%" /><br><br>
		<input type="text" name="date" placeholder="Date" value="" style="width:20%" /><br><br>
		<input type="text" name="time" placeholder="Time" value="" style="width:20%" /><br><br>
		<? $select_companies = '<select name = "company"><option value="">-- company --</option>';
$res = mysql_query('SELECT id_company, name FROM companies');
while($log = mysql_fetch_assoc($res)) {
	$select_companies.='<option value="'.$log['id_company'].'">'.$log['id_company'].' - '.$log['name'].'</option>';
}
$select_companies.= '<select>'
		?>
		<?= $select_companies ?><br><br>
		<? $select_vendors = '<select name="vendor"><option value="">-- vendor --</option>';
$res = mysql_query('SELECT id_vendor, name FROM vendors');
while($log = mysql_fetch_assoc($res)) {
	$select_vendors.='<option value="'.$log['id_vendor'].'">'.$log['id_vendor'].' - '.$log['name'].'</option>';
}
$select_vendors.= '<select>'
		?>
		<?= $select_vendors ?>
		
			
		<p style="margin:30px; text-align:center"><input type="submit" value="Add" /></p>
</form>
	</div>


<?
require 'footer.php';

?>