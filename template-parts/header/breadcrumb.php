<?php
/**
 * Display Breadcrumb
 *
 * @package Catch_Fullscreen
 */
?>

<?php
$enable_breadcrumb = get_theme_mod( 'catch_fullscreen_breadcrumb_option', 1 );

if ( $enable_breadcrumb ) :
    if ( function_exists( 'woocommerce_breadcrumb' ) && ( is_woocommerce() || is_shop() ) ) : ?>
        <div class="breadcrumb-area">
            <div class="wrapper">
                <?php
                    $args = array(
                        'delimiter' => '',
                        'before'    => '<span>',
                        'after'     => '</span>'

                    );

                    woocommerce_breadcrumb( $args );
                ?>
            </div><!-- .wrapper -->
        </div><!-- .breadcrumb-area -->
    <?php else:
        catch_fullscreen_breadcrumb();
    endif;
endif;
