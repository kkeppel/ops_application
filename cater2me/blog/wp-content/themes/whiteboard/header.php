<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"> 

<head>

	<meta charset="UTF-8">
	
	<title><?=(($template['title'])?$template['title']:'Cater2.me | Office Catering in San Francisco and the Bay Area')?></title>
	<meta name="description" content="<?=(($template['meta_name'])?$template['meta_name']:'Cater2.me connects curated, up-and-coming catering providers with companies through simplified ordering and personalized, 24/7 customer service.')?>">
	
	<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
	
	<link rel="shortcut icon" href="http://cater2.me/template/favicon.ico">
	
	<link rel="stylesheet" href="http://cater2.me/template/css/reset.css" />
	<link rel="stylesheet" href="http://cater2.me/template/css/typography.css" />
	<link rel="stylesheet" href="http://cater2.me/template/css/960.css" />
	<link rel="stylesheet" type="text/css" href="http://cater2.me/template/css/jquery.fancybox-1.3.4.css" media="screen" />
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/base/jquery-ui.css" />
	<link rel="stylesheet" href="http://cater2.me/template/tuw-inc/style.css" type="text/css" media="screen" />
	
	<link rel="stylesheet" href="http://cater2.me/template/css/style.css">
	<link rel="stylesheet" media="handheld" href="http://cater2.me/template/css/handheld.css">
	
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="http://cater2.me/template/css/ie8.css">
	<![endif]-->
	
	<!-- Libraries -->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
	
	<!-- Image Display Effects -->
	<script src="/template/js/jquery.fancybox-1.3.4.js"></script>
	
	<!-- Image Hover Effects -->
	<script src="/template/js/mosaic.1.0.1.min.js"></script>
	
	<!-- Tooltips -->
	<script src="/template/js/jquery.tooltip.min.js"></script>
	
	<!-- Portfolio Sorting -->
	<script src="/template/js/portfolio.js"></script>
	
	<!-- Navigation Dropdown Menu -->
	<script src="/template/js/hoverIntent.js"></script>
	<script src="/template/js/superfish.js"></script>
	
	<!-- Twitter Rotator -->
	<script src="/template/tuw-inc/jquery.tuw.js"></script>
	
	<!-- AJAX Contact Form  -->
	<script type="text/javascript" src="/template/includes/js/jquery.jigowatt.js"></script>

	<!-- Script Functions -->
	<script src="/template/js/scripts.js"></script>
	
	<!-- Tabbed Content in Sidebar -->
	<script src="/template/js/tabbed.js"></script>
	
	<!-- Quote Rotator -->
	<script src="/template/js/jquery.quote_rotator.js"></script>
	
	<!-- Nivo Slider -->
	<script src="/template/js/jquery.nivo.slider.pack.js"></script>
	
	<link rel="stylesheet" href="http://cater2.me/template/css/custom/c2me.css" />
	<script src="/template/js/custom/common.js"></script>
	<script type="text/javascript" src="/template/js/custom/jquery.simplemodal-1.3.4.min.js"></script>
	<? if(isset($template['header_resources'])) echo $template['header_resources']; ?>
	<? if(isset($template['slider_open'])&&$template['slider_open']) echo '<script>$(document).ready(toggleGlobalSignup);</script>'; ?>
	
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-21295926-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	  
	  
	</script>
	
</head>

