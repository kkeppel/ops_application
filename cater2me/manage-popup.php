<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');
$message ='';

if($_SERVER['REQUEST_METHOD']=='POST')
{
$vnd1 = $_POST['order1'];
$vnd2 = $_POST['order2'];
$vnd3 = $_POST['order3'];
$vnd4 = $_POST['order4'];

if ($vnd1 == $vnd2 or $vnd1 == $vnd3 or $vnd1 == $vnd4 or $vnd2 == $vnd3 or $vnd2 == $vnd4 or $vnd3 == $vnd4 )
{
	$message = "<font color='red'>sorry, it is not possible to have the same vendor for different order, please try again</font><br>";
}
	else {
	$sql1 = "Update popup set order_popup='1' WHERE id_popup=$vnd1";
		    mysql_query($sql1);
	$sql2 = "Update popup set order_popup='2' WHERE id_popup=$vnd2";
		    mysql_query($sql2);
	$sql3 = "Update popup set order_popup='3' WHERE id_popup=$vnd3";
		    mysql_query($sql3);
	$sql4 = "Update popup set order_popup='4' WHERE id_popup=$vnd4";
		    mysql_query($sql4);	  
	$sql5 = "Update popup set order_popup='0' WHERE id_popup <> '$vnd1' and id_popup <> '$vnd2' and id_popup <> '$vnd3' and id_popup <> '$vnd4' ";
		    mysql_query($sql5);		      
}
}

?>
<?
$template = array(
	'title' => 'Cater2.me | Manage PopUp',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Manage PopUp '=>'/dashboard/manage-popup/'),
	'menu_selected' => 'dashboard',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
	
		<script>
		$(function() {
			$( ".accordion" ).accordion({
				autoHeight: false,
				navigation: true,
				collapsible: true,
				active: false
			});
		});
		
		function deleteResource(res_type, id) {
			document.f.delete_resource.value=res_type;
			document.f.id_resource.value=id;
			document.f.submit();
		}
		</script>
		
		<style>
		
		#tblHTML td {
		  height: 35px;
		  vertical-align: middle;
		}
		#tblHomeSlider {
		border:0;
		width:100%;
		}
		#tblHomeSlider td {
		border:0;
		}
		
		fieldset {
		border:1px #777 solid;
		padding:10px;
		}
		fieldset legend {
		margin-left:2px;
		}
		.del {
		color:red !important;
		}
		</style>
	',
	
	'grey_bar' => 'Manage PopUp'
	);

require 'header.php';


?>
<div class="grid_7" id="contact-page">
<p style="margin:30px; text-align:center"><form action="/add-popup.php"><input type="submit" value="Add a popup" /></form></p>
<p style="margin:30px; text-align:center"><form action="/add-multiple-popup.php"><input type="submit" value="Add multiple popup" /></form></p>
<!-- <form method="post"> -->

<table id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th width="30%">Vendor name</th> 
  
	<th width="10%">Actions</th> 

</tr> 
</thead> 
<tbody> 
<?
$res = mysql_query('SELECT * FROM vendors order by public_name	');
while($popup = mysql_fetch_assoc($res))
{
?>
<tr> 
 <td id="vnd_name<?=$popup['id_vendor']?>"><?=$popup['public_name']?></td>
    <td><a href='/edit-popup.php?a=<?=$popup['id_vendor']?>'>
    &nbsp;<img title="edit vendor" id="vndrEdit<?=$popup['id_v']?>" src="/template/images/custom/user_edit.png" />  </a>
    <a href='/delete-popup.php?a=<?=$popup['id_vendor']?>' class="del" onclick="return confirm('Are you sure you want to delete <?=$popup['name_popup']?> ?');" >
      &nbsp;&nbsp;&nbsp;X</a>
      <a href='/sample-vendor.php?a=<?=$popup['id_vendor']?>'>see calendar</a>
    </td>
</tr> 
<? } ?>
</tbody> 
</table> 
<!--
<p style="margin:30px; text-align:center"><input type="submit" value="Validate the new order" />
</form>

-->
<!--
<center>
<form method="post">
Change the order: <br> <? echo $message ?>

	Vendor 1  
	<select name="order1">
	<?php 
	$res3= mysql_query("SELECT id_popup FROM popup where order_popup = '1'");
	$popord = mysql_fetch_assoc($res3);
	$popuporder1= $popord['id_popup'];
	$req = mysql_query('SELECT * FROM popup order by name_popup');
	while($donnees=mysql_fetch_array($req))
	{
	echo '<option ';
	if($popuporder1==$donnees['id_popup'])
	   {
	   echo 'selected="selected" ';
	   }
	echo 'value="'.$donnees['id_popup'].'">'.$donnees['name_popup'].'</option>' ;
	} ?>
	</select><br>

	Vendor 2
	<select name="order2">
	<?php 
	$res3= mysql_query("SELECT id_popup FROM popup where order_popup = '2'");
	$popord = mysql_fetch_assoc($res3);
	$popuporder1= $popord['id_popup'];
	$req = mysql_query('SELECT * FROM popup order by name_popup');
	while($donnees=mysql_fetch_array($req))
	{
	echo '<option ';
	if($popuporder1==$donnees['id_popup'])
	   {
	   echo 'selected="selected" ';
	   }
	echo 'value="'.$donnees['id_popup'].'">'.$donnees['name_popup'].'</option>' ;
	} ?>
	</select><br>

	Vendor 3  
	<select name="order3">
	<?php 
	$res3= mysql_query("SELECT id_popup FROM popup where order_popup = '3'");
	$popord = mysql_fetch_assoc($res3);
	$popuporder1= $popord['id_popup'];
	$req = mysql_query('SELECT * FROM popup order by name_popup');
	while($donnees=mysql_fetch_array($req))
	{
	echo '<option ';
	if($popuporder1==$donnees['id_popup'])
	   {
	   echo 'selected="selected" ';
	   }
	echo 'value="'.$donnees['id_popup'].'">'.$donnees['name_popup'].'</option>' ;
	} ?>
	</select><br>

	Vendor 4  
	<select name="order4">
	<?php 
	$res3= mysql_query("SELECT id_popup FROM popup where order_popup = '4'");
	$popord = mysql_fetch_assoc($res3);
	$popuporder1= $popord['id_popup'];
	$req = mysql_query('SELECT * FROM popup order by name_popup');
	while($donnees=mysql_fetch_array($req))
	{
	echo '<option ';
	if($popuporder1==$donnees['id_popup'])
	   {
	   echo 'selected="selected" ';
	   }
	echo 'value="'.$donnees['id_popup'].'">'.$donnees['name_popup'].'</option>' ;
	} ?>
	</select>

<p style="margin:30px; text-align:center"><input type="submit" value="Validate the new order" />

</form>
</center>
-->
</div>
<?
require 'footer.php';

?>