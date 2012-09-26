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
	/*
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
*/
</style>
<title>Menu</title>
</head>
<body>
<br>
<?
$idpopup=$_GET['pop'];
$res = mysql_query("SELECT menu_beta  FROM betakitchen where id_beta = '$idpopup'");
$popup = mysql_fetch_assoc($res);
$menu_popup= $popup['menu_beta'];
echo nl2br($menu_popup);
?>
<br><br>	

</body>
</html>
