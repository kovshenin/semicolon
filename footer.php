<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package kovkov
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'kovkov_credits' ); ?>
			<?php /*<a href="http://wordpress.org/" rel="generator"><?php printf( __( 'Proudly powered by %s', 'kovkov' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span> */ ?>
			<?php /* printf( __( 'Theme: %1$s by %2$s.', 'kovkov' ), 'kovkov', '<a href="http://underscores.me/" rel="designer">Underscores.me</a>' ); */ ?>
			&copy; <?php echo date( 'Y' ); ?> Копирование материалов без разрешения автора запрещено. WordPress и WordCamp являются зарегистрированными торговыми марками и принадлежат фонду <a href="http://wordpressfoundation.org/" target="_blank">WordPress Foundation</a>. Читайте правила использования торговых марок. Работает на <a href="http://wordpress.org/" target="_blank">WordPress</a>.
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>