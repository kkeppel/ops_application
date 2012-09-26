<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
	<!-- Check if page has a call to action sentence in the page meta box -->
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
		
			<?php  include (TEMPLATEPATH.'/sidebar-generator.php'); ?>
	
			</div> <!-- end #sidebar .grid_4 -->
	
		<?php } ?>
		
		<div id="post-content-wrap" class="<?php if($sidebar_position == 'right') { echo 'grid_7 suffix_1'; } elseif($sidebar_position == 'left') { echo 'grid_7'; } ?>">
				
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					
					<!--BEGIN .entry-content -->
					<div class="entry-content">
                    
						<?php the_content(); ?>
						
					<!--END .entry-content -->
					</div>
					
					<!--BEGIN .archive-lists -->
					<div class="archive-lists">
						
						<h4><?php _e('Last 20 Posts', 'bowtie') ?></h4>
						
						<ul>
						<?php $archive_20 = get_posts('numberposts=20');
						foreach($archive_20 as $post) : ?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
						<?php endforeach; ?>
						</ul>
						
						<h4><?php _e('Archives by Month', 'bowtie') ?></h4>
						
						<ul>
							<?php wp_get_archives('type=monthly'); ?>
						</ul>
			
						<h4><?php _e('Archives by Subject', 'bowtie') ?></h4>
						
						<ul>
					 		<?php wp_list_categories( 'title_li=' ); ?>
						</ul>
					
					<!--END .archive-lists -->
					</div>
                
                <!--END .hentry-->  
				</div>
				
				<?php endwhile; else: ?>

				<!--BEGIN #post-0-->
				<div id="post-0" <?php post_class() ?>>
				
					<h1 class="entry-title"><?php _e('Error 404 - Not Found', 'bowtie') ?></h1>
				
					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e("Sorry, but you are looking for something that isn't here.", "bowtie") ?></p>
					<!--END .entry-content-->
					</div>
				
				<!--END #post-0-->
				</div>

			<?php endif; ?>
			
                	<?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>
                    <!--BEGIN .entry-meta .entry-header-->
					<hr />
					<div class="entry-meta entry-header">
						<?php edit_post_link( __('edit', 'bowtie'), '<span class="edit-post">[', ']</span>' ); ?>
					<!--END .entry-meta .entry-header-->
                    </div>
                    <?php endif; ?>

			</div><!-- end #post-content-wrap .grid_7 .suffix_1 -->

	<?php if ($sidebar_position == 'right') { ?>

		<div id="sidebar" class="grid_4" style="margin-top:-5px;">
		
		<?php  include (TEMPLATEPATH.'/sidebar-generator.php'); ?>
	
		</div> <!-- end #sidebar .grid_4 -->
	
	<?php } ?>

	</div> <!-- end #body-wrap .container_12 -->
	
	<div class="clearfix"></div>

<?php get_footer(); ?>