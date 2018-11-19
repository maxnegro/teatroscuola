<?php
/**
 * The template part for displaying content
 *
 * @package Catch_Fullscreen
 */
?>

<?php
/**
 * Get classes for posts and add it via post_class() function
 * We are doing it this way because it is only required for this section of homepage
 */
$content_align = get_theme_mod( 'catch_fullscreen_home_content_align', 'content-align-right' );
$classes[]     = esc_attr( $content_align );
$content_bg    = get_theme_mod( 'catch_fullscreen_home_content_bg', 'disable' );

if ( 'enable' === $content_bg ) {
	$classes[] = 'content-background';
}

$classes[] = 'section';

if ( has_post_thumbnail() ) :
$thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'catch-fullscreen-slider' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?> style="background-image: url( <?php echo esc_url( $thumbnail ); ?> )">
<?php else : ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?> style="background-image: url( <?php echo trailingslashit( esc_url( get_template_directory_uri() ) ); ?>assets/images/no-thumb-1920x1080.jpg">
<?php endif; ?>
	<div class="post-wrapper">

		<div class="post-thumbnail">
			<?php the_post_thumbnail( 'catch-fullscreen-slider' ); ?>
		</div>

		<div class="entry-content-wrapper">
			<div class="entry-container">
				<header class="entry-header">
					<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
						<span class="sticky-post"><?php esc_html_e( 'Featured', 'catch-fullscreen' ); ?></span>
					<?php endif; ?>


					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

					<?php echo catch_fullscreen_entry_header(); ?>
				</header><!-- .entry-header -->

				<?php if ( ! get_theme_mod( 'catch_fullscreen_homepage_disable_content', 1 ) ) : ?>
					<?php if ( ! has_excerpt() ) : ?>
					    <div class="entry-content">
							<?php
								/* translators: %s: Name of current post */
								the_content( sprintf(
									__( 'Continue Reading<span class="screen-reader-text"> "%s"</span>', 'catch-fullscreen' ),
									get_the_title()
								) );

								wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'catch-fullscreen' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
									'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'catch-fullscreen' ) . ' </span>%',
									'separator'   => '<span class="screen-reader-text">, </span>',
								) );
							?>
						</div><!-- .entry-content -->
					<?php else : ?>
					    <div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->
					<?php endif; ?>
				<?php endif; ?>
			</div><!-- .entry-container -->
		</div> <!-- .entry-content-wrapper -->
	</div><!-- .hentry-inner -->
</article><!-- #post-## -->
