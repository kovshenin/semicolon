<?php
/**
 * The Semicolon Theme
 */
class Semicolon {
	private function __construct() {}

	/**
	 * Runs immediately at the end of this file, not to be confused
	 * with after_setup_theme, which runs a little bit later.
	 */
	public static function setup() {
		add_action( 'after_setup_theme', array( __CLASS__, 'after_setup_theme' ) );
		do_action( 'semicolon_setup' );
	}

	/**
	 * Runs during core's after_setup_theme
	 */
	public static function after_setup_theme() {
		global $content_width;

		if ( ! isset( $content_width ) ) {
			$content_width = 780;
		}

		add_action( 'pre_get_posts', array( __CLASS__, 'pre_get_posts' ) );
		add_filter( 'posts_results', array( __CLASS__, 'posts_results' ), 10, 2 );
		add_filter( 'found_posts', array( __CLASS__, 'found_posts' ), 10, 2 );
		add_filter( 'body_class', array( __CLASS__, 'body_class' ) );
		add_filter( 'post_class', array( __CLASS__, 'post_class' ), 10, 3 );

		add_filter( 'shortcode_atts_gallery', array( __CLASS__, 'shortcode_atts_gallery' ), 10, 3 );
		add_filter( 'use_default_gallery_style', '__return_false' );

		add_action( 'widgets_init', array( __CLASS__, 'widgets_init' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_action( 'wp', array( __CLASS__, 'setup_author' ) );

		add_filter( 'wp_page_menu_args', array( __CLASS__, 'page_menu_args' ) );
		add_filter( 'wp_title', array( __CLASS__, 'wp_title' ), 10, 2 );

		// Enhanced customizer support
		add_action( 'customize_register', array( __CLASS__, 'customize_register' ) );
		add_action( 'customize_preview_init', array( __CLASS__, 'customize_preview_js' ) );

		load_theme_textdomain( 'semicolon', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Editor style
		add_editor_style();

		// Post thumbnail support and additional image sizes.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 360, 210, true );
		add_image_size( 'semicolon-mini', 60, 60, true );
		add_image_size( 'semicolon-gallery', 220, 220, true );

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

		// Add support for Jetpack's Featured Content
		add_theme_support( 'featured-content', array(
			'filter' => 'semicolon_get_featured_posts',
			'max_posts' => 2,
		) );

		do_action( 'semicolon_after_setup_theme' );
	}

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
	public static function setup_author() {
		global $wp_query;

		if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
			$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
		}
	}

	/**
	 * Sets up all the sidebars in the world.
	 */
	public static function widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Primary', 'semicolon' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => __( 'Secondary', 'semicolon' ),
			'id'            => 'sidebar-2',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => __( 'Tertiary', 'semicolon' ),
			'id'            => 'sidebar-3',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name' => __( 'Footer Sidebar', 'semicolon' ),
			'id'   => 'footer-sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

	/**
	 * Enqueue all the things.
	 */
	public static function enqueue_scripts() {
		wp_enqueue_style( 'semicolon', get_stylesheet_uri(), array( 'semicolon-genericons', 'semicolon-open-sans', 'semicolon-pt-serif' ), '20140520' );
		wp_enqueue_style( 'semicolon-genericons', get_template_directory_uri() . '/css/genericons.css', array(), '20131222' );

		// @todo: allow subsets via i18n.
		wp_enqueue_style( 'semicolon-pt-serif', '//fonts.googleapis.com/css?family=PT+Serif&subset=latin,cyrillic' );
		wp_enqueue_style( 'semicolon-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic' );

		wp_enqueue_script( 'semicolon-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
		wp_enqueue_script( 'semicolon', get_template_directory_uri() . '/js/semicolon.js', array( 'jquery' ), '20140506', true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Use a specific size for the gallery shortcode.
	 *
	 * Unless a size is explicitly provided in the shortcode,
	 * use a size registered with the theme if the number of columns
	 * is more than a single one.
	 */
	public static function shortcode_atts_gallery( $out, $pairs, $atts ) {
		if ( empty( $atts['size'] ) && $out['columns'] >= 2 )
			$out['size'] = 'semicolon-gallery';

		return $out;
	}

	/**
	 * Theme-specific body classes.
	 */
	public static function body_class( $classes ) {
		if ( ! is_singular() )
			$classes[] = 'grid';

		$classes[] = 'no-js';

		return $classes;
	}

	/**
	 * Theme-specific post classes.
	 */
	public static function post_class( $classes, $class, $post_id ) {
		if ( self::is_featured( $post_id ) )
			$classes[] = 'semicolon-featured';

		return $classes;
	}

	/**
	 * Looks up featured posts via a filter or uses ones provided by Jetpack.
	 *
	 * @return WP_Query
	 */
	public static function get_featured_posts() {
		$featured_posts = array();

		$jetpack_featured_posts = apply_filters( 'semicolon_get_featured_posts', false );
		if ( ! empty( $jetpack_featured_posts ) )
			$featured_posts = array_map( 'absint', wp_list_pluck( $jetpack_featured_posts, 'ID' ) );

		if ( empty( $featured_posts ) )
			return new WP_Query;

		return new WP_Query( array(
			'post__in' => $featured_posts,
			'posts_per_page' => 2,
			'ignore_sticky_posts' => true,
		) );
	}

	/**
	 * Returns true if the given post is featured.
	 *
	 * @return bool Whether the given post is featured or not.
	 */
	public static function is_featured( $post_id = null ) {
		$post = get_post( $post_id );
		$featured = false;

		if ( class_exists( 'Featured_Content' ) && method_exists( 'Featured_Content', 'get_setting' ) ) {
			$tag_id = Featured_Content::get_setting( 'tag-id' );
			$post_tags = wp_get_object_terms( $post->ID, 'post_tag' );

			if ( in_array( absint( $tag_id ), wp_list_pluck( $post_tags, 'term_id' ) ) )
				$featured = true;
		}

		return $featured;
	}

	/**
	 * Exclude featured posts from the main loop, because we're going to
	 * attach them to the results a little later with an offset.
	 */
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

				if ( is_paged() ) {
					$query->set( 'offset', ( $query->get( 'paged' ) - 1 ) * $posts_per_page - $featured->post_count );
				}
			}
		}
	}

	/**
	 * When posts are fetched for the front page, look for
	 * some feature posts and prepend them to the resulting array.
	 */
	public static function posts_results( $posts, $query ) {
		if ( ! $query->is_main_query() || is_admin() )
			return $posts;

		if ( is_front_page() ) {

			// Stick only on the home page.
			if ( ! is_paged() ) {
				$featured = self::get_featured_posts();

				if ( $featured->have_posts() ) {

					// Since we're going to unshift these, we'll need them in reverse order.
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

	/**
	 * The number of found posts can vary with featured posts.
	 */
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

	/**
	 * Use a plugin to get related posts, or fall back to
	 * simply fetching some posts from the same category.
	 */
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

	public static function customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 */
	public static function customize_preview_js() {
		wp_enqueue_script( 'semicolon_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
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