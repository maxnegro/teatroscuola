<?php
/**
 * Header Media Options
 *
 * @package Catch_Fullscreen
 */

function catch_fullscreen_header_media_options( $wp_customize ) {
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'If you add video, it will only show up on Homepage/FrontPage. Other Pages will use Header/Post/Page Image depending on your selection of option. Header Image will be used as a fallback while the video loads ', 'catch-fullscreen' );

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_header_media_option',
			'default'           => 'entire-site-page-post',
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'catch-fullscreen' ),
				'exclude-home'           => esc_html__( 'Excluding Homepage', 'catch-fullscreen' ),
				'exclude-home-page-post' => esc_html__( 'Excluding Homepage, Page/Post Featured Image', 'catch-fullscreen' ),
				'entire-site'            => esc_html__( 'Entire Site', 'catch-fullscreen' ),
				'entire-site-page-post'  => esc_html__( 'Entire Site, Page/Post Featured Image', 'catch-fullscreen' ),
				'pages-posts'            => esc_html__( 'Pages and Posts', 'catch-fullscreen' ),
				'disable'                => esc_html__( 'Disabled', 'catch-fullscreen' ),
			),
			'label'             => esc_html__( 'Enable on', 'catch-fullscreen' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_header_media_content_alignment',
			'default'           => 'content-align-center',
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'choices'           => array(
				'content-align-center' => esc_html__( 'Center', 'catch-fullscreen' ),
				'content-align-right'  => esc_html__( 'Right', 'catch-fullscreen' ),
				'content-align-left'   => esc_html__( 'Left', 'catch-fullscreen' ),
			),
			'label'             => esc_html__( 'Content Alignment', 'catch-fullscreen' ),
			'section'           => 'header_image',
			'type'              => 'radio',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_header_media_bg_image_opacity',
			'default'           => '10',
			'sanitize_callback' => 'catch_fullscreen_sanitize_number_range',
			'label'             => esc_html__( 'Background Image Overlay', 'catch-fullscreen' ),
			'section'           => 'header_image',
			'type'              => 'number',
			'input_attrs'       => array(
				'style' => 'width: 60px;',
				'min'   => 0,
				'max'   => 100,
			),
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_header_media_title',
			'sanitize_callback' => 'wp_kses_post',
			'default'           => esc_html__( 'Dancing Under The Sky', 'catch-fullscreen' ),
			'label'             => esc_html__( 'Header Media Title', 'catch-fullscreen' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

    catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_header_media_text',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Text', 'catch-fullscreen' ),
			'section'           => 'header_image',
			'type'              => 'textarea',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_header_media_url',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => esc_html__( 'Header Media Url', 'catch-fullscreen' ),
			'section'           => 'header_image',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_header_media_url_text',
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Header Media Url Text', 'catch-fullscreen' ),
			'section'           => 'header_image',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_header_url_target',
			'sanitize_callback' => 'catch_fullscreen_sanitize_checkbox',
			'label'             => esc_html__( 'Check to Open Link in New Window/Tab', 'catch-fullscreen' ),
			'section'           => 'header_image',
			'type'              => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'catch_fullscreen_header_media_options' );

