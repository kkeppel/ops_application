<?
require 'lib/core.php';

if($config['notify_server_errors']) sendMail($config['notify_server_errors'],$_SERVER['QUERY_STRING'],$_SERVER['REQUEST_URI']);

switch($_SERVER['QUERY_STRING']) {
	case '404':
	$msg='Sorry, this page does not exist.';
	break;
}

notif('<b>('.$_SERVER['QUERY_STRING'].')</b> '.$msg);
