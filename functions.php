<?php
/**
 * Architect 2 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Architect_2
 */

 /**
  * Custom rewrites
  */
 function ghp_rewrite_tag() {
 	add_rewrite_tag('%site%', '([^&]+)');
 }
 add_action( 'init', 'ghp_rewrite_tag', 10, 0 );

 function add_query_vars_filter( $vars ) {
   $vars[] = "site";
   return $vars;
 }
 add_filter( 'query_vars', 'add_query_vars_filter' );

 function ghp_rewrite_rule() {
 	add_rewrite_rule('^([^/]*)/site/([^/]*)/?','index.php?pagename=$matches[1]&site=$matches[2]','top');
 }
 add_action('init', 'ghp_rewrite_rule', 10, 0);

 function ghp_disable_canonical_front_page( $redirect ) {
 	//prevents front page redirecting
     if ( is_page() && $front_page = get_option( 'page_on_front' ) ) {
         if ( is_page( $front_page ) )
             $redirect = false;
     }

     return $redirect;
 }
 add_filter( 'redirect_canonical', 'ghp_disable_canonical_front_page' );


if ( ! function_exists( 'architect_2_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function architect_2_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Architect 2, use a find and replace
		 * to change 'architect-2' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'architect-2', get_template_directory() . '/languages' );

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



		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'architect-2' ),
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
		add_theme_support( 'custom-background', apply_filters( 'architect_2_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'architect_2_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function architect_2_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'architect_2_content_width', 640 );
}
add_action( 'after_setup_theme', 'architect_2_content_width', 0 );


/**
  * Customizer changes editor visuals
  */
function architect_2_setup() {
  //add support for editor styles
  add_theme_support( 'editor-styles' );
  //enqueue editor styles
  add_editor_style( '/'.get_theme_mod('bootstrap_theme_name').'.css' );
}

add_action( 'after_setup_theme', 'architect_2_setup' );

/**
 * Enqueue scripts and styles.
 */
 function architect_2_scripts() {
 wp_enqueue_style( 'architect-2-style', get_stylesheet_uri(), array(), filemtime( get_template_directory().'/style.css'), 'all' );

 	wp_enqueue_script( 'architect-2-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

 	wp_enqueue_script( 'architect-2-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

 	wp_enqueue_script( 'architect-2-change-core-block-categories', get_template_directory_uri() . '/js/scripts.js', array(), '20151215', true );

 	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
 		wp_enqueue_script( 'comment-reply' );
 	}
 }
 add_action( 'wp_enqueue_scripts', 'architect_2_scripts' );

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

function load_custom_wp_admin_style() {
        wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/admin-styles.css', false, '2.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );


function add_custom_change_admin_style() {
        wp_register_style( 'custom_change_admin_css', get_template_directory_uri() . '/' . get_theme_mod( 'arch_theme_name' ) . '.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_change_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'add_custom_change_admin_style' );



add_filter( 'allowed_block_types', 'arch2_allowed_block_types' );


/*if( is_plugin_active( 'arch-photo-essay/arch-photo-essay.php' ) ) {
	// Plugin is active
  function arch2_allowed_block_types( $allowed_blocks ) {

  	return array(

      'core/paragraph',

  		'hero/main',

  		'full-width-image/main',

      'intro-outro/main'

  	);

  }
} else {*/


  function arch2_allowed_block_types( $allowed_blocks ) {


return array(
  		'core/html',
      'core/paragraph',
      'core/list',
  		'byline/main',
  		'hero/main',
  		'three-image/main',
  		'full-width-image/main',
  		'single-image/main',
  		'two-image/main',
  		'blockquote/main',
  		'core-embed/youtube',
  		'core-embed/twitter',
      'button/main',
      'subscribe/main',
      'headline/main',
      'subhead/main',
      'section-anchor/main',
      'top-ad/main',
      'in-well/main',
      'banner-ad/main',
      'metaslider/slider',
      'core/separator',
      'core/table',
      'cbus/main'
  	);



  }
//}





function mytheme_customize_register( $wp_customize ) {
  //All our sections, settings and controls will be added here

  $wp_customize->remove_section( 'title_tagline');
  $wp_customize->remove_section( 'colors');
  $wp_customize->remove_section( 'header_image');
  $wp_customize->remove_section( 'background_image');
  $wp_customize->remove_section( 'widgets');

}
add_action( 'customize_register', 'mytheme_customize_register',50 );

add_theme_support( 'post-thumbnails' );
add_post_type_support( 'page', 'excerpt' );
