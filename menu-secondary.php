<?php if ( has_nav_menu( 'secondary' ) ) : ?>

	<nav class="site-navigation secondary-navigation clearfix" role="navigation">

		<?php 
			wp_nav_menu( 
				array(  
					'container' => '',
					'menu_class' => 'secondary-nav',
					'theme_location' => 'secondary' 
				) 
			); 
		?>

	</nav><!-- end .site-navigation -->

<?php endif; ?>