<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Catch_Fullscreen
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php if ( is_active_sidebar( 'sidebar-notfound' ) ) :
				dynamic_sidebar( 'sidebar-notfound' );
			else : ?>
			<section class="error-404 not-found">
				<?php
				$header_image = catch_fullscreen_featured_overall_image();

				if ( 'disable' === $header_image ) : ?>
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'catch-fullscreen' ); ?></h1>
					</header><!-- .page-header -->
				<?php endif; ?>

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'catch-fullscreen' ); ?></p>

					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
			<?php endif; ?>
		</main><!-- .site-main -->

		<?php get_sidebar( 'content-bottom' ); ?>

	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
