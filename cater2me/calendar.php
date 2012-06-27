<?

require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}


switch(getUserGroup($curUser))
{
case 'vendor':
	include 'Calendar-Vendor.php';
break;
case 'client':
case 'employee':
	include 'calendar-choice.php';
break;
case 'staff':
	include 'Calendar-Staff.php';
break;
default:
	notif('Sorry, you are not allowed here.');
break;
}


require 'footer.php';

