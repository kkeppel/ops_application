<?php

/*-----------------------------------------------------------------------------------*/
/*	[raw] Function for Shortcodes - http://www.wprecipes.com/disable-wordpress-automatic-formatting-on-posts-using-a-shortcode
/*-----------------------------------------------------------------------------------*/
function jg_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

add_filter('the_content', 'jg_formatter', 99);

/*-----------------------------------------------------------------------------------*/
/*	Highlight Yellow
/*-----------------------------------------------------------------------------------*/
function jg_highlight_yellow( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'yellow'
    ), $atts));
	$out = "<span class=\"highlight\"><span class=\"yellow\">". do_shortcode($content) ."</span></span>";
    return $out;
}
add_shortcode('highlight-yellow', 'jg_highlight_yellow');

/*-----------------------------------------------------------------------------------*/
/*	Highlight Red
/*-----------------------------------------------------------------------------------*/
function jg_highlight_red( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'red'
    ), $atts));
	$out = "<span class=\"highlight\"><span class=\"red\">". do_shortcode($content) ."</span></span>";
    return $out;
}
add_shortcode('highlight-red', 'jg_highlight_red');

/*-----------------------------------------------------------------------------------*/
/*	Highlight Green
/*-----------------------------------------------------------------------------------*/
function jg_highlight_green( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'green'
    ), $atts));
	$out = "<span class=\"highlight\"><span class=\"green\">". do_shortcode($content) ."</span></span>";
    return $out;
}
add_shortcode('highlight-green', 'jg_highlight_green');

/*-----------------------------------------------------------------------------------*/
/*	Highlight Blue
/*-----------------------------------------------------------------------------------*/
function jg_highlight_blue( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'blue'
    ), $atts));
	$out = "<span class=\"highlight\"><span class=\"blue\">". do_shortcode($content) ."</span></span>";
    return $out;
}
add_shortcode('highlight-blue', 'jg_highlight_blue');

/*-----------------------------------------------------------------------------------*/
/*	Highlight Gray
/*-----------------------------------------------------------------------------------*/
function jg_highlight_gray( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'gray'
    ), $atts));
	$out = "<span class=\"highlight\"><span class=\"gray\">". do_shortcode($content) ."</span></span>";
    return $out;
}
add_shortcode('highlight-gray', 'jg_highlight_gray');

/*-----------------------------------------------------------------------------------*/
/*	Highlight Black
/*-----------------------------------------------------------------------------------*/
function jg_highlight_black( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'black'
    ), $atts));
	$out = "<span class=\"highlight\"><span class=\"black\">". do_shortcode($content) ."</span></span>";
    return $out;
}
add_shortcode('highlight-black', 'jg_highlight_black');

/*-----------------------------------------------------------------------------------*/
/*	Pricing Plan 6 Rows Shortcode
/*-----------------------------------------------------------------------------------*/
function jg_pricing_plan_six( $atts, $content = null ) {
    extract(shortcode_atts(array(
    ), $atts));
	$out = '';
	return $out;
}
add_shortcode('pricing-plan-six', 'jg_pricing_plan_six');

/*-----------------------------------------------------------------------------------*/
/*	Pricing Plan 5 Rows Shortcode
/*-----------------------------------------------------------------------------------*/
function jg_pricing_plan_five( $atts, $content = null ) {
    extract(shortcode_atts(array(
    ), $atts));
	$out = '';
    return $out;
}
add_shortcode('pricing-plan-five', 'jg_pricing_plan_five');

/*-----------------------------------------------------------------------------------*/
/*	Pricing Plan 4 Rows Shortcode
/*-----------------------------------------------------------------------------------*/
function jg_pricing_plan_four( $atts, $content = null ) {
    extract(shortcode_atts(array(
    ), $atts));
	
	$out = '';
    return $out;
}
add_shortcode('pricing-plan-four', 'jg_pricing_plan_four');

