<?

require 'lib/core.php';
require 'lib/gcalendar.php';



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

if($_SERVER['REQUEST_METHOD']=='POST')
{
if (isset($_POST['add'])) 
{
$companies = explode(',',$_POST['companies']);
foreach($companies as $company) {
if ($company == '' ) {}
else {
//$sql = "insert into calendar_version (id_company_v, version) values  ('$company','0')";
$sql = "Update calendar_version set version= '1' where id_company_v = '$company'";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	
}
}}
if  (isset($_POST['remove'])) 
{ 
$companies2 = explode(',',$_POST['companies2']);
foreach($companies2 as $company) {
if ($company == '' ) {}
else {
$sql = "Update calendar_version set version= '0' where id_company_v = '$company'";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	
}}
}
}

$select_companies = '<select onchange="document.f.companies.value=document.f.companies.value+this.value+\',\'"><option value="">-- list --</option>';
$res = mysql_query('SELECT id_company,   FROM companies, calendar_version where version=0 and id_company = id_company_v ORDER BY 2');
while($log = mysql_fetch_assoc($res)) {
	$select_companies.='<option value="'.$log['id_company'].'">'.$log['id_company'].' - '.$log['name'].'</option>';
}
$select_companies.= '<select>';

$select_companies2 = '<select onchange="document.f2.companies2.value=document.f2.companies2.value+this.value+\',\'"><option value="">-- list --</option>';
$res2 = mysql_query('SELECT id_company, name FROM companies,calendar_version  where version=1 and id_company = id_company_v  ORDER BY 2');
while($log2 = mysql_fetch_assoc($res2)) {
	$select_companies2.='<option value="'.$log2['id_company'].'">'.$log2['id_company'].' - '.$log2['name'].'</option>';
}
$select_companies2.= '<select>';

	$tmp='
	Give access to new calendar
	<form method="post" name="f">
	 Companies:  <input type="text" name="companies" placeholder="1,2,3,4,5" required /> <br />'.$select_companies.'
	
	<br />
	<input type="submit" name="add" value="Submit" />
	</form><br><br>
	Remove access to new calendar
	<form method="post" name="f2">
	 Companies:  <input type="text" name="companies2" placeholder="1,2,3,4,5" required /> <br />'.$select_companies2.'
	
	<br />
	<input type="submit" name="remove" value="Submit" />
	</form>
	
	';
	
	

	notif($tmp);







?>
