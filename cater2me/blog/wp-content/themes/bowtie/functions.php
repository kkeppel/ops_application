<?php

/*-----------------------------------------------------------------------------------*/
/*  Options Framework Theme Options Panel
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'optionsframework_init' ) ) {

/* Set the file path based on whether the Options Framework Theme is a parent theme or child theme */

if ( STYLESHEETPATH == TEMPLATEPATH ) {
	define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/');
} else {
	define('OPTIONS_FRAMEWORK_URL', STYLESHEETPATH . '/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/');
}

	require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');

}

/*-----------------------------------------------------------------------------------*/
/*   Thumbnails - http://core.trac.wordpress.org/ticket/15311
/*-----------------------------------------------------------------------------------*/
	require_once(TEMPLATEPATH . '/includes/custom-image-resizing.php');
	
/*-----------------------------------------------------------------------------------*/
/*	Meta Box for Pages/Posts
/*-----------------------------------------------------------------------------------*/
	require_once(TEMPLATEPATH . '/includes/meta/functions.php');
	
/*-----------------------------------------------------------------------------------*/
/*	Portfolio & Slider
/*-----------------------------------------------------------------------------------*/
	require_once(TEMPLATEPATH . '/includes/customposts/customfields.php');
	require_once(TEMPLATEPATH . '/includes/customposts/posttypes.php');
	
/*-----------------------------------------------------------------------------------*/
/*	Comments & Pings
/*-----------------------------------------------------------------------------------*/
	require_once(TEMPLATEPATH . '/includes/comments.php');

/*-----------------------------------------------------------------------------------*/
/*	Featured Images
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
		add_image_size( 'large', 400, 400, true ); // default
}

/*-----------------------------------------------------------------------------------*/
/*	Load General Javascript
/*-----------------------------------------------------------------------------------*/
function jg_register_js() {
	if (!is_admin()) {
		wp_deregister_script('jquery');
		
		wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js');
		wp_enqueue_script('jquery-ui-custom', get_template_directory_uri() . '/js/jquery-ui-1.8.5.custom.min.js', 'jquery');
		wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/jquery.fancybox-1.3.4.js', 'jquery');
		wp_enqueue_script('hover-intent', get_template_directory_uri() . '/js/hoverIntent.js', 'jquery');
		wp_enqueue_script('superfish', get_template_directory_uri() . '/js/superfish.js', 'jquery');
		wp_enqueue_script('nudge', get_template_directory_uri() . '/js/link_nudge.js', 'jquery');
		wp_enqueue_script('jg_custom', get_template_directory_uri() . '/js/scripts.js', 'jquery', '1.0', TRUE);
		
		wp_register_script('tabs', get_template_directory_uri().'/js/jquery.tabbed-widget.js', array('jquery-ui-tabs')); // called in 'tabbed-blog.php' widget

	}
}
add_action('init', 'jg_register_js');

/*-----------------------------------------------------------------------------------*/
/*	Load Home Portfolio Scripts
/*-----------------------------------------------------------------------------------*/
function jg_home_portfolio_scripts() {
	
    if ( is_front_page() ) {
	
		wp_enqueue_script('mosaic', get_template_directory_uri() . '/js/mosaic.1.0.1.min.js', 'jquery');
		wp_enqueue_script('mosaic_function', get_template_directory_uri() . '/js/mosaic_function.js');
	
	}
}
add_action('template_redirect', 'jg_home_portfolio_scripts');


/*-----------------------------------------------------------------------------------*/
/*	Load Content Slider Script
/*-----------------------------------------------------------------------------------*/
function jg_slider_content_scripts() {
    $slider_choice = of_get_option('slider_choice');
	
    if ( is_front_page() && $slider_choice == 'content') {
	
       wp_enqueue_script('slides', get_template_directory_uri() . '/js/slides.min.jquery.js', 'jquery');
	   
    }
}
add_action('template_redirect', 'jg_slider_content_scripts');

/*-----------------------------------------------------------------------------------*/
/*	Load Nivo Slider Script
/*-----------------------------------------------------------------------------------*/
function jg_slider_nivo_scripts() {
    $slider_choice = of_get_option('slider_choice');
	
    if ( is_front_page() && $slider_choice == 'nivo') {

       wp_enqueue_script('nivo', get_template_directory_uri() . '/js/jquery.nivo.slider.pack.js', 'jquery');
	   
    }
}
add_action('template_redirect', 'jg_slider_nivo_scripts');

/*-----------------------------------------------------------------------------------*/
/*	Load Portfolio Scripts & Custom Walker
/*-----------------------------------------------------------------------------------*/
function jg_portfolio_scripts() {
	if (is_front_page() || 
		is_page_template('template-portfolio-gallery.php') || 
		is_page_template('template-portfolio-one.php') || 
		is_page_template('template-portfolio-two.php') || 
		is_page_template('template-portfolio-three.php') ) {
		
		wp_enqueue_script('portfolio', get_template_directory_uri() . '/js/portfolio.js', 'jquery');
		
		require_once(TEMPLATEPATH . '/includes/customposts/walker.php');
	}
}
add_action('template_redirect', 'jg_portfolio_scripts');

