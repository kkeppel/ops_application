<script type="text/javascript">
var curstep=0;
var maxsteps=28;
</script><? flush(); ?>
<div style="text-align:center;margin:50px;font-family:Arial">Processing... Do not navigate away.</div>
<div id="perc" style="text-align:center;margin:50px;font-family:Arial">Initializing...</div>
<br /><br /><br /><br />

<?

mysql_connect('localhost','cater2me','dJ75abK2h') or die(mysql_error());





mysql_select_db('cater2medev') or die(mysql_error());
mysql_query('TRUNCATE `catering_extra`');
mysql_query('TRUNCATE `catering_extra_labels`;');
mysql_query('TRUNCATE `clients`;');
mysql_query('TRUNCATE `clients_si`;');
mysql_query('TRUNCATE `client_profiles`;');
mysql_query('TRUNCATE `companies`;');
mysql_query('TRUNCATE `food_categories`;');
mysql_query('TRUNCATE `meal_types`;');
mysql_query('TRUNCATE `order_adjustments`;');
mysql_query('TRUNCATE `order_adjustment_types`;');
mysql_query('TRUNCATE `order_proposals`;');
mysql_query('TRUNCATE `order_proposals_si`;');
mysql_query('TRUNCATE `order_proposal_items`;');
mysql_query('TRUNCATE `order_requests`;');
mysql_query('TRUNCATE `order_requests_si`;');
mysql_query('TRUNCATE `order_status`;');
mysql_query('TRUNCATE `payment_methods`;');
mysql_query('TRUNCATE `payment_status`;');
mysql_query('TRUNCATE `payout_status`;');
mysql_query('TRUNCATE `printed_menus`;');
mysql_query('TRUNCATE `serving_instructions`;');
mysql_query('TRUNCATE `tip_status`;');
//mysql_query('TRUNCATE `users`;');
mysql_query('TRUNCATE `vendors`;');
mysql_query('TRUNCATE `vendor_fees`;');
mysql_query('TRUNCATE `vendor_items`;');
mysql_query('TRUNCATE `referrals`;');
mysql_query('TRUNCATE `quote`;');
mysql_query('TRUNCATE `SubType`;');
mysql_query('TRUNCATE `Type`;');


//mysql_query('TRUNCATE `employees`;');
//mysql_query('TRUNCATE `calendars`;');

#mysql_query('TRUNCATE `order_feedback`;');
#mysql_query('TRUNCATE TABLE `order_feedback_items`;');


$now=date('Y-m-d H:i:s');

//staff
/*
mysql_query('INSERT INTO users
(username, first_name, last_name, email, password, staff, created)
VALUES
("Etienne","Etienne","Florit","etienne@cater2.me","fc8f4e2cdbd2d68cb73847eef7a97232",1,"'.$now.'"),
("Zach","Zach","Yungst","zachary@cater2.me","c08f32cde4729b43d9052804f875efa7",1,"'.$now.'"),
("Alex","Alex","Lorton","alex@cater2.me","c08f32cde4729b43d9052804f875efa7",1,"'.$now.'"),
("Mark","Mark","Chaitin","mark@cater2.me","c08f32cde4729b43d9052804f875efa7",1,"'.$now.'")
');
*/

/*
not sure why about the following:

mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_BuyerContactInfo` ORDER BY BuyerID');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'UPDATE users SET email = "'.mysql_real_escape_string($log['EmailAddress']).'" WHERE client_id = '.$log['BuyerID'].'
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}
*/



?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?



$vendors = array();

mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT VendorID, VendorName FROM `tbl_Vendor Contact Info`');

while($log = mysql_fetch_assoc($res))
{
	$vendors[strtolower($log['VendorName'])] = $log['VendorID'];
}

?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?


//
mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_Vendor Contact Info` ORDER BY VendorID');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());
$now = date('Y-m-d H:i:s');

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO vendors
	(id_vendor, name, public_name, tagline, website, address, city, zip, state, country, max_order_size, delivery_start, delivery_end, lead_time_needed, delivery_area, delivery_notes, deactivated, VendorBioField1, VendorBioField2, VendorBioField3, FoodGeo, vendor_type )
	VALUES
	('.$log['VendorID'].', "'.mysql_real_escape_string($log['VendorName']).'", "'.mysql_real_escape_string($log['VendorShowName']).'", "'.mysql_real_escape_string($log['Tagline']).'", "'.mysql_real_escape_string($log['Website']).'", "'.mysql_real_escape_string($log['VendorAddress']).'", "'.mysql_real_escape_string($log['City']).'", "'.mysql_real_escape_string($log['PostalCode']).'", "'.mysql_real_escape_string($log['StateOrProvince']).'", "'.mysql_real_escape_string($log['Country/Region']).'", '.(int)$log['Max Order Size'].', "'.substr($log['Delivery start'], -8).'", "'.substr($log['Delivery end'], -8).'", '.(int)$log['Lead-time Needed (Days)'].', "'.mysql_real_escape_string($log['Delivery Area (Blocks)']).'", "'.mysql_real_escape_string($log['Delivery Notes']).'", '.$log['Old'].',"'.mysql_real_escape_string(trim($log['VendorBioField1'])).'","'.mysql_real_escape_string(trim($log['VendorBioField2'])).'","'.mysql_real_escape_string(trim($log['VendorBioField3'])).'","'.mysql_real_escape_string(trim($log['FoodGeo'])).'","'.$log['VendorType'].'");
	
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
	
	
	
	if(!mysql_num_rows(mysql_query('SELECT 1 FROM tmp_vendors WHERE vendor_id = '.$log['VendorID']))) {
	
	$sql = 'INSERT INTO tmp_vendors
	(vendor_id, opt_out_confirm_notif, opt_out_weekly_notif, opt_out_sms_notif)
	VALUES
	('.$log['VendorID'].', 0, 0, 0);
	
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
	
	}
	
	
	
	if(!mysql_num_rows(mysql_query('SELECT 1 FROM users WHERE email = "'.$log['EmailAddress'].'"'))) {
	
	$sql = 'INSERT INTO users
	(username, password, email, email2, vendor_id, first_name, last_name, title, phone_number, personal_number, extension, fax_number, created, notes, deactivated)
	VALUES
	("'.mysql_real_escape_string($log['EmailAddress']).'", "'.md5($log['VendorID']).'", "'.mysql_real_escape_string($log['EmailAddress']).'", "'.mysql_real_escape_string($log['EmailAddress2']).'", '.(int)$log['VendorID'].', "'.mysql_real_escape_string($log['ContactFirstName']).'", "'.mysql_real_escape_string($log['ContactLastName']).'", "'.mysql_real_escape_string($log['ContactTitle']).'", "'.mysql_real_escape_string($log['PhoneNumber']).'", "'.mysql_real_escape_string($log['PersonalNumber']).'", "'.mysql_real_escape_string($log['Extension']).'", "'.mysql_real_escape_string($log['FaxNumber']).'", "'.$now.'", "'.mysql_real_escape_string($log['Notes']).'",'.(int)$log['Old'].');
	
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
	
	}
}


/*
mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `accounts`');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'UPDATE users SET `password` = "'.$log['pwd'].'", nb_visits = '.$log['NbLogins'].' WHERE vendor_id = '.$log['id'].';
	
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}
*/

?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?



mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_BuyerCompanies` ORDER BY BuyerID');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());


