<?php
/*
Template Name: Home
*/
?>

<?php get_header(); ?>

<?php $slider_choice = of_get_option('slider_choice'); // Get the slider choice ?>

<?php if ($slider_choice == 'content') : // If 'Content Slider' is chosen, display it ?>

	<!-- Begin Content Slider -->
	<div class="clearfix" id="slider-main-wrap">

		<?php 
		$query = new WP_Query();
		$query->query('post_type='.__( 'slide' ).'&posts_per_page=-1');
		$post_count = $query->post_count;
		$count = 1; ?>
		
		<div class="container_12">

        <div id="slider" >
		
            <div class="slides_container grid_12">
                    	
            <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); // a lovely loop ?>

				<div id="count-<?php echo $count; ?>">
                        
                <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">	

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div> <!-- end .entry-content -->
                            
                </div><!-- end #post-<?php the_ID(); ?> -->
                       
                </div><!-- end .count-<?php echo $count; ?> -->
                        
                <?php $count++; ?>
                        
                <?php endwhile;  endif; // end the loop ?>
                    
            </div> <!-- end .sliders_container -->

        </div><!-- end #slider -->
		
		</div> <!-- end .container_12 --> 

        <?php wp_reset_query(); ?>
			
	</div> <!-- end #container_12 #slider-main-wrap -->
	<!-- End Content Slider -->
	
<?php else : ?> 

<?php if ($slider_choice == 'nivo') : // If 'Nivo Slider' is chosen, display it ?>

	<!-- Begin Nivo Slider -->
	<div class="container_12">
	
		<?php 	
		$custom_post_type = 'slide';
		$args=array(
			'post_type' => $custom_post_type,
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'caller_get_posts'=> 1
		);
		$query = null;
		$query = new WP_Query($args); ?>

        <div id="slider-wrapper">
        
            <div id="slider-nivo" class="nivoSlider">
			
			<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); // a lovely loop ?>

			<?php if (has_post_thumbnail()) { /* if the post has a featured image */ 
				$blog_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), ''); // Get original image size
				$thumb = get_post_thumbnail_id(); 
				$image = vt_resize( $thumb,'' , 940, 300, true ); // Resize original image
			?>
				
			<?php // Check if Nivo slide has a URLs
				if (get_post_meta($post->ID, "_nivo_link", true)) { ?>
				
                <a href="<?php echo stripslashes(get_post_meta($post->ID, "_nivo_link", true)) ?>"><img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" alt="" title="<?php echo get_post_meta($post->ID, "_nivo_title", true); ?>" /></a>
				
			<?php } else { // if no URL is given, then omit the anchor tag ?>
			
				<img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" alt="" title="<?php echo get_post_meta($post->ID, "_nivo_title", true); ?>" />
				
			<?php } // end slide URL check ?>
				
			<?php } // end check for featured image ?>
                        
			<?php endwhile;  endif; // end the loop ?>
				
            </div> <!-- end #slider-nivo .nivoSlider -->
        
        </div><!-- end #slider-wrapper -->
		
		<?php wp_reset_query(); ?>

	</div> <!-- end #container_12 -->
	<!-- End Nivo Slider -->
		
<?php else : ?> 

<?php if ($slider_choice == 'none') : // If 'None' is chosen, don't show slider ?>

