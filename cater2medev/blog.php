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
	
	'grey_bar' => 'Blog'
	);
	
require 'header.php'; 
?>

<?

require 'footer.php';

