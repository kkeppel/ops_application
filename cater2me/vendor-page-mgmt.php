<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}
$name= $curUser['first_name'];

if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');


if($_SERVER['REQUEST_METHOD']=='POST')
{
			switch($_POST['action'])
	{
		case 'vndrEdit':
		notif('PLP');			break;
				}
		
}
		 
$template = array(
	'title' => 'Cater2.me | Vendor Page management',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Vendor Page management'=>'/dashboard/vendor-page-mgmt/'),
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
	
	'grey_bar' => 'Vendor Page management'
	);

require 'header.php';


?>
<div class="grid_7" id="contact-page">
<form method="post">

<table id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th width="10%">Vendor name</th> 
    <th width="70%">Description</th> 
    <th width="10%">Twitter</th> 
    <th width="10%">Facebook</th> 
	<th width="10%">Actions</th> 

</tr> 
</thead> 
<tbody> 
<?
$res = mysql_query('SELECT * FROM Vendor');
while($vendor = mysql_fetch_assoc($res))
{
?>
<tr> 
    <td id="vnd_name<?=$vendor['id_vnd']?>"><a href="vendor_page.php/<?=$vendor['url_v']?>"><?=$vendor['name_v']?></a></td>
    <td id="vnd_desc<?=$vendor['id_vnd']?>"><?=$vendor['desc_v']?></td>
    <td id="vnd_twit<?=$vendor['id_vnd']?>"><?=$vendor['twitter_v']?></td>
    <td id="vnd_fb<?=$vendor['id_vnd']?>"><?=$vendor['facebook_v']?></td>
    <td><a href='/manage-vendor.php?a=<?=$vendor['id_v']?>'>
    <img title="edit vendor" id="vndrEdit<?=$vendor['id_v']?>" src="/template/images/custom/user_edit.png" /></a></td>
</tr> 
<? } ?>
</tbody> 
</table> 

</form>
<p style="margin:30px; text-align:center"><form action="/add-vendorpage-mgmt.php"><input type="submit" value="Add a vendor" /></form>
<form action="/comment-page-mgmt.php"><input type="submit" value="Manage Comments" /></form>


</div>
<?
require 'footer.php';

?>