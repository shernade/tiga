<?php
/**
 * Theme functions file
 *
 * Contains all of the Theme's setup functions, custom functions,
 * custom Widgets, custom hooks, and Theme settings.
 * 
 * @package 	Tiga
 * @author		Satrya
 * @license		license.txt
 * @since 		0.0.1
 *
 */

/* Loads the Options Panel. */
if ( !function_exists( 'optionsframework_init' ) ) {

	define( 'OPTIONS_FRAMEWORK_DIRECTORY', trailingslashit( get_template_directory_uri() ) . 'admin/' );
	require_once dirname( __FILE__ ) . '/admin/options-framework.php';

	/* Options panel extras. */
	require( trailingslashit( get_template_directory() ) . 'includes/options-functions.php' );
	require( trailingslashit( get_template_directory() ) . 'includes/options-sidebar.php' );

}

add_action( 'after_setup_theme', 'tiga_setup' );
/**
 * Define Theme setup
 * 
 * @since 0.0.1
 */
function tiga_setup() {

	global $content_width;

	/* Sets the theme version number. */
	define( 'TIGA_VERSION', 1.4 );

	/* Sets the path to the theme directory. */
	define( 'THEME_DIR', get_template_directory() );

	/* Sets the path to the theme directory URI. */
	define( 'THEME_URI', get_template_directory_uri() );

	/* Sets the path to the admin directory. */
	define( 'TIGA_ADMIN', trailingslashit( THEME_DIR ) . 'admin' );

	/* Sets the path to the includes directory. */
	define( 'TIGA_INCLUDES', trailingslashit( THEME_DIR ) . 'includes' );

	/* Sets the path to the img directory. */
	define( 'TIGA_IMAGE', trailingslashit( THEME_URI ) . 'img' );

	/* Sets the path to the css directory. */
	define( 'TIGA_CSS', trailingslashit( THEME_URI ) . 'css' );

	/* Sets the path to the js directory. */
	define( 'TIGA_JS', trailingslashit( THEME_URI ) . 'js' );

	/* Loads the template tags. */
	require( trailingslashit( TIGA_INCLUDES ) . 'templates.php' );

	/* Loads the theme hooks. */
	require( trailingslashit( TIGA_INCLUDES ) . 'hooks.php' );

	/* Loads the theme metabox. */
	if( is_admin() ) 
		require( trailingslashit( TIGA_INCLUDES ) . 'metabox.php' );
		
	/* Set the content width based on the theme's design and stylesheet. */
	if ( ! isset( $content_width ) ) $content_width = 620;

	/* Embed width defaults. */
	add_filter( 'embed_defaults', 'tiga_embed_defaults' );
	
	/* Make tiga available for translation. */
	load_theme_textdomain( 'tiga', trailingslashit( THEME_DIR ) . 'languages' );

	/* WordPress theme support */
	add_editor_style();
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 
		'custom-background',
		array(
			'default-image' => trailingslashit( TIGA_IMAGE ) . 'pattern.png',
		)
	);
	register_nav_menus( 
		array(
			'primary' => __( 'Primary Navigation', 'tiga' ),
			'secondary' => __( 'Secondary Navigation', 'tiga' )
		) 
	);
	add_theme_support( 'post-thumbnails' );

	/* Add custom image sizes. */
	add_action( 'init', 'tiga_add_image_sizes' );
	/* Add custom image sizes custom name. */
	add_filter( 'image_size_names_choose', 'tiga_custom_name_image_sizes' );

	/* Enqueue styles & scripts. */
	add_action( 'wp_enqueue_scripts', 'tiga_enqueue_scripts' );

	/* Deregister wp-pagenavi plugin style. */
	add_action( 'wp_print_styles', 'tiga_deregister_styles', 100 );

	/* Comment reply js */
	add_action( 'comment_form_before', 'tiga_enqueue_comment_reply_script' );

	/* Remove gallery inline style */
	add_filter( 'use_default_gallery_style', '__return_false' );

	/* wp_title filter. */
	add_filter( 'wp_title', 'tiga_title', 10, 2 );

	/* Replace [...] */
	add_filter( 'excerpt_more', 'tiga_auto_excerpt_more' );

	/* Add 'Continue Reading' */
	add_filter( 'get_the_excerpt', 'tiga_custom_excerpt_more' );

	/* Stop more link from jumping to middle of page. */
	add_filter( 'the_content_more_link', 'tiga_remove_more_jump_link' );

	/* Add custom class to the body. */
	add_filter( 'body_class', 'tiga_body_classes' );

	/* Filter in a link to a content ID attribute for the next/previous image links on image attachment pages. */
	add_filter( 'attachment_link', 'tiga_enhanced_image_navigation', 10, 2 );

	/* Customize tag cloud widget. */
	add_filter( 'widget_tag_cloud_args', 'tiga_new_tag_cloud' );

	/* HTML5 tag for image and caption. */
	add_filter( 'img_caption_shortcode', 'tiga_html5_caption', 10, 3 );

	/* Allow shortcode in widget. */
	add_filter( 'widget_text', 'do_shortcode' );

	/* Register additional widgets. */
	add_action( 'widgets_init', 'tiga_register_widgets' );

	/* Register custom sidebar. */
	add_action( 'widgets_init', 'tiga_register_custom_sidebars' );

	/* Removes default styles set by WordPress recent comments widget. */
	add_action( 'widgets_init', 'tiga_remove_recent_comments_style' );

} // end tiga_setup