/*-----------------------------------------------------------------------------------*/
/*	Pricing Plan 3 Rows Shortcode
/*-----------------------------------------------------------------------------------*/
function jg_pricing_plan_three( $atts, $content = null ) {
    extract(shortcode_atts(array(
    ), $atts));
	$out = '';
    return $out;
}
add_shortcode('pricing-plan-three', 'jg_pricing_plan_three');

/*-----------------------------------------------------------------------------------*/
/*	Pricing Plan 2 Rows Shortcode
/*-----------------------------------------------------------------------------------*/
function jg_pricing_plan_two( $atts, $content = null ) {
    extract(shortcode_atts(array(
    ), $atts));
	$out = '';
    return $out;
}
add_shortcode('pricing-plan-two', 'jg_pricing_plan_two');

/*-----------------------------------------------------------------------------------*/
/*	Toggle Shortcode
/*-----------------------------------------------------------------------------------*/
function jg_toggle( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'title'    	 => 'Title goes here'
    ), $atts));

	
	$out .= "<div class=\"infobox-wrap toggle\"><h4><span class=\"".get_template_directory_uri()."\"></span>".$title."</h4><div class=\"inner\">".do_shortcode($content)."</div><!--inner--></div><!--infobox-wrap-->";
    return $out;
}
add_shortcode('toggle', 'jg_toggle');

/*-----------------------------------------------------------------------------------*/
/*	Image Hover with Tooltip Shortcode
/*-----------------------------------------------------------------------------------*/
function jg_image_hover_with_tooltip( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'src'    	 => 'First image url goes here',
		'data_hover' => 'Second image url goes here',
		'title'      => 'Title goes here',
		'link'       => 'URL you want it linked to',
    ), $atts));

	$out .= "<div class=\"bubbleInfo\"><a href=\"".$link."\"><img class=\"trigger\" src=\"".$src."\" data-hover=\"".$data_hover."\" title=\"\" /></a><div class=\"popup\">".do_shortcode($content)."</div><!-- end .popup --></div><!-- end .bubbleInfo -->";
	
    return $out;
}
add_shortcode('image-hover-with-tooltip', 'jg_image_hover_with_tooltip');

/*-----------------------------------------------------------------------------------*/
/*	Image Hover without Tooltip Shortcode
/*-----------------------------------------------------------------------------------*/
function jg_image_hover( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'src'    	 => 'First image url goes here',
		'data_hover' => 'Second image url goes here',
		'title'      => 'Title goes here',
		'link'       => 'URL you want it linked to',
    ), $atts));

	$out .= "<div class=\"jg_image_hover\"><a href=\"".$link."\"><img class=\"trigger\" src=\"".$src."\" data-hover=\"".$data_hover."\" title=\"\" /></a></div><!-- end .jg_image_hover -->";
	
    return $out;
}
add_shortcode('image-hover', 'jg_image_hover');

/*-----------------------------------------------------------------------------------*/
/*	Buttons Shortcode
/*-----------------------------------------------------------------------------------*/

function jg_button_silver( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'url'     	 => '#',
		'target'     => '_self',
		'position'   => 'left'
    ), $atts));
	$out = "<a href=\"" .$url. "\" target=\"" .$target. "\" class=\"buttons button_silver " .$position. "\"><span class=\"left\">".do_shortcode($content)."</span></a>";
    return $out;
}
add_shortcode('button-silver', 'jg_button_silver');

function jg_button_green( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'url'     	 => '#',
		'target'     => '_self',
		'position'   => 'left'
    ), $atts));
	$out = "<a href=\"" .$url. "\" target=\"" .$target. "\" class=\"buttons btn_green " .$position. "\"><span class=\"left\">".do_shortcode($content)."</span></a>";
    return $out;
}
add_shortcode('button-green', 'jg_button_green');

function jg_button_red( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'url'     	 => '#',
		'target'     => '_self',
		'position'   => 'left'
    ), $atts));
	$out = "<a href=\"" .$url. "\" target=\"" .$target. "\" class=\"buttons btn_red " .$position. "\"><span class=\"left\">".do_shortcode($content)."</span></a>";
    return $out;
}
add_shortcode('button-red', 'jg_button_red');

