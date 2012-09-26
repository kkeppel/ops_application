<?php // http://users.tpg.com.au/j_birch/plugins/superfish/ ?>
<?php // http://css-tricks.com/jquery-magicline-navigation/ ?>

<script type="text/javascript">
/*-----------------------------------------------------------------------------------*/
/*	Navigation 
/*-----------------------------------------------------------------------------------*/		
		jQuery("ul.sf-menu").superfish(); 

/*-----------------------------------------------------------------------------------*/
/*	Background Hover Color Effect
/*-----------------------------------------------------------------------------------*/	
	
    var $el, leftPos, newWidth;
        $mainNav = jQuery("#main-nav");
 	$mainNav.append('<li id="magic-line" style="z-index:20;"></li>');
    
    var $magicLine = jQuery("#magic-line");
    jQuery(window).load(function(){ /* update */
    $magicLine
        .width(jQuery(".current-menu-item , .current-menu-parent, .current_page_ancestor, .current-menu-ancestor, .current_page_item").width())
        .height($mainNav.height())
        .css("left", jQuery(".current-menu-item, .current-menu-parent, .current_page_ancestor, .current-menu-ancestor, .current_page_item").position().left) /* update */
        .data("origLeft", jQuery(".current-menu-item, .current-menu-parent, .current_page_ancestor, .current-menu-ancestor, .current_page_item").position().left)
        .data("origWidth", $magicLine.width())
        .data("origColor", jQuery(".current-menu-item, .current-menu-parent, .current_page_ancestor, .current-menu-ancestor, .current_page_item").find(">a").attr("title"));
    });  /* update */ 
    jQuery("#main-nav>li").hover(function() {
        $el = jQuery(this);
        leftPos = $el.position().left;
        newWidth = $el./*parent()*/width();
        $magicLine.stop().animate({
            left: leftPos,
            width: newWidth,
            backgroundColor: $el.find(">a").attr("title")
        })
    }, function() {
        $magicLine.stop().animate({
            left: $magicLine.data("origLeft"),
            width: $magicLine.data("origWidth"),
            backgroundColor: $magicLine.data("origColor")
        });    
    });
    
    /* Kick IE into gear */
    jQuery(".current-menu-item a, .current-menu-parent a, .current_page_ancestor a, .current-menu-ancestor a, .current_page_item a").mouseenter();
</script>