<?php endif; // end check for 'Nivo' ?>
<?php endif; // end check for 'Content Slider' ?>
<?php endif; // end check for 'None' ?>
	
	<div class="clear"></div>
	
	<?php $cta_choice = of_get_option('cta_choice'); // Check if user wants to display CTA on homepage
		if($cta_choice == 'true') : ?>
		
	<!-- BEGIN CALL TO ACTION -->
	<div class="cta-wrap">
		<div id="call-to-action" class="container_12 clearfix">
			
			<!-- CTA SENTENCE -->
			<div class="grid_7">
				<h2><?php echo stripslashes(of_get_option('cta_text')); ?></h2>
			</div> <!-- end #cta-top .grid_7 -->
			
			<!-- CTA WIDGET -->
			<div class="cta-info grid_5" >
			
			<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('cta-widgets')) : // check for 'cta-widgets' and display if exists ?> 
			
			<?php else : // if no 'cta-widgets' then display message ?>
			
			<p style="position:relative;top:40px;left:70px;"><?php _e('Drag a widget into the \'Call to Action\' area.',''); ?></p>
			
			<?php endif; // end 'cta-widgets' check ?>

			</div>
			
		</div> <!-- end .container_12 #call-to-action -->
	</div><!-- end .cta-wrap -->
	
	<?php endif; // End if user wants to display CTA on homepage ?>
	
	<div class="clear"></div>
	
	<div id="home-content-wrap">
	
	<?php $portfolio_choice = of_get_option('portfolio_choice'); // Check if user wants to display portfolio on homepage
		if($portfolio_choice == 'true') : // If the choice is true, then show it ?>
	
	<!-- Begin Portfolio Items -->
	<div class="container_12" id="home-portfolio" role="main">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); // a lovely loop ?>
	
	<div class="grid_12">
	
		<div class="grid_3 alpha"><h3><?php echo stripslashes(of_get_option('portfolio_home_title')); ?></h3></div>
		<div class="grid_9 omega">
			<div class="hr-pattern"></div> <!-- Horizontal Line -->
		</div>
	
	</div> <!-- END .grid_12  -->
	<?php endwhile; endif; // end the loop  ?>
	
    <?php $query = new WP_Query(); 
		$query->query('post_type=portfolio&posts_per_page=4'); // Get custom posts in 'portfolio' and show 4 of them ?>
	
	<ul id="portfolio">
	
                <?php $count = 0; // let's count from the beginning ?>
                <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); // a lovely loop
				$terms = get_the_terms( get_the_ID(), 'skill-type' ); //grab the portfolio categories ?> 
		
		<li data-id="id-<?php echo $count; ?>" id="id-<?php echo $count; ?>" class="<?php foreach ($terms as $term) { echo strtolower(preg_replace('/\s+/', '-', $term->name)). ' '; } ?> portfolio_three_columns grid_3" >
		
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>" >
			
			<div class="mosaic-block-wrap">
			<div class="featured-image mosaic-block fade" >

				<a href="<?php the_permalink(); ?>" title="<?php printf(__('Permanent Link to %s', 'bowtie'), get_the_title()); ?>" class="mosaic-overlay">
					<div class="details">
						<h4><?php the_title(); ?></h4>
						<span><?php echo jg_excerpt('10'); //custom excerpt length from functions.php ?></span>
					</div> <!-- end .details -->
				</a> <!-- end .mosaic-overlay -->
				
				<!-- Portfolio Image -->
				<?php if (has_post_thumbnail()) { /* if the post has a featured image */ 
					$blog_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), ''); // Get original image size
					$thumb = get_post_thumbnail_id(); 
					$image = vt_resize( $thumb,'' , 204, 117, true ); // Resize original image
				?>
			
					<div class="mosaic-backdrop">
						<img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" alt="portfolio-item" />
					</div><!-- end .mosaic-backdrop -->
				
				<?php } elseif (!has_post_thumbnail()) { // if there is no thumbnail, show a generic image holder ?>
				
					<div class="mosaic-backdrop">
					<img src="<?php bloginfo('template_directory'); ?>/images/no-image-204x117.jpg" title="<?php the_title() ?>"  />
					</div><!-- end .mosaic-backdrop -->
				
				<?php } // end featured image display check ?>
			
			</div><!-- end .mosaic-block .fade  -->
			</div><!-- end .mosaic-block-wrap -->
			
		</div> <!-- end portfolio post-<?php the_ID(); ?> -->
			
		</li> <!-- end .portfolio_three_columns -->
	
        <?php $count++; // count up to the next slide ?>
        <?php endwhile; endif; //end loop ?>
					
        <?php wp_reset_query(); ?>
		
	</ul> <!-- end #portfolio -->
		
	</div> <!-- end #home-portfolio .container_12 -->
	
	<?php endif; // End if user wants to display portfolio on homepage ?>
	
	<div class="clear"></div>
	
	<?php $blog_choice = of_get_option('blog_choice'); // Check if user wants to display blog posts on homepage
		if($blog_choice == 'true') : ?>
	
	<!-- Begin Blog Items -->
	<div class="container_12" id="home-latest-blog">

		<div class="grid_3"><h3><?php echo stripslashes(of_get_option('blog_home_title')); ?></h3></div>
		<div class="grid_9">
			<div class="hr-pattern"></div> <!-- Horizontal Line -->
		</div>
	
		<div class="clear"></div>
		
		<!-- BEGIN MOST RECENT POST EXCERPT -->
		<div id="home-blog-post-wrap" class="clearfix">

		<?php // Loop 1 - First Blog Post
		
		$home_cat_choice = of_get_option('home_cat_choice');
		if($home_cat_choice == 'true') {  // if you want to display specific post category
			
			$home_cat = of_get_option('home_posts_cat');
			$args=array(
				'cat' => $home_cat, //category ID
				'posts_per_page' => 1,
			);

		} elseif ($home_cat_choice == 'false') { // if you don't want to display a specific category, just show the most recent post
			$args=array(
				'posts_per_page' => 1,
			);
		} 
		
		// Here comes the first loop
		$first_query = new WP_Query($args); 
		while($first_query->have_posts()) : $first_query->the_post();
		
		
		global $more; // Kick the <!--more--> button into gear
		$more = 0; ?>

		<div id="home-blog" class="grid_9">
		
			<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
			<p class="home-meta"><?php _e('Posted:','bowtie'); ?>  <?php the_date('F jS, Y') ?> <?php _e('by','bowtie'); ?> <?php the_author_link(); ?>   -  <?php comments_popup_link(__('No Comments', 'bowtie'), __('1 Comment', 'bowtie'), __('% Comments', 'bowtie')); ?></p>
			
			<!-- Featured Image -->
			<?php if (has_post_thumbnail()) { /* if the post has a featured image */ 
				$blog_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), ''); // Get original image size
				$thumb = get_post_thumbnail_id(); 
				$image = vt_resize( $thumb,'' , 137, 137, true ); // Resize original image
			?>
				
			<div class="grid_2 alpha image-fade">
			
				<a class="portfolio lightbox" href="<?php echo $blog_image_url[0]; ?>">
					<img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" title="<?php _e('Click to view image','bowtie') ?>" />
				</a>
				
			</div>
			
			<div class="home-post-content grid_7 omega">
				<?php the_content(__('&nbsp; Read more &rarr;', 'bowtie')); ?>
			</div>
			
			<?php } else { //if no featured image, then adjust the grid layout to accomodate ?>
			
			<div class="home-post-content grid_9 alpha">
				<?php the_content(__('&nbsp; Read more &rarr;', 'bowtie')); ?>
			</div>
			
			<?php } // nada ?>
		
		</div> <!-- end #home-blog .grid_9 -->
		
		<?php endwhile;
		wp_reset_postdata(); ?>

		<!-- BEGIN BLOG POST LIST -->
		<div id="blog-list" class="grid_3 omega">
		
		<h3><?php echo stripslashes(of_get_option('blog_list_title')); ?></h3>
		
		<?php
		// Loop 2 - Listed Posts
		$home_cat_choice = of_get_option('home_cat_choice');
		if($home_cat_choice == 'true') { // if you want to display specific post category
		
			$home_cat = of_get_option('home_posts_cat');
			$args=array(
				'cat' => $home_cat, // category ID
				'posts_per_page' => of_get_option('blog_list_num'),
				'offset' => 1, // exclude the first post from the loop because it's already being showed in excerpt format to the left
			);

		} elseif ($home_cat_choice == 'false') { // if you don't want to display a specific category, just show the most recent post
			$args=array(
				'posts_per_page' => of_get_option('blog_list_num'),
				'offset' => 1, // exclude the first post from the loop because it's already being showed in excerpt format to the left
			);
		} 
		
		// Here comes the second loop
		$second_query = new WP_Query($args); 
		while($second_query->have_posts()) : $second_query->the_post(); ?>
				
			<ul>
				<li class="grid_3 image-fade">
				
				<!-- Featured Image -->
				<?php if (has_post_thumbnail()) { /* if the post has a featured image */ 
					$blog_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), ''); // Get original image size
					$thumb = get_post_thumbnail_id(); 
					$image = vt_resize( $thumb,'' , 34, 34, true ); // Resize original image
				?>
					
					<a class="portfolio" href="<?php echo $blog_image_url[0]; ?>">
						<img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" title="<?php _e('Click to view image','bowtie') ?>" />
					</a>
					
					<?php } elseif (!has_post_thumbnail()) { // if there is no thumbnail, show a generic image holder ?>
					
					<a href="<?php the_permalink() ?>">
						<img src="<?php bloginfo('template_directory'); ?>/images/no-image-sm.jpg" title="<?php the_title() ?>" />
					</a>
					
					<?php } ?>
					
					<h4><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>

				</li>
			</ul>
		
		<?php endwhile;
		wp_reset_postdata(); ?>
		</div><!-- end .blog-item -->
		
		</div><!-- end #home-blog-post-wrap -->
		
	</div> <!-- end #home-blog  .container_12 -->
	
	<?php endif; // End if user wants to display blog posts on homepage ?>
	
	<!-- Begin Services Area -->
	
	<?php $services_choice = of_get_option('services_choice'); // Check if user wants to display blog posts on homepage
		if($services_choice == 'true') : ?>
		
	<div id ="home-services" class="container_12">

		<div class="grid_3"><h3><?php echo stripslashes(of_get_option('services_home_title')); ?></h3></div>
		
		<div class="grid_9">
			<div class="hr-pattern"></div> <!-- Horizontal Line -->
		</div>
	
		<div class="clear"></div>
		
		<div id="home-services-wrap" class="clearfix">
		
			<!-- First Service -->
			<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('home-services')) : // check for 'home-services' and display if exists ?> 
			
			<?php else : // if no 'home-services' widgets then display placeholder text ?>
			
			<?php include (TEMPLATEPATH.'/includes/placeholder/services.php'); ?>
			
			<?php endif; // end 'home-services' check ?>
		
		</div><!-- end #home-services-wrap -->
		
	</div> <!-- end .container_12 -->
	
	<div class="clear"></div>
	
	<?php endif; // End if user wants to display services on homepage ?>
	
	</div> <!-- End #home-content-wrap -->
	
	<div class="clear"></div>

<?php get_footer(); ?>