<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');

if($_SERVER['REQUEST_METHOD']=='POST')
	{
	if (!empty($_POST['need_delete'])) {
	 foreach ($_POST['need_delete'] as $id => $value) {
	                $sql = 'Update Comments set is_show_c=0 WHERE `id_c`='.(int)$id;
	                mysql_query($sql);
	                $sql3 = 'Update Subcomments set is_show_s=0 WHERE `id_subc_c`='.(int)$id;
	                mysql_query($sql3);

	} }
	else {
	foreach ($_POST['need_delete2'] as $id2 => $value) {
	$sql2 = 'Update Subcomments set is_show_s=0 WHERE `id_subc`='.(int)$id2;
	                mysql_query($sql2);
		}
	}}
 
$template = array(
	'title' => 'Cater2.me | Comments Page management',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Comments Page management'=>'/dashboard/comment-page-mgmt/'),
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
	
	'grey_bar' => 'Comments Page'
	);

require 'header.php';

?>
<div class="grid_7" id="contact-page">
<form method="post" name="f" enctype="multipart/form-data">

<!-- table comment -->
<table id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th>Vendor</th> 
    <th>Comment</th> 
    <th>Date</th> 
    <th>Display</th> 
    <th>Flagged</th> 
    <th>Remove</th> 
    <th>Comment_id</th> 

</tr> 
</thead> 
<tbody> 
<?
$res = mysql_query('SELECT V.name_v, C.text_c,id_c,C.is_flag_c,C.is_show_c, date_c FROM Vendor V, Comments C Where C.id_vendor_c=V.id_v');
while($comment = mysql_fetch_assoc($res))
{
if ($comment['is_flag_c'] == '1') {$flagged='yes';} else {$flagged='no';}
if ($comment['is_show_c']=='1') {$display='yes';} else {$display='no';}
$id = $comment['id_c'];
?>
<tr> 
    <td id="usrUsername<?=$comment['id_c']?>"><?=$comment['name_v']?></td>
    <td id="usrEmail<?=$comment['id_c']?>"><?=$comment['text_c']?></td>
    <td id="usrEmail<?=$comment['id_c']?>"><?=$comment['date_c']?></td>
    <td id="usrPersonalNumber<?=$comment['id_c']?>"><?=$display?></td>
    <td id="usrPersonalNumber<?=$comment['id_c']?>"><?=$flagged?></td>
	<td><input name="need_delete[<? echo $id; ?>]" type="checkbox" id="checkbox[<? echo $id; ?>]" value="<? echo $id; ?>"></td>
	<td id="usrPersonalNumber<?=$comment['id_c']?>"><?=$comment['id_c']?></td>
</tr> 
<? } ?>
</tbody> 
</table> 

<!-- table subcomment -->
<table id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th>Vendor</th> 
    <th>SubComment</th> 
    <th>Comment_id</th> 
    <th>Date</th> 
    <th>Display</th> 
    <th>Flagged</th> 
    <th>Remove</th> 

</tr> 
</thead> 
<tbody> 
<?
$res = mysql_query('SELECT id_subc,V.name_v, text_subc, id_c,is_flag_s,is_show_s, id_subc, date_subc FROM Vendor V, Comments C, Subcomments S Where C.id_vendor_c=V.id_v and C.id_c=S.id_subc_c');
while($comment = mysql_fetch_assoc($res))
{
if ($comment['is_flag_s'] == '1') {$flaggeds='yes';} else {$flaggeds='no';}
if ($comment['is_show_s']=='1') {$displays='yes';} else {$displays='no';}
$id2 = $comment['id_subc'];
?>
<tr> 
    <td id="usrUsername<?=$comment['id_c']?>"><?=$comment['name_v']?></td>
    <td id="usrEmail<?=$comment['id_c']?>"><?=$comment['text_subc']?></td>
    <td id="usrEmail<?=$comment['id_c']?>"><?=$comment['id_c']?></td>
    <td id="usrEmail<?=$comment['id_c']?>"><?=$comment['date_subc']?></td>
    <td id="usrPersonalNumber<?=$comment['id_c']?>"><?=$displays?></td>
    <td id="usrPersonalNumber<?=$comment['id_c']?>"><?=$flaggeds?></td>
	<td><input name="need_delete2[<? echo $id2; ?>]" type="checkbox" id="checkbox[<? echo $id2; ?>]" value="<? echo $id2; ?>"></td>
</tr> 
<? } ?>
</tbody> 
</table> 



<p style="margin:30px; text-align:center"><input type="submit" value="Update" /></p>
</form>


</div>
<?
require 'footer.php';

?>