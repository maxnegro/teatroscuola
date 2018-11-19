<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Catch_Fullscreen
 */

/**
 * Converts a HEX value to RGB.
 *
 * @since Catch Fullscreen Pro 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function catch_fullscreen_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Catch Fullscreen 1.0
 *
 * @see catch_fullscreen_header_style()
 */
function catch_fullscreen_custom_header_and_background() {
	/**
	 * Filter the arguments used when adding 'custom-background' support in Persona.
	 *
	 * @since Catch Fullscreen 1.0
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'catch_fullscreen_custom_background_args', array(
		'default-color' => '#3e3e3e',
	) ) );

	/**
	 * Filter the arguments used when adding 'custom-header' support in Persona.
	 *
	 * @since Catch Fullscreen 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default-text-color Default color of the header text.
	 *     @type int      $width            Width in pixels of the custom header image. Default 1200.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'catch_fullscreen_custom_header_args', array(
		'default-image'      	 => get_parent_theme_file_uri( '/assets/images/header-image.jpg' ),
		'default-text-color'     => '#ffffff',
		'width'                  => 1920,
		'height'                 => 822,
		'flex-height'            => true,
		'flex-height'            => true,
		'wp-head-callback'       => 'catch_fullscreen_header_style',
		'video'                  => true,
	) ) );

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/assets/images/header-image.jpg',
			'thumbnail_url' => '%s/assets/images/header-image-275x155.jpg',
			'description'   => esc_html__( 'Default Header Image', 'catch-fullscreen' ),
		),
	) );
}
add_action( 'after_setup_theme', 'catch_fullscreen_custom_header_and_background' );

if ( ! function_exists( 'catch_fullscreen_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see catch_fullscreen_custom_header_setup().
	 */
	function catch_fullscreen_header_style() {
		$header_image = catch_fullscreen_featured_overall_image();

	    if ( !is_front_page() && 'disable' !== $header_image ) : ?>
	        <style type="text/css" rel="header-image">
	            .custom-header:before {
	                background-image: url( <?php echo esc_url( $header_image ); ?>);
					background-position: center center;
					background-repeat: no-repeat;
					background-size: cover;
	            }
	        </style>
	    <?php
	    endif;

	    $header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color || 'blank'=== $header_text_color ) {
			// Has the text been hidden?
			if ( ! display_header_text() ) :
			?>
				<style type="text/css">
					.site-title,
					.site-description {
						position: absolute;
						clip: rect(1px, 1px, 1px, 1px);
					}
				</style>
			<?php
			endif;

			return;
		}

		$header_text_fiftyfive_color = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.55)', catch_fullscreen_hex2rgb( $header_text_color ) );

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
			.site-title a,
			.custom-header .entry-title,
			.custom-header,
			.custom-header-media .wp-custom-header-video-button,
			.custom-header-media .wp-custom-header-video-button.wp-custom-header-video-pause,
			.custom-header-media .wp-custom-header-video-button:hover,
			.custom-header-media .wp-custom-header-video-button:focus {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}

			.site-description  {
				color: <?php echo esc_attr( $header_text_fiftyfive_color ); ?>;
			}
		}
		</style>
		<?php
	}
endif;

