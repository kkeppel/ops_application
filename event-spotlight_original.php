<?
require 'lib/core.php';

$template = array(
	'title' => 'Cater2.me | Event spotlight',
	'menu_selected' => 'home',
	'breadcrumb' => array('Home'=>'/', 'Event spotlight'=>'/event-spotlight/'),
	
	'grey_bar' => 'Event calendar'
	);

require 'header.php';

?>


<center>
<p style="text-align:center"><iframe src="https://www.google.com/calendar/b/0/embed?showNav=0&amp;showPrint=0&amp;showCalendars=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23ffffff&amp;src=cater2.me_b0m934mhp7m3926b29cpl2985g%40group.calendar.google.com&amp;color=%23711616&amp;ctz=America%2FLos_Angeles" style="border-width:0" width="100%" height="600" frameborder="0" scrolling="no"></iframe></p>
</center>
<?

require 'footer.php';
