<?php
/**
 * Template Name: Archives Template
 * Description: A Page Template for displaying the archives
 *
 * @package tiga
 * @since tiga 0.0.1
 */
get_header(); ?>


	<div id="primary" class="site-content">
		<div id="content" role="main">
			
			<?php while ( have_posts() ) : the_post(); ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<header class="entry-header">
						<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tiga' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>
						
						<div class="archives-content clearfix">
						
							<div class="archives-left">
								<h2><?php _e('By Category', 'tiga'); ?></h2>
									<ul><?php wp_list_categories('depth=0&title_li=&'); ?></ul>
									
								<h2><?php _e('By Monthly', 'tiga'); ?></h2>
									<ul><?php wp_get_archives('type=monthly&limit=12'); ?> </ul>
								
								<h2><?php _e('By Yearly', 'tiga'); ?></h2>
									<ul><?php wp_get_archives('type=yearly'); ?></ul>
							</div> <!-- end .archives-left -->
							
							<div class="archives-right">
								<h2><?php _e('Latest Posts', 'tiga'); ?></h2>
									<ul>  
										<?php wp_get_archives('type=postbypost'); ?>
									</ul>  
							</div> <!-- end .archives-right -->
							
						</div> <!-- end archives-content -->
					</div><!-- .entry-content -->
					
				</article><!-- #post-<?php the_ID(); ?> -->

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary .site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>