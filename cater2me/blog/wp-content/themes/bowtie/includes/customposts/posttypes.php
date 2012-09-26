<?php
load_theme_textdomain('bowtie'); // Localization

/*-----------------------------------------------------------------------------------*/
/*	Create a new post type called slides
/*-----------------------------------------------------------------------------------*/

function jg_create_post_type_slides() 
{
	$labels = array(
		'name' => __( 'Slides','bowtie'),
		'singular_name' => __( 'Slide','bowtie' ),
		'rewrite' => array('slug' => __( 'slides','bowtie' )),
		'add_new' => _x('Add New', 'slide'),
		'add_new_item' => __('Add New Slide','bowtie'),
		'edit_item' => __('Edit Slide','bowtie'),
		'new_item' => __('New Slide','bowtie'),
		'view_item' => __('View Slide','bowtie'),
		'search_items' => __('Search Slides','bowtie'),
		'not_found' =>  __('No slides found','bowtie'),
		'not_found_in_trash' => __('No slides found in Trash','bowtie'), 
		'parent_item_colon' => ''
	  );
	  
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','custom-fields','excerpt'),
		'register_meta_box_cb' => 'add_events_metaboxes'
	  ); 
	  
	  register_post_type(__( 'slide' ),$args);
}

/*-----------------------------------------------------------------------------------*/
/*	Add the Slide Title Meta Box - http://wptheming.com/2010/08/custom-metabox-for-post-type/
/*-----------------------------------------------------------------------------------*/
function add_events_metaboxes() {
    add_meta_box('wpt_events_location', __('Nivo Slide Details','bowtie'), 'wpt_events_location', 'slide', 'side', 'default');
}

/*-----------------------------------------------------------------------------------*/
/*	Create Slide Title & URL Boxes
/*-----------------------------------------------------------------------------------*/
function wpt_events_location() {
    global $post;
 
    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
 
    // Get the title & URL data if its already been entered
    $nivo_title = get_post_meta($post->ID, '_nivo_title', true);
	$nivo_link = get_post_meta($post->ID, '_nivo_link', true);
 
    // Echo out the fields
	 echo '<p style="margin-top:20px;">'. __('Enter the Nivo slide title:','bowtie'). '</p>';
    echo '<input type="text" name="_nivo_title" value="' . $nivo_title  . '" class="widefat" />';
	
	 echo '<p style="margin-top:20px;">'. __('Enter a link for the Nivo slide:','bowtie'). '</p>';
	echo '<input type="text" name="_nivo_link" value="' . $nivo_link  . '" class="widefat" />';
 
}

/*-----------------------------------------------------------------------------------*/
/*	Save the Slide Meta Info
/*-----------------------------------------------------------------------------------*/
 
function wpt_save_events_meta($post_id, $post) {
 
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !wp_verify_nonce( $_POST['eventmeta_noncename'], plugin_basename(__FILE__) )) {
    return $post->ID;
    }
 
    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;
 
    // OK, we're authenticated: we need to find and save the data
    // We'll put it into an array to make it easier to loop though.
 
    $events_meta['_nivo_title'] = $_POST['_nivo_title'];
	$events_meta['_nivo_link'] = $_POST['_nivo_link'];
 
    // Add values of $events_meta as custom fields
 
    foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
        if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
            update_post_meta($post->ID, $key, $value);
        } else { // If the custom field doesn't have a value
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
 
}
 
add_action('save_post', 'wpt_save_events_meta', 1, 2); // save the custom fields

/*-----------------------------------------------------------------------------------*/
/*	Create a new post type called portfolio
/*-----------------------------------------------------------------------------------*/

function jg_create_post_type_portfolios() 
{
	$labels = array(
		'name' => __( 'Portfolio','bowtie'),
		'singular_name' => __( 'Portfolio','bowtie' ),
		'rewrite' => array('slug' => __( 'portfolios' )),
		'add_new' => _x('Add New', 'slide'),
		'add_new_item' => __('Add New Portfolio','bowtie'),
		'edit_item' => __('Edit Portfolio','bowtie'),
		'new_item' => __('New Portfolio','bowtie'),
		'view_item' => __('View Portfolio','bowtie'),
		'search_items' => __('Search Portfolio','bowtie'),
		'not_found' =>  __('No portfolios found','bowtie'),
		'not_found_in_trash' => __('No portfolios found in Trash','bowtie'), 
		'parent_item_colon' => ''
	  );
	  
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','custom-fields','excerpt')
	  ); 
	  
	  register_post_type(__( 'portfolio' ),$args);
}

