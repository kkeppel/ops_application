<?

require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser) != 'staff') notif('Denied');


if($_SERVER['REQUEST_METHOD']=='POST')
{
	mysql_query('DELETE FROM calendars WHERE company_id > 1');
	
	
	foreach($_POST['gcal'] as $company_id => $string) {
		
		if($string) //string not empty
		{
			$cals=explode(';', $string);
			foreach($cals as $cal) {
				mysql_query('INSERT INTO calendars (gcal_id, company_id) VALUES ("'.trim($cal).'", "'.$company_id.'")');	
			}
		
			
		}
	}
}


$template = array(
	'menu_selected' => 'home',
	'grey_bar' => 'Manage calendars',
	'header_resources' => '
		<link rel="stylesheet" href="/template/css/custom/tablesorter/style.css" />
		<script type="text/javascript" src="/template/js/custom/jquery.tablesorter.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			  $("#tblCalendars").tablesorter();
		    }
		);
		</script>
		
		<style>
		#tblCalendars td input {
		width:500px;
		}
		</style>
	',
	);


require 'header.php';

?>
<form method="post">
<p>Separate calendar IDs with semi-colons</p>

<table id="tblCalendars" class="tablesorter"> 
<thead> 
<tr>
    <th>ID company</th>  
    <th>Company</th> 
    <th>GCal</th> 
</tr> 
</thead> 
<tbody> 
<?

/*
Company: 0, 1, 2
each{template}

id_order_proposal
id_order
public_name
food_category (label)
order_for (date[])
employees
profile_name
vendor_name (name)
feedback_link

items:
menu_name
quantity
description
notes
*/


$res = mysql_query('SELECT id_company, name FROM companies ORDER BY name');
while($log = mysql_fetch_assoc($res)) {
	
	$cals=array();
	
	$res2 = mysql_query('SELECT gcal_id FROM calendars WHERE company_id = '.$log['id_company']);
	while($log2 = mysql_fetch_assoc($res2)) {
		
		$cals[] = $log2['gcal_id'];
		
	}
	
	echo '<tr><td>'.$log['id_company'].'</td><td> '.$log['name'].' </td><td> <input type="text" name="gcal['.$log['id_company'].']" value="'.implode('; ',$cals).'" /> </td></tr>';
}

?>
</tbody>
</table>
<br /><br />
<p style="text-align:center"> <input type="submit" value="Update" /> </p>
</form>
<?

require 'footer.php';
