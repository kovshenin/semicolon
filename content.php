<?php
/**
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<a class="post-thumbnail" href="<?php the_permalink(); ?>"><span><?php the_post_thumbnail(); ?></span></a>
		<?php Semicolon::inline_controls(); ?>

		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<div class="entry-meta">
			<?php semicolon_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

</article><!-- #post-## -->