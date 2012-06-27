<?

require 'lib/core.php';
require 'lib/gcalendar.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser) != 'staff') notif('Denied');


if(!isset($_GET['companies'])) $form=1; //notif('GET[companies] needs to be defined (11,22,33,44,55..)');
if(!isset($_GET['start'])) $form=1; //notif('GET[start] needs to be defined (YYYY-MM-DD)');
if(!isset($_GET['end'])) $form=1; //notif('GET[end] needs to be defined (YYYY-MM-DD)');
if(!isset($_GET['meal'])) $form=1; //notif('GET[meal] needs to be defined (1-6)');
if(!isset($_GET['status'])) $form=1; //notif('GET[status] needs to be defined (4,7)');
/*
1	
2	Appetizers
3	Breakfast
4	Dinner
5	Event
6	Lunch
*/

if(isset($form)) {

$select_companies = '<select onchange="document.f.companies.value=document.f.companies.value+this.value+\',\'"><option value="">-- list --</option>';
$res = mysql_query('SELECT id_company, name FROM companies, calendars WHERE id_company = company_id GROUP BY 1 ORDER BY 2');
while($log = mysql_fetch_assoc($res)) {
	$select_companies.='<option value="'.$log['id_company'].'">'.$log['id_company'].' - '.$log['name'].'</option>';
}
$select_companies.= '<select>';

	$tmp='
	<form method="get" name="f">
	<table style="margin:0 auto">
	<tr><td> Companies: </td><td> <input type="text" name="companies" placeholder="1,2,3,4,5" required /> <br />'.$select_companies.' </td></tr>
	<tr><td> Date start: </td><td> <input type="text" name="start" placeholder="YYYY-MM-DD" required /> </td></tr>
	<tr><td> Date end: </td><td> <input type="text" name="end" placeholder="YYYY-MM-DD" required /> (add +1) </td></tr>
	<tr><td> Status: </td><td> <select name="status"> <option value="4">confirmed</option><option value="7">prop selected</option> </select> </td></tr>
	<tr><td> Type: </td><td> <select name="meal"> <option value="*">-- all --</option>';
	
	$res = mysql_query('SELECT * FROM meal_types');
	while($log = mysql_fetch_assoc($res)) {
		$tmp.='<option value="'.$log['id_meal_type'].'">'.$log['label'].'</option>';
	}
	
	$tmp.='</select> </td></tr>
	<tr><td> Include feedback link: </td><td> <input type="checkbox" name="feedback" value="1" checked="checked" /> </td></tr>
	<tr><td> Include allergenes: </td><td> <input type="checkbox" name="allergen" value="1" checked="checked" /> </td></tr>
	<tr><td> In title: </td><td>
		<input type="checkbox" name="employees" value="1" /> Head count<br />
		<input type="checkbox" name="profile" value="1" /> Profile name<br />
	</td></tr>
	</table><br />
	<br />
	<input type="button" value="Add to GCal" onclick="this.disabled=true;this.value=\'processing...\';document.f.submit();" />
	</form>';
	
	notif($tmp);
}

if(is_numeric($_GET['meal']))
	$_GET['meal']=' AND meal_type_id = '.$_GET['meal'];
else
	$_GET['meal']='';



$nbrAdded=0;

$companies = explode(',',$_GET['companies']);

$gcal = new gCal();

