<?

$config = array(
	'db' => array(
			'host' => 'localhost',
			'user' => 'root',
			'pwd' => 'dbAcc3ss!',
			'db' => 'cater2medev',
			'dbNY' => 'cater2medevNY',
			'charset' => 'utf8'
			),
	'NYurl' => 'http://ny.cater2.me',
	'secret' => 'd:2.2A-J2h@az/;Pow', //random key for generating security hash
	
	'sess_length' => 3600, //max session idle time allowed, in sec
	
	'www' => false, // turns on/off redirection from www.c2me to c2me
	
	'tax_rate' => 0.085, // tax % applied to vendor items. Used throughout the platform. Example: 0.1234 will be 12.34%
	
	'gcal' => array(  'login'=>'calendar@cater2.me', // credentials for Google Calendar API
				'pwd'=>'156cater',
				
				'cal_name'=>'Cater2.me - {vendor_name} meals' //formatting of calendar names. Variable available: {vendor_name}
				),
	
	'gshortener_key' => 'AIzaSyBGWYvSnTDkNDmgSGO1UZ0tZcN5jVO8FUY', // URL shortener API key
	
	'feedback_max_period' => 172800, // allow users to leave feedback after ### seconds after delivery | 86400sec = 24hrs
	
	'signup_reminder' => 604800, // sends email atfer #### seconds to remind users who didn't go through the entire signup process | 604800sec = 1 week
	
	'public_phone' => '(415) 343-5160', // exlusively displayed throughout the site
	
	'public_email' => 'help@cater2.me', // exlusively displayed throughout the site
	
	'staff_notifications' => array( // platform notifications will be sent to these e-mail addresses (order confirmations, feedback, ...).
						'vendor_confirmations' => 'help@cater2.me', //by e-mail or by txt msging
						'default' => 'help@cater2.me' //everything else
						),
	
	'mailer_from' => 'bot@cater2.me', // ALL website e-mails will be sent from this address.
	
	'newsletter_from' => 'social@cater2.me', // e-mail nesletter
	
	'testimonials_interval' => 7000, // interval (in millisec) between each homepage testimonial
	
	'referral_forms' => true, // enable/disable referral pages
	
	'notify_server_errors' => 'zachary@cater2.me', // sends email notifications upon server errors (404). Empty string = disabled
	
	'scheduled_jobs' => array(
			//array('hour (0-23)', 'minute (0 or 30)', 'day of week (1-7)', 'day of month (1-31)', 'month (1-12)', 'target filename'),
			//for any field: all = '*'
			//To turn something off, comment it out ("//" at beginning of line). Make sure last item in list has no comma, 2nd to last item has comma.
			array('10', '0', '*', '*', '*', 'Signup-reminders.php'),
			array('13', '0', '7', '*', '*', 'Weekly-reminders.php'),
			array('15', '0', '*', '*', '*', 'Staff-reminders.php'),
			array('2', '0', '*', '*', '*', 'StaffDay_reminder.php'),
			array('13', '0', '*', '*', '*', 'Confirmation-reminders.php?ahead=3'),
			array('13', '0', '*', '*', '*', 'Confirmation-reminders.php?ahead=2'),
			array('13', '0', '*', '*', '*', 'Confirmation-reminders.php?ahead=1'),
			array('7', '0', '*', '*', '*', 'SMS-reminders.php')
	)

	
);


