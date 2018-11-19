<?php
/**
 * Featured Slider Options
 *
 * @package Catch_Fullscreen
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function catch_fullscreen_slider_options( $wp_customize ) {
	$wp_customize->add_section( 'catch_fullscreen_featured_slider', array(
			'panel' => 'catch_fullscreen_theme_options',
			'title' => esc_html__( 'Featured Slider', 'catch-fullscreen' ),
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_slider_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'choices'           => catch_fullscreen_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_featured_slider',
			'type'              => 'select',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_slider_number',
			'default'           => '4',
			'sanitize_callback' => 'catch_fullscreen_sanitize_number_range',

			'active_callback'   => 'catch_fullscreen_is_slider_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'catch-fullscreen' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
				'max'   => 20,
				'step'  => 1,
			),
			'label'             => esc_html__( 'No of Slides', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_featured_slider',
			'type'              => 'number',
		)
	);

	$slider_number = get_theme_mod( 'catch_fullscreen_slider_number', 4 );

	for ( $i = 1; $i <= $slider_number ; $i++ ) {
		// Page Sliders
		catch_fullscreen_register_option( $wp_customize, array(
				'name'              => 'catch_fullscreen_slider_page_' . $i,
				'sanitize_callback' => 'catch_fullscreen_sanitize_post',
				'active_callback'   => 'catch_fullscreen_is_slider_active',
				'label'             => esc_html__( 'Page', 'catch-fullscreen' ) . ' #' . $i,
				'section'           => 'catch_fullscreen_featured_slider',
				'type'              => 'dropdown-pages',
			)
		);
	} // End for().
}
add_action( 'customize_register', 'catch_fullscreen_slider_options' );

/** Active Callback Functions */

if( ! function_exists( 'catch_fullscreen_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since Catch Fullscreen 1.0
	*/
	function catch_fullscreen_is_slider_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'catch_fullscreen_slider_option' )->value();

		//return true only if previewed page on customizer matches the type of slider option selected
		return ( 'entire-site' == $enable || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable )
			);
	}
endif;