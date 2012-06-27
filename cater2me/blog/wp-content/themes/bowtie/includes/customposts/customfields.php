<?php
load_theme_textdomain('bowtie'); // Localization

/*-----------------------------------------------------------------------------------*/
/*	Add Heading and Tagline Custom Fields
/*-----------------------------------------------------------------------------------*/

$jg_new_meta_boxes = 
array(

"client" => array(
"name" => "client",
"type" => "input",
"std" => "",
"title" => __('Client or Project Name','bowtie') ),

"date" => array(
"name" => "date",
"type" => "input",
"std" => "",
"title" => __('Date Completed','bowtie') ),

"tasks" => array(
"name" => "tasks",
"type" => "input",
"std" => "",
"title" => __('Tasks or Skills','bowtie') ),


//"extra" => array(
//"name" => "extra",
//"type" => "input",
//"std" => "",
//"title" => "Additional Details"),

);


/*-----------------------------------------------------------------------------------*/
/*	Create a new meta box function. 
/*-----------------------------------------------------------------------------------*/

function jg_new_meta_boxes() {
global $post, $jg_new_meta_boxes;
	
	foreach($jg_new_meta_boxes as $meta_box) {
		
		echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
		
		echo'<h4>'.$meta_box['title'].'</h4>';
		
		if( $meta_box['type'] == "input" ) { 
		
			$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);
		
			if($meta_box_value == "")
				$meta_box_value = $meta_box['std'];
		
			echo'<input type="text" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" style="width:90%"/><br />';
			
		} elseif ( $meta_box['type'] == "select" ) {
			
			echo'<select name="'.$meta_box['name'].'_value">';
			
			foreach ($meta_box['options'] as $option) {
                
				echo'<option';
				if ( get_post_meta($post->ID, $meta_box['name'].'_value', true) == $option ) { 
					echo ' selected="selected"'; 
				} elseif ( $option == $meta_box['std'] ) { 
					echo ' selected="selected"'; 
				} 
				echo'>'. $option .'</option>';
			
			} 
			
			echo'</select>';
			
			}elseif ( $meta_box['type'] == "upload" ) {
			
				echo 'upload box';
				
			}
		
		echo'<p><label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p>';
	}

}

/*-----------------------------------------------------------------------------------*/
/*	Enable the boxes on portfolios
/*-----------------------------------------------------------------------------------*/


function jg_create_meta_box() {
global $theme_name, $jg_new_meta_boxes;
	if (function_exists('add_meta_box') ) {
	add_meta_box( 'new-meta-boxes', __('Portfolio Item Details', 'bowtie'), 'jg_new_meta_boxes', 'portfolio', 'side', 'low' );
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Save the newly added custom fields
/*-----------------------------------------------------------------------------------*/

function jg_save_postdata( $post_id ) {
	global $post, $jg_new_meta_boxes;  
		foreach($jg_new_meta_boxes as $meta_box) {  

		
		// Verify  
		if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {  
		return $post_id;  
		}  
	
	if ( 'page' == $_POST['post_type'] ) {  
	if ( !current_user_can( 'edit_page', $post_id ))  
	return $post_id;  
	} else {  
	if ( !current_user_can( 'edit_post', $post_id ))  
	return $post_id;  
	}  
	
	$data = $_POST[$meta_box['name'].'_value'];  
	
	if(get_post_meta($post_id, $meta_box['name'].'_value') == "")  
	add_post_meta($post_id, $meta_box['name'].'_value', $data, true);  
	elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))  
	update_post_meta($post_id, $meta_box['name'].'_value', $data);  
	elseif($data == "")  
	delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));  
	}

	
}

add_action('admin_menu', 'jg_create_meta_box');
add_action('save_post', 'jg_save_postdata');


?>