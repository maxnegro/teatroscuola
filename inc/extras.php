<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Catch_Fullscreen
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Catch Fullscreen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function catch_fullscreen_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Always add a front-page class to the front page.
	if ( is_front_page() && ! is_home() ) {
		$classes[] = 'page-template-front-page';
	}

	$classes[] = 'fluid-layout';

	$classes[] = 'navigation-classic';

	// Adds a class with respect to layout selected.
	$layout  = catch_fullscreen_get_theme_layout();
	$sidebar = catch_fullscreen_get_sidebar_id();

	if ( 'no-sidebar' === $layout ) {
		$classes[] = 'no-sidebar content-width-layout';
	} elseif ( 'right-sidebar' === $layout ) {
		if ( '' !== $sidebar ) {
			$classes[] = 'two-columns-layout content-left';
		}
	}

	$classes[] = get_theme_mod( 'catch_fullscreen_content_layout', 'excerpt-image-top' );

	$classes[] = 'primary-menu-left';

	$header_center = get_theme_mod( 'catch_fullscreen_center_header' );

	if ( $header_center ) {
		$classes[] = 'header-center-layout';
	}

	$header_media_title = get_theme_mod( 'catch_fullscreen_header_media_title', esc_html__( 'Dancing Under The Sky', 'catch-fullscreen' ) );
	$header_media_text  = get_theme_mod( 'catch_fullscreen_header_media_text' );

	if ( ! $header_media_title && ! $header_media_text ) {
		$classes[] = 'no-header-media-text';
	}

	if ( ! has_nav_menu( 'menu-1' ) ) {
		$classes[] = 'site-primary-wrapper-menu-disabled';
	}

	$disable_main_pager = get_theme_mod( 'catch_fullscreen_main_pager_mobile' );

	if ( $disable_main_pager ) {
		$classes[] = 'mobile-main-pager-enabled';
	}

	$classes[] = esc_attr( get_theme_mod( 'catch_fullscreen_desktop_navigation', 'desktop-nav-on-page-right' ) );
	$classes[] = esc_attr( get_theme_mod( 'catch_fullscreen_mobile_navigation', 'mobile-nav-on-header' ) );

	return $classes;
}
add_filter( 'body_class', 'catch_fullscreen_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function catch_fullscreen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'catch_fullscreen_pingback_header' );

/**
 * Adds custom background image overlay for each section
 */
function catch_fullscreen_sections_bg_image_overlay_css() {
	$css = '';

	// For Header Media.
	$overlay = get_theme_mod( 'catch_fullscreen_header_media_bg_image_opacity', '10' );

	$overlay_bg = $overlay / 100;

	if ( '10' !== $overlay ) {
		$css = '.custom-header.has-section-background-image:before { background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . '); } '; // Dividing by 100 as the option is shown as % for user
	}

	// For Featured Content.
	$overlay = get_theme_mod( 'catch_fullscreen_featured_content_bg_image_opacity', '10' );

	$overlay_bg = $overlay / 100;

	if ( '10' !== $overlay ) {
		$css .= '#featured-content-section.has-section-background-image:before { background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . '); } '; // Dividing by 100 as the option is shown as % for user
	}

	// For Service.
	$overlay = get_theme_mod( 'catch_fullscreen_service_bg_image_opacity', '10' );

	$overlay_bg = $overlay / 100;

	if ( '10' !== $overlay ) {
		$css .= '#service-content-section.has-section-background-image:before { background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . '); } '; // Dividing by 100 as the option is shown as % for user
	}

	// For Team.
	$overlay = get_theme_mod( 'catch_fullscreen_team_bg_image_opacity', '10' );

	$overlay_bg = $overlay / 100;

	if ( '10' !== $overlay ) {
		$css .= '#team-content-section.has-section-background-image:before { background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . '); } '; // Dividing by 100 as the option is shown as % for user
	}

	// For Testimonial.
	$overlay = get_theme_mod( 'catch_fullscreen_testimonials_bg_image_opacity', '10' );

	$overlay_bg = $overlay / 100;

	if ( '10' !== $overlay ) {
		$css .= '#testimonial-content-section.has-section-background-image:before { background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . '); } '; // Dividing by 100 as the option is shown as % for user
	}

	// For gallery.
	$overlay = get_theme_mod( 'catch_fullscreen_gallery_bg_image_opacity', '10' );

	$overlay_bg = $overlay / 100;

	if ( '10' !== $overlay ) {
		$css .= '.gallery-section.has-section-background-image:before { background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . '); } '; // Dividing by 100 as the option is shown as % for user
	}

	// For portfolio.
	$overlay = get_theme_mod( 'catch_fullscreen_portfolio_bg_image_opacity', '10' );

	$overlay_bg = $overlay / 100;

	if ( '10' !== $overlay ) {
		$css .= '#portfolio-content-section.has-section-background-image:before { background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . '); } '; // Dividing by 100 as the option is shown as % for user
	}

	// For Hero.
	$overlay = get_theme_mod( 'catch_fullscreen_hero_bg_image_opacity', '10' );

	$overlay_bg = $overlay / 100;

	if ( '10' !== $overlay ) {
		$css .= '#hero-section.has-section-background-image:before { background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . '); } '; // Dividing by 100 as the option is shown as % for user
	}

	// For Promotion.
	$overlay = get_theme_mod( 'catch_fullscreen_promotion_bg_image_opacity', '10' );

	$overlay_bg = $overlay / 100;

	if ( '10' !== $overlay ) {
		$css .= '#promotion-section.has-section-background-image:before { background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . '); } '; // Dividing by 100 as the option is shown as % for user
	}

	wp_add_inline_style( 'catch-fullscreen-style', $css );
}
add_action( 'wp_enqueue_scripts', 'catch_fullscreen_sections_bg_image_overlay_css', 11 );

