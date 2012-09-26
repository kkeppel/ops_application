<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Bowtie
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
		
		<?php $sidebar_position = of_get_option('sidebar_position'); ?>

		<?php if ($sidebar_position == 'left') { ?>

			<div id="sidebar" class="grid_4 suffix_1 alpha">
		
			<?php include (TEMPLATEPATH.'/sidebar-generator.php'); ?>
	
			</div> <!-- end #sidebar .grid_4 -->
	
		<?php } ?>
		
		<div id="post-content-wrap" class="<?php if($sidebar_position == 'right') { echo 'grid_7 suffix_1'; } elseif($sidebar_position == 'left') { echo 'grid_7'; } ?> single-post">

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
		
			<h3 class="post-title"><?php the_title() ?></h3>
			
					<!-- Post Meta -->
					<div class="meta">
						<ul>
							<li class="published"><?php _e('Published on', 'bowtie') ?> <?php the_time('F jS, Y'); ?></li>
							<li class="author">&nbsp;<?php _e('by', 'bowtie') ?> <?php the_author_posts_link(); ?></li>
							<li class="entry-categories">&nbsp;<?php _e('in', 'bowtie') ?> <?php the_category(', '); ?></li>
							<li class="comment-count">&nbsp; | <?php comments_popup_link(__('No Comments', 'bowtie'), __('1 Comment', 'bowtie'), __('% Comments', 'bowtie')); ?></li>
						<!-- <li> -->
							<?php if ( current_user_can( 'edit_post', $post->ID ) ): // check if user is logged in and has editing permissions ?>
							<?php edit_post_link( __('edit', 'bowtie'), '<li class="edit-post">&nbsp;[', ']</li>' ); ?>	
							<?php endif; ?>
						<!-- </li> -->
						</ul>
					</div> <!-- end .meta -->
			
			<!-- Featured Image -->
			<!-- end .featured-image .image-fade -->
					
					
			<div id="content">

				<?php the_content(); ?>
			
			</div> <!-- end #content -->
			
			<div class="clear"></div>
			
			<?php if (has_tag()) { //check if post has tags ?> 
			<div id="post-tags">
				<?php the_tags('Tags: ',', '); ?>
			<?php } else { ?>
			<!-- If post does not have tags, change tag area style -->
			<div id="post-tags" style="height:0px;border-top:none;">
			<?php } ?>
			</div> <!-- end #post-tags -->
			
		<?php $author_choice = of_get_option('author_choice');
			if ($author_choice == 'true' && get_the_author_meta( 'description' )) : ?>
				
			<div id="post-author">
			<div class="hr-pattern"></div>
			
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'bowtie_author_bio_avatar_size', 70 ) ); ?>
				</a>
				
				<div id="author-details">
					
					<p>
					<?php _e('Written by','bowtie'); ?>
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
						<?php printf( __( '%s ', 'bowtie' ), get_the_author() ); ?></a>
					</p>	
			
					<?php the_author_meta( 'description' ); ?>
				
				</div><!-- end #author-details -->
				
			<div class="clear"></div>
			<div class="hr-pattern"></div>
			
			</div><!-- end #post-author -->
			
			<?php endif; ?>
			
		</div> <!-- end <?php post_class() ?> #post-<?php the_ID(); ?> -->
		
		<?php comments_template('', true); ?>

		<?php endwhile; else: ?>
			
			<!-- If we can't find anything  -->
			<div id="post-0" <?php post_class() ?>>
				
				<h3 class="post-title"><?php _e('Error 404 - Not Found', 'bowtie') ?></h3>
				
				<div class="content">
					<p><?php _e('Sorry, but you are looking for something that isn\'t here.', 'bowtie') ?></p>
				</div> <!-- end .content -->
				
			<!--END #post-0-->
			</div> <!-- end <?php post_class() ?> #post-0 -->
				
		<?php endif; ?>
			
		</div><!-- end #post-content-wrap .grid_7 .suffix_1 -->
		
	<?php if ($sidebar_position == 'right') { ?>

		<div id="sidebar" class="grid_4">
		
		<?php include (TEMPLATEPATH.'/sidebar-generator.php'); ?>
	
		</div> <!-- end #sidebar .grid_4 -->
	
	<?php } ?>
	
	</div> <!-- end #body-wrap .container_12 -->
	
	<div class="clearfix"></div>

<?php get_footer(); ?>