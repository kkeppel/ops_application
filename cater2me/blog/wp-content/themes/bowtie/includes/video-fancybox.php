<?php 

/*-----------------------------------------------------------------------------------*/
/*	FancyBox  Video (added in v1.4) - http://fancybox.net/
/*-----------------------------------------------------------------------------------*/	
<script type="text/javascript">
$("a[id^=tube]").click(function() {
	$.fancybox({
			'padding'		: 0,
			'autoScale'		: false,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'title'			: this.title,
			'width'		: 680,
			'height'		: 495,
			'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
			'type'			: 'swf',
			'swf'			: {
			   	 'wmode'		: 'transparent',
				'allowfullscreen'	: 'true'
			}
		});

	return false;
});

$("a[id^=vimeo]").click(function() {
	$.fancybox({
			'padding'		: 0,
			'autoScale'		: false,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'title'			: this.title,
			'width'			: 680,
			'height'		: 495,
			'href'			: this.href.replace(new RegExp("([0-9])","i"),'moogaloop.swf?clip_id=$1'),
			'type'			: 'swf'
		});
 
		return false;
});

$("a[id^=daily]").click(function() {
	$.fancybox({
			'padding'		: 0,
			'autoScale'		: false,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'title'			: this.title,
			'width'			: 680,
			'height'		: 495,
			'href'			: this.href.replace(new RegExp('/video/', 'i'), '/swf/'),
			'type'			: 'swf'
		});
 
		return false;
});
   /*
$('a.fancybox-dailymotion').fancybox( $.extend({}, fb_opts, { 'type' : 'swf', 'width' : 480, 'height' : 485, 'padding' : 0, 'autoScale' : false, 'transitionOut' : 'fade', 'easingIn' : 'swing', 'titleShow' : false, 'titlePosition' : 'float', 'titleFromAlt' : false, 'swf' : {'wmode':'opaque','allowfullscreen':true}, 'onStart' : function(selectedArray, selectedIndex, selectedOpts) { selectedOpts.href = selectedArray[selectedIndex].href.replace(new RegExp('/video/', 'i'), '/swf/') } }) );
*/
</script>
?>