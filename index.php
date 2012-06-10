<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package tiga
 * @since tiga 0.0.3
 */

get_header(); ?>

		<div id="primary" class="site-content">
			<div id="content" role="main">
				
				<?php if( of_get_option('tiga_show_featured') ) : ?>
					<section class="featured-posts rslides_container">
						<div class="featuredposts-heading"><?php _e( 'Featured Posts', 'tiga' ); ?></div>
					
						<?php get_template_part( 'content', 'featured' ); ?>
						
					</section> <!-- end .featured-posts -->
				<?php endif; ?>
				
				<?php
					$paged = 1;
					if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
					if ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
					$paged = intval( $paged );
					
					$args = array(
						'post__not_in' => get_option('sticky_posts'),
						'paged' => $paged,
					);
					query_posts( $args );
					if ( have_posts() ) : 
				?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content' ); ?>

				<?php endwhile; ?>

					<?php tiga_content_nav( 'nav-below' ); ?>

				<?php elseif ( current_user_can( 'edit_posts' ) ) : ?>

					<?php get_template_part( 'no-results', 'index' ); ?>

				<?php endif; ?>
				
			</div><!-- #content -->
		</div><!-- #primary .site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>