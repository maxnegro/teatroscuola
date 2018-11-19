<?php
/**
 * The template part for displaying content
 *
 * @package Catch_Fullscreen
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-wrapper">
		<?php
		$content_layout = get_theme_mod( 'catch_fullscreen_content_layout', 'excerpt-image-top' );

		if ( 'excerpt-image-top' === $content_layout ) {
			catch_fullscreen_post_thumbnail();
		}
		?>

		<div class="entry-container">
			<header class="entry-header">
				<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
					<span class="sticky-post"><?php esc_html_e( 'Featured', 'catch-fullscreen' ); ?></span>
				<?php endif; ?>

				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

				<?php echo catch_fullscreen_entry_header(); ?>
			</header><!-- .entry-header -->

			<?php
			if ( 'excerpt-image-top' === $content_layout ) { ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			<?php
			} else {
			?>
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
			<?php
			}
			?>
		</div><!-- .entry-container -->
	</div><!-- .hentry-inner -->
</article><!-- #post-## -->
