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
	foreach($_POST['infoemail'] as $id=>$fields) {
		$notes = mysql_real_escape_string(stripslashes($fields['notes']));
		$date =  $fields['date'];	
		if ($notes == '' and $date == '') {}
		else {
		//echo $notes.' ----- '.$date.' ----- '.$id.'<br>';
		mysql_query('UPDATE info_email SET notes = "'.$notes.'" WHERE id_info = "'.$id.'"');
		mysql_query('UPDATE info_email SET date2 = "'.$date.'"WHERE id_info = "'.$id.'"');
		}				
			}
			
	foreach($_POST['news'] as $id=>$fields) {
		$notes = mysql_real_escape_string(stripslashes($fields['notes']));
		$date =  $fields['date'];	
		if ($notes == '' and $date == '') {}
		else {
		//echo $notes.' ----- '.$date.' ----- '.$id.'<br>';
		mysql_query('UPDATE website_newsletter_emails SET notes = "'.$notes.'" WHERE email_w = "'.$id.'"');
		mysql_query('UPDATE website_newsletter_emails SET date2 = "'.$date.'"WHERE email_w = "'.$id.'"');
		}
		}	
		
		foreach($_POST['signup'] as $id=>$fields) {
		$notes = mysql_real_escape_string(stripslashes($fields['notes']));
		$date =  $fields['date'];	
		if ($notes == '' and $date == '') {}
		else {
		//echo $notes.' ----- '.$date.' ----- '.$id.'<br>';
		mysql_query('UPDATE website_signup_attempts SET notes = "'.$notes.'" WHERE email = "'.$id.'"');
		mysql_query('UPDATE website_signup_attempts SET date2 = "'.$date.'"WHERE email = "'.$id.'"');
		}
		}
		
		foreach($_POST['refer'] as $id=>$fields) {
		$notes = mysql_real_escape_string(stripslashes($fields['notes']));
		$date =  $fields['date'];	
		if ($notes == '' and $date == '') {}
		else {
		//echo $notes.' ----- '.$date.' ----- '.$id.'<br>';
		mysql_query('UPDATE referral_email SET notes = "'.$notes.'" WHERE id_ref = "'.$id.'"');
		mysql_query('UPDATE referral_email SET date2 = "'.$date.'"WHERE id_ref = "'.$id.'"');
		}
		}	

}
$template = array(
	'title' => 'Cater2.me | Capture management',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Capture management'=>'/dashboard/capture/'),
	'menu_selected' => 'Dashboard',
	'header_resources' => '
		<script src="/template/js/custom/user-mgmt.js"></script>
		
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>
		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
		<script src="/template/js/custom/jquery.ui.datepicker.js"></script>
		<link rel="stylesheet" href="/template/css/custom/tablesorter/style.css" />
		<script type="text/javascript" src="/template/js/custom/jquery.tablesorter.min.js"></script>
		<script type="text/javascript">
		
		$(document).ready(function() {
			  $("#tblUsers").tablesorter();
		    }
		);
		 
		$(function() {
			$( ".accordion" ).accordion({
				autoHeight: false,
				navigation: true,
				collapsible: true,
				active: false
			});
		});
		
		$(function()
{
var date = $("#date").datepicker({ dateFormat: "yy-mm-dd" });
$("#date").datepicker();

});
		
		</script>
	
	',
	
	'grey_bar' => 'Capture management'
	);
	
require 'header.php';
?>
Emails asking for informations
<table id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th>E-mail</th> 
    <th>Page</th>
    <th>IP Adress</th> 
    <th>Date</th> 
    <th>Name</th> 
    <th>Phone</th> 
    <th>Referral</th> 
    <th>Date note</th> 
</tr> 
</thead> 
<tbody> 
<form method="post"  name="f">

<?

$res = mysql_query('SELECT * FROM info_email ');
while($email = mysql_fetch_assoc($res))
{
?>
<tr> 
    <td id="usrUsername<?=$email['id_info']?>"><?=$email['email_info']?></td>
    <td id="usrUsername<?=$email['id_info']?>"><?=$email['page_info']?></td>
    <td id="usrEmail<?=$email['id_info']?>"><?=$email['ip_info']?></td>
    <td id="usrPersonalNumber<?=$email['id_info']?>"><?=$email['date_info']?></td>
    <td id="usrCarrier<?=$email['id_info']?>"><?=$email['name_email']?></td>
    <td id="usrCarrier<?=$email['id_info']?>"><?=$email['tel_email']?></td>
    <td id="usrCarrier<?=$email['id_info']?>"><?=$email['refer_email']?></td> 
 	 <td ><input type="text" id="date" value ="<?=$email['date2']?>" name="infoemail[<?=$email['id_info']?>][date]"placeholder="yy-mm-dd"  </td></tr><tr>
<td colspan="8">
<div class="accordion">
	<h3 style="border:0px;"><a href="#">Click to write / see notes</a></h3>
	<div><input type="text"  size="140"  value ="<?=$email['notes']?>" name="infoemail[<?=$email['id_info']?>][notes]">
	</div> 
</div></td>
</tr> 
<? } ?>
</tbody> 
</table> 

