<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 */

if ( ! function_exists( 'semicolon_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */
function semicolon_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'semicolon' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'semicolon' ) ); ?>
			<?php next_post_link(     '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link',     'semicolon' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'semicolon_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function semicolon_posted_on() {
	$human_time = semicolon_human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) );
	$regular_time = get_the_time( get_option( 'date_format' ) );

	$output_time = sprintf( '%s <span style="display:none;">%s</span>', $human_time, $regular_time );

	if ( current_time( 'timestamp' ) > get_the_time( 'U' ) + 60 * 60 * 24 * 14 )
		$output_time = $regular_time;

	printf( ' <a class="entry-date published" datetime="%s" href="%s">%s</a>', get_the_date('c'), esc_url( get_permalink() ), $output_time );
	printf( '<time class="updated" datetime="%s">%s</time>', get_the_modified_date('c'), get_the_modified_date() );
	printf( '<span class="author vcard"><a class="url fn n" href="%s">%s</a></span>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_the_author() );
}
endif;

if ( ! function_exists( 'semicolon_human_time_diff' ) ) :
/**
 * Same as core's human_time_diff(), only in the "ago" context,
 * which is different for some languages.
 *
 * @since Semicolon 1.9
 *
 * @param int $from Unix timestamp from which the difference begins.
 * @param int $to Optional. Unix timestamp to end the time difference. Default becomes time() if not set.
 * @return string Human readable time difference.
 */
function semicolon_human_time_diff( $from, $to = '' ) {
	if ( empty( $to ) )
		$to = time();

	$diff = (int) abs( $to - $from );

	if ( $diff < HOUR_IN_SECONDS ) {
		$mins = round( $diff / MINUTE_IN_SECONDS );
		if ( $mins <= 1 )
			$mins = 1;
		/* translators: min=minute */
		$since = sprintf( _n( '%s min ago', '%s mins ago', $mins, 'semicolon' ), $mins );
	} elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
		$hours = round( $diff / HOUR_IN_SECONDS );
		if ( $hours <= 1 )
			$hours = 1;
		$since = sprintf( _n( '%s hour ago', '%s hours ago', $hours, 'semicolon' ), $hours );
	} elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
		$days = round( $diff / DAY_IN_SECONDS );
		if ( $days <= 1 )
			$days = 1;
		$since = sprintf( _n( '%s day ago', '%s days ago', $days, 'semicolon' ), $days );
	} elseif ( $diff < 30 * DAY_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
		$weeks = round( $diff / WEEK_IN_SECONDS );
		if ( $weeks <= 1 )
			$weeks = 1;
		$since = sprintf( _n( '%s week ago', '%s weeks ago', $weeks, 'semicolon' ), $weeks );
	} elseif ( $diff < YEAR_IN_SECONDS && $diff >= 30 * DAY_IN_SECONDS ) {
		$months = round( $diff / ( 30 * DAY_IN_SECONDS ) );
		if ( $months <= 1 )
			$months = 1;
		$since = sprintf( _n( '%s month ago', '%s months ago', $months, 'semicolon' ), $months );
	} elseif ( $diff >= YEAR_IN_SECONDS ) {
		$years = round( $diff / YEAR_IN_SECONDS );
		if ( $years <= 1 )
			$years = 1;
		$since = sprintf( _n( '%s year ago', '%s years ago', $years, 'semicolon' ), $years );
	}

	return $since;
}
endif; // function_exists

/**
 * Returns true if a blog has more than 1 category.
 */
function semicolon_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so semicolon_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so semicolon_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in semicolon_categorized_blog.
 */
function semicolon_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'semicolon_category_transient_flusher' );
add_action( 'save_post',     'semicolon_category_transient_flusher' );

if ( ! function_exists( 'semicolon_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return void
 */
function semicolon_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&larr;', 'semicolon' ),
		'next_text' => __( '&rarr;', 'semicolon' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'semicolon' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;