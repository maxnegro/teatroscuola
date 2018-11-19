<?php
/**
 * The template used for displaying testimonial on front page
 *
 * @package Catch_Fullscreen
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="hentry-inner">
		<div class="entry-content">
			<?php the_content(); ?>
		</div>

	<?php if ( has_post_thumbnail() ) : ?>
			<div class="testimonial-thumbnail post-thumbnail">
				<?php the_post_thumbnail( 'catch-fullscreen-testimonial' ); ?>
			</div>
		<?php endif; ?>

	<?php $position = get_post_meta( get_the_id(), 'ect_testimonial_position', true ); ?>

		<header class="entry-header">
			<?php
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>

			<?php if ( $position ) : ?>
				<div class="entry-position"><span><?php echo esc_html( $position ); ?></span></div>
			<?php endif; ?>
		</header>
</div><!-- .hentry-inner -->
</article>