/**
 * Remove first post from blog as it is already show via recent post template
 */
function catch_fullscreen_alter_home( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$cats = get_theme_mod( 'catch_fullscreen_front_page_category' );

		if ( is_array( $cats ) && ! in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}
	}
}
add_action( 'pre_get_posts', 'catch_fullscreen_alter_home' );

/**
 * Function to add Scroll Up icon
 */
function catch_fullscreen_scrollup() {
	$disable_scrollup = get_theme_mod( 'catch_fullscreen_disable_scrollup' );

	if ( $disable_scrollup ) {
		return;
	}

	echo '<a href="#masthead" id="scrollup" class="backtotop">' . catch_fullscreen_get_svg( array( 'icon' => 'angle-down' ) ) . '<span class="screen-reader-text">' . esc_html__( 'Scroll Up', 'catch-fullscreen' ) . '</span></a>' ;

}
add_action( 'wp_footer', 'catch_fullscreen_scrollup', 1 );

if ( ! function_exists( 'catch_fullscreen_content_nav' ) ) :
	/**
	 * Display navigation/pagination when applicable
	 *
	 * @since Catch Fullscreen 1.0
	 */
	function catch_fullscreen_content_nav() {
		global $wp_query;

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}

		$pagination_type = get_theme_mod( 'catch_fullscreen_pagination_type', 'default' );

		/**
		 * Check if navigation type is Jetpack Infinite Scroll and if it is enabled, else goto default pagination
		 * if it's active then disable pagination
		 */
		if ( ( 'infinite-scroll' === $pagination_type ) && class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
			return false;
		}

		if ( 'numeric' === $pagination_type && function_exists( 'the_posts_pagination' ) ) {
			the_posts_pagination( array(
				'prev_text'          => esc_html__( 'Previous page', 'catch-fullscreen' ),
				'next_text'          => esc_html__( 'Next page', 'catch-fullscreen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'catch-fullscreen' ) . ' </span>',
			) );
		} else {
			the_posts_navigation();
		}
	}
endif; // catch_fullscreen_content_nav

/**
 * Check if a section is enabled or not based on the $value parameter
 * @param  string $value Value of the section that is to be checked
 * @return boolean return true if section is enabled otherwise false
 */
function catch_fullscreen_check_section( $value ) {
	global $wp_query;

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Front page displays in Reading Settings
	$page_for_posts = get_option('page_for_posts');

	return ( 'entire-site' == $value  || ( ( is_front_page() || ( is_home() && intval( $page_for_posts ) !== intval( $page_id ) ) ) && 'homepage' == $value ) );
}

