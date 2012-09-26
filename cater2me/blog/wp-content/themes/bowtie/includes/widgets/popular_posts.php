<?php
// Add function to widgets_init that'll load our widget
add_action( 'widgets_init', 'jg_popular_posts' );

// Register widget
function jg_popular_posts() {
	register_widget( 'jg_popular_posts' );
}

// Widget class
class jg_popular_posts extends WP_Widget {


/*-----------------------------------------------------------------------------------*/
/*	Widget Setup
/*-----------------------------------------------------------------------------------*/
function jg_popular_posts() {
	
	// Widget settings
	$widget_ops = array(
		'classname' => 'jg_popular_posts',
		'description' => __('Displays your most popuar posts.', 'Bowtie')
	);

	/* Create the widget */
	$this->WP_Widget( 'jg_popular_posts', __('Bowtie Popular Posts', 'Bowtie'), $widget_ops );
}


/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/
function widget( $args, $instance ) {
	global $wpdb;
	extract( $args );

	// Our variables from the widget settings
	$title = apply_filters('widget_title', $instance['title'] );
	$count = apply_filters('widget_count', $instance['count'] );

	// Before widget (defined by theme functions file)
	echo $before_widget;

	// Display the widget title if one was input
	if ( $title )
		echo $before_title . $title . $after_title;
	
			// Start Display of Recent Posts
			echo '<ul class="recent-posts">';
			
			// Setup the loop		
			$posts = new WP_Query();
			
			$args = array( 
				'showposts' => $count,
				'order' => 'DESC',
				'orderby' => 'comment_count',
				'ignore_sticky_posts' => '1',
				'post_type' => 'post',
				'post_status' => 'publish'
			);
			
			$posts->query( $args  );
			while ($posts->have_posts()) : $posts->the_post(); ?>
					
				<li class="image-fade">
					
					<?php 
						if (has_post_thumbnail()) { // if the post has a featured image
						$thumb = get_post_thumbnail_id(); 
						$image = vt_resize( $thumb,'' , 50, 50, true ); // Resize original image
					?>

						<a href="<?php the_permalink();?>" class="thumb"><img class="omega" src="<?php echo $image[url] ?>" height="<?php echo $image[height] ?>" width="<?php echo $image[width] ?>" title="<?php the_title(); ?>" class="frame" /></a>
					
					
					<?php } elseif (!has_post_thumbnail()) { // if there is no thumbnail, show a generic image holder ?>
					
					<a href="<?php the_permalink() ?>">
						<img src="<?php bloginfo('template_directory'); ?>/images/no-image-sm2.jpg" title="<?php the_title() ?>" class="frame"  />
					</a>
					
					<?php } ?>
					
					<span class="most-recent-title"><a href="<?php the_permalink(); ?>" class="title"><?php the_title();?></a></span><br/>
					<span class="most-recent-excerpt"><?php jg_excerpt('6'); ?></span>
				</li>
						
			<?php endwhile; 
			wp_reset_query();
				
				
			echo '</ul>';

	// After widget (defined by theme functions file)
	echo $after_widget;
	
}


/*-----------------------------------------------------------------------------------*/
/*	Update Widget
/*-----------------------------------------------------------------------------------*/
function update( $new_instance, $old_instance ) {
	$instance = $old_instance;

	// Strip tags to remove HTML (important for text inputs)
	$instance['title'] = strip_tags( $new_instance['title'] );
	$instance['count'] = strip_tags( $new_instance['count'] );

	return $instance;
}

/*-----------------------------------------------------------------------------------*/
/*	Widget Settings (Displays the widget settings controls on the widget panel)
/*-----------------------------------------------------------------------------------*/
function form( $instance ) {

	// Set up some default widget settings
	$defaults = array(
		'title' => 'Popular Posts',
		'count' => '3'
	);
	
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>

	<!-- Title Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'Bowtie') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>
	
	<!-- Count Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Count', 'Bowtie') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" />
	</p>

	<?php
	}
}
?>