<?
require '../../lib/core.php';

if(!$curUser) {
	redirect('../../login/?url='.urlencode($_SERVER['REQUEST_URI']));
}



$client = $curUser['client_id'];
$employee = $curUser['employee_id'];

	if ($client == '0') 
	{
	$res2 = mysql_query ( "SELECT company_id
	FROM employees
	WHERE id_employee = '$employee'");
	$companyarray  = mysql_fetch_assoc($res2);
	$company = $companyarray['company_id'];
	}
	else 
	{
	$res3 = mysql_query ( "SELECT company_id
	FROM clients
	WHERE id_client = '$client'");
	$companyarray  = mysql_fetch_assoc($res3);
	$company = $companyarray['company_id'];
	}

if ($company <> 107)
notif('Sorry, you are not allowed here.');

?>
<?
$template = array(
	'title' => 'Cater2.me ',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/'),
	'menu_selected' => 'dashboard',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>


	',
	
	'grey_bar' => 'Eventbrite Vendors'
	);

require '../../header.php';

?>
<iframe src="https://docs.google.com/a/cater2.me/viewer?authuser=1&srcid=0B4YggFwSf_hzeFNRVGp5dkk1U2s&pid=explorer&a=v&chrome=false&embedded=true" width="950" height="1130"></iframe>
<?
require '../../footer.php';

?>