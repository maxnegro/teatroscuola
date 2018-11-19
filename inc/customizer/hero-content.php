<?php
/**
 * Hero Content Options
 *
 * @package Catch_Fullscreen
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function catch_fullscreen_hero_content_options( $wp_customize ) {
	$wp_customize->add_section( 'catch_fullscreen_hero_content_options', array(
			'title' => esc_html__( 'Hero Content', 'catch-fullscreen' ),
			'panel' => 'catch_fullscreen_theme_options',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_hero_content_visibility',
			'default'           => 'disabled',
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'choices'           => catch_fullscreen_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_hero_content_options',
			'type'              => 'select',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
            'name'              => 'catch_fullscreen_hero_main_image',
            'sanitize_callback' => 'catch_fullscreen_sanitize_image',
            'active_callback'   => 'catch_fullscreen_is_hero_content_active',
            'custom_control'    => 'WP_Customize_Image_Control',
            'label'             => esc_html__( 'Section Background Image', 'catch-fullscreen' ),
            'section'           => 'catch_fullscreen_hero_content_options',
            'mime_type'         => 'image',
        )
    );

    catch_fullscreen_register_option( $wp_customize, array(
            'name'              => 'catch_fullscreen_hero_bg_image_opacity',
            'default'           => '10',
            'sanitize_callback' => 'catch_fullscreen_sanitize_number_range',
            'active_callback'   => 'catch_fullscreen_is_hero_content_active',
            'label'             => esc_html__( 'Background Image Overlay', 'catch-fullscreen' ),
            'section'           => 'catch_fullscreen_hero_content_options',
            'type'              => 'number',
            'input_attrs'       => array(
                'style' => 'width: 60px;',
                'min'   => 0,
                'max'   => 100,
            ),
        )
    );

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_hero_content',
			'default'           => '0',
			'sanitize_callback' => 'catch_fullscreen_sanitize_post',
			'active_callback'   => 'catch_fullscreen_is_hero_content_active',
			'label'             => esc_html__( 'Page', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_hero_content_options',
			'type'              => 'dropdown-pages',
		)
	);
}
add_action( 'customize_register', 'catch_fullscreen_hero_content_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'catch_fullscreen_is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since Catch Fullscreen 1.0
	*/
	function catch_fullscreen_is_hero_content_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option( 'page_for_posts' );

		$enable = $control->manager->get_setting( 'catch_fullscreen_hero_content_visibility' )->value();

		return ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) &&	 'homepage' == $enable )
			);
	}
endif;