<?

require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');


if(isset($_GET['del']))
{
	mysql_query('DELETE FROM website_signup_attempts WHERE email = "'.mysql_real_escape_string(stripslashes($_GET['del'])).'"');
	redirect('/dashboard/list-signup-attempts/');
}

$template = array(
	'title' => 'Cater2.me | Website management',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Website management'=>'/dashboard/website-mgmt/'),
	'menu_selected' => 'home',
	'header_resources' => '
	',
	
	'grey_bar' => 'Signup attempts'
	);

require 'header.php';



?>
<div class="grid_10 suffix_1 prefix_1">

<table>
<tr><th></th><th> E-mail </th><th> When </th></tr>
<?
	$res=mysql_query('SELECT * FROM website_signup_attempts wsa ORDER BY wsa.when DESC');
	while($log=mysql_fetch_assoc($res)) {
	?>
	<tr><td> <a href="/dashboard/list-signup-attempts/?del=<?=urlencode($log['email'])?>">remove</a> </td><td> <?=$log['email']?> </td><td> <?=$log['when']?> </td></tr>
	<?
	}
?>
</table>

</div>

<?

require 'footer.php';
