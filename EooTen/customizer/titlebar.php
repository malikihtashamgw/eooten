<?php
/**
 * Load the Customizer with some custom extended addons
 * @package Eooten
 * @link http://codex.wordpress.org/Theme_Customization_API
 */
function eooten_customize_register_titlebar($wp_customize) {
	//header section
	$wp_customize->add_section('header', array(
		'title' => esc_attr__('Titlebar', 'eooten'),
		'priority' => 31
	));

	$wp_customize->add_setting('eooten_global_header', array(
		'default' => 'title',
		'sanitize_callback' => 'eooten_sanitize_choices'
	));
	$wp_customize->add_control('eooten_global_header', array(
		'label'    => esc_attr__('Titlebar Layout', 'eooten'),
		'section'  => 'header',
		'settings' => 'eooten_global_header',
		'type'     => 'select',
		'priority' => 1,
		'choices'  => array(
			'title'               => esc_attr__('Titlebar (Left Align)', 'eooten'),
			'featuredimagecenter' => esc_attr__('Titlebar (Center Align)', 'eooten'),
			'notitle'             => esc_attr__('No Titlebar', 'eooten')
		)
	));


	$wp_customize->add_setting('eooten_titlebar_style', array(
		'default' => 'titlebar-dark',
		'sanitize_callback' => 'eooten_sanitize_choices'
	));
	$wp_customize->add_control('eooten_titlebar_style', array(
		'label'    => esc_attr__('Titlebar Style', 'eooten'),
		'section'  => 'header',
		'settings' => 'eooten_titlebar_style',
		'type'     => 'select',
		'priority' => 1,
		'choices'  => array(
			'titlebar-dark' => esc_attr__('Dark (for dark backgrounds)', 'eooten'),
			'titlebar-light' => esc_attr__('Light (for light backgrounds)', 'eooten')
		)
	));

	$wp_customize->add_setting( 'eooten_titlebar_bg_image' , array(
		'sanitize_callback' => 'esc_url'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'eooten_titlebar_bg_image', array(
		'priority' => 1,
	    'label'    => esc_attr__( 'Titlebar Background', 'eooten' ),
	    'section'  => 'header',
	    'settings' => 'eooten_titlebar_bg_image'
	)));

	$wp_customize->add_setting('eooten_blog_title', array(
		'default' => esc_attr__('Blog', 'eooten'),
		'sanitize_callback' => 'esc_attr'
	));
	$wp_customize->add_control('eooten_blog_title', array(
		'priority' => 2,
	    'label'    => esc_attr__('Blog Title: ', 'eooten'),
	    'section'  => 'header',
	    'settings' => 'eooten_blog_title'
	));

	if (class_exists('Woocommerce')){
		$wp_customize->add_setting('eooten_woocommerce_title', array(
			'default' => esc_attr__('Shop', 'eooten'),
			'sanitize_callback' => 'esc_attr'
		));
		$wp_customize->add_control('eooten_woocommerce_title', array(
			'priority' => 3,
		    'label'    => esc_attr__('WooCommerce Title: ', 'eooten'),
		    'section'  => 'header',
		    'settings' => 'eooten_woocommerce_title'
		));
	}

	$wp_customize->add_setting('eooten_right_element', array(
		'default' => 'back_button',
		'sanitize_callback' => 'eooten_sanitize_choices'
	));
	$wp_customize->add_control('eooten_right_element', array(
		'label'    => esc_attr__('Right Element', 'eooten'),
		'section'  => 'header',
		'settings' => 'eooten_right_element',
		'type'     => 'select',
		'priority' => 4,
		'choices'  => array(
			0             => esc_attr__('Nothing', 'eooten'),
			'back_button' => esc_attr__('Back Button', 'eooten'),
			'breadcrumb'  => esc_attr__('Breadcrumb', 'eooten')
		)
	));

}

add_action('customize_register', 'eooten_customize_register_titlebar');