<?

require 'lib/core.php';

if(!$curUser) {
	redirect('/login/?url='.urlencode($_SERVER['REQUEST_URI']));
}

if(getUserGroup($curUser) != 'staff')
	notif('Sorry, you are not allowed here.');


if($_SERVER['REQUEST_METHOD']=='POST')
{
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['homepage_slide1_content'])).'" WHERE label = "homepage_slide1_content"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['homepage_slide1_icon1'])).'" WHERE label = "homepage_slide1_icon1"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['homepage_slide1_icon2'])).'" WHERE label = "homepage_slide1_icon2"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['homepage_slide1_icon3'])).'" WHERE label = "homepage_slide1_icon3"');
		
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['homepage_featured_in'])).'" WHERE label = "homepage_featured_in"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['homepage_6icons_title'])).'" WHERE label = "homepage_6icons_title"');
		
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['about_top'])).'" WHERE label = "about_top"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['about_bio_zach'])).'" WHERE label = "about_bio_zach"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['about_bio_alex'])).'" WHERE label = "about_bio_alex"');
		
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['contact_us_top'])).'" WHERE label = "contact_us_top"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['contact_us_buyers'])).'" WHERE label = "contact_us_buyers"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['contact_us_providers'])).'" WHERE label = "contact_us_providers"');
		
		
		
		//referral_types
		foreach($_POST['referral_types'] as $id=>$fields) {
		
			if($id) // update
				mysql_query('UPDATE website_referral_types SET label = "'.mysql_real_escape_string(stripslashes($fields['label'])).'" WHERE id_referral_type = '.(int)$id) or die(mysql_error());
			elseif($fields['label']!='') // new
				mysql_query('INSERT INTO website_referral_types SET label = "'.mysql_real_escape_string(stripslashes($fields['label'])).'"') or die(mysql_error());
		}
		
		
		
		foreach($_POST['testimonials'] as $id=>$fields) {
		
			if($id) // update
				mysql_query('UPDATE website_testimonials SET author = "'.mysql_real_escape_string(stripslashes($fields['author'])).'", content = "'.mysql_real_escape_string(stripslashes($fields['content'])).'" WHERE id_testimonial = '.(int)$id) or die(mysql_error());
			elseif($fields['content']!='') // new
				mysql_query('INSERT INTO website_testimonials SET author = "'.mysql_real_escape_string(stripslashes($fields['author'])).'", content = "'.mysql_real_escape_string(stripslashes($fields['content'])).'"') or die(mysql_error());
			
			if(is_uploaded_file($_FILES['testimonials']['tmp_name'][$id]['pic'])) {
				if(!move_uploaded_file($_FILES['testimonials']['tmp_name'][$id]['pic'], 'template/images/custom/testimonials/'.(($id)?$id:mysql_insert_id()).'.png'))
				{
					notif('Error: File(s) didn\'t upload successfully');
				}
			}
		}
		
		
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['homepage_event_spotlight_title'])).'" WHERE label = "homepage_event_spotlight_title"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['homepage_event_spotlight_posted'])).'" WHERE label = "homepage_event_spotlight_posted"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['homepage_event_spotlight'])).'" WHERE label = "homepage_event_spotlight"');
		if(is_uploaded_file($_FILES['homepage_event_spotlight_pic']['tmp_name'])) {
			if(!move_uploaded_file($_FILES['homepage_event_spotlight_pic']['tmp_name'], 'template/images/custom/home_event_spotlight.jpg'))
			{
				notif('Error: File(s) didn\'t upload successfully');
			}
		}
		
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['event_spotlight_top'])).'" WHERE label = "event_spotlight_top"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['event_spotlight_highlights'])).'" WHERE label = "event_spotlight_highlights"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['event_spotlight_title'])).'" WHERE label = "event_spotlight_title"');
		
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['event_spotlight_links'])).'" WHERE label = "event_spotlight_links"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['event_spotlight_involved'])).'" WHERE label = "event_spotlight_involved"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['twitter_widget'])).'" WHERE label = "twitter_widget"');
		
		foreach($_POST['blog_posts'] as $id=>$fields) {
			
			if($id) // update
				mysql_query('UPDATE website_blog_posts SET title = "'.mysql_real_escape_string(stripslashes($fields['title'])).'", posted = "'.mysql_real_escape_string(stripslashes($fields['posted'])).'", content = "'.mysql_real_escape_string(stripslashes($fields['content'])).'" WHERE id_blog_post = '.(int)$id) or die(mysql_error());
			elseif($fields['title']!='') // new
				mysql_query('INSERT website_blog_posts SET title = "'.mysql_real_escape_string(stripslashes($fields['title'])).'", posted = "'.mysql_real_escape_string(stripslashes($fields['posted'])).'", content = "'.mysql_real_escape_string(stripslashes($fields['content'])).'"') or die(mysql_error());
			
			if(is_uploaded_file($_FILES['blog_posts']['tmp_name'][$id]['pic'])) {
				if(!move_uploaded_file($_FILES['blog_posts']['tmp_name'][$id]['pic'], 'template/images/custom/blog_posts/'.(($id)?$id:mysql_insert_id()).'.jpg'))
				{
					notif('Error: File(s) didn\'t upload successfully');
				}
			}
		}
		
		
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['jobs'])).'" WHERE label = "jobs"');
		
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['calendar_vendor_top'])).'" WHERE label = "calendar_vendor_top"');
		mysql_query('UPDATE website_editable_areas SET value = "'.mysql_real_escape_string(stripslashes($_POST['calendar_client_top'])).'" WHERE label = "calendar_client_top"');
		
		if($_POST['delete_resource'])
		{
			$_POST['id_resource']=(int)$_POST['id_resource'];
			
			switch($_POST['delete_resource']) {
				case 'del_blog_post':
				@unlink('template/images/custom/blog_posts/'.$_POST['id_resource'].'.jpg');
				mysql_query('DELETE FROM website_blog_posts WHERE id_blog_post = '.$_POST['id_resource']);
				break;
				case 'del_testimonial':
				@unlink('template/images/custom/testimonials/'.$_POST['id_resource'].'.png');
				mysql_query('DELETE FROM website_testimonials WHERE id_testimonial = '.$_POST['id_resource']);
				break;
				case 'del_referral_type':
				mysql_query('DELETE FROM website_referral_types WHERE id_referral_type = '.$_POST['id_resource']);
				break;
			}
		}
}


