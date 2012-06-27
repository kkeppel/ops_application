<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');
$message ='';

$template = array(
	'title' => 'Cater2.me | Calendar',
	'menu_selected' => 'dashboard',
	'breadcrumb' => array('Home'=>'/','Dashboard'=>'/dashboard/','Calendar'=>'/home/dashboard/calendar/'),
	
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>
		

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
		<script src="/template/js/custom/jquery.ui.tabs.js"></script>


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
		
		function disclaimer() {
	simpleModal("/disclaimer.php",530,340);
		}

		</script>
		
		<style type="text/css">
		#id_de_mon_tab .ui-widget-header { /* mon code spécifique */ }
		</style>
		',
	
	'grey_bar' => 'Your Catering Calendar',
	);


require 'header.php';
?>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
	</script>

<div class="demo">
<div id="tabs">
	
	<? 
	$id = $_GET["a"];
	
	$res = mysql_query("SELECT * FROM vendors where id_vendor = '$id'");
	$popup = mysql_fetch_assoc($res);
$name_popup= $popup['name'];
$name_pic =strtolower($name_popup);
$name_pic = str_replace(' ','',$name_pic);
?>
<ul>
<li><a href="#tabs-1"><?=$name_popup?></a></li>

 	</ul> 
	
	<div id="tabs-1">

<center><img width="550" height="300"  src="/template/images/popup/<? echo $name_pic?>_popup.jpg"></center>	<br><br>
<? echo nl2br($popup['VendorBioField1']);?> <br><br>
<? if ($popup['VendorBioField2']==''){ } else {echo nl2br($popup['VendorBioField2']);?> <br><br> <? }
if ($popup['VendorBioField3']==''){ } else {echo nl2br($popup['VendorBioField3']);?> <br><br> <? }
?><div class="accordion">

	<h3><a href="#">Menu (Click to expand)</a></h3>
	<div>
	Test Menu ....
	</div> <br><br>
</div>	
</div>
<!-- End div tabs -->


</div>
<!-- End demo -->
</div>

