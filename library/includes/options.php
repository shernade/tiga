<?php
/**
 * Theme options
 *
 * Theme options for tiga theme
 *
 * @package tiga
 * @since tiga 0.0.1
 */
 
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {
	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace('/\W/', '', strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Number data
	$numbers = array('2' => __('Two', 'tiga'), '3' => __('Three', 'tiga'), '4' => __('Four', 'tiga'), '5' => __('Five', 'tiga'), '6' => __('Six', 'tiga'), '7' => __('Seven', 'tiga'), '8' => __('Eight', 'tiga'), '9' => __('Nine', 'tiga'), '10' => __('Ten', 'tiga') );
	
	// Enable disable
	$endi_select = array('enable' => __('Enable', 'tiga'), 'disable' => __('Disable', 'tiga') );
	
	// Background Defaults
	
	$background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll');
	
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_stylesheet_directory_uri() . '/library/images/';
	$imageadminpath =  get_stylesheet_directory_uri() . '/library/admin/images/';
	$imageadminpathlayouts =  get_stylesheet_directory_uri() . '/library/admin/images/layouts/';
		
	$options = array();
		
	$options[] = array( 'name' => __('General Settings', 'tiga'),
						'type' => 'heading');
							
	$options[] = array( 'name' => __('Custom Logo', 'tiga'),
						'desc' => __('Upload a logo for your website, or specify the image address of your online logo. (http://example.com/logo.png)', 'tiga'),
						'id' => 'tiga_custom_logo',
						'type' => 'upload');
								
	$options[] = array( 'name' => __('Custom Favicon', 'tiga'),
						'desc' => __('Upload a favicon for your website, or specify the image address of your online favicon. (http://example.com/favicon.png)', 'tiga'),
						'id' => 'tiga_custom_favicon',
						'type' => 'upload');
							
	$options[] = array( 'name' => __('Custom CSS', 'tiga'),
						'desc' => __('Quickly add some CSS to your theme by adding it to this block.', 'tiga'),
						'id' => 'tiga_custom_css',
						'std' => '',
						'type' => 'textarea'); 
						
	$options[] = array( 'name' => __('Analytic Code', 'tiga'),
						'desc' => __('Paste your Google Analytics (or other) tracking code here. It will be inserted before the closing body tag of your theme.', 'tiga'),
						'id' => 'tiga_analytic_code',
						'type' => 'textarea'); 		 
						
	$options[] = array( 'name' => __('Iframe Blocker', 'tiga'),
						'desc' => __('Enable or disable iframe blocker.', 'tiga'),
						'id' => 'tiga_iframe_blocker',
						'std' => 'disable',
						'type' => 'select',
						'options' => $endi_select);
						
	/* ============================== End General Settings ================================= */					
	
	$options[] = array( 'name' => __('Theme Settings', 'tiga'),
						'type' => 'heading');
	
	$options[] = array( 'name' => __('Facebook open graph default thumb', 'tiga'),
						'desc' => __('Upload the default facebook open graph thumbnail', 'tiga'),
						'id' => 'tiga_og_thumb',
						'type' => 'upload');
						
	$options[] = array( 'name' => __('Show featured posts', 'tiga'),
						'desc' => __('Check this options to show featured posts on home page', 'tiga'),
						'id' => 'tiga_show_featured',
						'type' => 'checkbox');
						
	$options[] = array( 'name' => __('Select a number of featured posts', 'tiga'),
						'desc' => __('How many featured posts you want to show ?', 'tiga'),
						'id' => 'tiga_featured',
						'class' => 'hidden',
						'type' => 'select',
						'std' => '2',
						'options' => $numbers);
						
	$options[] = array( 'name' => __('Use footer widgets', 'tiga'),
						'desc' => __('Check this option if you want to use the footer widgets', 'tiga'),
						'id' => 'tiga_footer_widgets',
						'type' => 'checkbox');
						
	$options[] = array( 'name' => __('Display social share button', 'tiga'),
						'desc' => __('Check this option if you want display the social share button on single posts', 'tiga'),
						'id' => 'tiga_social_share',
						'type' => 'checkbox');
						
	$options[] = array( 'name' => __('Display author box', 'tiga'),
						'desc' => __('Check this option if you want display the author box on single posts', 'tiga'),
						'id' => 'tiga_author_box',
						'type' => 'checkbox');
	
	/* ============================== End Theme Settings ================================= */	
	
	$options[] = array( 'name' => __('Social Settings', 'tiga'),
						'type' => 'heading');
	
	$options[] = array( 'name' => __('Social settings', 'tiga'),
						'desc' => __('If you want to display the social button, first you should fill the form below, put only the <strong>username</strong>. After that, go to Appearance > Widgets then drag the widget called &raquo; tiga socia widget.', 'tiga'),
						'type' => 'info');
		
	$options[] = array( 'name' => __('Email', 'tiga'),
						'desc' => __('Your email', 'tiga'),
						'id' => 'tiga_email',
						'type' => 'text');
		
	$options[] = array( 'name' => __('Twitter Username', 'tiga'),
						'desc' => __('Your twitter username', 'tiga'),
						'id' => 'tiga_twitter_username',
						'type' => 'text');
						
	$options[] = array( 'name' => __('Facebook Username', 'tiga'),
						'desc' => __('Your facebook username', 'tiga'),
						'id' => 'tiga_fb_username',
						'type' => 'text');
						
	$options[] = array( 'name' => __('Google Plus Username', 'tiga'),
						'desc' => __('https://plus.google.com/u/<strong>109253446701726260861</strong>', 'tiga'),
						'id' => 'tiga_gplus_username',
						'type' => 'text');
						
	$options[] = array( 'name' => __('Youtube Username', 'tiga'),
						'desc' => __('Your youtube username', 'tiga'),
						'id' => 'tiga_ytube_username',
						'type' => 'text');
						
	$options[] = array( 'name' => __('Flickr Username', 'tiga'),
						'desc' => __('Your flickr username', 'tiga'),
						'id' => 'tiga_flickr_username',
						'type' => 'text');
						
	$options[] = array( 'name' => __('Linkedin Username', 'tiga'),
						'desc' => __('http://id.linkedin.com/in/<strong>username</strong>', 'tiga'),
						'id' => 'tiga_linkedin_username',
						'type' => 'text');
						
	$options[] = array( 'name' => __('Pinterest Username', 'tiga'),
						'desc' => __('Your pinterest username', 'tiga'),
						'id' => 'tiga_pinterest_username',
						'type' => 'text');
						
	$options[] = array( 'name' => __('Dribbble Username', 'tiga'),
						'desc' => __('Your dribbble username', 'tiga'),
						'id' => 'tiga_dribbble_username',
						'type' => 'text');
						
	$options[] = array( 'name' => __('Github Username', 'tiga'),
						'desc' => __('Your github username', 'tiga'),
						'id' => 'tiga_github_username',
						'type' => 'text');
						
	$options[] = array( 'name' => __('LastFM Username', 'tiga'),
						'desc' => __('Your lastfm username', 'tiga'),
						'id' => 'tiga_lastfm_username',
						'type' => 'text');

	$options[] = array( 'name' => __('Vimeo Username', 'tiga'),
						'desc' => __('Your vimeo username', 'tiga'),
						'id' => 'tiga_vimeo_username',
						'type' => 'text');
	
	/* ============================== End Social Settings ================================= */
	
	$options[] = array( 'name' => __('Meta Verification', 'tiga'),
						'type' => 'heading');
						
	$options[] = array( 'name' => __('Webmaster Tools Setting', 'tiga'),
						'desc' => __('You can use the boxes below to verify with the different Webmaster Tools. Only enter the meta values/content. <br /><br />ex: <i><meta name="google-site-verification" content="<b>2141241512</b>" /></i>', 'tiga'),
						'type' => 'info');
						
	$options[] = array( 'name' => __('Google Webmaster Tools', 'tiga'),
						'desc' => __('<a href="http://www.google.com/webmasters/">Google webmaster tools &raquo;</a>', 'tiga'),
						'id' => 'tiga_meta_google',
						'std' => '',
						'type' => 'text');
						
	$options[] = array( 'name' => __('Bing Webmaster', 'tiga'),
						'desc' => __('<a href="http://www.bing.com/webmaster/">Bing webmaster &raquo;</a>', 'tiga'),
						'id' => 'tiga_meta_bing',
						'std' => '',
						'type' => 'text');
						
	$options[] = array( 'name' => __('Alexa', 'tiga'),
						'desc' => __('<a href="http://www.alexa.com/">Alexa &raquo;</a>', 'tiga'),
						'id' => 'tiga_meta_alexa',
						'std' => '',
						'type' => 'text');
						
	/* ============================== End Meta Verivication Settings ================================= */	
	
	$options[] = array( 'name' => __('Ads Settings', 'tiga'),
						'type' => 'heading');
						
	$options[] = array( 'name' => __('Ads 1', 'tiga'),
						'desc' => __('Ads after post title on single post', 'tiga'),
						'id' => 'tiga_ads_after_title',
						'std' => '',
						'type' => 'textarea');
						
	$options[] = array( 'name' => __('Ads 2', 'tiga'),
						'desc' => __('Ads after post content on single post', 'tiga'),
						'id' => 'tiga_ads_after_content',
						'std' => '',
						'type' => 'textarea'); 
	
	/* ============================== End Ads Settings ================================= */	
	
	$options[] = array( 'name' => 'Advanced Settings',
						'type' => 'heading');
						
	$options[] = array( 'name' => 'Example Image Selector',
						'desc' => 'Images for layout.',
						'id' => 'example_images',
						'std' => '2c-l-fixed',
						'type' => 'images',
						'options' => array(
							'1col-fixed' => $imageadminpathlayouts . '1col.png',
							'2c-l-fixed' => $imageadminpathlayouts . '2cl.png',
							'2c-r-fixed' => $imageadminpathlayouts . '2cr.png')
						);
						
	$options[] = array( 'name' =>  'Example Background',
						'desc' => 'Change the background CSS.',
						'id' => 'example_background',
						'std' => $background_defaults, 
						'type' => 'background');
								
							
	$options[] = array( 'name' => 'Colorpicker',
						'desc' => 'No color selected by default.',
						'id' => 'example_colorpicker',
						'std' => '',
						'type' => 'color');
						
	$options[] = array( 'name' => 'Typography',
						'desc' => 'Example typography.',
						'id' => 'example_typography',
						'std' => array('size' => '12px','face' => 'verdana','style' => 'bold italic','color' => '#123456'),
						'type' => 'typography');			
	return $options;
}

/* 
 * Custom script for theme options
 *
 * @since tiga 0.0.1
 */

add_action('optionsframework_custom_scripts', 'tiga_custom_scripts');
function tiga_custom_scripts() { ?>
	<script type='text/javascript'>
	jQuery(document).ready(function($) {

		$('#tiga_show_featured').click(function() {
			$('#section-tiga_featured').fadeToggle(400);
		});
		
		if ($('#tiga_show_featured:checked').val() !== undefined) {
			$('#section-tiga_featured').show();
		}
		
	});
	</script>
<?php
}