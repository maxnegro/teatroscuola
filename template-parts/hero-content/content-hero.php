<?php
/**
 * The template used for displaying hero content
 *
 * @package Catch_Fullscreen
 */
?>

<?php
$enable_section = get_theme_mod( 'catch_fullscreen_hero_content_visibility', 'disabled' );

if ( ! catch_fullscreen_check_section( $enable_section ) ) {
	// Bail if hero content is not enabled
	return;
}

$args['page_id'] = absint( get_theme_mod( 'catch_fullscreen_hero_content' ) );

// Create a new WP_Query using the argument previously created
$hero_query = new WP_Query( $args );

if ( $hero_query->have_posts() ) :
	while ( $hero_query->have_posts() ) :
		$hero_query->the_post();

		$image = get_theme_mod( 'catch_fullscreen_hero_main_image' );

		$img_align = '';

		if ( has_post_thumbnail() ) {
			$img_align = 'content-right';
		}
		?>
		<?php if ( $image ) : ?>
		<div id="hero-section" class="section <?php echo $img_align; ?>" style="background-image: url( <?php echo esc_url( $image ); ?> )">
		<?php else : ?>
		<div id="hero-section" class="section <?php echo $img_align; ?>">
		<?php endif; ?>
			<div class="wrapper section-content-wrapper hero-content-wrapper">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="post-thumbnail">
							<a class="cover-link" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('catch-fullscreen-hero-content' ); ?></a>
						</div><!-- .post-thumbnail -->
						<div class="entry-container">
					<?php else : ?>
						<div class="entry-container full-width">
					<?php endif; ?>
						<header class="entry-header section-title-wrapper">
							<?php the_title( '<h2 class="entry-title section-title">', '</h2>' ); ?>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<?php
								the_content();

								wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'catch-fullscreen' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span class="page-number">',
									'link_after'  => '</span>',
									'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'catch-fullscreen' ) . ' </span>%',
									'separator'   => '<span class="screen-reader-text">, </span>',
								) );
							?>
						</div><!-- .entry-content -->

						<?php if ( get_edit_post_link() ) : ?>
							<footer class="entry-footer">
								<div class="entry-meta">
									<?php
										edit_post_link(
											sprintf(
												/* translators: %s: Name of current post */
												esc_html__( 'Edit %s', 'catch-fullscreen' ),
												the_title( '<span class="screen-reader-text">"', '"</span>', false )
											),
											'<span class="edit-link">',
											'</span>'
										);
									?>
								</div>
							</footer><!-- .entry-footer -->
						<?php endif; ?>
					</div><!-- .entry-container -->
				</article><!-- #post-## -->
			</div><!-- .wrapper -->
		</div><!-- .section -->
	<?php
	endwhile;

	wp_reset_postdata();
endif;
