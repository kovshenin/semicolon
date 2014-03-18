<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

	<?php if ( ! is_front_page() ) : ?>
	<header class="page-header page-description">
		<h1 class="page-title">
			<?php
				if ( is_category() ) :
					single_cat_title();

				elseif ( is_tag() ) :
					printf( __( 'Tagged: %s', 'semicolon' ), single_tag_title( '', false ) );

				elseif ( is_author() ) :
					printf( __( 'Author: %s', 'semicolon' ), '<span class="vcard">' . get_the_author() . '</span>' );

				elseif ( is_day() ) :
					printf( __( 'Day: %s', 'semicolon' ), '<span>' . get_the_date() . '</span>' );

				elseif ( is_month() ) :
					printf( __( 'Month: %s', 'semicolon' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'semicolon' ) ) . '</span>' );

				elseif ( is_year() ) :
					printf( __( 'Year: %s', 'semicolon' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'semicolon' ) ) . '</span>' );

				elseif ( is_search() ) :
					printf( __( 'Search Results for: %s', 'semicolon' ), '<span>' . get_search_query() . '</span>' );

				elseif ( is_archive() ):
					_e( 'Archives', 'semicolon' );

				endif;
			?>
		</h1>
	</header><!-- .page-header -->
	<?php endif; // is_front_page ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content' ); ?>

			<?php endwhile; ?>

			<?php semicolon_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
