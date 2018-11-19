<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package Catch_Fullscreen
 */
?>

<section class="no-results not-found<?php echo is_front_page() ? ' section' : ''; ?>  ">
	<?php
	$header_image = catch_fullscreen_featured_overall_image();

	if ( 'disable' === $header_image ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'catch-fullscreen' ); ?></h1>
		</header><!-- .page-header -->
	<?php endif; ?>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'catch-fullscreen' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'catch-fullscreen' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'catch-fullscreen' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
