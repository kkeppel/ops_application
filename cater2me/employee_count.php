<?

require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

switch(getUserGroup($curUser))
{
case 'staff':
break;
default: //vendor, employee
	notif('Sorry, you are not allowed here.');
break;
}

$template = array(
	'title' => 'Cater2.me | User management',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'User management'=>'/dashboard/user-mgmt/'),
	'menu_selected' => 'dashboard',
	'header_resources' => '
		<script src="/template/js/custom/user-mgmt.js"></script>
		
		<link rel="stylesheet" href="/template/css/custom/tablesorter/style.css" />
		<script type="text/javascript" src="/template/js/custom/jquery.tablesorter.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			  $("#tblUsers").tablesorter();
		    }
		);
		</script>
	',
	
	'grey_bar' => 'Employee management'
	);

require 'header.php';

 $companyid = ($_POST['company']);

$res = mysql_query("SELECT  count(id_user) as count, name
FROM users, employees, companies
WHERE employee_id = id_employee
AND company_id = id_company
and company_id = '$companyid'");
$count = mysql_fetch_assoc($res);
$res4 = mysql_query("SELECT  count(id_user) as count, name
FROM users, clients, companies
WHERE client_id = id_client
AND company_id = id_company
and company_id = '$companyid'");
$count2 = mysql_fetch_assoc($res4);
?>
<h2>The company <?=$count['name'];?> has <?=$count['count'];?> employees and <?=$count2['count'];?> clients who signed up.</h2> <br>

<table id="tblUsers"> 
<thead> 
<tr> 
    <th>Username</th> 
    <th>First Name</th> 
    <th>Last Name</th> 
    <th>Email</th> 
    <th>User type</th> 
	<th>Nb visits</th> 
    <th>Last visits</th> 
    <th>Created</th> 
</tr> 
<? $res3 = mysql_query("SELECT * FROM users, clients
WHERE client_id = id_client
AND company_id ='$companyid' order by username ");
while($user2 = mysql_fetch_assoc($res3))
{
?>
<tr> 
    <td id="usrUsername<?=$user2['id_user']?>"><?=$user2['username']?></td>
    <td id="usrEmail<?=$user2['id_user']?>"><?=$user2['first_name']?></td>
    <td id="usrPersonalNumber<?=$user2['id_user']?>"><?=$user2['last_name']?></td>
    <td id="usrCarrier<?=$user2['id_user']?>"><?=$user2['email']?></td>
    <td><?=getUserGroup($user2)?></td>
 	<td id="usrCarrier<?=$user2['id_user']?>"><?=$user2['nb_visits']?></td>
 	<td><?=(($user2['last_visit']=='0000-00-00 00:00:00')?'never':date('M d, Y g:i A', strtotime($user2['last_visit'])))?></td>
    <td><?=date('M d, Y g:i A', strtotime($user2['created']))?></td>
</tr>
<? } ?>
<? $res2 = mysql_query("SELECT * FROM users, employees
WHERE employee_id = id_employee
AND company_id ='$companyid' order by username");
while($user = mysql_fetch_assoc($res2))
{
?>
<tr> 
    <td id="usrUsername<?=$user['id_user']?>"><?=$user['username']?></td>
    <td id="usrEmail<?=$user['id_user']?>"><?=$user['first_name']?></td>
    <td id="usrPersonalNumber<?=$user['id_user']?>"><?=$user['last_name']?></td>
    <td id="usrCarrier<?=$user['id_user']?>"><?=$user['email']?></td>
    <td><?=getUserGroup($user)?></td>
 	<td id="usrCarrier<?=$user['id_user']?>"><?=$user['nb_visits']?></td>
 	<td><?=(($user['last_visit']=='0000-00-00 00:00:00')?'never':date('M d, Y g:i A', strtotime($user['last_visit'])))?></td>
    <td><?=date('M d, Y g:i A', strtotime($user['created']))?></td>
</tr>
<? } 
?>
</table>
<?

require 'footer.php';
