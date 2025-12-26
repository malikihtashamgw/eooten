<?php

namespace Eooten\Customizer\Settings;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// die('loaded');

class Settings_copyright extends Tab_Base {

	public function get_id() {
		return 'eooten-settings-copyright';
	}

	public function get_title() {
		return __('Copyright', 'eooten');
	}

	public function get_icon() {
		return 'eicon-footer';
	}

	public function get_help_url() {
		return '';
	}

	public function get_group() {
		return 'theme-style';
	}

	protected function register_tab_controls() {

		$this->start_controls_section(
			'section_eooten_copyright',
			[
				'tab' => 'eooten-settings-copyright',
				'label' => __('Footer', 'eooten'),
			]
		);
		$this->add_control(
			'hello_footer_layout',
			[
				'type' => Controls_Manager::SELECT,
				'label' => __('Layout', 'eooten'),
				'options' => [
					'default' => __('Default', 'eooten'),
					'inverted' => __('Inverted', 'eooten'),
					'stacked' => __('Centered', 'eooten'),
				],
				'selector' => '.tm-copyright .copyright-txt',
				'default' => 'default',
			]
		);
		$this->add_control(
			'eooten_copyright_text_custom_show',
			[
				'label'         => esc_html__('Custom Text', 'eooten'),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => esc_html__('Show', 'eooten'),
				'label_off'     => esc_html__('Hide', 'eooten'),
				// 'render_type' => 'template'
				'selector' => '.tm-copyright .copyright-txt',
				// 'default'       => 'yes',

			]
		);
		$this->add_control(
			'eooten_copyright_text_custom',
			[
				'label'       => esc_html__('Copyright Text', 'eooten'),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => esc_html__('&copy; Copyright 2021 All Rights Reserved by Eooten', 'eooten'),
				'placeholder' => esc_html__('© Copyright 2021 All Rights Reserved by Eooten', 'eooten'),
				'renter_type' => 'template',
				'condition' => [
					'eooten_copyright_text_custom_show' => 'yes'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'eooten_copyright_bg_style',
				'label'     => esc_html__('Background', 'eooten'),
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .copyright-txt',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'eooten_copyright_typography',
				'label'     => esc_html__('Typography', 'eooten'),
				'selector'  => '{{WRAPPER}} .copyright-txt',
			]
		);


		// 'choices'  => array(
		// 		'default'   => esc_html_x('Default', 'backend', 'eooten'),
		// 		'muted'     => esc_html_x('Muted', 'backend', 'eooten'),
		// 		'primary'   => esc_html_x('Primary', 'backend', 'eooten'),
		// 		'secondary' => esc_html_x('Secondary', 'backend', 'eooten'),
		// 		'media'     => esc_html_x('Image', 'backend', 'eooten'),
		// 		'custom'    => esc_html_x('Custom Color', 'backend', 'eooten'),
		// 	),

		// $this->add_control(
		// 	'hello_footer_tagline_display',
		// 	[
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label' => __('Tagline', 'eooten'),
		// 		'default' => 'yes',
		// 		'label_on' => __('Show', 'eooten'),
		// 		'label_off' => __('Hide', 'eooten'),
		// 		'selector' => '.site-footer .site-description',
		// 	]
		// );

		// $this->add_control(
		// 	'hello_footer_menu_display',
		// 	[
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label' => __('Menu', 'eooten'),
		// 		'default' => 'yes',
		// 		'label_on' => __('Show', 'eooten'),
		// 		'label_off' => __('Hide', 'eooten'),
		// 		'selector' => '.site-footer .site-navigation',
		// 	]
		// );

		// $this->add_control(
		// 	'hello_footer_copyright_display',
		// 	[
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label' => __('Copyright', 'eooten'),
		// 		'default' => 'yes',
		// 		'label_on' => __('Show', 'eooten'),
		// 		'label_off' => __('Hide', 'eooten'),
		// 		'selector' => '.site-footer .copyright',
		// 	]
		// );

		// $this->add_control(
		// 	'hello_footer_layout',
		// 	[
		// 		'type' => Controls_Manager::SELECT,
		// 		'label' => __('Layout', 'eooten'),
		// 		'options' => [
		// 			'default' => __('Default', 'eooten'),
		// 			'inverted' => __('Inverted', 'eooten'),
		// 			'stacked' => __('Centered', 'eooten'),
		// 		],
		// 		'selector' => '.site-footer',
		// 		'default' => 'default',
		// 	]
		// );

		// $this->add_control(
		// 	'hello_footer_width',
		// 	[
		// 		'type' => Controls_Manager::SELECT,
		// 		'label' => __('Width', 'eooten'),
		// 		'options' => [
		// 			'boxed' => __('Boxed', 'eooten'),
		// 			'full-width' => __('Full Width', 'eooten'),
		// 		],
		// 		'selector' => '.site-footer',
		// 		'default' => 'boxed',
		// 	]
		// );

		// $this->add_responsive_control(
		// 	'hello_footer_custom_width',
		// 	[
		// 		'type' => Controls_Manager::SLIDER,
		// 		'label' => __('Content Width', 'eooten'),
		// 		'size_units' => [
		// 			'%',
		// 			'px',
		// 		],
		// 		'range' => [
		// 			'px' => [
		// 				'max' => 2000,
		// 				'step' => 1,
		// 			],
		// 			'%' => [
		// 				'max' => 100,
		// 				'step' => 1,
		// 			],
		// 		],
		// 		'condition' => [
		// 			'hello_footer_width' => 'boxed',
		// 		],
		// 		'selectors' => [
		// 			'.site-footer .footer-inner' => 'width: {{SIZE}}{{UNIT}}; max-width: 100%;',
		// 		],
		// 	]
		// );

		// $this->add_responsive_control(
		// 	'hello_footer_gap',
		// 	[
		// 		'type' => Controls_Manager::SLIDER,
		// 		'label' => __('Gap', 'eooten'),
		// 		'size_units' => [
		// 			'%',
		// 			'px',
		// 		],
		// 		'range' => [
		// 			'px' => [
		// 				'max' => 2000,
		// 				'step' => 1,
		// 			],
		// 			'%' => [
		// 				'max' => 100,
		// 				'step' => 1,
		// 			],
		// 		],
		// 		'selectors' => [
		// 			'.site-footer' => 'padding-right: {{SIZE}}{{UNIT}}; padding-left: {{SIZE}}{{UNIT}}',
		// 		],
		// 		'condition' => [
		// 			'hello_footer_layout!' => 'stacked',
		// 		],
		// 	]
		// );

		// $this->add_group_control(
		// 	Group_Control_Background::get_type(),
		// 	[
		// 		'name' => 'hello_footer_background',
		// 		'label' => __('Background', 'eooten'),
		// 		'types' => ['classic', 'gradient'],
		// 		'selector' => '.site-footer',
		// 	]
		// );

		// $this->end_controls_section();

		// $this->start_controls_section(
		// 	'hello_footer_logo_section',
		// 	[
		// 		'tab' => 'hello-settings-footer',
		// 		'label' => __('Site Logo', 'eooten'),
		// 		'condition' => [
		// 			'hello_footer_logo_display!' => '',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'hello_footer_logo_type',
		// 	[
		// 		'label' => __('Type', 'eooten'),
		// 		'type' => Controls_Manager::SELECT,
		// 		'default' => 'logo',
		// 		'options' => [
		// 			'logo' => __('Logo', 'eooten'),
		// 			'title' => __('Title', 'eooten'),
		// 		],
		// 		'frontend_available' => true,
		// 	]
		// );

		// $this->add_responsive_control(
		// 	'hello_footer_logo_width',
		// 	[
		// 		'type' => Controls_Manager::SLIDER,
		// 		'label' => __('Logo Width', 'eooten'),
		// 		'description' => sprintf(__('Go to <a href="%s">Site Identity</a> to manage your site\'s logo', 'eooten'), wp_nonce_url('customize.php?autofocus[section]=title_tagline')),
		// 		'size_units' => [
		// 			'%',
		// 			'px',
		// 			'vh',
		// 		],
		// 		'range' => [
		// 			'px' => [
		// 				'max' => 1000,
		// 				'step' => 1,
		// 			],
		// 			'%' => [
		// 				'max' => 100,
		// 				'step' => 1,
		// 			],
		// 		],
		// 		'condition' => [
		// 			'hello_footer_logo_display' => 'yes',
		// 			'hello_footer_logo_type' => 'logo',
		// 		],
		// 		'selectors' => [
		// 			'.site-footer .site-branding .site-logo img' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}}',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'hello_footer_title_color',
		// 	[
		// 		'label' => __('Text Color', 'eooten'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'condition' => [
		// 			'hello_footer_logo_display' => 'yes',
		// 			'hello_footer_logo_type' => 'title',
		// 		],
		// 		'selectors' => [
		// 			'.site-footer h4.site-title a' => 'color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->add_group_control(
		// 	Group_Control_Typography::get_type(),
		// 	[
		// 		'name' => 'hello_footer_title_typography',
		// 		'label' => __('Typography', 'eooten'),
		// 		'condition' => [
		// 			'hello_footer_logo_display' => 'yes',
		// 			'hello_footer_logo_type' => 'title',
		// 		],
		// 		'selector' => '.site-footer h4.site-title',

		// 	]
		// );

		// $this->add_control(
		// 	'hello_footer_title_link',
		// 	[
		// 		'type' => Controls_Manager::RAW_HTML,
		// 		'raw' => sprintf(__('Go to <a href="%s">Site Identity</a> to manage your site\'s title and tagline', 'eooten'), wp_nonce_url('customize.php?autofocus[section]=title_tagline')),
		// 		'content_classes' => 'elementor-control-field-description',
		// 		'condition' => [
		// 			'hello_footer_logo_display' => 'yes',
		// 			'hello_footer_logo_type' => 'title',
		// 		],
		// 	]
		// );

		// $this->end_controls_section();

		// $this->start_controls_section(
		// 	'hello_footer_tagline',
		// 	[
		// 		'tab' => 'hello-settings-footer',
		// 		'label' => __('Tagline', 'eooten'),
		// 		'condition' => [
		// 			'hello_footer_tagline_display' => 'yes',
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'hello_footer_tagline_color',
		// 	[
		// 		'label' => __('Text Color', 'eooten'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'condition' => [
		// 			'hello_footer_tagline_display' => 'yes',
		// 		],
		// 		'selectors' => [
		// 			'.site-footer .site-description' => 'color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->add_group_control(
		// 	Group_Control_Typography::get_type(),
		// 	[
		// 		'name' => 'hello_footer_tagline_typography',
		// 		'label' => __('Typography', 'eooten'),
		// 		'condition' => [
		// 			'hello_footer_tagline_display' => 'yes',
		// 		],
		// 		'selector' => '.site-footer .site-description',
		// 	]
		// );

		// $this->add_control(
		// 	'hello_footer_tagline_link',
		// 	[
		// 		'type' => Controls_Manager::RAW_HTML,
		// 		'raw' => sprintf(__('Go to <a href="%s">Site Identity</a> to manage your site\'s title and tagline', 'eooten'), wp_nonce_url('customize.php?autofocus[section]=title_tagline')),
		// 		'content_classes' => 'elementor-control-field-description',
		// 	]
		// );

		// $this->end_controls_section();

		// $this->start_controls_section(
		// 	'hello_footer_menu_tab',
		// 	[
		// 		'tab' => 'hello-settings-footer',
		// 		'label' => __('Menu', 'eooten'),
		// 		'condition' => [
		// 			'hello_footer_menu_display' => 'yes',
		// 		],
		// 	]
		// );

		// $available_menus = wp_get_nav_menus();

		// $menus = ['0' => __('— Select a Menu —', 'eooten')];
		// foreach ($available_menus as $available_menu) {
		// 	$menus[$available_menu->term_id] = $available_menu->name;
		// }

		// if (1 === count($menus)) {
		// 	$this->add_control(
		// 		'hello_footer_menu_notice',
		// 		[
		// 			'type' => Controls_Manager::RAW_HTML,
		// 			'raw' => '<strong>' . __('There are no menus in your site.', 'eooten') . '</strong><br>' . sprintf(__('Go to <a href="%s" target="_blank">Menus screen</a> to create one.', 'eooten'), admin_url('nav-menus.php?action=edit&menu=0')),
		// 			'separator' => 'after',
		// 			'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
		// 		]
		// 	);
		// } else {
		// 	$this->add_control(
		// 		'hello_footer_menu',
		// 		[
		// 			'label' => __('Menu', 'eooten'),
		// 			'type' => Controls_Manager::SELECT,
		// 			'options' => $menus,
		// 			'default' => array_keys($menus)[0],
		// 			'description' => sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'eooten'), admin_url('nav-menus.php')),
		// 		]
		// 	);

		// 	$this->add_control(
		// 		'hello_footer_menu_warning',
		// 		[
		// 			'type' => Controls_Manager::RAW_HTML,
		// 			'raw' => __('Changes will be reflected in the preview only after the page reloads.', 'eooten'),
		// 			'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
		// 		]
		// 	);

		// 	$this->add_control(
		// 		'hello_footer_menu_color',
		// 		[
		// 			'label' => __('Color', 'eooten'),
		// 			'type' => Controls_Manager::COLOR,
		// 			'selectors' => [
		// 				'footer .footer-inner .site-navigation a' => 'color: {{VALUE}};',
		// 			],
		// 		]
		// 	);

		// 	$this->add_group_control(
		// 		Group_Control_Typography::get_type(),
		// 		[
		// 			'name' => 'hello_footer_menu_typography',
		// 			'label' => __('Typography', 'eooten'),
		// 			'selector' => 'footer .footer-inner .site-navigation a',
		// 		]
		// 	);
		// }

		// $this->end_controls_section();

		// $this->start_controls_section(
		// 	'hello_footer_copyright_section',
		// 	[
		// 		'tab' => 'hello-settings-footer',
		// 		'label' => __('Copyright', 'eooten'),
		// 		'conditions' => [
		// 			'relation' => 'and',
		// 			'terms' => [
		// 				[
		// 					'name' => 'hello_footer_copyright_display',
		// 					'operator' => '=',
		// 					'value' => 'yes',
		// 				],
		// 			],
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'hello_footer_copyright_text',
		// 	[
		// 		'type' => Controls_Manager::TEXTAREA,
		// 		'default' => __('All rights reserved', 'eooten'),
		// 	]
		// );

		// $this->add_control(
		// 	'hello_footer_copyright_color',
		// 	[
		// 		'label' => __('Text Color', 'eooten'),
		// 		'type' => Controls_Manager::COLOR,
		// 		'condition' => [
		// 			'hello_footer_copyright_display' => 'yes',
		// 		],
		// 		'selectors' => [
		// 			'.site-footer .copyright p' => 'color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->add_group_control(
		// 	Group_Control_Typography::get_type(),
		// 	[
		// 		'name' => 'hello_footer_copyright_typography',
		// 		'label' => __('Typography', 'eooten'),
		// 		'condition' => [
		// 			'hello_footer_copyright_display' => 'yes',
		// 		],
		// 		'selector' => '.site-footer .copyright p',
		// 	]
		// );

		$this->end_controls_section();
	}

	public function on_save($data) {
		// Save chosen footer menu to the WP settings.
		if (isset($data['settings']['hello_footer_menu'])) {
			$menu_id = $data['settings']['hello_footer_menu'];
			$locations = get_theme_mod('nav_menu_locations');
			$locations['menu-2'] = (int) $menu_id;
			set_theme_mod('nav_menu_locations', $locations);
		}
	}

	public function _get_additional_tab_content() {
		return sprintf(
			'
				<div class="eooten elementor-nerd-box">
					<img src="%4$s" class="elementor-nerd-box-icon">
					<div class="elementor-nerd-box-message">
						<p class="elementor-panel-heading-title elementor-nerd-box-title">%1$s</p>
						<p class="elementor-nerd-box-message">%2$s</p>
					</div>
					<a class="elementor-button elementor-button-success elementor-nerd-box-link" target="_blank" href="%5$s">%3$s</a>
				</div>
				',
			__('Create a custom footer with the new Theme Builder', 'eooten'),
			__('With the new Theme Builder you can jump directly into each part of your site', 'eooten'),
			__('Create Footer', 'eooten'),
			get_template_directory_uri() . '/assets/images/go-pro.svg',
			get_admin_url(null, 'admin.php?page=elementor-app#/site-editor/templates/footer')
		);
	}
}
