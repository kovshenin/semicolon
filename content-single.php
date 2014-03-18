<?php
/**
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1 class="entry-title"><?php the_title(); ?></h1>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'semicolon' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'semicolon' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'semicolon' ) );

			$meta = array( '&mdash;' );
			$author = sprintf( '<a class="author" rel="author" href="%s">%s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_the_author() );

			if ( semicolon_categorized_blog() ) {
				$meta[] = sprintf( __( '%1$s in %2$s', 'semicolon' ), $author, $category_list );
			} else {
				$meta[] = $author;
			}

			if ( '' != $tag_list )
				$meta[] = sprintf( __( 'Tagged: %s', 'semicolon' ), $tag_list );

			$meta[] = get_the_time( get_option( 'date_format' ) );

			echo implode( '<br />', $meta );
		?>
	</footer><!-- .entry-meta -->

</article><!-- #post-## -->
