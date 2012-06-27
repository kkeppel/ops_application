<?php

//Add function to widgets_init that'll load our widget.
add_action( 'widgets_init', 'jg_ad120x240' );

// Register widget.
function jg_ad120x240() {
	register_widget( 'jg_ad120x240_widget' );
}

//Widget class.
class jg_ad120x240_widget extends WP_Widget {

	function jg_ad120x240_widget() {
	
		/* Widget settings */
		$widget_ops = array( 'classname' => 'jg_ad120x240_widget', 'description' => __('Displays a single 120x240 Banner.', 'Bowtie') );

		/* Widget control settings */
		//$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'jg_ad300_widget' );

		/* Create the widget */
		$this->WP_Widget( 'jg_ad120x240_widget', __('Bowtie 120x240 Ad', 'Bowtie'), $widget_ops );
	}

/***	Display Widget ***/
	function widget( $args, $instance ) {  
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$ad = $instance['ad'];
		$link = $instance['link'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		/* Display a containing div */
		echo '<div class="sidebar_ad">';

		/* Display Ad */
		if ( $ad )
			echo '<a href="' . $link . '"><img src="' . $ad . '" width="120" height="240" alt="" /></a>';
			
		echo '</div>';

		/* After widget (defined by themes). */
		echo $after_widget;
	}

/*** Update Widget ***/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* No need to strip tags */
		$instance['ad'] = $new_instance['ad'];
		$instance['link'] = $new_instance['link'];

		return $instance;
	}
	
/*** Widget Settings ***/
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => '',
		'ad' => get_template_directory_uri()."/images/ad120x240.jpg",
		'link' => 'http://themeforest.net/user/JamiGibbs/profile',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p> <!-- Widget Title: Text Input -->
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p> <!-- Ad image url: Text Input -->
			<label for="<?php echo $this->get_field_id( 'ad' ); ?>"><?php _e('Ad image url:', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'ad' ); ?>" name="<?php echo $this->get_field_name( 'ad' ); ?>" value="<?php echo $instance['ad']; ?>" />
		</p>
		
		<p> <!-- Ad link url: Text Input -->
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e('Ad link url:', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $instance['link']; ?>" />
		</p>
		
	<?php
	}
}
?>