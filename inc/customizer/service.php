<?php
/**
* The template for adding Service Settings in Customizer
*
 * @package Catch_Fullscreen
*/

function catch_fullscreen_service_options( $wp_customize ) {
	// Add note to Jetpack Portfolio Section
    catch_fullscreen_register_option( $wp_customize, array(
            'name'              => 'catch_fullscreen_service_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Fullscreen_Note_Control',
            'label'             => sprintf( esc_html__( 'For Service Options, go %1$shere%2$s', 'catch-fullscreen' ),
                 '<a href="javascript:wp.customize.section( \'catch_fullscreen_service\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'ect_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	$wp_customize->add_section( 'catch_fullscreen_service', array(
			'panel'    => 'catch_fullscreen_theme_options',
			'title'    => esc_html__( 'Service', 'catch-fullscreen' ),
		)
	);

	$action = 'install-plugin';
	$slug   = 'essential-content-types';

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

	catch_fullscreen_register_option( $wp_customize, array(
            'name'              => 'catch_fullscreen_service_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Fullscreen_Note_Control',
            'active_callback'   => 'catch_fullscreen_is_ect_service_inactive',
            'label'             => sprintf( esc_html__( 'For Services, install %1$sEssential Content Types%2$s Plugin with Services Content Type Enabled', 'catch-fullscreen' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'
            ),
            'section'           => 'catch_fullscreen_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_service_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'catch_fullscreen_sanitize_select',
			'active_callback'   => 'catch_fullscreen_is_ect_service_active',
			'choices'           => catch_fullscreen_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_service',
			'type'              => 'select',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_service_main_image',
			'sanitize_callback' => 'catch_fullscreen_sanitize_image',
			'active_callback'   => 'catch_fullscreen_is_services_active',
			'custom_control'    => 'WP_Customize_Image_Control',
			'label'             => esc_html__( 'Section Background Image', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_service',
			'mime_type'         => 'image',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_service_bg_image_opacity',
			'default'           => '10',
			'sanitize_callback' => 'catch_fullscreen_sanitize_number_range',
			'active_callback'   => 'catch_fullscreen_is_services_active',
			'label'             => esc_html__( 'Background Image Overlay', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_service',
			'type'              => 'number',
			'input_attrs'       => array(
				'style' => 'width: 60px;',
				'min'   => 0,
				'max'   => 100,
			),
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_service_headline',
			'default'           => esc_html__( 'Services', 'catch-fullscreen' ),
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'catch_fullscreen_is_services_active',
			'label'             => esc_html__( 'Service Archive Title', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_service',
			'type'              => 'text',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
			'name'              => 'catch_fullscreen_service_subheadline',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'catch_fullscreen_is_services_active',
			'label'             => esc_html__( 'Service Archive Content', 'catch-fullscreen' ),
			'section'           => 'catch_fullscreen_service',
			'type'              => 'textarea',
		)
	);

	catch_fullscreen_register_option( $wp_customize, array(
				'name'              => 'catch_fullscreen_service_number',
				'default'           => 4,
				'sanitize_callback' => 'catch_fullscreen_sanitize_number_range',
				'active_callback'   => 'catch_fullscreen_is_services_active',
				'description'       => esc_html__( 'Save and refresh the page if No. of Service is changed', 'catch-fullscreen' ),
				'input_attrs'       => array(
					'style' => 'width: 100px;',
					'min'   => 0,
				),
				'label'             => esc_html__( 'No of Service', 'catch-fullscreen' ),
				'section'           => 'catch_fullscreen_service',
				'type'              => 'number',
		)
	);

	$number = get_theme_mod( 'catch_fullscreen_service_number', 4 );

	for ( $i = 1; $i <= $number ; $i++ ) {
		//for CPT
		catch_fullscreen_register_option( $wp_customize, array(
				'name'              => 'catch_fullscreen_service_cpt_' . $i,
				'sanitize_callback' => 'catch_fullscreen_sanitize_post',
				'default'           => 0,
				'active_callback'   => 'catch_fullscreen_is_services_active',
				'label'             => esc_html__( 'Service ', 'catch-fullscreen' ) . ' ' . $i ,
				'section'           => 'catch_fullscreen_service',
				'type'              => 'select',
				'choices'           => catch_fullscreen_generate_post_array( 'ect-service' ),
			)
		);
	} // End for().
}
add_action( 'customize_register', 'catch_fullscreen_service_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'catch_fullscreen_is_services_active' ) ) :
	/**
	* Return true if featured content is active
	*
	* @since Adonis 0.1
	*/
	function catch_fullscreen_is_services_active( $control ) {
		$enable = $control->manager->get_setting( 'catch_fullscreen_service_option' )->value();

		return ( catch_fullscreen_is_ect_service_active( $control ) &&  catch_fullscreen_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'catch_fullscreen_is_ect_service_inactive' ) ) :
    /**
    * Return true if service is active
    *
    * @since Adonis 0.1
    */
    function catch_fullscreen_is_ect_service_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;

if ( ! function_exists( 'catch_fullscreen_is_ect_service_active' ) ) :
    /**
    * Return true if service is active
    *
    * @since Adonis 0.1
    */
    function catch_fullscreen_is_ect_service_active( $control ) {
        return ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;
