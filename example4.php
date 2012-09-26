<?php
echo $_GET['utm_campaign'];
?>
<?php
session_start(); 
$_SESSION['campaign'] = $_GET['utm_campaign']; // store session data
?>
Below:
<?php
echo $_SESSION['campaign']
?>