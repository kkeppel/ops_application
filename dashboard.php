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
		<style type="text/css">
		 
		
		table{
		border-width : 0px;
				}
		td {
		border-width : 0px;

		}
		
		</style>
	<h1> San Francisco Dashboard</h1>
    
    <p>
        <a href="http://ny.cater2.me/dashboard/" target="_self" title="Administer New York">Go to NY Dashboard</a>
    </p>


<table border="0" cellspacing="5" cellpadding="5">
	<tr><td width = "300px"><b>Monitoring Tools</b></td><td><b>Download / Upload</b></td></tr>
	<tr><td><a href="/dashboard/calendar/">• All calendars</a></td><td><a href="/tmp-feedback-csv.php">• Get feedback CSV</a></td></tr>
	<tr><td><a href="/capture.php">• Email capture management</a></td><td><a href="/tmp-newsletter-csv.php">• Get list of newsletter emails CSV</a></td></tr>
	<tr><td><a href="/dashboard/list-signup-attempts/">• List of signup attempts</a></td><td><a href="/tmp-text-csv.php">• Get list of text info CSV</a></td></tr>
	<tr><td><a href="/order-text-mgmt.php">• Order arrival SMS</a></td><td><a href="/tmp-users-csv.php">• Get list of users CSV</a></td></tr>
	<tr><td><a href="/tmp-vendors-opt-out.php">• Vendors opt-out</a></td><td><a href="/new-gcal.php">• Insert orders to GCal</a></td></tr>
	<tr><td><a href="/tmp-sms-confirmations.php">• View SMS Confirmations</a></td><td><a href="/tmp-referral-csv.php">• List referral CSV</a></td></tr>
	<tr><td></td><td><a href="http://dev.cater2.me/db/update-db.php">• Update database</a></td></tr>
		<tr><td></td><td></td></tr>
			<tr><td></td><td></td></tr>
	<tr><td width = "300px"><b>Website / Communication</b></td><td><b>Client / Vendor Management</b></td></tr>
	<tr><td><a href="/manage-betakitchen.php">• Betakitchen management</a></td><td><a href="/choice_pdf.php">• Manage access to menu pdf</a></td></tr>
	<tr><td><a href="/newsletter-simple-mgmt.php">• E-mail template management</a></td><td><a href="/sub-email-mgmt.php">• Manage address delegation</a></td></tr>
	<tr><td><a href="/dashboard/newsletter-mgmt/">• Newsletter Management</a></td><td><a href="/tmp-calendar-mgmt.php">• Manage Client Calendars</a></td></tr>
	<tr><td><a href="/vendor-page-mgmt.php">• Vendor Page management</a></td><td><a href="/choice_client.php">• Manage client calendar version</a></td></tr>
	<tr><td><a href="/dashboard/website-mgmt/">• Website management</a></td><td><a href="/send_VForm.php">• Send vendor form</a></td></tr>
	<tr><td></td><td><a href="/dashboard/user-mgmt/">• User Management</a></td></tr>
	<tr><td></td><td><a href="/manage-popup.php">• Vendor menu and bio management</a></td></tr>
 
	
</table>
		
	<?
	require 'footer.php';
	
	break;
	case 'vendor':
	case 'client':
	case 'employee':
	redirect('/dashboard/calendar/');
	break;
}


