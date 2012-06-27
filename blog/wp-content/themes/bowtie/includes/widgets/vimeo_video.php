<?php 

/*-----------------------------------------------------------------------------------*/
/*  Vimeo Video Widget
/*-----------------------------------------------------------------------------------*/
class jg_vimeo extends WP_Widget {
	function jg_vimeo() {
		$widget_ops = array('classname' => 'jg_vimeo', 'description' => 'Display Vimeo Video' );
		$this->WP_Widget('jg_vimeo', 'Bowtie Vimeo Video', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$vimeo_id = empty($instance['vimeo_id']) ? 0 : $instance['vimeo_id'];
		
		if(!empty($title))
		{
			echo '<h2 class="widgettitle">'.$title.'</h2>';
		}
?>

<object width="300" height="200"><param name="allowfullscreen" value="true" /><param name="wmode" value="opaque"><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $vimeo_id; ?>&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $vimeo_id; ?>&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="300" height="200" wmode="transparent"></embed></object><br/><br/>
		
<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['vimeo_id'] = strip_tags($new_instance['vimeo_id']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'vimeo_id' => '') );
		$title = strip_tags($instance['title']);
		$vimeo_id = strip_tags($instance['vimeo_id']);

?>
			
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('vimeo_id'); ?>">Video_id: <input class="widefat" id="<?php echo $this->get_field_id('vimeo_id'); ?>" name="<?php echo $this->get_field_name('vimeo_id'); ?>" type="text" value="<?php echo esc_attr($vimeo_id); ?>" /></label></p>
<?php
	}
}

register_widget('jg_vimeo');

?>