/*-----------------------------------------------------------------------------------*/
/*	Wordpress 3.0+ Navigation (Top and Footer)
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'register_jg_menus' );
 
function register_jg_menus() {
	register_nav_menus(
		array(
			'main-menu' => __( 'Main Menu' ),
			'footer-menu' => __( 'Footer Menu' ),
		)
	);
}

/*-----------------------------------------------------------------------------------*/
/*	Register Widget Areas
/*-----------------------------------------------------------------------------------*/
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Home Services',
		'id'   => 'home-services',
		'description'   => 'The home page area that displays your services. Recommended to use the \'Bowtie Service Widget\'.',
		'before_widget' => '<div class="service grid_3"><div id="%1$s" class="%2$s">',
		'after_widget'  => '</div><!-- end .service .grid_3 --></div>',
		'before_title'  => '<h4 class="service-widget-title">',
		'after_title'   => '</h4>'
	));	
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Call to Action Area',
		'id'   => 'cta-widgets',
		'description'   => 'This is the call to action widget area. It\'s designed to accomodate 1 widget.',
		'before_widget' => '<div class="cta-widget "><div id="%1$s" class="%2$s">',
		'after_widget'  => '</div><!-- .cta-widget --></div>',
		'before_title'  => '<h4 class="cta-widget-title">',
		'after_title'   => '</h4>'
	));
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Blog Widgets',
		'id'   => 'general-widgets',
		'description'   => 'These are the widgets in general areas like the index page.',
		'before_widget' => '<li class="widget-block grid_4"><div id="%1$s" class="%2$s">',
		'after_widget'  => '</div></li><!-- end .widget-block .grid_4 -->',
		'before_title'  => '<h2 class="general-widget-title">',
		'after_title'   => '</h2>'
	));	
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Footer Widgets',
		'id'   => 'footer-widgets',
		'description'   => 'This is the footer widget area. It\'s designed to accomodate 3 widgets.',
		'before_widget' => '<div class="widget-block grid_4"><div id="%1$s" class="%2$s">',
		'after_widget'  => '</div><!-- end .widget-block .grid_4 --></div>',
		'before_title'  => '<h2 class="footer-widget-title">',
		'after_title'   => '</h2>'
	));	
	
/*-----------------------------------------------------------------------------------*/
/*  Custom Content Excerpt -  eg. usage: <?php jg_excerpt('10'); ?>
/*-----------------------------------------------------------------------------------*/
function jg_excerpt($num) {
    $limit = $num+1;
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).""; // Put anything between the "" to display at end
    echo $excerpt;
}

/*-----------------------------------------------------------------------------------*/
/*	Allows hastag in 'rel' input for menu system 
/*-----------------------------------------------------------------------------------*/
add_filter( 'sanitize_html_class', 'dont_filter_hash', 10, 2 );

function dont_filter_hash($sanitized, $raw) {
  if(preg_match("/^#[0-9a-fA-F]{6}$/", $raw)) {
  
    return $raw;
	
  } else { 
  
    return $sanitized;
  } 
} 

/*-----------------------------------------------------------------------------------*/
/*	Plugins
/*-----------------------------------------------------------------------------------*/
	require_once(TEMPLATEPATH . '/includes/plugins/wp-pagenavi.php');
	require_once(TEMPLATEPATH . '/includes/plugins/sidebar_generator/infinite_sidebars.php');
	
/*-----------------------------------------------------------------------------------*/
/*	Widgets 
/*-----------------------------------------------------------------------------------*/
	require_once(TEMPLATEPATH . '/includes/widgets/twitter/twitter-updates-widget.php');
	require_once(TEMPLATEPATH . '/includes/widgets/recent_posts.php');
	require_once(TEMPLATEPATH . '/includes/widgets/popular_posts.php');
	require_once(TEMPLATEPATH . '/includes/widgets/youtube_video.php');
	require_once(TEMPLATEPATH . '/includes/widgets/vimeo_video.php');
	require_once(TEMPLATEPATH . '/includes/widgets/flickr.php');
	require_once(TEMPLATEPATH . '/includes/widgets/tabbed-blog.php');
	require_once(TEMPLATEPATH . '/includes/widgets/ad120x240.php');
	require_once(TEMPLATEPATH . '/includes/widgets/ad125x125.php');
	require_once(TEMPLATEPATH . '/includes/widgets/ad300x250.php');
	require_once(TEMPLATEPATH . '/includes/widgets/services.php');
	
/*-----------------------------------------------------------------------------------*/
/*	Shortcodes
/*-----------------------------------------------------------------------------------*/
	require_once(TEMPLATEPATH . '/includes/shortcodes/theme-shortcodes.php');
	require_once(TEMPLATEPATH . '/includes/shortcodes/tinymce/tinymce.php');

/*-----------------------------------------------------------------------------------*/
/*	Set Content Width - grid_7
/*-----------------------------------------------------------------------------------*/
if ( ! isset( $content_width ) ) $content_width = 540;

/*-----------------------------------------------------------------------------------*/
/*	Automatic Feed Links - ThemeCheck bizness
/*-----------------------------------------------------------------------------------*/
if(function_exists('add_theme_support')) {
    add_theme_support('automatic-feed-links');
    //WP Auto Feed Links
}
/*-----------------------------------------------------------------------------------*/
/*	Browser Body Class - http://pastebin.com/y5BFR4q7
/*-----------------------------------------------------------------------------------*/
	require_once(TEMPLATEPATH . '/includes/meta/browser-class.php');

?>