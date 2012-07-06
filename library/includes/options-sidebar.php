<?php
/**
 * Options Panel Sidebar
 *
 *
 * @package tiga
 * @since tiga 0.0.6
 */

add_action( 'optionsframework_after','tiga_options_sidebar' );
function tiga_options_sidebar() { ?>

	<div id="optionsframework-sidebar">
		<div class="metabox-holder">
			
			<div id="tiga-themes" class="postbox">
				<h3 class="hndle"><span><?php _e('Recommended Theme', 'tiga'); ?></span></h3>
				<div class="inside">
					<p><strong>Rumput Hijau</strong></p>
					<a href="http://satrya.me/rumput-hijau-wordpress-theme/" title="Download now!" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/library/img/rumput-hijau.png"></a>
					<p>Responsive, clean and search engine friendly WordPress theme.<br><a href="http://satrya.me/rumput-hijau-wordpress-theme/" title="Download now!" target="_blank">Get it for free! &rarr;</a></p>
				</div>
			</div>
			
			<div id="tiga-rating" class="postbox">
				<h3 class="hndle"><span><?php _e('Give Tiga Theme 5 Star Rating', 'tiga'); ?></span></h3>
				<div class="inside">
					<p><?php _e('If you love Tiga theme, please give 5 star rating at WordPress directory. <a href="http://wordpress.org/extend/themes/tiga" target="_blank">Give 5 star rating &rarr;</a>', 'tiga'); ?></p>
				</div>
			</div>
			
			<div id="tiga-support" class="postbox">
				<h3 class="hndle"><span><?php _e('Support & Contribute', 'tiga'); ?></span></h3>
				<div class="inside">
					<p><?php _e('Need a support? Or you want to submit a translation. Create a ticket <a href="http://www.themephe.com/tickets/" target="_blank">here</a> or you can <a href="http://twitter.com/msattt" target="_blank">follow me @msattt</a>', 'tiga'); ?></p>
				</div>
			</div>
			
		</div>
	</div>
	
<?php }


/**
 * loads an additional CSS file for the options panel
 *
 * @since tiga 0.0.6
 */
 if ( is_admin() ) {
    $of_page= 'appearance_page_options-framework';
    add_action( "admin_print_styles-$of_page", 'tiga_optionsframework_custom_css', 100);
}
 
function tiga_optionsframework_custom_css () {
	wp_register_style( 'tiga_optionsframework_custom_css', get_stylesheet_directory_uri() .'/library/css/options-custom.css' );
	wp_enqueue_style( 'tiga_optionsframework_custom_css' );
}
