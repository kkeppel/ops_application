<div class="my_meta_control">

<?php load_theme_textdomain('bowtie'); // Localization ?>
	
	<p><?php _e('Use this area to enter a call to action sentence for the top of the single page, post, or the subtitle on the portfolio item details page.','bowtie') ?></p>

	<label><?php _e('Call to Action &amp; Portfolio Page Title','bowtie') ?></label>

	<p>
		<input type="text" name="_my_meta[cta]" value="<?php if(!empty($meta['cta'])) echo $meta['cta']; ?>"/>
		<span><?php _e('Enter a call to action for the page','bowtie') ?></span>
	</p>
	
	<!-- 
	
	<label>Name</label>

	<p>
		<input type="text" name="_my_meta[link]" value="<?php if(!empty($meta['link'])) echo $meta['link']; ?>"/>
		<span>Enter in a name</span>
	</p>

	<label>Description <span>(optional)</span></label>

	<p>
		<textarea name="_my_meta[description]" rows="3"><?php if(!empty($meta['description'])) echo $meta['description']; ?></textarea>
		<span>Enter in a description</span>
	</p>

	-->
	
</div>