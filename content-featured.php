<?php
/**
 * Featured posts 
 *
 * Display featured posts based on sticky post
 *
 * @package tiga
 * @since tiga 0.0.1
 */
?>

<ul class="slides">
	<?php
		// code by justin tadlock & nathan rice 
		// http://justintadlock.com/archives/2009/03/28/get-the-latest-sticky-posts-in-wordpress
		
		$num = of_get_option('tiga_featured');
		$featured = get_option( 'sticky_posts' );
		rsort( $featured );
		$featured = array_slice( $featured, 0, $num );
		query_posts( array( 'post__in' => $featured, 'caller_get_posts' => 1 ) );
		?>

		<?php while ( have_posts() ) : the_post(); ?>
		
		<li>
			<article id="post-<?php the_ID(); ?>" <?php post_class('featured-slides'); ?>>
				<div class="slides-item">
				
					<?php if(has_post_thumbnail()){ ?>
						<span class="slides-thumbnail">
							<?php the_post_thumbnail('700px', array( 'class' => 'photo thumbnail', 'alt' => get_the_title()));?>
						</span>
					<?php } ?>
					
					<div class="slides-content">
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tiga' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div>
					</div> <!-- end slides-content -->
			
				</div> <!-- end .slides-item -->
			</article> <!-- end #post-<?php the_ID(); ?> -->
		</li>
		
	<?php endwhile; ?>
</ul> <!-- end .carousel-wrapper -->