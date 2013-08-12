<?php
	$layout = of_get_option( 'tiga_layouts' );
	if( 'onecolumn' != $layout ) :
?>

	<?php if ( is_active_sidebar( 'primary' ) ) : ?>

		<aside id="secondary" class="sidebar-primary widget-area" role="complementary">

			<?php tiga_sidebar_before(); ?>

			<?php dynamic_sidebar( 'primary' ); ?>

		</aside><!-- #secondary .sidebar-primary .widget-area -->

	<?php endif; ?>

<?php endif; ?>