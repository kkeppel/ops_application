<?php
/*
Template Name: Full Width
*/
get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<!-- Check if post has a call to action sentence in the post meta box -->
	<?php $my_meta = get_post_meta($post->ID,'_my_meta',TRUE);
		if(!empty($my_meta)) { // if cta meta box has info ?>
		
	<!-- BEGIN CALL TO ACTION -->
	<div class="inner-cta-wrap">
		<div id="call-to-action" class="container_12">

			<!-- TOP SENTENCE -->
			<div id="cta-top" class="grid_12">
				<h2 class="inner-title">
				<?php 
					echo $my_meta['cta']; // display cta meta info ?>
				</h2>
			</div> <!-- end #cta-top .grid_6 .alpha -->
			
		</div> <!-- end .container_12 #call-to-action -->
	</div><!-- end .cta-wrap -->
	
	<?php } else { // Otherwise, display a simple and elegant horizontal line ?>
		<div class="cta-empty">
			<hr />
		</div> <!-- end .cta-empty -->
	<?php } ?>
	
	<div class="clear"></div>
	
	<!-- Begin Main Body -->
	<div class="container_12" id="body-wrap" role="main">
	
		<div id="breadcrumb-wrap" class="grid_12 breadcrumbs">
			<?php if(function_exists('bcn_display')) {  bcn_display(); } ?>
		</div> <!-- end #breadcrumb-wrap .grid_12 -->
		
		<div id="post-content-wrap" class="grid_12">

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
		
			<h3 class="post-title"><?php the_title() ?></h3>
			
			<!-- Featured Image -->
			<?php if (has_post_thumbnail()) { /* if the post has a featured image */ 
				$blog_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), ''); // Get original image size
				$thumb = get_post_thumbnail_id(); 
				$image = vt_resize( $thumb,'' , 934, 294, true ); // Resize original image
			?>
				
			<div class="featured-image image-fade">
			
				<a class="portfolio" href="<?php echo $blog_image_url[0]; ?>">
					<img class="omega" src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" title="<?php _e('Click to view image','bowtie') ?>" />
				</a>
				
			</div> <!-- end .featured-image .image-fade -->
				
				<?php } // end check for featured image ?>
					
			<div id="content">
			
				<?php the_content(); ?>
			
			</div> <!-- end #content -->
			
		</div> <!-- end <?php post_class() ?> #post-<?php the_ID(); ?> -->

		<?php endwhile; else: ?>
			
			<!-- If we can't find anything  -->
			<div id="post-0" <?php post_class() ?>>
				
				<h3 class="post-title"><?php _e('Error 404 - Not Found', 'bowtie') ?></h3>
				
				<div class="content">
					<p><?php _e("Sorry, but you are looking for something that isn't here.", "bowtie") ?></p>
				</div> <!-- end .content -->
				
			<!--END #post-0-->
			</div> <!-- end <?php post_class() ?> #post-0 -->
				
		<?php endif; ?>
			
		</div><!-- end #post-content-wrap .grid_12 -->
	
	</div> <!-- end #body-wrap .container_12 -->
	
	<div class="clearfix"></div>

<?php get_footer(); ?>