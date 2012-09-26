<?
if(!isset($_GET['debut'])) $_GET['debut']=date('Y-m-d');
if(!isset($_GET['fin'])) $_GET['fin']=date('Y-m-d', time()+60*60*24*14);
if(isset($_GET['restaurateur'])) 
{
	$restaurateur=' AND name LIKE "'.$_GET['restaurateur'].'%" ';
}
else
{
	$restaurateur='';
}


	$res = mysql_query('SELECT id_order, id_order_proposal, order_for, o_r.notes, last_updated, last_updates, name, label label_status
				  FROM order_requests o_r, order_proposals, vendors, order_status
				  WHERE id_order = order_id
				  AND id_vendor = vendor_id
				  AND id_order_status = order_status_id
				  AND selected
				  '.$restaurateur.'
				  /*AND order_status_id = 4 */ /*confirmed*/
				  AND order_for BETWEEN "'.$_GET['debut'].'" AND "'.$_GET['fin'].'" ORDER BY order_for'); //next 14 days
		

/**** to fix */
$ordersConfirmed=array();
$res2 = mysql_query('SELECT order_id FROM tmp_vendor_confirmations ORDER BY order_id');
while($log = mysql_fetch_assoc($res2)) {
	$ordersConfirmed[]=$log['order_id'];
}
/**** to fix */



	if(!mysql_num_rows($res)) notif('No orders planned for the next few days.');
	
	
	
$template = array(
	'title' => 'Cater2.me | Calendar',
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
		
			for(day in daysToHide)
			{
				document.getElementById("t"+daysToHide[day]).style.display="none";
			}
		
		});
		daysToHide=Array();
		</script>
		
		<style type="text/css">
			.confirmed {
				color:green;
			}
			.notConfirmed {
				color:tomato;
			}
			.other {
				color:blue;
			}
			.labelday > div {
			margin:14px 20px;
			}
			.nothingToday {
			padding-left:30px;
			}
			hr {
			color:white;
			width:500px;
			margin:20px 80px;
			}
		</style>
	',
	'breadcrumb' => array('Home'=>'/','Dashboard'=>'/dashboard/','Calendar'=>'/home/dashboard/calendar/'),
	
	'grey_bar' => 'Your Vendor Calendar',
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
</form>

