<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function semicolon_jetpack_setup() {
	/*add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );*/

	add_theme_support( 'featured-content', array(
		'filter' => 'semicolon_get_featured_posts',
		'max_posts' => 2,
	) );
}
add_action( 'after_setup_theme', 'semicolon_jetpack_setup' );