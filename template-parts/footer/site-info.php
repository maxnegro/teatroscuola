<?php
/**
 * The template used for displaying credits
 *
 * @package Catch_Fullscreen
 */
?>

<?php
$theme_data = wp_get_theme();

$footer_text = sprintf(
		_x( 'Copyright &copy; %1$s %2$s. All Rights Reserved. %3$s', '1: Year, 2: Site Title with home URL, 3: Privacy Policy Link', 'catch-fullscreen' ),
		esc_attr( date_i18n( __( 'Y', 'catch-fullscreen' ) ) ),
		'<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>',
		function_exists( 'get_the_privacy_policy_link' ) ? get_the_privacy_policy_link() : ''
	) . ' &#124; ' . esc_html( $theme_data->get( 'Name') ) . '&nbsp;' . esc_html__( 'by', 'catch-fullscreen' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_html( $theme_data->get( 'Author' ) ) .'</a>';
?>

<div id="site-generator">
	<div class="site-info one">
		<div class="wrapper">
			<div id="footer-left-content" class="copyright">
				<?php echo wp_kses_post( $footer_text ); ?>
			</div> <!-- .footer-left-content -->
		</div> <!-- .wrapper -->
	</div><!-- .site-info -->
</div> <!-- #site-generator -->