function jg_button_blue( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'url'     	 => '#',
		'target'     => '_self',
		'position'   => 'left'
    ), $atts));
	$out = "<a href=\"" .$url. "\" target=\"" .$target. "\" class=\"buttons btn_blue " .$position. "\"><span class=\"left\">".do_shortcode($content)."</span></a>";
    return $out;
}
add_shortcode('button-blue', 'jg_button_blue');

function jg_button_white( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'url'     	 => '#',
		'target'     => '_self',
		'position'   => 'left'
    ), $atts));
	$out = "<a href=\"" .$url. "\" target=\"" .$target. "\" class=\"buttons btn_white " .$position. "\"><span class=\"left\">".do_shortcode($content)."</span></a>";
    return $out;
}
add_shortcode('button-white', 'jg_button_white');

function jg_button_dark( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'url'     	 => '#',
		'target'     => '_self',
		'position'   => 'left'
    ), $atts));
	$out = "<a href=\"" .$url. "\" target=\"" .$target. "\" class=\"buttons btn_dark " .$position. "\"><span class=\"left\">".do_shortcode($content)."</span></a>";
    return $out;
}
add_shortcode('button-dark', 'jg_button_dark');


/*-----------------------------------------------------------------------------------*/
/*	Alert Shortcodes
/*-----------------------------------------------------------------------------------*/
function jg_alert_blue( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'blue'
    ), $atts));
	$out = "<div class=\"alert blue\">".do_shortcode($content)."</div>";
    return $out;
}
add_shortcode('alert-blue', 'jg_alert_blue');


function jg_alert_red( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'red'
    ), $atts));
	$out = "<div class=\"alert red\">".do_shortcode($content)."</div>";
    return $out;
}
add_shortcode('alert-red', 'jg_alert_red');

function jg_alert_orange( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'orange'
    ), $atts));
	$out = "<div class=\"alert orange\">".do_shortcode($content)."</div>";
    return $out;
}
add_shortcode('alert-orange', 'jg_alert_orange');

function jg_alert_green( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'green'
    ), $atts));
	$out = "<div class=\"alert green\">".do_shortcode($content)."</div>";
    return $out;
}
add_shortcode('alert-green', 'jg_alert_green');

function jg_alert_white( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'white'
    ), $atts));
	$out = "<div class=\"alert white\">".do_shortcode($content)."</div>";
    return $out;
}
add_shortcode('alert-white', 'jg_alert_white');


function jg_alert_dark( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'style'    	 => 'dark'
    ), $atts));
	$out = "<div class=\"alert dark\">".do_shortcode($content)."</div>";
    return $out;
}
add_shortcode('alert-dark', 'jg_alert_dark');

/*-----------------------------------------------------------------------------------*/
/*	Info Box Shortcodes
/*-----------------------------------------------------------------------------------*/
function jg_infobox( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'title'    	 => 'Title goes here'
    ), $atts));
	$out = "<div class=\"infobox-wrap\"><h4>".$title."</h4><div class=\"inner\">".do_shortcode($content)."</div><!--inner--></div><!-- end .infobox-wrap -->";
    return $out;
}
add_shortcode('infobox', 'jg_infobox');

/*-----------------------------------------------------------------------------------*/
/*	Horizontal Line Shortcode
/*-----------------------------------------------------------------------------------*/
function jg_horizontal_line( $atts, $content = null ) {
   return '<div class="hr-shortcode"></div><!-- end .hr-shortcode -->';
}
add_shortcode('horizontal-line', 'jg_horizontal_line');

/*-----------------------------------------------------------------------------------*/
/*	Column Shortcodes
/*-----------------------------------------------------------------------------------*/

// One Half
function jg_one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'jg_one_half');

function jg_one_half_last( $atts, $content = null ) {
   return '<div class="one_half column-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half_last', 'jg_one_half_last');

// One Third
function jg_one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'jg_one_third');

function jg_one_third_last( $atts, $content = null ) {
   return '<div class="one_third column-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third_last', 'jg_one_third_last');


