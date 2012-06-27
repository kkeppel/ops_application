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
$vendors = explode(',',$_POST['vendors']);
foreach($vendors as $vendor) {
if ($vendor == '' ) {}
else {
$vnd = mysql_query("SELECT id_vendor_pdf FROM show_pdf WHERE id_vendor_pdf = '$vendor'");
if(!mysql_num_rows($vnd)) 
{
$sql = "INSERT INTO `show_pdf`(`id_vendor_pdf`, `showp`) VALUES ('$vendor','1')";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());
}
else 
{
//$sql = "insert into calendar_version (id_company_v, version) values  ('$company','0')";
$sql = "UPDATE `show_pdf` SET `showp`= 1 WHERE `id_vendor_pdf`=$vendor
";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	
}
}} }
if  (isset($_POST['remove'])) 
{ 
$vendors2 = explode(',',$_POST['vendors2']);
foreach($vendors2 as $vendor) {
if ($vendor == '' ) {}
else {
$sql = "UPDATE `show_pdf` SET `showp`= 0 WHERE `id_vendor_pdf`=$vendor";
mysql_query($sql) or die('SQL error !'.$sql.'<br>'.mysql_error());	
}}
}
}

$select_vendors = '<select onchange="document.f.vendors.value=document.f.vendors.value+this.value+\',\'"><option value="">-- list --</option>';
$res = mysql_query('SELECT id_vendor, public_name
FROM vendors
WHERE id_vendor NOT 
IN (
SELECT id_vendor_pdf
FROM show_pdf
WHERE showp =1
) order by 2');
while($log = mysql_fetch_assoc($res)) {
	$select_vendors.='<option value="'.$log['id_vendor'].'">'.$log['id_vendor'].' - '.$log['public_name'].'</option>';
}
$select_vendors.= '<select>';

$select_vendors2 = '<select onchange="document.f2.vendors2.value=document.f2.vendors2.value+this.value+\',\'"><option value="">-- list --</option>';
$res2 = mysql_query('SELECT id_vendor, public_name FROM vendors,show_pdf where showp=1 and id_vendor= id_vendor_pdf ORDER BY 2');
while($log2 = mysql_fetch_assoc($res2)) {
	$select_vendors2.='<option value="'.$log2['id_vendor'].'">'.$log2['id_vendor'].' - '.$log2['public_name'].'</option>';
}
$select_vendors2.= '<select>';

	$tmp='
	Give access to pdf
	<form method="post" name="f">
	 Vendors:  <input type="text" name="vendors" placeholder="1,2,3,4,5" required /> <br />'.$select_vendors.'
	
	<br />
	<input type="submit" name="add" value="Submit" />
	</form><br><br>
	Remove access to pdf
	<form method="post" name="f2">
	 Vendors:  <input type="text" name="vendors2" placeholder="1,2,3,4,5" required /> <br />'.$select_vendors2.'
	
	<br />
	<input type="submit" name="remove" value="Submit" />
	</form>
	
	';
	
	

	notif($tmp);







?>
