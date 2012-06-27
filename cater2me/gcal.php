<?


require 'lib/core.php';
require 'lib/gcalendar.php';

//ngmoco:79 => tepjt5u18k7qbs5g9tjt60l4jg

//$companies=array(12,16,24,25,28,75,78,79,91,94,100,130,131,133,134,135,138,140);
//$companies=array(74,116,126);
//$companies=array(6, 107, 76, 77); //73
$companies=array(76); //73
/* 74,116,126: vendor_name (employee_count people) */

$gcal = new gCal();

foreach($companies as $company) {

		$calendar = $gcal->getCalendarByCompanyId($company);

		$res = mysql_query('SELECT id_order, order_for, public_name, id_order_proposal, employees
					  FROM order_requests, clients, order_proposals, vendors
					  WHERE company_id = '.$company.'
					  AND id_client = client_id
					  AND id_order = order_id
					  AND selected
					  AND vendor_id = id_vendor
					  AND order_status_id = 4
					  AND order_for BETWEEN "2011-09-05" AND "2011-10-07" ORDER BY order_for');


		while($log = mysql_fetch_assoc($res)) {
							   
				$res2 = mysql_query('SELECT menu_name, quantity, description, label food_category, o_p_i.notes, o_p_i.non_menu_notes
							   FROM order_proposal_items o_p_i, vendor_items, food_categories f_c
							   WHERE id_food_category = food_category_id
							   AND id_vendor_item = vendor_item_id
							   	AND list_order < 19
							   AND order_proposal_id = '.$log['id_order_proposal'].' ORDER BY f_c.list_order, quantity DESC') or die(mysql_error());
							   
							   
				$lastCategory='-';
				$description='<a href="http://cater2.me/dashboard/feedback/?oid='.$log['id_order'].'">'.$log['public_name'].' Feedback</a>'."\n";
		
				while($items = mysql_fetch_assoc($res2))
				{
					if($lastCategory!=$items['food_category'])
					{
						$description.="\n<b>".$items['food_category']."</b>\n";
						$lastCategory=$items['food_category'];
					}
				
					$tmp='';
					$tmp.=(($items['description'])? ': '.$items['description']: '');
					$tmp.=(($items['notes'])? ' ('.$items['notes'].')': '');
					$description.= '* '.$items['menu_name'].$tmp."\n";
				}
				
				
			
			foreach($calendar as $cal) //in case company has multiple calendars (rare)
			{
			//$event = $gcal->createEvent(strtotime($log['order_for']), $log['public_name'], $description, $cal);
			//mysql_query('INSERT INTO calendars SET gcal_id = "'.$event.'", id_order = '.$log['id_order']);
			echo $log['name']."\n\n".$description."\n------------------------------------------------------------\n";
			}
		}
}


/*
$gcal = new gCal();
$gcal->createCalendar(123);
die(':'.$gcal->createEvent(time(), 'Test API', 'desc test API', $gcal->getCalendarById(123)).':');
*/


/*

no servingware
no delivery charge
no service charge

vegetarian bottom
quantity
item name

	asc fcorder

*/

?>OK
