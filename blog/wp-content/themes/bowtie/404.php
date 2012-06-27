<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Bowtie
 */
 
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");

get_header(); ?>

	<!-- BEGIN CALL TO ACTION -->
	<div class="inner-cta-wrap">
		<div id="call-to-action" class="container_12">
			
			<!-- TOP SENTENCE -->
			<div id="cta-top" class="grid_12">
				<h2 class="inner-title">
				<?php if(of_get_option('error_title') != '') { // if the blog title is not empty ?>
				<?php echo stripslashes(of_get_option('error_title')); ?>
				<?php } else { ?>
				<span style="font-size:30px;">Set this title in the theme options panel under 'Pages'!</span>
				<?php } ?>
				</h2>
			</div> <!-- end #cta-top .grid_6 .alpha -->
			
		</div> <!-- end .container_12 #call-to-action -->
	</div><!-- end .cta-wrap -->
	
	<div class="clear"></div>
	
	<!-- Begin Main Body -->
	<div class="container_12" id="body-wrap" role="main">
	
		<div id="breadcrumb-wrap" class="grid_12 breadcrumbs">
			<?php if(function_exists('bcn_display')) {  bcn_display(); } ?>
		</div> <!-- end #breadcrumb-wrap .grid_12 -->

		<div id="post-content-wrap" class="grid_12">
		<div class="error-page grid_6 alpha">
			<h1 class="title-404"><?php _e( 'oops! Not Found.', 'bowtie' ); ?></h1>
			<p class="subtitle-404"><?php _e('Try to search or a link from the sitemap instead', 'bowtie'); ?> &rarr; </p>
			<img src="<?php bloginfo('template_directory'); ?>/images/404-arrows.png" alt="" />
		</div><!-- end .error-page -->
		
		<div class="grid_5 prefix_1 omega">
			<h3> <?php _e('Search the Site', 'bowtie'); ?> </h3>
		<?php get_search_form(); ?>
		
		<div class="hr-pattern" style="margin:20px 0;"></div>
		
		<script type="text/javascript">
			// focus on search field after it has loaded
			document.getElementById('s') && document.getElementById('s').focus();
		</script>
		
		<h3><?php _e('Site Pages','bowtie'); ?></h3>
			<ul>
				<?php wp_list_pages('sort_column=post_title&title_li='); ?>
			</ul>
		</div> <!-- end .grid_5 -->
	
		</div><!-- end #post-content-wrap .grid_12 -->
	
	</div> <!-- end #body-wrap .container_12 -->
	
	<div class="clear"></div>

<?php get_footer(); ?>