/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since Catch Fullscreen 1.0
 */

function catch_fullscreen_get_first_image( $postID, $size, $attr, $src = false ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field( 'post_content', $postID ) , $matches );

	if( isset( $matches[1][0] ) ) {
		//Get first image
		$first_img = $matches[1][0];

		if ( $src ) {
			//Return url of src is true
			return $first_img;
		}

		return '<img class="pngfix wp-post-image" src="' . $first_img . '">';
	}

	return false;
}

function catch_fullscreen_get_theme_layout() {
	$layout = '';

	if ( is_page_template( 'templates/no-sidebar.php' ) ) {
		$layout = 'no-sidebar';
	} elseif ( is_page_template( 'templates/right-sidebar.php' ) ) {
		$layout = 'right-sidebar';
	} else {
		$layout = get_theme_mod( 'catch_fullscreen_default_layout', 'right-sidebar' );

		if ( is_home() || is_archive() ) {
			$layout = get_theme_mod( 'catch_fullscreen_homepage_archive_layout', 'right-sidebar' );
		}
	}

	return $layout;
}

function catch_fullscreen_get_sidebar_id() {
	$sidebar = '';

	$layout = catch_fullscreen_get_theme_layout();

	$sidebaroptions = '';

	if ( 'no-sidebar' === $layout ) {
		return $sidebar;
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$sidebar = 'sidebar-1'; // Primary Sidebar.
	}

	return $sidebar;
}

/**
 * Display social Menu
 */
function catch_fullscreen_social_menu() {
	if ( has_nav_menu( 'social-menu' ) ) :
		?>
		<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'catch-fullscreen' ); ?>">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'social-menu',
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>',
					'depth'          => 1,
				) );
			?>
		</nav><!-- .social-navigation -->
	<?php endif;
}

if ( ! function_exists( 'catch_fullscreen_truncate_phrase' ) ) :
	/**
	 * Return a phrase shortened in length to a maximum number of characters.
	 *
	 * Result will be truncated at the last white space in the original string. In this function the word separator is a
	 * single space. Other white space characters (like newlines and tabs) are ignored.
	 *
	 * If the first `$max_characters` of the string does not contain a space character, an empty string will be returned.
	 *
	 * @since Catch Fullscreen 1.0
	 *
	 * @param string $text            A string to be shortened.
	 * @param integer $max_characters The maximum number of characters to return.
	 *
	 * @return string Truncated string
	 */
	function catch_fullscreen_truncate_phrase( $text, $max_characters ) {

		$text = trim( $text );

		if ( mb_strlen( $text ) > $max_characters ) {
			//* Truncate $text to $max_characters + 1
			$text = mb_substr( $text, 0, $max_characters + 1 );

			//* Truncate to the last space in the truncated string
			$text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
		}

		return $text;
	}
endif; //catch-catch_fullscreen_truncate_phrase

if ( ! function_exists( 'catch_fullscreen_get_the_content_limit' ) ) :
	/**
	 * Return content stripped down and limited content.
	 *
	 * Strips out tags and shortcodes, limits the output to `$max_char` characters, and appends an ellipsis and more link to the end.
	 *
	 * @since Catch Fullscreen 1.0
	 *
	 * @param integer $max_characters The maximum number of characters to return.
	 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)".
	 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
	 *
	 * @return string Limited content.
	 */
	function catch_fullscreen_get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

		$content = get_the_content( '', $stripteaser );

		// Strip tags and shortcodes so the content truncation count is done correctly.
		$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

		// Remove inline styles / .
		$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

		// Truncate $content to $max_char
		$content = catch_fullscreen_truncate_phrase( $content, $max_characters );

		// More link?
		if ( $more_link_text ) {
			$link   = apply_filters( 'get_the_content_more_link', sprintf( '<span class="more-button"><a href="%s" class="more-link">%s</a></span>', esc_url( get_permalink() ), $more_link_text ), $more_link_text );
			$output = sprintf( '<p>%s %s</p>', $content, $link );
		} else {
			$output = sprintf( '<p>%s</p>', $content );
			$link = '';
		}

		return apply_filters( 'catch_fullscreen_get_the_content_limit', $output, $content, $link, $max_characters );

	}
