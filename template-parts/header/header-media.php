<?php
/**
 * Display Header Media
 *
 * @package Catch_Fullscreen
 */

	$header_image = catch_fullscreen_featured_overall_image();

	if ( 'disable' === $header_image ) {
		// Bail if all header media are disabled.
		return;
	}

	$style = '';

	if ( is_front_page() ) {
		$style = 'style="background-image: url(\'' . esc_url( $header_image ) . '\');"';
	}

	$content_alignment = get_theme_mod( 'catch_fullscreen_header_media_content_alignment', 'content-align-center' );
?>
<div class="custom-header header-media section <?php echo esc_attr( $content_alignment ); ?> " <?php echo $style; // WPCS: XSS OK. ?> >
	<div class="wrapper">
		<?php if ( ( is_header_video_active() && has_header_video() ) || 'disable' !== $header_image ) : ?>
		<div class="custom-header-media">
			<?php
			if ( is_header_video_active() && has_header_video() ) {
				the_custom_header_markup();
			} elseif ( $header_image ) {
				echo '<img src="' . esc_url( $header_image ) . '"/>';
			}
			?>
		</div>
		<?php endif; ?>

		<?php catch_fullscreen_header_media_text(); ?>
	</div><!-- .wrapper -->
</div><!-- .custom-header -->
