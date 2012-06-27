<?


	$res = mysql_query('SELECT id_order, id_order_proposal, order_for, notes, last_updated, last_updates
				  FROM order_requests, order_proposals
				  WHERE vendor_id = '.$curUser['vendor_id'].'
				  AND id_order = order_id
				  AND selected
				  AND order_status_id = 4
				  AND order_for BETWEEN "'.date('Y-m-d').'" AND "'.date('Y-m-d', time()+60*60*24*14).'" ORDER BY order_for'); //next 14 days
		

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
			form{
			display: inline;
			}
		</style>
	',
	'breadcrumb' => array('Home'=>'/','Dashboard'=>'/dashboard/','Calendar'=>'/home/dashboard/calendar/'),
	
	'grey_bar' => 'Your Vendor Calendar',
	);


require 'header.php';


$areas=array();
$tmp = mysql_query('SELECT label, value FROM website_editable_areas WHERE label LIKE "calendar_vendor_%"');
while($log = mysql_fetch_assoc($tmp)) {
	$areas[$log['label']]=$log['value'];
}

	
?>

<h2>Below you'll find your schedule for the NEXT 14 DAYS.</h2>
<br />
<p><?=plain2Html($areas['calendar_vendor_top'])?></p>
<?
	
		$orders=array();
		while($log = mysql_fetch_assoc($res))
		{
			$orders[] = $log;
		}
		
		
		$now=time();
		for($days=0;$days<15;$days++)
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
$isConfirmed=(array_search($order['id_order'],$ordersConfirmed)!==false);
/**** to fix */

if($isConfirmed)
	$confirmed=' <span class="confirmed">[confirmed]</span>';
else
	$confirmed=' <span class="notConfirmed">[not confirmed]</span>';
			
		
			echo '
			<h3><a href="#order'.$order['id_order'].'">'.date('g:i A', strtotime($order['order_for'])).' - '.$address['address'].' [Order #'.$order['id_order_proposal'].']'.$confirmed.'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<form target="_blank"><input type="button" value="Print Order" OnClick="window.open(\'/order-pdf.php?a='.$order['id_order'].'\')"></form>
			<form target="_blank"><input type="button" value="Print Labels" OnClick="window.open(\'/label-pdf.php?a='.$order['id_order'].'\')"></form>
			<form target="_blank"><input type="button" value="Print Menu Day" OnClick="window.open(\'/menu-pdf.php?a='.$order['id_order'].'\')"></form>
			</h3>
			<div>';
			
			if(!$isConfirmed)  //  md5($config['secret'].$order['id_order'])
				echo '<div class="divLnkConfirm" id="divLnkConfirm'.$order['id_order'].'"><a href="javascript:void(0)" onclick="vendorConfirmEvent('.$order['id_order'].',\''.round(((($order['id_order'] + 5)*152) -2)/2).'\')">Click here to confirm this event now</a></div>';
			
			if($order['notes'])
				echo '<p><b>Notes:</b> '.$order['notes'].'</p>';
			
			if($order['last_updated'] != '0000-00-00 00:00:00')
			{
				echo '<p><b><u>Updated</u>:</b> '.date('l M j Y @ g:i A', strtotime($order['last_updated'])).'</p>
					  <p><b><u>Updates</u>:</b> '.$order['last_updates'].'</p><br />';
			}
			
			echo $deliveryInfo;

$neworder = $order['id_order'];			
$neworder = ((($neworder * 45)+165)/2) ;
$textCode = floor( $neworder);
if(strlen($textCode)>4)
{ 
$textCode = substr($textCode, -4);   }
else  {
	if(strlen($textCode)==3)
	{ 
	$textCode = '1'.$textCode;}  
	}


			echo 'Text <b><span style="font-size:15px" >'.$textCode.'</span></b> to (415)-944-4121 upon arrival<br><br>';
		
			$res3 = mysql_query('SELECT label
			FROM catering_extra, catering_extra_labels
			WHERE catering_extra.extra_label_id = catering_extra_labels.id_extra
			AND order_request_id = '.$order['id_order']);
		
		
			echo '<b>Bring the following:</b><ul class="si">';	
			echo '<li>Cater2.me Labels</li>';
			echo '<li>Serving Utensils</li>';
			if(mysql_num_rows($res3))
			{
			while($sj = mysql_fetch_assoc($res3))
				{
					if ($sj['label'] == 'Utensils' or $sj['label'] == 'Paper Ware' or $sj['label'] == 'Table Clothes' or $sj['label'] == 'Chafing Dishes'){
					echo '<li>'.$sj['label'].'</li>';}
				}
			}

			$res2 = mysql_query('SELECT label
			FROM serving_instructions, order_proposals_si
			WHERE id_serving_instruction = serving_instruction_id
			AND order_proposal_id = '.$order['id_order_proposal']);
		
			if(mysql_num_rows($res2))
			{
				echo '<b>Order instructions:</b><ul class="si">';

				while($si = mysql_fetch_assoc($res2))
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
			</div>		&nbsp;&nbsp;&nbsp;';
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


