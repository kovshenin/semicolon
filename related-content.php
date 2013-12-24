<?php
/**
 * @package Kovkov
 */
do_action( 'kovkov_related_posts_before' );
?>
<div class="wpmag-content-newsletter">
	<h3>Подписаться на рассылку</h3>
	<p>
		<a class="button-primary alignright" href="http://wpmag.ru/subscribe/" target="_blank">Подписаться &rarr; </a>
		Подпишитесь на бесплатную рассылку журнала WP Magazine и получайте новости, события, подборки тем и плагинов, уроки, советы и многое другое в мире WordPress!
	</p>
</div>
<?php
$related_posts = kovkov_get_related_posts();
?>
<?php if ( $related_posts->have_posts() ) : ?>
<div class="related-content">
	<h3 class="related-content-title"><?php _e( 'Related posts', 'kovkov' ); ?></h3>

	<?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>

		<article id="post-<?php the_ID(); ?>">
			<header class="entry-header">
				<a class="post-thumbnail" href="<?php the_permalink(); ?>"><span><?php the_post_thumbnail(); ?></span></a>
				<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

				<div class="entry-meta">
					<?php kovkov_posted_on(); ?>
				</div><!-- .entry-meta -->
			</header><!-- .entry-header -->

		</article><!-- #post-## -->

	<?php endwhile; ?>
</div>
<?php wp_reset_postdata(); ?>
<?php endif; // have_posts() ?>
<?php do_action( 'kovkov_related_posts_after' ); ?>
