<?
require 'lib/core.php';

$template = array(
	'title' => 'Cater2.me | Jobs',
	'menu_selected' => 'jobs',
	'breadcrumb' => array('Home'=>'/', 'Jobs'=>'/jobs/'),
	'meta_name' => 'We are always looking for new talents to join our team and help us offer top quality food to offices',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>
		

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
		<script src="/template/js/custom/jquery.ui.tabs.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>

		<script>
		$(function() {
			$( ".accordion" ).accordion({
				autoHeight: false,
				navigation: true,
				collapsible: true,
				active: false
			});
		});

		</script>
	',

	'grey_bar' => 'Cater2.me is hiring!',
	'slider_open' => true
	);

require 'header.php';

$res = mysql_query('SELECT label, value FROM website_editable_areas WHERE label LIKE "jobs"');
$area = mysql_fetch_assoc($res);
$res3 = mysql_query('SELECT label, value FROM website_editable_areas WHERE label LIKE "jobs2"');
$area3 = mysql_fetch_assoc($res3);

echo $area['value'];

$res2 = mysql_query('SELECT title, description FROM website_jobs');
$area2 = mysql_fetch_assoc($res);

while($area2 = mysql_fetch_assoc($res2)) { ?>
<style type="text/css">
.ui-widget-header {
		 		border: 0px ;
}
.ui-widget-header a {
		 		border: 0px ;
		 		
}
.ui-widget-content{
		 		border: 0px solid;
		 		color: #585858;
		 		background-color: White;
		 		font-size: 12px;	
		 					}
#post-content-wrap a {
    background-color: White;
	border: none;    
}


</style> 

<div class="accordion">
	<h3 style="border:0px;"><a href="#"><?=$area2['title']; ?> (Click to expand)</a></h3>
	<div><? echo $area2['description']; ?>
	</div> 
</div>
</p>
<?
}
echo $area3['value'];
?>
<?
require 'footer.php';
