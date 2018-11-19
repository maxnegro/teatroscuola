<?php
/**
 * The template for displaying featured content
 *
 * @package Catch_Fullscreen
 */
?>

<?php
$enable_content = get_theme_mod( 'catch_fullscreen_featured_content_option', 'disabled' );

if ( ! catch_fullscreen_check_section( $enable_content ) ) {
	// Bail if featured content is disabled.
	return;
}

$featured_posts = catch_fullscreen_get_featured_posts();

if ( empty( $featured_posts ) ) {
	return;
}

$title     = get_option( 'featured_content_title', esc_html__( 'Contents', 'catch-fullscreen' ) );
$sub_title = get_option( 'featured_content_content' );

$image = get_theme_mod( 'catch_fullscreen_featured_content_main_image' );
?>

<?php if ( $image ) : ?>
<div id="featured-content-section" class="featured-section section" style="background-image: url( <?php echo esc_url( $image ); ?> )">

<?php else : ?>
	<div id="featured-content-section" class="section">
<?php endif; ?>
	<div class="wrapper">
		<?php if ( '' !== $title || $sub_title ) : ?>
			<div class="section-heading-wrapper featured-section-headline">
				<?php if ( '' !== $title ) : ?>
					<div class="section-title-wrapper">
						<h2 class="section-title"><?php echo wp_kses_post( $title ); ?></h2>
					</div><!-- .page-title-wrapper -->
				<?php endif; ?>

				<?php if ( $sub_title ) : ?>
					<div class="taxonomy-description-wrapper">
						<p class="section-subtitle"><?php echo wp_kses_post( $sub_title ); ?></p>
					</div><!-- .taxonomy-description-wrapper -->
				<?php endif; ?>
			</div><!-- .section-heading-wrapper -->
		<?php endif; ?>

		<div class="section-content-wrapper featured-content-wrapper layout-three">

			<?php
			foreach ( $featured_posts as $post ) {
				setup_postdata( $post );

				// Include the featured content template.
				get_template_part( 'template-parts/featured-content/content', 'featured' );
			}

			wp_reset_postdata();
			?>
		</div><!-- .featured-content-wrapper -->
	</div><!-- .wrapper -->
</div><!-- #featured-content-section -->
