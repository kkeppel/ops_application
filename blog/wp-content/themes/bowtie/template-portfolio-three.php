<?php
/**
 * Template Name: Portfolio Three Columns
 *
 * @package WordPress
 * @subpackage Bowtie
 */
get_header(); ?>

	<?php 
		// Check if portfolio page title is entered in theme options
		if(of_get_option('portfolio_title') != '' ) : // If there is a title, display it
	?>
	<!-- BEGIN CALL TO ACTION -->
	<div class="inner-cta-wrap">
		<div id="call-to-action" class="container_12">
			
			<!-- TOP SENTENCE -->
			<div id="cta-top" class="grid_12">
				<h2 class="inner-title">
				<?php if(of_get_option('portfolio_title') != '') : // if the blog title is not empty ?>
				<?php echo stripslashes(of_get_option('portfolio_title', 'bowtie' )); ?>
				<?php endif; // end check for portfolio title ?>
				</h2>
			</div> <!-- end #cta-top .grid_12-->
			
		</div> <!-- end .container_12 #call-to-action -->
	</div><!-- end .cta-wrap -->
	
	<?php else : ?>
	
	<hr />
	
	<?php endif; // end check for portfolio page title ?>
	
	<div class="clear"></div>
	
	<!-- Begin Main Body -->
	<div class="container_12" id="body-wrap" role="main">
	
		<div id="breadcrumb-wrap" class="grid_12 breadcrumbs">
			<?php if(function_exists('bcn_display')) {  bcn_display(); } ?>
		</div> <!-- end #breadcrumb-wrap .grid_12 -->
		
		<div id="post-content-wrap" class="grid_12">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <div class="entry-content">
                <?php the_content(); ?>
            </div><!-- end .entry-content -->
				
		<div class="grid_1 alpha omega">
			<span class="sort"><?php _e('Sort', 'bowtie'); ?></span>
		</div><!-- end .grid_1 .alpha .omega -->
        
		<div class="grid_11 alpha">
            <ul id="filter" class="clearfix">
                <li class="segment-1"><a class="current all" data-value="all" href="#"><?php _e('All', 'bowtie'); ?></a></li>
                <?php wp_list_categories(array('title_li' => '', 'taxonomy' => 'skill-type', 'walker' => new jg_Walker_Category_Filter())); ?>
            </ul>	
        </div> <!-- end .grid_11 -->     

		<div class="clear"></div>
		<!-- <div class="hr-pattern"></div>	-->

        <?php endwhile; endif; ?>
            
        <?php $query = new WP_Query(); 
			  $query->query('post_type=portfolio&posts_per_page=-1'); ?>
            	
                <!--BEGIN #columns-wrap-->
            	<ul id="portfolio" class="three-columns">
                
                <?php $count = 0; ?>
                <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                
				$terms = get_the_terms( get_the_ID(), 'skill-type' );  ?> 

					<li data-id="id-<?php echo $count; ?>" class="<?php foreach ($terms as $term) { echo strtolower(preg_replace('/\s+/', '-', $term->name)). ' '; } ?> portfolio_three_columns grid_4 alpha" >
					
					<!-- Start Portfolio Item -->
                    <div <?php post_class(); ?> id="post-<?php the_ID(); ?>" style="clear:both;overflow:hidden;">	

					<div class="featured-image image-fade" style="<?php if ( get_post_meta($post->ID, 'use_video', true) == 'on' ){ ?> margin-bottom: -46px; <?php } ?>">
					
					<!-- Portfolio Image -->
					<?php if (has_post_thumbnail()) { /* if the post has a featured image */ 
						$blog_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), ''); // Get original image size
						$thumb = get_post_thumbnail_id(); 
						$image = vt_resize( $thumb,'' , 294, 194, true ); // Resize original image
					?>
						
					<?php if ( get_post_meta($post->ID, 'use_video', true) == 'on' ){
					
					switch(get_post_meta($post->ID, 'pf_video', true)){
                    case 'youtube':
						$link = 'http://www.youtube.com/watch?v='.get_post_meta($post->ID, 'youtube_id', true).'&amp;feature=player_embedded#at=41';
						$id = ' id="tube'.$post->ID.'" ';
						break;
                    case 'vimeo':
						$link = 'http://vimeo.com/'.get_post_meta($post->ID, 'vimeo_id', true);
						$id = ' id="vimeo'.$post->ID.'" ';
						break;
                    case 'dailymotion':
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
						
					<?php } elseif (!has_post_thumbnail()) { // if there is no thumbnail, show a generic image holder ?>
					
						<a href="<?php the_permalink() ?>">
							<img src="<?php bloginfo('template_directory'); ?>/images/no-image-294x194.jpg" title="<?php the_title() ?>"  />
						</a>
					
					<?php } // end featured image display check ?>
				
					</div> <!-- end .featured-image -->
					
					<div class="portfolio-details">

					<div class="grid_4 more-info alpha">
					
                    <h4 class="portfolio-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'bowtie'), get_the_title()); ?>"> <?php the_title(); ?></a> </h4>
                    
					<hr />
					
                    <div class="portfolio-excerpt">
					
						<?php the_excerpt(); ?>
                        <a href="<?php the_permalink(); ?>" class="more-link"><?php _e('read more', 'bowtie'); ?> &rarr;</a>
								
					</div> <!-- end .portfolio-excerpt -->

					</div> <!-- end .more-info -->
					
					<div class="grid_4 more-info alpha">	
					
					<!-- Client Meta -->
					<?php $client = get_post_meta($post->ID,'client_value',TRUE); 
							if(!empty($client)) { // if client meta box has info ?>
						<div class="client" style="margin-right:10px;"><?php echo $client ?></div>
							<?php } else { } //if no data, display nothing ?>

					<!-- Date Meta -->
					<?php  $date = get_post_meta($post->ID,'date_value',TRUE); 
						  if(!empty($date)) { // if date meta box has info ?>
						<div class="calendar" style="margin-right:10px;"><?php  echo $date ?></div>
							<?php } else { } //if no data, display nothing ?>
					

					<!-- Tasks Meta -->
					<?php $tasks = get_post_meta($post->ID,'tasks_value',TRUE); 
							if(!empty($tasks)) { // if tasks meta box has info ?>
						<div class="services" style="margin-right:10px;"><?php echo $tasks ?></div>
							<?php } else { } //if no data, display nothing?>
							
					</div> <!-- end .grid_4 Portfolio Meta Details -->
					</div><!-- end .portfolio-details -->
				
					<div class="clear"></div>
				
                    <div class="hr-pattern" style="margin:20px 0;" ></div>
					
					</div> <!-- end portfolio post-<?php the_ID(); ?> -->
					
                    </li> <!-- end .portfolio_three_columns -->

                    <?php $count++; ?>
                    <?php endwhile; endif; ?>
					
                    <?php wp_reset_query(); ?>
               
                </ul> <!-- end #portfolio -->

</div><!-- end #post-content-wrap .grid_12 -->
			
</div> <!-- end #body-wrap .container_12 -->

<div class="clear"></div>

<?php get_footer(); ?>