while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO companies
	(id_company, name, address, cross_streets, city, zip, state, country, website, notes, fee, invoice_first_name, invoice_last_name, invoice_email, default_tip, delivery_difficulty, special_delivery)
	VALUES
	('.$log['BuyerID'].', "'.mysql_real_escape_string($log['CompanyName']).'", "'.mysql_real_escape_string($log['BuyerAddress']).'", "'.mysql_real_escape_string($log['CrossStreets']).'", "'.mysql_real_escape_string($log['City']).'", "'.mysql_real_escape_string($log['PostalCode']).'", "'.mysql_real_escape_string($log['StateOrProvince']).'", "'.mysql_real_escape_string($log['Country/Region']).'", "'.mysql_real_escape_string($log['Website']).'", "'.mysql_real_escape_string($log['Notes']).'", "'.mysql_real_escape_string($log['Fee']).'", "'.mysql_real_escape_string($log['InvoiceContactFirst']).'", "'.mysql_real_escape_string($log['InvoiceContactLast']).'", "'.mysql_real_escape_string($log['InvoiceContactEmail']).'", "'.mysql_real_escape_string($log['DefaultTip']).'", "'.mysql_real_escape_string($log['DeliveryDifficulty']).'","'.$log['SpecialDelDiff'].'");
	
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}


?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?


mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_BuyerContactInfo` ORDER BY BuyerContactID');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO clients
	(id_client, company_id, payment_method, floor, delivery_instructions, delivery_area)
	VALUES
	('.$log['BuyerContactID'].', '.$log['BuyerID'].', 9999, "'.mysql_real_escape_string($log['Floor']).'", "'.mysql_real_escape_string($log['DeliveryInstructions']).'", "'.mysql_real_escape_string($log['DeliveryArea']).'");
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
	
	if(!mysql_num_rows(mysql_query('SELECT 1 FROM users WHERE email = "'.$log['EmailAddress'].'"'))) {
	$sql = 'INSERT INTO users (username, password, email, email2, first_name, last_name, title, client_id, phone_number, personal_number, extension, fax_number, notes, created)
	VALUES
	("'.mysql_real_escape_string($log['EmailAddress']).'", "'.md5($log['BuyerContactID']).'", "'.mysql_real_escape_string($log['EmailAddress']).'", "'.mysql_real_escape_string($log['EmailAddress2']).'", "'.mysql_real_escape_string($log['ContactFirstName']).'", "'.mysql_real_escape_string($log['ContactLastName']).'", "'.mysql_real_escape_string($log['ContactTitle']).'", '.$log['BuyerContactID'].', "'.mysql_real_escape_string($log['PhoneNumber']).'", "'.mysql_real_escape_string($log['PersonalNumber']).'", "'.mysql_real_escape_string($log['Extension']).'", "'.mysql_real_escape_string($log['FaxNumber']).'", "'.mysql_real_escape_string($log['Notes']).'", "'.$now.'")
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
	}
}


//clients
/*
mysql_query('UPDATE users SET username = "ngmoco", password="475brannan" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 79);');
mysql_query('UPDATE users SET username = "Weatherbill", password="insure" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 91);');
mysql_query('UPDATE users SET username = "Plum District", password="familydeal" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 68);');
mysql_query('UPDATE users SET username = "Klout", password="stillman" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 65);');
mysql_query('UPDATE users SET username = "Practice Fusion", password="onlineEMR" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 94);');
mysql_query('UPDATE users SET username = "Meraki", password="alabama660" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 76);');
mysql_query('UPDATE users SET username = "Quantcast", password="quant" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 97);');
mysql_query('UPDATE users SET username = "TPG", password="splitevenly" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 4);');
mysql_query('UPDATE users SET username = "Hearsay", password="bsocial" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 89);');
mysql_query('UPDATE users SET username = "Kontagent", password="metrics" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 74);');
mysql_query('UPDATE users SET username = "Tagged", password="socialnet" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 32);');
mysql_query('UPDATE users SET username = "Posterous", password="shareit" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 100);');
mysql_query('UPDATE users SET username = "Eventbrite", password="easyevents" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 107);');
mysql_query('UPDATE users SET username = "iloverewards", password="incentives" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 116);');
mysql_query('UPDATE users SET username = "Ooyala", password="videotech" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 102);');
mysql_query('UPDATE users SET username = "Heroku", password="cloudapp" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 12);');
mysql_query('UPDATE users SET username = "Monkey Inferno", password="codemonkey" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 16);');
mysql_query('UPDATE users SET username = "Topsy", password="real-time" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 126);');
mysql_query('UPDATE users SET username = "3VR", password="security" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 75);');
mysql_query('UPDATE users SET username = "Adbrite", password="adexchange" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 77);');
mysql_query('UPDATE users SET username = "Adku", password="beale300" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 134);');
mysql_query('UPDATE users SET username = "BAR Architects", password="build" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 28);');
mysql_query('UPDATE users SET username = "Dropbox", password="storage" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 13);');
mysql_query('UPDATE users SET username = "Gametheory", password="leads" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 133);');
mysql_query('UPDATE users SET username = "Inigral", password="schoolsapp" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 130);');
mysql_query('UPDATE users SET username = "Metamoki", password="mobwars" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 129);');
mysql_query('UPDATE users SET username = "Mindjet", password="vizualize" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 33);');
mysql_query('UPDATE users SET username = "Splunk", password="data" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 82);');

mysql_query('UPDATE users SET username = "Heyzap", password="mobilegames" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 135);');
mysql_query('UPDATE users SET username = "Twilio", password="cloudcomm" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 25);');
mysql_query('UPDATE users SET username = "Kontera", password="textad" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 131);');
mysql_query('UPDATE users SET username = "TinyCo", password="tinygames" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 78);');
mysql_query('UPDATE users SET username = "Hipmunk", password="traveltime" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 138);');
mysql_query('UPDATE users SET username = "BranchOut", password="careernet" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 140);');
mysql_query('UPDATE users SET username = "NEA", password="venture" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 24);');

mysql_query('UPDATE users SET username = "TPG Growth", password="grow" WHERE client_id IN (SELECT id_client FROM clients WHERE company_id = 6);');
*/



/*
mysql_query('INSERT INTO calendars SET gcal_id = "tepjt5u18k7qbs5g9tjt60l4jg", company_id = 79');
mysql_query('INSERT INTO calendars SET gcal_id = "02je9vb84bsqeogejtgee3anss", company_id = 91');
mysql_query('INSERT INTO calendars SET gcal_id = "tc8c4ltddi92o10r4ul9sbvbno", company_id = 68');
mysql_query('INSERT INTO calendars SET gcal_id = "qgf31ifncdvt4ouas843qbpk18", company_id = 65');
mysql_query('INSERT INTO calendars SET gcal_id = "hi3nqmj3774m1ubt72pe1p9tl0", company_id = 94');
mysql_query('INSERT INTO calendars SET gcal_id = "4tnba02atl5jqq3jq73fak0bk4", company_id = 76');
mysql_query('INSERT INTO calendars SET gcal_id = "00ucqtho7kd3a3vkv2rq2sc024", company_id = 97');
mysql_query('INSERT INTO calendars SET gcal_id = "v6j3pe9i58vfu3kkh7nc84n76k", company_id = 4');
mysql_query('INSERT INTO calendars SET gcal_id = "dvpbvbd6jlubnlii4j2n4v07kc", company_id = 89');
mysql_query('INSERT INTO calendars SET gcal_id = "5ql3sa1ondljfk9uo4kjs51cdc", company_id = 74');
mysql_query('INSERT INTO calendars SET gcal_id = "4c4vlqtnmma0cte5trleb773ho", company_id = 32');
mysql_query('INSERT INTO calendars SET gcal_id = "uu2f48sss5naskjr48u10lv82k", company_id = 100');
mysql_query('INSERT INTO calendars SET gcal_id = "6k5g6djje1j2b66cn4n7aknd74", company_id = 107');
mysql_query('INSERT INTO calendars SET gcal_id = "6a4b8c5etee2iejm58tloq51m0", company_id = 116');
mysql_query('INSERT INTO calendars SET gcal_id = "meje4d62u1ftkredd25s37bg6o", company_id = 102');
mysql_query('INSERT INTO calendars SET gcal_id = "v165o6n74mg67hkme064p93aeg", company_id = 12');
mysql_query('INSERT INTO calendars SET gcal_id = "4jj722gd02lb4d1vstvuku65dk", company_id = 16');
mysql_query('INSERT INTO calendars SET gcal_id = "lecjnlvuddo5c2f23q4emigq8o", company_id = 126');
mysql_query('INSERT INTO calendars SET gcal_id = "26s06d0b2chjj1a47qj98fcics", company_id = 75');
mysql_query('INSERT INTO calendars SET gcal_id = "ea94qq16s6o7gbk6r1dsuvi3dg", company_id = 77');
mysql_query('INSERT INTO calendars SET gcal_id = "po7itc6u9s1r61nrtoap7pimm4", company_id = 134');
mysql_query('INSERT INTO calendars SET gcal_id = "pa181moiehv1vajjmp4r0o35lk", company_id = 28');
mysql_query('INSERT INTO calendars SET gcal_id = "lhvvlg048ddqa7r18r1utb580g", company_id = 13');
mysql_query('INSERT INTO calendars SET gcal_id = "pls0t6l9bs79n3co1lob7e94bk", company_id = 133');
mysql_query('INSERT INTO calendars SET gcal_id = "2cisg21rqfkgfutc01q7ld1bm8", company_id = 130');
mysql_query('INSERT INTO calendars SET gcal_id = "0seiedtn5s6v31enj0lm5q95k0", company_id = 129');
mysql_query('INSERT INTO calendars SET gcal_id = "o3cas4u33sdkafjagdqdj2khb4", company_id = 33');
mysql_query('INSERT INTO calendars SET gcal_id = "mv8l33apu696eok6ist25jdo8o", company_id = 82');

mysql_query('INSERT INTO calendars SET gcal_id = "hm8c6icnqf4bum3e13cg43qhf0", company_id = 135');
mysql_query('INSERT INTO calendars SET gcal_id = "jbc3iah37m3vljs05m83lq65pc", company_id = 25');
mysql_query('INSERT INTO calendars SET gcal_id = "985ucjpe6mt95r15r15qsj1ifc", company_id = 131');
mysql_query('INSERT INTO calendars SET gcal_id = "fgkt43eu04g7pong2bbeusnfb4", company_id = 78');
mysql_query('INSERT INTO calendars SET gcal_id = "sa4bnnh1d3hb6kf78umo7sm510", company_id = 138');
mysql_query('INSERT INTO calendars SET gcal_id = "h8kojbqthvitftcgao3v0fvp7g", company_id = 140');
mysql_query('INSERT INTO calendars SET gcal_id = "pl03pbg1vog8uht4n6mfka7mn0", company_id = 24');

mysql_query('INSERT INTO calendars SET gcal_id = "725t8srv34on4c9km0gk0ndq4o", company_id = 6');
*/
//mysql_query('UPDATE users SET `password`=md5(`password`) WHERE CHAR_LENGTH(`password`) <> 32');






?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?



mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_OrderRequests` ORDER BY OrderID');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());


