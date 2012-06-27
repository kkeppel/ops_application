<?php

load_theme_textdomain('bowtie'); // Localization

/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Test data
	$test_array = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
	
	// Multicheck Array
	$multicheck_array = array("one" => "French Toast", "two" => "Pancake", "three" => "Omelette", "four" => "Crepe", "five" => "Waffle");
	
	// Multicheck Defaults
	$multicheck_defaults = array("one" => "1","five" => "1");
	
	// Background Defaults
	$background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll');
	
	// Yes or No Selection
	$yes_or_no = array("true" => "Yes","false" => "No");
	
	// Slider Selection
	$slider_choice = array("nivo" => "Nivo Slider","content" => "Content Slider","none" => "None");
	
	// Content Slider Speeds
	$slider_content_speed = array("0" => "0","1000" => "1000","2000" => "2000","3000" => "3000","4000" => "4000","5000" => "5000","6000" => "6000","7000" => "7000","8000" => "8000","9000" => "9000");
	
	// Nivo Slider Effects
	$nivo_effects = array("sliceDown" => "sliceDown","sliceDownLeft" => "sliceDownLeft","sliceUp" => "sliceUp","sliceUpLeft" => "sliceUpLeft","sliceUpDown" => "sliceUpDown","sliceUpDownLeft" => "sliceUpDownLeft","fold" => "fold","fade" => "fade","random" => "random","slideInRight" => "slideInRight","slideInLeft" => "slideInLeft","boxRandom" => "boxRandom","boxRain" => "boxRain","boxRainReverse" => "boxRainReverse","boxRainGrow" => "boxRainGrow","boxRainGrowReverse" => "boxRainGrowReverse");
	
	// Navigation Selection
	$nav_choice = array("title" => "Title","rel" => "Rel","none" => "No Hover Effect");
	
	/** 
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	} 
	**/
	
	// Pull all the categories into an array
	$categories = get_categories('hide_empty=1&orderby=name');
	$options_categories = array( 0 => "Choose a category" );
	foreach ($categories as $category_list ) {
		$options_categories[$category_list->cat_ID] = $category_list->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_stylesheet_directory_uri() . '/images/';
		
	$options = array();
	
	
	// Begin HEADER Section
	$options[] = array( "name" => __('Header','bowtie'),
						"type" => "heading");
						
	$options[] = array( "name" => __('Logo','bowtie'),
						"desc" => __('Upload the image you would like to display as your logo.  The optimal size is 285x79 but any size will be accepted.','bowtie'),
						"id" => "logo_img",
						"type" => "upload");
	
	$options[] = array( "name" => __('Navigation Hover Effect','bowtie'),
						"desc" => __('Choose how or if you want to assign a 6 digit hex color to the navigation background color. Please read theme instructions for more details.','bowtie'),
						"id" => "nav_choice",
						"std" => "title",
						"type" => "radio",
						"options" => $nav_choice);
						
						
	// Begin HOME CALL TO ACTION Section	
	$options[] = array( "name" => __('Home Call to Action','bowtie'),
						"type" => "heading");
						
	$options[] = array( "name" => __('Display Call to Action Area on home page?','bowtie'),
						"desc" => __('Choose if you want to display the home page call to action area.','bowtie'),
						"id" => "cta_choice",
						"std" => "true",
						"type" => "radio",
						"options" => $yes_or_no);

	$options[] = array( "name" => __('Call to Action Sentence', 'bowtie'),
						"desc" => __('Enter the sentence to be displayed in the call to action area.', 'bowtie'),
						"id" => "cta_text",
						"std" => "Enter your call to action sentence in the theme options panel.",
						"type" => "textarea");
						
	// Begin HOME PORTFOLIO Section	
	$options[] = array( "name" => __('Home Portfolio'),
						"type" => "heading");
						
	$options[] = array( "name" => __('Display Portfolio on home page?'),
						"desc" => __('Choose if you want to display your latest portfolio items on the home page.'),
						"id" => "portfolio_choice",
						"std" => "true",
						"type" => "radio",
						"options" => $yes_or_no);
						
	$options[] = array( "name" => __('Portfolio Section Title','bowtie'),
						"desc" => __('Enter the title you want displayed for the home page portfolio area.','bowtie'),
						"id" => "portfolio_home_title",
						"std" => "Latest Portfolio Items",
						"type" => "textarea");
						
	// Begin HOME BLOG Section	
	$options[] = array( "name" => __('Home Blog','bowtie'),
						"type" => "heading");
						
	$options[] = array( "name" => __('Display Blog Area on home page?','bowtie'),
						"desc" => __('Choose if you want to display your latest blog posts on the home page.','bowtie'),
						"id" => "blog_choice",
						"std" => "true",
						"type" => "radio",
						"options" => $yes_or_no);
						
	$options[] = array( "name" => __('Blog Section Title','bowtie'),
						"desc" => __('Enter the title you want displayed for the home page blog area.','bowtie'),
						"id" => "blog_home_title",
						"std" => "Latest Blog Post",
						"type" => "textarea");
						
	$options[] = array( "name" => __('Display Specific Blog Category?','bowtie'),
						"desc" => __('Choose if you want to display a specific blog category, or, most recent post regardless of category.','bowtie'),
						"id" => "home_cat_choice",
						"std" => "true",
						"type" => "radio",
						"options" => $yes_or_no);
						
	$options[] = array( "name" => __('Select Home Blog Category','bowtie'),
						"desc" => __('If you want a specific category displayed from your blog on the home page.','bowtie'),
						"id" => "home_posts_cat",
						"type" => "select",
						"options" => $options_categories);
						
	$options[] = array( "name" => __('Blog List Title','bowtie'),
						"desc" => __('Enter the title you want displayed for the home page blog list area.','bowtie'),
						"id" => "blog_list_title",
						"std" => "More from the blog",
						"type" => "text");
						
	$options[] = array( "name" => __('Blog List Number','bowtie'),
						"desc" => __('Enter the number of posts you want to list.','bowtie'),
						"id" => "blog_list_num",
						"std" => "3",
						"type" => "text");
						
	// Begin HOME SERVICES Section	
	$options[] = array( "name" => __('Home Services','bowtie'),
						"type" => "heading");
						
	$options[] = array( "name" => __('Display Services Area on home page?','bowtie'),
						"desc" => __('Choose if you want to display services area on the home page.','bowtie'),
						"id" => "services_choice",
						"std" => "true",
						"type" => "radio",
						"options" => $yes_or_no);
						
	$options[] = array( "name" => __('Services Section Title','bowtie'),
						"desc" => __('Enter the title you want displayed for the home services area.','bowtie'),
						"id" => "services_home_title",
						"std" => "How Can We Help You?",
						"type" => "textarea");
						

	// Begin SLIDER Section				
	$options[] = array( "name" => __('Slider','bowtie'),
						"type" => "heading");
						
	$options[] = array( "name" => __('Slider Choice','bowtie'),
						"desc" => __('Choose the slider you want to display on the home page.','bowtie'),
						"id" => "slider_choice",
						"std" => "content",
						"type" => "radio",
						"options" => $slider_choice);
						
	//Begin Content slider					
	$options[] = array( "name" => __('Content Slider Options','bowtie'),
						"desc" => __('If you have chosen the Content Slider as your home page slider, then you can adjust these options.','bowtie'),
						"type" => "info");
						
	$options[] = array( "name" => __('Content Slider Play Time','bowtie'),
						"desc" => __('Enter the slide play time you want in milliseconds. Enter 0 if you don\'t want slider to auto move. e.g. 6000','bowtie'),
						"id" => "content_play_time",
						"std" => "6000",
						"type" => "text");
						
	$options[] = array( "name" => __('Content Slider Pause Time','bowtie'),
						"desc" => __('Enter the slide pause time you want in milliseconds. e.g. 4500','bowtie'),
						"id" => "content_pause_time",
						"std" => "4500",
						"type" => "text");
						
	$options[] = array( "name" => __('Content Slider Rotation Time','bowtie'),
						"desc" => __('Enter the slide rotation time you want in milliseconds. e.g. 600','bowtie'),
						"id" => "content_rotation_time",
						"std" => "600",
						"type" => "text");
						
	// Begin Nivo slider options					
	$options[] = array( "name" => __('Nivo Slider Options','bowtie'),
						"desc" => __('If you have chosen Nivo as your home page slider, then you can adjust these options.','bowtie'),
						"type" => "info");
						
	$options[] = array( "name" => __('Nivo Slide Effect','bowtie'),
						"desc" => __('Select the transition effect you want.','bowtie'),
						"id" => "nivo_effect",
						"std" => "fade",
						"type" => "select",
						"options" => $nivo_effects);
						
	$options[] = array( "name" => __('Nivo Slices','bowtie'),
						"desc" => __('Enter the number of slices you want if using a slice effect. e.g. 15','bowtie'),
						"id" => "nivo_slice_num",
						"std" => "15",
						"type" => "text");
						
	$options[] = array( "name" => __('Nivo Box Columns','bowtie'),
						"desc" => __('Enter the number of box columns you want if using a box effect. e.g. 8','bowtie'),
						"id" => "nivo_box_cols",
						"std" => "8",
						"type" => "text");
						
	$options[] = array( "name" => __('Nivo Box Rows','bowtie'),
						"desc" => __('Enter the number of box rows you want if using a box effect. e.g. 4','bowtie'),
						"id" => "nivo_box_rows",
						"std" => "4",
						"type" => "text");
						
	$options[] = array( "name" => __('Nivo Slide Transition Speed','bowtie'),
						"desc" => __('Enter the slide transition speed you want in milliseconds. e.g. 500','bowtie'),
						"id" => "nivo_transition_speed",
						"std" => "500",
						"type" => "text");
						
	$options[] = array( "name" => __('Nivo Slide Pause Time','bowtie'),
						"desc" => __('Enter the slide pause time you want in milliseconds. e.g. 3000','bowtie'),
						"id" => "nivo_pause_time",
						"std" => "3000",
						"type" => "text");
						
	$options[] = array( "name" => __('Nivo Caption Opacity','bowtie'),
						"desc" => __('Enter the amount of opacity you want if using a slide caption. e.g. 0.8','bowtie'),
						"id" => "nivo_caption_opacity",
						"std" => "0.8",
						"type" => "text");
						
	// Begin PAGES & POSTS Section	
	$options[] = array( "name" => __('Pages & Posts','bowtie'),
						"type" => "heading");
						
	$options[] = array( "name" => __('Right or Left Sidebars','bowtie'),
						"desc" => __('Select the side of post sidebars.','bowtie'),
						"id" => "sidebar_position",
						"std" => "right",
						"type" => "images",
						"options" => array(
							'right' => $imagepath . '2cr.png',
							'left' => $imagepath . '2cl.png')
						);
						
	$options[] = array( "name" => __('Blog Page Title','bowtie'),
						"desc" => __('Enter your blog page title.','bowtie'),
						"id" => "blog_title",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Portfolio Page Title','bowtie'),
						"desc" => __('Enter your portfolio page title.','bowtie'),
						"id" => "portfolio_title",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('404 Error Page Title','bowtie'),
						"desc" => __('Enter your 404 error page title.','bowtie'),
						"id" => "error_title",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Display Author Box on Posts','bowtie'),
						"desc" => __('Choose if you want to display the author info box at the end of posts.','bowtie'),
						"id" => "author_choice",
						"std" => "yes",
						"type" => "radio",
						"options" => $yes_or_no);
						

	// Begin FOOTER Section
	$options[] = array( "name" => __('Footer','bowtie'),
						"type" => "heading");				
						
	$options[] = array( "name" => __('Display Footer Widgets?','bowtie'),
						"desc" => __('Choose if you want to display the footer widgets at all.','bowtie'),
						"id" => "footer_choice",
						"std" => "true",
						"type" => "radio",
						"options" => $yes_or_no);

	$options[] = array( "name" => __('Display Footer Widgets as a Dropdown?','bowtie'),
						"desc" => __('Choose if you want to display the footer widgets as a dropdown or as a standard display.','bowtie'),
						"id" => "footer_dropdown_choice",
						"std" => "true",
						"type" => "radio",
						"options" => $yes_or_no);
							
	$options[] = array( "name" => __('Copyright Text','bowtie'),
						"desc" => __('Enter the text you want displayed in the footer copyright area.','bowtie'),
						"id" => "copyright_text",
						"std" => "Copyright &copy; 2011 Jami Gibbs - All rights reserved",
						"type" => "textarea"); 
						
	$options[] = array( "name" => __('Social Icons','bowtie'),
						"type" => "heading");	
						
	$options[] = array( "name" => __('Twitter Username','bowtie'),
						"desc" => __('Paste your Twitter username','bowtie'),
						"id" => "twitter_username",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Twitter Title','bowtie'),
						"desc" => __('Enter the Twitter link title','bowtie'),
						"id" => "twitter_title",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Facebook Link','bowtie'),
						"desc" => __('Paste your Facebook URL','bowtie'),
						"id" => "facebook_link",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Facebook Title','bowtie'),
						"desc" => __('Enter the Facebook link title','bowtie'),
						"id" => "facebook_title",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Linkedin Link','bowtie'),
						"desc" => __('Paste your Linkedin URL','bowtie'),
						"id" => "linkedin_link",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Linkedin Title','bowtie'),
						"desc" => __('Enter the Linkedin link title','bowtie'),
						"id" => "linkedin_title",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Dribbble Link','bowtie'),
						"desc" => __('Paste your Dribbble URL','bowtie'),
						"id" => "dribbble_link",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Dribbble Title','bowtie'),
						"desc" => __('Enter the Dribbble link title','bowtie'),
						"id" => "dribbble_title",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Forrst Link','bowtie'),
						"desc" => __('Paste your Forrst URL','bowtie'),
						"id" => "forrst_link",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Forrst Title','bowtie'),
						"desc" => __('Enter the Forrst link title','bowtie'),
						"id" => "forrst_title",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Google Plus Link','bowtie'),
						"desc" => __('Paste your Google Plus URL','bowtie'),
						"id" => "google_link",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Google Plus Title','bowtie'),
						"desc" => __('Enter the Google Plus link title','bowtie'),
						"id" => "google_title",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('RSS Feed Link','bowtie'),
						"desc" => __('Paste your RSS Feed URL','bowtie'),
						"id" => "rss_link",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('RSS Feed Title','bowtie'),
						"desc" => __('Enter the RSS feed title','bowtie'),
						"id" => "rss_title",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Contact Link','bowtie'),
						"desc" => __('Paste a link to your contact form or any other contact URL.','bowtie'),
						"id" => "contact_link",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Contact Title','bowtie'),
						"desc" => __('Enter the contact link title','bowtie'),
						"id" => "contact_title",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Share This Site HTML Code','bowtie'),
						"desc" => __('Enter your ShareThis code.  http://sharethis.com/ ','bowtie'),
						"id" => "sharethis_code",
						"std" => "",
						"type" => "textarea"); 
						
	$options[] = array( "name" => __('ShareThis Publisher ID','bowtie'),
						"desc" => __('Enter your publisher ID from ShareThis. http://sharethis.com/','bowtie'),
						"id" => "sharethis_id",
						"std" => "",
						"type" => "text");
						
						
						
						
	// Begin STYLES Section	- fonts listed in 'options-sanitize.php' line 278
	$options[] = array( "name" => __('Styles','bowtie'),
						"type" => "heading");
						
	$options[] = array( "name" => __('Call to Action Text','bowtie'),
						"desc" => __('Font style for the call to action area on the home page and call to action on single posts. Default is Lato.','bowtie'),
						"id" => "cta_typography",
						"std" => array('size' => '42px','face' => 'Lato','style' => 'normal','color' => '#eeeeee'),
						"type" => "typography");
						
	$options[] = array( "name" => __('Post Text','bowtie'),
						"desc" => __('Font style for the main reading area in posts (paragraphy tags). Default is Droid Sans.','bowtie'),
						"id" => "post_typography",
						"std" => array('size' => '12px','face' => 'Droid Sans','style' => 'normal','color' => '#585858'),
						"type" => "typography");
						
	$options[] = array( "name" => __('Post Title Text','bowtie'),
						"desc" => __('Font style for the post titles. Default is Lato.','bowtie'),
						"id" => "post_title_typography",
						"std" => array('size' => '30px','face' => 'Lato','style' => 'normal','color' => '#3C3C3C'),
						"type" => "typography");
						
	$options[] = array( "name" => __('Navigation Text','bowtie'),
						"desc" => __('Font style for the navigation. Default is Lato #8A8A8A.','bowtie'),
						"id" => "nav_typography",
						"std" => array('size' => '15px','face' => 'Lato','style' => 'normal','color' => '#8A8A8A'),
						"type" => "typography");
						
	$options[] = array( "name" => __('Links Hover Color','bowtie'),
						"desc" => __('Color to display when a link is hovered. Default is #458AB3.','bowtie'),
						"id" => "hover_typography",
						"std" => "#458AB3",
						"type" => "color");
						
	$options[] = array( "name" => __('Custom Style','bowtie'),
						"desc" => __('Enter your custom style here.'),
						"id" => "custom_style",
						"std" => "",
						"type" => "textarea"); 
						
						
						
						
	// Begin OTHER Section	
	$options[] = array( "name" => __('Other','bowtie'),
						"type" => "heading");
						
	$options[] = array( "name" => __('Favicon','bowtie'),
						"desc" => __('A favicon is most commonly 16x16 pixels in size.  It will be displayed in your browser tab when your website is loaded.  If you need help generating a favicon, you can go here: www.favicon.cc','bowtie'),
						"id" => "favicon_icon",
						"type" => "upload");
						
	$options[] = array( "name" => __('Analytics Tracking Code','bowtie'),
						"desc" => __('Paste your tracking code here i.e. Google Analytics.','bowtie'),
						"id" => "tracking_code",
						"std" => "",
						"type" => "textarea"); 
						
							
	return $options;
}