<?php
/**
 * Theme Options
 *
 * @package Catch_Fullscreen
 */

/**
 * Add theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function catch_fullscreen_theme_options( $wp_customize ) {
	$wp_customize->add_panel( 'catch_fullscreen_theme_options', array(
		'title'    => esc_html__( 'Theme Options', 'catch-fullscreen' ),
		'priority' => 130,
	) );

	// Breadcrumb Option.
	$wp_customize->add_section( 'catch_fullscreen_breadcrumb_options', array(
		'description'   => esc_html__( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance.', 'catch-fullscreen' ),
		'panel'         => 'catch_fullscreen_theme_options',
		'title'         => esc_html__( 'Breadcrumb', 'catch-fullscreen' ),
	) );

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_breadcrumb_option',
			'default'           => 1,
			'sanitize_callback' => 'catch_fullscreen_sanitize_checkbox',
			'label'             => esc_html__( 'Check to enable Breadcrumb', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_breadcrumb_options',
			'type'              => 'checkbox',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_breadcrumb_on_homepage',
			'sanitize_callback' => 'catch_fullscreen_sanitize_checkbox',
			'label'             => esc_html__( 'Check to enable Breadcrumb on Homepage', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_breadcrumb_options',
			'type'              => 'checkbox',
		)
	);

	// Layout Options
	$wp_customize->add_section( 'catch_fullscreen_layout_options', array(
		'title' => esc_html__( 'Layout Options', 'catch-fullscreen' ),
		'panel' => 'catch_fullscreen_theme_options',
		)
	);

	/* Default Layout */
	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_default_layout',
			'default'           => 'right-sidebar',
			'description'       => esc_html__( 'Only for Single Pages including Static Front Page', 'catch-fullscreen' ),
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'label'             => esc_html__( 'Default Layout', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar' => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'catch-fullscreen' ),
				'no-sidebar'    => esc_html__( 'No Sidebar', 'catch-fullscreen' ),
			),
		)
	);

	/* Homepage/Archive Layout */
	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_homepage_archive_layout',
			'default'           => 'right-sidebar',
			'description'       => esc_html__( 'Not for Homepage', 'catch-fullscreen' ),
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'label'             => esc_html__( 'Archive Layout', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar' => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'catch-fullscreen' ),
				'no-sidebar'    => esc_html__( 'No Sidebar', 'catch-fullscreen' ),
			),
		)
	);

	/* Homepage Content Alignment */
	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_home_content_align',
			'default'           => 'content-align-right',
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'label'             => esc_html__( 'Homepage Posts Content Alignment', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'content-align-right'  => esc_html__( 'Content Right', 'catch-fullscreen' ),
				'content-align-center' => esc_html__( 'Content Center', 'catch-fullscreen' ),
			),
		)
	);

	/* Homepage Content BG */
	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_home_content_bg',
			'default'           => 'disable',
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'label'             => esc_html__( 'Homepage Posts Content Background', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'disable' => esc_html__( 'Disabled', 'catch-fullscreen' ),
				'enable'  => esc_html__( 'Enabled', 'catch-fullscreen' ),
			),
		)
	);

	/* Archive Content Layout */
	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_content_layout',
			'default'           => 'excerpt-image-top',
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'description'       => esc_html__( 'Only for blog/archive pages', 'catch-fullscreen' ),
			'label'             => esc_html__( 'Archive Content Layout', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'excerpt-image-top'      => esc_html__( 'Show Excerpt( Image Top )', 'catch-fullscreen' ),
				'full-content'           => esc_html__( 'Show Full Content ( No Featured Image )', 'catch-fullscreen' ),
			),
		)
	);

	/* Single Page/Post Image Layout */
	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_single_layout',
			'default'           => 'disabled',
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'label'             => esc_html__( 'Single Page/Post Image Layout', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'disabled'       => esc_html__( 'Disabled', 'catch-fullscreen' ),
				'post-thumbnail' => esc_html__( 'Post Thumbnail', 'catch-fullscreen' ),
			),
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'catch_fullscreen_excerpt_options', array(
		'panel'     => 'catch_fullscreen_theme_options',
		'title'     => esc_html__( 'Excerpt Options', 'catch-fullscreen' ),
	) );

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_excerpt_length',
			'default'           => '10',
			'sanitize_callback' => 'absint',
			'description' => esc_html__( 'Excerpt length. Default is 20 words', 'catch-fullscreen' ),
			'input_attrs' => array(
				'min'   => 10,
				'max'   => 200,
				'step'  => 5,
				'style' => 'width: 60px;',
			),
			'label'    => esc_html__( 'Excerpt Length (words)', 'catch-fullscreen' ),
			'section'  => 'catch_fullscreen_excerpt_options',
			'type'     => 'number',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_excerpt_more_text',
			'default'           => esc_html__( 'Continue Reading', 'catch-fullscreen' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Continue Reading Text', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_excerpt_options',
			'type'              => 'text',
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'catch_fullscreen_search_options', array(
		'panel'     => 'catch_fullscreen_theme_options',
		'title'     => esc_html__( 'Search Options', 'catch-fullscreen' ),
	) );

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_search_text',
			'default'           => esc_html__( 'Search', 'catch-fullscreen' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Search Text', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_search_options',
			'type'              => 'text',
		)
	);

	// Homepage / Frontpage Options.
	$wp_customize->add_section( 'catch_fullscreen_homepage_options', array(
		'description' => esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'catch-fullscreen' ),
		'panel'       => 'catch_fullscreen_theme_options',
		'title'       => esc_html__( 'Homepage / Frontpage Options', 'catch-fullscreen' ),
	) );

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_front_page_category',
			'sanitize_callback' => 'catch_fullscreen_sanitize_category_list',
			'custom_control'    => 'Catch_Fullscreen_Multi_Categories_Control',
			'label'             => esc_html__( 'Categories', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_homepage_options',
			'type'              => 'dropdown-categories',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_main_pager_mobile',
			'sanitize_callback' => 'catch_fullscreen_sanitize_checkbox',
			'label'             => esc_html__( 'Enable main pager on Mobile Devices', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_homepage_options',
			'type'              => 'checkbox',
    	)
	);

	 // Homepage Navigation/Scroll
	$wp_customize->add_section( 'catch_fullscreen_fullpage', array(
			'panel'       => 'catch_fullscreen_theme_options',
			'description' => esc_html__( 'Homepage Fullscreen Options', 'catch-fullscreen' ),
			'title'       => esc_html__( 'FullPage Options', 'catch-fullscreen' ),
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_desktop_navigation',
			'default'           => 'desktop-nav-on-page-right',
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'choices'           => array(
				'desktop-nav-on-header'     => esc_html__( 'On Header', 'catch-fullscreen' ),
				'desktop-nav-on-page-right' => esc_html__( 'On Page Right', 'catch-fullscreen' ),
			),
			'label'             => esc_html__( 'Desktop Navigation', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_fullpage',
			'type'              => 'radio',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_mobile_navigation',
			'default'           => 'mobile-nav-on-header',
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'choices'           => array(
				'mobile-nav-on-header'     => esc_html__( 'On Header', 'catch-fullscreen' ),
				'mobile-nav-on-page-right' => esc_html__( 'On Page Right', 'catch-fullscreen' ),
			),
			'label'             => esc_html__( 'Mobile Navigation', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_fullpage',
			'type'              => 'radio',
		)
	);

	// Disable post content
    catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_homepage_disable_content',
			'default'           => 1,
			'sanitize_callback' => 'catch_fullscreen_sanitize_checkbox',
			'label'             => esc_html__( 'Disable blog post content', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_homepage_options',
			'type'              => 'checkbox',
    	)
	);

	// Pagination Options.
	$pagination_type = get_theme_mod( 'catch_fullscreen_pagination_type', 'default' );

	$nav_desc = '';

	/**
	* Check if navigation type is Jetpack Infinite Scroll and if it is enabled
	*/
	$action = 'install-plugin';
	$slug   = 'catch-infinite-scroll';

	$install_url = wp_nonce_url(
	    add_query_arg(
	        array(
	            'action' => $action,
	            'plugin' => $slug
	        ),
	        admin_url( 'update.php' )
	    ),
	    $action . '_' . $slug
	);

	$nav_desc = sprintf(
		wp_kses(
			__( 'For infinite scrolling, use %1$sCatch Infinite Scroll Plugin%2$s with Infinite Scroll module Enabled.', 'catch-fullscreen' ),
			array(
				'a' => array(
					'href' => array(),
					'target' => array(),
				),
				'br'=> array()
			)
		),
		'<a target="_blank" href="' . esc_url( $install_url ) . '">',
		'</a>'
	);

	$wp_customize->add_section( 'catch_fullscreen_pagination_options', array(
		'description' => $nav_desc,
		'panel'       => 'catch_fullscreen_theme_options',
		'title'       => esc_html__( 'Pagination Options', 'catch-fullscreen' ),
	) );

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_pagination_type',
			'default'           => 'default',
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'choices'           => catch_fullscreen_get_pagination_types(),
			'label'             => esc_html__( 'Pagination type', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_pagination_options',
			'type'              => 'select',
		)
	);

	/* Scrollup Options */
	$wp_customize->add_section( 'catch_fullscreen_scrollup', array(
		'panel'    => 'catch_fullscreen_theme_options',
		'title'    => esc_html__( 'Scrollup Options', 'catch-fullscreen' ),
	) );

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_disable_scrollup',
			'sanitize_callback' => 'catch_fullscreen_sanitize_checkbox',
			'label'             => esc_html__( 'Disable Scroll Up', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_scrollup',
			'type'              => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'catch_fullscreen_theme_options' );
