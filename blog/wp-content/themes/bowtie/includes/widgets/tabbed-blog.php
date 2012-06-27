<?php

// Add function to widgets_init that'll load our widget
add_action( 'widgets_init', 'jg_blog_widget' );

// Register widget
function jg_blog_widget() {
	register_widget( 'jg_Blog_Widget' );
}

// Register and queue JS
function jg_blog_tab_js(){
	if (!is_admin() && is_active_widget(false, false, 'jg_blog_widget')) { 
		//wp_enqueue_script('jquery-ui-core');		
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('tabs');
	}
}

add_action('init', 'jg_blog_tab_js');

// Widget class
class jg_blog_widget extends WP_Widget {


/*-----------------------------------------------------------------------------------*/
/*	Widget Setup
/*-----------------------------------------------------------------------------------*/
	
function jg_blog_Widget() {
	
	// Widget settings
	$widget_ops = array(
		'classname' => 'jg_blog_widget',
		'description' => __('A tabbed widget that display popular posts, recent posts, comments and tags.', 'Bowtie')
	);

	/* Create the widget */
	$this->WP_Widget( 'jg_blog_widget', __('Bowtie Blog Tabs', 'Bowtie'), $widget_ops );
}


/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/
	
function widget( $args, $instance ) {
	global $wpdb;
	extract( $args );

	// Our variables from the widget settings
	$title = apply_filters('widget_title', $instance['title'] );
	$tab1 = $instance['tab1'];
	$tab2 = $instance['tab2'];
	$tab3 = $instance['tab3'];
	$tab4 = $instance['tab4'];

	// Before widget (defined by theme functions file)
	echo $before_widget;

	// Display the widget title if one was input
	if ( $title )
		echo $before_title . $title . $after_title;
		
	// Display the tab navigation
	echo '<div id="tabs">';
	
		echo '<ul id="tab-items">';
			echo '<li id="jg_tab1"><a href="#tabs-1"><span>'.$tab1.'</span></a></li>';
			echo '<li id="jg_tab2"><a href="#tabs-2"><span>'.$tab2.'</span></a></li>';
			echo '<li id="jg_tab3"><a href="#tabs-3"><span>'.$tab3.'</span></a></li>';
			echo '<li id="jg_tab4"><a href="#tabs-4"><span>'.$tab4.'</span></a></li>';
		echo '</ul>';
		
		echo '<div class="tabs-inner">';
	
		// Display popular posts tab
		echo '<div id="tabs-1" class="tab tab-popular">';
			echo '<ul>';
				
			$popPosts = new WP_Query();
			$popPosts->query('caller_get_posts=1&showposts=5&orderby=comment_count');
			while ($popPosts->have_posts()) : $popPosts->the_post(); ?>
					
				<li class="clearfix">
				
					<div class="tab-thumb image-fade">
					
					<?php /* if the post has a featured image */
						if (has_post_thumbnail()) {

						$thumb = get_post_thumbnail_id(); 
						$image = vt_resize( $thumb,'' , 50, 50, true ); // Resize original image
					
					?>

						<a href="<?php the_permalink();?>" class="thumb"><img class="omega" src="<?php echo $image[url] ?>" height="<?php echo $image[height] ?>" width="<?php echo $image[width] ?>" title="<?php the_title(); ?>" /></a>
					
					
					<?php } elseif (!has_post_thumbnail()) { // if there is no thumbnail, show a generic image holder ?>
					
					<a href="<?php the_permalink() ?>">
						<img src="<?php bloginfo('template_directory'); ?>/images/no-image-sm2.jpg" title="<?php the_title() ?>"  />
					</a>
					
					<?php } ?>
					
					</div> <!-- end .tab-thumb .image-fade -->
					
					<h3 class="entry-title"><a href="<?php the_permalink(); ?>" class="title"><?php the_title();?></a></h3>
					<div class="entry-meta entry-header">
						<span class="published"><?php the_time('F j, Y'); ?></span>
						<span class="comment-count">&nbsp; &#47; &nbsp;<?php comments_popup_link(__('No Comments', 'Bowtie'), __('1 Comment', 'Bowtie'), __('% Comments', 'Bowtie')); ?></span>
					</div>
				</li>
						
			<?php endwhile; 
			wp_reset_query();
				
				
			echo '</ul>';
		echo '</div><!-- #tabs-1 -->';


		// Display recent posts tab
		echo '<div id="tabs-2" class="tab tab-recent">';
			echo '<ul>';
				
			$recentPosts = new WP_Query();
			$recentPosts->query('caller_get_posts=1&showposts=5');
			while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
			
				<li class="clearfix">
				
					<div class="tab-thumb image-fade">
					
					<?php /* if the post has a featured image */
						if (has_post_thumbnail()) {

						$thumb = get_post_thumbnail_id(); 
						$image = vt_resize( $thumb,'' , 50, 50, true ); // Resize original image
					
					?>
					
						<a href="<?php the_permalink();?>" class="thumb"><img class="omega" src="<?php echo $image[url] ?>" height="<?php echo $image[height] ?>" width="<?php echo $image[width] ?>" title="<?php the_title(); ?>" /></a>
					
					
					<?php } elseif (!has_post_thumbnail()) { // if there is no thumbnail, show a generic image holder ?>
					
					<a href="<?php the_permalink() ?>">
						<img src="<?php bloginfo('template_directory'); ?>/images/no-image-sm2.jpg" title="<?php the_title() ?>"  />
					</a>
					
					<?php } ?>
					
					</div> <!-- end .tab-thumb .image-fade -->
					
					<h3 class="entry-title"><a href="<?php the_permalink(); ?>" class="title"><?php the_title();?></a></h3>
					<div class="entry-meta entry-header">
						<span class="published"><?php the_time('F j, Y' ); ?></span>
						<span class="comment-count">&nbsp; &#47; &nbsp;<?php comments_popup_link(__('No Comments', 'Bowtie'), __('1 Comment', 'Bowtie'), __('% Comments', 'Bowtie')); ?></span>
				</div>
				</li>
				
			<?php endwhile;
					
			echo '</ul>';
		echo '</div><!-- #tabs-2 -->';
		

		// Display comments tab
		echo '<div id="tabs-3" class="tab tab-comments">';
			
			$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,70) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT 5";
			
