<?php

/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.com/
 *
 * @package eooten
 */
function eooten_jetpack_setup() {
	add_theme_support('infinite-scroll', [
		'container' => 'main',
		'render'    => 'eooten_infinite_scroll_render',
		'footer'    => 'page',
	]);

	add_theme_support('jetpack-responsive-videos');
}
add_action('after_setup_theme', 'eooten_jetpack_setup');

/**
 * Custom render function for Infinite Scroll.
 */
function eooten_infinite_scroll_render() {
	while (have_posts()) {
		the_post();
		if (is_search()) :
			get_template_part('template-parts/content', 'search');
		else :
			get_template_part('template-parts/content', get_post_format());
		endif;
	}
}

/**
 * Remove sharing display from excerpt
 */
function eooten_remove_share() {
	remove_filter('the_excerpt', 'sharing_display', 19);
}

add_action('loop_start', 'eooten_remove_share');
