<?php
/**
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clear' ); ?>>
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

	<footer>
		<div class="taxonomy">
			<?php do_action( 'semicolon_before_category' ); ?>
			<?php if ( semicolon_categorized_blog() ) { the_category(); } ?>
			<?php the_tags( '<div class="post-tags">', ' ', '</div>' ); ?>
		</div>

		<div class="author vcard">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 120 ); ?>
			<?php
				$time_string = sprintf( '<time class="entry-date published" datetime="%s">%s</time>', get_the_date('c'), get_the_time( get_option( 'date_format' ) ) );
				$time_string .= sprintf( '<time class="updated" datetime="%s">%s</time>', get_the_modified_date('c'), get_the_modified_date() );
			?>

			<div class="author-bio">
				<h3><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a> <?php echo $time_string; ?></h3>
				<p><?php echo get_the_author_meta( 'description', get_the_author_meta( 'ID' ) ); ?></p>
			</div>
		</div>
	</footer><!-- .entry-meta -->

</article><!-- #post-## -->