if ( ! function_exists( 'catch_fullscreen_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own catch_fullscreen_featured_image(), and that function will be used instead.
	 *
	 * @since My Music Band Pro 1.0
	 */
	function catch_fullscreen_featured_image() {
		if ( is_header_video_active() && has_header_video() ) {
			return true;
		}
		$thumbnail = 'catch-fullscreen-slider';

		if ( is_post_type_archive( 'jetpack-testimonial' ) ) {
			$jetpack_options = get_theme_mod( 'jetpack_testimonials' );

			if ( isset( $jetpack_options['featured-image'] ) && '' !== $jetpack_options['featured-image'] ) {
				$image = wp_get_attachment_image_src( (int) $jetpack_options['featured-image'], $thumbnail );
				return $image['0'];
			} else {
				return false;
			}
		} elseif ( is_post_type_archive( 'jetpack-portfolio' ) || is_post_type_archive( 'featured-content' ) || is_post_type_archive( 'ect-service' ) ) {
			$option = '';

			if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
				$option = 'jetpack_portfolio_featured_image';
			} elseif ( is_post_type_archive( 'featured-content' ) ) {
				$option = 'featured_content_featured_image';
			} elseif ( is_post_type_archive( 'ect-service' ) ) {
				$option = 'ect_service_featured_image';
			}

			$featured_image = get_option( $option );

			if ( '' !== $featured_image ) {
				$image = wp_get_attachment_image_src( (int) $featured_image, $thumbnail );
				return $image[0];
			} else {
				return get_header_image();
			}
		} elseif ( is_header_video_active() && has_header_video() ) {
			return true;
		} else {
			return get_header_image();
		}
	} // catch_fullscreen_featured_image
endif;

if ( ! function_exists( 'catch_fullscreen_featured_page_post_image' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 *
	 * To override this in a child theme
	 * simply create your own catch_fullscreen_featured_imaage_pagepost(), and that function will be used instead.
	 *
	 * @since My Music Band Pro 1.0
	 */
	function catch_fullscreen_featured_page_post_image() {
		$thumbnail = 'catch-fullscreen-slider';

		if ( is_home() && $blog_id = get_option('page_for_posts') ) {
			if ( has_post_thumbnail( $blog_id  ) ) {
		    	return get_the_post_thumbnail_url( $blog_id, $thumbnail );
			} else {
				return catch_fullscreen_featured_image();
			}
		} elseif ( ! has_post_thumbnail() ) {
			return catch_fullscreen_featured_image();
		} elseif ( is_home() && is_front_page() ) {
			return catch_fullscreen_featured_image();
		}

		$shop_header = get_theme_mod( 'catch_fullscreen_shop_page_header_image' );

		return get_the_post_thumbnail_url( get_the_id(), $thumbnail );
	} // catch_fullscreen_featured_page_post_image
endif;

if ( ! function_exists( 'catch_fullscreen_featured_overall_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own catch_fullscreen_featured_pagepost_image(), and that function will be used instead.
	 *
	 * @since My Music Band Pro 1.0
	 */
	function catch_fullscreen_featured_overall_image() {
		global $post;
		$enable = get_theme_mod( 'catch_fullscreen_header_media_option', 'entire-site-page-post' );

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_singular() ) {
			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $post->ID, 'catch-fullscreen-header-image', true );

			if ( 'disable' === $individual_featured_image || ( 'default' === $individual_featured_image && 'disable' === $enable ) ) {
				return 'disable' ;
			} elseif ( 'enable' == $individual_featured_image && 'disable' === $enable ) {
				return catch_fullscreen_featured_page_post_image();
			}
		}

		// Check Homepage
		if ( 'homepage' === $enable ) {
			if ( is_front_page() ) {
				return catch_fullscreen_featured_image();
			}
		} elseif ( 'exclude-home' === $enable ) {
			// Check Excluding Homepage
			if ( ! is_front_page() ) {
				return catch_fullscreen_featured_image();
			}
		} elseif ( 'exclude-home-page-post' === $enable ) {
			if ( is_front_page() ) {
				return 'disable';
			} elseif ( is_singular() ) {
				return catch_fullscreen_featured_page_post_image();
			} else {
				return catch_fullscreen_featured_image();
			}
		} elseif ( 'entire-site' === $enable ) {
			// Check Entire Site
			return catch_fullscreen_featured_image();
		} elseif ( 'entire-site-page-post' === $enable ) {
			// Check Entire Site (Post/Page)
			if ( is_singular() || ( is_home() && ! is_front_page() ) ) {
				return catch_fullscreen_featured_page_post_image();
			} else {
				return catch_fullscreen_featured_image();
			}
		} elseif ( 'pages-posts' === $enable ) {
			// Check Page/Post
			if ( is_singular() ) {
				return catch_fullscreen_featured_page_post_image();
			}
		}

		return 'disable';
	} // catch_fullscreen_featured_overall_image
endif;

if ( ! function_exists( 'catch_fullscreen_header_media_text' ) ):
	/**
	 * Display Header Media Text
	 *
	 * @since My Music Band Pro 1.0
	 */
	function catch_fullscreen_header_media_text() {

		if ( ! catch_fullscreen_has_header_media_text() ) {
			// Bail early if header media text is disabled on front page
			return false;
		}

		?>
		<div class="custom-header-content entry-content-wrapper sections header-media-section">
			<div class="entry-container">
			<?php get_template_part( 'template-parts/header/breadcrumb' ); ?>
				<header class="entry-header">
					<h1 class="entry-title">
						<?php catch_fullscreen_header_title(); ?>
					</h1>
				</header>

				<div class="entry-summary">
					<?php catch_fullscreen_header_description(); ?>

					<?php if ( is_front_page() ) :
						$header_media_title    = get_theme_mod( 'catch_fullscreen_header_media_title', esc_html__( 'Dancing Under The Sky', 'catch-fullscreen' ) );
						$header_media_url      = get_theme_mod( 'catch_fullscreen_header_media_url');
						$header_media_url_text = get_theme_mod( 'catch_fullscreen_header_media_url_text' );
					?>

						<?php if ( $header_media_url_text ) : ?>
							<span class="more-button">
								<a class="more-link" href="<?php echo esc_url( $header_media_url ); ?>" target="<?php echo get_theme_mod( 'catch_fullscreen_header_url_target' ) ? '_blank' : '_self'; ?>"><?php echo esc_html( $header_media_url_text ); ?><span class="screen-reader-text"><?php echo wp_kses_post( $header_media_title ); ?></span></a>
							</span>
						<?php endif; ?>
					<?php endif; ?>
				</div> <!-- entry-summary -->
			</div> <!-- entry-container -->
		</div><!-- .custom-header-content -->
		<?php
	} // catch_fullscreen_header_media_text.
endif;

if ( ! function_exists( 'catch_fullscreen_has_header_media_text' ) ):
	/**
	 * Return Header Media Text fro front page
	 *
	 * @since My Music Bandl Trainer 0.1
	 */
	function catch_fullscreen_has_header_media_text() {
		$header_image = catch_fullscreen_featured_overall_image();

		if ( is_front_page() ) {
			$header_media_title    = get_theme_mod( 'catch_fullscreen_header_media_title', esc_html__( 'Dancing Under The Sky', 'catch-fullscreen' ) );
			$header_media_text     = get_theme_mod( 'catch_fullscreen_header_media_text' );
			$header_media_url      = get_theme_mod( 'catch_fullscreen_header_media_url' );
			$header_media_url_text = get_theme_mod( 'catch_fullscreen_header_media_url_text' );

			if ( ! $header_media_title && ! $header_media_text && ! $header_media_url && ! $header_media_url_text ) {
				// Bail early if header media text is disabled
				return false;
			}
		} elseif ( 'disable' === $header_image ) {
			return false;
		}

		return true;
	} // catch_fullscreen_has_header_media_text.
endif;

if ( ! function_exists( 'catch_fullscreen_header_title' ) ) :
	/**
	 * Display header media text
	 */
	function catch_fullscreen_header_title( $before = '', $after = '' ) {
		if ( is_front_page() ) {
			$header_media_title = get_theme_mod( 'catch_fullscreen_header_media_title', esc_html__( 'Dancing Under The Sky', 'catch-fullscreen' ) );

			if ( $header_media_title ) {
				echo $before . wp_kses_post( $header_media_title ) . $after;
			}
		} elseif ( is_singular() ) {
			if ( is_page() ) {
				if( ! get_theme_mod( 'catch_fullscreen_single_page_title' ) ) {
					the_title( $before, $after );
				}
			} else {
				the_title( $before, $after );
			}
		} elseif ( is_404() ) {
			echo $before . esc_html__( 'Nothing Found', 'catch-fullscreen' ) . $after;
		} elseif ( is_search() ) {
			/* translators: %s: search query. */
			echo $before . sprintf( esc_html__( 'Search Results for: %s', 'catch-fullscreen' ), '<span>' . get_search_query() . '</span>' ) . $after;
		} else {
			the_archive_title( $before, $after );
		}
	}
endif;

if ( ! function_exists( 'catch_fullscreen_header_description' ) ) :
	/**
	 * Display header media description
	 */
	function catch_fullscreen_header_description( $before = '', $after = '' ) {
		if ( is_front_page() ) {
			$header_media_text = get_theme_mod( 'catch_fullscreen_header_media_text' );

			if ( $header_media_text ) {
				echo $before . '<p>' . wp_kses_post( $header_media_text ) . '</p>' . $after;
			}
		} elseif ( is_singular() && ! is_page() ) {
			echo $before . '<div class="entry-header"><div class="entry-meta">';
				catch_fullscreen_posted_on();
			echo '</div><!-- .entry-meta --></div>' . $after;
		} elseif ( is_404() ) {
			echo $before . '<p>' . esc_html__( 'Oops! That page can&rsquo;t be found', 'catch-fullscreen' ) . '</p>' . $after;
		} else {
			the_archive_description( $before, $after );
		}
	}
endif;
