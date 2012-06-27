<script type="text/javascript">
jQuery(window).load(function() {
    jQuery('#slider-nivo').nivoSlider({
        effect:'<?php echo (of_get_option('nivo_effect'));?>',
        slices: <?php echo (of_get_option('nivo_slice_num'));?>,
        boxCols: <?php echo (of_get_option('nivo_box_cols'));?>,
        boxRows: <?php echo (of_get_option('nivo_box_rows'));?>,
        animSpeed: <?php echo (of_get_option('nivo_transition_speed'));?>,
        pauseTime: <?php echo (of_get_option('nivo_pause_time'));?>,
        startSlide:0, // Set starting Slide (0 index)
        directionNav:false, // Next & Prev navigation
        directionNavHide:false, // Only show on hover
        keyboardNav:true, // Use left & right arrows
        pauseOnHover:true, // Stop animation while hovering
        manualAdvance:false, // Force manual transitions
        captionOpacity: <?php echo (of_get_option('nivo_caption_opacity'));?>
    });
});
</script>