<?php
function get_sidebar_name($echo=0) {
	global $wpdb;
	
	if (is_single() || is_page()) {
	$temp_query = $wp_query;
	wp_reset_query();		
	
	$postssidebars = $wpdb->get_results("SELECT * FROM es_posts_sidebar WHERE PostID = ".get_the_ID());
	$sidebar = $wpdb->get_results("SELECT * FROM es_sidebars WHERE ID = ".$postssidebars[0]->SidebarID);
	$SidebarName = $sidebar[0]->Name;
		
	$wp_query = $temp_query;
	}
	
	if (is_category()) {
	$temp_query = $wp_query;
	wp_reset_query();		
	
	$catname = single_cat_title('', false);
	$catid = get_cat_ID($catname);		
	
	
	$termssidebars = $wpdb->get_results("SELECT * FROM es_terms_sidebar WHERE TermID = ".$catid);

	$sidebar = $wpdb->get_results("SELECT * FROM es_sidebars WHERE ID = ".$termssidebars[0]->SidebarID);
	$SidebarName = $sidebar[0]->Name;
	
	$wp_query = $temp_query;
	}	

	if ($SidebarName) {

		if ($echo == 1) { echo "Sidebar ".$SidebarName; }
		else { return "Sidebar ".$SidebarName; }		
	}
	
}

?>