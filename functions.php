<?php
/**
 * app_starter functions and definitions
 *
 * @package app_starter
 */

/**
 * Define version in a constant
 *
 * @since 0.0.1
 */
if ( !defined( 'APP_STARTER_VERSION' ) ) {
	define( 'APP_STARTER_VERSION', '0.0.1' );
}
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'app_starter_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function app_starter_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on app_starter, use a find and replace
	 * to change 'app_starter' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'app_starter', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'off-canvas-right' => __( 'Right Off Canvas Menu', 'app_starter' ),
		'off-canvas-left' => __( 'Left Off Canvas Menu', 'app_starter' ),
	) );

	// Enable support for Post Formats.
	//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'app_starter_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
	) );
}
endif; // app_starter_setup
add_action( 'after_setup_theme', 'app_starter_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function app_starter_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'app_starter' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Off Canvas Left Sidebar', 'app_starter' ),
		'id'            => 'offcanvas-left',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Off Canvas Right Sidebar', 'app_starter' ),
		'id'            => 'offcanvas-right',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'app_starter_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function app_starter_scripts() {

	/**
	 * Prevent loading of the theme's CSS
	 *
	 * @param bool $use Whether to load theme's CSS.
	 *
	 * @return bool
	 *
	 * @since 0.0.2.
	 */
	if ( apply_filters( 'app_starter_use_main_css', true ) ) {
		wp_enqueue_style( 'app_starter-style', trailingslashit( get_stylesheet_directory_uri() ).'css/app_starter.css', array(), APP_STARTER_VERSION );
	}

	wp_enqueue_script( 'app_starter-navigation', get_template_directory_uri() . '/js/navigation.js', array(), APP_STARTER_VERSION, true );

	wp_enqueue_script( 'app_starter-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), APP_STARTER_VERSION, true );

	/**
	 * Prevent loading of the theme's JS
	 *
	 * @param bool $use Whether to load theme's js.
	 *
	 * @retrun bool
	 *
	 * @since 0.0.2.
	 */
	if ( apply_filters( 'app_starter_use_main_js', true ) ) {
		wp_enqueue_script( 'app-starter', get_stylesheet_directory_uri() . '/js/app_starter.min.js', array ( 'jquery', 'foundation' ), APP_STARTER_VERSION, TRUE );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'app_starter_scripts' );

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
require get_template_directory() . '/inc/jetpack.php';

/**
 * Add Foundation
 */
require get_template_directory() . '/inc/foundation.php';



if ( ! function_exists( 'app_starter_sidebar' ) ) :
	/**
	 * Better sidebar function
	 *
	 * @since 0.0.1
	 */
	function app_starter_sidebar( $name = null ) {
		/**
		 * Filter to override which sidebar we are using.
		 *
		 * @see https://core.trac.wordpress.org/ticket/26636
		 *
		 * @since 0.0.1
		 */
		$name = apply_filters( 'app_starter_get_sidebar', $name );

		/**
		 * Filter to prevent sidebar
		 *
		 * @param bool
		 *
		 * @since 0.0.1
		 */
		if ( apply_filters( 'app_starter_no_sidebar', false ) === false ) {
			if ( function_exists( 'pods_view' ) ) {
				$name = 'sidebar.php';
				if ( ! is_null( $name ) && file_exists( 'sidebar-'.$name.'.php' ) ) {
						$name = 'sidebar-'.$name.'.php';
					}

				pods_view( $name, null, app_starter_cache_expires(), app_starter_cache_mode() );
			}
			else {
				get_sidebar( $name );

			}

		}

	}
endif;

if ( ! function_exists( 'app_starter_header' ) ) :
	/**
	 * Better header function
	 *
	 * @param 	string	$name	Name of header.
	 *
	 * @returns	string			The header.
	 *
	 * @since 0.0.2
	 */
	function app_starter_header( $name = null ) {
		/**
		 * Override which header is returned;
		 *
		 * @param string $name Name of header.
		 *
		 * @since 0.0.2
		 */
		$name = apply_filters( 'app_starter_header', $name );

		if ( function_exists( 'pods_view' ) ) {
			$name = 'header.php';
			if ( ! is_null( $name ) && file_exists( 'header-'.$name.'.php' ) ) {
				$name = 'header-'.$name.'.php';
			}

			pods_view( $name, null, app_starter_cache_expires(), app_starter_cache_mode() );
		}
		else {
			get_header( $name );

		}

	}
endif;

if ( ! function_exists( 'app_starter_footer' ) ) :
	/**
	 * Better footer function
	 *
	 * @param 	string	$name	Name of footer.
	 *
	 * @returns	string			The footer.
	 *
	 * @since 0.0.2
	 */
	function app_starter_footer( $name = null ) {

		/**
		 * Override which footer is returned;
		 *
		 * @param string $name Name of footer.
		 *
		 * @since 0.0.2
		 */
		$name = apply_filters( 'app_starter_footer', $name );
		if ( function_exists( 'pods_view' ) ) {
			$name = 'footer.php';
			if ( ! is_null( $name ) && file_exists( 'footer-'.$name.'.php' ) ) {
				$name = 'footer-'.$name.'.php';
			}

			pods_view( $name, null, app_starter_cache_expires(), app_starter_cache_mode() );
		}
		else {
			get_header( $name );

		}
	}
endif;

/**
 * Get the default cache expiration length
 *
 * @return string
 *
 * @since 0.0.2
 */
function app_starter_cache_expires() {
	/**
	 * Filter to set the cache expiration
	 *
	 * Note: Not used if Pods isn't active.
	 *
	 * @see http://pods.io/docs/code/pods-view/
	 *
	 * @param null|int $cache_expires If null, not used. To use set a time span in seconds.
	 *
	 * @return null|int The cache expiration length
	 *
	 * @since 0.0.1
	 */
	if ( !is_null ( $cache_expires = apply_filters( 'app_starter_cache_expires', null ) ) ) {
		return $cache_expires;
	}

	return get_option( 'app_starter_cache_expires', DAY_IN_SECONDS );

}

/**
 * Get the default cache expiration mode
 *
 * @return string
 *
 * @since 0.0.2
 */
function app_starter_cache_mode() {
	/**
	 * Filter to set the cache mode
	 *
	 * Note: Not used if Pods isn't active.
	 *
	 * @see http://pods.io/docs/code/pods-view/
	 *
	 * @param null|string $cache_mode If null, not used. To use set to cache|transient|site_transient
	 *
	 * @return null|string The cache mode for pods_view
	 *
	 * @since 0.0.1
	 */
	if ( !is_null ( $cache_expires = apply_filters( 'app_starter_cache_mode', null ) ) ) {
		return $cache_expires;
	}

	return get_option( 'app_starter_cache_mode', 'cache' );

}
