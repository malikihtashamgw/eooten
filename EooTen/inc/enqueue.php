<?php

/**
 * Enqueue scripts and styles.
 * @return [type] [description]
 */
function eooten_admin_style() {
	wp_register_style('admin-setting', get_template_directory_uri() . '/admin/css/admin-settings.css');
	wp_enqueue_style('admin-setting');
}
add_action('admin_enqueue_scripts', 'eooten_admin_style');


/**
 * Admin related scripts
 * @return [type] [description]
 */
function eooten_admin_script() {
	wp_register_script('admin-setting', get_template_directory_uri() . '/admin/js/admin-settings.js', ['jquery'], EOOTEN_VER, true);

	wp_enqueue_script('admin-setting');
}
add_action('admin_enqueue_scripts', 'eooten_admin_script');


/**
 * Site Stylesheets
 * @return [type] [description]
 */
function eooten_styles() {

	// Load Primary Stylesheet

	if (is_rtl()) {
		wp_enqueue_style('bdt-uikit', EOOTEN_URL . '/css/bdt-uikit.rtl.css', [], '3.11.1', 'all');
	} else {
		wp_enqueue_style('bdt-uikit', EOOTEN_URL . '/css/bdt-uikit.css', [], '3.11.1', 'all');
	}

	if (class_exists('Woocommerce')) {
		wp_enqueue_style('theme-woocommerce-style', EOOTEN_URL . '/css/woocommerce.css', [], EOOTEN_VER, 'all');
	}

	if (get_theme_mod('eooten_header_txt_style', false)) {
		wp_enqueue_style('theme-inverse-style', EOOTEN_URL . '/css/inverse.css', [], '3.11.1', 'all');
	}

	// google font load locally for faster load
	wp_enqueue_style('theme-style', EOOTEN_URL . '/css/default-fonts.css', [], EOOTEN_VER, 'all');

	wp_enqueue_style('eooten-style', get_stylesheet_uri(), [], EOOTEN_VER, 'all');

	wp_style_add_data('eooten-style', 'rtl', 'replace');
}
add_action('wp_enqueue_scripts', 'eooten_styles');

/**
 * Site Scripts
 * @return [type] [description]
 */
function eooten_scripts() {

	$suffix    = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
	$preloader = get_theme_mod('eooten_preloader');
	$cookie    = get_theme_mod('eooten_cookie');

	if ($preloader) {
		wp_enqueue_script('please-wait', EOOTEN_URL . '/js/please-wait.min.js', [], EOOTEN_VER, false);
	}
	if ($cookie) {
		wp_register_script('cookie-bar', EOOTEN_URL . '/js/jquery.cookiebar.js', [], EOOTEN_VER, true);
		wp_enqueue_script('cookie-bar');
	}

	if (!defined('BDTEP') or !defined('BDTPS')) {
		wp_register_script('bdt-uikit', EOOTEN_URL . '/js/bdt-uikit' . $suffix . '.js', ['jquery'], '3.16.3', true);
		wp_enqueue_script('bdt-uikit');
	}
	
	if (get_theme_mod('eooten_smooth_scroll', 1)) {
		wp_register_script( 'gsap', EOOTEN_URL . '/js/gsap.min.js', [], '3.12.5', true );
		wp_register_script( 'lenis', EOOTEN_URL . '/js/lenis.min.js', [ 'gsap' ], EOOTEN_VER, true );
		wp_register_style( 'lenis', EOOTEN_URL . '/css/lenis.min.css', [], EOOTEN_VER );
		wp_register_script( 'bdt-smooth-scroller', EOOTEN_URL . '/js/eooten-smooth-scroller.js', [ 'jquery-core', 'lenis' ], EOOTEN_VER, true );

		wp_enqueue_style( 'lenis' );
		wp_enqueue_script( 'gsap' );
		wp_enqueue_script( 'lenis' );
		wp_enqueue_script( 'bdt-smooth-scroller' );
	}

	wp_register_script('eooten-script', EOOTEN_URL . '/js/theme.js', ['jquery'], EOOTEN_VER, true);
	wp_enqueue_script('eooten-script');

	// Load WP Comment Reply JS
	if (is_singular()) {
		wp_enqueue_script('comment-reply');
	}
}

add_action('wp_enqueue_scripts', 'eooten_scripts', 99998);
