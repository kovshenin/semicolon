<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<script type="text/javascript">document.body.className = document.body.className.replace('no-js','js');</script>
<div id="page" class="hfeed site">

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<a class="menu-toggle"><?php _e( 'Menu', 'semicolon' ); ?></a>
			<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'semicolon' ); ?></a>

			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_class'     => 'semicolon-navigation',
				'depth'          => 1,
			) ); ?>

			<?php wp_nav_menu( array(
				'theme_location' => 'social',
				'menu_class'     => 'semicolon-social',
				'link_before'    => '<span>',
				'link_after'     => '</span>',
				'fallback_cb'    => '',
				'depth'          => 1,
			) ); ?>

		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<?php do_action( 'semicolon_header_after' ); ?>

	<div id="content" class="site-content">