/*-----------------------------------------------------------------------------------*/
/*	All the pre-made messages for the slide post type
/*-----------------------------------------------------------------------------------*/

function jg_slide_updated_messages( $messages ) {

  $messages[__( 'slide' )] = 
  	array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Slide updated. <a href="%s">View slide</a>','bowtie'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.','bowtie'),
		3 => __('Custom field deleted.','bowtie'),
		4 => __('Slide updated.','bowtie'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Slide restored to revision from %s','bowtie'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Slide published. <a href="%s">View slide</a>','bowtie'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Slide saved.'),
		8 => sprintf( __('Slide submitted. <a target="_blank" href="%s">Preview slide</a>','bowtie'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Slide scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview slide</a>','bowtie'),
		  // translators: Publish box date format, see http://php.net/date
		  date_i18n( __( 'M j, Y @ G:i','bowtie' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Slide draft updated. <a target="_blank" href="%s">Preview slide</a>','bowtie'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  
  return $messages;
  
}  

/*-----------------------------------------------------------------------------------*/
/*	All the pre-made messages for the portfolio post type
/*-----------------------------------------------------------------------------------*/

function jg_portfolio_updated_messages( $messages ) {

  $messages[__( 'portfolio' )] = 
  	array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Portfolio updated. <a href="%s">View portfolio</a>','bowtie'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.','bowtie'),
		3 => __('Custom field deleted.','bowtie'),
		4 => __('Portfolio updated.','bowtie'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Portfolio restored to revision from %s','bowtie'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Portfolio published. <a href="%s">View portfolio</a>','bowtie'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Portfolio saved.','bowtie'),
		8 => sprintf( __('Portfolio submitted. <a target="_blank" href="%s">Preview portfolio</a>','bowtie'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Portfolio scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview portfolio</a>','bowtie'),
		  // translators: Publish box date format, see http://php.net/date
		  date_i18n( __( 'M j, Y @ G:i','bowtie' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Portfolio draft updated. <a target="_blank" href="%s">Preview portfolio</a>','bowtie'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  
  return $messages;
  
}  

/*-----------------------------------------------------------------------------------*/
/*	Create custom taxonomies for the portfolio post type
/*-----------------------------------------------------------------------------------*/

function jg_build_taxonomies(){
	register_taxonomy(__( "skill-type" ), array(__( "portfolio" )), array("hierarchical" => true, "label" => __( "Categories" ), "singular_label" => __( "Categories" ), "rewrite" => array('slug' => 'skill-type', 'hierarchical' => true))); 
}
  
function jg_slide_edit_columns($columns){  

        $columns = array(  
            "cb" => "<input type=\"checkbox\" />",  
            "title" => __( 'Slide Title' )
        );  
  
        return $columns;  
}  
 

/*-----------------------------------------------------------------------------------*/
/*	Edit the portfolio columns
/*-----------------------------------------------------------------------------------*/

function jg_portfolio_edit_columns($columns){  

        $columns = array(  
            "cb" => "<input type=\"checkbox\" />",  
            "title" => __( 'Portfolio Item Title','bowtie' ),
            "type" => __( 'type' )
        );  
  
        return $columns;  
}  

/*-----------------------------------------------------------------------------------*/
/*	Show the taxonomies within the columns
/*-----------------------------------------------------------------------------------*/

function jg_portfolio_custom_columns($column){  
        global $post;  
        switch ($column)  
        {    
            case __( 'type' ):  
                echo get_the_term_list($post->ID, __( 'skill-type' ), '', ', ','');  
                break;
        }  
}  

add_action( 'init', 'jg_create_post_type_slides' );
add_action( 'init', 'jg_create_post_type_portfolios' );
add_action( 'init', 'jg_build_taxonomies', 0 );
add_filter('post_updated_messages', 'jg_slide_updated_messages');
add_filter('post_updated_messages', 'jg_portfolio_updated_messages');
add_filter("manage_edit-slide_columns", "jg_slide_edit_columns");  
add_filter("manage_edit-portfolio_columns", "jg_portfolio_edit_columns");  
add_action("manage_posts_custom_column",  "jg_portfolio_custom_columns");  
?>