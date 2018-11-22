<?php
/**
 * Catch Full functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Catch_Fullscreen
 */

/**
 * Catch Full only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require trailingslashit( get_template_directory() ) . 'inc/back-compat.php';
}

if ( ! function_exists( 'catch_fullscreen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own catch_fullscreen_setup() function to override in a child theme.
 *
 * @since Catch Fullscreen 1.0
 */
function catch_fullscreen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/catchBase2
	 * If you're building a theme based on Catch Full, use a find and replace
	 * to change 'catch-fullscreen' to the name of your theme in all the template files
	 */
	load_theme_textdomain('catch-fullscreen', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for custom logo.
	 *
	 *  @since Catch Fullscreen 1.0
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 100,
		'flex-height' => true,
		'flex-width' => true,
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// Used in excerpt image Top 16:9 Ratio
	set_post_thumbnail_size( 990, 556, true );

	// Used ins Featured Slider, Promotion Headline, 16:9 Ratio
	add_image_size( 'catch-fullscreen-slider', 1920, 1080, true );

	// Used in Our Team 1:1 ratio
	add_image_size( 'catch-fullscreen-team', 270, 270, true );

	// Used in Featured Content, Services, Portfolio 3:2 ratio
	add_image_size( 'catch-fullscreen-featured', 666, 444, true );

	// Used in Archive image left/right, 1:1 ratio
	add_image_size( 'catch-fullscreen-square', 480, 480, true );

	// Used in testimonial, 1:1 ratio
	add_image_size( 'catch-fullscreen-testimonial', 100, 100, true );

	// Used in Hero Content, 4:3 ratio
	add_image_size( 'catch-fullscreen-hero-content', 755, 566, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'menu-1'         => esc_html__( 'Primary Menu', 'catch-fullscreen' ),
		'social-primary' => esc_html__( 'Social on Primary Menu', 'catch-fullscreen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'assets/css/editor-style.css', catch_fullscreen_fonts_url() ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Support Alternate image for services when using Essential Content Types Pro.
	if ( class_exists( 'Essential_Content_Types_Pro' ) ) {
		add_theme_support( 'ect-alt-featured-image-ect-service' );
	}

	// Add support for page excerpt, used for featured slider
	add_post_type_support( 'page', 'excerpt' );
}
endif; // catch_fullscreen_setup
add_action( 'after_setup_theme', 'catch_fullscreen_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Catch Fullscreen 1.0
 */
function catch_fullscreen_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'catch_fullscreen_content_width', 990 );
}
add_action( 'after_setup_theme', 'catch_fullscreen_content_width', 0 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Catch Fullscreen 1.0
 */
function catch_fullscreen_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'catch-fullscreen' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'catch-fullscreen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'catch-fullscreen' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'catch-fullscreen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'catch-fullscreen' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'catch-fullscreen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'catch-fullscreen' ),
		'id'            => 'sidebar-4',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'catch-fullscreen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	//Instagram Widget
	if ( class_exists( 'Catch_Instagram_Feed_Gallery_Widget' ) ||  class_exists( 'Catch_Instagram_Feed_Gallery_Widget_Pro' ) ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Instagram', 'catch-fullscreen' ),
			'id'            => 'sidebar-instagram',
			'description'   => esc_html__( 'Appears above footer. This sidebar is only for Widget from plugin Catch Instagram Feed Gallery Widget and Catch Instagram Feed Gallery Widget Pro', 'catch-fullscreen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}
add_action( 'widgets_init', 'catch_fullscreen_widgets_init' );

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 *
 * @since Catch Fullscreen 1.0
 */
function catch_fullscreen_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-4' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-5' ) ) {
		$count++;
	}

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;
	}

	if ( $class )
		echo 'class="widget-area footer-widget-area ' . $class . '"'; // WPCS: XSS OK.
}

if ( ! function_exists( 'catch_fullscreen_fonts_url' ) ) :
/**
 * Register Google fonts for Catch Fullscreen
 *
 * Create your own catch_fullscreen_fonts_url() function to override in a child theme.
 *
 * @since Catch Fullscreen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function catch_fullscreen_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Montserrat, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$poppins = _x( 'on', 'Poppins: on or off', 'catch-fullscreen' );

	if ( 'off' !== $poppins ) {
		$fonts_url = 'https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700i,900i';
	}

	return esc_url_raw( $fonts_url );
}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Catch Fullscreen 1.0
 */
function catch_fullscreen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'catch_fullscreen_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Catch Fullscreen 1.0
 */
