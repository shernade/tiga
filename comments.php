<?php
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'tiga' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<?php tiga_comment_nav(); ?>

		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'tiga_comment' ) ); ?>
		</ol>

		<?php tiga_comment_nav(); ?>

	<?php endif; // have_comments() ?>

	<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'tiga' ); ?></p>
	<?php endif; ?>

	<?php
		$args = array(
			'title_reply' 			=> __( 'Leave a Comment', 'tiga' ),
			'label_submit' 			=> __( 'Send your comment', 'tiga' ),
			'comment_notes_after' 	=> ''
		);
			
		comment_form( $args ); 
	?>

</div><!-- #comments .comments-area -->