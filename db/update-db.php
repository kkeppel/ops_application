<?

if($_SERVER['REQUEST_METHOD'] == 'POST')
{

	if(!is_uploaded_file($_FILES['upload_file']['tmp_name'])) die('Err: file failed uploading. '.$_FILES["upload_file"]["error"].' (note: server limit: '.ini_get('upload_max_filesize').').');
		
	
	if($_FILES['upload_file']['name'] != 'dump.sql') die('Err: filename has to be dump.sql');

	@unlink('./dump.sql');

	if(!move_uploaded_file($_FILES['upload_file']['tmp_name'], './dump.sql')) die('Err: could not move file');


mysql_connect('localhost','cater2me','dJ75abK2h');
mysql_select_db('cater2me');
mysql_set_charset('utf8');

mysql_query('DROP TABLE `Category`, `Paste Errors`, `Switchboard Items`, `tbl_Adjustments`, `tbl_BuyerCompanies`, `tbl_BuyerContactInfo`, `tbl_BuyerContactProfiles`, `tbl_C2MeVendorFees`, `tbl_CreditRanges`, `tbl_ExpenseCategories`, `tbl_expenses`, `tbl_LeadsPipeline`, `tbl_OrderPaymentStatus`, `tbl_OrderProposalDetails`, `tbl_OrderProposals`, `tbl_OrderRequests`, `tbl_OrderStatus`, `tbl_PayFees`, `tbl_PayoutStatus`, `tbl_ProposalStatus`, `tbl_ServingInstructions`, `tbl_VendorAbilities`, `tbl_Vendor Contact Info`, `tbl_VendorItems`, `tlb_FoodCategory`');
mysql_close();

system('find . -name "*.sql" -print | xargs sed -i \'s/CREATE DATABASE/#CREATE DATABASE/g\'');
system('find . -name "*.sql" -print | xargs sed -i \'s/USE `/#USE `/g\'');


system('mysql -ucater2me -pdJ75abK2h -hlocalhost cater2me < dump.sql');

mysql_connect('localhost','cater2me','dJ75abK2h');
mysql_select_db('cater2me');
mysql_set_charset('utf8');

if(mysql_num_rows(mysql_query('SELECT 1 FROM `tbl_Vendor Contact Info` WHERE VendorID = 1 AND VendorName = "Mondo Caffe"')))
	die('<br /><br /><br />Update performed successfully! <script type="text/javascript"> document.location.href = "new-db.php"; </script>');
else
	die('<br /><br /><br />Uhh not sure everything went ok here..');

}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
</head>
<body>

<form name="f" enctype="multipart/form-data" method="POST">
Browse for <b>dump.sql</b>: <input name="upload_file" type="file" /><br />
<input type="button" value="Upload Db" onclick="f.submit(); this.disabled=true; document.getElementById('msg').style.display='block'" />
</form>

<div id="msg" style="display:none">This may take a few minutes...</div>

<div style="width: 100%; text-align: center;"><img src="sf.jpg" alt="Dude, you are connected to the SF Dashboard!" title="Dude, you are connected to the SF Dashboard!"/></div>

</body>

</html>
