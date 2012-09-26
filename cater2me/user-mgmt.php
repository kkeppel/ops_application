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



if($_SERVER['REQUEST_METHOD']=='POST')
{
	switch($_POST['action'])
	{
		case 'usrEdit':
		
		if(getUserGroup($curUser)!='staff')
			notif('Sorry, you can\'t do that.');
		else
		{
			//check username not in use already
			if(mysql_num_rows(mysql_query('SELECT 1 FROM users WHERE username = "'.mysql_real_escape_string(stripslashes($_POST['username'])).'" AND id_user <> '.(int)$_POST['id']))) die('Username already in use');
			
			mysql_query('UPDATE users SET username = "'.mysql_real_escape_string(stripslashes($_POST['username'])).'", email = "'.mysql_real_escape_string(stripslashes($_POST['email'])).'", personal_number = "'.mysql_real_escape_string(stripslashes($_POST['personal_number'])).'", carrier = "'.mysql_real_escape_string(stripslashes($_POST['carrier'])).'" WHERE id_user = '.(int)$_POST['id']) or die(mysql_error());
			die('ok');
		}
		
		break;
		case 'resetPwd':
		
		if(getUserGroup($curUser)!='staff')
			notif('Sorry, you can\'t do that.');
		else
		{
			mysql_query('UPDATE users SET users.password = "'.md5(stripslashes($_POST['pwd'])).'" WHERE id_user = '.(int)$_POST['id']) or die(mysql_error());
			die('ok');
		}
		
		break;
		case 'activate':
		
		if(getUserGroup($curUser)!='staff')
			notif('Sorry, you can\'t do that.');
		else
		{
			mysql_query('UPDATE users SET deactivated = 0 WHERE id_user = '.(int)$_POST['id']) or die(mysql_error());
			die('ok');
		}
		
		break;
		case 'deactivate':
		
		if(getUserGroup($curUser)!='staff')
			notif('Sorry, you can\'t do that.');
		else
		{
			mysql_query('UPDATE users SET deactivated = 1 WHERE id_user = '.(int)$_POST['id']) or die(mysql_error());
			die('ok');
		}
		
		break;
		case 'loginAs':
		
		if(getUserGroup($curUser)!='staff')
			notif('Sorry, you can\'t do that.');
		else
		{
			$res = mysql_query('SELECT username, users.password FROM users WHERE id_user = '.(int)$_POST['id']);
			$log = mysql_fetch_assoc($res);
			authenticate($log['username'],$log['password']);
			
			mysql_query('UPDATE users SET nb_logins=nb_logins-1 WHERE id_user = '.(int)$_POST['id']);
			
			die('ok');
		}
		
		break;
		case 'addUser': //only action that's not Ajax
		
		if(getUserGroup($curUser)!='staff')
			notif('Sorry, you can\'t do that.');
		else
		{
			//req ajout ici
		}	
		
		break;
	}
}

$template = array(
	'title' => 'Cater2.me | User management',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'User management'=>'/dashboard/user-mgmt/'),
	'menu_selected' => 'home',
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
	
	'grey_bar' => 'User management'
	);

require 'header.php';

?>
<div class="grid_7" id="contact-page">

<form method="post">


<p>Carriers available:<br />
ATT, Verizon, T-Mobile, Sprint, Metro PCS
</p>

<table id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th>Username</th> 
    <th>E-mail</th> 
    <th>Personal number</th> 
    <th>Carrier</th> 
    <th>User type</th> 
    <th>Company</th> 
    <th>Last visit</th> 
    <th>Created</th> 
    <th>Nb visits</th> 
    <th>Actions</th> 
