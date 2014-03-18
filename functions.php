<?php
/**
 * The Semicolon Theme
 */
class Semicolon {
	private function __construct() {}

	/**
	 * Runs immediately at the end of this file.
	 */
	public static function setup() {
		if ( ! isset( $GLOBALS['content_width'] ) ) {
			$GLOBALS['content_width'] = 940;
		}

		// @todo: sticky to featured
		add_action( 'pre_get_posts', array( 'Semicolon', 'pre_get_posts' ) );
		add_filter( 'posts_results', array( 'Semicolon', 'posts_results' ), 10, 2 );
		add_filter( 'found_posts', array( 'Semicolon', 'found_posts' ), 10, 2 );
		add_filter( 'body_class', array( 'Semicolon', 'body_class' ) );
		add_filter( 'post_class', array( 'Semicolon', 'post_class' ), 10, 3 );

		add_filter( 'shortcode_atts_gallery', array( 'Semicolon', 'shortcode_atts_gallery' ), 10, 3 );
		add_filter( 'use_default_gallery_style', '__return_false' );

		add_action( 'after_setup_theme', array( 'Semicolon', 'after_setup_theme' ) );
		add_action( 'widgets_init', array( 'Semicolon', 'widgets_init' ) );
		add_action( 'wp_enqueue_scripts', array( 'Semicolon', 'enqueue_scripts' ) );

		add_filter( 'wp_page_menu_args', array( 'Semicolon', 'page_menu_args' ) );
		add_filter( 'wp_title', array( 'Semicolon', 'wp_title', 10, 2 ) );

		do_action( 'semicolon_setup' );
	}

