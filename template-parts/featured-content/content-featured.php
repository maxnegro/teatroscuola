<?php
/**
 * The template for displaying featured posts on the front page
 *
 * @package Catch_Fullscreen
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="hentry-inner">
		<?php if ( has_post_thumbnail() ) : ?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'catch-fullscreen-featured' ); ?> </a>
		<?php endif; ?>

		<div class="entry-container">
			<header class="entry-header">
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h2>' ); ?>
			</header>
			<div class="entry-summary"><?php the_excerpt(); ?></div><!-- .entry-summary -->
		</div><!-- .entry-container -->
	</div><!-- .hentry-inner -->
</article>