while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO order_requests
	(id_order, order_payment_status_id, order_status_id, payment_method_id, client_id, meal_type_id, order_created, order_for, employees, max_price, notes, client_profile_id, payout_status_id, tip_status_id, tax_exempt, fc2me_fee, tip, last_updated, last_updates)
	VALUES
	('.$log['OrderID'].', 9999, 9999, 9999, '.$log['BuyerContactID'].', 9999, "'.$log['OrderPlaceDate'].'", "'.substr($log['OrderForDate'],0,10).' '.substr($log['OrderForTime'], -8).'", '.(int)$log['Employees'].', '.(int)$log['MaxPerPerson'].', "'.mysql_real_escape_string($log['Notes']).'", '.(int)$log['SelectedProfile'].', 9999, 9999, 9999, 9999, 9999, 9999, 9999);
	
	';
	
	mysql_query($sql) or die($sql.':'.mysql_error());
}


?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?



mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_BuyerContactProfiles` ORDER BY ProfileNumber');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO client_profiles
	(id_profile, client_id, name, employees, max_price, time_served, day_served, notes, delivery_address, delivery_cross_streets, delivery_city, delivery_zip, delivery_state, delivery_instructions, delivery_area, profile_delivery_diff, profile_special_delivery)
	VALUES
	('.$log['ProfileNumber'].', '.$log['BuyerContactID'].', "'.mysql_real_escape_string($log['Profile Name']).'", "'.$log['Employees'].'", "'.$log['MaxPrice'].'", "'.substr($log['TimeServed'], -8).'", '.(int)$log['DayServed'].', "'.mysql_real_escape_string($log['ProfileNotes']).'", "'.mysql_real_escape_string($log['DeliveryAddress']).'", "'.mysql_real_escape_string($log['DeliveryCrossStreets']).'", "'.mysql_real_escape_string($log['DeliveryCity']).'", "'.mysql_real_escape_string($log['DeliveryPostalCode']).'", "'.mysql_real_escape_string($log['DeliveryStateOrProvince']).'", "'.mysql_real_escape_string($log['ProfileDeliveryInstructions']).'", "'.mysql_real_escape_string($log['ProfileDeliveryArea']).'", "'.mysql_real_escape_string($log['ProfileDeliveryDifficulty']).'", "'.$log['ProfileSpecialDelDiff'].'");
	
	';
	
	mysql_query($sql) or die($sql.':'.mysql_error());
}


?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?


mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT ServingInstruction FROM `tbl_ServingInstructions` GROUP BY ServingInstruction');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO serving_instructions
	(label)
	VALUES
	("'.mysql_real_escape_string(ucfirst($log['ServingInstruction'])).'");
	
	';
	
	mysql_query($sql) or die($sql.':'.mysql_error());
}


?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?



mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tlb_FoodCategory` ORDER BY FCOrder');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO food_categories
	(label, list_order)
	VALUES
	("'.mysql_real_escape_string($log['FoodCategory']).'", '.$log['FCOrder'].');
	
	';
	
	mysql_query($sql) or die($sql.':'.mysql_error());
}



?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?


mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT CategoryName FROM `tbl_OrderRequests` GROUP BY CategoryName');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO meal_types
	(label)
	VALUES
	("'.mysql_real_escape_string($log['CategoryName']).'");
	
	';
	
	mysql_query($sql) or die($sql.':'.mysql_error());
}


?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?


mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_OrderProposals` GROUP BY ProposalNumber');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO order_proposals
	(id_order_proposal, order_id, vendor_id, service_fee, selected)
	VALUES
	('.$log['ProposalNumber'].', '.$log['OrderID'].', '.$vendors[strtolower($log['VendorName'])].', "'.$log['ServiceFee'].'", '.$log['Selected'].');
	
	';
	
	mysql_query($sql) or die($sql.':'.mysql_error());
}


?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?


mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT OrderStatus FROM `tbl_OrderRequests` GROUP BY OrderStatus');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO order_status
	(label)
	VALUES
	("'.mysql_real_escape_string($log['OrderStatus']).'");
	
	';
	
	mysql_query($sql) or die($sql.':'.mysql_error());
}


?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?


mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT PayoutStatus FROM `tbl_OrderProposals` GROUP BY PayoutStatus');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO payout_status
	(label)
	VALUES
	("'.mysql_real_escape_string($log['PayoutStatus']).'");
	
	';
	
	mysql_query($sql) or die($sql.':'.mysql_error());
}


?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?



mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT OrderPaymentStatus FROM `tbl_OrderRequests` GROUP BY OrderPaymentStatus');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO payment_status
	(label)
	VALUES
	("'.mysql_real_escape_string($log['OrderPaymentStatus']).'");
	
	';
	
	mysql_query($sql) or die($sql.':'.mysql_error());
}



?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?


$sql = 'INSERT INTO order_adjustment_types (label) VALUES ("Vendor to Client"), ("C2me to Client"), ("C2me to Vendor");';
mysql_query($sql) or die($sql.':'.mysql_error());


$sql = 'INSERT INTO catering_extra_labels (label, flag) VALUES ("Beverages",1),("Utensils",1),("Paper Ware",1),("Folding Tables",1),("Food allergies",1),("Organic",1),("Low Carb",1),("Chafing Dishes",1),("Vegetarian (#)",0),("Vegans (#)",0),("Kosher (#)",0),("Gluten Free (#)",0),("Serving Trays",1),("Table Clothes",1),("Other",1),("Individuals",1);';
mysql_query($sql) or die($sql.':'.mysql_error());



?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?



mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_PayFees`');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO payment_methods
	(label, fee)
	VALUES
	("'.mysql_real_escape_string($log['PayMethod']).'", '.$log['PayFee'].');
	
	';
	
	mysql_query($sql) or die($sql.':'.mysql_error());
}
//mysql_query('INSERT INTO payment_methods (label) VALUES ("TBD")') or die(__LINE__.':'.mysql_error());



