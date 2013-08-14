<?php
/**
 * Template Name: Blog Page with Slider
 * Description: A Page Template for displaying a recent post with slider.
 */

get_header(); ?>

	<section id="primary" class="site-content">

		<?php tiga_content_before(); ?>

		<div id="content" role="main">
			
			<?php tiga_content(); ?>
			
			<?php get_template_part( 'content', 'featured' ); ?>
			
			<?php 
			
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args = array(
				'paged' 	=> $paged,
				'post_type'	=> 'post',
			);

			$blog_query = new WP_Query( $args );
				
			if ( $blog_query->have_posts() ) : ?>

				<?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>

					<?php get_template_part( 'content', 'index' ); ?>

				<?php endwhile; ?>

				<?php tiga_content_nav( 'nav-below' ); ?>

			<?php elseif ( current_user_can( 'edit_posts' ) ) : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; wp_reset_postdata(); ?>
			
		</div><!-- #content -->

		<?php tiga_content_after(); ?>

	</section><!-- #primary .site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>