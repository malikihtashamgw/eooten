<?php

/**
 * Load the Customizer with some custom extended addons
 * @package Eooten
 * @link http://codex.wordpress.org/Theme_Customization_API
 */

load_template(get_template_directory() . '/customizer/class-customizer-control.php');

/**
 * This funtion is only called when the user is actually on the customizer page
 * @param  WP_Customize_Manager $wp_customize
 */
if (!function_exists('eooten_customizer')) {
	function eooten_customizer($wp_customize) {

		// add required files
		load_template(get_template_directory() . '/customizer/class-customizer-base.php');
		load_template(get_template_directory() . '/customizer/class-customizer-dynamic-css.php');

		new eooten_Customizer_Base($wp_customize);
	}

	add_action('customize_register', 'eooten_customizer');
}

/**
 * Takes care for the frontend output from the customizer and nothing else
 *
 * @return void
 * @since 1.0.0
 * @package eooten
 * @subpackage eooten/customizer
 * @link http://codex.wordpress.org/Theme_Customization_API
 */
if (!function_exists('eooten_customizer_frontend') && !class_exists('Eooten_Customize_Frontent')) {
	function eooten_customizer_frontend() {
		load_template(get_template_directory() . '/customizer/class-customizer-frontend.php');
		new eooten_Customize_Frontent();
	}
	add_action('init', 'eooten_customizer_frontend');
}
