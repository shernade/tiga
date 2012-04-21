<?php
/**
 * Display the recent posts posts content on home page
 *
 * Basic code from twentyeleven showcase page
 *
 * @package tiga
 * @since tiga 0.0.1
 */
 

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
			<article id="post-<?php the_ID(); ?>" <?php post_class('first-posts clearfix'); ?>>
			
				<?php if(has_post_thumbnail()){ ?>
					<span class="entry-thumbnail last">
						<a href="<?php the_permalink() ?>">
							<?php the_post_thumbnail('140px', array( 'class' => 'photo thumbnail', 'alt' => get_the_title(), 'title' => get_the_title()));?>
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

		<?php else : ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('cols clearfix'); ?>>
			
				<header>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tiga' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				</header>
				
				<?php if(has_post_thumbnail()){ ?>
					<span class="entry-thumbnail">
						<a href="<?php the_permalink() ?>">
							<?php the_post_thumbnail('300px', array( 'class' => 'photo thumbnail', 'alt' => get_the_title(), 'title' => get_the_title()));?>
						</a>
					</span>
				<?php } ?>
			
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div>
				
				<div class="entry-meta">
					<?php tiga_posted_on(); ?>
				</div>
				
			</article> <!-- end #post-<?php the_ID(); ?> -->

		<?php endif;
		
	endwhile;
?>