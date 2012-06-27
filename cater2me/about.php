
<?
require 'lib/core.php';

$template = array(
	'title' => 'Cater2.me | About Us: Your catering is our business',
	'meta_name' => 'Our mission is to connect companies with the local food scene, to give offices a better, more wholesome sense of the small businesses around them',

	'menu_selected' => 'about',
	'breadcrumb' => array('Home'=>'/', 'About Us'=>'/about/'),
	
	'grey_bar' => 'About Us',
	'slider_open' => true
	);

require 'header.php';


$areas=array();
$res = mysql_query('SELECT label, value FROM website_editable_areas WHERE label LIKE "about_%"');
while($log = mysql_fetch_assoc($res)) {
	$areas[$log['label']]=$log['value'];
}

?>
<div class="grid_12">
<h3 class="post-title">About Cater2.me</h3>

<div id="content">
			
<p><?=plain2Html($areas['about_top'])?></p>
			
</div>

<h3 class="post-title">About the Founders</h3>


<div id="post-author">
				<div class="hr-pattern"></div>
					<a href="#"><img width="70" height="70" alt="author" src="/template/images/custom/zach.png"></a>
					<div id="author-details">
						<h3 id="author-title">Zach Yungst</h3>
						<p><?=plain2Html($areas['about_bio_zach'])?></p>
					</div><!-- end #author-details -->
				<div class="clear"></div>
				<div class="hr-pattern"></div>
</div>
<div id="post-author">
					<a href="#"><img width="70" height="70" alt="author" src="/template/images/custom/alex.png" style="margin-top:0"></a>
					<div id="author-details">
						<h3 id="author-title">Alex Lorton</h3>
						<p><?=plain2Html($areas['about_bio_alex'])?></p>
					</div><!-- end #author-details -->
				<div class="clear"></div>
				<div class="hr-pattern"></div>
</div>
</div>
<?

require 'footer.php';
