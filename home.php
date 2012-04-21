<?php
/**
 * Custom home page 
 *
 * Display the featured & recent posts
 *
 * @package tiga
 * @since tiga 0.0.1
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
			
			<?php if(of_get_option('tiga_show_featured')) : ?>
				<section class="featured-posts flexslider">
					<div class="featuredposts-heading"><?php _e( 'Featured Posts', 'tiga' ); ?></div>
				
					<?php get_template_part( 'content', 'featured' ); ?>
					
				</section> <!-- end .featured-posts -->
			<?php endif; ?>
			
			<section class="recent-posts">
				<div class="recentposts-heading"><?php _e( 'Recent Posts', 'tiga' ); ?></div>

				<?php get_template_part( 'content', 'recent' ); ?>

			</section> <!-- end .recent-posts -->

		</div><!-- #content -->
	</div><!-- #primary .site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>