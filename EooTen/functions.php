<?php

/**
 * eooten functions and definitions.
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package eooten
 */

define('EOOTEN_VER', wp_get_theme()->get('Version'));
define('EOOTEN__FILE__', __FILE__);
define('EOOTEN_PNAME', basename(dirname(EOOTEN__FILE__)));
define('EOOTEN_PATH', get_template_directory());
define('EOOTEN_URL', get_template_directory_uri());

//
/**
 * Check if in the admin
 * @global bool $eooten_is_admin
 *
 */
$eooten_is_admin = is_admin();
if ($eooten_is_admin) {
    require_once(EOOTEN_PATH . '/admin/admin-functions.php');
}


/**
 * load helper functions file
 */
require_once(EOOTEN_PATH . '/inc/helper-functions.php');
/**
 * load nav walker file
 */
require_once(EOOTEN_PATH . '/inc/nav_walker.php');

/**
 * Custom Widgets declare here
 */
require_once(EOOTEN_PATH . '/inc/sidebars.php');

/**
 * Customizer additions.
 */
require_once(EOOTEN_PATH . '/customizer/theme-customizer.php');


/**
 * Breadcrumb
 */
require_once(EOOTEN_PATH . '/inc/breadcrumbs.php');


/**
 * Load custom metabox
 */
if (did_action('elementor/loaded')) {
    require_once(EOOTEN_PATH . '/inc/meta-box/metabox.php');
}


// enqueue style and script from this file
require_once(EOOTEN_PATH . '/inc/enqueue.php');

/**
 * Custom functions that act independently of the theme templates.
 */
require EOOTEN_PATH . '/inc/extras.php';


if (!function_exists('eooten_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function eooten_setup() {
        /**
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on eooten, use a find and replace
         * to change 'eooten' to the name of your theme in all the template files.
         */
        load_theme_textdomain('eooten', EOOTEN_PATH . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /**
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');
        add_theme_support('wp-block-styles');
        add_theme_support('responsive-embeds');
        add_theme_support('custom-logo');
        add_theme_support('align-wide');

        // Post Formats
        add_theme_support('post-formats', array('gallery', 'link', 'quote', 'audio', 'video'));

        /**
         * Enable support for Post Thumbnails on posts and pages.
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        if (function_exists('add_image_size')) {
            add_image_size('eooten_blog', 1200, 800, true); // Standard Blog Image
        }

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
            [
                'primary'   => esc_html_x('Primary Menu', 'backend', 'eooten'),
                'offcanvas' => esc_html_x('Offcanvas Menu', 'backend', 'eooten'),
                'toolbar'   => esc_html_x('Toolbar Menu', 'backend', 'eooten'),
                'copyright' => esc_html_x('Copyright Menu', 'backend', 'eooten'),
            ]
        );

        /**
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ]);

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background');

        /**
         * Set the content width in pixels, based on the theme's design and stylesheet.
         * Priority 0 to make it available to lower priority callbacks.
         * @global int $content_width
         */
        $GLOBALS['content_width'] = apply_filters('content_width', 1200);

        /**
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style('admin/css/editor-style.css');

        add_theme_support('customize-selective-refresh-widgets');
    }
endif;

add_action('after_setup_theme', 'eooten_setup');

/**
 * Custom template tags for this theme.
 */
require EOOTEN_PATH . '/inc/template-tags.php';


/**
 * Load Jetpack compatibility file.
 */
require EOOTEN_PATH . '/inc/jetpack.php';