<?

require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser) != 'staff') notif('Denied');





if(!isset($_GET['debut'])) $_GET['debut']=date('Y-m-d');
if(!isset($_GET['fin'])) $_GET['fin']=date('Y-m-d', time()+60*60*24*14);
if(isset($_GET['restaurateur'])) 
	$restaurateur=' AND name LIKE "'.$_GET['restaurateur'].'%" ';
else
	$restaurateur='';

$orders=array();
$res = mysql_query('SELECT order_id FROM tmp_sms_confirmations ORDER BY order_id');
while($log = mysql_fetch_assoc($res)) {
	$orders[]=$log['order_id'];
}

$res = mysql_query('SELECT id_order, id_order_proposal, order_for, name
			  FROM order_requests o_r, order_proposals, vendors
			  WHERE id_order = order_id
			  AND id_vendor = vendor_id
			  AND selected
			  '.$restaurateur.'
			  /*AND order_status_id = 4 */ /*confirmed*/
			  AND order_for BETWEEN "'.$_GET['debut'].'" AND "'.$_GET['fin'].'" ORDER BY order_for'); //next 14 days


if(isset($_GET['csv'])) {
header('Content-Type: application/force-download');
echo '"id_order","order_for","confirmed","name"'."\n";
	while($log = mysql_fetch_assoc($res)) {
		echo '"'.$log['id_order'].' ","'.$log['order_for'].'","'.((array_search($log['id_order'],$orders)===false)?'0':'1').'","'.utf8_decode($log['name']).'"'."\n";
	}
	die;
}





$template = array(
	'menu_selected' => 'home',
	'grey_bar' => 'List of SMS confirmations',
	'header_resources' => '
		<link rel="stylesheet" href="/template/css/custom/tablesorter/style.css" />
		<script type="text/javascript" src="/template/js/custom/jquery.tablesorter.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			  $("#tblOrders").tablesorter();
		    }
		);
		</script>
	',
	);


require 'header.php';


?>
<form>
<h2>Filters</h2>
<div style="border:1px black dotted; width:550px; margin:0 auto; text-align:center;padding:10px">
<b>By date</b><br /><br />
	From: <input type="text" name="debut" value="<?=$_GET['debut']?>" placeholder="YYYY-MM-DD" />
	To: <input type="text" name="fin" value="<?=$_GET['fin']?>" placeholder="YYYY-MM-DD" /> (add +1)


<br /><br /><b>By vendor</b><br /><br />
	<input type="text" name="restaurateur" value="<?=$_GET['restaurateur']?>" placeholder="first chars" />
</fieldset>

<input type="submit" value="Apply" />
</div>
</form><br /><br /><br />

<?
if(strpos($_SERVER['REQUEST_URI'],'?') === false)
	echo '<a href="'.$_SERVER['REQUEST_URI'].'?csv=1">Right click to save CSV version</a>';
else
	echo '<a href="'.$_SERVER['REQUEST_URI'].'&csv=1">Right click to save CSV version</a>';
?>

<br /><br />

<?

echo '
<table id="tblOrders" class="tablesorter"> 
<thead> 
<tr> 
    <th>Order ID</th> 
    <th>Order for</th> 
    <th>Confirmed?</th> 
    <th>Vendor</th> 
</tr> 
</thead> 
<tbody> ';



while($log = mysql_fetch_assoc($res)) {
	echo '<tr><td> '.$log['id_order'].' </td><td> '.date('l M j Y @ g:i A',strtotime($log['order_for'])).' </td><td> '.((array_search($log['id_order'],$orders)===false)?'No':'Yes').' </td><td>'.$log['name'].'</td></tr>';
}

echo '</tbody>
</table>
<br /><br /><br /><br /><br /><br /><br />';


require 'footer.php';