?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?




mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT PrintedMenuCategory FROM `tbl_VendorItems` GROUP BY PrintedMenuCategory');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO printed_menus
	(label)
	VALUES
	("'.mysql_real_escape_string($log['PrintedMenuCategory']).'");
	
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}




?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?




$printed_menus = array();

$res = mysql_query('SELECT id_printed_menu, label FROM `printed_menus`');

while($log = mysql_fetch_assoc($res))
{
	$printed_menus[$log['label']] = $log['id_printed_menu'];
}



$food_categories = array();

$res = mysql_query('SELECT id_food_category, label FROM `food_categories`');

while($log = mysql_fetch_assoc($res))
{
	$food_categories[strtolower(trim($log['label']))] = $log['id_food_category'];
}



mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_VendorItems` ORDER BY ItemID');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO vendor_items
	(id_vendor_item, vendor_id, name, menu_name, description, food_category_id, hot, vegetarian, gluten_safe, dairy, dairy_safe, nut_safe, egg_safe, soy_safe, contains_honey, contains_shellfish, contains_alcohol, number_of_servings, unit_price, notes, individual_menu, taxed, deactivated, printed_menu_id)
	VALUES
	('.$log['ItemID'].', '.$vendors[strtolower($log['VendorName'])].', "'.mysql_real_escape_string($log['ItemName']).'", "'.mysql_real_escape_string($log['MenuName']).'", "'.mysql_real_escape_string($log['Item Description']).'", '.(int)$food_categories[strtolower(trim($log['FoodCategory']))].', '.$log['Hot'].', '.$log['Vegetarian'].','.$log['Gluten Safe'].', '.$log['Dairy'].','.$log['Dairy Safe'].','.$log['Nut Safe'].','.$log['Egg Safe'].','.$log['Soy Safe'].','.$log['Contains Honey'].','.$log['Contains Shellfish'].','.$log['Contains Alcohol'].', '.(int)$log['NumberofServings'].', '.$log['UnitPrice'].', "'.mysql_real_escape_string($log['Notes']).'", '.$log['IndividualMenus'].', '.$log['Taxed'].', '.$log['Old?'].', '.(int)$printed_menus[$log['PrintedMenuCategory']].');
	
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}



?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?





$SIs = array();

mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());
$res = mysql_query('SELECT id_serving_instruction, label FROM `serving_instructions`');

while($log = mysql_fetch_assoc($res))
{
	$SIs[$log['label']] = $log['id_serving_instruction'];
}


mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT OrderID, ServingInstructions, ServingInstructions2, ServingInstructions3, ServingInstructions4, ServingInstructions5, ServingInstructions6 FROM `tbl_OrderRequests` ORDER BY OrderID');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$tmp=$SIs[ucfirst($log['ServingInstructions'])];
	if($tmp>1) // 1 == NULL in table entry
	{
		$sql = 'REPLACE INTO order_requests_si
		(order_id, serving_instruction_id)
		VALUES
		('.$log['OrderID'].', '.$tmp.');';
		
		mysql_query($sql) or die($sql.':'.mysql_error());
		
		
		mysql_select_db('cater2me') or die(mysql_error());
		mysql_set_charset('latin1') or die(mysql_error());
		$res2 = mysql_query('SELECT ProposalNumber, SI1 FROM `tbl_OrderProposals` WHERE OrderID = '.$log['OrderID']);
		mysql_select_db('cater2medev') or die(mysql_error());
		mysql_set_charset('utf8') or die(mysql_error());
		while($log2 = mysql_fetch_row($res2))
		{
			if($log2[1])
			{
				$sql = 'REPLACE INTO order_proposals_si
				(order_proposal_id, serving_instruction_id)
				VALUES
				('.$log2[0].', '.$tmp.');';
		
				mysql_query($sql) or die($sql.':'.mysql_error());
			}
		}
	}
	
	$tmp=$SIs[ucfirst($log['ServingInstructions2'])];
	if($tmp>1)
	{
		$sql = 'REPLACE INTO order_requests_si
		(order_id, serving_instruction_id)
		VALUES
		('.$log['OrderID'].', '.$tmp.');';
		
		mysql_query($sql) or die($sql.':'.mysql_error());
		
		
		mysql_select_db('cater2me') or die(mysql_error());
		mysql_set_charset('latin1') or die(mysql_error());
		$res2 = mysql_query('SELECT ProposalNumber, SI2 FROM `tbl_OrderProposals` WHERE OrderID = '.$log['OrderID']);
		mysql_select_db('cater2medev') or die(mysql_error());
		mysql_set_charset('utf8') or die(mysql_error());
		while($log2 = mysql_fetch_row($res2))
		{
			if($log2[1])
			{
				$sql = 'REPLACE INTO order_proposals_si
				(order_proposal_id, serving_instruction_id)
				VALUES
				('.$log2[0].', '.$tmp.');';
		
				mysql_query($sql) or die($sql.':'.mysql_error());
			}
		}
	}
	
	$tmp=$SIs[ucfirst($log['ServingInstructions3'])];
	if($tmp>1)
	{
		$sql = 'REPLACE INTO order_requests_si
		(order_id, serving_instruction_id)
		VALUES
		('.$log['OrderID'].', '.$tmp.');';
		
		mysql_query($sql) or die($sql.':'.mysql_error());
		
		
		mysql_select_db('cater2me') or die(mysql_error());
		mysql_set_charset('latin1') or die(mysql_error());
		$res2 = mysql_query('SELECT ProposalNumber, SI3 FROM `tbl_OrderProposals` WHERE OrderID = '.$log['OrderID']);
		mysql_select_db('cater2medev') or die(mysql_error());
		mysql_set_charset('utf8') or die(mysql_error());
		while($log2 = mysql_fetch_row($res2))
		{
			if($log2[1])
			{
				$sql = 'REPLACE INTO order_proposals_si
				(order_proposal_id, serving_instruction_id)
				VALUES
				('.$log2[0].', '.$tmp.');';
		
				mysql_query($sql) or die($sql.':'.mysql_error());
			}
		}
	}
	
	$tmp=$SIs[ucfirst($log['ServingInstructions4'])];
	if($tmp>1)
	{
		$sql = 'REPLACE INTO order_requests_si
		(order_id, serving_instruction_id)
		VALUES
		('.$log['OrderID'].', '.$tmp.');';
		
		mysql_query($sql) or die($sql.':'.mysql_error());
		
		
		mysql_select_db('cater2me') or die(mysql_error());
		mysql_set_charset('latin1') or die(mysql_error());
		$res2 = mysql_query('SELECT ProposalNumber, SI4 FROM `tbl_OrderProposals` WHERE OrderID = '.$log['OrderID']);
		mysql_select_db('cater2medev') or die(mysql_error());
		mysql_set_charset('utf8') or die(mysql_error());
		while($log2 = mysql_fetch_row($res2))
		{
			if($log2[1])
			{
				$sql = 'REPLACE INTO order_proposals_si
				(order_proposal_id, serving_instruction_id)
				VALUES
				('.$log2[0].', '.$tmp.');';
		
				mysql_query($sql) or die($sql.':'.mysql_error());
			}
		}
	}
	
	$tmp=$SIs[ucfirst($log['ServingInstructions5'])];
	if($tmp>1)
	{
		$sql = 'REPLACE INTO order_requests_si
		(order_id, serving_instruction_id)
		VALUES
		('.$log['OrderID'].', '.$tmp.');';
		
		mysql_query($sql) or die($sql.':'.mysql_error());
		
		
		mysql_select_db('cater2me') or die(mysql_error());
		mysql_set_charset('latin1') or die(mysql_error());
		$res2 = mysql_query('SELECT ProposalNumber, SI5 FROM `tbl_OrderProposals` WHERE OrderID = '.$log['OrderID']);
		mysql_select_db('cater2medev') or die(mysql_error());
		mysql_set_charset('utf8') or die(mysql_error());
		while($log2 = mysql_fetch_row($res2))
		{
			if($log2[1])
			{
				$sql = 'REPLACE INTO order_proposals_si
				(order_proposal_id, serving_instruction_id)
				VALUES
				('.$log2[0].', '.$tmp.');';
		
				mysql_query($sql) or die($sql.':'.mysql_error());
			}
		}
	}
	
	$tmp=$SIs[ucfirst($log['ServingInstructions6'])];
	if($tmp>1)
	{
		$sql = 'REPLACE INTO order_requests_si
		(order_id, serving_instruction_id)
		VALUES
		('.$log['OrderID'].', '.$tmp.');';
		
		mysql_query($sql) or die($sql.':'.mysql_error());
		
		
		mysql_select_db('cater2me') or die(mysql_error());
		mysql_set_charset('latin1') or die(mysql_error());
		$res2 = mysql_query('SELECT ProposalNumber, SI6 FROM `tbl_OrderProposals` WHERE OrderID = '.$log['OrderID']);
		mysql_select_db('cater2medev') or die(mysql_error());
		mysql_set_charset('utf8') or die(mysql_error());
		while($log2 = mysql_fetch_row($res2))
		{
			if($log2[1])
			{
				$sql = 'REPLACE INTO order_proposals_si
				(order_proposal_id, serving_instruction_id)
				VALUES
				('.$log2[0].', '.$tmp.');';
		
				mysql_query($sql) or die($sql.':'.mysql_error());
			}
		}
	}

}



?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?


mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT TipStatus FROM `tbl_OrderProposals` GROUP BY TipStatus');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO tip_status
	(label)
	VALUES
	("'.mysql_real_escape_string($log['TipStatus']).'");
	
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}



?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?


mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_OrderProposalDetails` ORDER BY LineNumber');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO order_proposal_items
	(id_proposal_item, order_proposal_id, vendor_item_id, quantity, fprice, ftax, notes, non_menu_notes)
	VALUES
	('.$log['LineNumber'].', '.$log['ProposalNumber'].', '.$log['ItemID'].', "'.$log['Quantity'].'", "'.$log['FPrice'].'", "'.$log['FTax'].'", "'.mysql_real_escape_string($log['Notes']).'", "'.mysql_real_escape_string($log['Non-MenuNotes']).'");
	
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}

