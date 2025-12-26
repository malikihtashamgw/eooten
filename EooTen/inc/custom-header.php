<?php
/**
 * Set up the WordPress core custom header feature.
 * @uses eooten_header_style() fuzzy function for validation
 */
function eooten_custom_header_setup() {
	add_theme_support( 'custom-header');
}
add_action( 'after_setup_theme', 'eooten_custom_header_setup' );
