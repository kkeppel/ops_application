<?php class ServicesWidget extends WP_Widget
{
    function ServicesWidget(){
		$widget_ops = array('description' => 'Add an icon and text to display a service you provide.');
		$control_ops = array('width' => 400, 'height' => 300);
		parent::WP_Widget(false,$name='Bowtie Service Widget',$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'About The Fan' : $instance['title']);
		$imagePath = empty($instance['imagePath']) ? '' : $instance['imagePath'];
		$aboutText = empty($instance['aboutText']) ? '' : $instance['aboutText'];
		$readMore = empty($instance['readMore']) ? '' : $instance['readMore'];

		echo $before_widget;

		if ( $title )
		echo $before_title . $title . $after_title;
?>	
<div class="service-info">

	<?php if ($imagePath) : ?>
	<img src="<?php echo($imagePath); ?>" alt="" />
	<?php endif ?>
	
	<p><?php echo($aboutText)?></p>
	
	<?php if ($readMore) : ?>
	<span class="read-more"><a href="<?php echo($readMore); ?>"> &nbsp; read more &rarr;</a></span>
	<?php endif ?>

</div> <!-- end .service-info -->

<?php
		echo $after_widget;
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = stripslashes($new_instance['title']);
		$instance['imagePath'] = stripslashes($new_instance['imagePath']);
		$instance['aboutText'] = stripslashes($new_instance['aboutText']);
		$instance['readMore'] = stripslashes($new_instance['readMore']);
		
		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'Service Provided', 'imagePath'=>'', 'aboutText'=>'', 'readMore'=>'',) );

		$title = htmlspecialchars($instance['title']);
		$imagePath = htmlspecialchars($instance['imagePath']);
		$aboutText = htmlspecialchars($instance['aboutText']);
		$readMore = htmlspecialchars($instance['readMore']);

		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
		# Image
		echo '<p><label for="' . $this->get_field_id('imagePath') . '">' . 'Image URL:' . '</label><textarea cols="20" rows="2" class="widefat" id="' . $this->get_field_id('imagePath') . '" name="' . $this->get_field_name('imagePath') . '" >'. $imagePath .'</textarea></p>';	
		# About Text
		echo '<p><label for="' . $this->get_field_id('aboutText') . '">' . 'Text:' . '</label><textarea cols="20" rows="5" class="widefat" id="' . $this->get_field_id('aboutText') . '" name="' . $this->get_field_name('aboutText') . '" >'. $aboutText .'</textarea></p>';
		# Read More Link
		echo '<p><label for="' . $this->get_field_id('readMore') . '">' . 'Read More URL:' . '</label><textarea cols="20" rows="2" class="widefat" id="' . $this->get_field_id('readMore') . '" name="' . $this->get_field_name('readMore') . '" >'. $readMore .'</textarea></p>';	
	}

}// end ServicesWidget class

function ServicesWidgetInit() {
  register_widget('ServicesWidget');
}

add_action('widgets_init', 'ServicesWidgetInit');

?>