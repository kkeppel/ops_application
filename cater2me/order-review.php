<?

require 'lib/core.php';

if(!isset($_GET['oid']) || !isset($_GET['hash'])) {
	notif('Link invalid: arguments missing. Please check your link.');
}
if(md5($config['secret'].$_GET['oid']) != $_GET['hash']) {
	notif('Link invalid: hash is incorrect. Please check your link.');
}

$_GET['oid']=(int)$_GET['oid'];


	//get ID of main contact 
	$log = mysql_fetch_row(mysql_query('SELECT id_user FROM order_requests o_r, users u WHERE u.client_id = o_r.client_ID AND id_order = '.$_GET['oid']));
	$user = $log[0];


//check if proposal OK to be picked												select appropriate status(es)
///if(mysql_num_rows(mysql_query('SELECT 1 FROM order_requests WHERE id_order = '.$_GET['oid'].' AND order_status_id <> 6'))) notif('Sorry, you can no longer review this order.');


	//get name vendor/client
	$log = mysql_fetch_row(mysql_query('SELECT v.name, co.name
						FROM vendors v, order_proposals o_p, order_requests o_r, clients cl, companies co
						WHERE vendor_id = id_vendor
						AND order_id = id_order
						AND client_id = id_client
						AND company_id = id_company
						AND id_order = '.$_GET['oid']));
						
	$names=array('vendor'=>$log[0], 'client'=>$log[1]);
	


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(!mysql_num_rows(mysql_query('SELECT 1 FROM order_proposals WHERE order_id = '.$_GET['oid'].' AND id_order_proposal = '.(int)$_POST['prop_selected']))) notif('Sorry, could not verify selected proposal.');
	
	
								// set appropriate status ID (prop selected)
	///mysql_query('UPDATE order_requests SET order_status_id = 7 WHERE id_order = '.$_GET['oid']);
	///mysql_query('UPDATE order_proposals SET selected = 1 WHERE id_order_proposal = '.(int)$_POST['prop_selected']);



// process email notification 

$body='<h3>Companies</h3><br />
Client: '.$name['client'].'<br />
Vendor: '.$name['vendor'].'<br /><br /><br />
Comment: '.stripslashes($_POST['comment'][$_POST['prop_selected']]);


if(!sendMail('etienne@cater2.me', 'Proposal selected - ID: '.$_GET['oid'],$body,true)) notif('We encountered an error sending your mail');

	notif('Thanks, your choice has been saved.');
}





$template = array(
	'title' => 'Cater2.me | Feedback',
	'menu_selected' => 'home',
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
		</script>
		<style>
		.accordion {
		margin:15px 0;
		}
		</style>
	',
	'breadcrumb' => array('Home'=>'/','Dashboard'=>'/dashboard/','Order review (#'.$_GET['oid'].')'=>$_SERVER['REQUEST_URI']),
	
	'grey_bar' => 'Order review',
	);


require 'header.php';

$res = mysql_query('SELECT order_for, employees FROM order_requests WHERE id_order = '.$_GET['oid']);
$order = mysql_fetch_assoc($res);

?>
<h1>Please select a proposal</h1>

<table>
<tr><th>Order Date</th><th><?=date('l M j Y @ g:i A',strtotime($order['order_for']))?></th></tr>
<tr><td>Order ID</td><td><?=$_GET['oid']?></td></tr>
<tr><td>Number of people</td><td><?=$order['employees']?></td></tr>
</table>

<form name="f" method="post">
<input type="hidden" name="prop_selected" value="0">

<div class="accordion" style="width:800px">
<?
$props = mysql_query('SELECT id_order_proposal, public_name FROM order_proposals, vendors WHERE id_vendor = vendor_id AND order_id = '.$_GET['oid']);
while($proposal=mysql_fetch_assoc($props)) {

$total=array('taxed'=>0, 'not-taxed'=>0);

?>

		<h3><a href="#" onclick="document.f.prop_selected.value=<?=$proposal['id_order_proposal']?>"><?=$proposal['public_name']?></a></h3>
		<div>
			
			<table class="tblItems">
			<tr><th><u>Items</u></th><th>Servings</th><th>Description</th><th>Category</th></tr>
			<?
			
			$res = mysql_query('SELECT id_proposal_item, menu_name, quantity, description, unit_price, taxed, label, o_p_i.notes, o_p_i.non_menu_notes
						   FROM order_proposals, order_proposal_items o_p_i, vendor_items, food_categories
						   WHERE id_order_proposal = order_proposal_id
						   AND id_vendor_item = vendor_item_id
						   AND food_category_id = id_food_category
						   
						   AND quantity > 0
						   AND list_order < 18
						   
						   AND id_order_proposal = '.$proposal['id_order_proposal'].' ORDER BY list_order, quantity DESC');
			
			
			while($log = mysql_fetch_assoc($res))
			{
			
			if($log['taxed'])
				$total['taxed']+=$log['unit_price']*$log['quantity'];
			else
				$total['not-taxed']+=$log['unit_price']*$log['quantity'];
			
			?>
			<tr>
			<td>
				<?=$log['menu_name']?><small><br /><?=$log['notes']?></small>
			</td>
			<td>
				<?=$log['quantity']?>
			</td>
			<td>
				<?=$log['description']?>
			</td>
			<td>
				<?=$log['label']?>
			</td>
			</tr>
			<?
			}
			?>
			</table>
			
			<?
			$tax=round($total['taxed']*(1+$config['tax_rate']),2)-$total['taxed'];
			?>
			
			
			
			<div class="container_8">
			
			<div class="grid_4">			
				<table>
				<tr><th> Pre taxed </td><td> $<?=($total['taxed']+$total['not-taxed'])?> </td></tr>
				<tr><th> Tax </td><td> $<?=$tax?> </td></tr>
				<tr><th> Total </td><td> $<?=($total['taxed']+$tax+$total['not-taxed'])?> </td></tr>
				</table>
			</div>
			<div class="grid_4">
				(optional) Comment:
				<textarea name="comment[<?=$proposal['id_order_proposal']?>]" style="height:100%;width:100%"></textarea>
			</div>
			</div>
			<br style="clear:both" />
			
			
			<div style="margin:20px 0;" class="grid-hr"></div>
			
			
            	<input type="submit" value="Select this proposal" />
            	
			
		</div>
<?
}
?>
</div>
</form>
	
            
<?
require 'footer.php';
