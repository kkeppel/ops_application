<?
require 'lib/core.php';

$template = array(
	'title' => 'Cater2.me | Welcome',
	'header_resources' => '
	<!-- Content Slider -->
	<script src="/template/js/slides.min.jquery.js"></script>
	
		<link rel="stylesheet" href="/template/css/custom/tipTip.css" />
		<script src="/template/js/custom/jquery.tipTip.minified.js"></script>
		<script>
		$(document).ready(function() {
		$(".tiptip").tipTip({delay:50});
		});
		
		
		var var_index=1;
		</script>
	',
	'menu_selected' => 'home',
	'breadcrumb' => array('Home'=>'/'),
	
	'index' => true,
	'grey_bar' => 'Welcome to cater2.me<br />Second line',
	);

require 'header_test_3.php';


$areas=array();
$res = mysql_query('SELECT label, value FROM website_editable_areas WHERE label LIKE "homepage_%"');
while($log = mysql_fetch_assoc($res)) {
	$areas[$log['label']]=$log['value'];
}


?>

<div class="grid_12" id="divHomeIconsLeft">
	Our catering partners have
	been featured on the Food
	Network, in 7x7 Magazine,
	SF Weekly, SFGate, The
	New York Times, The Wall
	Street Journal, and other
	publications. Our unique
	providers include:
</div>
<!--
<div class="grid_6 prefix_1" id="divHomeIconsRight">
	<div class="grid_3 alpha"> <img src="/template/images/custom/icon-home.png" /> aaaa </div>
	<div class="grid_3 omega"> <img src="/template/images/custom/icon-home.png" /> bbbb</div>
	<div class="grid_3 alpha"> <img src="/template/images/custom/icon-home.png" /> cccc</div>
	<div class="grid_3 omega"> <img src="/template/images/custom/icon-home.png" /> dddd</div>
	<div class="grid_3 alpha"> <img src="/template/images/custom/icon-home.png" /> eeee</div>
	<div class="grid_3 omega"> <img src="/template/images/custom/icon-home.png" /> ffff</div>
