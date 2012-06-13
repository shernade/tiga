<?php
/**
 * Custom template tags for this theme
 *
 * This file contains the template custom functions that add functionality to the theme
 *
 * @package tiga
 * @since tiga 0.0.1
 */

/**
 * Adding the Open Graph in the Language Attributes
 *
 * @since tiga 0.0.3
 */
add_filter('language_attributes', 'tiga_add_opengraph_doctype');
function tiga_add_opengraph_doctype( $output ) {
		return $output . ' xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"';
	}

/**
 * Prints the Facebook open-graph meta
 *
 * @since tiga 0.0.3
 */
add_action('wp_head', 'tiga_open_graph', 1);
function tiga_open_graph() {
	global $post;
	$thumbsfb = of_get_option('tiga_og_thumb');
	
	$excerpt = ""; 
		if (has_excerpt($post->ID)) {
			$excerpt = esc_attr(strip_tags(get_the_excerpt($post->ID)));
		} else {
			$excerpt = esc_attr(str_replace("\r\n",' ',substr(strip_tags(strip_shortcodes($post->post_content)), 0, 160)));
		}
?>
	<!-- Open Graph Tags -->
	<meta property="og:type" content="<?php if ( is_singular() ) { echo "article"; } else { echo "website";} ?>">
	<meta property="og:title" content="<?php if ( is_singular() ) { echo esc_attr( get_the_title() ); } else { echo get_bloginfo('name'); } ?>">
	<meta property="og:url" content="<?php if ( is_singular() ) { echo esc_url( get_permalink() ); } else { echo esc_url( home_url( '/' ) ); } ?>">
	<meta property="og:description" content="<?php
		if ( is_singular() ) {
			if ( function_exists('wpseo_get_value') ) {
				echo wpseo_get_value('metadesc'); // get meta descriptions from WordPress SEO plugin
			} else {
				echo $excerpt;
			}
		} else {
			echo get_bloginfo('description');
		}
	?>">
	<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>">
	<meta property="og:image" content="<?php if ( is_singular() ) { echo tiga_fb_image(); } else { echo esc_url( $thumbsfb ); } ?>">
	<!-- End Open Graph Tags -->
<?php
	
} //end tiga_open_graph()


/**
 * Get image for facebook open-graph
 *
 * @since tiga 0.0.3
 */
function tiga_fb_image() {
	global $post;
	$thumbsfb = of_get_option('tiga_og_thumb');
	$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', '' );
	
	if ( has_post_thumbnail($post->ID) ) {
		$fbimage = $src[0];
	} else {
		global $post, $posts;
		$fbimage = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if (array_key_exists(1, $matches)) {
			if (array_key_exists(0, $matches[1])) {
				$fbimage  = $matches [1] [0];
			}
		}
	}
	if(empty($fbimage)) {
		$fbimage = esc_url( $thumbsfb );
	}
	
	return $fbimage;
}

 
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since tiga 0.0.1
 */
if ( ! function_exists( 'tiga_content_nav' ) ):
function tiga_content_nav( $nav_id ) {
	global $wp_query;

	$nav_class = 'site-navigation paging-navigation clearfix';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation clearfix';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'tiga' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'tiga' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'tiga' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>
		
		<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else : // integrate wp-pagenavi ?>
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'tiga' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'tiga' ) ); ?></div>
			<?php endif; ?>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // tiga_content_nav()
 
 
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since tiga 0.0.1
 */
if ( ! function_exists( 'tiga_posted_on' ) ) :
function tiga_posted_on() {
	printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'tiga' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'tiga' ), get_the_author() ) ),
		esc_html( get_the_author() )
	); 
	if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
		<span class="comments-link">&middot; <?php comments_popup_link( __( 'Leave a comment', 'tiga' ), __( '1 Comment', 'tiga' ), __( '% Comments', 'tiga' ) ); ?></span>
	<?php endif;
}
endif; // tiga_posted_on()
 
/**
 * Returns true if a blog has more than 1 category
 *
 * @since tiga 0.0.1
 */
function tiga_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so tiga_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so tiga_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in tiga_categorized_blog
 *
 * @since tiga 0.0.1
 */
function tiga_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'tiga_category_transient_flusher' );
add_action( 'save_post', 'tiga_category_transient_flusher' );


/**
 * Display author information on single posts
 *
 * @since tiga 0.0.1
 */
if ( ! function_exists( 'tiga_the_author' ) ) :
function tiga_the_author() {
	if ( get_the_author_meta( 'description' ) && of_get_option('tiga_author_box') ) : // If a user has filled out their description and checked the "display author box" option, show a bio on their entries ?>
	<div id="author-info">
		<div id="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'tiga_author_bio_avatar_size', 48 ) ); ?>
		</div><!-- #author-avatar -->
		<div id="author-description">
			<h2><?php printf( __( 'About %s', 'tiga' ), get_the_author() ); ?></h2>
			<p><?php the_author_meta( 'description' ); ?></p>
			<div id="author-link">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
					<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'tiga' ), get_the_author() ); ?>
				</a>
			</div><!-- #author-link	-->
		</div><!-- #author-description -->
	</div><!-- #entry-author-info -->
	<?php endif;
}
endif; // tiga_the_author()


/**
 * This function removes default styles set by WordPress recent comments widget.
 *
 * @since tiga 0.0.1
 */
add_action( 'widgets_init', 'tiga_remove_recent_comments_style' );
function tiga_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
} // end tiga_remove_recent_comments_style()


/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since tiga 1.0
 */
if ( ! function_exists( 'tiga_comment' ) ) :
function tiga_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'tiga' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'tiga' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 48;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 40;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'tiga' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'tiga' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'tiga' ), '<span class="edit-comment-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'tiga' ); ?></em>
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'tiga' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for tiga_comment()


/**
 * Display navigation to next/previous comments pages when applicable
 *
 * @since tiga 0.0.1
 */
if ( ! function_exists( 'tiga_comment_nav' ) ) :
function tiga_comment_nav() {
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
	<nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation clearfix">
		<h1 class="assistive-text"><?php _e( 'Comment navigation', 'tiga' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'tiga' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'tiga' ) ); ?></div>
	</nav>
	<?php endif; // check for comment navigation
}
endif; // tiga_comment_nav()


/**
 * Return the URL for the first link found in the post content.
 *
 * @since tiga 0.0.1
 * @return string|bool URL or false when no link is present.
 */
function tiga_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}


/**
 * Display the social share button
 *
 * @since tiga 0.0.1
 */
if ( ! function_exists( 'tiga_share_buttons' ) ) :
function tiga_share_buttons() {
	global $post;
	?>
	<div class="share">
		<p class="share-title"><?php _e('Share This:', 'tiga'); ?></p>
		
		<p class="twitter">
			<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</p> <!-- end .twitter -->
		
		<p class="fb-like">
			<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;send=false&amp;layout=button_count&amp;width=96&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:96px; height:21px;" allowTransparency="true"></iframe>
		</p> <!-- end .fb-like -->
		
		<p class="plusone">
			<g:plusone size="medium"></g:plusone>
		</p> <!-- end .plusone -->
		
		<p class="stumble">
			<su:badge layout="1"></su:badge>
		</p> <!-- end .stumble -->
		
		<p class="pin-it">
			<?php 
			global $post; ?>
			<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($post->ID)); ?>&media=<?php echo tiga_fb_image(); ?>&description=<?php the_title(); ?>" class="pin-it-button" count-layout="horizontal">Pin It</a>
		</p> <!-- end .pin-it -->
		
	</div> <!-- end .share -->
<?php
}
endif; // end tiga_share_button() 

 
?>