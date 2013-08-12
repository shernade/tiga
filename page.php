<?php get_header(); ?>

	<section id="primary" class="site-content">

		<?php tiga_content_before(); ?>

		<div id="content" role="main">

			<?php tiga_content(); ?>

			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php get_template_part( 'content', 'page' ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->

		<?php tiga_content_after(); ?>

	</section><!-- #primary .site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>