	/**
	 * Runs during core's after_setup_theme
	 */
	public static function after_setup_theme() {
		load_theme_textdomain( 'semicolon', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Post thumbnail support and additional image sizes.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 420, 240, true );
		add_image_size( 'semicolon-mini', 60, 60, true );
		add_image_size( 'semicolon-gallery', 300, 300, true );

		// This theme uses a primary navigation menu and an additional
		// menu for social profile links.
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'semicolon' ),
			'social'  => __( 'Social Menu', 'semicolon' ),
		) );

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

		// HTML5 support for core elements.
		add_theme_support( 'html5', array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
		) );

		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) );
	}

	public static function widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Primary', 'semicolon' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		) );

		register_sidebar( array(
			'name'          => __( 'Secondary', 'semicolon' ),
			'id'            => 'sidebar-2',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		) );

		register_sidebar( array(
			'name'          => __( 'Tertiary', 'semicolon' ),
			'id'            => 'sidebar-3',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		) );
	}

	public static function enqueue_scripts() {
		wp_enqueue_style( 'semicolon-style', get_stylesheet_uri(), array(), '20140129' );

		wp_enqueue_style( 'semicolon-genericons', get_template_directory_uri() . '/css/genericons.css', array(), '20131222' );

		wp_enqueue_script( 'semicolon-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

		wp_enqueue_script( 'semicolon-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

		wp_enqueue_script( 'semicolon-grid', get_template_directory_uri() . '/js/grid.js', array( 'jquery' ), '20140129', true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	public static function shortcode_atts_gallery( $out, $pairs, $atts ) {
		if ( empty( $atts['size'] ) && $out['columns'] >= 2 )
			$out['size'] = 'semicolon-gallery';

		return $out;
	}

	public static function body_class( $classes ) {
		if ( ! is_singular() )
			$classes[] = 'grid';

		$classes[] = 'no-js';

		return $classes;
	}

	public static function post_class( $classes, $class, $post_id ) {
		if ( self::is_featured( $post_id ) )
			$classes[] = 'semicolon-featured';

		return $classes;
	}

	public static function get_featured_posts() {
		$featured_posts = array();

		$jetpack_featured_posts = apply_filters( 'semicolon_get_featured_posts', false );
		if ( ! empty( $jetpack_featured_posts ) )
			$featured_posts = array_map( 'absint', wp_list_pluck( $jetpack_featured_posts, 'ID' ) );
		else
			$featured_posts = (array) get_option( 'sticky_posts' );

		if ( empty( $featured_posts ) )
			return new WP_Query;

		return new WP_Query( array(
			'post__in' => $featured_posts,
			'posts_per_page' => 2,
			'ignore_sticky_posts' => true,
		) );
	}

	public static function is_featured( $post_id = null ) {
		$post = get_post( $post_id );
		$featured = false;

		if ( class_exists( 'Featured_Content' ) && method_exists( 'Featured_Content', 'get_setting' ) ) {
			$tag_id = Featured_Content::get_setting( 'tag-id' );
			$post_tags = wp_get_object_terms( $post->ID, 'post_tag' );

			if ( in_array( absint( $tag_id ), wp_list_pluck( $post_tags, 'term_id' ) ) )
				$featured = true;
		} else {
			$sticky_posts = (array) get_option( 'sticky_posts' );
			$featured = in_array( $post->ID, $sticky_posts );
		}

		return $featured;
	}

	public static function pre_get_posts( $query ) {
		if ( ! $query->is_main_query() || is_admin() )
			return;

		if ( is_front_page() ) {
			$query->set( 'ignore_sticky_posts', 1 );

			// We're going to stick two posts only, on the home page
			// But not on other pages, see posts_results.
			$featured = self::get_featured_posts();

			if ( $featured->have_posts() ) {
				$posts_per_page = $query->get( 'posts_per_page' );
				if ( ! $posts_per_page )
					$posts_per_page = get_option( 'posts_per_page', 10 );

				$query->set( 'post__not_in', wp_list_pluck( $featured->posts, 'ID' ) );

				if ( ! is_paged() ) {
					// $query->set( 'posts_per_page', $posts_per_page - $featured->post_count );
				} else {
					$query->set( 'offset', ( $query->get( 'paged' ) - 1 ) * $posts_per_page - $featured->post_count );
					// $query->set( 'offset', get_query_var( 'paged' ) );
				}
			}
		}
	}

	public static function posts_results( $posts, $query ) {
		if ( ! $query->is_main_query() || is_admin() )
			return $posts;

		if ( is_front_page() ) {

			// Stick only on the home page.
			if ( ! is_paged() ) {
				$featured = self::get_featured_posts();

				if ( $featured->have_posts() ) {

					// Since we're going to unshif these, we'll need them in reverse order.
					$featured->posts = array_reverse( $featured->posts );

					foreach ( $featured->posts as $post ) {
						array_unshift( $posts, $post );
					}

					// Remove any extras on top of ppp.
					while ( count( $posts ) > $query->get( 'posts_per_page' ) ) {
						array_pop( $posts );
					}
				}
			}
		}

		return $posts;
	}

	public static function found_posts( $found_posts, $query ) {
		if ( ! $query->is_main_query() || is_admin() )
			return $found_posts;

		if ( is_front_page() ) {
			$featured = self::get_featured_posts();

			if ( $featured->have_posts() ) {
				$found_posts += $featured->post_count;
			}
		}

		return $found_posts;
	}

	public static function get_related_posts() {
		$post = get_post();

		// Support for the Yet Another Related Posts Plugin
		if ( function_exists( 'yarpp_get_related' ) ) {
			$related = yarpp_get_related( array( 'limit' => 4 ), $post->ID );
			return new WP_Query( array(
				'post__in' => wp_list_pluck( $related, 'ID' ),
				'posts_per_page' => 3,
				'ignore_sticky_posts' => true,
				'post__not_in' => array( $post->ID ),
			) );
		}

		$args = array(
			'posts_per_page' => 4,
			'ignore_sticky_posts' => true,
			'post__not_in' => array( $post->ID ),
		);

		// Get posts from the same category.
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			$category = array_shift( $categories );
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'id',
					'terms' => $category->term_id,
				),
			);
		}

		return new WP_Query( $args );
	}

	public static function page_menu_args( $args ) {
		$args['show_home'] = true;
		return $args;
	}

	public static function wp_title( $title, $sep ) {
		global $page, $paged;

		if ( is_feed() ) {
			return $title;
		}

		// Add the blog name
		$title .= get_bloginfo( 'name' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'semicolon' ), max( $paged, $page ) );
		}

		return $title;
	}
}

Semicolon::setup();

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function semicolon_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'semicolon_setup_author' );
