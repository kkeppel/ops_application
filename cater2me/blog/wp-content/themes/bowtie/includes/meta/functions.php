<?php

load_theme_textdomain('bowtie'); // Localization

// http://www.farinspace.com/how-to-create-custom-wordpress-meta-box/

define('MY_WORDPRESS_FOLDER',$_SERVER['DOCUMENT_ROOT']);
define('MY_THEME_FOLDER',str_replace('\\','/',dirname(__FILE__)));
define('MY_THEME_PATH','/' . substr(MY_THEME_FOLDER,stripos(MY_THEME_FOLDER,'wp-content')));

add_action('admin_init','my_meta_init');

function my_meta_init()
{
	// review the function reference for parameter details
	// http://codex.wordpress.org/Function_Reference/wp_enqueue_script
	// http://codex.wordpress.org/Function_Reference/wp_enqueue_style

	//wp_enqueue_script('my_meta_js', MY_THEME_PATH . '/custom/meta.js', array('jquery'));
	wp_enqueue_style('my_meta_css', MY_THEME_PATH . '/custom/meta.css');

	// review the function reference for parameter details
	// http://codex.wordpress.org/Function_Reference/add_meta_box

	foreach (array('post','page','portfolio') as $type) 
	{
		add_meta_box('my_all_meta',  __('Theme Meta Box','bowtie'), 'my_meta_setup', $type, 'normal', 'high');
	}
	
	add_action('save_post','my_meta_save');
}

function my_meta_setup()
{
	global $post;
 
	// using an underscore, prevents the meta variable
	// from showing up in the custom fields section
	$meta = get_post_meta($post->ID,'_my_meta',TRUE);
 
	// instead of writing HTML here, lets do an include
	include(MY_THEME_FOLDER . '/custom/meta.php');
 
	// create a custom nonce for submit verification later
	echo '<input type="hidden" name="my_meta_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
}
 
function my_meta_save($post_id) 
{
	// authentication checks

	// make sure data came from our meta box
	if (!wp_verify_nonce($_POST['my_meta_noncename'],__FILE__)) return $post_id;

	// check user permissions
	if ($_POST['post_type'] == 'page') 
	{
		if (!current_user_can('edit_page', $post_id)) return $post_id;
	}
	else 
	{
		if (!current_user_can('edit_post', $post_id)) return $post_id;
	}

	// authentication passed, save data

	// var types
	// single: _my_meta[var]
	// array: _my_meta[var][]
	// grouped array: _my_meta[var_group][0][var_1], _my_meta[var_group][0][var_2]

	$current_data = get_post_meta($post_id, '_my_meta', TRUE);	
 
	$new_data = $_POST['_my_meta'];

	my_meta_clean($new_data);
	
	if ($current_data) 
	{
		if (is_null($new_data)) delete_post_meta($post_id,'_my_meta');
		else update_post_meta($post_id,'_my_meta',$new_data);
	}
	elseif (!is_null($new_data))
	{
		add_post_meta($post_id,'_my_meta',$new_data,TRUE);
	}

	return $post_id;
}

function my_meta_clean(&$arr)
{
	if (is_array($arr))
	{
		foreach ($arr as $i => $v)
		{
			if (is_array($arr[$i])) 
			{
				my_meta_clean($arr[$i]);

				if (!count($arr[$i])) 
				{
					unset($arr[$i]);
				}
			}
			else 
			{
				if (trim($arr[$i]) == '') 
				{
					unset($arr[$i]);
				}
			}
		}

		if (!count($arr)) 
		{
			$arr = NULL;
		}
	}
}

/*------------------------------------------------*/
/*	Video Meta (added in v1.4)
/*------------------------------------------------*/
add_action('admin_init','my_video_init');

function my_video_init()
{
		add_meta_box('my_video_meta', __('Video Options','bowtie'), 'my_video_options', 'portfolio', 'normal', 'high');	
}

function my_video_options(){
      global $post;
      ?>
      <div class="my_meta_control">
	  
		<p><?php _e('Use this area to display a video for this portfolio post.','bowtie')?> </p>
      
      <label><?php _e('Use Video','bowtie')  ?>
      <input type="hidden" name="use_video_meta" value="off" />
      <input type="checkbox" name="use_video_meta" <?php if( get_post_meta($post->ID, 'use_video', true) == 'on' ) echo ' checked ';?> />
      </label>  
      
      <label><?php _e('Select Video type','bowtie') ?></label>
      <select name="pf_video_meta" >      
      
      <option value="youtube" <?php if( get_post_meta($post->ID, 'pf_video', true) == 'youtube' ) echo ' selected ';?>  >YouTube</option>
      <option value="vimeo" <?php if( get_post_meta($post->ID, 'pf_video', true) == 'vimeo' ) echo ' selected ';?>  >Vimeo</option>
      <option value="dailymotion" <?php if( get_post_meta($post->ID, 'pf_video', true) == 'dailymotion' ) echo ' selected ';?> >Dailymotion</option>
      
      </select>
      <label><?php _e('Youtube Video ID (ex. EhkHFenJ3rM)','bowtie') ?></label>
      <input size="60" name="youtube_id_meta" value="<?php  echo get_post_meta($post->ID, 'youtube_id', true); ?>" />
      <label><?php _e('Vimeo Video ID (ex. 11334082)','bowtie') ?></label>
      <input size="60" name="vimeo_id_meta"  value="<?php  echo get_post_meta($post->ID, 'vimeo_id', true); ?>" />
      <label><?php _e('Dailymotion Video ID (ex. xil34i_nicki-minaj-super-bass_music)','bowtie') ?></label>
      <input size="60" name="dailymotion_id_meta" value="<?php  echo get_post_meta($post->ID, 'dailymotion_id', true); ?>" />
      
      
      </div>
      <?php

}

add_action('save_post', 'my_save_video', 100);
function my_save_video(){

global $post;
  if( (get_post_type() == 'portfolio') && is_admin() ){ 

// var_dump(   $_POST ); 

  if( isset($_POST["use_video_meta"]) )
  update_post_meta($post->ID, "use_video", $_POST["use_video_meta"]   );
  
  if( isset($_POST["pf_video_meta"]) )
  update_post_meta($post->ID, "pf_video", $_POST["pf_video_meta"]   );
  
  if( isset($_POST["youtube_id_meta"]) )
  update_post_meta($post->ID, "youtube_id", $_POST["youtube_id_meta"]   );
  
  if( isset($_POST["vimeo_id_meta"]) )
  update_post_meta($post->ID, "vimeo_id", $_POST["vimeo_id_meta"]   );
  
  if( isset($_POST["dailymotion_id_meta"]) )
  update_post_meta($post->ID, "dailymotion_id", $_POST["dailymotion_id_meta"]   );
  }

}


?>