<?php
// add config page in wordpress menu
add_action('admin_menu', 'sidebar_config_menu');  

function sidebar_config_menu() {
	add_submenu_page('themes.php', 'setup sidebars', 'Sidebars', 'administrator', 'setup_sidebars', 'setup_sidebars');	
}

// build config page

function setup_sidebars() {
	global $_POST, $_GET, $wpdb;
	
	if ($_POST['addsidebar'] == 1 ) {
		add_sidebars();
	}	
	if ($_GET['deleteid']) {
		delete_sidebars();
	}		
	
	$content = '<div class="wrap">';
	$content .= '<div id="icon-themes" class="icon32"><br /></div>';
	$content .= '<h2>Manage sidebars</H2><br/>';

	$content .= '<table class="widefat post fixed">';
	$content .= '<thead>';		
	$content .= '<tr>';		
	$content .= '<th class="manage-column column-title">Sidebar name</th>';		
	$content .= '<th class="manage-column column-title">Actions</th>';		
	$content .= '</tr>';	
	$content .= '</thead>';		

	$content .= '<tbody>';		
	$content .= '<tr class="alternate author-self status-publish iedit">';
	$content .= '<td class="column-title post-title">defaultsidebar</td>';	
	$content .= '<td>This sidebar can\'t be deleted.</td>';	
	$content .= '</tr>';	
	
	$sidebars = $wpdb->get_results("SELECT * FROM es_sidebars WHERE Name <> 'defaultsidebar'");
	
	$nr = 1;
	foreach($sidebars as $sidebar) {
	
	if ($nr%2 == 1) {
	$content .= '<tr class="author-self status-publish iedit">';		
	}
	else {
	$content .= '<tr class="alternate author-self status-publish iedit">';	
	}
	$content .= '<td>'.$sidebar->Name.'</td>';	
	$content .= '<td><a href="admin.php?page=setup_sidebars&deleteid='.$sidebar->ID.'">DELETE</a></td>';		
	$content .= '</tr>';	
		
	$nr++;
	}
	$content .= '</tbody>';		
	
	$content .= '<tfoot>';		
	$content .= '<tr>';		
	$content .= '<th class="manage-column column-title">Sidebar name</th>';		
	$content .= '<th class="manage-column column-title">Actions</th>';		
	$content .= '</tr>';	
	$content .= '</tfoot>';		
	
	$content .= '</table>';
	
	echo $content;
	
	$content  = '<div class="tablenav">';
	$content .= '<form name=addsidebars id="widgetsAddSidebar" method=POST action="admin.php?page=setup_sidebars">';
	$content .= '<input type=hidden name=addsidebar value=1>';	
	$content .= '<table border=0 cellspacing=0 cellpadding=0>';
	$content .= '<tr>';
	$content .= '<td>Add new sidebar</td>';
	$content .= '<td style="padding: 5px;"><input type=text name=sidebarname value="" size=50></td>';
	$content .= '<td><input class="button-secondary action" type=submit value="Add"></td>';
	$content .= '</tr>';
	$content .= '</table>';		
	$content .= '</form>';
	$content .= '</div>';

	$content .= '</div>';

	
	echo $content;
	
}

function delete_sidebars() {
	global $_GET, $wpdb;
	
	$wpdb->query("DELETE FROM es_sidebars
			WHERE ID = ".$_GET['deleteid']);	
	
}

function add_sidebars() {
	global $_POST, $wpdb;
	
	$sidebarexists = $wpdb->get_var($wpdb->prepare("SELECT ID FROM es_sidebars WHERE Name = '".$_POST['sidebarname']."'" ));
	
	if (!$sidebarexists) {
		$sidebar_name = $_POST['sidebarname'];
	}
	else {
		$sidebar_name = $_POST['sidebarname']."_copy";
	}
	
	$wpdb->query("INSERT INTO es_sidebars
			(Name)
				VALUES ('".$sidebar_name."')");
	
}

?>