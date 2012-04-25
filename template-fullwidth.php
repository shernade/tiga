<?php
/**
 * Template Name: Full Width Template
 * Description: A Page Template for displaying a full width content
 *
 * @package tiga
 * @since tiga 0.0.1
 */
get_header(); ?>

	<div id="full-primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php get_template_part( 'content', 'page' ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary .site-content -->

<?php get_footer(); ?>