<?php
/**
 * kovkov functions and definitions
 *
 * @package kovkov
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'kovkov_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kovkov_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on kovkov, use a find and replace
	 * to change 'kovkov' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'kovkov', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 180, 180, true );
	add_image_size( 'kovkov-featured', 420, 230, true );
	add_image_size( 'kovkov-mini', 60, 60, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'kovkov' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'kovkov_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // kovkov_setup
add_action( 'after_setup_theme', 'kovkov_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function kovkov_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary', 'kovkov' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary', 'kovkov' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Tertiary', 'kovkov' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'kovkov_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function kovkov_scripts() {
	wp_enqueue_style( 'kovkov-style', get_stylesheet_uri() );

	wp_enqueue_script( 'kovkov-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'kovkov-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'kovkov_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

add_action( 'kovkov_header_after', function() {
	?>
	<div class="page-description"><p>WP Magazine — это онлайн журнал посвящённый системе управления контентом WordPress. Здесь вы найдёте много полезной информации, как для начинающих, так и для опытных разработчиков.</p></div>
	<?php
});

class Kovkov {
	function __construct() {
		// @todo: sticky to featured

		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
		add_filter( 'posts_results', array( $this, 'posts_results' ), 10, 2 );
		add_filter( 'option_sticky_posts', array( $this, 'option_sticky_posts' ) );
		add_filter( 'body_class', array( $this, 'body_class' ) );
	}

	function body_class( $classes ) {
		if ( is_front_page() || is_archive() )
			$classes[] = 'grid';

		return $classes;
	}

	function pre_get_posts( $query ) {
		if ( ! $query->is_main_query() || is_admin() )
			return;

		if ( is_front_page() ) {
			$query->set( 'ignore_sticky_posts', 1 );

			// We're going to stick two posts only, on the home page
			// But not on other pages, see posts_results.
			$featured = get_posts( array(
				'post__in' => (array) get_option( 'sticky_posts' ),
				'posts_per_page' => 2,
			) );

			if ( ! empty( $featured ) ) {
				$query->set( 'post__not_in', wp_list_pluck( $featured, 'ID' ) );
			}
		}
	}

	function posts_results( $posts, $query ) {
		if ( ! $query->is_main_query() || is_admin() )
			return $posts;

		if ( is_front_page() ) {

			// Stick only on the home page.
			if ( ! is_paged() ) {
				$featured = get_posts( array(
					'post__in' => (array) get_option( 'sticky_posts' ),
					'posts_per_page' => 2,
				) );

				foreach ( $featured as $post ) {
					array_unshift( $posts, $post );
					array_pop( $posts );
				}
			}
		}

		// Unstick some stickies!
		$unstick = array();
		$count = 0;
		foreach ( $posts as $post ) {
			$increment = is_sticky( $post->ID ) ? 2 : 1;
			$count += $increment;

			// Useful for debugging
			// $post->post_title .= $count % 4;

			if ( $count <= 4 || ! is_sticky( $post->ID ) )
				continue;

			/*
			 * Let me explain. Our main grid can contain up to four posts, but featured
			 * posts tend to take up two spaces instead of one. Only the two latest
			 * featured posts are pushed to the top, the others are scattered within
			 * the rest, so here's what we do.
			 *
			 * Let's number our spaces, 1 is the first, 4 or 0 is the last space. If
			 * a post is featured, we check its ending position. We know it takes up two spaces
			 * so if it ended on space number 1, it means that it started on space number 4,
			 * meaning it will wrap, creating an orphaned space. Yuck! So we unstick it and
			 * display it as if it weren't sticky at all, better luck next time!
			 *
			 * If it's anything other than space #1, we can safely render it on two spaces.
			 * Let's also unstick the last post in a set.
			 */
			if ( $count % 4 == 1 || end( $posts ) === $post ) {
				$unstick[] = $post->ID;
				$count--;
			}
		}

		$this->unstick = $unstick;

		return $posts;
	}

	function option_sticky_posts( $value ) {
		if ( empty( $value ) || ! is_array( $value ) || empty( $this->unstick ) )
			return $value;

		$clean = array();
		foreach ( $value as $post_id )
			if ( ! in_array( $post_id, $this->unstick ) )
				$clean[] = $post_id;

		$value = $clean;
		return $value;
	}
};
new Kovkov;