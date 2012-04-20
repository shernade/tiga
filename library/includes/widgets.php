<?php
/**
 * Register our sidebars and widgetized areas
 * 
 * @package tiga
 * @since tiga 0.0.1
 */
 
add_action( 'widgets_init', 'tiga_widgets_init' );
function tiga_widgets_init() {

	register_widget( 'tiga_Ephemera_Widget' );
	
	register_widget('tiga_Twitter_Widget');
	
	register_widget('tiga_Social_Widget');
	
    register_sidebar(array(
		'name'          => __( 'General', 'tiga'),
		'description'   => __('This sidebar appears on the right side of your site', 'tiga'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));
	
	register_sidebar(array(
		'name'          => __( 'Footer Sidebar 1', 'tiga'),
		'description'   => __('This sidebar appears on the footer side of your site', 'tiga'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));
	
	register_sidebar(array(
		'name'          => __( 'Footer Sidebar 2', 'tiga'),
		'description'   => __('This sidebar appears on the footer side of your site', 'tiga'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));
	
	register_sidebar(array(
		'name'          => __( 'Footer Sidebar 3', 'tiga'),
		'description'   => __('This sidebar appears on the footer side of your site', 'tiga'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));
	
	register_sidebar(array(
		'name'          => __( 'Footer Sidebar 4', 'tiga'),
		'description'   => __('This sidebar appears on the footer side of your site', 'tiga'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	));
}

?>