<?php
/**
 * The Template for displaying content
 *
 * @package tiga
 * @since tiga 0.0.1
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('cols clearfix'); ?>>
				
		<header>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tiga' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		</header>
		
		<?php if(has_post_thumbnail()){ ?>
			<figure class="entry-thumbnail">
				<a href="<?php the_permalink() ?>">
					<?php the_post_thumbnail('tiga-300px', array( 'class' => 'photo thumbnail', 'alt' => get_the_title(), 'title' => get_the_title()));?>
				</a>
			</figure>
		<?php } ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>
		
		<div class="entry-meta">
			<?php tiga_posted_on(); ?>
		</div>
		
	</article> <!-- end #post-<?php the_ID(); ?> -->