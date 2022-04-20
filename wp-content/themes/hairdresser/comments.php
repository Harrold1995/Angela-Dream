<?php if ( post_password_required() ) : ?>
<p><?php esc_html_e( 'This post is password protected. Enter the password to view any comments.', 'hairdresser'); ?></p>
<?php return; endif; ?>
<?php if ( have_comments() ) : ?>
    <div class="comments comments--<?php echo get_option('anps_post_single_style', 'classic'); ?>">
        <h4 id="comments" class="comments-title"><?php echo esc_html__('Comments', 'hairdresser') . " (".get_comments_number().")"; ?></h4>
        <ul class="comment-list">
            <?php
            wp_list_comments(array( 'callback' => 'anps_comment' )); 
            ?>
        </ul>
    </div>
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
	<?php previous_comments_link( esc_html__( '&larr; Older Comments', 'hairdresser') ); ?>
	<?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'hairdresser') ); ?>
<?php endif; ?>
<?php else :
	if ( ! comments_open() ) :
?>
	<p><?php esc_html_e( 'Comments are closed.', 'hairdresser'); ?></p>
<?php endif; ?>
<?php endif; ?>
    
        
<?php
if(!isset($fields)) {
    $fields =  array(
        'author' => '<div class="form-group"><input type="text" id="author" name="author" placeholder="'. esc_html__( 'Name', 'hairdresser').'"><i class="fa fa-user"></i></div>',
        'email'  => '<div class="form-group"><input type="text" id="email" name="email" placeholder="'. esc_html__( 'E-mail', 'hairdresser').'"><i class="fa fa-envelope"></i></div>'
    ); 
}

$button_classes = 'btn btn-md';

if (get_option('anps_post_single_style', 'classic') === 'modern') {
    $button_classes = 'btn btn-sm modern-2 btn--modern-button-2';  
}

if ( is_user_logged_in() ) {
    $defaults = array(
    'fields'               => apply_filters( 'comment_form_default_fields', $fields),
    'comment_field'        => '<div class="col-md-12"><textarea id="message" placeholder="' . esc_html__("Message", 'hairdresser') . '" name="comment" rows="5"></textarea></div></div>',
    'must_log_in'          => '<p class="must-log-in">You must be logged in to leave a reply.</p>',
    'logged_in_as'         => '<h4 class="comment-heading">' . esc_html__('Post comment', 'hairdresser') . '</h4><div class="row contact-form">',
    'comment_notes_before' => '<h2 class="comment-heading">' . esc_html__('Leave a reply', 'hairdresser') . '</h2><div id="comment-form">',
    'title_reply' => '',
    'comment_notes_after'  => '<div class="contact-buttons text-left"><button data-form="clear" class="' . $button_classes . '">Reset</button>
                               <button data-form="submit" class="' . $button_classes . '">Submit</button>                          
                               </div>',
    'id_form'              => 'commentform',
    'id_submit'            => 'submit'
 );
} else {
    $defaults = array(
    'fields'               => apply_filters( 'comment_form_default_fields', $fields),
    'comment_field'        => '</div><div class="col-md-7"><textarea id="message" placeholder="' . esc_html__("Message", 'hairdresser') . '" name="comment" rows="5"></textarea></div>',
    'must_log_in'          => '<p class="must-log-in">You must be logged in to leave a reply.</p>',
    'logged_in_as'         => '<div class="row contact-form"><h4 class="comment-heading">' . esc_html__('Post comment', 'hairdresser') . '</h4>',
    'comment_notes_before' => '<h4 class="comment-heading">' . esc_html__('Post comment', 'hairdresser') . '</h4><div class="row contact-form"><div class="col-md-5">',
    'title_reply' => '',
    'comment_notes_after'  => '</div><div class="contact-buttons text-left"><button data-form="clear" class="' . $button_classes . '">Reset</button>
                               <button data-form="submit" class="' . $button_classes . '">Submit</button> 
                               </div>',
    'id_form'              => 'commentform',
    'id_submit'            => 'submit'
 );
}
comment_form( $defaults ); 