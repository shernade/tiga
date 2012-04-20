<?php
/**
 * Custom home page 
 *
 * Display the featured & recent posts
 * Basic Code by twentyeleven showcase page
 *
 * @package tiga
 * @since tiga 0.0.1
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
			
			<?php if(of_get_option('tiga_show_featured')) : ?>
			<section class="featured-posts">
				<div class="featuredposts-heading"><?php _e( 'Featured Posts', 'tiga' ); ?></div>
				<div class="carousel-control">
					<a id="prev" href="#"><span>&larr;</span></a>
					<a id="next" href="#"><span>&rarr;</span></a>
				</div> <!-- end .carousel-control -->
				
				<div class="carousel-wrapper clearfix">
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
					
					<article id="post-<?php the_ID(); ?>" <?php post_class('featured-carousel'); ?>>
						<div class="carousel-item">
						
							<?php if(has_post_thumbnail()){ ?>
								<span class="carousel-thumbnail">
									<?php the_post_thumbnail('700px', array( 'class' => 'photo thumbnail', 'alt' => get_the_title()));?>
								</span>
							<?php } ?>
							
							<div class="carousel-content">
								<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tiga' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
								
								<div class="entry-summary">
									<?php the_excerpt(); ?>
								</div>
							</div> <!-- end carousel-content -->
					
						</div> <!-- end .carousel-item -->
					</article> <!-- end #post-<?php the_ID(); ?> -->
					
				<?php endwhile; ?>
				</div> <!-- end .carousel-wrapper -->
			</section> <!-- end .featured-posts -->
			<?php endif; ?>
			
			
			<section class="recent-posts">
				<div class="recentposts-heading"><?php _e( 'Recent Posts', 'tiga' ); ?></div>

				<?php
				// Display our recent posts, showing full content for the very latest, ignoring Aside posts
				$recent_args = array(
					'order' => 'DESC',
					'post__not_in' => get_option( 'sticky_posts' ),
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'terms' => array( 'post-format-aside', 'post-format-link', 'post-format-status', 'post-format-quote' ),
							'field' => 'slug',
							'operator' => 'NOT IN',
						),
					),
				);
				$recent = new WP_Query();
				$recent->query( $recent_args );
				$counter = 0;

				while ( $recent->have_posts() ) : $recent->the_post();
					// set $more to 0 in order to only get the first part of the post
					global $more;
					$more = 0;
					$counter++;

					if ( 1 == $counter ) : ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class('first-posts'); ?>>
						
							<header>
								<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tiga' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
							</header>
							
							<div class="entry-meta">
								<?php tiga_posted_on(); ?>
							</div>
							
							<?php if(has_post_thumbnail()){ ?>
								<span class="entry-thumbnail">
									<a href="<?php the_permalink() ?>">
										<?php the_post_thumbnail('120px', array( 'class' => 'photo thumbnail', 'alt' => get_the_title(), 'title' => get_the_title()));?>
									</a>
								</span>
							<?php } ?>
							
							<div class="entry-content">
								<?php the_content( __('Read the full article &rarr;', 'tiga') );  ?>
							</div>
							
						</article> <!-- end #post-<?php the_ID(); ?> -->

					<?php else : ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
						
							<?php if(has_post_thumbnail()){ ?>
								<span class="entry-thumbnail last">
									<a href="<?php the_permalink() ?>">
										<?php the_post_thumbnail('120px', array( 'class' => 'photo thumbnail', 'alt' => get_the_title(), 'title' => get_the_title()));?>
									</a>
								</span>
							<?php } ?>
							
							<div class="left-content">
								<header>
									<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tiga' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
								</header>
							
								<div class="entry-summary">
									<?php the_excerpt(); ?>
								</div>
								
								<div class="entry-meta">
									<?php tiga_posted_on(); ?>
								</div>
							</div> <!-- end .left-content -->
							
						</article> <!-- end #post-<?php the_ID(); ?> -->

					<?php endif;
				endwhile;
				?>

			</section> <!-- end .recent-posts -->

		</div><!-- #content -->
	</div><!-- #primary .site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>