<?php if ( is_active_sidebar( 'subsidiary' ) ) : ?>

	<aside id="footer-sidebar" class="footer-widget-area clearfix <?php tiga_dynamic_sidebar_class( 'secondary' ); ?>">
		<?php dynamic_sidebar( 'subsidiary' ); ?>
	</aside> <!-- end #footer-sidebar .footer-widget-area -->

<?php endif; ?>