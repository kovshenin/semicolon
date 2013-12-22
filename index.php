<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package kovkov
 */

get_header(); ?>

	<?php if ( ! is_front_page() ) : ?>
	<header class="page-header page-description">
		<h1 class="page-title">
			<?php
				if ( is_category() ) :
					single_cat_title();

				elseif ( is_tag() ) :
					single_tag_title();

				elseif ( is_author() ) :
					printf( __( 'Author: %s', 'kovkov' ), '<span class="vcard">' . get_the_author() . '</span>' );

				elseif ( is_day() ) :
					printf( __( 'Day: %s', 'kovkov' ), '<span>' . get_the_date() . '</span>' );

				elseif ( is_month() ) :
					printf( __( 'Month: %s', 'kovkov' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'kovkov' ) ) . '</span>' );

				elseif ( is_year() ) :
					printf( __( 'Year: %s', 'kovkov' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'kovkov' ) ) . '</span>' );

				elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
					_e( 'Asides', 'kovkov' );

				elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
					_e( 'Galleries', 'kovkov');

				elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
					_e( 'Images', 'kovkov');

				elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
					_e( 'Videos', 'kovkov' );

				elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
					_e( 'Quotes', 'kovkov' );

				elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
					_e( 'Links', 'kovkov' );

				elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
					_e( 'Statuses', 'kovkov' );

				elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
					_e( 'Audios', 'kovkov' );

				elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
					_e( 'Chats', 'kovkov' );

				elseif ( is_search() ) :
					printf( __( 'Search Results for: %s', 'kovkov' ), '<span>' . get_search_query() . '</span>' );

				elseif ( is_archive() ):
					_e( 'Archives', 'kovkov' );

				endif;
			?>
		</h1>
		<?php
			// Show an optional term description.
			$term_description = term_description();
			if ( ! empty( $term_description ) ) :
				printf( '<div class="taxonomy-description">%s</div>', $term_description );
			endif;
		?>
	</header><!-- .page-header -->
	<?php endif; // is_front_page ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content' ); ?>

			<?php endwhile; ?>

			<?php kovkov_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