function catch_fullscreen_scripts() {
	$theme_details = wp_get_theme();
	$theme_version = $theme_details->get( 'Version' );

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'catch-fullscreen-fonts', catch_fullscreen_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'catch-fullscreen-style', get_stylesheet_uri() );

	// Load the html5 shiv.
	wp_enqueue_script( 'catch-fullscreen-html5', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/html5.min.js', array(), '3.7.3' );
	wp_script_add_data( 'catch-fullscreen-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'catch-fullscreen-skip-link-focus-fix', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/skip-link-focus-fix.min.js', array(), $theme_version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'catch-fullscreen-keyboard-image-navigation', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/keyboard-image-navigation.min.js', array( 'jquery' ), $theme_version );
	}

 	wp_register_script( 'jquery-match-height', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/jquery.matchHeight.min.js', array( 'jquery' ), $theme_version, true );

	wp_enqueue_script( 'catch-fullscreen-script', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/source/functions.js', array( 'jquery', 'jquery-match-height' ), $theme_version, true );
//	wp_enqueue_script( 'catch-fullscreen-script', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/functions.min.js', array( 'jquery', 'jquery-match-height' ), $theme_version, true );

	// Full Page Scripts Start
	if ( is_front_page() ) {
		// Because full page is only active on front page.

		// Full Page CSS.
		wp_enqueue_style( 'fullpage', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/css/fullpage.css', null, $theme_version );


		wp_register_script( 'fullpage', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/fullpage.min.js', null, $theme_version, true );
		wp_register_script( 'fullpage-scrolloverflow', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/scrolloverflow.min.js', array( 'fullpage' ), $theme_version, true );

 		wp_enqueue_script( 'catch-fullscreen-fullpage', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/custom-fullpage.min.js', array( 'fullpage-scrolloverflow' ), $theme_version, true );
	}
	// Full Page Scripts End

	wp_localize_script( 'catch-fullscreen-script', 'screenReaderText', array(
		'expand'   => esc_html__( 'expand child menu', 'catch-fullscreen' ),
		'collapse' => esc_html__( 'collapse child menu', 'catch-fullscreen' ),
		'icon'     => catch_fullscreen_get_svg( array(
			'icon'     => 'angle-down',
			'fallback' => true,
		) ),
	) );

	//Slider Scripts
	$enable_slider = get_theme_mod( 'catch_fullscreen_slider_option', 'disabled' );
	$enable_testimonial = get_theme_mod( 'catch_fullscreen_testimonial_option', 'disabled' );

	if ( catch_fullscreen_check_section( $enable_slider ) || catch_fullscreen_check_section( $enable_testimonial ) ) {
		wp_enqueue_script( 'jquery-cycle2', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/jquery.cycle/jquery.cycle2.min.js', array( 'jquery' ), '2.1.5', true );
	}

	// Enqueue fitvid if JetPack is not installed.
	if ( ! class_exists( 'Jetpack' ) ) {
		wp_enqueue_script( 'jquery-fitvids', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/fitvids.min.js', array( 'jquery' ), '1.1', true );
	}

	// Slick styles and scripts (partner logo carousel)
	wp_register_style('Slick_style', '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.0/slick/slick.css');
	wp_enqueue_style('Slick_style');
	wp_register_style('Slick_Theme_style', '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.0/slick/slick-theme.css');
	wp_enqueue_style('Slick_Theme_style');
	wp_register_script('Slick', '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.0/slick/slick.min.js', array('jquery'), null, true);
	wp_enqueue_script('Slick');

	/*
	<!-- Add the slick-theme.css if you want default styling -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.0/slick/slick.css"/>
	<!-- Add the slick-theme.css if you want default styling -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.0/slick/slick-theme.css"/>
	```

	Then, before your closing ```<body>``` tag add:

	```html
	<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.0/slick/slick.min.js"></script>
	*/
}
add_action( 'wp_enqueue_scripts', 'catch_fullscreen_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( 'inc/template-tags.php' );

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( 'inc/icon-functions.php' );

/**
 * Custom functions that act independently of the theme templates.
 */
require get_parent_theme_file_path( 'inc/extras.php' );

/**
 * Add functions for header media.
 */
require get_parent_theme_file_path( 'inc/custom-header.php' );

/**
 * Load Jetpack compatibility file.
 */
require get_parent_theme_file_path( 'inc/jetpack.php' );

/**
 * Include Breadcrumb
 */
require get_parent_theme_file_path( '/inc/breadcrumb.php' );

/**
 * Include Slider
 */
require get_parent_theme_file_path( '/inc/featured-slider.php' );

/**
 * Include Service
 */
require get_parent_theme_file_path( '/inc/service.php' );

/**
 * Include Partners
 */
require get_parent_theme_file_path( '/inc/partners.php' );

/**
 * Add Metaboxes
 */
require get_parent_theme_file_path( 'inc/metabox/metabox.php' );

/**
 * Include Widgets
 */
require get_parent_theme_file_path( '/inc/widgets/social-icons.php' );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Catch Fullscreen 1.0
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function catch_fullscreen_widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'catch_fullscreen_widget_tag_cloud_args' );

/**
 * Load TGMPA
 */
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function catch_fullscreen_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// Catch Web Tools.
		array(
			'name' => 'Catch Web Tools', // Plugin Name, translation not required.
			'slug' => 'catch-web-tools',
		),
		// Catch IDs
		array(
			'name' => 'Catch IDs', // Plugin Name, translation not required.
			'slug' => 'catch-ids',
		),
		// To Top.
		array(
			'name' => 'To top', // Plugin Name, translation not required.
			'slug' => 'to-top',
		),
		// Catch Gallery.
		array(
			'name' => 'Catch Gallery', // Plugin Name, translation not required.
			'slug' => 'catch-gallery',
		),
	);

	if ( ! class_exists( 'Catch_Infinite_Scroll_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Infinite Scroll', // Plugin Name, translation not required.
			'slug' => 'catch-infinite-scroll',
		);
	}

	if ( ! class_exists( 'Essential_Content_Types_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Content Types', // Plugin Name, translation not required.
			'slug' => 'essential-content-types',
		);
	}

	if ( ! class_exists( 'Essential_Widgets_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Widgets', // Plugin Name, translation not required.
			'slug' => 'essential-widgets',
		);
	}

	if ( ! class_exists( 'Catch_Instagram_Feed_Gallery_Widget_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Instagram Feed Gallery & Widget', // Plugin Name, translation not required.
			'slug' => 'catch-instagram-feed-gallery-widget',
		);
	}

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'catch-fullscreen',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'catch_fullscreen_register_required_plugins' );