foreach($companies as $company) {

	$calendar = $gcal->getCalendarByCompanyId($company);
	
	
		///$in_title['employees'] = array();
		///$in_title['profile'] = array();
		///$res = mysql_query('SELECT employees_in_title, profile_in_title FROM calendars WHERE company_id = '.$company);
		///while($log = mysql_fetch_row($res)) {
		///	$in_title['employees'][] = $log[0];
		///	$in_title['profile'][] = $log[0];
		///}
		
	$orders = mysql_query('SELECT id_order, order_for, public_name, id_order_proposal, o_r.employees, c_p.name cpname
				  FROM order_requests o_r, clients cl, order_proposals o_p, vendors v, client_profiles c_p
				  WHERE cl.company_id = '.$company.'
				  AND cl.id_client = o_r.client_id
				  AND o_r.id_order = o_p.order_id
				  AND selected
				  '.$_GET['meal'].'
				  AND o_p.vendor_id = v.id_vendor
				  AND client_profile_id = id_profile
				  AND order_status_id = '.$_GET['status'].'
				  AND order_for BETWEEN "'.$_GET['start'].'" AND "'.$_GET['end'].'" ORDER BY order_for');


	while($order = mysql_fetch_assoc($orders)) {
						   
		$items = mysql_query('SELECT menu_name, quantity, description, label food_category, o_p_i.notes, o_p_i.non_menu_notes, vegetarian, gluten_safe, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol
					   FROM order_proposal_items o_p_i, vendor_items, food_categories f_c
					   WHERE id_food_category = food_category_id
					   AND id_vendor_item = vendor_item_id
					   	AND list_order < 19
					   AND order_proposal_id = '.$order['id_order_proposal'].' ORDER BY f_c.list_order, quantity DESC') or die(mysql_error());
		
	
					   
		$lastCategory='-';
				
		if(isset($_GET['feedback']))
			$description='<a href="http://cater2.me/dashboard/feedback/?oid='.$order['id_order'].'">'.$order['public_name'].' Feedback</a>'."\n";
		else
			$description='';
			
	
		while($item = mysql_fetch_assoc($items))
		{
		$veg = '';
		$glu= '';
		$dai= '';
		$vegan= '';
		$nut= '';
		$egg= '';
		$soy= '';
		$hon= '';
		$she= '';
		$alc= '';

		if(isset($_GET['allergen']))
		{
			// get the allergens				   
		if ($item['vegetarian']=='1')
		{ $veg = '*';}	
		if ($item['gluten_safe']=='1')
		{ $glu = '(G)';}	
		if ($item['dairy_safe']=='1')
		{ $dai = '(D)';}	
		if ($item['vegetarian'] =='1' && $item['dairy_safe']=='1' && $item['egg_safe']=='1')
		{ $vegan = '*';}
		if ($item['nut_safe']=='1')
		{ $nut = '(N)';}	
		if ($item['egg_safe']=='1')
		{ $egg = '(E)';}	
		if ($item['soy_safe']=='1')
		{ $soy = '(S)';}	
		if ($item['contains_honey']=='1')
		{ $hon = '(Contains honey)';}
		if ($item['contains_shellfish']=='1')
		{ $she = '(Contains shellfish)';}
		if ($item['contains_alcohol']=='1')
		{ $alc = '(Contains alcohol)';}
		$legend = '<br><b>Allergen Key:</b> *Vegetarian, **Vegan, (G) Gluten Safe, (D) Dairy Safe, (N) Nut Safe, (E) Egg Safe, (S) Soy Safe. <br>Items have been prepared in facilities that may contain trace amounts of common allergens. See below for full disclaimer.';
		} else {$legend =''; }
		
			if($lastCategory!=$item['food_category'])
			{
				$description.="\n<b>".$item['food_category']."</b>\n";
				$lastCategory=$item['food_category'];
			}
			
			$tmp='';
			$tmp.=(($item['description'])? ': '.$item['description']: '');
			$tmp.=(($item['notes'])? ' ('.$item['notes'].')': '');
			$description.= '* '.$item['menu_name'].$veg.$vegan.$tmp.'  <font size="1" color="#990066">'.$glu.$dai.$nut.$egg.$soy.$hon.$she.$alc."</font>\n";
		}
			$description.= 	$legend;	
		
		//foreach($calendar as $cal) //in case company has multiple calendars (rare)
		for($i=0; $i<count($calendar); $i++)
		{
		$event = $gcal->createEvent(strtotime($order['order_for']), $order['public_name'].((isset($_GET['employees']))?' ('.$order['employees'].' people)':'').((isset($_GET['profile']))?' ['.$order['cpname'].']':''), $description, $calendar[$i]);
		mysql_query('INSERT INTO calendars SET gcal_id = "'.$event.'", id_order = '.$order['id_order']);
		//echo $order['public_name'].((isset($_GET['employees']))?' ('.$order['employees'].' people)':'').((isset($_GET['profile']))?' ['.$order['cpname'].']':'')."\n\n".$description."\n------------------------------------------------------------\n";
		$nbrAdded++;
		}
	}
}


notif('Processed: '.$nbrAdded);
?>
