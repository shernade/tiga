<?php
/**
 * Helper function to return the theme option value
 *
 * @package tiga
 * @since tiga 0.0.1
 */

add_action('wp_head', 'tiga_custom_favicon', 5);
add_action('wp_head', 'tiga_custom_css', 10);
add_action('wp_head', 'tiga_iframe_blocker', 11);
add_filter( 'body_class', 'tiga_custom_layouts' );
add_action('wp_head', 'tiga_meta_google', 2);
add_action('wp_head', 'tiga_meta_bing', 2);
add_action('wp_head', 'tiga_meta_alexa', 2);
add_action('wp_footer','tiga_analytics');

/**
 * Output Custom CSS from theme options
 *
 * @package tiga
 * @since tiga 0.0.1
 */
 
function tiga_custom_css() {
	$custom_css = of_get_option('tiga_custom_css');
	
	if ($custom_css != '') {
		echo "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $custom_css . "</style>\n";
	}
}

/**
 * Output favicon from theme options
 *
 * @package tiga
 * @since tiga 0.0.1
 */

function tiga_custom_favicon() {
	if (of_get_option('tiga_custom_favicon'))
		echo '<link rel="shortcut icon" href="'. of_get_option('tiga_custom_favicon') .'">'."\n";
	else
		echo '<link rel="shortcut icon" href="'. get_stylesheet_directory_uri() .'/library/img/WordPress.png">'."\n";
}

/**
 * Output iframe blocker from theme options
 *
 * @package tiga
 * @since tiga 0.0.1
 */

function tiga_iframe_blocker() {
		
	if(of_get_option('tiga_iframe_blocker') == 'enable'):?>
		<script language="javascript" type="text/javascript"> 
			if (top.location != self.location) top.location.replace(self.location); 
		</script>
	<?php endif;
}


/**
 * Output custom class for layouts
 *
 * @package tiga
 * @since tiga 0.0.1
 */
function tiga_custom_layouts($classes) {
	$layouts = of_get_option('tiga_layouts');
	
	if ( 'rcontent' == $layouts )
		$classes[] = 'two-columns right-primary left-secondary';
	else
		$classes[] = 'two-columns left-primary right-secondary';
		
	return $classes;
}
 

/**
 * Output Google meta verification from theme options
 *
 * @package tiga
 * @since tiga 0.0.1
 */
 
function tiga_meta_google(){
	$output = of_get_option('tiga_meta_google');
	if ( $output ) 
		echo '<meta name="google-site-verification" content="' . $output . '"> ' . "\n";
}


/**
 * Output Bing meta verification from theme options
 *
 * @package tiga
 * @since tiga 0.0.1
 */

function tiga_meta_bing(){
	$output = of_get_option('tiga_meta_bing');
	if ( $output ) 
		echo '<meta name="msvalidate.01" content="' . $output . '"> ' . "\n";
}


/**
 * Output Alexa meta verification from theme options
 *
 * @package tiga
 * @since tiga 0.0.1
 */
 
function tiga_meta_alexa(){
	$output = of_get_option('tiga_meta_alexa');
	if ( $output ) 
		echo '<meta name="alexaVerifyID" content="' . $output . '"> ' . "\n";
}


/**
 * Output analytics code in footer from theme options
 *
 * @package tiga
 * @since tiga 0.0.1
 */

function tiga_analytics(){
	$output = of_get_option('tiga_analytic_code');
	if ( $output ) 
		echo "\n" . stripslashes($output) . "\n";
}

/*
 * for 'textarea' sanitization and $allowedposttags + embed and script.
 */
add_action('admin_init', 'tiga_change_santiziation', 100);
function tiga_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'tiga_sanitize_textarea' );
}

function tiga_sanitize_textarea($input) {
    global $allowedposttags;
    $custom_allowedtags["embed"] = array(
		"src" => array(),
		"type" => array(),
		"allowfullscreen" => array(),
		"allowscriptaccess" => array(),
		"height" => array(),
			"width" => array()
		);
	$custom_allowedtags["script"] = array();
	$custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
	$output = wp_kses( $input, $custom_allowedtags);
    return $output;
}

?>