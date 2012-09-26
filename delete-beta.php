<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');
	
$id = $_GET["a"];
			
$sql = "delete from betakitchen where id_beta='".$id."'";
mysql_query($sql);


redirect('/manage-betakitchen.php');



?>
<?
$template = array(
	'title' => 'Cater2.me | Add PopUp',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Edit PopUp '=>'/dashboard/edit-popup/'),
	'menu_selected' => 'dashboard',
	
	'grey_bar' => 'Edit a PopUp'
	);

require 'header.php';
require 'footer.php';
?>