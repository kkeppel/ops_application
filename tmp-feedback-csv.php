<?

require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser)!='staff') notif('Sorry, you are not supposed to be here.');

function formatdate($datetime)
{
   $day = date("d", strtotime($datetime));
  $month =  date("n", strtotime($datetime));
  $year = date("Y", strtotime($datetime));
	return $month.'/'.$day.'/'.$year;
}

if(isset($_GET['csv']))
{
	$filters = '';
	if(isset($_GET['start']) && $_GET['start']) $filters.=' AND order_for > "'.$_GET['start'].'"';
	if(isset($_GET['end']) && $_GET['end']) $filters.=' AND order_for < "'.$_GET['end'].'"';
	if(isset($_GET['client']) && $_GET['client']) $filters.=' AND o_r.client_id = "'.$_GET['client'].'"';
	if(isset($_GET['vendor']) && $_GET['vendor']) $filters.=' AND o_p.vendor_id = "'.$_GET['vendor'].'"';
	
	header('Content-Type: application/force-download');
	
	if($_GET['csv']=='items')
	{
		echo '"feedback_items_id","item_id","food_rating","portioning","user_id","user_type","first_name","last_name","email"'."\n";
		
		//$res = mysql_query('SELECT * FROM order_feedback_items ORDER BY item_id');
		$res = mysql_query('SELECT feedback_items_id, o_p.order_id, u.client_id, o_p.vendor_id, order_for, item_id, o_f_i.food_rating, o_f_i.portioning, o_f_i.user_id, first_name, last_name, email, u.id_user 
		FROM order_feedback_items o_f_i, order_proposal_items o_p_i, order_proposals o_p, order_requests o_r, users u, order_feedback o_f
		WHERE o_f_i.item_id = o_p_i.id_proposal_item
		AND o_p_i.order_proposal_id = o_p.id_order_proposal
		AND  o_f.user_id = u.id_user
		AND o_f.order_id = o_r.id_order
		AND o_p.order_id = o_r.id_order
		'.$filters.'
		ORDER BY feedback_items_id');
		while($log = mysql_fetch_assoc($res))
		{
			if($log['employee_id']) $role='employee';
			elseif($log['client_id']) $role='client';
			else $role='N/A';
			
			echo '"'.$log['feedback_items_id'].'","'.$log['item_id'].'","'.$log['food_rating'].'","'.$log['portioning'].'","'.$log['id_user'].'","'.$role.'","'.$log['first_name'].'", "'.$log['last_name'].'","'.$log['email'].'"'."\n";
		}
	}
	else if ($_GET['csv']=='tips')
	{
	echo '"feedback_id","id_order","id_order_proposal","order_for","vendor_name","company_name","client_id","employee_id","tip_type"'."\n";

		
		//$res = mysql_query('SELECT * FROM order_feedback_items ORDER BY item_id');
		$res = mysql_query('SELECT feedback_id, id_order, id_order_proposal, order_for, v.name vname, co.name coname, u.client_id, u.employee_id, tip_type, tip_feedback
FROM order_requests o_r, order_proposals o_p, clients cl, companies co, order_feedback o_f, users u, vendors v
WHERE o_r.id_order = o_p.order_id
AND o_p.selected =1
AND o_r.client_id = cl.id_client
AND cl.company_id = co.id_company
AND o_f.order_id = o_r.id_order
AND o_f.user_id = u.id_user
AND o_p.vendor_id = v.id_vendor
'.$filters.'
ORDER BY feedback_id');
		while($log = mysql_fetch_assoc($res))
		{
			
			echo '"'.$log['feedback_id'].'","'.$log['id_order'].'","'.$log['id_order_proposal'].'","'.$log['order_for'].'","'.$log['vname'].'","'.$log['coname'].'","'.$log['client_id'].'","'.$log['employee_id'].'","'.$log['tip_type'].'","'.$log['tip_feedback'].'"'."\n";
		}
	}
	
	else  //orders
	{
		echo 
			 '"feedback_id","id_order","id_order_proposal","order_for","vendor_name","food_rating","service_rating","when_next","SpecificDate","feedback_public","feedback_private","c2me_rating","tip","role"'."\n";
	
		//$res = mysql_query('SELECT * FROM order_feedback ORDER BY order_id');
		$res = mysql_query('SELECT feedback_id, id_order, id_order_proposal, order_for, v.name vname, co.name coname, food_rating, service_rating, when_next, feedback_public, feedback_private, c2me_rating, o_r.tip, u.client_id, u.employee_id, first_name,last_name,email, portioning
		FROM order_requests o_r, order_proposals o_p, clients cl, companies co, order_feedback o_f, users u, vendors v
		WHERE o_r.id_order = o_p.order_id
		AND o_p.selected = 1
		AND o_r.client_id = cl.id_client
		AND cl.company_id = co.id_company
		AND o_f.order_id = o_r.id_order
		AND o_f.user_id = u.id_user
		AND o_p.vendor_id = v.id_vendor
		'.$filters.'
		ORDER BY feedback_id
		');
		while($log = mysql_fetch_assoc($res))
		{
			if($log['employee_id']) $role='employee';
			elseif($log['client_id']) $role='client';
			else $role='N/A';
			$date1 = $log['order_for'];
			$date = formatdate($date1);
			
			echo '"'.$log['feedback_id'].'","'.$log['id_order'].'","'.$log['id_order_proposal'].'","'.$date.'","'.utf8_decode($log['vname']).'","'.$log['food_rating'].'","'.$log['service_rating'].'","'.$log['when_next'].'","","'.utf8_decode(str_replace("\r",' ',str_replace('"',"'",str_replace("\n",' ',$log['feedback_public'])))).'","'.utf8_decode(str_replace("\r",' ',str_replace('"',"'",str_replace("\n",' ',$log['feedback_private'])))).'","'.$log['c2me_rating'].'","'.$log['tip'].'","'.$role.'"'."\n";
		}
	}
die;
}

$tmp = '<form>
<table style="margin:0 auto">
<tr><td> Get </td><td> Orders <input type="radio" name="csv" value="orders" checked="checked" /> Items <input type="radio" name="csv" value="items" /> Tips <input type="radio" name="csv" value="tips" />  </td></tr>
<tr><td> Date start </td><td> <input type="text" name="start" placeholder="YYYY-MM-DD" /> </td></tr>
<tr><td> Date end </td><td> <input type="text" name="end" placeholder="YYYY-MM-DD" /> </td></tr>
<tr><td> Client ID </td><td> <input type="text" name="client" placeholder="0" /> </td></tr>
<tr><td> Vendor ID </td><td> <input type="text" name="client" placeholder="0" /> </td></tr>
</table>

<p>All fields are optional</p>

<p><input type="submit" value="Submit" /></p>

</form>';

notif($tmp);

require 'header.php';

?>

CSV columns for ORDERS:<br />
id_order, id_order_proposal, order_for, vendor_name, client_name, food_rating, service_rating, when_next, feedback_public, feedback_private, c2me_rating, tip, role<br />

<a href="/tmp-feedback-csv.php?csv=orders">Right click "Save target as"</a>
<br /><br /><br />


CSV columns for INDIVIDUAL ITEMS:<br />
order_id, client_id, vendor_id, order_for, proposal_item_id, food_rating, portioning<br />

<a href="/tmp-feedback-csv.php?csv=items">Right click "Save target as"</a>

<br /><br /><br />
Notes:<br />
portioning: (0) undefined | (1) not enough | (2) just right | (3) too much<br />
when_next (in weeks): -1: never | 0: N/A

<?
require 'footer.php';
?>
