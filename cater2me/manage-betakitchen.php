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
$vnd5 = $_POST['order5'];

if ($vnd1 == $vnd2 or $vnd1 == $vnd3 or $vnd1 == $vnd4 or $vnd1 == $vnd5 or $vnd2 == $vnd3 or $vnd2 == $vnd4 or $vnd2 == $vnd5 or $vnd3 == $vnd4 or $vnd3 == $vnd5 )
{
	$message = "<font color='red'>sorry, it is not possible to have the same vendor for different order, please try again</font><br>";
}
	else {
	$sql1 = "Update betakitchen set order_beta='1' WHERE id_beta=$vnd1";
		    mysql_query($sql1);
	$sql2 = "Update betakitchen set order_beta='2' WHERE id_beta=$vnd2";
		    mysql_query($sql2);
	$sql3 = "Update betakitchen set order_beta='3' WHERE id_beta=$vnd3";
		    mysql_query($sql3);
	$sql4 = "Update betakitchen set order_beta='4' WHERE id_beta=$vnd4";
		    mysql_query($sql4);	  		
	$sql5 = "Update betakitchen set order_beta='5' WHERE id_beta=$vnd5";
		    mysql_query($sql5);	  
	$sql6 = "Update betakitchen set order_beta='0' WHERE id_beta <> '$vnd1' and id_beta <> '$vnd2' and id_beta <> '$vnd3' and id_beta <> '$vnd4' and id_beta <> '$vnd5' ";
		    mysql_query($sql6);		      
}
}

?>
<?
$template = array(
	'title' => 'Cater2.me | Manage betakitchen',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Manage betakitchen '=>'/dashboard/manage-betakitchen/'),
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
	
	'grey_bar' => 'Manage BetaKitchen'
	);

require 'header.php';


?>
<div class="grid_7" id="contact-page">
<p style="margin:30px; text-align:center"><form action="/add-beta.php"><input type="submit" value="Add a vendor" /></form></p>

<!-- <form method="post"> -->

<table id="tblUsers" class="tablesorter"> 
<thead> 
<tr> 
    <th width="30%">Vendor name</th> 
    <th width="10%">Order</th> 
	<th width="10%">Actions</th> 

</tr> 
</thead> 
<tbody> 
<?
$res = mysql_query('SELECT * FROM betakitchen order by name_beta	');
while($popup = mysql_fetch_assoc($res))
{
?>
<tr> 
 <td id="vnd_name<?=$popup['id_beta']?>"><?=$popup['name_beta']?></td>
 <td id="vnd_name<?=$popup['id_beta']?>"><?=$popup['order_beta']?></td>
    <td><a href='/edit-beta.php?a=<?=$popup['id_beta']?>'>
    &nbsp;<img title="edit vendor" id="vndrEdit<?=$popup['id_beta']?>" src="/template/images/custom/user_edit.png" />  </a>
    <a href='/delete-beta.php?a=<?=$popup['id_beta']?>' class="del" onclick="return confirm('Are you sure you want to delete <?=$popup['name_popup']?> ?');" >
      &nbsp;&nbsp;&nbsp;X</a>
    </td>
</tr> 
<? } ?>
</tbody> 
</table> 
<!--
<p style="margin:30px; text-align:center"><input type="submit" value="Validate the new order" />
</form>

-->
<center>
<form method="post">
Change the order: <br> <? echo $message ?>

	Vendor 1  
	<select name="order1">
	<?php 
	$res3= mysql_query("SELECT id_beta FROM betakitchen where order_beta = '1'");
	$popord = mysql_fetch_assoc($res3);
	$popuporder1= $popord['id_beta'];
	$req = mysql_query('SELECT * FROM betakitchen order by name_beta');
	while($donnees=mysql_fetch_array($req))
	{
	echo '<option ';
	if($popuporder1==$donnees['id_beta'])
	   {
	   echo 'selected="selected" ';
	   }
	echo 'value="'.$donnees['id_beta'].'">'.$donnees['name_beta'].'</option>' ;
	} ?>
	</select><br>

	Vendor 2
	<select name="order2">
	<?php 
	$res3= mysql_query("SELECT id_beta FROM betakitchen where order_beta = '2'");
	$popord = mysql_fetch_assoc($res3);
	$popuporder1= $popord['id_beta'];
	$req = mysql_query('SELECT * FROM betakitchen order by name_beta');
	while($donnees=mysql_fetch_array($req))
	{
	echo '<option ';
	if($popuporder1==$donnees['id_beta'])
	   {
	   echo 'selected="selected" ';
	   }
	echo 'value="'.$donnees['id_beta'].'">'.$donnees['name_beta'].'</option>' ;
	} ?>
	</select><br>

	Vendor 3  
	<select name="order3">
	<?php 
	$res3= mysql_query("SELECT id_beta FROM betakitchen where order_beta = '3'");
	$popord = mysql_fetch_assoc($res3);
	$popuporder1= $popord['id_beta'];
	$req = mysql_query('SELECT * FROM betakitchen order by name_beta');
	while($donnees=mysql_fetch_array($req))
	{
	echo '<option ';
	if($popuporder1==$donnees['id_beta'])
	   {
	   echo 'selected="selected" ';
	   }
	echo 'value="'.$donnees['id_beta'].'">'.$donnees['name_beta'].'</option>' ;
	} ?>
	</select><br>

	Vendor 4  
	<select name="order4">
	<?php 
	$res3= mysql_query("SELECT id_beta FROM betakitchen where order_beta = '4'");
	$popord = mysql_fetch_assoc($res3);
	$popuporder1= $popord['id_beta'];
	$req = mysql_query('SELECT * FROM betakitchen order by name_beta');
	while($donnees=mysql_fetch_array($req))
	{
	echo '<option ';
	if($popuporder1==$donnees['id_beta'])
	   {
	   echo 'selected="selected" ';
	   }
	echo 'value="'.$donnees['id_beta'].'">'.$donnees['name_beta'].'</option>' ;
	} ?>
	</select><br>
	
	Vendor 5  
	<select name="order5">
	<?php 
	$res3= mysql_query("SELECT id_beta FROM betakitchen where order_beta = '5'");
	$popord = mysql_fetch_assoc($res3);
	$popuporder1= $popord['id_beta'];
	$req = mysql_query('SELECT * FROM betakitchen order by name_beta');
	while($donnees=mysql_fetch_array($req))
	{
	echo '<option ';
	if($popuporder1==$donnees['id_beta'])
	   {
	   echo 'selected="selected" ';
	   }
	echo 'value="'.$donnees['id_beta'].'">'.$donnees['name_beta'].'</option>' ;
	} ?>
	</select>


<p style="margin:30px; text-align:center"><input type="submit" value="Validate the new order" />

</form>
</center>
</div>
<?
require 'footer.php';

?>