$template = array(
	'title' => 'Cater2.me | Website management',
	'breadcrumb' => array('Home'=>'/', 'Dashboard'=>'/dashboard/', 'Website management'=>'/dashboard/website-mgmt/'),
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
		
		function deleteResource(res_type, id) {
			document.f.delete_resource.value=res_type;
			document.f.id_resource.value=id;
			document.f.submit();
		}
		</script>
		
		<style>
		
		#tblHTML td {
		  height: 35px;
		  vertical-align: middle;
		}
		#tblHomeSlider {
		border:0;
		width:100%;
		}
		#tblHomeSlider td {
		border:0;
		}
		
		fieldset {
		border:1px #777 solid;
		padding:10px;
		}
		fieldset legend {
		margin-left:2px;
		}
		.del {
		color:red !important;
		}
		</style>
	',
	
	'grey_bar' => 'Website management'
	);

require 'header.php';


$areas=array();
$res = mysql_query('SELECT * FROM website_editable_areas');
while($log = mysql_fetch_assoc($res)) {
	$areas[$log['label']]=$log['value'];
}


?>
<div class="grid_10 suffix_1 prefix_1">

<form method="post" name="f" enctype="multipart/form-data">

<!-- for any deletion to go through POST instead of GET, therefore update the rest of the page too -->
<input type="hidden" name="delete_resource" value="" />
<input type="hidden" name="id_resource" value="" />


