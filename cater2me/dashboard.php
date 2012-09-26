<?
require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

switch(getUserGroup($curUser))
{
	case 'staff':
	
	require 'header.php';
	?>
	<h1> San Francisco Dashboard</h1>
    
    <p>
        <a href="http://ny.cater2.me/dashboard/" target="_self" title="Administer New York">Go to NY Dashboard</a>
    </p>
		<ul>
			<li><a href="/dashboard/user-mgmt/">User management</a></li>
			<li><a href="/dashboard/website-mgmt/">Website management</a></li>
			<li><a href="/dashboard/newsletter-mgmt/">Newsletter management</a></li>
			<li><a href="/newsletter-simple-mgmt.php">E-mail template management</a></li>
			<li><a href="/dashboard/calendar/">All calendars</a></li>
			<li><a href="/dashboard/list-signup-attempts/">List of signup attempts</a></li>
			<li><a href="/tmp-vendors-opt-out.php">Vendors opt-out notif</a></li>
			
			
			<li><a href="/tmp-vendor-confirmations.php">[temporary] View vendor confirmations </a></li>
			<li><a href="/tmp-sms-confirmations.php">[temporary] View SMS confirmations </a></li>
			<li><a href="http://dev.cater2.me/db/update-db.php">[temporary] Update database </a></li>
			<li><a href="/new-gcal.php">[temporary] Insert orders to GCal </a></li>
			<li><a href="/tmp-calendar-mgmt.php">[temporary] Manage client calendars </a></li>
			<li><a href="/tmp-feedback-csv.php">[temporary] Get feedback CSV </a></li>
			<li><a href="/tmp-referral-csv.php">[temporary] List referral CSV </a></li>
			<li><a href="/tmp-users-csv.php">[temporary] Get list of users CSV </a></li>
			<li><a href="/tmp-text-csv.php">[temporary] Get list of text info CSV </a></li>
			<li><a href="/tmp-newsletter-csv.php">[temporary] Get list of newsletter emails CSV </a></li>
			<li><a href="/order-text-mgmt.php">[temporary] Order arrival SMS </a></li>
			<li><a href="/vendor-page-mgmt.php">[temporary] Vendor Page management </a></li>
			<li><a href="/manage-popup.php">[temporary] Popup management </a></li>
			<li><a href="/manage-betakitchen.php">[temporary] Betakitchen management </a></li>
			<li><a href="/capture.php">[temporary] Email capture management </a></li>
			<li><a href="/choice_client.php">[temporary] Manage Client Calendar Version</a></li>
			<li><a href="/choice_pdf.php">[temporary] Manage Access to Menu Pdf</a></li>
			<li><a href="/sub-email-mgmt.php">[temporary] Manage Address Delegation</a></li>
			<li><a href="/send_VForm.php">Create Vendor Form</a></li>
		</ul>
	
	<?
	require 'footer.php';
	
	break;
	case 'vendor':
	case 'client':
	case 'employee':
	redirect('/dashboard/calendar/');
	break;
}


