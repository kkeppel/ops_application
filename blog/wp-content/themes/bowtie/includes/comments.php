<?php

/*-----------------------------------------------------------------------------------*/
/*	Comments & Pings - http://www.studiograsshopper.ch/code-snippets/customising-wp_list_comments/
/*-----------------------------------------------------------------------------------*/

function jg_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
	 <div class="comment-body">
      <div class="comment-author vcard">
	  
		<a href="<?php get_comment_author_link(); ?>">
         <?php echo get_avatar($comment,$size='60',$default='<path_to_url>' ); ?>
		</a>
		
         <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
      </div> <!-- end .comment-author vcard -->
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>
 
      <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?>
	  </div><!-- end .comment-meta .commentmetadata -->
 
      <?php comment_text() ?>
 
      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div> <!-- end .reply -->
	  </div> <!-- end .comment-body -->
     </div> <!-- end #comment-<?php comment_ID(); ?> -->
<?php
        }
		
/* Custom callback function for Trackbacks/Pings, see comments.php */
function jg_pings($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
 
         <?php printf(__('<cite class="fn">%s</cite> <span class="says">wrote:</span>'), get_comment_author_link()) ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>
 
      <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','') ?></div>
 
      <?php comment_text() ?>
 
     </div>
<?php
}

?>