			$comments = $wpdb->get_results($sql);
			
			echo '<ul>';
			
			foreach ($comments as $comment) { ?>
				
				<li class="clearfix">
		    
				    <a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> <?php _e('on ', 'Bowtie'); ?><?php echo $comment->post_title; ?>"><?php echo get_avatar( $comment, '50' ); ?></a>
				
					<h3><a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> <?php _e('on ', 'Bowtie'); ?><?php echo $comment->post_title; ?>"><?php echo strip_tags($comment->comment_author); ?> said  "<?php echo strip_tags($comment->com_excerpt); ?> ..."</a></h3>
		
				</li>
				<?php }			
						
			echo '</ul>';
		echo '</div><!-- #tabs-3 -->';


		// Display tags tab
		echo '<div id="tabs-4" class="tab tab-tags clearfix">';
		wp_tag_cloud('largest=12&smallest=12&unit=px');
		echo '</div><!-- #tabs-4 -->';
	
	
	// End tabbed inner div
	echo '</div><!-- .tabs-inner -->';
	
	// End tabbed content
	echo '</div><!-- #tabs -->';

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

	// No need to strip tags
	$instance['tab1'] = $new_instance['tab1'];
	$instance['tab2'] = $new_instance['tab2'];
	$instance['tab3'] = $new_instance['tab3'];
	$instance['tab4'] = $new_instance['tab4'];
	
	return $instance;
}


/*-----------------------------------------------------------------------------------*/
/*	Widget Settings (Displays the widget settings controls on the widget panel)
/*-----------------------------------------------------------------------------------*/
	
function form( $instance ) {

	// Set up some default widget settings
	$defaults = array(
		'title' => '',
		'tab1' => 'Popular',
		'tab2' => 'Recent',
		'tab3' => 'Comments',
		'tab4' => 'Tags',
	);
	
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>

	<!-- Widget Title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'Bowtie') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<!-- tab 1 title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'tab1' ); ?>"><?php _e('Tab 1 Title:', 'Bowtie') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'tab1' ); ?>" name="<?php echo $this->get_field_name( 'tab1' ); ?>" value="<?php echo $instance['tab1']; ?>" />
	</p>
	
	<!-- tab 2 title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'link1' ); ?>"><?php _e('Tab 2 Title:', 'Bowtie') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'tab2' ); ?>" name="<?php echo $this->get_field_name( 'tab2' ); ?>" value="<?php echo $instance['tab2']; ?>" />
	</p>
	
	<!-- tab 3 title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'tab2' ); ?>"><?php _e('Tab 3 Title:', 'Bowtie') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'tab3' ); ?>" name="<?php echo $this->get_field_name( 'tab3' ); ?>" value="<?php echo $instance['tab3']; ?>" />
	</p>
	
	<!-- tab 4 title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'link2' ); ?>"><?php _e('Tab 4 Title:', 'Bowtie') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'tab4' ); ?>" name="<?php echo $this->get_field_name( 'tab4' ); ?>" value="<?php echo $instance['tab4']; ?>" />
	</p>

	<?php
	}
}
?>