<body >
<div id="globalGlobal">
	<div id="top-bg"></div>
	<div class="container_12" id="header" >
	
		<header>
		
			<!-- Logo Here -->
			<a href="http://cater2.me/">
				<div id="logo" class="grid_4"></div><!-- end #logo .grid_4 -->
			</a>
			
				<div id="divAccount">
				<? if($curUser) { ?>
					Hi, <?=$curUser['first_name']?>. <a href="http://cater2.me/logout/">Sign out</a>
				<? } else { ?>
					<a href="http://cater2.me/login/">Sign in</a>
				<? } ?>
				</div>
			
			<!-- Main Navigation Here -->
			<nav id="top_nav" class="grid_8">
				<ul id="main-nav" class="sf-menu">
					
				<?
				if($curUser) { //user logged in
				?>
					<li rel="#e7e7e7"<? if($template['menu_selected']=='home') echo ' class="current"'; ?>>
						<a href="http://cater2.me/">Home</a> 
					</li>
					<li rel="#e7e7e7"<? if($template['menu_selected']=='event-spotlight') echo ' class="current"'; ?>>
						<a href="http://cater2.me/event-spotlight/">Events</a> 
					</li>
					<li rel="#e7e7e7"<? if($template['menu_selected']=='jobs') echo ' class="current"'; ?>>
						<a href="http://cater2.me/jobs/">Jobs</a> 
					</li>
					<li rel="#e7e7e7"<? if($template['menu_selected']=='dashboard') echo ' class="current"'; ?>>
						<a href="http://cater2.me/dashboard/">Dashboard</a> 
					</li>
					<li rel="#e7e7e7"<? if($template['menu_selected']=='BetaKitchen') echo ' class="current"'; ?>>
						<a href="http://cater2.me/betakitchen">BetaKitchen</a> 
					</li>
					
				<?
				}
				else
				{
				?>
					<li rel="#e7e7e7"<? if($template['menu_selected']=='home') echo ' class="current"'; ?>>
						<a href="http://cater2.me/">Home</a> 
					</li>
					<li rel="#e7e7e7"<? if($template['menu_selected']=='about') echo ' class="current"'; ?>>
						<a href="http://cater2.me/about/">About Us</a> 
					</li>
					<li rel="#e7e7e7"<? if($template['menu_selected']=='contact') echo ' class="current"'; ?>>
						<a href="http://cater2.me/contact/">Contact Us</a> 
					</li>
					<li rel="#e7e7e7"<? if($template['menu_selected']=='event-spotlight') echo ' class="current"'; ?>>
						<a href="http://cater2.me/event-spotlight/">Events</a> 
					</li>
					<li rel="#e7e7e7"<? if($template['menu_selected']=='jobs') echo ' class="current"'; ?>>
						<a href="http://cater2.me/jobs/">Jobs</a> 
					</li>
					<li rel="#e7e7e7"<? if($template['menu_selected']=='BetaKitchen') echo ' class="current"'; ?>>
						<a href="http://cater2.me/betakitchen">BetaKitchen</a> 
					</li>
					
				<?
				}
				?>
				</ul> 
				
			</nav> <!-- end #top-nav .grid_8 -->
			
		</header>
		
		<? if(isset($template['index'])) { ?>
		
		<div class="clear"></div>

			<div id="slider" >
				<div class="slides_container">
				
					<!-- FIRST SLIDE -->
					<div class="slide">
					
						<div id="divHomeSliderText">
							<div>
							<p><?=plain2Html($areas['homepage_slide1_content'])?></p>
							</div>
						</div>
						
						<div id="divHomeSliderIcons">
						
							<div class="tiptip" title="<?=$areas['homepage_slide1_icon1']?>"> <img src="/template/images/custom/home_panel_1a.png"  alt="Office and team catering"/> </div>
							<div class="tiptip" title="<?=$areas['homepage_slide1_icon2']?>"> <img src="/template/images/custom/home_panel_2a.png" alt="San Francisco office Catering" /> </div>
							<div class="tiptip" title="<?=$areas['homepage_slide1_icon3']?>"> <img src="/template/images/custom/home_panel_3a.png" alt="Business Calendar Catering"/> </div>
							
						</div>
						
					</div> <!-- end .slide -->
					
					<!-- SECOND SLIDE -->
					<div class="slide">
						<div id="divHomeSliderTestimonials">
							<div id="testimonial_picture">
								<img src="" id="testimonial_picture_img" />
							</div>
							<div id="testimonial_content">
								<!-- Content --> Initializing...
							</div>
							<div id="testimonial_author">
								<!-- Author -->
							</div>
							<div class="clear"></div>
						</div>
					</div> <!-- end .slide -->
					
					<!-- THIRD SLIDE -->
					<div class="slide">
						<div id="divHomeSliderHIW">
						</div>
					</div> <!-- end .slide -->
					
				</div> <!-- end .slides_container -->
			</div> <!-- end #slider -->
			
			<? } ?>

