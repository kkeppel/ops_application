<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage Bowtie
 */
?>
<style type="text/css" media="screen">
	#social-wrap {
	  background-image:url(http://cater2.me/template/images/bg-social2.png);
	  background-position:0 0;
	  background-repeat:repeat no-repeat;
	  height:51px;
	  width:100%;
	}
	#expand-button {
	  background-image:url(http://cater2.me/template/images/expand.jpg);
	  background-position:0 0;
	  background-repeat:no-repeat no-repeat;
	  height:23px;
	  margin-left:10px;
	  width:73px;
	}
	style.css
	
</style>

	<div class="clear"></div>

	<footer>
	<?php $footer_choice = of_get_option('footer_choice');
	if($footer_choice == 'true') { ?> 
	
	<?php $dropdown_choice = of_get_option('footer_dropdown_choice');
		if($dropdown_choice == 'true') { ?> 
	<div id="home-widgets-wrap" class="open-content">
	
		<div id="home-widgets" class="container_12 clearfix">
			
			<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('footer-widgets')) : // check for 'footer-widgets' and display if exists ?> 
			
			<?php else : // if no 'cta-widgets' then display placeholder text ?>
			
			<?php include (TEMPLATEPATH.'/includes/placeholder/sidebar-footer.php'); ?>
			
			<?php endif; // end 'footer-widgets' check ?>
			
		</div> <!-- end #home-widgets .container_12 -->
			
	</div> <!-- end #home-widgets-wrap -->
	
	<?php } elseif ($dropdown_choice == 'false') { ?>
	
	<div id="home-widgets-wrap">
	
		<div id="home-widgets" class="container_12 clearfix">
		
			<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('footer-widgets')) : // check for 'footer-widgets' and display if exists ?> 
			
			<?php else : // if no 'cta-widgets' then display placeholder text ?>
			
			<?php include (TEMPLATEPATH.'/includes/placeholder/sidebar-footer.php'); ?>
			
			<?php endif; // end 'footer-widgets' check ?>
			
		</div> <!-- end #home-widgets .container_12 -->
			
	</div> <!-- end #home-widgets-wrap -->
	
	<?php } ?>
	
<?php } elseif ($footer_choice == 'false') {} //nada ?>
	
	<div class="clear"></div>
	
		<div id="social-wrap">
			<div id="social-icons" class="container_12">
				<ul class="grid_10 omega">
				
					<!-- TWITTER -->
					<?php $twitter_name = of_get_option('twitter_username');
						if(!$twitter_name) { /* nada */ } else { ?> 
				
					<li id="twitter">
					<a href="http://twitter.com/<?php echo $twitter_name ?>" title="<?php echo of_get_option('twitter_title'); ?>">
						<div class="fadeThis">
							<span class="hover"></span>
						</div>
					</a>
					</li>
					
					<?php } ?> 
					<!-- end Twitter -->
					
