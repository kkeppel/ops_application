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


if($_SERVER['REQUEST_METHOD'] == 'POST') {
mysql_query('UPDATE tmp_vendors SET opt_out_confirm_notif = 0') or die(mysql_error());
mysql_query('UPDATE tmp_vendors SET opt_out_weekly_notif = 0') or die(mysql_error());
mysql_query('UPDATE tmp_vendors SET opt_out_sms_notif = 0') or die(mysql_error());
}


if(isset($_POST['confirm']))
{	
	foreach($_POST['confirm'] as $id=>$val)
	{
	
		mysql_query('UPDATE tmp_vendors SET opt_out_confirm_notif = 1 WHERE vendor_id = '.(int)$id) or die(mysql_error());
	}
}
if(isset($_POST['weekly']))
{	
	foreach($_POST['weekly'] as $id=>$val)
	{
		mysql_query('UPDATE tmp_vendors SET opt_out_weekly_notif = 1 WHERE vendor_id = '.(int)$id) or die(mysql_error());
	}
}
if(isset($_POST['sms']))
{	
	foreach($_POST['sms'] as $id=>$val)
	{
		mysql_query('UPDATE tmp_vendors SET opt_out_sms_notif = 1 WHERE vendor_id = '.(int)$id) or die(mysql_error());
	}
}


$template = array(
	'menu_selected' => 'home',
	'header_resources' => '
		<script src="/template/js/custom/user-mgmt.js"></script>
		
		<link rel="stylesheet" href="/template/css/custom/tablesorter/style.css" />
		<script type="text/javascript" src="/template/js/custom/jquery.tablesorter.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			  $("#tblVendors").tablesorter();
		    }
		);
		</script>
	',
	
	'grey_bar' => 'Vendors opt out'
	);

require 'header.php';

?>
<div class="grid_7" id="contact-page">

<form method="post">



<table id="tblVendors" class="tablesorter"> 
<thead> 
<tr> 
    <th>Vendor</th> 
    <th>Confirm notif (3,2,1d)&nbsp;&nbsp;&nbsp;</th> 
    <th>Weekly notif&nbsp;&nbsp;&nbsp;</th> 
    <th>Text msg notif&nbsp;&nbsp;&nbsp;</th> 
</tr> 
</thead> 
<tbody> 
<?
$res = mysql_query('SELECT id_vendor, name, opt_out_confirm_notif, opt_out_weekly_notif, opt_out_sms_notif FROM vendors, tmp_vendors WHERE id_vendor = vendor_id AND deactivated < 1 ORDER BY name') or die(mysal_error());
while($log = mysql_fetch_assoc($res))
{
?>
<tr> 
    <td><?=$log['name']?></td>
    <td>
    		<input type="checkbox" name="confirm[<?=$log['id_vendor']?>]" <? if($log['opt_out_confirm_notif']) echo 'checked="checked"'; ?> value="1" />
    </td>
    <td>
    		<input type="checkbox" name="weekly[<?=$log['id_vendor']?>]" <? if($log['opt_out_weekly_notif']) echo 'checked="checked"'; ?> value="1" />
    </td>
    <td>
    		<input type="checkbox" name="sms[<?=$log['id_vendor']?>]" <? if($log['opt_out_sms_notif']) echo 'checked="checked"'; ?> value="1" />
    </td>
</tr> 
<? } ?>
</tbody> 
</table> 

<p><input type="submit" value="Update" /></p>

</form>

</div>
<?

require 'footer.php';
