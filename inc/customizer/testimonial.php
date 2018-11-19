<?php
/**
 * Add Testimonial Settings in Customizer
 *
 * @package Catch_Fullscreen
*/

/**
 * Add testimonial options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function catch_fullscreen_testimonial_options( $wp_customize ) {
    // Add note to Jetpack Testimonial Section
    catch_fullscreen_register_option( $wp_customize, array(
            'name'              => 'catch_fullscreen_jetpack_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Fullscreen_Note_Control',
            'label'             => sprintf( esc_html__( 'For Testimonial Options, go %1$shere%2$s', 'catch-fullscreen' ),
                '<a href="javascript:wp.customize.section( \'catch_fullscreen_testimonials\' ).focus();">',
                '</a>'
            ),
            'section'           => 'jetpack_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'catch_fullscreen_testimonials', array(
            'panel'    => 'catch_fullscreen_theme_options',
            'title'    => esc_html__( 'Testimonials', 'catch-fullscreen' ),
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
            'name'              => 'catch_fullscreen_testimonial_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Fullscreen_Note_Control',
            'active_callback'   => 'catch_fullscreen_is_ect_testimonial_inactive',
            'label'             => sprintf( esc_html__( 'For Testimonial, install %1$sEssential Content Types%2$s Plugin with Testimonial Content Type Enabled', 'catch-fullscreen' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'
            ),
            'section'           => 'catch_fullscreen_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    catch_fullscreen_register_option( $wp_customize, array(
            'name'              => 'catch_fullscreen_testimonial_option',
            'default'           => 'disabled',
            'sanitize_callback' => 'catch_fullscreen_sanitize_select',
            'active_callback'   => 'catch_fullscreen_is_ect_testimonial_active',
            'choices'           => catch_fullscreen_section_visibility_options(),
            'label'             => esc_html__( 'Enable on', 'catch-fullscreen' ),
            'section'           => 'catch_fullscreen_testimonials',
            'type'              => 'select',
            'priority'          => 1,
        )
    );

    catch_fullscreen_register_option( $wp_customize, array(
            'name'              => 'catch_fullscreen_testimonials_main_image',
            'sanitize_callback' => 'catch_fullscreen_sanitize_image',
             'active_callback'   => 'catch_fullscreen_is_testimonial_active',
            'custom_control'    => 'WP_Customize_Image_Control',
            'label'             => esc_html__( 'Section Background Image', 'catch-fullscreen' ),
            'section'           => 'catch_fullscreen_testimonials',
            'mime_type'         => 'image',
        )
    );

    catch_fullscreen_register_option( $wp_customize, array(
            'name'              => 'catch_fullscreen_testimonials_bg_image_opacity',
            'default'           => '10',
            'sanitize_callback' => 'catch_fullscreen_sanitize_number_range',
            'active_callback'   => 'catch_fullscreen_is_testimonial_active',
            'label'             => esc_html__( 'Background Image Overlay', 'catch-fullscreen' ),
            'section'           => 'catch_fullscreen_testimonials',
            'type'              => 'number',
            'input_attrs'       => array(
                'style' => 'width: 60px;',
                'min'   => 0,
                'max'   => 100,
            ),
        )
    );

    catch_fullscreen_register_option( $wp_customize, array(
            'name'              => 'catch_fullscreen_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Catch_Fullscreen_Note_Control',
            'active_callback'   => 'catch_fullscreen_is_testimonial_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'catch-fullscreen' ),
                '<a href="javascript:wp.customize.section( \'jetpack_testimonials\' ).focus();">',
                '</a>'
            ),
            'section'           => 'catch_fullscreen_testimonials',
            'type'              => 'description',
        )
    );

     catch_fullscreen_register_option( $wp_customize, array(
            'name'              => 'catch_fullscreen_testimonial_number',
            'default'           => '4',
            'sanitize_callback' => 'catch_fullscreen_sanitize_number_range',
             'active_callback'   => 'catch_fullscreen_is_testimonial_active',
            'label'             => esc_html__( 'Number of items', 'catch-fullscreen' ),
            'section'           => 'catch_fullscreen_testimonials',
            'type'              => 'number',
            'input_attrs'       => array(
                'style'             => 'width: 100px;',
                'min'               => 0,
            ),
        )
    );

    $number = get_theme_mod( 'catch_fullscreen_testimonial_number', 4 );

    for ( $i = 1; $i <= $number ; $i++ ) {
        //for CPT
        catch_fullscreen_register_option( $wp_customize, array(
                'name'              => 'catch_fullscreen_testimonial_cpt_' . $i,
                'sanitize_callback' => 'catch_fullscreen_sanitize_post',
                'active_callback'   => 'catch_fullscreen_is_testimonial_active',
                'label'             => esc_html__( 'Testimonial', 'catch-fullscreen' ) . ' ' . $i ,
                'section'           => 'catch_fullscreen_testimonials',
                'type'              => 'select',
                'choices'           => catch_fullscreen_generate_post_array( 'jetpack-testimonial' ),
            )
        );
    } // End for().
}
add_action( 'customize_register', 'catch_fullscreen_testimonial_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'catch_fullscreen_is_testimonial_active' ) ) :
    /**
    * Return true if portfolio is active
    *
    * @since Adonis 0.1
    */
    function catch_fullscreen_is_testimonial_active( $control ) {
        $enable = $control->manager->get_setting( 'catch_fullscreen_testimonial_option' )->value();

        //return true only if previwed page on customizer matches the type of content option selected
        return ( catch_fullscreen_is_ect_testimonial_active ($control) && catch_fullscreen_check_section( $enable ) );
    }
endif;

if ( ! function_exists( 'catch_fullscreen_is_ect_testimonial_inactive' ) ) :
    /**
    *
    * @since Adonis 0.1
    */
    function catch_fullscreen_is_ect_testimonial_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_Testimonial' ) );
    }
endif;

if ( ! function_exists( 'catch_fullscreen_is_ect_testimonial_active' ) ) :
    /**
    *
    * @since Adonis 0.1
    */
    function catch_fullscreen_is_ect_testimonial_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_Testimonial' ) );
    }
endif;