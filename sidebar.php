<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package tiga
 * @since tiga 0.0.1
 */
?>
<aside id="secondary" class="widget-area" role="complementary">
	<?php do_action( 'tiga_before_sidebar' ); ?>

	<?php if ( ! dynamic_sidebar( 'General' ) ) : ?>
	<?php endif; // end sidebar widget area ?>

</aside><!-- #secondary .widget-area -->
