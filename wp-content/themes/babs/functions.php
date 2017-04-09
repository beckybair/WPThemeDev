<?php
/**
 * BABs functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/babs/theme-functions/
 *
 * @package BABs
 */

if ( ! function_exists( 'babs_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function babs_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on BABs, use a find and replace
	 * to change 'babs' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'babs', get_template_directory() . '/languages' );

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
    set_post_thumbnail_size( 828, 360, TRUE );
    add_image_size( 'babs-small-thumb', 300, 150, TRUE );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'babs' ),
    'social' => __('Social', 'babs'),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'babs_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

  /**
  * Add editor styles
  **/
  add_editor_style( array(
    'inc/editor-style.css',
    'https://fonts.googleapis.com/css?family=Raleway:400,400i,700,700i',
    'https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i',
    'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
  ) );
}
endif;
add_action( 'after_setup_theme', 'babs_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function babs_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'babs_content_width', 640 );
}
add_action( 'after_setup_theme', 'babs_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function babs_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Widget Area', 'babs' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'babs' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'babs_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function babs_scripts() {
	wp_enqueue_style( 'babs-style', get_stylesheet_uri() );

  // Expand and Collapse Menus
  wp_enqueue_script( 'babs-navigation', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20151215', true );
	wp_localize_script( 'babs-navigation', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'babs' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'babs' ) . '</span>',
	) );

	wp_enqueue_script( 'babs-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

  // Add Google Fonts: Fira Sans and Merriweather
  wp_enqueue_style( 'google-raleway', "https://fonts.googleapis.com/css?family=Raleway:400,400i,700,700i" );
  wp_enqueue_style( 'google-roboto', "https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i" );
//  wp_enqueue_style( '', '' );

  // Add Font Awesome icons (http://fontawesome.io)
  wp_enqueue_style( 'font-awesome', "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'babs_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
