<?php
/**
 * The template for displaying posts in the Link Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package tiga
 * @since tiga 0.0.1
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
		<header class="entry-header">
			<div class="entry-format"><?php _e( 'Gallery', 'tiga' ); ?></div>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			
			<div class="flexslider">
				<ul class="slides">
				<?php
					// basic code by:
					// twentyeleven gallery format,
					// http://wpengineer.com/1735/easier-better-solutions-to-get-pictures-on-your-posts
					
					$attachments = get_children( array(
						'post_parent' => $post->ID, 
						'post_type' => 'attachment', 
						'post_mime_type' => 'image',
						'numberposts' =>  -1,
						'orderby' => 'menu_order', 
						'order' => 'ASC', 
						'numberposts' => 999
					) );
					
					foreach ( $attachments as $attachment_id => $attachment ) : ?>
						<li><figure class="format-gallery-item"><?php echo wp_get_attachment_link($attachment_id, '620px'); ?></figure></li>
					<?php endforeach; 	
				?>
				</ul>
			</div>
			<?php the_excerpt(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'tiga' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
	
			<?php tiga_posted_on(); ?>

			<?php edit_post_link( __( 'Edit', 'tiga' ), '<span class="sep"> | </span><span class="post-edit">', '</span>' ); ?>
		
		</footer><!-- .entry-meta -->
		
	</article><!-- #post-<?php the_ID(); ?> -->
