<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"> 

<head>

	<meta charset="UTF-8">
	
	<title><?=(($template['title'])?$template['title']:'Cater2.me | Your Catering is Our Business')?></title>
	<meta name="description" content="A painstakingly crafted professional business and portfolio template.">
	<meta name="author" content="Jami Gibbs">
	
	<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
	
	<link rel="shortcut icon" href="/template/favicon.ico">
	
	<link rel="stylesheet" href="/template/css/reset.css" />
	<link rel="stylesheet" href="/template/css/typography.css" />
	<link rel="stylesheet" href="/template/css/960.css" />
	<link rel="stylesheet" type="text/css" href="/template/css/jquery.fancybox-1.3.4.css" media="screen" />
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/base/jquery-ui.css" />
	<link rel="stylesheet" href="/template/tuw-inc/style.css" type="text/css" media="screen" />
	
	<link rel="stylesheet" href="/template/css/style.css">
	<link rel="stylesheet" media="handheld" href="/template/css/handheld.css">
	
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="/template/css/ie8.css">
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
	
	<link rel="stylesheet" href="/template/css/custom/c2me.css" />
	<script src="/template/js/custom/common.js"></script>
	<script type="text/javascript" src="/template/js/custom/jquery.simplemodal-1.3.4.min.js"></script>
	<? if(isset($template['header_resources'])) echo $template['header_resources']; ?>
</head>

<body>
<div id="globalGlobal">
	<div id="top-bg"></div>
	<div class="container_12" id="header" >
	
		<header>
		
			<!-- Logo Here -->
			<a href="/">
				<div id="logo" class="grid_4"></div><!-- end #logo .grid_4 -->
			</a>
			
				<div id="divAccount">
				<? if($curUser) { ?>
					Hi, <?=$curUser['username']?>. <a href="/logout/">Sign out</a>
				<? } else { ?>
					<a href="/login/">Sign in</a>
				<? } ?>
				</div>
			
			<!-- Main Navigation Here -->
			<nav id="top_nav" class="grid_8">
				<ul id="main-nav" class="sf-menu">
					<li rel="#cb2222">
						<a href="#">Public Website</a> 
						<ul>
							<li rel="#cb2222">
								<a href="/" >Home</a> 
							</li>
							<li rel="#cb2222">
								<a href="/about/" >About Us</a> 
							</li>
							<li rel="#cb2222">
								<a href="/contact/" >Contact Us</a> 
							</li>
						</ul>
					</li>
					<li rel="#cb2222" class="current">
						<a href="#">Calendar</a>
					</li>
					<li rel="#cb2222">
						<a href="#">Manage</a> 
						<ul style="width:200px;">
							<li><a href="/dashboard/user-mgmt/">Users</a></li>
							<li><a href="/dashboard/website-mgmt/">Website</a></li>
						</ul>
					</li>
				</ul> 
				
			</nav> <!-- end #top-nav .grid_8 -->
			
		</header>
		
		<? if(isset($template['index'])) { ?>
		
		<div class="clear"></div>

			<div id="slider" >
				<div class="slides_container">
				
					<!-- FIRST SLIDE -->
					<div class="slide">
					
						<div class="grid_4 suffix_1" id="divHomeSliderText">
							<div>
							<p>Cater2.me is your solution
							for simplified, organized
							group and event ordering
							from the best catering
							providers available. We make
							it easy to add variety to your
							daily meals, ensure proper
							portioning within budget, and
							manage feedback.</p>
							
							<p>Whether it’s lunch for 60
							Tuesdays & Thursdays or an
							event for 400, Your Catering is
							Our Business.</p>
							</div>
						</div>
						
						<div class="grid_7" id="divHomeSliderIcons">
						
							<div class="grid_2 alpha tiptip" title="first image"> <img src="/template/images/custom/image-home.png" /> </div>
							<div class="grid_2 tiptip" title="second image"> <img src="/template/images/custom/image-home.png" /> </div>
							<div class="grid_2 omega tiptip" title="third image"> <img src="/template/images/custom/image-home.png" /> </div>
							
						</div>
						
					</div> <!-- end .slide -->
					
					<!-- SECOND SLIDE -->
					<div class="slide">
						<div class="grid_10 prefix_1 suffix_1" id="divHomeSliderTestimonials">
							<div>
								<div id="divHomeSliderLabelTestimonials">What our clients are saying</div>
							</div>
						</div>
					</div> <!-- end .slide -->
					
				</div> <!-- end .slides_container -->
			</div> <!-- end #slider -->
			
			<? } ?>

</div> <!-- end #container_12 #header -->

	<div class="clear"></div>
	
	<? if(isset($template['grey_bar'])) { ?>
	<!-- BEGIN CALL TO ACTION -->
	<div class="<?=((isset($template['index']))?'cta-wrap':'inner-cta-wrap')?>">
		<div id="call-to-action" class="container_12">
			
			<!-- TOP SENTENCE -->
			<div id="cta-top" class="grid_7">
				<h2 class="inner-title"><?=$template['grey_bar']?></h2>
			</div> <!-- end #cta-top .grid_6 .alpha -->
			
		</div> <!-- end .container_12 #call-to-action -->
		
					<div id="parentGlobalSignup"<? if(isset($template['index'])) echo ' style="height:114px"'; ?>>
					<div id="globalSignup"<? if(isset($template['index'])) echo ' style="height:114px"'; ?>>
						<img src="/template/images/custom/globalSignup<? if(isset($template['index'])) echo '-big'; ?>.png" onclick="toggleGlobalSignup()" />
						<div style="float:right">
						Enter your e-mail address:<br />
						<input type="email" id="signup_email" placeholder="Company e-mail" onkeypress="if(event.keyCode==13) sendSignup();" />
						<input type="button" id="btnSignup_email" value="Send" onclick="sendSignup()" />
						</div>
					</div>
					</div>
		
	</div><!-- end .cta-wrap -->
	
	<div class="clear"></div>
	<? } ?>
	
	<!-- Begin Main Body -->
	<div class="container_12" id="post-content-wrap" role="main"> <!--body-wrap-->
	
		<? if(isset($template['breadcrumb'])) { ?>
		<div id="breadcrumb-wrap" class="grid_12">
			<p id="breadcrumbs">You are here:  &nbsp; <?=genBreadcrumb($template['breadcrumb'])?></p>
		</div>
		<? } ?>
<br style="clear:both" />

