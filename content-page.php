<?php
/**
 * The template used for displaying page content in page.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

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
		<div class="author vcard">
			<?php
				$time_string = sprintf( '<time class="entry-date published" datetime="%s">%s</time>', get_the_date('c'), get_the_time( get_option( 'date_format' ) ) );
				$time_string .= sprintf( '<time class="updated" datetime="%s">%s</time>', get_the_modified_date('c'), get_the_modified_date() );
			?>
			<a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a> <?php echo $time_string; ?>
		</div>
	</footer>
</article><!-- #post-## -->
