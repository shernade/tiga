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
			
			<div id="tiga-rating" class="postbox">
				<h3 class="hndle"><span><?php _e('Give Tiga Theme 5 Star Rating', 'tiga'); ?></span></h3>
				<div class="inside">
					<p><?php _e('If you love Tiga theme, please give 5 star rating at WordPress directory. <a href="http://wordpress.org/extend/themes/tiga" target="_blank">Give 5 star rating &rarr;</a>', 'tiga'); ?></p>
				</div>
			</div>
			
			<div id="tiga-support" class="postbox">
				<h3 class="hndle"><span><?php _e('Support', 'tiga'); ?></span></h3>
				<div class="inside">
					<p><?php _e('Need a support ? Create a ticket <a href="http://www.themephe.com/tickets/" target="_blank">here</a> or you can <a href="http://twitter.com/msattt" target="_blank">follow me @msattt</a>', 'tiga'); ?></p>
				</div>
			</div>
			
			<div id="tiga-contribute" class="postbox">
				<h3 class="hndle"><span><?php _e('Contribute to Tiga Theme', 'tiga'); ?></span></h3>
				<div class="inside">
					<ul class="links">
						<li><?php _e('You can contribute to this project by submit a translation <a href="http://www.themephe.com/tickets/" target="_blank">here</a>', 'tiga'); ?></li>
					</ul>
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
