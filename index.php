<?
require 'lib/core.php';

	// referral through newsletter email
	if(isset($_GET['ref'])) // original email address crypted
	{
		session_start();
		$_SESSION['ref']=c2me_decrypt($_GET['ref']);
		redirect('/');
	}
	

$testimonials='';
$res = mysql_query('SELECT id_testimonial, author, content FROM website_testimonials ORDER BY 1');
while($log = mysql_fetch_assoc($res)) {
	$testimonials.= 'testimonials.push({"id_testimonial":'.$log['id_testimonial'].', "content":"'.$log['content'].'<br /><br />", "author":"'.$log['author'].'"});'."\n";
}


$template = array(
	'title' => 'Cater2.me | Office Catering in San Francisco and the Bay Area',
	'header_resources' => '
	<!-- Content Slider -->
	<script src="/template/js/slides.min.jquery.js"></script>
	
		<link rel="stylesheet" href="/template/css/custom/tipTip.css" />
		<script src="/template/js/custom/jquery.tipTip.minified.js"></script>
		<script>
		$(document).ready(function() {
		
			$(".tiptip").tipTip({delay:50});
			
			$("#divHomeSliderIcons img").hover(
			function() { this.src = this.src.replace("a.", "b.");
			},
			function() { this.src = this.src.replace("b.", "a.");
			});
			
		
			
			setInterval(\'nextTestimonial()\','.$config['testimonials_interval'].');
		});
		
		var curTestimonial=0;
		var testimonials=Array();
		'.$testimonials.'
		
			
		var var_index=1;
		</script>
	',
	'menu_selected' => 'home',
	'breadcrumb' => array('Home'=>'/'),
	
	'index' => true,
	'grey_bar' => 'Need catering?<br />We\'ve got you covered...',
	);


$areas=array();
$res = mysql_query('SELECT label, value FROM website_editable_areas WHERE label LIKE "homepage_%" OR label = "twitter_widget"');
while($log = mysql_fetch_assoc($res)) {
	$areas[$log['label']]=$log['value'];
}


require 'header.php';

?>
	
	<div id="divHomeFeaturedIn">
	<div>
	<a href="http://www.nytimes.com/2011/09/25/technology/internet/lunch-catered-by-internet-middlemen.html" target="_blank"><img src="http://cater2.me/template/images/custom/nytsmall.png" /></a>
	<a href="http://www.7x7.com/tech-gadgets/san-francisco-startup-cater2me-helps-street-food-vendors-connect-tech-companies" target="_blank"><img src="http://cater2.me/template/images/custom/7x7sflogo.png" /></a>
	<a href="http://techcrunch.com/2012/03/09/cater2-me-feeds-startups/" target="_blank"><img src="http://cater2.me/template/images/custom/techcrunch1.png" /></a>
		</div>
	</div>

<div class="grid_12" id="divHomeIconsLeft">
	<?=plain2Html($areas['homepage_6icons_title'])?>
</div>


	<div class="container_12 home_icons">
		<div class="grid_2">
			<img src="/template/images/custom/home_icon_1_off.png" alt="Farmers Market" width="120" height="120" />
			<div>Farmers' Market Purveyors</div>
		</div>
		<div class="grid_2">
			<img src="/template/images/custom/home_icon_2_off.png" alt="Local Chefs" width="120" height="120" />
			<div>Local Chefs</div>
		</div>
		<div class="grid_2">
			<img src="/template/images/custom/home_icon_3_off.png" alt="Top restaurants" width="120" height="120" />
			<div>Top Restaurants</div>
		</div>
		<div class="grid_2">
			<img src="/template/images/custom/home_icon_4_off.png" alt="Pop-up restaurants" width="120" height="120" />
			<div>Pop-up Restaurants</div>
		</div>
		<div class="grid_2">
			<img src="/template/images/custom/home_icon_5_off.png" alt="Hot Food Startups" width="120" height="120" />
			<div>Hot Food Startups</div>
		</div>
		<div class="grid_2">
			<img src="/template/images/custom/home_icon_6_off.png" alt="Food Trucks" width="120" height="120" />
			<div>Food Trucks</div>
		</div>
	</div>
	


		<div class="clear"></div><br /><br />
		<div class="grid_2"><h3>Cater2.me blog</h3></div>
		
		<div class="grid_10">
			<div class="hr-pattern"></div> <!-- Horizontal Line -->
		</div>
	
		<div class="clear"></div>
		
		<div id="home-blog-post-wrap">
		
		<div id="home-blog" class="grid_8">
			
			<?
				//$res=mysql_query('SELECT * FROM website_blog_posts ORDER BY id_blog_post DESC LIMIT 1');
				//$post=mysql_fetch_assoc($res);
			?>
			
			<h3><?=plain2Html($areas['homepage_event_spotlight_title'])?></h3>
		
			<div class="grid_2 alpha image-fade">
				<img src="/template/images/custom/home_event_spotlight.jpg" alt="" />
			</div>
			
			<div class="home-post-content grid_6 omega">
			<p> <?=plain2Html($areas['homepage_event_spotlight'])?>
			</p>
			</div>
			
		
		</div> <!-- end #home-blog .grid_9 -->

		
		<!-- BEGIN BLOG POST LIST -->
		<div id="blog-list" class="grid_4 omega">
		<h3>Twitter</h3>

		<?=$areas['twitter_widget'];?>
		
		</div><!-- end .blog-item -->
		
		</div><!-- end #home-blog-post-wrap -->

<?

require 'footer.php';
