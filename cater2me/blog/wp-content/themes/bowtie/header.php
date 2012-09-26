<?php
/**
 * The Header for our theme.
 *
 * @package WordPress
 * @subpackage Bowtie
 */
?>

<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

	<?php load_theme_textdomain('bowtie'); //localization  ?>
	
	<!-- Meta Info -->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="description" content="<?php bloginfo('description'); ?>">
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo of_get_option('favicon_icon'); ?>" />
	
	<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 * We filter the output of wp_title() a bit -- see
	 * twentyten_filter_wp_title() in functions.php.
	 */
	wp_title( '|', true, 'right' );

	?><?php bloginfo('name'); ?></title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/typography.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/960.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/jquery.fancybox-1.3.4.css" media="screen" /> 
	<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>">
	<link rel="stylesheet" media="handheld" href="<?php bloginfo('template_url'); ?>/css/handheld.css">

	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!--[if lte IE 8]>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/ie8.css">
	<![endif]-->
	
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/ie7.css">
	<![endif]-->
	
	<!-- RSS & Pingbacks -->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
<!-- All of our custom styles -->
<style type="text/css">

#logo {
  background-position:initial initial;
  background-repeat:no-repeat no-repeat;
  height:85px;
  margin-left:0;
  margin-right:20px;
}

.sf-menu a {
  font-size:16px;
}

#call-to-action h2, #cta-top h2.inner-title {
<?php $cta_typography = of_get_option('cta_typography'); if ($cta_typography) { 
echo 'font-size:'.$cta_typography['size'] . ';'; 
echo 'font-family:\''.$cta_typography['face'] . '\';';
echo 'font-style:'.$cta_typography['style'] . ';';
echo 'color:'.$cta_typography['color'] . ';';
} else {} ?> 
}

p {
<?php $post_typography = of_get_option('post_typography'); if ($post_typography) { 
echo 'font-size:'.$post_typography['size'] . ';'; 
echo 'font-family:\''.$post_typography['face'] . '\';';
echo 'font-style:'.$post_typography['style'] . ';';
echo 'color:'.$post_typography['color'] . ';';
} else {} ?> 
}

#post-content-wrap h3.post-title {
<?php $post_title_typography = of_get_option('post_title_typography'); if ($post_title_typography) { 
echo 'font-size:'.$post_title_typography['size'] . ';'; 
echo 'font-family:\''.$post_title_typography['face'] . '\';';
echo 'font-style:'.$post_title_typography['style'] . ';';
echo 'color:'.$post_title_typography['color'] . ';';
} else {} ?> 
}

.sf-menu a {
<?php $nav_typography = of_get_option('nav_typography'); if ($nav_typography) { 
echo 'font-size:'.$nav_typography['size'] . ';'; 
echo 'font-family:\''.$nav_typography['face'] . '\';';
echo 'font-style:'.$nav_typography['style'] . ';';
echo 'color:'.$nav_typography['color'] . ';';
} else {} ?> 
}

#home-blog h3 a:hover, #home-latest-blog a:hover, #blog-list h4 a:hover, ul li a:hover, .service span.read-more a:hover, .footer-nav li a:hover, .content .more-link:hover, #copyright a:hover, #post-tags a:hover, #post-author a, #comments ol.commentlist li.comment div.comment-meta a:hover, #commentform a:hover, #home-widgets ul.recent-posts .most-recent-title a:hover, #home-widgets ul.recent-posts .most-recent-title a:hover, .blog-page-post h3 a:hover, #wp-calendar a:hover, .cta-widget .tuw_twi .tuw_t .tuw_r a, #call-to-action h2 a:hover {
color:<?php echo of_get_option('hover_typography'); ?>!important;
}
#post-author a:hover {color:#000!important;}
.tab-tags a:hover {color:#333!important;}
#home-portfolio .details h4 {color:#86CCF6!important;}

<?php echo of_get_option('custom_style'); //custom style inputed from theme options panel ?>

</style>

<!-- Analytics -->
<script type="text/javascript">
<?php echo stripslashes(of_get_option('tracking_code'));  ?>
</script>
	<?php
		/* We add some JavaScript to pages with the comment form
		* to support sites with threaded comments (when in use).
		*/
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		/* Always have wp_head() just before the closing </head>
		* tag of your theme, or you will break many plugins, which
		* generally use this hook to add elements to <head> such
		* as styles, scripts, and meta tags.
		*/
		wp_head();
	?>
	
</head>

<body <?php body_class(); ?>>
	
	<div id="top-bg"></div>
	<div class="container_12" id="header" >
	
		<header>
		
			<!-- Logo -->
			<a href="<?php echo home_url( '/' ); ?>">
				<div id="logo" class="grid_4"><!-- Logo Grid Size -->
				
					<?php if(of_get_option('logo_img') != '') { // if the logo is not empty ?>
					<img src="<?php echo of_get_option('logo_img') ?>" alt="<?php bloginfo('name'); ?>" />
					<?php } else { ?>
					<img src="<?php bloginfo('template_directory') ?>/images/logo.jpg" alt="<?php bloginfo('name'); ?>" />
					<?php } ?>
					
				</div><!-- end #logo -->
			</a>
			
			<!-- Main Navigation -->
			<nav id="top_nav" class="grid_8"><!-- Navigation Grid Size -->
                <?php if ( has_nav_menu( 'main-menu' ) ) { /* if menu location 'main-menu' exists then use custom menu */ ?>
                        
                <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'items_wrap' => '<ul id="main-nav" class="sf-menu">%3$s</ul>', 'container' => '' ) ); ?>
				
                <?php } else {} // nada ?>
				
			</nav> <!-- end #top-nav  -->
			
		</header>

		<div class="clear"></div>
	</div> <!-- end #container_12 #header -->