?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?

mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_Quotes`');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO quote
	(Quote_Id, Quote_date, Quote, Author)
	VALUES
	('.$log['QuoteID'].', "'.$log['QuoteDate'].'", "'.mysql_real_escape_string($log['Quote']).'", "'.mysql_real_escape_string($log['Author']).'");
	';
	
	mysql_query($sql) or die($sql.':'.mysql_error());
}
?>

<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?

mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `new_tbl_VSubTypes`');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO SubType
	(SubType_Id, Type, Type_Id)
	VALUES
	('.$log['VSubTypeID'].', "'.$log['Type'].'", "'.mysql_real_escape_string($log['VMasTypeID']).'");
	';
	
	mysql_query($sql) or die($sql.':'.mysql_error());
}

?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?

mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `new_tbl_VMasTypes`');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO Type
	(Type_Id, Type)
	VALUES
	('.$log['VMasTypeID'].', "'.mysql_real_escape_string($log['Type']).'");
	';
	
	mysql_query($sql) or die($sql.':'.mysql_error());
}


?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?




/*
mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `feedback_orders`');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$res2 = mysql_query('SELECT order_id, id_user FROM order_proposals o_p, order_requests o_r, users u WHERE order_id = id_order AND u.client_id = o_r.client_id AND main_contact AND id_order_proposal = '.$log['ProposalID']) or die(__LINE__.':'.mysql_error());
	$log2 = mysql_fetch_row($res2);
	
	$sql = 'REPLACE INTO order_feedback
	(order_id, user_id, food_rating, portioning, feedback_private, feedback_public)
	VALUES
	('.$log2[0].', '.$log2[1].', '.$log['FoodRating'].', '.$log['Portioning'].', "'.mysql_real_escape_string($log['FeedbackPrivate']).'", "'.mysql_real_escape_string($log['FeedbackPublic']).'");
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}



mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `feedback_order_items`');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$res2 = mysql_query('SELECT id_user FROM order_proposals o_p, order_requests o_r, users u WHERE order_id = id_order AND u.client_id = o_r.client_id AND main_contact AND id_order_proposal = '.$log['ProposalID']);
	$log2 = mysql_fetch_row($res2);
	
	$res3 = mysql_query('SELECT id_proposal_item FROM order_proposal_items WHERE vendor_item_id = '.$log['ItemID'].' AND order_proposal_id = '.$log['ProposalID']) or die(__LINE__.':'.mysql_error());
	$log3 = mysql_fetch_row($res3);
	
	$sql = 'INSERT INTO order_feedback_items
	(item_id, user_id, food_rating, portioning)
	VALUES
	('.$log3[0].', '.$log2[0].', '.$log['FoodRating'].', '.$log['Portioning'].');
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}
*/






mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_C2MeVendorFees` ORDER BY Record');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO vendor_fees
	(vendor_id, f5_less11, f5_11_25, f5_26_50, f5_50plus, normal_less11, normal_11_25, normal_26_100, normal_101plus, pilot_pricing)
	VALUES
	('.$vendors[strtolower($log['VendorName'])].', '.$log['F5<11'].', '.$log['F511-25'].', '.$log['F526-50'].', '.$log['F550+'].', '.$log['Normal<11'].', '.$log['Normal11-25'].', '.$log['Normal26-100'].', '.$log['Normal101+'].', '.$log['PilotPricing?'].');
	
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}