</tr> 
</thead> 
<tbody> 
<?
$res = mysql_query('SELECT * FROM users ORDER BY username');
while($user = mysql_fetch_assoc($res))
{
?>
<tr> 
    <td id="usrUsername<?=$user['id_user']?>"><?=$user['username']?></td>
    <td id="usrEmail<?=$user['id_user']?>"><?=$user['email']?></td>
    <td id="usrPersonalNumber<?=$user['id_user']?>"><?=$user['personal_number']?></td>
    <td id="usrCarrier<?=$user['id_user']?>"><?=$user['carrier']?></td>
    <td><?=getUserGroup($user)?></td>
    <td><?
    
    
    
	    // TODO: denormalize database and put "company" varchar field in "users" table to avoid the following subquery
    
	    switch(getUserGroup($user))
	    {
	    	case 'staff':
	    	echo 'C2ME';
	    	break;
	    	case 'vendor':
	    	$sql='SELECT name FROM vendors WHERE id_vendor = '.$user['vendor_id'];
	    	break;
	    	case 'client':
	    	$sql='SELECT name FROM companies, clients WHERE id_company=company_id AND id_client = '.$user['client_id'];
	    	break;
	    	case 'employee':
	    	$sql='SELECT name FROM companies, employees WHERE id_company=company_id AND id_employee = '.$user['employee_id'];
	    	break;
	    }
	    
	    if(isset($sql)) //query needed
	    {
		    $res2=mysql_query($sql);
		    $company=mysql_fetch_row($res2);
		    echo $company[0];
		    unset($sql);
	    }
    
    
    
    ?></td> 
    <td><?=(($user['last_visit']=='0000-00-00 00:00:00')?'never':date('M d, Y g:i A', strtotime($user['last_visit'])))?></td>
    <td><?=date('M d, Y g:i A', strtotime($user['created']))?></td>
    <td><?=$user['nb_visits']?></td>
    <td>
    	<a href="javascript:void(0)" onclick="userEdit(<?=$user['id_user']?>)"><img title="edit user" id="usrEdit<?=$user['id_user']?>" src="/template/images/custom/user_edit.png" /></a>
    	<a href="javascript:void(0)" onclick="toggleAccountStatus(<?=$user['id_user']?>)"><img title="<? if(!$user['deactivated']) echo 'de'; ?>activate account" id="usrAccountStatus<?=$user['id_user']?>" src="/template/images/custom/user_<? if($user['deactivated']) echo 'de'; ?>activated.png" /></a>
    	<a title="change password" href="javascript:void(0)" onclick="resetPassword(<?=$user['id_user']?>)"><img src="/template/images/custom/reset_password.png" /></a>
    	<? if(getUserGroup($user)!='staff') { ?>
    	<a title="log in as user" href="javascript:void(0)" onclick="loginAsUser(<?=$user['id_user']?>)"><img src="/template/images/custom/user_login_account.png" /></a>
    	<? } ?>
    </td>
</tr> 
<? } ?>
</tbody> 
</table> 

<!--
<fieldset><legend>Add new User</legend>

<table>
<tr><th> Username </th><td> <input type="text" name="username" /> </td></tr>
<tr><th> Password </th><td> user will pick </td></tr>
<tr><th> E-mail </th><td> <input type="email" name="email" /> </td></tr>
<tr><th> User type </th><td>
	<select name="account_type" onchange="toggleAccountType(this)">
		<option value="client">Client (main contact)</option>
		<option value="employee">Client (employee)</option>
		<option value="staff">C2me Staff</option>
		<option value="vendor">Vendor</option>
	</select>
</td></tr>

<tr id="trClients"><th> Company </th><td>
	<select name="company">
		<option value="0">-- please select --</option>
		<? $res = mysql_query('SELECT id_company, name FROM companies ORDER BY 2');
		while($log = mysql_fetch_assoc($res)) { ?>
		<option value="<?=$log['id_company']?>"><?=$log['name']?></option>
		<? } ?>
	</select>
</td></tr>
<tr><th> Notification </th><td> <input type="checkbox" checked="checked" name="notif" value="1" /> Send an e-mail to the user (welcome + password creation) </td></tr>

</table>
<input type="hidden" name="action" value="addUser" />

<p><input type="submit" value="Add" /></p>

</fieldset>
-->

</form>

</div>
<?

require 'footer.php';
