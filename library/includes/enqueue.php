<?php 
/**
 * Enqueue scripts and styles
 * 
 * This file contains all the enqueue scripts and styles for the theme
 * also for deregistering scripts & styles
 * 
 * @package tiga
 * @since tiga 0.0.1
 */

add_action('wp_enqueue_scripts', 'tiga_enqueue_styles');
add_action('wp_enqueue_scripts', 'tiga_enqueue_scripts');
add_action( 'wp_print_styles', 'tiga_deregister_styles', 100 );
add_action('wp_head', 'tiga_style_for_ie', 10);


function tiga_enqueue_styles() {
	wp_enqueue_style( 'style', get_stylesheet_uri(), '', '0.0.1', 'all' );
	
	wp_enqueue_style('print', get_template_directory_uri() . '/library/css/print.css', '', '0.0.1', 'print');
	
	wp_enqueue_style('shortcodes', get_template_directory_uri() . '/library/css/shortcodes.css', '', '0.0.1', 'all');
}

function tiga_deregister_styles() {
	wp_deregister_style( 'wp-pagenavi' ); // deregistering default wp-pagenavi style
}

function tiga_style_for_ie() {?>
<!--[if gte IE 7]>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/library/css/ie.css" media="screen">
<![endif]-->
<?php
}

function tiga_enqueue_scripts() {
	global $post;
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/library/js/libs/modernizr-2.5.3.min.js', array('jquery'), '2.5.3' );
	
	wp_enqueue_script( 'plugins', get_template_directory_uri() . '/library/js/plugins.js', array('jquery'), '20120410', true );
	
	wp_enqueue_script( 'script', get_template_directory_uri() . '/library/js/script.js', array('jquery'), '20120410', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/library/js/libs/keyboard-image-navigation.js', array( 'jquery' ), '20120410', true );
	}
	
	if ( is_singular() && of_get_option('tiga_social_share') ) {
		wp_enqueue_script( 'social-share', get_template_directory_uri() . '/library/js/libs/social-share.js', array( 'jquery' ), '20120410', true );
	}
	
}
 
?>