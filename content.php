<?php
/**
 * @package kovkov
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php $post_thumbnail_size = Kovkov::is_featured() ? 'kovkov-featured' : 'post-thumbnail'; ?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $post_thumbnail_size ); ?></a>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<div class="entry-meta">
			<?php kovkov_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

</article><!-- #post-## -->

<?php if ( Kovkov::is_featured() ) : ?>
<article class="empty">
</article>
<?php endif; ?>