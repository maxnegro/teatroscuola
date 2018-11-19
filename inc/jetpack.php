<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.me/
 *
 * @package Catch_Fullscreen
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function catch_fullscreen_jetpack_setup() {
	/**
	 * Setup Infinite Scroll using JetPack if navigation type is set
	 */
	$pagination_type = get_theme_mod( 'catch_fullscreen_pagination_type', 'default' );

	if ( 'infinite-scroll' === $pagination_type ) {
		add_theme_support( 'infinite-scroll', array(
			'container'      => 'main',
			'wrapper'        => false,
			'render'         => 'catch_fullscreen_infinite_scroll_render',
			'footer'         => false,
			'footer_widgets' => array( 'sidebar-2', 'sidebar-3', 'sidebar-4', 'sidebar-5' ),
		) );
	}

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	add_theme_support( 'featured-content', array(
		'filter'     => 'catch_fullscreen_get_featured_posts',
		'max_posts'  => 3,
		'post_types' => array( 'post', 'page' ),
	) );

	// Add theme support for JetPack Portfolio.
	add_theme_support( 'jetpack-portfolio', array(
		'title'          => true,
		'content'        => true,
		'featured-image' => true,
	) );

	// Add theme support for Content Options.
	add_theme_support( 'jetpack-content-options', array(
		'post-details'    => array(
			'stylesheet' => 'catch-fullscreen-style',
			'date'       => '.posted-on, .sep',
			'categories' => '.cat-links'
		),
	) );

	// Add theme support for testimonials.
	add_theme_support( 'jetpack-testimonial' );
}
add_action( 'after_setup_theme', 'catch_fullscreen_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function catch_fullscreen_infinite_scroll_render() {
	do_action( 'catch_fullscreen_jetpack_infinite_scroll_before' );

	while ( have_posts() ) {
		the_post();
		if ( catch_fullscreen_is_product_archive() ) :
			wc_get_template_part( 'content', 'product' );
		elseif ( is_search() ) :
			get_template_part( 'template-parts/content/content', 'search' );
		else :
			get_template_part( 'template-parts/content/content', get_post_format() );
		endif;
	}

	do_action( 'catch_fullscreen_jetpack_infinite_scroll_after' );
}

/**
 * Jetpack infinite scroll duplicates posts where orderby is anything other than modified or date
 * This filter offsets the products returned by however many are displayed per page
 *
 * @link https://github.com/Automattic/jetpack/issues/1135
 * @param  array $args infinite scroll args.
 * @return array       infinite scroll args.
 */
function catch_fullscreen_fix_duplicate_products( $args ) {
	if ( ( isset( $args['post_type'] ) && 'product' === $args['post_type'] ) || ( isset( $args['taxonomy'] ) && 'product_cat' === $args['taxonomy'] ) ) {
		$args['offset'] = $args['posts_per_page'] * $args['paged'];
	}

 	return $args;
}
add_filter( 'infinite_scroll_query_args', 'catch_fullscreen_fix_duplicate_products', 100 );

/**
 * Portfolio Title
 *
 * @param  string $before before title content.
 * @param  string $after after title content.
 */
function catch_fullscreen_portfolio_title( $before = '', $after = '' ) {
	get_option( 'jetpack_portfolio_title', esc_html__( 'Projects', 'catch-fullscreen' ) );
	$title = '';

	if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
		if ( isset( $jetpack_portfolio_title ) && '' !== $jetpack_portfolio_title ) {
			$title = $jetpack_portfolio_title;
		} else {
			$title = post_type_archive_title( '', false );
		}
	} elseif ( is_tax( 'jetpack-portfolio-type' ) || is_tax( 'jetpack-portfolio-tag' ) ) {
		$title = single_term_title( '', false );
	}

	$title = $before . $title . $after;

	echo $title;
}

/**
 * Portfolio Content
 *
 * @param  string $before before title content.
 * @param  string $after after title content.
 */
function catch_fullscreen_portfolio_content( $before = '', $after = '' ) {
	$jetpack_portfolio_content = get_option( 'jetpack_portfolio_content' );
	$title = '';

	if ( is_tax() && get_the_archive_description() ) {
		$title = $before . get_the_archive_description() . $after;
	} elseif ( isset( $jetpack_portfolio_content ) && '' !== $jetpack_portfolio_content ) {
		$content = convert_chars( convert_smilies( wptexturize( stripslashes( wp_kses_post( addslashes( $jetpack_portfolio_content ) ) ) ) ) );
		$title = $before . $content . $after;
	}

	echo $title;
}

/**
 * Support JetPack featured content
 */
function catch_fullscreen_get_featured_posts() {
	$number = get_theme_mod( 'catch_fullscreen_featured_content_number', 3 );

	$post_list    = array();

	$args = array(
		'posts_per_page'      => $number,
		'ignore_sticky_posts' => 1, // ignore sticky posts.
		'post_type'                => 'featured-content',
	);

	for ( $i = 1; $i <= $number; $i++ ) {
		$post_id = '';

		$post_id = get_theme_mod( 'catch_fullscreen_featured_content_cpt_' . $i );

		if ( $post_id && '' !== $post_id ) {
			$post_list = array_merge( $post_list, array( $post_id ) );
		}
	}

	$args['post__in'] = $post_list;
	$args['orderby']  = 'post__in';

	$featured_posts = get_posts( $args );

	return $featured_posts;
}