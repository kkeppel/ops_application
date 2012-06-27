<?php
/**
 * The Template for displaying single portfolio posts.
 *
 * @package WordPress
 * @subpackage Bowtie
 */

get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<?php $my_meta = get_post_meta($post->ID,'_my_meta',TRUE); //Check if post has a call to action sentence in the post meta box
		if(!empty($my_meta)) { // if cta meta box has info ?>
		
	<!-- BEGIN CALL TO ACTION -->
	<div class="inner-cta-wrap">
		<div id="call-to-action" class="container_12">

			<!-- TOP SENTENCE -->
			<div id="cta-top" class="grid_12">
				<h2 class="inner-title">
					<?php echo $my_meta['cta']; // display cta meta info ?>
				</h2>
			</div> <!-- end #cta-top .grid_6 .alpha -->
			
		</div> <!-- end .container_12 #call-to-action -->
	</div><!-- end .cta-wrap -->
	
	<?php } else { } // If no top title is entered, go onto the main content ?>
	
	<div class="clear"></div>
	
	<!-- Begin Main Body -->
	<div class="container_12" id="body-wrap" role="main">
	
		<div id="breadcrumb-wrap" class="grid_12 breadcrumbs">
			<?php if(function_exists('bcn_display')) {  bcn_display(); } ?>
		</div> <!-- end #breadcrumb-wrap .grid_12 -->
		
		<div id="post-content-wrap" class="portfolio-single grid_12">

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
		
			<div class="featured-image image-fade" style="<?php if ( get_post_meta($post->ID, 'use_video', true) == 'on' ){ ?>height:294px; <?php } ?>">
			
				<?php if (has_post_thumbnail()) { /* if the post has a featured image */ 
					$blog_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), ''); // Get original image size
					$thumb = get_post_thumbnail_id(); 
					$image = vt_resize( $thumb,'' , 934, 294, true ); // Resize original image
				?>
				
					  <?php if ( get_post_meta($post->ID, 'use_video', true) == 'on' ){ // check if post is using video

						switch(get_post_meta($post->ID, 'pf_video', true)){
							case 'youtube': // Display Youtube Video
							$link = 'http://www.youtube.com/watch?v='.get_post_meta($post->ID, 'youtube_id', true).'&amp;feature=player_embedded#at=41';
							$id = ' id="tube'.$post->ID.'" ';
							break;
						case 'vimeo': // Display Vimeo Video
							$link = 'http://vimeo.com/'.get_post_meta($post->ID, 'vimeo_id', true);
							$id = ' id="vimeo'.$post->ID.'" ';
							break;
						case 'dailymotion': // Display DailyMotion Video
							$link = 'http://www.dailymotion.com/video/'.get_post_meta($post->ID, 'dailymotion_id', true);
							$id = ' id="daily'.$post->ID.'" ';
							break;  
						}       
					$class = ' ';
					}
					else{
						$link =  $blog_image_url[0];
						$class = ' class="portfolio" ';
					} ?>
					
				<a <?php echo $id; ?> <?php echo $class; ?> href="<?php echo $link; ?>">
				
					<img class="omega" src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" title="<?php _e('Click to view image','bowtie') ?>" />
					
					<?php if ( get_post_meta($post->ID, 'use_video', true) == 'on' ){ // check if post is using video and add play it if true ?>
						<img class="play-button" src="<?php bloginfo('template_directory'); ?>/images/video-play.png" alt="" />
					<?php } ?>
							
				</a>
				
			</div> <!-- end .featured-image .image-fade -->
					
			<?php } ?>
			
			<?php // get all the meta data
				$client = get_post_meta($post->ID,'client_value',TRUE);
				$date = get_post_meta($post->ID,'date_value',TRUE); 
				$tasks = get_post_meta($post->ID,'tasks_value',TRUE); 
				$extra = get_post_meta($post->ID,'extra_value',TRUE); 
			?>
			
			<?php if( $client || $data || $tasks || $extra ) { // check if any of the meta fields have data ?>
			
					<div class="grid_3 alpha" style="margin-top:20px;">	
					
					<h4 class="details"><?php _e('Details:','bowtie'); ?></h4>					
					<hr style="margin-bottom:20px;" />
					
					<!-- Client Meta -->
					<?php  if(!empty($client)) { // if client meta box has info ?>
						<div class="client"><?php echo $client ?></div>
							<?php } else { } //if no data, display nothing ?>

					<!-- Date Meta -->
					<?php if(!empty($date)) { // if date meta box has info ?>
						<div class="calendar"><?php echo $date ?></div>
							<?php } else { } //if no data, display nothing ?>

					<!-- Tasks Meta -->
					<?php if(!empty($tasks)) { // if tasks meta box has info ?>
						<div class="services"><?php echo $tasks ?></div>
							<?php } else { } //if no data, display nothing?>
							
					<!-- Extra Meta -->
					<?php if(!empty($extra)) { // if tasks meta box has info ?>
						<div class="extra"><?php echo $extra ?></div>
							<?php } else { } //if no data, display nothing?>
						<div> <span><?php edit_post_link( __('edit', 'bowtie'), '<span class="edit-post">[', ']</span>' ); ?></span></div>
							
					</div> <!-- end .grid_3 Portfolio Meta Details -->
					
			<?php } //end check for meta data ?>
			
			<div id="content" class="<?php if ( $client || $data || $tasks || $extra ) { echo 'grid_9'; } else { echo 'grid_12'; } ?>" style="margin-top:30px;" >

				<h3 class="post-title">
					<?php the_title() ?>
				</h3>

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