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
add_action( 'wp_footer', 'tiga_js_ie' );

/**
 * Function to call the main and helper style file
 *
 * @since tiga 0.0.1
 */
function tiga_enqueue_styles() {
	wp_enqueue_style( 'tiga-style', get_stylesheet_uri(), '', '0.0.7', 'all' );
}

/**
 * Deregistering default wp-pagenavi style
 *
 * @since tiga 0.0.1
 */
function tiga_deregister_styles() {
	wp_deregister_style( 'wp-pagenavi' ); // deregistering default wp-pagenavi style
}


function tiga_enqueue_scripts() {
	global $post;
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'tiga-modernizr', get_template_directory_uri() . '/library/js/vendor/modernizr-2.5.3.min.js', array('jquery'), '2.5.3' );
	
	wp_enqueue_script( 'tiga-nwmathcer', get_template_directory_uri() . '/library/js/vendor/nwmatcher-1.2.5-min.js', array('jquery'), '2.5.3', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'tiga-keyboard-image-navigation', get_template_directory_uri() . '/library/js/vendor/keyboard-image-navigation.js', array( 'jquery' ), '20120410', true );
	}
	
	if ( is_singular() && of_get_option('tiga_social_share') ) {
		wp_enqueue_script( 'tiga-social-share', get_template_directory_uri() . '/library/js/vendor/social-share.js', array( 'jquery' ), '20120410', true );
	}
	
	wp_enqueue_script( 'tiga-plugins', get_template_directory_uri() . '/library/js/plugins.js', array('jquery'), '20120410', true );
	
	wp_enqueue_script( 'tiga-methods', get_template_directory_uri() . '/library/js/methods.js', array('jquery'), '20120410', true );
}

/**
 * JS library only for IE
 *
 * @since tiga 0.0.3
 */
function tiga_js_ie() { ?>
	<!--[if (gte IE 6)&(lte IE 8)]>
		<script src="<?php echo get_template_directory_uri(); ?>/library/js/vendor/selectivizr-min.js"></script>
	<![endif]-->
	
<?php 
}
 
?>