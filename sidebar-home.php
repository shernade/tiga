<?php if ( is_active_sidebar( 'home' ) ) : ?>

	<div id="home-content" class="widget-area <?php tiga_dynamic_sidebar_class( 'home' ); ?>">	
		<?php dynamic_sidebar( 'home' ); ?>
	</div><!-- #home-content .widget-area -->

<?php endif; ?>