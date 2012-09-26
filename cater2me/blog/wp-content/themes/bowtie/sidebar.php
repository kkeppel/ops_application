<?php
/**
 * The Sidebar containing widget areas.
 *
 * @package WordPress
 * @subpackage Bowtie
 */
?>

	<div id="primary" class="widget-area" role="complementary">
	
		<ul class="xoxo">
			
			<?php if ( is_active_sidebar( 'general-widgets' ) ) : // check if there are widgets in the 'genderal widgets' sidebar ?>

			<?php dynamic_sidebar( 'general-widgets' ); // display 'general widgets' ?>
						
			<?php else : // if no 'general widgets' do nada  ?>
	
			<?php endif; // end 'general widgets' check ?>
			
		</ul>
		
	</div>