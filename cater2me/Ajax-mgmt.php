<?

require 'lib/core.php';
if(getUserGroup($curUser) != 'staff') {
	die(json_encode(array('info'=>'You cannot view this page. Please check that you have a valid staff session.')));
}



switch(true) {

/** start COMPANY MGMT **/

case isset($_GET['autocomplete_company']): //gets company names from real time user input

	$_GET['autocomplete_company']=stripslashes($_GET['autocomplete_company']);
	
	$json_data['query']=$_GET['autocomplete_company'];
	$json_data['suggestions']=array();
	$json_data['data']=array();
	
	$res = mysql_query('SELECT id_company, name FROM companies WHERE name LIKE "'.mysql_real_escape_string($_GET['autocomplete_company']).'%"');
	while($log = mysql_fetch_assoc($res)) {
		$json_data['suggestions'][]=$log['name'];
		$json_data['data'][]=$log['id_company'];
	}
	
	die(json_encode($json_data));

break;
case isset($_GET['company']): //loads company info

	$_GET['company']=(int)$_GET['company'];
	
	$json_data=array();
	
	//basic company info
	$res = mysql_query('SELECT id_company, name, address, cross_streets, city, zip, state, country, website, notes, fee, invoice_first_name, invoice_last_name, invoice_email, default_tip FROM companies WHERE id_company = '.$_GET['company']);
	while($log = mysql_fetch_assoc($res)) {
		
		foreach($log as $column=>$value) {
			$json_data[$column]=$value;
		}
	}
	
	
	// gets users
	$json_data['users']=array();
	
	// (clients first)
	$res = mysql_query('SELECT id_user, username, first_name, last_name, title, email, email2, phone_number, personal_number, extension, fax_number, last_visit, created, notes, nb_visits, deactivated FROM users, clients WHERE id_client = client_id AND company_id = '.$_GET['company']);
	while($log = mysql_fetch_assoc($res)) {
		
		$u=array();
		foreach($log as $column=>$value) {
			$u[$column]=$value;
		}
		$u['account_type']='client';
		
		$json_data['users'][]=$u;
	}
	
	// (employees next)
	$res = mysql_query('SELECT id_user, username, first_name, last_name, title, email, email2, phone_number, personal_number, extension, fax_number, last_visit, created, notes, nb_visits, deactivated FROM users, employees WHERE id_employee = employee_id AND company_id = '.$_GET['company']);
	while($log = mysql_fetch_assoc($res)) {
	
		$u=array();
		foreach($log as $column=>$value) {
			$u[$column]=$value;
		}
		$u['account_type']='employee';
		
		$json_data['users'][]=$u;
	}
	
	
	die(json_encode($json_data));

break;

/** end COMPANY MGMT **/


/** start VENDOR MGMT **/

case isset($_GET['autocomplete_vendor']): //gets vendor names from real time user input

	$_GET['autocomplete_vendor']=stripslashes($_GET['autocomplete_vendor']);
	
	$json_data['query']=$_GET['autocomplete_vendor'];
	$json_data['suggestions']=array();
	$json_data['data']=array();
	
	$res = mysql_query('SELECT id_vendor, name FROM vendors WHERE name LIKE "'.mysql_real_escape_string($_GET['autocomplete_vendor']).'%"');
	while($log = mysql_fetch_assoc($res)) {
		$json_data['suggestions'][]=$log['name'];
		$json_data['data'][]=$log['id_vendor'];
	}
	
	die(json_encode($json_data));

break;
case isset($_GET['vendor']): //loads vendor info

	$_GET['vendor']=(int)$_GET['vendor'];
	
	$json_data=array();
	
	//basic vendor info
	$res = mysql_query('SELECT id_vendor, name, public_name, tagline, website, address, city, zip, state, country, max_order_size, delivery_start, delivery_end, lead_time_needed, delivery_area, delivery_notes, deactivated FROM vendors WHERE id_vendor = '.$_GET['vendor']);
	while($log = mysql_fetch_assoc($res)) {
		
		foreach($log as $column=>$value) {
			$json_data[$column]=$value;
		}
	}
	
	
	
	die(json_encode($json_data));

break;

/** end VENDOR MGMT **/


/** start ORDER MGMT **/

case isset($_GET['order']): //loads order info

	$_GET['order']=(int)$_GET['order'];
	
	$json_data=array();
	
	//basic vendor info
	$res = mysql_query('SELECT id_order, order_payment_status_id, order_status_id, payment_method_id, client_id, meal_type_id, order_created, order_for, employees, max_price, notes, client_profile_id, payout_status_id, tip_status_id, tax_exempt, fc2me_fee, tip, last_updated, last_updates FROM order_requests WHERE id_order = '.$_GET['order']);
	while($log = mysql_fetch_assoc($res)) {
		
		foreach($log as $column=>$value) {
			$json_data[$column]=$value;
		}
	}
	
	
	
	die(json_encode($json_data));

break;

case isset($_GET['proposals_for']): //loads proposals

	$_GET['proposals_for']=(int)$_GET['proposals_for'];
	
	$json_data=array();
	
	
	//proposals
	$props = mysql_query('SELECT id_order_proposal, vendor_id, service_fee, selected, name FROM order_proposals, vendors WHERE vendor_id = id_vendor AND order_id = '.$_GET['proposals_for']);
	while($prop = mysql_fetch_assoc($props)) {
		
		$p=array();
		foreach($prop as $column=>$value) {
			$p[$column]=$value;
		}
		
		
		
		//items in proposal
		$items = mysql_query('  SELECT id_proposal_item, /*name,*/ vendor_item_id, quantity, fprice, ftax, /*description, label,*/ o_p_i.notes, o_p_i.non_menu_notes
						FROM order_proposals, order_proposal_items o_p_i, /*vendor_items,*/ food_categories
						WHERE id_order_proposal = order_proposal_id
						/*AND id_vendor_item = vendor_item_id
						AND food_category_id = id_food_category*/
						
						AND quantity > 0
						AND list_order < 18
						
						AND id_order_proposal = '.$prop['id_order_proposal'].' ORDER BY list_order, quantity DESC') or die(mysql_error());
			
		while($item = mysql_fetch_assoc($items)) {
		
			$i=array();
			foreach($item as $column=>$value) {
				$i[$column]=$value;
			}
			
			$p['items'][]=$i;
		}
		
		
		
		
		//items from vendor (to populate dropdown)
		$items = mysql_query('  SELECT id_vendor_item, name
						FROM vendor_items
						WHERE deactivated < 1
						AND vendor_id = '.$prop['vendor_id'].' ORDER BY name DESC') or die(mysql_error());
			
		while($item = mysql_fetch_assoc($items)) {
		
			$i=array();
			foreach($item as $column=>$value) {
				$i[$column]=$value;
			}
			
			$p['vendor_items'][]=$i;
		}
		
		
		
		
		//serving instructions
		$sis = mysql_query('SELECT serving_instruction_id, label
		FROM serving_instructions, order_proposals_si
		WHERE id_serving_instruction = serving_instruction_id
		AND order_proposal_id = '.$prop['id_order_proposal']);
		
		while($si = mysql_fetch_assoc($sis)) {
		
			$s=array();
			foreach($si as $column=>$value) {
				$s[$column]=$value;
			}
			
			$p['serving_instructions'][]=$s;
		}
		
		
		$json_data[]=$p;
	}
	
	die(json_encode($json_data));
	
	/*

	
{
    "id_proposal":"76",
    "vendor_name":"Fleur de Sel",
    "items":{
        "i3875":{
            "id_item":"210",
            "created":"2011-09-02 19:10:37",
            "notes":"",
            "account_type":"client"
        },
},

	
	*/

break;

case isset($_GET['autocomplete_serving_instruction']):

	$_GET['autocomplete_serving_instruction']=stripslashes($_GET['autocomplete_serving_instruction']);
	
	$json_data['query']=$_GET['autocomplete_serving_instruction'];
	$json_data['suggestions']=array();
	$json_data['data']=array();
	
	$res = mysql_query('SELECT id_serving_instruction, label FROM serving_instructions WHERE label LIKE "'.mysql_real_escape_string($_GET['autocomplete_serving_instruction']).'%"');
	while($log = mysql_fetch_assoc($res)) {
		$json_data['suggestions'][]=$log['label'];
		$json_data['data'][]=$log['id_serving_instruction'];
	}
	
	die(json_encode($json_data));

break;

/** end ORDER MGMT **/

}
?>