<div class="accordion">
	<h3><a href="#"><u>HTML notes</u></a></h3>
	<div>
	
		<table id="tblHTML">
			<tr>
				<td> <b>bold</b> </td><td> &lt;b&gt;bold&lt;/b&gt; </td>
				<td> <u>underline</u> </td><td> &lt;u&gt;underline&lt;/u&gt; </td>
			</tr>
			<tr>
				<td> <a href="http://www.google.com" target="_new">link</a> </td><td> &lt;a href="http://www.google.com"&gt;link&lt;/a&gt; </td>
				<td> <h2>Title</h2> </td><td> &lt;h2&gt;Title&lt;/h2&gt; </td>
			</tr>
			<tr>
				<td> <span style="color:#FF0000">color</span> </td><td> &lt;span style="color:#FF0000"&gt;color&lt;/span&gt; </td>
				<td>
					<ul style="padding:0;margin:0">
						<li>bullet</li>
						<li>...</li>
					</ul>
				</td>
				<td>
					&lt;ul&gt;<br />
						&lt;li&gt;bullet&lt;/li&gt;
						&lt;li&gt;...&lt;/li&gt;<br />
					&lt;/ul&gt;
				</td>
			</tr>
		</table>
	
	</div>
	<h3><a href="#"><b>Homepage</b> - Slider</a></a></h3>
	<div>
		<textarea name="homepage_slide1_content" style="width:100%; height:100px"><?=$areas['homepage_slide1_content']?></textarea>
		
		<table id="tblHomeSlider"><tr>
		<td><textarea name="homepage_slide1_icon1" style="width:100%; height:90px"><?=$areas['homepage_slide1_icon1']?></textarea></td>
		<td><textarea name="homepage_slide1_icon2" style="width:100%; height:90px"><?=$areas['homepage_slide1_icon2']?></textarea></td>
		<td><textarea name="homepage_slide1_icon3" style="width:100%; height:90px"><?=$areas['homepage_slide1_icon3']?></textarea></td>
		</tr></table>
	</div>
	<h3><a href="#"><b>Homepage</b> - Testimonials</a></a></h3>
	<div>
		<?
		$res = mysql_query('SELECT * FROM website_testimonials');
		while($log = mysql_fetch_assoc($res)) {
			?>
				<fieldset><legend>Testimonial <?=$log['id_testimonial']?> <a href="javascript:void(0)" onclick="deleteResource('del_testimonial',<?=$log['id_testimonial']?>)" class="del">X</a></legend>
				<input type="text" name="testimonials[<?=$log['id_testimonial']?>][author]" value="<?=$log['author']?>" style="width:100%" />
				<textarea name="testimonials[<?=$log['id_testimonial']?>][content]" style="width:100%"><?=$log['content']?></textarea>
				<input type="file" name="testimonials[<?=$log['id_testimonial']?>][pic]" /> (.png, max 150x150) <!-- make HTML 5 filter only jpg here -->
				</fieldset>
			<?			
		}
		?>
			<fieldset><legend>New testimonial</legend>
			<input type="text" name="testimonials[0][author]" value="" placeholder="author" style="width:100%" />
			<textarea name="testimonials[0][content]" style="width:100%" placeholder="...content"></textarea>
			<input type="file" name="testimonials[0][pic]" /> (.png, max 150x150) <!-- make HTML 5 filter only jpg here -->
			</fieldset>
	</div>
	<h3><a href="#"><b>Homepage</b> - Body</a></h3>
	<div>
		<textarea name="homepage_featured_in" style="width:100%; height:70px"><?=$areas['homepage_featured_in']?></textarea><br />
		<textarea name="homepage_6icons_title" style="width:100%; height:70px"><?=$areas['homepage_6icons_title']?></textarea><br />
		
		<fieldset><legend>Event spotlight</legend>
		<input type="text" name="homepage_event_spotlight_title" value="<?=$areas['homepage_event_spotlight_title']?>" style="width:100%" />
		<input type="text" name="homepage_event_spotlight_posted" value="<?=$areas['homepage_event_spotlight_posted']?>" style="width:100%" />
		<input type="file" name="homepage_event_spotlight_pic" /> (.jpg, 137x137) <!-- make HTML 5 filter only jpg here -->
		<textarea name="homepage_event_spotlight" style="width:100%;height:130px"><?=$areas['homepage_event_spotlight']?></textarea>
		</fieldset>
	</div>
	<h3><a href="#"><b>Event spotlight</b> - Top</a></h3>
	<div>
		<fieldset><legend>Top text</legend>
		<textarea name="event_spotlight_top" style="width:100%; height:120px"><?=$areas['event_spotlight_top']?></textarea>
		</fieldset>
		<fieldset><legend>Highlights</legend>
		<input type="text" name="event_spotlight_title" value="<?=$areas['event_spotlight_title']?>" style="width:100%" />
		<textarea name="event_spotlight_highlights" style="width:100%; height:120px"><?=$areas['event_spotlight_highlights']?></textarea>
		</fieldset>
		<fieldset><legend>Links</legend>
		<textarea name="event_spotlight_links" style="width:100%; height:120px"><?=$areas['event_spotlight_links']?></textarea>
		</fieldset>
		<fieldset><legend>Get involved</legend>
		<textarea name="event_spotlight_involved" style="width:100%; height:120px"><?=$areas['event_spotlight_involved']?></textarea>
		</fieldset>


		<fieldset><legend>Twitter widget</legend>
		<textarea name="twitter_widget" style="width:100%; height:120px"><?=$areas['twitter_widget']?></textarea>
		</fieldset>
		
	</div>
	<h3><a href="#"><b>Event spotlight</b> - Blog posts</a></h3>
	<div>
		<?
		$res = mysql_query('SELECT * FROM website_blog_posts');
		while($log = mysql_fetch_assoc($res)) {
			?>
				<fieldset><legend>Post #<?=$log['id_blog_post']?> <a href="javascript:void(0)" onclick="deleteResource('del_blog_post',<?=$log['id_blog_post']?>)" class="del">X</a></legend>
				<input type="text" name="blog_posts[<?=$log['id_blog_post']?>][title]" value="<?=$log['title']?>" style="width:100%" />
				<input type="text" name="blog_posts[<?=$log['id_blog_post']?>][posted]" value="<?=$log['posted']?>" style="width:100%" />
				<input type="file" name="blog_posts[<?=$log['id_blog_post']?>][pic]" /> (.jpg, 137x137) <!-- make HTML 5 filter only jpg here -->
				<textarea name="blog_posts[<?=$log['id_blog_post']?>][content]" style="width:100%;height:130px"><?=$log['content']?></textarea>
				</fieldset>
			<?			
		}
		?>
		
			<fieldset><legend>New post</legend>
			<input type="text" name="blog_posts[0][title]" value="" placeholder="title" style="width:100%" />
			<input type="text" name="blog_posts[0][posted]" value="<?=date('m/d/Y g:i A')?>" style="width:100%" />
			<input type="file" name="blog_posts[0][pic]" /> (.png, max 150x150) <!-- make HTML 5 filter only jpg here -->
			<textarea name="blog_posts[0][content]" style="width:100%;height:130px" placeholder="...content"></textarea>
			</fieldset>
	</div>
	<h3><a href="#"><b>Signup</b></a></h3>
	<div>
		<fieldset><legend>Referral types</legend>
			<?
			$res = mysql_query('SELECT * FROM website_referral_types');
			while($log = mysql_fetch_assoc($res)) {
			?>
				<input type="text" name="referral_types[<?=$log['id_referral_type']?>][label]" value="<?=$log['label']?>" style="width:80%" /> <a href="javascript:void(0)" onclick="deleteResource('del_referral_type',<?=$log['id_referral_type']?>)" class="del">X</a></legend>
			<?
			}
			?>
				<hr style="margin:10px" />
				<input type="text" name="referral_types[0][label]" value="" style="width:80%" /> (new)
		</fieldset>
	</div>
	<h3><a href="#"><b>Jobs</b></a></h3>
	<div>
		<textarea name="jobs" style="width:100%; height:200px"><?=$areas['jobs']?></textarea>
	</div>
	<h3><a href="#"><b>About us</b></a></h3>
	<div>
		<textarea name="about_top" style="width:100%; height:90px"><?=$areas['about_top']?></textarea>
		
		<fieldset><legend>Zach</legend>
		<textarea name="about_bio_zach" style="width:100%; height:90px"><?=$areas['about_bio_zach']?></textarea>
		</fieldset>
		<fieldset><legend>Alex</legend>
		<textarea name="about_bio_alex" style="width:100%; height:90px"><?=$areas['about_bio_alex']?></textarea>
		</fieldset>
	</div>
	<h3><a href="#"><b>Contact us</b></a></h3>
	<div>
		<textarea name="contact_us_top" style="width:100%; height:90px"><?=$areas['contact_us_top']?></textarea>
		
		<fieldset><legend>Buyers</legend>
		<textarea name="contact_us_buyers" style="width:100%; height:90px"><?=$areas['contact_us_buyers']?></textarea>
		</fieldset>
		<fieldset><legend>Providers</legend>
		<textarea name="contact_us_providers" style="width:100%; height:90px"><?=$areas['contact_us_providers']?></textarea>
		</fieldset>
	</div>
	<h3><a href="#"><b>Calendar</b></a></h3>
	<div>
		<fieldset><legend>Vendors</legend>
		<textarea name="calendar_vendor_top" style="width:100%; height:90px"><?=$areas['calendar_vendor_top']?></textarea>
		</fieldset>
		<fieldset><legend>Clients</legend>
		<textarea name="calendar_client_top" style="width:100%; height:90px"><?=$areas['calendar_client_top']?></textarea>
		</fieldset>
	</div>
</div>

<p style="margin:30px; text-align:center"><input type="submit" value="Update" /></p>

</form>

</div>

<?

require 'footer.php';

