<?php
/**
 * The template for displaying posts in the Quote Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package tiga
 * @since tiga 0.0.1
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
		<header class="entry-header">
			<div class="entry-format"><?php _e( 'Quote', 'tiga' ); ?></div>
		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'tiga' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'tiga' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
	
		<?php tiga_posted_on(); ?>

		<?php edit_post_link( __( 'Edit', 'tiga' ), '<span class="sep"> | </span><span class="post-edit">', '</span>' ); ?>
		
		</footer><!-- #entry-meta -->
		
	</article><!-- #post-<?php the_ID(); ?> -->
