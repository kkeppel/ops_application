<?php

/*
if (!function_exists("get_wp_path")) {

function get_wp_path($filename) {


	$url = explode("wp-content", getcwd());
	if (count($url) <= 1) {
		$url = explode("wp-admin", getcwd());
		if (count($url) <= 1) {
			$url[0] = getcwd()."/";
		}
	}
	
	return $url[0].$filename;
}

}
*/

require_once( ABSPATH . ('wp-includes/pluggable.php'));
require_once( ABSPATH . ('wp-admin/includes/upgrade.php'));
global $wpdb;

// Create mysql tables

$sql = "CREATE TABLE 
					es_posts_sidebar (
	  				ID bigint(20) NOT NULL AUTO_INCREMENT,
	  				PostID bigint(20) NOT NULL,
	  				SidebarID bigint(20) NOT NULL,
						PRIMARY KEY (`ID`) 
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8;							
					
				CREATE TABLE 
					es_sidebars (
	  				ID bigint(20) NOT NULL AUTO_INCREMENT,
	  				Name varchar(255) NOT NULL,
						PRIMARY KEY (`ID`) 
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
					
				CREATE TABLE 
					es_terms_sidebar (
	  				ID bigint(20) NOT NULL AUTO_INCREMENT,
	  				TermID bigint(20) NOT NULL,
	  				SidebarID bigint(20) NOT NULL,
						PRIMARY KEY (`ID`) 
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8;					
				
						
				";

dbDelta($sql);

$sidebarexists = $wpdb->get_var($wpdb->prepare("SELECT ID FROM es_sidebars WHERE Name = 'defaultsidebar'" ));					

if (!$sidebarexists) {
$wpdb->query("INSERT INTO es_sidebars
			(Name)
				VALUES ('defaultsidebar')");	
}

// Create sidebar edit box for all custom posts and normal posts and pages

$customposttypes = $wpdb->get_results("SELECT DISTINCT post_type FROM ".$wpdb->prefix."posts
																				 WHERE post_type <> 'attachment'
																				 		AND post_type <> 'nav_menu_item'
																				 			AND post_type <> 'revision'");

foreach($customposttypes as $customposttype) { 

	add_meta_box( 'myplugin_sectionid', __( 'Show sidebar', 'myplugin_textdomain' ), 
	                'Show_sidebar', $customposttype->post_type, 'side', 'high' );                
                
}

// Action for saving the sidebar selected

add_action('save_post', 'Sidebar_config_save');


// Show sidebar config form function

function Show_sidebar() {
	global $wpdb, $_GET;
	
	echo '<table border=0 cellspacing=0 cellpadding=0 >
	<tr>
	<td style="font-size: 11px !important;">Show sidebar</td>
	<td style="padding: 0px 0px 0px 5px;">
		<select name="SideBar">';
//			<option value="0">No sidebar</option>';
	
	$sidebars = $wpdb->get_results("SELECT * FROM es_sidebars");
	$sidebarID = $wpdb->get_var($wpdb->prepare("SELECT SidebarID FROM es_posts_sidebar WHERE PostID = ".$_GET['post']));		
	
	//print_r($sidebars);
	
	foreach($sidebars as $sidebar) {
		
		echo '<option value="'.$sidebar->ID.'"'; if ($sidebar->ID == $sidebarID) { echo ' selected=selected'; } echo '>'.$sidebar->Name.'</option>';
		
	}
			
	echo '
		</select>
	</td>
	</tr>
	</table>
	<p class="howto">Select which sidebar you want to show on this post.</p>
	';	
	
}

// Save sidebar option function

function Sidebar_config_save() {
	global $_POST, $wpdb;
	
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
        return $postID;
  
  
	
	$sidebarexists = $wpdb->get_var($wpdb->prepare("SELECT ID FROM es_posts_sidebar WHERE PostID = ".$_POST['post_ID']));		
	
	if ($sidebarexists) {
		if ($_POST['SideBar'] != 0) {
		$wpdb->query("UPDATE es_posts_sidebar SET 
			SidebarID = '".$_POST['SideBar']."'
				WHERE PostID = ".$_POST['post_ID'] );		
		}
		else {
		$wpdb->query("DELETE FROM es_posts_sidebar 
				WHERE PostID = ".$_POST['post_ID'] );					
		}
	}
	else {
		if ($_POST['SideBar'] != 0) {
		$wpdb->query("INSERT INTO es_posts_sidebar 
			(PostID, SidebarID)
				VALUES (".$_POST['post_ID'].",".$_POST['SideBar'].")");
		}
	}
	
	
}

add_action ('edit_category_form_fields', 'es_category_sidebar_form_fields');
add_action ('category_add_form_fields', 'es_category_sidebar_form_fields_add');
add_action ('edited_terms', 'es_category_sidebar_form_save');
add_action ('create_category', 'es_category_sidebar_form_save_add', $category_ID);

function es_category_sidebar_form_fields() {
	global $_GET, $wpdb;
	
	// category sidebar
	$content = '<tr class="form-field">';
	$content .= '<th scope="row" valign="top"><label for="category_theme">Show sidebar</label></th>';
	$content .= '<td>';
  $content .= '<select name="SideBar" id="category_sidebar">';
 	$content .= '<option value="0">No sidebar</option>';
   
	$sidebars = $wpdb->get_results("SELECT * FROM es_sidebars");
	$sidebarID = $wpdb->get_var($wpdb->prepare("SELECT SidebarID FROM es_terms_sidebar WHERE TermID = ".$_GET['tag_ID']));		
	
	
	foreach($sidebars as $sidebar) {
		
		$content .= '<option value="'.$sidebar->ID.'"'; if ($sidebar->ID == $sidebarID) {$content .= ' selected=selected'; } $content .= '>'.$sidebar->Name.'</option>';
		
	}
	
	$content .= '</select>';
	$content .= '<p class="description">Select which sidebar you want to show on this category.</p>';
	$content .= '</td>';
	$content .= '</tr>';
	
	echo $content;	
}

function es_category_sidebar_form_fields_add() {
	global $_GET, $wpdb;
	
	
	// category sidebar
	$content = '<div class="form-field">';
	$content .= '<label for="category_theme">Show sidebar</label>';
  $content .= '<select name="SideBar" id="category_sidebar">';
 	$content .= '<option value="0">No sidebar</option>';
   
	$sidebars = $wpdb->get_results("SELECT * FROM es_sidebars");
	$sidebarID = $wpdb->get_var($wpdb->prepare("SELECT SidebarID FROM es_terms_sidebar WHERE TermID = ".$_GET['tag_ID']));		
	
	
	foreach($sidebars as $sidebar) {
		
		$content .= '<option value="'.$sidebar->ID.'"'; if ($sidebar->ID == $sidebarID) {$content .= ' selected=selected'; } $content .= '>'.$sidebar->Name.'</option>';
		
	}
	
	$content .= '</select>';
	$content .= '<p>Select which sidebar you want to show on this category. Select <b>No sidebar</b> if you want to create a full page layout.</p>';
	$content .= '</div>';
	
	echo $content;	
}

function es_category_sidebar_form_save() {
	global $_POST, $_GET, $wpdb;
	
	// sidebar
	$sidebarexists = $wpdb->get_var($wpdb->prepare("SELECT ID FROM es_terms_sidebar WHERE TermID = ".$_POST['tag_ID']));		
	
	if ($sidebarexists) {
		if ($_POST['SideBar'] != 0) {
		$wpdb->query("UPDATE es_terms_sidebar SET 
			SidebarID = '".$_POST['SideBar']."'
				WHERE TermID = ".$_POST['tag_ID'] );		
		}
		else {
		$wpdb->query("DELETE FROM es_terms_sidebar 
				WHERE TermID = ".$_POST['tag_ID'] );					
		}
	}
	else {
		if ($_POST['SideBar'] != 0) {
		$wpdb->query("INSERT INTO es_terms_sidebar 
			(TermID, SidebarID)
				VALUES (".$_POST['tag_ID'].",".$_POST['SideBar'].")");
		}
	}		
	
}

function es_category_sidebar_form_save_add($category_ID) {
	global $_POST, $_GET, $wpdb;
	
	// sidebar

	$wpdb->query("INSERT INTO es_terms_sidebar 
		(TermID, SidebarID)
			VALUES (".$category_ID.",".$_POST['SideBar'].")");
	

	
}

include('config_page.php');
include('generate_sidebars.php');
include('sidebar_functions.php');


?>