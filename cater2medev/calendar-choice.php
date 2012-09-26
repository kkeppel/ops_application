<?


if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

$client = $curUser['client_id'];
$employee = $curUser['employee_id'];

	if ($client == '0') 
	{
	$res2 = mysql_query ( "SELECT company_id, version
	FROM employees, companies, calendar_version
	where company_id = id_company
	and id_company = id_company_v
	and id_employee = '$employee'");
	$companyarray  = mysql_fetch_assoc($res2);
	$company = $companyarray['company_id'];
	$version = $companyarray['version'];
	}
	else 
	{
	$res3 = mysql_query ( "SELECT company_id, version
	FROM clients, companies, calendar_version
	where company_id = id_company
	and id_company = id_company_v
	and id_client = '$client'");
	$companyarray  = mysql_fetch_assoc($res3);
	$company = $companyarray['company_id'];
	$version = $companyarray['version'];
	}
	
if ($version == '1')
{
	include 'Calendar-Client-new.php';
}
else 
{
	include 'Calendar-Client-old.php';
}


