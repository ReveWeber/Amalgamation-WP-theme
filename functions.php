<?php
/**
 * Amalgamation functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Amalgamation
 */

if ( ! function_exists( 'amalgamation_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function amalgamation_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Amalgamation, use a find and replace
	 * to change 'amalgamation' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'amalgamation', get_template_directory() . '/languages' );

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
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'amalgamation' ),
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
	add_theme_support( 'custom-background', apply_filters( 'amalgamation_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
    
}
endif; // amalgamation_setup
add_action( 'after_setup_theme', 'amalgamation_setup' );

/**
 * Enables the Excerpt meta box in Page edit screen.
 */
function amalgamation_add_excerpt_support_for_pages() {
    add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'amalgamation_add_excerpt_support_for_pages' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 * @global int $content_width
 */
function amalgamation_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'amalgamation_content_width', 640 );
}
add_action( 'after_setup_theme', 'amalgamation_content_width', 0 );

/**
 * Register widget area.
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function amalgamation_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'amalgamation' ),
		'id'            => 'sidebar-1',
		'description'   => 'Widgets to appear in the footer of the page',
		'before_widget' => '<aside id="%1$s" class="masonry-item widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'amalgamation_widgets_init' );

/* Add proportional thumbnail image size for front page */
add_image_size( 'proportional-thumbnail', 150, 150 );

add_filter( 'image_size_names_choose', 'amalgamation_custom_sizes' );

function amalgamation_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'proportional-thumbnail' => __( 'Proportional Thumbnail', 'amalgamation' ),
    ) );
}

/**
 * Enqueue scripts and styles.
 */
function amalgamation_scripts() {
	wp_enqueue_style( 'amalgamation-style', get_stylesheet_uri() );

	wp_enqueue_script( 'amalgamation-js-functions', get_template_directory_uri() . '/js/functions.js', array(), '20151216', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'amalgamation_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

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
//require get_template_directory() . '/inc/jetpack.php';

/**
 * Add featured images to RSS feed
 */

function featuredtoRSS($content) {
    global $post;
    if ( has_post_thumbnail( $post->ID ) ){
        $content = '<div>' . get_the_post_thumbnail( $post->ID, 'medium', array( 'style' => 'float:left; margin-right:16px; margin-bottom:16px;' ) ) . '</div>' . $content;
    }
    return $content;
}
 
add_filter('the_excerpt_rss', 'featuredtoRSS');
add_filter('the_content_feed', 'featuredtoRSS');