<?php
/**
 * The template used for displaying projects on index view
 *
 * @package Catch_Fullscreen
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="hentry">
	<div class="hentry-inner">
		<div class="portfolio-thumbnail post-thumbnail">
			<a class="post-thumbnail" href="<?php the_permalink(); ?>">
				<?php
				// Output the featured image.
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'catch-fullscreen-featured' );
				} else {
					echo '<img src="' . trailingslashit( esc_url( get_template_directory_uri() ) ) . 'assets/images/no-thumb.jpg"/>';
				}
				?>
			</a>
		</div><!-- .portfolio-thumbnail -->

		<div class="entry-container">
			<div class="inner-wrap">
				<a href="<?php the_permalink(); ?>" class="view-detail"><?php echo catch_fullscreen_get_svg( array( 'icon' => 'search' ) ) ?></a>

				<header class="entry-header portfolio-entry-header">
					<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
				</header>
			</div><!-- .inner-wrap -->
		</div><!-- .entry-container -->
	</div><!-- .hentry-inner -->
</article>