<!-- CONTACT -->
					<?php $contact_link = of_get_option('contact_link');
						if(!$contact_link) { /* nada */ } else { ?> 
						
					<li id="contact">
					<a href="<?php echo $contact_link ?>" title="<?php echo of_get_option('contact_title'); ?>">
						<div class="fadeThis">
							<span class="hover"></span>
						</div>
					</a>
					</li>
					
					<?php } ?> 
					<!-- end Contact -->
					
					<!-- FACEBOOK -->
					<?php $facebook_link = of_get_option('facebook_link');
						if(!$facebook_link) { /* nada */ } else { ?> 
					
					<li id="facebook">
					<a href="<?php echo $facebook_link ?>" title="<?php echo of_get_option('facebook_title'); ?>">
						<div class="fadeThis">
							<span class="hover"></span>
						</div>
					</a>
					</li>
					
					<?php } ?> 
					<!-- end Facebook -->
					
					<!-- LINKEDIN -->
					<?php $linkedin_link = of_get_option('linkedin_link');
						if(!$linkedin_link) { /* nada */ } else { ?> 
					
					<li id="linkedin">
					<a href="<?php echo $linkedin_link ?>" title="<?php echo of_get_option('linkedin_title'); ?>">
						<div class="fadeThis">
							<span class="hover"></span>
						</div>
					</a>
					</li>
					
					<?php } ?> 
					<!-- end Linkedin -->
				
					<!-- DRIBBBLE -->
					<?php $dribbble_link = of_get_option('dribbble_link');
						if(!$dribbble_link) { /* nada */ } else { ?> 
						
					<li id="dribbble">
					<a href="<?php echo $dribbble_link ?>" title="<?php echo of_get_option('dribbble_title'); ?>">
						<div class="fadeThis">
							<span class="hover"></span>
						</div>
					</a>
					</li>
	
					<?php } ?> 
					<!-- end Dribbble -->
				
					<!-- FORRST -->
					<?php $forrst_link = of_get_option('forrst_link');
						if(!$forrst_link) { /* nada */ } else { ?> 
						
					<li id="forrst">
					<a href="<?php echo $forrst_link ?>" title="<?php echo of_get_option('forrst_title'); ?>">
						<div class="fadeThis">
							<span class="hover"></span>
						</div>
					</a>
					</li>
					
					<?php } ?> 
					<!-- end Forrst -->
					
					<!-- GOOGLE -->
					<?php $google_link = of_get_option('google_link');
						if(!$google_link) { /* nada */ } else { ?> 
						
					<li id="google">
					<a href="<?php echo $google_link ?>" title="<?php echo of_get_option('google_title'); ?>">
						<div class="fadeThis">
							<span class="hover"></span>
						</div>
					</a>
					</li>
					
					<?php } ?> 
					<!-- end Google -->

					<!-- RSS -->
					<?php $rss_link = of_get_option('rss_link');
						if(!$rss_link) { /* nada */ } else { ?> 
						
					<li id="rss">
					<a href="<?php echo $rss_link ?>" title="<?php echo of_get_option('rss_title'); ?>">
						<div class="fadeThis">
							<span class="hover"></span>
						</div>
					</a>
					</li>
					
					<?php } ?> 
					<!-- end RSS -->

					
				</ul>
					
					<!-- SHARE THIS SITE -->
					<div id="share" class="grid_2">
					
					<?php $sharethis_code = of_get_option('sharethis_code');
						if(!$sharethis_code) { /* nada */ } else { ?> 

						<div class="fadeThis">
							<span class="hover"></span>
							<a id="various1" href="#inline1" title="Share this website with the world!" ><span><?php _e('Share this site','bowtie'); ?></span></a>
						</div>

						<div class="hidden">
							<div id="inline1">
								<?php echo stripslashes($sharethis_code) ?>
							</div> <!-- end #inline1 -->
						</div> <!-- end .hidden -->
						
					<?php } ?> 
							
					</div> <!-- end #share .grid_2 -->
				
			</div><!-- end .container_12 -->
		</div> <!-- end #social-wrap -->
		
		<div id="copyright-wrap" class="clearfix">
			
			<div class="container_12">
						
				<div id="copyright" class="grid_12 omega">
					<p>Copyright &#169; <?=date('Y')?> Cater2.me -  All rights reserved</p>
					<ul class="footer-nav">
						<li><a href="/">Home</a></li>
						<li><a href="/about/">About Us</a></li>
						<li><a href="/contact/">Contact Us</a></li>
						<li><a href="/event-spotlight/">Events</a></li>
						<li><a href="/jobs/">Jobs</a></li>
						<li><a href="mailto:<?=$config['public_email']?>">Help</a></li>
					</ul><!-- end .footer-nav -->
				</div>
				</div> <!-- end #copyright -->
				
			</div><!-- end .container_12 -->
			
		</div> <!-- end #footer-widget-wrap -->
		
	</footer>

	<!-- Your ShareThis Scripts | http://sharethis.com -->
	<script type="text/javascript">var switchTo5x=false;</script><script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher:'<?php echo of_get_option('sharethis_id'); ?>'});</script>

	<!-- Nivo Slider Options -->
	<?php $slider_choice = of_get_option('slider_choice'); //Get the slider choice 
	if ( is_front_page() && $slider_choice == 'nivo') {  require_once(TEMPLATEPATH . '/includes/nivo.php'); } ?>
	
	<!-- Content Slider Options -->
	<?php $slider_choice = of_get_option('slider_choice'); //Get the slider choice 
	if ( is_front_page() && $slider_choice == 'content') { require_once(TEMPLATEPATH . '/includes/slides.php'); } ?>

<?php // Check how to implement the nav hover effect 
	$nav_choice = of_get_option('nav_choice');
	if($nav_choice == 'title') { 
	
	include (TEMPLATEPATH.'/includes/magicline_title.php');
	
	} elseif($nav_choice == 'rel') {

	include (TEMPLATEPATH.'/includes/magicline_rel.php');
	
	} elseif($nav_choice == 'none'){ 
	
	include (TEMPLATEPATH.'/includes/magicline_none.php');
	
	} else {} ?> 
	
<?php 
// Display Theme version in footer sourcecode 
// Used for debugging and support
$themeversion = get_theme_data(STYLESHEETPATH . '/style.css');
$themeversion = $themeversion['Version']; ?>
<!-- This is version <?php echo $themeversion ?> -->
	
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>