<?php
/**
 * Displays Header Right Navigation
 *
 * @package Catch_Fullscreen
 */
?>

<div class="site-primary-wrapper">
	<button id="menu-toggle-primary" class="menu-primary menu-toggle" aria-controls="primary-menu" aria-expanded="false">
		<?php
		echo catch_fullscreen_get_svg( array( 'icon' => 'bars' ) );
		echo catch_fullscreen_get_svg( array( 'icon' => 'close' ) );
		echo '<span class="menu-label-prefix">'. esc_attr__( 'Secondary ', 'catch-fullscreen' ) . '</span><span class="menu-label">'. esc_attr__( 'Menu', 'catch-fullscreen' ) . '</span>';
		?>
	</button>

	<div id="site-primary-menu" class="site-primary-menu">
		<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
			<nav id="site-primary-navigation" class="primary-navigation site-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'catch-fullscreen' ); ?>">
				<?php wp_nav_menu( array(
					'theme_location'  => 'menu-1',
					'container_class' => 'primary-menu-container',
					'menu_class'      => 'primary-menu',
				) ); ?>
			</nav><!-- #site-primary-navigation -->
		<?php else : ?>
			<nav id="site-primary-navigation" class="main-navigation site-navigation default-page-menu" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'catch-fullscreen' ); ?>">
				<?php wp_page_menu(
					array(
						'menu_class' => 'primary-menu-container',
						'before'     => '<ul id="primary-page-menu" class="primary-menu">',
						'after'      => '</ul>',
					)
				); ?>
			</nav><!-- #site-primary-navigation.default-page-menu -->
		<?php endif; ?>

		<?php if ( has_nav_menu( 'social-primary' ) ) : ?>
			<nav id="social-primary-navigation-top" class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links on Primary Menu', 'catch-fullscreen' ); ?>">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'social-primary',
						'menu_class'     => 'social-links-menu',
						'depth'          => 1,
						'link_before'    => '<span class="screen-reader-text">',
						'link_after'     => '</span>' . catch_fullscreen_get_svg( array( 'icon' => 'chain' ) ),
					) );
				?>
			</nav><!-- #social-primary-navigation -->
		<?php endif; ?>

		<div class="primary-search-wrapper">
			<button id="search-toggle-right" class="menu-search-toggle menu-toggle search-toggle"><?php echo catch_fullscreen_get_svg( array(
				'icon' => 'search',
			), true ); echo catch_fullscreen_get_svg( array(
				'icon' => 'close',
			), true ); ?><span class="screen-reader-text"><?php esc_html_e( 'Search', 'catch-fullscreen' ); ?></span></button>

			<div id="search-social-container-right" class="search-social-container with-social displaynone">
	        	<div id="search-container">
	            	<?php get_search_form(); ?>
	            </div><!-- #search-container -->
			</div><!-- #search-social-container -->
		</div><!-- .primary-search-wrapper -->
	</div><!-- #site-primary-menu -->
	<?php if ( is_front_page() ) : ?>
		<div id="updownnav">
			<button aria-label="Previous" class="arrow-up">
				<span class="screen-reader-text"><?php esc_html_e( 'Previous Section', 'catch-fullscreen' ); ?></span><?php echo catch_fullscreen_get_svg( array( 'icon' => 'angle-down' ) ); ?>
				</button>
			<button aria-label="Previous" class="arrow-down">
				<span class="screen-reader-text"><?php esc_html_e( 'Next Section', 'catch-fullscreen' ); ?></span><?php echo catch_fullscreen_get_svg( array( 'icon' => 'angle-down' ) ); ?>
				</button>
		</div>
	<?php endif; ?>
</div>
