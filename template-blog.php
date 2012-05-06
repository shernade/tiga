<?php
/**
 * Template Name: Blog Template
 * Description: A Page Template for displaying posts list
 *
 * @package tiga
 * @since tiga 0.0.1
 */
get_header(); ?>


	<div id="primary" class="site-content">
		<div id="content" role="main">

		<?php
		$paged = 1;
		if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
		if ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
		$paged = intval( $paged );
			 
		query_posts( 'post_type=post&paged=' . $paged );
				
		if (have_posts()): 
		global $more;
		$more = 0;
		?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php tiga_content_nav( 'nav-below' ); ?>

		<?php elseif ( current_user_can( 'edit_posts' ) ) : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; 
		wp_reset_query(); ?>

		</div><!-- #content -->
	</div><!-- #primary .site-content -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>