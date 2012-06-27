<?

require 'lib/core.php';


	session_start();
	//if user comes from referral link
	if(isset($_SESSION['ref'])) {
		$res=mysql_query('SELECT * FROM users WHERE id_user =  '.(int)$_SESSION['ref']);
		$log=mysql_fetch_assoc($res);
		$ref="\nReferral: ".$log['username'].' ('.$log['first_name'].' '.$log['last_name'].')';
	}
	else
		$ref='';


?><!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"> 
<head>
<style>
	body {
	font-family:"Trebuchet MS", Arial;
	color:#C4C4C4;
	text-align:center;
	background-color:#222;
	}
	h1 {
	text-align:center;
	font-size:24px;
	margin:30px;
	}
	
	table {
	margin:5px auto
	}
	td {
	padding:12px;
	text-align:right;
	}
	td input {
	width:200px;
	}
	a {
	color:#C82B2B;
	}
</style>

</head>
<body>


		Cater2.me and its vendors go to great lengths to tag each menu item with accurate allergen information. Each item is put through a technology filter and then reviewed by both the vendor and Cater2.me for accuracy. Vendors have verified allergen information and are expected to prepare dishes in a manner consistent with the item descriptions and allergen information presented on the menus.<br><br> As Cater2.me does not participate in the preparation or transportation of the items, Cater2.me does not assume any liability with regard to the accuracy of the allergen labeling and is unable to guarantee that common allergens are not present during the preparation, cooking, delivery or setup processes for each meal. <br><br>Should you have a severe allergy, please contact Cater2.me at 415.781.5500 for more information regarding general questions or specific dishes.
	

</body>
</html>
