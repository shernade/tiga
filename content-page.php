<?php
/**
 * The template used for displaying page content in page.php
 * 
 * @package 	Tiga
 * @author		Satrya
 * @license		license.txt
 * @since 		0.0.1
 *
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'tiga' ), 'after' => '</div>' ) ); ?>
			<?php edit_post_link( __( 'Edit', 'tiga' ), '<span class="page-edit">', '</span>' ); ?>
		</div><!-- .entry-content -->
		
	</article><!-- end #article-<?php the_ID(); ?> -->