</div> <!-- end #container_12 #header -->

	<div class="clear"></div>
	
	<? if(isset($template['index'])) { ?>
	<!-- landscape -->
	<div id="homeLandscape"></div>
	
	<div class="clear"></div>
	<? } ?>
	
	<? if(isset($template['grey_bar'])) { ?>
	<!-- BEGIN CALL TO ACTION -->
	<div class="<?=((isset($template['index']))?'cta-wrap':'inner-cta-wrap')?>">
		<div id="call-to-action" class="container_12">
			
			<!-- TOP SENTENCE -->
			<div id="cta-top" class="grid_6">
				<h2 class="inner-title"><?=$template['grey_bar']?></h2>
			</div> <!-- end #cta-top .grid_6 .alpha -->
			
		</div> <!-- end .container_12 #call-to-action -->
		
				<?	
				if($curUser) {
				
					 if(isset($template['index'])) { 

						?>
						<div id="parentGlobalSignup" style="height:114px">
					<div id="globalSignup" style="height:114px">
						<img src="/template/images/custom/globalSignup-big.png" onClick="toggleGlobalSignup()" />
						<div id="globalSignupRight">
							<div class="label" style="line-height:52px;font-size:17px"><span style="color: black;">Refer a friend and get $100 when they order.</span></div>
							
							<div style="float:left">
							<input type="email" id="signup_email" placeholder="Friend's e-mail address" onKeyPress="if(event.keyCode==13) sendSignup();" maxlength="35" />
							</div>
							<div style="float:left">
							<input type="button" id="btnSignup_email" value="" onClick="sendSignup(); _gaq.push(['_trackEvent', 'form', 'email']);" />
							</div>

						</div>
					</div>
					</div>
						
						<? }
						
						elseif ($config['referral_forms'])
						{
						
						switch(getUserGroup($curUser)) {
						case 'client': 
						case 'employee': ?>
						<div id="parentGlobalSignup">
						<div id="globalSignup">
							<img src="/template/images/custom/globalSignup.png" onClick="toggleGlobalSignup()" />
							<div id="globalSignupRight">
								<div class="label"><span style="color: black;">Refer a friend and get $100 when they order.</span></div>
								<div style="float:left">
								<input type="email" id="signup_email" placeholder="Friend's e-mail address" onKeyPress="if(event.keyCode==13) sendSignup();" maxlength="35" /><br />
								</div>
								<div style="float:left">
								<input type="button" id="btnSignup_email" value="" onClick="sendSignup(); _gaq.push(['_trackEvent', 'form', 'email']);" />
								</div>
							</div>
						</div>
						</div>
						<?
						break;
						}
						
						}	
				}	
				else  if(isset($template['index'])) { ?>
					<div id="parentGlobalSignup" style="height:114px">
					<div id="globalSignup" style="height:114px">
						<img src="/template/images/custom/globalSignup-big.png" onClick="toggleGlobalSignup()" />
						<div id="globalSignupRight">
							<div class="label" style="line-height:52px;font-size:17px"><span style="color: black;">Enter your email address and we'll get in touch!</span></div>
							
							<div style="float:left">
							<input type="email" id="signup_email" placeholder="Company e-mail address" onKeyPress="if(event.keyCode==13) sendSignup();" maxlength="35" />
							</div>
							<div style="float:left">
							<input type="button" id="btnSignup_email" value="" onClick="sendSignup(); _gaq.push(['_trackEvent', 'form', 'email']);" />
							</div>

						</div>
					</div>
					</div>
					<? }
					else { ?>
					<div id="parentGlobalSignup">
					<div id="globalSignup">
						<img src="/template/images/custom/globalSignup.png" onClick="toggleGlobalSignup()" />
						<div id="globalSignupRight">
							<div class="label"><span style="color: black;">Need catering? Enter your email address and we'll get in touch!</span></div>
							<div style="float:left">
							<input type="email" id="signup_email" placeholder="Company e-mail address" onKeyPress="if(event.keyCode==13) sendSignup();" maxlength="35" /><br />
							</div>
							<div style="float:left">
							<input type="button" id="btnSignup_email" value="" onClick="sendSignup(); _gaq.push(['_trackEvent', 'form', 'email']);" />
							</div>
						</div>
					</div>
					</div>
					<? } ?>
					

		
	</div><!-- end .cta-wrap -->
	
	<div class="clear"></div>
	<? } 
	else 
	
	?>
	
	<!-- Begin Main Body -->
<div class="container">	<!--
		<? if(isset($template['breadcrumb'])) { ?>
		<div id="breadcrumb-wrap" class="grid_12">
			<p id="breadcrumbs">You are here:  &nbsp; <?=genBreadcrumb($template['breadcrumb'])?></p>
		</div>
		<? } ?>
	-->
    <?php wp_enqueue_script("jquery"); /* Loads jQuery if it hasn't been loaded already */ ?>
	<?php /* The HTML5 Shim is required for older browsers, mainly older versions IE */ ?>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?> <?php /* this is used by many Wordpress features and for plugins to work proporly */ ?>
<br style="clear:both" />

