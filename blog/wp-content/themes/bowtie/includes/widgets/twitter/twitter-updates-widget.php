<?php
/*
Plugin Name: Twitter Updates Widget
Plugin URI: http://www.creavitastudios.com/
Description: A Wonderful Plugin for Showing Latest Tweets Created by Creavita Studios.
Author:  Creavita Studios
Version: 1.0
Author URI: http://www.creavitastudios.com/
*/	
	Class tuw_widget extends WP_Widget {
		
	    function tuw_widget() {
			$default_options = array("description" => "Display your tweets.");
	        parent::WP_Widget(false, 'Bowtie Twitter Widget', $default_options);
			
			// -----
			// Load needed Javascript and CSS Files
			// -----
			// Replace Wordpress' Default jQuery file with jQuery 1.4.2 from Google's CDN
//			wp_deregister_script('jquery');
//			wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js');
//			wp_enqueue_script('jquery');

			// Main JS file of Twitter Updates Widget
			wp_enqueue_script('tuw-js', get_template_directory_uri() . '/includes/widgets/twitter/jquery.tuw.js', array('jquery'));
			
			// Stylesheet
			wp_enqueue_style('tuw', get_template_directory_uri() . '/includes/widgets/twitter/style.css', array(), false, "screen");
	    }

	    function widget($args, $i) {	
			// -----
			// Widget
			// -----
	        extract($args);
	        $title = apply_filters('widget_title', $instance['title']);
			$unique = uniqid();
			
			echo $before_widget;
			//if($i['simpletheme'] == "true") {
				echo $before_title.$i['title'].$after_title;
		//	}
			?>
				<div class="tuw_container" id="<?php echo $unique;?>"></div>
				<script type="text/javascript" language="Javascript">
					var settingsTuw<?php echo $unique;?> = {
						'username' : [<?php echo $i['username'];?>],
						'simpletheme' : false <?php //echo $i['simpletheme'];?>,
						'updates' : <?php echo $i['updates'];?>,
						'list' : <?php echo (empty($i['list'])) ? "null" : "'".$i['list']."'";?>,
						'query' : <?php echo (empty($i['query'])) ? "null" : "'".$i['query']."'";?>,
						'color' : 'blue <?php //echo $i['color'];?>',
						'openbox' : true <?php //echo $i['openbox'];?>,
						'icon' : '1 <?php //echo $i['icon'];?>',
						'autonext' : <?php echo $i['autonext'];?>,
						'duration' : <?php echo $i['duration'];?>,
						'showavatar' : true <?php //echo $i['showavatar'];?>,
						'showusername' : false <?php //echo $i['showusername'];?>,
						'showdate' : <?php echo $i['showdate'];?>,
						'singlepostmode' : false <?php //echo $i['singlepostmode'];?>,
						'effect' : 'slide<?php //echo $i['effect'];?>',
						'defaultPicture' : '<?php echo $i['defaultPicture'];?>',
						'loadingText' : "<?php echo $i['loadingText'];?>"
					};
				</script>
			<?php echo $after_widget;
	    }

	    function update($new_instance, $old_instance) {	
			// Getting and saving new settings of the widget
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['username'] = strip_tags($new_instance['username']);
			$instance['simpletheme'] = ($new_instance['simpletheme'] == "true") ? "true" : "false";
			$instance['updates'] = strip_tags($new_instance['updates']);
			$instance['list'] = strip_tags($new_instance['list']);
			$instance['query'] = strip_tags($new_instance['query']);
			$instance['color'] = strip_tags($new_instance['color']);
			$instance['openbox'] = ($new_instance['openbox'] == "true") ? "true" : "false";
			$instance['icon'] = strip_tags($new_instance['icon']);
			$instance['autonext'] = ($new_instance['autonext'] == "true") ? "true" : "false";
			$instance['duration'] = strip_tags($new_instance['duration']); "false";
			$instance['showavatar'] = ($new_instance['showavatar'] == "true") ? "true" : "false";
			$instance['showusername'] = ($new_instance['showusername'] == "true") ? "true" : "false";
			$instance['showdate'] = ($new_instance['showdate'] == "true") ? "true" : "false";
			$instance['singlepostmode'] = ($new_instance['singlepostmode'] == "true") ? "true" : "false";
			$instance['effect'] = strip_tags($new_instance['effect']);
			$instance['defaultPicture'] = strip_tags($new_instance['defaultPicture']);
			$instance['loadingText'] = strip_tags($new_instance['loadingText']);

			return $instance;
	    }

	    function form($instance) {	
			if(count($instance) == 0) {
				$username = "'envato'"; 
				$simpletheme = "false"; 
				$updates = "5"; 
				$title = "Latest Tweets";
				$list = ""; 
				$query = ""; 
				$color = "blue"; 
				$openbox = "true"; 
				$icon = "1"; 
				$autonext = "false"; 
				$duration = "5000"; 
				$showavatar = "true"; 
				$showusername = "true"; 
				$showdate = "true"; 
				$singlepostmode = "false"; 
				$effect = "slide"; 
				$defaultPicture = "http://s.twimg.com/a/1281028705/images/default_profile_6_normal.png"; 
				$loadingText = "Loading tweets..."; 
			} else {
				$title = esc_attr($instance['title']);
				$username = esc_attr($instance['username']);
				$simpletheme = esc_attr($instance['simpletheme']);
				$updates = esc_attr($instance['updates']); 
				$list = esc_attr($instance['list']); 
				$query = esc_attr($instance['query']); 
				$color = esc_attr($instance['color']);
				$openbox = esc_attr($instance['openbox']); 
				$icon = esc_attr($instance['icon']); 
				$autonext = esc_attr($instance['autonext']); 
				$duration = esc_attr($instance['duration']); 
				$showavatar = esc_attr($instance['showavatar']); 
				$showusername = esc_attr($instance['showusername']); 
				$showdate = esc_attr($instance['showdate']); 
				$singlepostmode = esc_attr($instance['singlepostmode']); 
				$effect = esc_attr($instance['effect']); 
				$defaultPicture = esc_attr($instance['defaultPicture']); 
				$loadingText = esc_attr($instance['loadingText']);
			}
	        ?>
	
				<script type="text/javascript" language="Javascript">
					var $tuwA = jQuery.noConflict();
					
					$tuwA(function(){						
						$tuwA('#<?php echo $this->get_field_id('color'); ?>').click(function(){
							var tuwPar = $tuwA(this).parentsUntil('.tuwCont');
							$tuwA('#<?php echo $this->get_field_id('prevImage'); ?>', tuwPar).attr('src', "<?php echo get_bloginfo('wpurl');?>/wp-content/widgets/twitter/images/preview/"+$tuwA(this).val()+".jpg");
						});
					});
				</script>
				<div class="tuwCont">
				
				<p><label for="<?php echo $this->get_field_id('title'); ?>"><strong><?php _e('Title'); ?></strong> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
				
	            <p><label for="<?php echo $this->get_field_id('username'); ?>"><strong><?php _e('Twitter Usernames<br> \'username1\',\'username2\'...:'); ?></strong> <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" /></label></p>
	
				<p><label for="<?php echo $this->get_field_id('list'); ?>"><strong><?php _e('List name:'); ?></strong> <input class="widefat" id="<?php echo $this->get_field_id('list'); ?>" name="<?php echo $this->get_field_name('list'); ?>" type="text" value="<?php echo $list; ?>" /></label></p>
				
				<p><label for="<?php echo $this->get_field_id('query'); ?>"><strong><?php _e('Search Query:'); ?></strong> <input class="widefat" id="<?php echo $this->get_field_id('query'); ?>" name="<?php echo $this->get_field_name('query'); ?>" type="text" value="<?php echo $query; ?>" /></label></p>
	
				<p><label for="<?php echo $this->get_field_id('updates'); ?>"><strong><?php _e('How many updates to be retrieved?'); ?></strong></label>
					<select class="widefat" name="<?php echo $this->get_field_name('updates'); ?>">
						<?php
							for($i=1;$i<100;$i++) {
								echo "<option ";
								echo ($i==$updates) ? "selected>" : ">";
								echo $i."</option>";
							}
						?>
					</select>
				</p>
				
		<!-- Color Scheme 
				<p><label for="<?php// echo $this->get_field_id('color'); ?>"><strong><?php //_e('Color scheme:'); ?></strong></label>
					<table width=100%>
						<tr><td>
					<select id="<?php //echo $this->get_field_id('color'); ?>" class="widefat" name="<?php //echo $this->get_field_name('color'); ?>">
						<?php
						/*
							$themes = array(array("Blue","blue"),array("Red","red"),array("Green","green"),array("Grey","grey"),array("Dark Blue","db"),array("Orange","orange"),array("Black&White","bw"));
							foreach($themes as $t) {
								echo "<option value='".$t[1]."' ";
								echo ($t[1]==$color) ? "selected>" : ">";
								echo $t[0]."</option>";
							}
						*/
						?>
					</select>
					</td><td width=37px>
						<div><img id="<?php //echo $this->get_field_id('prevImage'); ?>" src="<?php// echo get_bloginfo('wpurl');?>/wp-content/plugins/twitter/images/preview/<?php //echo $color;?>.jpg" /></div>
					</td></tr>
					</table>
				</p>
				<hr>
		-->	
			

		<!-- Choose an Icon 	
				<p><label for="<?php //echo $this->get_field_id('icon'); ?>"><?php// _e('Choose an icon for the widget:'); ?></label>
					<select id="<?php //echo $this->get_field_id('icon'); ?>" class="widefat" name="<?php //echo $this->get_field_name('icon'); ?>">
						<?php
						/*
							$options = array(array("Icon #1","1"),array("Icon #2","2"),array("Icon #3","3"),array("Icon #4","4"));
							foreach($options as $t) {
								echo "<option value='".$t[1]."' ";
								echo ($t[1]==$icon) ? "selected>" : ">";
								echo $t[0]."</option>";
							}
						*/
						?>
					</select>
				</p>
		-->
		
		<!-- Choose an opening/closing effect 
				<p><label for="<?php //echo $this->get_field_id('effect'); ?>"><?php //_e('Choose an opening/closing effect:'); ?></label>
					<select id="<?php //echo $this->get_field_id('effect'); ?>" class="widefat" name="<?php //echo $this->get_field_name('effect'); ?>">
						<?php
						/*
							$options = array(array("Slide","slide"),array("Fade","fade"),array("No Effect","none"));
							foreach($options as $t) {
								echo "<option value='".$t[1]."' ";
								echo ($t[1]==$effect) ? "selected>" : ">";
								echo $t[0]."</option>";
							}
						*/
						?>
					</select>
				</p>
		-->		

		<!-- Simple Theme
				<p>
					<input id="<?php //echo $this->get_field_id('simpletheme'); ?>" name="<?php //echo $this->get_field_name('simpletheme'); ?>" type="checkbox" value="true" <?php //echo ($simpletheme == "true") ? "checked" : "" ?> /> <label for="<?php //echo $this->get_field_id('simpletheme'); ?>"><?php //_e('Simple Theme'); ?></label>
				</p>
		-->
		
		<!-- Open Box	
				<p>
					<input id="<?php //echo $this->get_field_id('openbox'); ?>" name="<?php //echo $this->get_field_name('openbox'); ?>" type="checkbox" value="true" <?php //echo ($openbox == "true") ? "checked" : "" ?> /> <label for="<?php //echo $this->get_field_id('openbox'); ?>"><?php //_e('Open box at the beginning'); ?></label>
				</p>
				
		-->
		
		
				<p>
					<input id="<?php echo $this->get_field_id('showavatar'); ?>" name="<?php echo $this->get_field_name('showavatar'); ?>" type="checkbox" value="true" <?php echo ($showavatar == "true") ? "checked" : "" ?> /> <label for="<?php echo $this->get_field_id('showavatar'); ?>"><?php _e('Show user\'s avatar?'); ?></label>
				</p>
		

		<!-- Show username		
				<p>
					<input id="<?php //echo $this->get_field_id('showusername'); ?>" name="<?php //echo $this->get_field_name('showusername'); ?>" type="checkbox" value="true" <?php //echo ($showusername == "true") ? "checked" : "" ?> /> <label for="<?php //echo $this->get_field_id('showusername'); ?>"><?php //_e('Show username?'); ?></label>
				</p>
		-->
				
				<p>
					<input id="<?php echo $this->get_field_id('showdate'); ?>" name="<?php echo $this->get_field_name('showdate'); ?>" type="checkbox" value="true" <?php echo ($showdate == "true") ? "checked" : "" ?> /> <label for="<?php echo $this->get_field_id('showdate'); ?>"><?php _e('Show tweets\' date?'); ?> </label>
				</p>
				
		<!-- Single Post Mode
				
				<p>
					<input id="<?php //echo $this->get_field_id('singlepostmode'); ?>" name="<?php //echo $this->get_field_name('singlepostmode'); ?>" type="checkbox" value="true" <?php //echo ($singlepostmode == "true") ? "checked" : "" ?> /> <label for="<?php //echo $this->get_field_id('singlepostmode'); ?>"><?php// _e('<abbr title="Used for displaying only the latest tweet of the user" style="border-bottom: 1px dotted #333">Single-post-mode</abbr>?'); ?></label>
				</p>
		-->
				
				<p>
					<input id="<?php echo $this->get_field_id('autonext'); ?>" name="<?php echo $this->get_field_name('autonext'); ?>" type="checkbox" value="true" <?php echo ($autonext == "true") ? "checked" : "" ?> /> <label for="<?php echo $this->get_field_id('autonext'); ?>"><abbr style="border-bottom: 1px dotted #333" title='Tweets will be shown in order automatically after specified number of seconds.'><?php _e('Auto-Next?'); ?></abbr></label>
				</p>
				
				<p><label for="<?php echo $this->get_field_id('autonexttime'); ?>"><?php _e('The duration between moves in auto-mode:'); ?></label>
					<select id="<?php echo $this->get_field_id('autonexttime');?>" class="widefat" name="<?php echo $this->get_field_name('duration'); ?>" >
						<?php
							$autonexttime = ($autonexttime == "") ? 5000 : "";
							for($i=1;$i<21;$i++) {
								echo "<option value='".$i."000' ";
								echo ("{$i}000"==$autonexttime) ? "selected>" : ">";
								echo $i." sec</option>";
							}
						?>
					</select>
				</p>
				
		<!-- Default Picture 
				<p><label for="<?php //echo $this->get_field_id('defaultPicture'); ?>"><strong><?php //_e('Default picture:'); ?></strong> <input class="widefat" id="<?php //echo $this->get_field_id('defaultPicture'); ?>" name="<?php //echo $this->get_field_name('defaultPicture'); ?>" type="text" value="<?php //echo $defaultPicture; ?>" /></label></p>
		-->
		
				<p><label for="<?php echo $this->get_field_id('loadingText'); ?>"><strong><?php _e('Loading text:'); ?></strong> <input class="widefat" id="<?php echo $this->get_field_id('loadingText'); ?>" name="<?php echo $this->get_field_name('loadingText'); ?>" type="text" value="<?php echo $loadingText; ?>" /></label></p>

				</div>
			<?php 
	    }

	}
	add_action('widgets_init', create_function('', 'return register_widget("tuw_widget");'));
	
	register_activation_hook(__FILE__,'tuw_install');
	register_deactivation_hook(__FILE__,'tuw_uninstall');

	// Install plugin
	function tuw_install() {
		
	}

	// Uninstall plugin
	function tuw_uninstall() {
	}
?>