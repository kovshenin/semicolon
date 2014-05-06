<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
		<div class="widget-area">
			<div class="footer-sidebar">
				<?php dynamic_sidebar( 'footer-sidebar' ); ?>
			</div>
		</div>
		<?php endif; ?>

		<div class="site-info">
			<?php if ( has_action( 'semicolon_credits' ) ) : ?>
				<?php do_action( 'semicolon_credits' ); ?>
			<?php else : ?>
				<?php _e( 'Powered by <a href="http://wordpress.org">WordPress</a>. Semicolon Theme by <a href="http://wpmag.ru">WP Magazine</a>.' ); ?>
				© 2014 Копирование материалов без разрешения автора запрещено. WordPress и WordCamp являются зарегистрированными торговыми марками и принадлежат фонду WordPress Foundation. Читайте правила использования торговых марок. Работает на WordPress.
			<?php endif; ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>