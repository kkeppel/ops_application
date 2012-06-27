<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<fieldset>
		<input type="text" name="s" id="s" value="<?php _e('type your search and hit enter', 'bowtie') ?>" onfocus="if(this.value=='<?php _e('type your search and hit enter', 'bowtie') ?>')this.value='';" onblur="if(this.value=='')this.value='<?php _e('type your search and hit enter', 'bowtie') ?>';" />
	</fieldset>
</form>