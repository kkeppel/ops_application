<?php
// The input of '0' was being treated as an octal so 
// I had to slap it around a little to get it to play nice.
$play_time = of_get_option('content_play_time');
if ($play_time < 1 ) $play_time = "0"; else $play_time;
?>

<script type="text/javascript">
    jQuery(window).load(function() {
				if (jQuery().slides) {
			
					jQuery('#slider').css({ display : 'block' });
						
					jQuery("#slider").slides({
						preload: true,
						preloadImage: '<?php bloginfo('template_directory'); ?>/images/slider/loading.gif',
						play: <?php echo $play_time; ?>, //enter 0 to stop slider from auto rotating
						width: 960,
						pause: <?php echo (of_get_option('content_pause_time'));?>,
						slideSpeed: <?php echo (of_get_option('content_rotation_time'));?>,
						generatePagination: true,
						hoverPause: true,
						autoHeight: true
					});	
					
				}
    });
</script>