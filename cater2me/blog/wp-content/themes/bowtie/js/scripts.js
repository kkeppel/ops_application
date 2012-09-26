jQuery(function(){

				
/*-----------------------------------------------------------------------------------*/
/*	Fading Buttons - http://greg-j.com/2008/07/21/hover-fading-transition-with-jquery/
/*-----------------------------------------------------------------------------------*/		
	jQuery('.fadeThis').append('<span class="hover"></span>').each(function () {
	  var $span = $('> span.hover', this).css('opacity', 0);
	  jQuery(this).hover(function () {
	    $span.stop().fadeTo(500, 1);
	  }, function () {
	    $span.stop().fadeTo(500, 0);
	  });
	});

/*-----------------------------------------------------------------------------------*/
/*	Show/Hide Content - http://rpardz.com/blog/show-hide-content-jquery-tutorial/
/*-----------------------------------------------------------------------------------*/	
    jQuery('.open-content').hide().before('<div class="container_12"><a href="#" id="toggle-content" class="button"><div id="expand-button" ></div></a></div><div id="toggle-top" style="width:100%"></div>');
	jQuery('a#toggle-content').click(function() {
		jQuery('.open-content').slideToggle(1000);
		return false;
	});
	
	
/*-----------------------------------------------------------------------------------*/
/*	FancyBox  - http://fancybox.net/
/*-----------------------------------------------------------------------------------*/	
	jQuery("#various1").fancybox({
		'titlePosition'		: 'inside',
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
			
	jQuery("a.portfolio, ul.flickr a, #post-content-wrap .gallery a").fancybox();
	
/*-----------------------------------------------------------------------------------*/
/*	Add Class to Tag Cloud (WP prep work) - http://www.simplethemes.com/blog/entry/style-wordpress-tags/
/*-----------------------------------------------------------------------------------*/					
	jQuery('p.tags a').wrap('<span class="jg-tags" />');

/*-----------------------------------------------------------------------------------*/
/*	Nav Link Nudge - http://davidwalsh.name/jquery-link-nudge
/*-----------------------------------------------------------------------------------*/	
	/* usage 1 */
	jQuery('.sub-menu li a').nudge();
	/* usage 2 */
	jQuery('.sub-menu li a').nudge({
		property: 'margin',
		direction: 'left',
		amount: 5,
		duration: 300
	});
	
/*-----------------------------------------------------------------------------------*/
/* Tabs Shortcode
/*-----------------------------------------------------------------------------------*/
	
	if(jQuery().tabs) {
		jQuery(".tabs, .tour").tabs({ 
			fx: { opacity: 'toggle', duration: 200} 
		});
		
		jQuery('.tour .nav a').click( function (e) {
			e.preventDefault();
		});
		
	}
	
/*-----------------------------------------------------------------------------------*/
/*	Toggle Content Shortcode
/*-----------------------------------------------------------------------------------*/

	jQuery('.toggle h4').each( 
		function () {
			
			var iHeight = jQuery(this).closest('.toggle').find('.inner').height();
			var ipaddingTop = jQuery(this).closest('.toggle').find('.inner').css('padding-top');
			var ipaddingBottom = jQuery(this).closest('.toggle').find('.inner').css('padding-bottom');
			
			
			jQuery(this).toggle( 
				function () {
					
					imageURL = jQuery(this).find('span').attr('class');
					
					jQuery(this)
					.closest('.toggle')
					.find('.inner')
					.animate({height: 0, paddingTop: 0, paddingBottom: 0, opacity: 0 }, 200, 'jswing');
					jQuery(this)
					.find('span')
					.css('background', 'url('+ imageURL +'/images/shortcodes/up_down_sprite.gif) 25px 12px');
				},
				function () {
					
					jQuery(this)
					.closest('.toggle')
					.find('.inner')
					.animate({height: iHeight, paddingTop: ipaddingTop, paddingBottom: ipaddingBottom, opacity: 1}, 200, 'jswing');
					
					jQuery(this)
					.find('span')
					.css('background', 'url('+ imageURL +'/images/shortcodes/up_down_sprite.gif) 12px 12px');
				}
			);
		}
	);
	
/*-----------------------------------------------------------------------------------*/
/*	Image Hover Shortcode  - http://www.selfcontained.us/2008/03/08/simple-jquery-image-rollover-script/
/*-----------------------------------------------------------------------------------*/
    jQuery('img[data-hover]').hover(function() {
        jQuery(this).attr('tmp', jQuery(this).attr('src')).attr('src', jQuery(this).attr('data-hover')).attr('data-hover', jQuery(this).attr('tmp')).removeAttr('tmp');
    }).each(function() {
        jQuery('<img />').attr('src', jQuery(this).attr('data-hover'));
    });;
   
});

/*-----------------------------------------------------------------------------------*/
/*	Tooltip - http://jqueryfordesigners.com/coda-popup-bubbles/
/*-----------------------------------------------------------------------------------*/	
    jQuery(function () {
        jQuery('.bubbleInfo').each(function () {
            var distance = 10;
            var time = 250;
            var hideDelay = 500;
 
            var hideDelayTimer = null;
 
            var beingShown = false;
            var shown = false;
            var trigger = jQuery('.trigger', this);
            var info = jQuery('.popup', this).css('opacity', 0);
 
 
            jQuery([trigger.get(0), info.get(0)]).mouseover(function () {
                if (hideDelayTimer) clearTimeout(hideDelayTimer);
                if (beingShown || shown) {
                    // don't trigger the animation again
                    return;
                } else {
                    // reset position of info box
                    beingShown = true;
 
                    info.css({
                        top: 0,
                        left: 20,
                        display: 'block'
                    }).animate({
                        top: '-=' + distance + 'px',
                        opacity: 1
                    }, time, 'swing', function() {
                        beingShown = false;
                        shown = true;
                    });
                }
 
                return false;
            }).mouseout(function () {
                if (hideDelayTimer) clearTimeout(hideDelayTimer);
                hideDelayTimer = setTimeout(function () {
                    hideDelayTimer = null;
                    info.animate({
                        top: '-=' + distance + 'px',
                        opacity: 0
                    }, time, 'swing', function () {
                        shown = false;
                        info.css('display', 'none');
                    });
 
                }, hideDelay);
 
                return false;
            });
        });
    });


/*-----------------------------------------------------------------------------------*/
/*	FancyBox for video (added in v1.4) - http://fancybox.net/
/*-----------------------------------------------------------------------------------*/	

jQuery("a[id^=tube]").click(function() {
	jQuery.fancybox({
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

jQuery("a[id^=vimeo]").click(function() {
	jQuery.fancybox({
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

jQuery("a[id^=daily]").click(function() {
	jQuery.fancybox({
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