</div>
-->

	<!-- Begin Portfolio Items -->
	<div class="container_12" id="home-portfolio" role="main">
	<ul id="portfolio">
		<!-- 4th PORTFOLIO ITEM -->
		<li class="marketing integration portfolio_three_columns grid_2">
		
			<div class="featured-image mosaic-block_c2me fade">

				<a href="#" target="_blank" class="mosaic-overlay portfolio">
					<div class="details">
						<h4>About Nec Sagittis Auctor</h4>
						<p>This is a short description of who or what this portfolio is about. Lorem ispsum dolar sit emit.</p>
					</div> <!-- end .details -->
				</a> <!-- end .mosaic-overlay -->
			
				<div class="mosaic-backdrop"><img src="/template/images/custom/icon-home.png" alt="portfolio-item" width="120" height="120" /></div><!-- end .mosaic-backdrop -->
			
			</div><!-- end .mosaic-block .fade  -->
		
			<h4><a href="#">Nec Sagittis Auctor</a></h4>
			<p>Marketing</p>
			
		</li> <!-- end .portfolio_three_columns -->
		<!-- 4th PORTFOLIO ITEM -->
		<li class="marketing integration portfolio_three_columns grid_2">
		
			<div class="featured-image mosaic-block_c2me fade">

				<a href="#" target="_blank" class="mosaic-overlay portfolio">
					<div class="details">
						<h4>About Nec Sagittis Auctor</h4>
						<p>This is a short description of who or what this portfolio is about. Lorem ispsum dolar sit emit.</p>
					</div> <!-- end .details -->
				</a> <!-- end .mosaic-overlay -->
			
				<div class="mosaic-backdrop"><img src="/template/images/custom/icon-home.png" alt="portfolio-item" width="120" height="120" /></div><!-- end .mosaic-backdrop -->
			
			</div><!-- end .mosaic-block .fade  -->
		
			<h4><a href="#">Nec Sagittis Auctor</a></h4>
			<p>Marketing</p>
			
		</li> <!-- end .portfolio_three_columns -->
		<!-- 4th PORTFOLIO ITEM -->
		<li class="marketing integration portfolio_three_columns grid_2">
		
			<div class="featured-image mosaic-block_c2me fade">

				<a href="#" target="_blank" class="mosaic-overlay portfolio">
					<div class="details">
						<h4>About Nec Sagittis Auctor</h4>
						<p>This is a short description of who or what this portfolio is about. Lorem ispsum dolar sit emit.</p>
					</div> <!-- end .details -->
				</a> <!-- end .mosaic-overlay -->
			
				<div class="mosaic-backdrop"><img src="/template/images/custom/icon-home.png" alt="portfolio-item" width="120" height="120" /></div><!-- end .mosaic-backdrop -->
			
			</div><!-- end .mosaic-block .fade  -->
		
			<h4><a href="#">Nec Sagittis Auctor</a></h4>
			<p>Marketing</p>
			
		</li> <!-- end .portfolio_three_columns -->
		<!-- 4th PORTFOLIO ITEM -->
		<li class="marketing integration portfolio_three_columns grid_2">
		
			<div class="featured-image mosaic-block_c2me fade">

				<a href="#" target="_blank" class="mosaic-overlay portfolio">
					<div class="details">
						<h4>About Nec Sagittis Auctor</h4>
						<p>This is a short description of who or what this portfolio is about. Lorem ispsum dolar sit emit.</p>
					</div> <!-- end .details -->
				</a> <!-- end .mosaic-overlay -->
			
				<div class="mosaic-backdrop"><img src="/template/images/custom/icon-home.png" alt="portfolio-item" width="120" height="120" /></div><!-- end .mosaic-backdrop -->
			
			</div><!-- end .mosaic-block .fade  -->
		
			<h4><a href="#">Nec Sagittis Auctor</a></h4>
			<p>Marketing</p>
			
		</li> <!-- end .portfolio_three_columns -->
		<!-- 4th PORTFOLIO ITEM -->
		<li class="marketing integration portfolio_three_columns grid_2">
		
			<div class="featured-image mosaic-block_c2me fade">

				<a href="#" target="_blank" class="mosaic-overlay portfolio">
					<div class="details">
						<h4>About Nec Sagittis Auctor</h4>
						<p>This is a short description of who or what this portfolio is about. Lorem ispsum dolar sit emit.</p>
					</div> <!-- end .details -->
				</a> <!-- end .mosaic-overlay -->
			
				<div class="mosaic-backdrop"><img src="/template/images/custom/icon-home.png" alt="portfolio-item" width="120" height="120" /></div><!-- end .mosaic-backdrop -->
			
			</div><!-- end .mosaic-block .fade  -->
		
			<h4><a href="#">Nec Sagittis Auctor</a></h4>
			<p>Marketing</p>
			
		</li> <!-- end .portfolio_three_columns -->
		<!-- 4th PORTFOLIO ITEM -->
		<li class="marketing integration portfolio_three_columns grid_2">
		
			<div class="featured-image mosaic-block_c2me fade">

				<a href="#" target="_blank" class="mosaic-overlay portfolio">
					<div class="details">
						<h4>About Nec Sagittis Auctor</h4>
						<p>This is a short description of who or what this portfolio is about. Lorem ispsum dolar sit emit.</p>
					</div> <!-- end .details -->
				</a> <!-- end .mosaic-overlay -->
			
				<div class="mosaic-backdrop"><img src="/template/images/custom/icon-home.png" alt="portfolio-item" width="120" height="120" /></div><!-- end .mosaic-backdrop -->
			
			</div><!-- end .mosaic-block .fade  -->
		
			<h4><a href="#">Nec Sagittis Auctor</a></h4>
			<p>Marketing</p>
			
		</li> <!-- end .portfolio_three_columns -->
	</ul> <!-- end #portfolio -->
		
	</div> <!-- end #home-portfolio .container_12 -->


		<div class="clear"></div><br /><br />
		<div class="grid_2"><h3>Latest Blog Post</h3></div>
		
		<div class="grid_10">
			<div class="hr-pattern"></div> <!-- Horizontal Line -->
		</div>
	
		<div class="clear"></div>
		
		<div id="home-blog-post-wrap">
		
		<div id="home-blog" class="grid_9">

			<h3><a href="#">Event spotlight</a></h3>
			<p class="home-meta">Posted: <?=date('F jS, Y', $areas['homepage_event_spotlight_posted'])?></p>
		
			<div class="grid_2 alpha image-fade">
				<a href="#"><img src="/template/images/sample/home-blog-image.jpg" alt="" /></a>
			</div>
			
			<div class="home-post-content grid_7 omega">
			<p> <?=plain2Html($areas['homepage_event_spotlight'])?>
				<span class="read-more"><a href="/event-spotlight/">read more &rarr;</a></span></p>
			</div>
		
		</div> <!-- end #home-blog .grid_9 -->

		
		<!-- BEGIN BLOG POST LIST -->
		<div id="blog-list" class="grid_3 omega">
		<h3>More from the blog</h3>
			<ul>
				<li class="grid_3">
					<a href="<?=$areas['homepage_event_spotlight_link1']?>"><img src="/template/images/sample/blog-list-image01.jpg" alt="" /></a>
					<h4><a href="<?=$areas['homepage_event_spotlight_link1']?>"><?=$areas['homepage_event_spotlight_link1_label']?></a></h4>

				</li>
				<li class="grid_3">
					<a href="<?=$areas['homepage_event_spotlight_link2']?>"><img src="/template/images/sample/blog-list-image02.jpg" alt="" /></a>
					<h4><a href="<?=$areas['homepage_event_spotlight_link2']?>"><?=$areas['homepage_event_spotlight_link2_label']?></a></h4>
				</li>
				<li  class="grid_3">
					<a href="<?=$areas['homepage_event_spotlight_link3']?>"><img src="/template/images/sample/blog-list-image03.jpg" alt="" /></a>
					<h4><a href="<?=$areas['homepage_event_spotlight_link3']?>"><?=$areas['homepage_event_spotlight_link3_label']?></a></h4>

				</li>

			</ul>
		
		</div><!-- end .blog-item -->
		
		</div><!-- end #home-blog-post-wrap -->

<?

require 'footer.php';
