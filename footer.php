<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Catch_Fullscreen
 */
?>
		<?php if ( ! ( is_front_page() && is_home() ) ) : ?>
			</div><!-- .wrapper -->
		</div><!-- .site-content -->
		<?php endif; ?>
		<?php catch_fullscreen_sections(); ?>

		<?php get_template_part( 'template-parts/partners/content', 'partners' ); ?>

		<?php get_template_part( 'template-parts/footer/footer', 'instagram' ); ?>

		<footer id="colophon" class="site-footer section fp-auto-height" role="contentinfo">

			<?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>

			<div class="footer-bottom">

				<?php get_template_part( 'template-parts/navigation/navigation', 'footer' ); ?>

				<?php get_template_part( 'template-parts/footer/site', 'info' ); ?>
			</div>

		</footer><!-- .site-footer -->

	<?php if ( is_front_page() ) : ?>
	</div><!-- #fullpage -->
	<?php endif; ?>
	<div class="site-overlay"></div>
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
