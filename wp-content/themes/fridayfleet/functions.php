<?php
/**
 * fridayfleet functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package fridayfleet
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'fridayfleet_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function fridayfleet_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on fridayfleet, use a find and replace
		 * to change 'fridayfleet' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'fridayfleet', get_template_directory() . '/languages' );

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
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'fridayfleet' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'fridayfleet_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'fridayfleet_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fridayfleet_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fridayfleet_content_width', 640 );
}
add_action( 'after_setup_theme', 'fridayfleet_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fridayfleet_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'fridayfleet' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'fridayfleet' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'fridayfleet_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fridayfleet_scripts() {
	wp_enqueue_style( 'fridayfleet-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'fridayfleet-style', 'rtl', 'replace' );
	wp_enqueue_style( 'fridayfleet-tooltipster', get_template_directory_uri() . '/js/vendor/tooltipster/css/tooltipster.bundle.min.css', array(), _S_VERSION );

	wp_enqueue_script( 'fridayfleet-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'fridayfleet-buttons', get_template_directory_uri() . '/js/buttons.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'fridayfleet-box', get_template_directory_uri() . '/js/box.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'fridayfleet-nav-bar', get_template_directory_uri() . '/js/nav-bar.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'fridayfleet-switcher', get_template_directory_uri() . '/js/switcher.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'fridayfleet-switch', get_template_directory_uri() . '/js/switch.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'fridayfleet-toggler', get_template_directory_uri() . '/js/toggler.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'fridayfleet-chart-js', 'https://cdn.jsdelivr.net/npm/chart.js@2.9.3', array(), _S_VERSION, true );
	wp_enqueue_script( 'fridayfleet-hammer-js', 'https://cdn.jsdelivr.net/npm/hammerjs@2.0.8', array(), _S_VERSION, true );
	wp_enqueue_script( 'fridayfleet-chart-js-zoom-plugin', 'https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7', array(), _S_VERSION, true );
	wp_enqueue_script( 'fridayfleet-chart-js-trendline-plugin', 'https://cdn.jsdelivr.net/npm/chartjs-plugin-trendline', array(), _S_VERSION, true );
	wp_enqueue_script( 'fridayfleet-chart-options', get_template_directory_uri() . '/js/chart-options.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'fridayfleet-tooltipster', get_template_directory_uri() . '/js/vendor/tooltipster/js/tooltipster.bundle.min.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'fridayfleet-init', get_template_directory_uri() . '/js/init.js', array(), _S_VERSION, true );


//	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
//		wp_enqueue_script( 'comment-reply' );
//	}
}
add_action( 'wp_enqueue_scripts', 'fridayfleet_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Sets up support for editor styles and imports them.
 */
function editor_styles_setup() {
	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( 'editor-style.css' );
}
add_action( 'after_setup_theme', 'editor_styles_setup' );

