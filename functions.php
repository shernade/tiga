<?php
/**
 * tiga functions and definitions
 *
 * @package tiga
 * @since tiga 0.0.1
 */

/*
 * Loads the Options Panel
 *
 * @package tiga
 * @since tiga 0.0.1
 */
 
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/library/admin/' );
	require_once dirname( __FILE__ ) . '/library/admin/options-framework.php';
}

/* Make tiga available for translation.
 * Translations can be added to the library/languages/ directory.
 * If you're building a theme based on tiga, use a find and replace
 * to change 'tiga' to the name of your theme in all the template files.
 */
load_theme_textdomain( 'tiga', get_template_directory() . '/library/languages' );

/**
 * Load all library files
 *
 * @package tiga
 * @since tiga 0.0.1
 */

require_once get_template_directory() . '/library/includes/setup.php';
require_once get_template_directory() . '/library/includes/enqueue.php';
require_once get_template_directory() . '/library/includes/extensions.php';
require_once get_template_directory() . '/library/includes/filters.php';
require_once get_template_directory() . '/library/includes/options-functions.php';
require_once get_template_directory() . '/library/includes/shortcodes.php';
require_once get_template_directory() . '/library/includes/templates.php';
require_once get_template_directory() . '/library/includes/widgets.php';

?>