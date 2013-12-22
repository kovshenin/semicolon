<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package kovkov
 */
?>
	<div id="secondary" class="widget-area" role="complementary">
		<div class="sidebar-primary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
		<div class="sidebar-secondary">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</div>
		<div class="sidebar-tertiary">
			<?php dynamic_sidebar( 'sidebar-3' ); ?>
		</div>
	</div><!-- #secondary -->
