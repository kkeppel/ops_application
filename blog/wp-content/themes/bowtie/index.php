<?php
/**
 *  Used for blog page when set in 'Reading > Posts page'
 *  
 * @package WordPress
 * @subpackage Bowtie
 */

get_header(); ?>
		
	<?php 
		// Check if blog page title is entered in theme options
		if(of_get_option('blog_title') != '' ) : // If there is a title, display it
	?>
	<!-- BEGIN CALL TO ACTION -->
	<div class="inner-cta-wrap">
		<div id="call-to-action" class="container_12">
			
			<!-- TOP SENTENCE -->
			<div id="cta-top" class="grid_12">
				<h2 class="inner-title">
				<?php if(of_get_option('blog_title') != '') : // if the blog title is not empty ?>
				<?php echo stripslashes(of_get_option('blog_title', 'bowtie' )); ?>
				<?php endif; // end check for blog title ?>
				</h2>
			</div> <!-- end #cta-top .grid_12-->
			
		</div> <!-- end .container_12 #call-to-action -->
	</div><!-- end .cta-wrap -->
	
	<?php else : ?>
	
	<hr />
	
	<?php endif; // end check for blog page title ?>
	
	<div class="clear"></div>

	<!-- Begin Main Body -->
	<div class="container_12" id="body-wrap" role="main">
	
		<div id="breadcrumb-wrap" class="grid_12 breadcrumbs">
			<?php if(function_exists('bcn_display')) {  bcn_display(); } ?>
		</div> <!-- end #breadcrumb-wrap .grid_12 -->
		
		<?php $sidebar_position = of_get_option('sidebar_position'); ?>

		<?php if ($sidebar_position == 'left') { ?>

			<div id="sidebar" class="grid_4 suffix_1 alpha">
		
			<?php get_sidebar(); ?>
	
			</div> <!-- end #sidebar .grid_4 -->
	
		<?php } ?>
	
		<div id="post-content-wrap" class="<?php if($sidebar_position == 'right') { echo 'grid_7 suffix_1'; } elseif($sidebar_position == 'left') { echo 'grid_7'; } ?> blog-content-wrap">
		
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div class="blog-page-post">
				
				<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">	
				
					<h3 class="blog-page-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'bowtie'), get_the_title()); ?>"> <?php the_title(); ?></a></h3>
					
			<?php if (has_post_thumbnail()) : /* if the post has a featured image */ ?>
									
					<!-- Post Meta -->
					<div class="blog-page-meta grid_2 alpha">
						<ul>
							<li class="calendar"><?php the_time( get_option('date_format') ); ?></li>
							<li class="comment-bubble"><?php comments_popup_link( __('No Comments','bowtie'), __('1 Comment','bowtie'), __('% Comments','bowtie') ); ?></li>
							<li class="cat-icon"><?php the_category(', '); ?></li>							
						</ul>
						
						<div class="clear"></div>
						
					<?php // Check if post has tags for related posts
						$tags = wp_get_post_tags($post->ID);
						if ($tags) {
					?>
						<span class="blog-tags"><?php _e('Tags:','bowtie'); ?></span>
							<p class="tags">
								<?php the_tags('',' ','<br />'); ?>
							</p>
					<?php } // end check if post has tags ?>
						
					</div> <!-- end .meta -->
					
			<div class="featured-image image-fade omega" style="margin-top:0;">
			
				<!-- Featured Image -->
				<?php 
					$blog_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), ''); // Get original image size
					$thumb = get_post_thumbnail_id(); 
					$image = vt_resize( $thumb,'' , 377, 157, true ); // Resize original image
				?>
					
				<a class="portfolio" href="<?php echo $blog_image_url[0]; ?>">
					<img class="omega" src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" title="<?php _e('Click to view image','bowtie'); ?>" />
				</a>
				
			</div> <!-- end .featured-image .image-fade -->

					<div class="clear"></div>
					
					<!-- Post Content -->
					<div class="content">
					
						<?php the_excerpt(); ?>
                        <a href="<?php the_permalink(); ?>" class="more-link"><?php _e('read more', 'bowtie'); ?> &rarr;</a>
					
					</div> <!-- end .content -->
					
			<?php else : // if there is no thumbnail, show a generic image holder ?>
			
				<div class="archive-wrap clearfix">
					<!-- Post Meta -->
					<div class="blog-page-meta grid_2 alpha">
						<ul>
							<li class="calendar"><?php the_time( get_option('date_format') ); ?></li>
							<li class="comment-bubble"><?php comments_popup_link( __('No Comments','bowtie'), __('1 Comment','bowtie'), __('% Comments','bowtie') ); ?></li>
							<li class="cat-icon"><?php the_category(', '); ?></li>							
						</ul>
						
						<div class="clear"></div>
						
					<?php // Check if post has tags for related posts
						$tags = wp_get_post_tags($post->ID);
						if ($tags) {
					?>
						<span class="blog-tags"><?php _e('Tags:','bowtie'); ?></span>
							<p class="tags">
								<?php the_tags('',' ','<br />'); ?>
							</p>
					<?php } // end check if post has tags ?>
						
					</div> <!-- end .meta -->
			
					<!-- Post Content -->
					<div class="content grid_5 omega">
					
						<?php the_excerpt(); ?>
                        <a href="<?php the_permalink(); ?>" class="more-link"><?php _e('read more', 'bowtie'); ?> &rarr;</a>
					
					</div> <!-- end .content -->
				</div> <!-- end .archive-wrap .clearfix -->
			
			<?php endif ?>
					
				<div class="hr-pattern"></div>
					
				</div> <!-- end .blog-page-post -->
                
				</div> <!-- end post ID <?php the_ID(); ?> -->
                
			<?php endwhile;
			wp_reset_postdata(); ?>

			<!-- Page Navigation  -->
			<div class="pagination wp-pagenavi">
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
				<?php wp_link_pages(); ?>
				<?php } ?>
			</div>

			<?php else : ?>

				<div id="post-0" <?php post_class(); ?>>
				
					<h2 class="entry-title"><?php _e('Error 404 - Not Found', 'bowtie') ?></h2>

					<div class="entry-content">
						<p><?php _e('Sorry, but you are looking for something that isn\'t here.', 'bowtie') ?></p>

					</div><!-- .entry-content -->

				</div><!-- end #post-0 -->

			<?php endif; ?>
			
		</div><!-- end #post-content-wrap .grid_7 .suffix_1 -->	

	<?php if ($sidebar_position == 'right') { ?>

		<div id="sidebar" class="grid_4">
		
		<?php get_sidebar(); ?>
	
		</div> <!-- end #sidebar .grid_4 -->
	
	<?php } ?>
		
	</div> <!-- end #body-wrap .container_12 -->
	
<?php get_footer(); ?>