/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.  This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 * @since 1.0
 */
function tiga_embed_defaults( $args ) {
	
	$args['width'] = 620;
	
	$layout = of_get_option( 'tiga_layouts' );

	if ( 'onecolumn' == $layout )
		$args['width'] = 700;

	return $args;
}

/**
 * Adds custom image sizes.
 *
 * @since 1.0
 */
function tiga_add_image_sizes() {
	add_image_size( 'tiga-140px' , 140, 140, true );
	add_image_size( 'tiga-300px' , 300, 130, true );
	add_image_size( 'tiga-700px' , 700, 300, true );
	add_image_size( 'tiga-620px' , 620, 350, true );
	add_image_size( 'tiga-460px' , 460, 300, true );
}

/**
 * Adds custom image sizes custom name.
 *
 * @since 1.0
 */
function tiga_custom_name_image_sizes( $sizes ) {
    $sizes['tiga-140px'] = __( 'Small Thumbnail', 'tiga' );
    $sizes['tiga-300px'] = __( 'Medium Thumbnail', 'tiga' );
    $sizes['tiga-700px'] = __( 'Featured', 'tiga' );
    $sizes['tiga-620px'] = __( 'Medium Featured', 'tiga' );
    $sizes['tiga-460px'] = __( 'Home Slides', 'tiga' );
 
    return $sizes;
}

/**
 * Enqueue scripts
 *
 * @since 0.0.1
 */
function tiga_enqueue_scripts() {
	global $post;

	wp_enqueue_style( 'tiga-font', 'http://fonts.googleapis.com/css?family=Francois+One|Open+Sans:400italic,400,700', '', TIGA_VERSION, 'all' );

	wp_enqueue_style( 'tiga-style', get_stylesheet_uri(), '', TIGA_VERSION, 'all' );

	wp_enqueue_script( 'jquery' );

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'tiga-keyboard-image-navigation', trailingslashit( TIGA_JS ) . 'vendor/keyboard-image-navigation.js', array( 'jquery' ), TIGA_VERSION, true );
	}
	
	if ( is_singular() && of_get_option('tiga_social_share') ) {
		wp_enqueue_script( 'tiga-social-share', trailingslashit( TIGA_JS ) . 'vendor/social-share.js', array( 'jquery' ), TIGA_VERSION, true );
	}
	
	wp_enqueue_script( 'tiga-plugins', trailingslashit( TIGA_JS ) . 'plugins.js', array('jquery'), TIGA_VERSION, true );
	
	wp_enqueue_script( 'tiga-methods', trailingslashit( TIGA_JS ) . 'methods.js', array('jquery'), TIGA_VERSION, true );

}

/**
 * Deregister default wp-pagenavi style
 *
 * @since 0.0.1
 */
function tiga_deregister_styles() {
	wp_deregister_style( 'wp-pagenavi' );
}

/**
 * Comment reply js
 *
 * @since 0.2
 */
function tiga_enqueue_comment_reply_script() {

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since 1.4
 */
function tiga_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'tiga' ), max( $paged, $page ) );

	return $title;
}

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since 0.0.1
 */
function tiga_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'tiga' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with 
 * an ellipsis and tiga_continue_reading_link().
 *
 * @since 0.0.1
 */
function tiga_auto_excerpt_more( $more ) {
	return ' &hellip;' . tiga_continue_reading_link();
}

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * @since 0.0.1
 */
function tiga_custom_excerpt_more( $output ) {

	if ( has_excerpt() && ! is_attachment() ) {
		$output .= tiga_continue_reading_link();
	}
	return $output;

}

