<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package tiga
 * @since tiga 0.0.1
 */
tiga_doctype(); ?>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site">
<?php do_action( 'tiga_before' ); ?>

	<header id="masthead" class="site-header" role="banner">
		<div id="main-header" class="clearfix">
		
			<div class="site-branding">
				<?php if(of_get_option('tiga_custom_logo')) :
					
					$logotag  = (is_home() || is_front_page())? 'h1':'div'; // only display h1 tag in home page, SEO reason ?>
						<<?php echo $logotag; ?> class="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img alt="<?php bloginfo('name'); ?>" src="<?php echo of_get_option('tiga_custom_logo'); ?>"><span><?php bloginfo('name'); ?></span></a></<?php echo $logotag; ?>>
					<?php
				else :
					$titletag  = (is_home() || is_front_page())? 'h1':'div'; // only display h1 tag in home page, SEO reason ?>
						<<?php echo $titletag; ?> class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></<?php echo $titletag; ?>>
						<div class="site-description"><?php bloginfo( 'description' ); ?></div>
				<?php endif; ?>
			</div> <!-- end .site-branding -->

			<nav class="site-navigation main-navigation last" role="navigation">
				<h1 class="assistive-text"><?php _e( 'Menu', 'tiga' ); ?></h1>
				<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'tiga' ); ?>"><?php _e( 'Skip to content', 'tiga' ); ?></a></div>

				<?php wp_nav_menu( array( 
						'theme_location' => 'primary', 
						'container' => '',
						'menu_class' => 'main-nav' ) 
					); ?>
			</nav> <!-- end .site-navigation -->
			
		</div> <!-- end #main-header -->
		
		<nav class="site-navigation secondary-navigation clearfix" role="navigation">
			<?php wp_nav_menu( array( 
					'theme_location' => 'secondary', 
					'container' => '',
					'menu_class' => 'secondary-nav' ) 
				); ?>
		</nav> <!-- end .site-navigation -->
	</header><!-- #masthead .site-header -->
	
	<div id="main">