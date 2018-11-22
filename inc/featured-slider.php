<?php
/**
 * The template for displaying the Slider
 *
 * @package Catch_Fullscreen
 */

if ( ! function_exists( 'catch_fullscreen_featured_slider' ) ) :
	/**
	 * Add slider.
	 *
	 * @uses action hook catch_fullscreen_before_content.
	 *
	 * @since Catch Fullscreen 1.0
	 */
	function catch_fullscreen_featured_slider() {
		$enable_slider = get_theme_mod( 'catch_fullscreen_slider_option', 'disabled' );

		if ( catch_fullscreen_check_section( $enable_slider ) ) {

			$output = '
				<div id="feature-slider-section" class="section">
					<div class="wrapper">
						<div class="cycle-slideshow"
							data-cycle-log="false"
							data-cycle-pause-on-hover="true"
							data-cycle-swipe="true"
							data-cycle-auto-height=container
							data-cycle-loader=true
							data-cycle-slides="> article"
							>

							<!-- prev/next links -->
							<button class="cycle-prev" aria-label="Previous"><span class="screen-reader-text">' . esc_html__( 'Previous Slide', 'catch-fullscreen' ) . '</span>' . catch_fullscreen_get_svg( array( 'icon' => 'angle-down' ) ) . '</button>
							<button class="cycle-next" aria-label="Next"><span class="screen-reader-text">' . esc_html__( 'Next Slide', 'catch-fullscreen' ) . '</span>' . catch_fullscreen_get_svg( array( 'icon' => 'angle-down' ) ) . '</button>


							<!-- empty element for pager links -->
							<div class="cycle-pager"></div>';

			$output .= catch_fullscreen_post_page_category_slider();

			$output .= '
						</div><!-- .cycle-slideshow -->
					</div><!-- .wrapper -->
				</div><!-- #feature-slider -->';

			echo $output;
		} // End if().
	}
	endif;
add_action( 'catch_fullscreen_slider', 'catch_fullscreen_featured_slider', 10 );


if ( ! function_exists( 'catch_fullscreen_post_page_category_slider' ) ) :
	/**
	 * This function to display featured posts/page/category slider
	 *
	 * @param $options: catch_fullscreen_theme_options from customizer
	 *
	 * @since Catch Fullscreen 1.0
	 */
	function catch_fullscreen_post_page_category_slider() {
		$quantity     = get_theme_mod( 'catch_fullscreen_slider_number', 4 );
		$no_of_post   = 0; // for number of posts
		$post_list    = array();// list of valid post/page ids
		$output       = '';

		$args = array(
			'post_type'           => 'any',
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1, // ignore sticky posts
		);

		for ( $i = 1; $i <= $quantity; $i++ ) {
			$post_id = get_theme_mod( 'catch_fullscreen_slider_page_' . $i );

			if ( $post_id && '' !== $post_id ) {
				$post_list = array_merge( $post_list, array( $post_id ) );

				$no_of_post++;
			}
		}

		$args['post__in'] = $post_list;

		if ( ! $no_of_post ) {
			return;
		}

		$args['posts_per_page'] = $no_of_post;

		$loop = new WP_Query( $args );

		while ( $loop->have_posts() ) :
			$loop->the_post();

			$title_attribute = the_title_attribute( 'echo=0' );

			$content_alignment = get_theme_mod( 'catch_fullscreen_content_align_' . ( $loop->current_post + 1 ), 'content-align-center' );

			if ( 0 === $loop->current_post ) {
				$classes = 'post post-' . get_the_ID() . ' hentry slides displayblock ' . $content_alignment;
			} else {
				$classes = 'post post-' . get_the_ID() . ' hentry slides displaynone ' . $content_alignment;
			}

			// Default value if there is no featurd image or first image.
			$image_url = trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/images/no-thumb-1920x1080.jpg';

			if ( has_post_thumbnail() ) {
				$image_url = get_the_post_thumbnail_url( get_the_ID(), 'catch-fullscreen-slider' );
			} else {
				// Get the first image in page, returns false if there is no image.
				$first_image_url = catch_fullscreen_get_first_image( get_the_ID(), 'catch-fullscreen-slider', '', true );

				// Set value of image as first image if there is an image present in the page.
				if ( $first_image_url ) {
					$image_url = $first_image_url;
				}
			}

			$style ='';

			if ( $image_url ) {
				$style = ' style="background-image: url(' . esc_url( $image_url ) . ')"';
			}

			$output .= '
			<article class="content-background ' . esc_attr( $classes ) . '"' . $style . '><div class="post-wrapper">';
				$output .= '
				<div class="slider-image-wrapper">
					<a href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">
							<img src="' . esc_url( $image_url ) . '" class="wp-post-image" alt="' . $title_attribute . '">
						</a>
				</div><!-- .slider-image-wrapper -->

				<div class="slider-content-wrapper entry-content-wrapper">
					<div class="entry-container">
						<header class="entry-header">
							<h2 class="entry-title">
								<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">' . the_title( '<span>','</span>', false ) . '</a>
							</h2>
						</header>
						<div class="entry-summary">
						' . get_the_excerpt() . '
						</div>
					</div><!-- .entry-container -->
				</div><!-- .slider-content-wrapper -->
			</div></article><!-- .slides -->';
		endwhile;

		wp_reset_postdata();

		return $output;
	}
endif; // catch_fullscreen_post_page_category_slider.