<?
	
	
		$orders=array();
		while($log = mysql_fetch_assoc($res))
		{
			$orders[] = $log;
		}
		
		
		$now=strtotime($_GET['debut']);
		
		$nbrOfDays=ceil((strtotime($_GET['fin'])-strtotime($_GET['debut']))/60/60/24);
		
		for($days=0;$days<$nbrOfDays;$days++)
		{
			$curDay=$now+$days*86400;
			
			if(date('l', $curDay) == 'Monday') echo '<hr />';
			echo '<div class="labelday" id="t'. $curDay.'"><div>'.date('l M j Y', $curDay).'</div>';
			
			//if(isset($orders[0]))
			//{
			
			echo '<div class="accordion" style="width:700px">';
			
			$nothing=true;
			while(isset($orders[0]) && substr($orders[0]['order_for'],0,10) == date('Y-m-d',$curDay))
			{
			$nothing=false;
			$order = array_shift($orders);
			
			
			// ADDRESS
			
			$res2 = mysql_query('SELECT address, city, state, zip, delivery_address
						 FROM companies, clients, order_requests, client_profiles p
						 WHERE id_company = company_id
						 AND id_client = p.client_id
						 AND client_profile_id = id_profile
					  	 AND id_order = '.$order['id_order']);
					  	 
			$address = mysql_fetch_assoc($res2);
	
			if($address['delivery_address']) $address['address']=$address['delivery_address'];
			
			
			
			
			
			// DELIVERY INSTRUCTIONS	
				
			$res2 = mysql_query('SELECT c.delivery_instructions di, c_p.delivery_instructions p_di, c.delivery_area da, c_p.delivery_area p_da
						 FROM clients c, order_requests o_r, client_profiles c_p
						 WHERE id_client = c_p.client_id
						 AND id_profile = client_profile_id
					  	 AND id_order = '.$order['id_order']);
					  	 
			$instructions = mysql_fetch_assoc($res2);
	
			if($instructions['p_di']) $instructions['di']=$instructions['p_di'];
			if($instructions['p_da']) $instructions['da']=$instructions['p_da'];
			
			if($instructions['di'] || $instructions['da'])
			{
				$deliveryInfo='<div class="accordion" style="width:650px"><h3><a>-- Delivery instructions --</a></h3><ul>';
				$deliveryInfo.='<li>'.$address['address'].'<br>'.$address['city'].', '.$address['state'].' '.$address['zip'].' </li>';
				if($instructions['di']) $deliveryInfo.='<li>'.$instructions['di'].'</li>';
				if($instructions['da']) $deliveryInfo.='<li>'.$instructions['da'].'</li>';
				$deliveryInfo.='</ul></div><br />';
			}
			else
				$deliveryInfo='';
			
			
			
/**** to fix */

if($order['label_status'] == 'Confirmed')
	$status=((array_search($order['id_order'],$ordersConfirmed)===false)?' <span class="notConfirmed">[not confirmed]</span>':' <span class="confirmed">[confirmed]</span>');
else
	$status=' <span class="other">['.$order['label_status'].']</span>';

/**** to fix */
			
		
			echo '
			<h3><a href="#order'.$order['id_order'].'">['.$order['name'].'] '.date('g:i A', strtotime($order['order_for'])).' - '.$address['address'].' [Order #'.$order['id_order_proposal'].']'.$status.'</a></h3>
			<div>';
		
			if($order['notes'])
				echo '<p><b>Notes:</b> '.$order['notes'].'</p>';
			
			if($order['last_updated'] != '0000-00-00 00:00:00')
			{
				echo '<p><b><u>Updated</u>:</b> '.date('l M j Y @ g:i A', strtotime($order['last_updated'])).'</p>
					  <p><b><u>Updates</u>:</b> '.$order['last_updates'].'</p><br />';
			}
			
			echo $deliveryInfo;
		
		
		
		
			$res2 = mysql_query('SELECT label
			FROM serving_instructions, order_proposals_si
			WHERE id_serving_instruction = serving_instruction_id
			AND order_proposal_id = '.$order['id_order_proposal']);
		
			if(mysql_num_rows($res2))
			{
				echo '<b>Serving instructions:</b><ul class="si">';

				if($si = mysql_fetch_assoc($res2))
				{
					echo '<li>'.$si['label'].'</li>';
				}
				
				echo '</ul><hr />';
			}
			
		
			$res2 = mysql_query('SELECT name, quantity, description, label food_category, o_p_i.notes, o_p_i.non_menu_notes
						   FROM order_proposal_items o_p_i, vendor_items, food_categories f_c
						   WHERE id_food_category = food_category_id
						   AND id_vendor_item = vendor_item_id
						   AND order_proposal_id = '.$order['id_order_proposal'].' ORDER BY f_c.list_order, quantity DESC') or die(mysql_error());
		
			echo '<ul>';
			while($items = mysql_fetch_assoc($res2))
			{
				$notes = '';
				if($items['notes']!='') $notes.=$items['notes'].'<br />';
				if($items['non_menu_notes']!='') $notes.=$items['non_menu_notes'].'<br />';
				echo '<li>('.$items['quantity'].') '.$items['name'].'<br /><small><b>'.$notes.'</b><i>'.$items['description'].' ('.$items['food_category'].')</i></small></li>';
			}
			echo '</ul>
			</div>';
			}
			
			echo '</div>';
			
			
			if($nothing)
			{
				switch(date('l',$curDay))
				{
				case 'Saturday':
				case 'Sunday':
					echo '<script> daysToHide.push('.$curDay.'); </script>';
				break;
				default:
					echo '<div class="nothingToday">-</div>';
				break;
				}
			}
			
			//}
			
			echo '</div>';
		}