// Two Third
function jg_two_third( $atts, $content = null ) {
	return '<div class="two_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'jg_two_third');

function jg_two_third_last( $atts, $content = null ) {
   return '<div class="two_third column-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third_last', 'jg_two_third_last');

// One Fourth
function jg_one_fourth( $atts, $content = null ) {
	return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'jg_one_fourth');

function jg_one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth column-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth_last', 'jg_one_fourth_last');

// Three Fourth
function jg_three_fourth( $atts, $content = null ) {
   return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'jg_three_fourth');

function jg_three_fourth_last( $atts, $content = null ) {
   return '<div class="three_fourth column-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth_last', 'jg_three_fourth_last');

// One Fifth
function jg_one_fifth( $atts, $content = null ) {
   return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth', 'jg_one_fifth');

function jg_one_fifth_last( $atts, $content = null ) {
   return '<div class="one_fifth column-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth_last', 'jg_one_fifth_last');

// Two Fifth
function jg_two_fifth( $atts, $content = null ) {
   return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_fifth', 'jg_two_fifth');

function jg_two_fifth_last( $atts, $content = null ) {
   return '<div class="two_fifth column-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_fifth_last', 'jg_two_fifth_last');

// Three Fifth
function jg_three_fifth( $atts, $content = null ) {
   return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fifth', 'jg_three_fifth');

function jg_three_fifth_last( $atts, $content = null ) {
   return '<div class="three_fifth column-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fifth_last', 'jg_three_fifth_last');

// Fourth Fifth
function jg_four_fifth( $atts, $content = null ) {
   return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('four_fifth', 'jg_four_fifth');

function jg_four_fifth_last( $atts, $content = null ) {
   return '<div class="four_fifth column-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('four_fifth_last', 'jg_four_fifth_last');

// One Sixth
function jg_one_sixth( $atts, $content = null ) {
   return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'jg_one_sixth');

function jg_one_sixth_last( $atts, $content = null ) {
   return '<div class="one_sixth column-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth_last', 'jg_one_sixth_last');

// Five Sixth
function jg_five_sixth( $atts, $content = null ) {
   return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('five_sixth', 'jg_five_sixth');

function jg_five_sixth_last( $atts, $content = null ) {
   return '<div class="five_sixth column-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('five_sixth_last', 'jg_five_sixth_last');


/*-----------------------------------------------------------------------------------*/
/*	Tabs Navigation Shortcode
/*-----------------------------------------------------------------------------------*/
function jg_tabs( $atts, $content = null ) {
	extract(shortcode_atts(array(
    ), $atts));
	
	global $tab_counter_1;
	global $tab_counter_2;
	
	$tab_counter_1++;
	$tab_counter_2++;
	
	$out .= '<div class="clear"></div><div class="tabs"><div class="tab_wrap">';
	
	$out .= '<ul class="nav">';
	
	$count = 1;
	
	foreach ($atts as $tab) {
		if($count == 1){$first = 'first';}else{$first = '';}
		$out .= '<li class="'.$first.'"><a title="' .$tab. '" href="#tab-' . $tab_counter_1 . '">' .$tab. '</a></li>';
		$tab_counter_1++;
		$count++;
	}
	$out .= '</ul>';

	$out .= do_shortcode($content) .'</div><!--tab_wrap--></div><!--tabs-->';
	
	return $out;
	
}
add_shortcode('tabs', 'jg_tabs');


/*-----------------------------------------------------------------------------------*/
/*	Tabs Info Area Shortcodes
/*-----------------------------------------------------------------------------------*/
function tabpanes( $atts, $content = null ) {
	extract(shortcode_atts(array(
    ), $atts));
	
	global $tab_counter_2;
	
	$out .= '<div class="tab" id="tab-' . $tab_counter_2 . '"><div class="padder">' . do_shortcode($content) .'</div></div>';
	
	$tab_counter_2++;
	
	return $out;
}
add_shortcode('tab', 'tabpanes');

?>