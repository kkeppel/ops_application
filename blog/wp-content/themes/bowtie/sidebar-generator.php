<?php
/**
 * Display Sidebar Generated Widgets
 *
 * @package WordPress
 * @subpackage Bowtie
 */
?>

	<div id="primary" class="widget-area" role="complementary">
	
		<ul class="xoxo">
			
			<?php 
			
			if (function_exists('get_sidebar_name') && dynamic_sidebar( get_sidebar_name() ) ) : else :  ?>

			<?php endif; // end 'generated sidebar' check ?>
			
		</ul>

	</div>