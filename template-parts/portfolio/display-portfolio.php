<?php
/**
 * The template for displaying portfolio items
 *
 * @package Catch_Fullscreen
 */
?>

<?php
$enable = get_theme_mod( 'catch_fullscreen_portfolio_option', 'disabled' );

if ( ! catch_fullscreen_check_section( $enable ) ) {
	// Bail if portfolio section is disabled.
	return;
}

$headline    = get_option( 'jetpack_portfolio_title', esc_html__( 'Projects', 'catch-fullscreen' ) );
$subheadline = get_option( 'jetpack_portfolio_content' );
$image       = get_theme_mod( 'catch_fullscreen_portfolio_main_image', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/images/portfolio-bg-1920x1080.jpg"' );

?>

<?php if ( $image ) : ?>
<div id="portfolio-content-section" class="section layout-three" style="background-image: url( <?php echo esc_url( $image ); ?> )">
<?php else : ?>
	<div id="portfolio-content-section" class="section" >
<?php endif; ?>
	<div class="wrapper">
		<?php if ( $headline || $subheadline ) : ?>
			<div class="section-heading-wrapper portfolio-section-headline">
			<?php if ( $headline ) : ?>
				<div class="section-title-wrapper">
					<h2 class="section-title"><?php echo wp_kses_post( $headline ); ?></h2>
				</div><!-- .section-title-wrapper -->
			<?php endif; ?>

			<?php if ( $subheadline ) : ?>
				<div class="taxonomy-description-wrapper">
					<p class="section-subtitle"><?php echo wp_kses_post( $subheadline ); ?></p>
				</div><!-- .taxonomy-description-wrapper -->
			<?php endif; ?>
			</div><!-- .section-heading-wrapper -->
		<?php endif; ?>

		<div class="section-content-wrapper portfolio-content-wrapper layout-three">
			<?php get_template_part( 'template-parts/portfolio/post-types', 'portfolio' ); ?>
		</div><!-- .portfolio-wrapper -->
	</div><!-- .wrapper -->
</div><!-- #portfolio-content-section -->
