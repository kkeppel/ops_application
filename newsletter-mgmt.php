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


	
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_top_bar']).'" WHERE label = "newsletter_top_bar"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_top']).'" WHERE label = "newsletter_top"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_title1']).'" WHERE label = "newsletter_title1"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_title2']).'" WHERE label = "newsletter_title2"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_title3']).'" WHERE label = "newsletter_title3"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_body1']).'" WHERE label = "newsletter_body1"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_body2']).'" WHERE label = "newsletter_body2"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_body3']).'" WHERE label = "newsletter_body3"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_side_title']).'" WHERE label = "newsletter_side_title"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_side']).'" WHERE label = "newsletter_side"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_bottom']).'" WHERE label = "newsletter_bottom"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_footer']).'" WHERE label = "newsletter_footer"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_keys']).'" WHERE label = "newsletter_keys"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_side_title2']).'" WHERE label = "newsletter_side_title2"');
	mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string($_POST['newsletter_side2']).'" WHERE label = "newsletter_side2"');
	
	
	
	if($_POST['recipients']) {

  $template = file_get_contents('template/emails/newsletter.html');

  $addresses = explode(';', $_POST['recipients']);
  $subject = stripslashes($_POST['subject']);
  foreach($addresses as $address) {
	$address = trim($address);
	$address2=md5($address);
    $newsletter_unsign =  ' <a href="http://cater2.me/unsign-newsletter.php?id='.$address2.'">Unsubscribe from the newsletter</a>';
	
    $template_after_replace = str_replace(array('{{newsletter_top_bar}}','{{newsletter_top}}','{{newsletter_title1}}','{{newsletter_body1}}','{{newsletter_title2}}','{{newsletter_body2}}','{{newsletter_title3}}','{{newsletter_body3}}','{{newsletter_side_title}}','{{newsletter_side}}','{{newsletter_bottom}}','{{newsletter_footer}}','{{newsletter_keys}}','{{newsletter_side_title2}}', '{{newsletter_side2}}','{{newsletter_unsign}}'),
              array($_POST['newsletter_top_bar'],$_POST['newsletter_top'],$_POST['newsletter_title1'],$_POST['newsletter_body1'],$_POST['newsletter_title2'],$_POST['newsletter_body2'],$_POST['newsletter_title3'],$_POST['newsletter_body3'],$_POST['newsletter_side_title'],$_POST['newsletter_side'],$_POST['newsletter_bottom'],$_POST['newsletter_footer'],$_POST['newsletter_keys'],$_POST['newsletter_side_title2'], $_POST['newsletter_side2'], $newsletter_unsign),
              $template);


    sendNewsletter($address, $subject, str_replace('{{c2me_tracking_link}}', 'http://cater2.me/?ref='.urlencode(c2me_encrypt($address)), $template_after_replace), true);
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
		<input type="text" name="newsletter_top_bar" value="<?=$areas['newsletter_top_bar']?>" />
		<textarea name="newsletter_top"><?=$areas['newsletter_top']?></textarea>
	
		<input type="text" name="newsletter_title1" value="<?=$areas['newsletter_title1']?>" />
		<textarea name="newsletter_body1"><?=$areas['newsletter_body1']?></textarea>
		<input type="text" name="newsletter_title2" value="<?=$areas['newsletter_title2']?>" />
		<textarea name="newsletter_body2"><?=$areas['newsletter_body2']?></textarea>
		<!-- KEYS -->
		<input type="text" name="newsletter_keys" value="<?=$areas['newsletter_keys']?>" />
		
		<input type="text" name="newsletter_title3" value="<?=$areas['newsletter_title3']?>" />
		<textarea name="newsletter_body3"><?=$areas['newsletter_body3']?></textarea>
		
		<textarea name="newsletter_bottom"><?=$areas['newsletter_bottom']?></textarea>
		<input type="text" name="newsletter_footer" value="<?=$areas['newsletter_footer']?>" />
	</div>
	<div style="float:right; height:300px; width:200px">
		<input type="text" name="newsletter_side_title" value="<?=$areas['newsletter_side_title']?>" />
		<textarea name="newsletter_side" style="height:80%"><?=$areas['newsletter_side']?></textarea>
	</div>
	<div style="float:right; height:300px; width:200px">
		<input type="text" name="newsletter_side_title2" value="<?=$areas['newsletter_side_title2']?>" />
		<textarea name="newsletter_side2" style="height:100%"><?=$areas['newsletter_side2']?></textarea>
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
	
	<h3><a href="#"><a>Emails users</a></h3>
	<div>
<? $text='';
$sql=mysql_query('SELECT email_w FROM website_newsletter_emails where newsletter_w=1');
$sql2=mysql_query('SELECT email FROM users where newsletter=1 and id_user not in (select id_user from users where vendor_id <> 0)');

while($user = mysql_fetch_assoc($sql))
{
$text=$text.$user['email_w'].';';
}
while($user2 = mysql_fetch_assoc($sql2))
{
$text=$text.$user2['email'].';';
}?>

	<textarea > <? echo $text ;?> </textarea>
	
	</div>

</div>


</form>
<?

require 'footer.php';

