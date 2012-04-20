<?php
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
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Number data
	$numbers = array("2" => "Two", "3" => "Three", "4" => "Four", "5" => "Five", "6" => "Six", "7" => "Seven", "8" => "Eight", "9" => "Nine", "10" => "Ten");
	
	// Enable disable
	$endi_select = array("enable" => "Enable", "disable" => "Disable");
	
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
	$imagepath =  get_bloginfo('stylesheet_directory') . '/library/images/';
	$imageadminpath =  get_bloginfo('stylesheet_directory') . '/library/admin/images/';
	$imageadminpathlayouts =  get_bloginfo('stylesheet_directory') . '/library/admin/images/layouts/';
		
	$options = array();
		
	$options[] = array( "name" => "General Settings",
						"type" => "heading");
							
	$options[] = array( "name" => "Custom Logo",
						"desc" => "Upload a logo for your website, or specify the image address of your online logo. (http://example.com/logo.png)",
						"id" => "tiga_custom_logo",
						"type" => "upload");
								
	$options[] = array( "name" => "Custom Favicon",
						"desc" => "Upload a favicon for your website, or specify the image address of your online favicon. (http://example.com/favicon.png)",
						"id" => "tiga_custom_favicon",
						"type" => "upload");
							
	$options[] = array( "name" => "Custom CSS",
						"desc" => "Quickly add some CSS to your theme by adding it to this block.",
						"id" => "tiga_custom_css",
						"std" => "",
						"type" => "textarea"); 
						
	$options[] = array( "name" => "Analytic Code",
						"desc" => "Paste your Google Analytics (or other) tracking code here. It will be inserted before the closing body tag of your theme.",
						"id" => "tiga_analytic_code",
						"type" => "textarea"); 		 
						
	$options[] = array( "name" => "Iframe Blocker",
						"desc" => "Enable or disable iframe blocker.",
						"id" => "tiga_iframe_blocker",
						"std" => "disable",
						"type" => "select",
						"options" => $endi_select);
						
	/* ============================== End General Settings ================================= */					
	
	$options[] = array( "name" => "Theme Settings",
						"type" => "heading");
	
	$options[] = array( "name" => "Facebook open graph default thumb",
						"desc" => "Upload the default facebook open graph thumbnail",
						"id" => "tiga_og_thumb",
						"type" => "upload");
						
	$options[] = array( "name" => "Show featured posts",
						"desc" => "Check this options to show featured posts on home page",
						"id" => "tiga_show_featured",
						"type" => "checkbox");
						
	$options[] = array( "name" => "Select a number of featured posts",
						"desc" => "How many featured posts you want to show ?",
						"id" => "tiga_featured",
						"class" => "hidden",
						"type" => "select",
						"std" => "2",
						"options" => $numbers);
						
	$options[] = array( "name" => "Use footer widgets",
						"desc" => "Check this option if you want to use the footer widgets",
						"id" => "tiga_footer_widgets",
						"type" => "checkbox");
						
	$options[] = array( "name" => "Display social share button",
						"desc" => "Check this option if you want display the social share button on single posts",
						"id" => "tiga_social_share",
						"type" => "checkbox");
						
	$options[] = array( "name" => "Display author box",
						"desc" => "Check this option if you want display the author box on single posts",
						"id" => "tiga_author_box",
						"type" => "checkbox");
	
	/* ============================== End Theme Settings ================================= */	
	
	$options[] = array( "name" => "Social Settings",
						"type" => "heading");
	
	$options[] = array( "name" => "Social settings",
						"desc" => "If you want to display the social button, first you should fill the form below, put only the <strong>username</strong>. After that, go to Appearance > Widgets then drag the widget called &raquo; tiga socia widget.",
						"type" => "info");
		
	$options[] = array( "name" => "Email",
						"desc" => "Your email",
						"id" => "tiga_email",
						"type" => "text");
		
	$options[] = array( "name" => "Twitter Username",
						"desc" => "Your twitter username",
						"id" => "tiga_twitter_username",
						"type" => "text");
						
	$options[] = array( "name" => "Facebook Username",
						"desc" => "Your facebook username",
						"id" => "tiga_fb_username",
						"type" => "text");
						
	$options[] = array( "name" => "Google Plus Username",
						"desc" => "https://plus.google.com/u/<strong>109253446701726260861</strong>",
						"id" => "tiga_gplus_username",
						"type" => "text");
						
	$options[] = array( "name" => "Youtube Username",
						"desc" => "Your youtube username",
						"id" => "tiga_ytube_username",
						"type" => "text");
						
	$options[] = array( "name" => "Flickr Username",
						"desc" => "Your flickr username",
						"id" => "tiga_flickr_username",
						"type" => "text");
						
	$options[] = array( "name" => "Linkedin Username",
						"desc" => "http://id.linkedin.com/in/<strong>username</strong>",
						"id" => "tiga_linkedin_username",
						"type" => "text");
						
	$options[] = array( "name" => "Pinterest Username",
						"desc" => "Your pinterest username",
						"id" => "tiga_pinterest_username",
						"type" => "text");
						
	$options[] = array( "name" => "Dribbble Username",
						"desc" => "Your dribbble username",
						"id" => "tiga_dribbble_username",
						"type" => "text");
						
	$options[] = array( "name" => "Github Username",
						"desc" => "Your github username",
						"id" => "tiga_github_username",
						"type" => "text");
						
	$options[] = array( "name" => "LastFM Username",
						"desc" => "Your lastfm username",
						"id" => "tiga_lastfm_username",
						"type" => "text");

	$options[] = array( "name" => "Vimeo Username",
						"desc" => "Your vimeo username",
						"id" => "tiga_vimeo_username",
						"type" => "text");
	
	/* ============================== End Social Settings ================================= */
	
	$options[] = array( "name" => "Meta Verification",
						"type" => "heading");
						
	$options[] = array( "name" => "Webmaster Tools Setting",
						"desc" => "You can use the boxes below to verify with the different Webmaster Tools. Only enter the meta values/content. <br /><br />ex: <i><meta name='google-site-verification' content='<b>2141241512</b>' /></i> ",
						"type" => "info");
						
	$options[] = array( "name" => "Google Webmaster Tools",
						"desc" => "<a href='http://www.google.com/webmasters'>Google webmaster tools &raquo;</a>",
						"id" => "tiga_meta_google",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Yahoo Site Explorer",
						"desc" => "<a href='http://siteexplorer.search.yahoo.com/'>Yahoo site explorer &raquo;</a>",
						"id" => "tiga_meta_yahoo",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Bing Webmaster",
						"desc" => "<a href='http://www.bing.com/webmaster/'>Bing webmaster &raquo;</a>",
						"id" => "tiga_meta_bing",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Alexa",
						"desc" => "<a href='http://www.alexa.com/'>Alexa &raquo;</a>",
						"id" => "tiga_meta_alexa",
						"std" => "",
						"type" => "text");
						
	/* ============================== End Meta Verivication Settings ================================= */	
	
	$options[] = array( "name" => "Advanced Settings",
						"type" => "heading");
						
	$options[] = array( "name" => "Check to Show a Hidden Text Input",
						"desc" => "Click here and see what happens.",
						"id" => "example_showhidden",
						"type" => "checkbox");
	
	$options[] = array( "name" => "Hidden Text Input",
						"desc" => "This option is hidden unless activated by a checkbox click.",
						"id" => "example_text_hidden",
						"std" => "Hello",
						"class" => "hidden",
						"type" => "text");
						
	$options[] = array( "name" => "Uploader Test",
						"desc" => "This creates a full size uploader that previews the image.",
						"id" => "example_uploader",
						"type" => "upload");
						
	$options[] = array( "name" => "Example Image Selector",
						"desc" => "Images for layout.",
						"id" => "example_images",
						"std" => "2c-l-fixed",
						"type" => "images",
						"options" => array(
							'1col-fixed' => $imageadminpathlayouts . '1col.png',
							'2c-l-fixed' => $imageadminpathlayouts . '2cl.png',
							'2c-r-fixed' => $imageadminpathlayouts . '2cr.png')
						);
						
	$options[] = array( "name" =>  "Example Background",
						"desc" => "Change the background CSS.",
						"id" => "example_background",
						"std" => $background_defaults, 
						"type" => "background");
								
							
	$options[] = array( "name" => "Colorpicker",
						"desc" => "No color selected by default.",
						"id" => "example_colorpicker",
						"std" => "",
						"type" => "color");
						
	$options[] = array( "name" => "Typography",
						"desc" => "Example typography.",
						"id" => "example_typography",
						"std" => array('size' => '12px','face' => 'verdana','style' => 'bold italic','color' => '#123456'),
						"type" => "typography");			
	return $options;
}

/* 
 * Custom script for theme options
 *
 * @since tiga 2.1.0
 */

add_action('optionsframework_custom_scripts', 'tiga_custom_scripts');
function tiga_custom_scripts() { ?>
	<script type="text/javascript">
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