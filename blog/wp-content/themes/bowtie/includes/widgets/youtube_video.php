<?php
/*-----------------------------------------------------------------------------------*/
/*  Youtube Video Widget
/*-----------------------------------------------------------------------------------*/
class jg_youtube extends WP_Widget {
	function jg_youtube() {
		$widget_ops = array('classname' => 'jg_youtube', 'description' => 'Display Youtube Video' );
		$this->WP_Widget('jg_youtube', 'Bowtie Youtube Video', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$youtube_id = empty($instance['youtube_id']) ? 0 : $instance['youtube_id'];
		
		if(!empty($title))
		{
			echo '<h2 class="widgettitle">'.$title.'</h2>';
		}
?>

<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/<?php echo $youtube_id; ?>&hd=1" style="width:300px;height:200px"><param name="wmode" value="opaque"><param name="movie" value="http://www.youtube.com/v/<?php echo $youtube_id; ?>&hd=1" /></object>
		
<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['youtube_id'] = strip_tags($new_instance['youtube_id']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'youtube_id' => '') );
		$title = strip_tags($instance['title']);
		$youtube_id = strip_tags($instance['youtube_id']);

?>
			
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('youtube_id'); ?>">Video_id: <input class="widefat" id="<?php echo $this->get_field_id('youtube_id'); ?>" name="<?php echo $this->get_field_name('youtube_id'); ?>" type="text" value="<?php echo esc_attr($youtube_id); ?>" /></label></p>
<?php
	}
}

register_widget('jg_youtube');


?>