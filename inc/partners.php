<?php
/**
 * The template for displaying Partners and Sponsors
 *
 * @package Catch_Fullscreen
 */

 if ( ! function_exists( 'catch_fullscreen_partners_display' ) ) :
 	/**
 	* Add Featured content.
 	*
 	* @uses action hook catch_fullscreen_before_content.
 	*
 	* @since Catch Fullscreen 1.0
 	*/
 	function catch_fullscreen_partners_display() {
 		$output = '';

 		// get data value from options
 		$enable_content = get_theme_mod( 'catch_fullscreen_partners_option', 'disabled' );

    if (! is_front_page()) {
      return '';
    }
    $output .= '
    <div id="partners-content-section" class="section">
      <div class="wrapper partners-wrapper">';
    $output .= catch_fullscreen_post_page_category_partners();
    $output .= '
        </div><!-- .wrapper -->
      </div><!-- #partners-content-section -->';

    $output .= '
    <script type="text/javascript">
    jQuery(document).ready(function($){
    $(\'.partners-wrapper\').slick({
      lazyLoad: \'ondemand\',
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
          }
        },
      ],
      });
    });
    </script>';

 		// if ( catch_fullscreen_check_section( $enable_content ) ) {
 		// 	$headline       = get_theme_mod( 'catch_fullscreen_service_headline', esc_html__( 'Services', 'catch-fullscreen' ) );
 		// 	$subheadline    = get_theme_mod( 'catch_fullscreen_service_subheadline' );
 		// 	$image = get_theme_mod( 'catch_fullscreen_service_main_image' );
 		// 	$classes[] = 'section';
 		// 	$classes[] = 'ect-service';
    //
 		// 	if ( $image ) {
 		// 		$output = '
 		// 		<div id="service-content-section" class="' . esc_attr( implode( ' ', $classes ) ) . '" style="background-image: url( ' . esc_url( $image ) . ' )">
 		// 			<div class="wrapper">';
 		// 	} else {
 		// 		$output = '
 		// 		<div id="service-content-section" class="' . esc_attr( implode( ' ', $classes ) ) . '">
 		// 			<div class="wrapper">';
 		// 	}
    //
 		// 	if ( ! empty( $headline ) || ! empty( $subheadline ) ) {
 		// 		$output .= '<div class="section-heading-wrapper service-section-headline">';
    //
 		// 		if ( ! empty( $headline ) ) {
 		// 			$output .= '<div class="section-title-wrapper"><h2 class="section-title">' . wp_kses_post( $headline ) . '</h2></div>';
 		// 		}
    //
 		// 		if ( ! empty( $subheadline ) ) {
 		// 			$output .= '<div class="taxonomy-description-wrapper"><p class="section-subtitle">' . wp_kses_post( $subheadline ) . '</p></div>';
 		// 		}
    //
 		// 		$output .= '
 		// 		</div><!-- .section-heading-wrapper -->';
 		// 	}
 		// 	$output .= '
 		// 		<div class="section-content-wrapper service-content-wrapper layout-four">';
    //
 		// 	$output .= catch_fullscreen_post_page_category_service();
    //
 		// 	$output .= '
 		// 				</div><!-- .partner-content-wrapper -->
 		// 		</div><!-- .wrapper -->
 		// 	</div><!-- #partners-content-section -->
    //   <script type="text/javascript">
    //   jQuery(document).ready(function($){
    //   $(\'.partners-wrapper\').slick({
    //     lazyLoad: \'ondemand\',
    //     slidesToShow: 4,
    //     slidesToScroll: 1,
    //     autoplay: true,
    //     autoplaySpeed: 2000,
    //     infinite: true,
    //     });
    //   });
    //   </script>';
    //
 		// }

 		echo $output;
 	}
 endif;
 add_action( 'catch_fullscreen_partners', 'catch_fullscreen_partners_display', 10 );


 if ( ! function_exists( 'catch_fullscreen_post_page_category_partners' ) ) :
 	/**
 	 * This function to display featured posts content
 	 *
 	 * @param $options: catch_fullscreen_theme_options from customizer
 	 *
 	 * @since Catch Fullscreen 1.0
 	 */
 	function catch_fullscreen_post_page_category_partners() {
 		global $post;

 		$quantity   = get_theme_mod( 'catch_fullscreen_service_number', 80 );
 		$post_list  = array();// list of valid post/page ids
 		$output     = '';

 		$args = array(
 			'orderby'             => 'menu_order',
      'order'               => 'ASC',
 			// 'ignore_sticky_posts' => 1 // ignore sticky posts
 		);

 		//Get valid number of posts
 		$args['post_type'] = 'cr3ativsponsor';

 		for ( $i = 1; $i <= $quantity; $i++ ) {
 			$post_id = get_theme_mod( 'catch_fullscreen_partners_cpt_' . $i );

 			if ( $post_id && '' !== $post_id ) {
 				// Polylang Support.
 				if ( class_exists( 'Polylang' ) ) {
 					$post_id = pll_get_post( $post_id, pll_current_language() );
 				}

 				$post_list = array_merge( $post_list, array( $post_id ) );

 			}
 		}

 		// $args['post__in'] = $post_list;

 		$args['posts_per_page'] = $quantity;

 		$loop     = new WP_Query( $args );

 		while ( $loop->have_posts() ) {
 			$loop->the_post();

 			$title_attribute = the_title_attribute( 'echo=0' );

 			$i = absint( $loop->current_post + 1 );

 			$class = 'class="' . join( ' ', get_post_class( 'cr3ativsponsor', $post->ID ) ) . '"';

 			$output .= '
 				<div id="partners-post-' . esc_attr( $i ) . '" ' . $class . '><div class="hentry-inner">'; // WPCS: XSS OK.


 				// Default value if there is no first image
 				$image = '<img class="wp-post-image" src="' . trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/images/no-thumb.jpg" >';

 				if ( $media_id = get_post_meta( $post->ID, 'ect-alt-featured-image', true ) ) {
 					// Get alternate thumbnail from CPT meta.
 					$image = wp_get_attachment_image( $media_id, 'catch-fullscreen-featured', false,  array( 'title' => $title_attribute, 'alt' => $title_attribute ) );
 				} elseif ( has_post_thumbnail() ) {
 					$image = get_the_post_thumbnail( $post->ID, 'catch-fullscreen-featured', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );
 				} else {
 					// Get the first image in page, returns false if there is no image.
 					$first_image = catch_fullscreen_get_first_image( $post->ID, 'catch-fullscreen-featured', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );

 					// Set value of image as first image if there is an image present in the page.
 					if ( $first_image ) {
 						$image = $first_image;
 					}
 				}

        $image = str_replace('src=', 'data-lazy=', $image);
        $splink = '#';
        if ($vl = get_post_custom_values('cr3ativ_sponsorurl'))  {
          $splink = $vl[0];
        }

 				$output .= '
 					<a class="post-thumbnail" href="' . esc_url( $splink ) . '" title="' . $title_attribute . '" rel="nofollow" target="_blank">
 						'. $image . '
 					</a>';

 				$output .= '	<div class="entry-container">';
        $output .= '
 						<div class="entry-summary" style="font-size: small;"><p style="text-align: center;">' . get_the_excerpt() . '</p></div><!-- .entry-summary -->';


 				$output .= the_title( '<header class="entry-header"><h2 class="entry-title"><a href="' . esc_url( $splink ) . '" rel="nofollow" target="_blank">', '</a></h2></header><!-- .entry-header -->', false );


 				$output .= '
 					</div><!-- .entry-container -->
 				</div></div><!-- .partners-post-' . $i . ' -->';
 			} //endwhile

 		wp_reset_postdata();

 		return $output;
 	}
 endif; // catch_fullscreen_post_page_category_service