endif; //catch-catch_fullscreen_get_the_content_limit

if ( ! function_exists( 'catch_fullscreen_content_image' ) ) :
	/**
	 * Template for Featured Image in Archive Content
	 *
	 * To override this in a child theme
	 * simply fabulous-fluid your own catch_fullscreen_content_image(), and that function will be used instead.
	 *
	 * @since Catch Fullscreen 1.0
	 */
	function catch_fullscreen_content_image() {
		if ( has_post_thumbnail() && catch_fullscreen_jetpack_featured_image_display() && is_singular() ) {
			global $post, $wp_query;

			// Get Page ID outside Loop.
			$page_id = $wp_query->get_queried_object_id();

			if ( $post ) {
				if ( is_attachment() ) {
					$parent = $post->post_parent;

					$individual_featured_image = get_post_meta( $parent, 'catch-fullscreen-single-image', true );
				} else {
					$individual_featured_image = get_post_meta( $page_id, 'catch-fullscreen-single-image', true );
				}
			}

			if ( empty( $individual_featured_image ) ) {
				$individual_featured_image = 'default';
			}

			if ( 'disable' === $individual_featured_image ) {
				echo '<!-- Page/Post Single Image Disabled or No Image set in Post Thumbnail -->';
				return false;
			} else {
				$class = array();

				$image_size = 'post-thumbnail';

				if ( 'default' !== $individual_featured_image ) {
					$image_size = $individual_featured_image;
					$class[]    = 'from-metabox';
				}

				$class[] = $individual_featured_image;
				?>
				<div class="post-thumbnail <?php echo esc_attr( implode( ' ', $class ) ); ?>">
					<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( $image_size ); ?>
					</a>
				</div>
			<?php
			}
		} // End if().
	}
endif; // catch_fullscreen_content_image.

/**
 * Get Featured Posts
 */

function catch_fullscreen_get_posts( $section ) {
	$number = get_theme_mod( 'catch_fullscreen_featured_content_number', 3 );

	if ( 'services' === $section ) {
		$number   = get_theme_mod( 'catch_fullscreen_services_number', 4 );
		$cpt_slug = 'ect-service';
	} elseif ( 'testimonial' === $section ) {
		$number   = get_theme_mod( 'catch_fullscreen_testimonial_number', 4 );
		$cpt_slug = 'jetpack-testimonial';
	}

	$post_list  = array();
	$no_of_post = 0;

	$args = array(
		'ignore_sticky_posts' => 1, // ignore sticky posts.
	);

	// Get valid number of posts.
	$args['post_type'] = $cpt_slug;

	for ( $i = 1; $i <= $number; $i++ ) {
		$post_id = '';

		$post_id = get_theme_mod( 'catch_fullscreen_' . $section . '_cpt_' . $i );

		if ( $post_id && '' !== $post_id ) {
			$post_list = array_merge( $post_list, array( $post_id ) );

			$no_of_post++;
		}
	}

	$args['post__in'] = $post_list;
	$args['orderby']  = 'post__in';

	$args['posts_per_page'] = $no_of_post;

	if( ! $no_of_post ) {
		return;
	}

	$posts = get_posts( $args );

	return $posts;
}

if ( ! function_exists( 'catch_fullscreen_sections' ) ) :
	/**
	 * Display Sections on header and footer with respect to the section option set in catch_fullscreen_sections_sort
	 */
	function catch_fullscreen_sections( $selector = 'header' ) {
		get_template_part( 'template-parts/header/header', 'media' );
		get_template_part( 'template-parts/slider/content', 'slider' );
		get_template_part( 'template-parts/featured-content/display','featured' );
		get_template_part( 'template-parts/service/content','service' );
		get_template_part( 'template-parts/portfolio/display','portfolio');
		get_template_part( 'template-parts/hero-content/content','hero' );
		get_template_part( 'template-parts/testimonial/display', 'testimonial' );
	}
endif;
