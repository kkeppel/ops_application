<?

require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');


if($_SERVER['REQUEST_METHOD']=='POST')
{
	foreach($_POST as $key=>$val) {
		$_POST[$key] = stripslashes($val);
	}


	
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_simple_top']).'" WHERE label = newsletter_simple_top"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_simple_body']).'" WHERE label = "newsletter_simple_body"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_simple_footer']).'" WHERE label = "newsletter_simple_footer"');
	
	
	
	if($_POST['recipients']) {
		
		$template = file_get_contents('template/emails/newsletter-simple.html');
		
		$addresses = explode(';', $_POST['recipients']);
		$subject = stripslashes($_POST['subject']);
		
		$template = str_replace(array('{{newsletter_simple_top}}','{{newsletter_simple_body}}','{{newsletter_simple_footer}}'),
					  array($_POST['newsletter_simple_top'],$_POST['newsletter_simple_body'],$_POST['newsletter_simple_footer']),
					  $template);
		
		
		foreach($addresses as $address) {
			$address = trim($address);
			
			sendMail($address, $subject, str_replace('{{c2me_tracking_link}}', 'http://cater2.me/?ref='.urlencode(c2me_encrypt($address)), $template), true);
		}
		
		notif('E-mail(s) sent');
	}
}

$template = array(
	'title' => 'Cater2.me | Newsletter management',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Newsletter management'=>'/dashboard/newsletter-mgmt/'),
	'menu_selected' => 'home',
	'header_resources' => '
		<script src="/template/js/custom/jquery.ui.core.js"></script>
		<script src="/template/js/custom/jquery.ui.widget.js"></script>

		<script src="/template/js/custom/jquery.ui.accordion.js"></script>
	
		<script>
		$(function() {
			$( ".accordion" ).accordion({
				autoHeight: false,
				navigation: true,
				collapsible: true,
				active: false
			});
		});
		</script>
		
		<style>
		input[type="text"], textarea {
		margin:5px;
		width:100%;
		}
		textarea {
		height:70px;
		}
		
		fieldset {
		border:1px #777 solid;
		padding:10px;
		}
		fieldset legend {
		margin-left:2px;
		}
		.accordion {
		width:800px;
		margin:0 auto;
		}
		</style>
	',
	
	'grey_bar' => 'Newsletter management'
	);

require 'header.php';


$areas=array();
$res = mysql_query('SELECT * FROM website_editable_areas');
while($log = mysql_fetch_assoc($res)) {
	$areas[$log['label']]=$log['value'];
}


?>
<form method="post">

<div class="accordion">
	<h3><a href="#">Template</a></h3>
	<div>


	<div style="float:left; width:500px;">
		<input type="text" name="newsletter_simple_top" value="<?=$areas['newsletter_simple_top']?>" />
	
		<textarea name="newsletter_simple_body"><?=$areas['newsletter_simple_body']?></textarea>

		<input type="text" name="newsletter_simple_footer" value="<?=$areas['newsletter_simple_footer']?>" />
	</div>

	<br style="clear:both" /><br />
	<p>Note for tracking: type {{c2me_tracking_link}} as link.<br />Example: <u>&lt;a href="{{c2me_tracking_link}}"&gt;visit our website&lt;/a&gt;</u></p>

	<p style="margin-top:40px; text-align:center"><input type="submit" value="Update" /></p>


	</div>
	<h3><a href="#"><a>Send now</a></h3>
	<div>
	
	<fieldset><legend>Send to</legend>
	<input type="text" name="subject" placeholder="Subject" />
	<textarea name="recipients" placeholder="E-mail addresses (separate with semi-colons)"></textarea><br />

	</fieldset>
	
	<p style="margin-top:20px; text-align:center"><input type="submit" value="Send" /></p>
	
	</div>

</div>


</form>
<?

require 'footer.php';