Emails subscribing to the newsletter
<table id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th>E-mail</th> 
    <th>Name</th>
    <th>Company</th>  
   
    <th>IP Adress</th> 
    <th>Date</th> 
     <th>Page</th> 
     <th>Newsletter</th>
     <th>Notes</th> 
    <th>Date note</th>  
</tr> 
</thead> 
<tbody> 
<?
$res = mysql_query('SELECT * FROM website_newsletter_emails ');
while($email = mysql_fetch_assoc($res))
{
if($email['newsletter_w']=='1')
{$news='C2me newsletter';} else {$news='BetaKitchen newsletter';}
?>
<tr> 
    <td id="usrUsername<?=$email['email_w']?>"><?=$email['email_w']?></td>
    <td id="usrUsername<?=$email['email_w']?>"><?=$email['name_w']?></td>
    <td id="usrEmail<?=$email['email_w']?>"><?=$email['company_w']?></td>
     <td id="usrEmail<?=$email['email_w']?>"><?=$email['ip_news']?></td>
    <td id="usrPersonalNumber<?=$email['email_w']?>"><?=$email['date_news']?></td>
    <td id="usrPersonalNumber<?=$email['email_w']?>"><?=$email['page']?></td>
	<td id="usrPersonalNumber<?=$email['email_w']?>"><?=$news?></td>
<td id="usrCarrier<?=$email['email_w']?>"><input type="text" value ="<?=$email['notes']?>" name="news[<?=$email['email_w']?>][notes]"></td>
 	 <td id="usrCarrier<?=$email['email_w']?>"><input type="text" id="date1" value ="<?=$email['date2']?>" name="news[<?=$email['email_w']?>][date]"placeholder="yy-mm-dd"  </td>

</tr> 
<? } ?>
</tbody> 
</table>

</table>
Emails signup attempts
<table id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th>Email</th>
    <th>IP Adress</th> 
    <th>Date</th> 
    <th>Notes</th> 
    <th>Date note</th> 
</tr> 
</thead> 
<tbody> 
<?
$res = mysql_query('SELECT * FROM website_signup_attempts ');
while($email = mysql_fetch_assoc($res))
{
?>
<tr> 
    <td id="usrUsername<?=$email['email']?>"><?=$email['email']?></td>
    <td id="usrPersonalNumber<?=$email['email']?>"><?=$email['ip_email']?></td>
    <td id="usrPersonalNumber<?=$email['email']?>"><?=$email['when']?></td>
    <td id="usrCarrier<?=$email['email']?>"><input type="text" value ="<?=$email['notes']?>" name="signup[<?=$email['email']?>][notes]"></td>
 	 <td id="usrCarrier<?=$email['email']?>"><input type="text" id="date1" value ="<?=$email['date2']?>" name="signup[<?=$email['email']?>][date]" placeholder="yy-mm-dd"  </td>

</tr> 
<? } ?>
</tbody> 
</table>

Emails referring friends
<table id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th>Name employee</th> 
    <th>Email employee</th>
    <th>Name friend</th>  
     <th>Email friend</th>
    <th>Company friend</th> 
    <th>IP Adress</th> 
    <th>Date</th> 
     <th>Page</th> 
     <th>Notes</th> 
    <th>Date note</th> 
</tr> 
</thead> 
<tbody> 
<?
$res = mysql_query('SELECT * FROM referral_email ');
while($email = mysql_fetch_assoc($res))
{
?>
<tr> 
    <td id="usrUsername<?=$email['id_info']?>"><?=$email['name_ref']?></td>
    <td id="usrUsername<?=$email['id_info']?>"><?=$email['email_ref']?></td>
    <td id="usrEmail<?=$email['id_info']?>"><?=$email['fr_name_ref']?></td>
        <td id="usrEmail<?=$email['id_info']?>"><?=$email['fr_email_ref']?></td>
     <td id="usrEmail<?=$email['id_info']?>"><?=$email['company_ref']?></td>
    <td id="usrPersonalNumber<?=$email['id_info']?>"><?=$email['ip_address']?></td>
    <td id="usrPersonalNumber<?=$email['id_info']?>"><?=$email['date']?></td>
 <td id="usrPersonalNumber<?=$email['id_info']?>"><?=$email['page']?></td>
 	 <td id="usrCarrier<?=$email['id_ref']?>"><input type="text" value ="<?=$email['notes']?>" name="refer[<?=$email['id_ref']?>][notes]"></td>
 	 <td id="usrCarrier<?=$email['id_ref']?>"><input type="text" id="date1" value ="<?=$email['date2']?>" name="refer[<?=$email['id_ref']?>][date]" placeholder="yy-mm-dd"  </td>

</tr> 
<? } ?>
</tbody> 
</table>
</div>
<p style="margin:30px; text-align:center"><input type="submit" value="Update" /></p>
</form> 
<?

require 'footer.php';

