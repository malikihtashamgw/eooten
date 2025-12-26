<?php

/**
 * eooten functions and definitions.
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package eooten
 */
function eooten_widgets_init() {

	// Blog Widgets
	register_sidebar(array('name' => esc_html_x('Blog Widgets', 'backend', 'eooten'), 'id' => 'blog-widgets', 'description' => esc_html_x('These are widgets for the Blog sidebar.', 'backend', 'eooten'), 'before_widget' => '<div id="%1$s" class="widget bdt-grid-margin %2$s"><div class="bdt-panel"><div class="panel-content">', 'after_widget' => '</div></div></div>', 'before_title' => '<h3 class="bdt-card-title">', 'after_title' => '</h3>'));
	register_sidebar(array('name' => esc_html_x('Header Bar', 'backend', 'eooten'), 'id' => 'headerbar', 'description' => esc_html_x('These are widgets for showing widgets (such as countdown, search small ads etc) on header top right corner .', 'backend', 'eooten'), 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3 class="bdt-hidden">', 'after_title' => '</h3>'));


	// Search Results Widgets
	register_sidebar(array('name' => esc_html_x('Search Results Widgets', 'backend', 'eooten'), 'id' => 'search-results-widgets', 'description' => esc_html_x('These are widgets for the Search Results sidebar. These sidebar widgets show on right side.', 'backend', 'eooten'), 'before_widget' => '<div id="%1$s" class="widget bdt-grid-margin %2$s"><div class="bdt-panel"><div class="panel-content">', 'after_widget' => '</div></div></div>', 'before_title' => '<h3 class="bdt-card-title">', 'after_title' => '</h3>'));


	// WooCommerce Widgets
	if (class_exists('Woocommerce')) {
		register_sidebar(array('name' => esc_html_x('Shop Widgets', 'backend', 'eooten'), 'id' => 'shop-widgets', 'description' => esc_html_x('These are widgets for the Shop sidebar.', 'backend', 'eooten'), 'before_widget' => '<div id="%1$s" class="widget bdt-grid-margin %2$s"><div class="bdt-panel"><div class="panel-content">', 'after_widget' => '</div></div></div>', 'before_title' => '<h3 class="bdt-card-title">', 'after_title' => '</h3>'));
	}

	// BBPress Widgets
	if (class_exists('bbPress')) {
		register_sidebar(array('name' => esc_html_x('Forum Widgets', 'backend', 'eooten'), 'id' => 'forum-widgets', 'description' => esc_html_x('These are widgets for the Forum sidebar.', 'backend', 'eooten'), 'before_widget' => '<div id="%1$s" class="widget bdt-grid-margin %2$s"><div class="bdt-panel"><div class="panel-content">', 'after_widget' => '</div></div></div>', 'before_title' => '<h3 class="bdt-card-title">', 'after_title' => '</h3>'));
	}

	// Bottom
	register_sidebar(array('name' => esc_html_x('Bottom Widgets', 'backend', 'eooten'), 'id' => 'bottom-widgets', 'description' => esc_html_x('These are widgets for the bottom area on footer position.', 'backend', 'eooten'), 'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="bdt-panel"><div class="panel-content">', 'after_widget' => '</div></div></div>', 'before_title' => '<h3 class="bdt-card-title">', 'after_title' => '</h3>'));

	// Footer Widgets
	register_sidebar(array('name' => esc_html_x('Footer', 'backend', 'eooten'), 'id' => 'footer-widgets', 'description' => esc_html_x('These are widgets for the Footer.', 'backend', 'eooten'), 'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="bdt-panel"><div class="panel-content">', 'after_widget' => '</div></div></div>', 'before_title' => '<h3 class="bdt-card-title">', 'after_title' => '</h3>'));

	// Mobile Off-Canvas position widgets
	register_sidebar(array('name' => esc_html_x('Off-Canvas', 'backend', 'eooten'), 'id' => 'offcanvas', 'description' => esc_html_x('These are widgets for off-canvas bar (it\'s only show in small device mode) and it\'s show under off-canvas menu.', 'backend', 'eooten'), 'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="bdt-panel"><div class="panel-content">', 'after_widget' => '</div></div></div>', 'before_title' => '<h3 class="bdt-card-title">', 'after_title' => '</h3>'));
}

/**
 * 'widgets_init' hook.
 * @link https://developer.wordpress.org/reference/hooks/widgets_init/
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 */
add_action('widgets_init', 'eooten_widgets_init');
