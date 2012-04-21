<?php 
/**
 * Filter Hooks
 * 
 * This file contains all the functions for the theme's filters, and their default content.
 * 
 * @package tiga
 * @since tiga 0.0.1
 */
 
/**
 * tiga_doctype();
 * Renders the current DOCTYPE of the page. By default it displays the HTML5 Doctype
 * 
 * @since tiga 0.0.1
 */
function tiga_doctype() {
	echo apply_filters('tiga_doctype', '<!DOCTYPE html>'). "\n";
}

 
/**
 * Sets the post excerpt length to 50 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since tiga 0.0.1
 */
function tiga_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'tiga_excerpt_length' );


/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since tiga 0.0.1
 */
function tiga_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'tiga' ) . '</a>';
}


/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and tiga_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since tiga 0.0.1
 */
function tiga_auto_excerpt_more( $more ) {
	return ' &hellip;' . tiga_continue_reading_link();
}
add_filter( 'excerpt_more', 'tiga_auto_excerpt_more' );


/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since tiga 0.0.1
 */
function tiga_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= tiga_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'tiga_custom_excerpt_more' );


/**
 * Remove gallery inline style
 *
 * @since tiga 0.0.1
 */

add_filter( 'gallery_style', 'tiga_remove_gallery_css' );
function tiga_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}


/**
 * Stop more link from jumping to middle of page
 *
 * @since tiga 0.0.1
 */

add_filter('the_content_more_link', 'tiga_remove_more_jump_link');
function tiga_remove_more_jump_link($link) { 
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}


/**
 * Filter post title for post-format links
 *
 * @since tiga 0.0.1
 */

add_filter('post_link', 'tiga_link_filter', 10, 2);
function tiga_link_filter($link, $post) {
	if (has_post_format('link', $post) && get_post_meta($post->ID, 'linkFormat', true)) {
		$link = get_post_meta($post->ID, 'linkFormat', true);
	}
	return $link;
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @since tiga 0.0.1
 */
function tiga_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'tiga_body_classes' );


/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since tiga 0.0.1
 */
function tiga_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'tiga_enhanced_image_navigation', 10, 2 );
 
?>