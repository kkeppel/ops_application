<?php
if (function_exists("register_sidebar")) {
	$sidebars = $wpdb->get_results("SELECT * FROM es_sidebars");	

   foreach($sidebars as $sidebar) {
   	register_sidebar(Array(
		"name" => sprintf(__('Sidebar '.$sidebar->Name), $sidebar->ID), 
		"id" => 'sidebar-'.$sidebar->ID,
		'description'   => 'These are the widgets in general areas like the index page.',
		'before_widget' => '<div class="widget-block grid_4"><div id="%1$s" class="%2$s">',
		'after_widget'  => '</div><!-- end .widget-block #grid_4 --></div>',
		'before_title'  => '<h2 class="general-widget-title">',
		'after_title'   => '</h2>'
	));
   }
}

// show the desired sidebar



?>