/**
 * Stop more link from jumping to middle of page
 *
 * @since 0.0.1
 */
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
 * Adds custom classes to the array of body classes.
 *
 * @since 0.0.1
 */
function tiga_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'multi-author';
	}

	return $classes;

}

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since 0.0.1
 */
function tiga_enhanced_image_navigation( $url, $id ) {

	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;

}

/**
 * Customize tag cloud widget
 *
 * @since 0.0.1
 */
function tiga_new_tag_cloud( $args ) {
	$args['largest'] 	= 12;
	$args['smallest'] 	= 12;
	$args['unit'] 		= 'px';
	return $args;
}

/**
 * HTML5 tag for image and caption
 *
 * @since 0.2.1
 */
function tiga_html5_caption( $output, $attr, $content ) {

	/* We're not worried abut captions in feeds, so just return the output here. */
	if ( is_feed() )
		return $output;

	/* Set up the default arguments. */
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);

	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );

	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
		return $content;

	/* Set up the attributes for the caption <div>. */
	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';
	$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';

	/* Open the caption <figure>. */
	$output = '<figure' . $attributes .'>';

	/* Allow shortcodes for the content the caption was created for. */
	$output .= do_shortcode( $content );

	/* Append the caption text. */
	$output .= '<figcaption class="wp-caption-text">' . $attr['caption'] . '</figcaption>';

	/* Close the caption </figure>. */
	$output .= '</figure>';

	/* Return the formatted, clean caption. */
	return $output;

}

/**
 * Registers extra widgets.
 * 
 * @since 1.0
 */
function tiga_register_widgets() {

	require_once( trailingslashit( TIGA_INCLUDES ) . 'widget-social.php' );
	register_widget( 'tiga_social' );

	require_once( trailingslashit( TIGA_INCLUDES ) . 'widget-subscribe.php' );
	register_widget( 'tiga_subscribe' );

	require_once( trailingslashit( TIGA_INCLUDES ) . 'widget-twitter.php' );
	register_widget( 'tiga_twitter' );

	require_once( trailingslashit( TIGA_INCLUDES ) . 'widget-fbfans.php' );
	register_widget( 'tiga_fb_box' );

}

/**
 * Registers custom sidebars.
 * 
 * @since 0.0.1
 */
function tiga_register_custom_sidebars() {

    register_sidebar(array(
    	'id'			=> 'primary',
		'name'          => __( 'Primary', 'tiga'),
		'description'   => __( 'Primary sidebar, appears on all pages.', 'tiga' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));
	
	register_sidebar(array(
		'id'			=> 'subsidiary',
		'name'          => __( 'Subsidiary', 'tiga'),
		'description'   => __( 'Subsidiary sidebar, appears on the footer side of your site.', 'tiga' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));

	register_sidebar(array(
		'id'			=> 'above-content',	
		'name'          => __( 'Above Single Post Content', 'tiga'),
		'description'   => __( 'This sidebar appears on the single post, above the content.', 'tiga' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));

	register_sidebar(array(
		'id'			=> 'below-content',	
		'name'          => __( 'Below Single Post Content', 'tiga'),
		'description'   => __( 'This sidebar appears on the single post, below the content.', 'tiga' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));

	register_sidebar(array(
		'id'			=> 'home',	
		'name'          => __( 'Custom Home Page', 'tiga'),
		'description'   => __( 'This sidebar appears on custom home page template.', 'tiga' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));

}

/**
 * Count the number of widgets to enable dynamic classes
 *
 * @since 1.0
 */
function tiga_dynamic_sidebar_class( $sidebar_id ) {

	$sidebars = wp_get_sidebars_widgets();
	$get_count = count( $sidebars[$sidebar_id] );

	$class = '';

	switch ( $get_count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;
	}

	if ( $class )
		echo $class;

}

/**
 * Removes default styles set by WordPress recent comments widget.
 *
 * @since 0.0.1
 */
function tiga_remove_recent_comments_style() {

	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );

}

/**
 * Tiga site title.
 *
 * @since 1.4
 */
function tiga_site_title() {	

	$titletag  = ( is_front_page() ) ? 'h1' : 'h2';

	if( of_get_option( 'tiga_custom_logo' ) ) { ?>

			<div class="site-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" src="<?php echo esc_url( of_get_option( 'tiga_custom_logo' ) ); ?>"></a>
			</div>

		<?php

	} else { ?>

			<<?php echo $titletag; ?> class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</<?php echo $titletag; ?>>
			<div class="site-description"><?php bloginfo( 'description' ); ?></div>

	<?php }

}
?>