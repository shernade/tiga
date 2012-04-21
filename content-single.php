<?php
/**
 * The Template for displaying content on single posts
 *
 * @package tiga
 * @since tiga 0.0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
	
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tiga' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<div class="entry-meta">
			<?php tiga_posted_on(); ?>
		</div><!-- .entry-meta -->
		
	</header><!-- .entry-header -->
	
	<?php if(of_get_option('tiga_ads_after_title')): ?>
		<div class="ads-after-title"><?php echo stripslashes(of_get_option('tiga_ads_after_title')); ?></div>
	<?php endif; ?>
	
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'tiga' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	
	<?php if(of_get_option('tiga_ads_after_content')): ?>
		<div class="ads-after-content"><?php echo stripslashes(of_get_option('tiga_ads_after_content')); ?></div>
	<?php endif; ?>
	
	<footer class="entry-meta">
	
		<?php if(of_get_option('tiga_social_share')):
			tiga_share_buttons();
		endif; ?>
	
		<?php 
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'tiga' ) );
			
			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', ', ' );

			if ( ! tiga_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'tiga' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'tiga' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'tiga' );
				} else {
					$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'tiga' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>

		<?php edit_post_link( __( 'Edit', 'tiga' ), '<span class="post-edit">', '</span>' ); ?>
		
		<?php if(of_get_option('tiga_author_box')):
			tiga_the_author();
		endif; ?>
		
	</footer><!-- .entry-meta -->
	
</article><!-- #post-<?php the_ID(); ?> -->
