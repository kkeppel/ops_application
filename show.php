<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.'); 

	if($_SERVER['REQUEST_METHOD']=='POST')
	{
	$order = $_POST['order'];
	echo $order;
	}

?>
<?
$template = array(
	'title' => 'Cater2.me | Manage betakitchen',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Signup Information '=>'/dashboard/signup_info/'),
	'menu_selected' => 'dashboard',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
	
		
		<style>
		
		table {
		border:0px;
		}
		td{
		vertical-align:middle;
		border:0px;}
		</style>
	',
	
	'grey_bar' => 'Show orders'
	);

require 'header.php';
?>
<form method="post">
<input type="text" name="order"/>
<input type="submit"  name = "Submit"  value="Submit"  />

</form>

<? 
require 'footer.php';

?>