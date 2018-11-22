<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package Catch_Fullscreen
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'catch-fullscreen' ); ?></a>
	<header id="masthead" class="site-header" role="banner" >
		<div id="header-wrapper">
		<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
		</div><!-- .header-wrapper -->
	</header>



	<?php if ( is_front_page() ) : ?>
	<div id="fullpage">
	<?php endif; ?>
		<?php get_template_part( 'template-parts/header/header', 'media' ); ?>

		<?php if ( ! ( is_front_page() && is_home() ) ) : ?>
		<div id="content" class="site-content section">
			<div class="wrapper">
		<?php endif; ?>