?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?



mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_ServingInstructions` ORDER BY Linenumber');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$SI = $SIs[ucfirst($log['ServingInstruction'])];
	if(!$SI)
	{
		mysql_query('INSERT INTO serving_instructions (label) VALUES ("'.mysql_real_escape_string($log['ServingInstruction']).'")') or die('line '.__LINE__.':'.mysql_error());
		$SIs[ucfirst($log['ServingInstruction'])] = mysql_insert_id();
		$SI=mysql_insert_id();
	}
	
	$sql = 'INSERT INTO clients_si
	(serving_instruction_id, client_id)
	VALUES
	('.$SI.', '.$log['BuyerContactID'].');
	
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}



?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?



mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_BuyerContactProfiles` ORDER BY ProfileNumber');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO catering_extra
	(client_profile_id, extra_label_id, value)
	VALUES
	('.$log['ProfileNumber'].', 1, "'.$log['Beverages?'].'"),
	('.$log['ProfileNumber'].', 2, "'.$log['Utensils?'].'"),
	('.$log['ProfileNumber'].', 3, "'.$log['Paper Ware?'].'"),
	('.$log['ProfileNumber'].', 4, "'.$log['Food allergies?'].'"),
	('.$log['ProfileNumber'].', 5, "'.$log['Folding Tables?'].'"),
	/*('.$log['ProfileNumber'].', 6, "'.$log['Organic'].'"),
	('.$log['ProfileNumber'].', 7, "'.$log['Low Carb'].'"),
	('.$log['ProfileNumber'].', 8, "'.$log['ChafingDishes?'].'"),*/
	('.$log['ProfileNumber'].', 9, "'.$log['Vegetarians'].'"),
	('.$log['ProfileNumber'].', 10, "'.$log['Vegans'].'"),
	('.$log['ProfileNumber'].', 11, "'.$log['Kosher'].'"),
	/*('.$log['ProfileNumber'].', 12, "'.$log['Gluten Free (#)'].'")*/
	
	('.$log['ProfileNumber'].', 13, "'.$log['Serving Trays?'].'"),
	('.$log['ProfileNumber'].', 14, "'.$log['Table Clothes?'].'")
	;
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}


?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?


mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_OrderRequests` ORDER BY OrderID');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'INSERT INTO catering_extra
	(order_request_id, extra_label_id, value)
	VALUES
	('.$log['OrderID'].', 1, "'.$log['Beverages?'].'"),
	('.$log['OrderID'].', 2, "'.$log['Utensils?'].'"),
	('.$log['OrderID'].', 3, "'.$log['Paper Ware?'].'"),
	('.$log['OrderID'].', 5, "'.$log['Folding Tables?'].'"),
	('.$log['OrderID'].', 14, "'.$log['Table Clothes?'].'"),
	('.$log['OrderID'].', 4, "'.$log['Food allergies?'].'"),
	('.$log['OrderID'].', 6, "'.$log['Organic?'].'"),
	('.$log['OrderID'].', 7, "'.$log['Low carb?'].'"),
	('.$log['OrderID'].', 8, "'.$log['ChafingDishes?'].'"),
	('.$log['OrderID'].', 9, "'.$log['Vegetarians(#)?'].'"),
	('.$log['OrderID'].', 10, "'.$log['Vegan(#)?'].'"),
	('.$log['OrderID'].', 11, "'.$log['Kosher(#)?'].'"),
	('.$log['OrderID'].', 12, "'.$log['Gluten Free(#)?'].'")
	;
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}



?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?


mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT * FROM `tbl_VendorAbilities` ORDER BY VendorName');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$vendor = $vendors[strtolower($log['VendorName'])];
	
	$sql = 'INSERT INTO catering_extra
	(vendor_id, extra_label_id, value)
	VALUES
	('.$vendor.', 1, "'.$log['Beverages?'].'"),
	('.$vendor.', 2, "'.$log['Utensils'].'"),
	('.$vendor.', 13, "'.$log['Serving Trays?'].'"),
	('.$vendor.', 3, "'.$log['Paper Ware?'].'"),
	('.$vendor.', 5, "'.$log['Folding Tables?'].'"),
	('.$vendor.', 14, "'.$log['Table Clothes?'].'"),
	('.$vendor.', 15, "'.$log['Other1?:'].'"),
	('.$vendor.', 4, "'.$log['Food allergies?'].'"),
	('.$vendor.', 6, "'.$log['Organic?'].'"),
	('.$vendor.', 7, "'.$log['Low carb?'].'"),
	('.$vendor.', 8, "'.$log['ChafingDishes?'].'"),
	('.$vendor.', 9, "'.$log['Vegetarian?'].'"),
	('.$vendor.', 10, "'.$log['Vegan?'].'"),
	('.$vendor.', 11, "'.$log['Kosher?'].'"),
	('.$vendor.', 12, "'.$log['Gluten Free?'].'"),
	('.$vendor.', 16, "'.$log['Individuals?'].'")
	;
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
}



?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<?






$meal_types = array();
$res = mysql_query('SELECT id_meal_type, label FROM meal_types');
while($log = mysql_fetch_assoc($res))
	$meal_types[strtolower($log['label'])] = $log['id_meal_type'];
	
$payout_status = array();
$res = mysql_query('SELECT id_payout_status, label FROM payout_status');
while($log = mysql_fetch_assoc($res))
	$payout_status[strtolower($log['label'])] = $log['id_payout_status'];
	
$tip_status = array();
$res = mysql_query('SELECT id_tip_status, label FROM tip_status');
while($log = mysql_fetch_assoc($res))
	$tip_status[strtolower($log['label'])] = $log['id_tip_status'];

$payment_methods = array();
$res = mysql_query('SELECT id_payment_method, label FROM payment_methods');
while($log = mysql_fetch_assoc($res))
	$payment_methods[strtolower($log['label'])] = $log['id_payment_method'];

$order_status = array();
$res = mysql_query('SELECT id_order_status, label FROM order_status');
while($log = mysql_fetch_assoc($res))
	$order_status[strtolower($log['label'])] = $log['id_order_status'];
	
$payment_status = array();
$res = mysql_query('SELECT id_payment_status, label FROM payment_status');
while($log = mysql_fetch_assoc($res))
	$payment_status[strtolower($log['label'])] = $log['id_payment_status'];
	


mysql_select_db('cater2me') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
$res = mysql_query('SELECT op.OrderID, OrderPaymentStatus, OrderStatus, OrderPaymentType, CategoryName, PayoutStatus, TipStatus, TaxExempt, ServiceFee, FC2meFee, Tip, UpdateTime, UpdateNotes FROM `tbl_OrderProposals` op, tbl_OrderRequests o_r WHERE Selected AND op.OrderID = o_r.OrderID ORDER BY op.OrderID');
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('utf8') or die(mysql_error());

while($log = mysql_fetch_assoc($res))
{
	$sql = 'UPDATE order_requests SET
	order_payment_status_id = '.$payment_status[strtolower($log['OrderPaymentStatus'])].',
	order_status_id = '.$order_status[strtolower($log['OrderStatus'])].',
	payment_method_id = '.(int)$payment_methods[strtolower($log['OrderPaymentType'])].',
	meal_type_id = '.$meal_types[strtolower($log['CategoryName'])].',
	payout_status_id = '.$payout_status[strtolower($log['PayoutStatus'])].',
	tip_status_id = '.$tip_status[strtolower($log['TipStatus'])].',
	tax_exempt = '.$log['TaxExempt'].',
	fc2me_fee = "'.$log['FC2meFee'].'" ,
	tip = "'.$log['Tip'].'",
	last_updated = "'.$log['UpdateTime'].'",
	last_updates = "'.mysql_real_escape_string($log['UpdateNotes']).'"
	
	WHERE id_order = '.$log['OrderID'].'
	';
	mysql_query($sql) or die($sql.':'.mysql_error());
	
}








$sql='DELETE FROM catering_extra WHERE value = "0" OR value = ""';
mysql_query($sql) or die($sql.':'.mysql_error());


?>
<script type="text/javascript">
curstep++;
document.getElementById('perc').innerHTML = Math.round(curstep/maxsteps*100) + " %";
</script><? flush(); ?>
<script type="text/javascript">
document.getElementById('perc').innerHTML = "Operation complete. If you don't see any error everything seems to be all right.";
</script><? flush(); ?>
<?



/*
mysql_connect('localhost','cater2me','dJ75abK2h') or die(mysql_error());
mysql_select_db('cater2medev') or die(mysql_error());
mysql_set_charset('latin1') or die(mysql_error());
*/
?>
