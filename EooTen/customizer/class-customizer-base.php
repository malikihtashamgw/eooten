<?php

/**
 * Contains methods for customizing the theme customization screen.
 *
 * @package Eooten
 * @link http://codex.wordpress.org/Theme_Customization_API
 */

class eooten_Customizer_Base {
	/**
	 * The singleton manager instance
	 * @see wp-includes/class-wp-customize-manager.php
	 * @var WP_Customize_Manager
	 */
	protected $wp_customize;

	public function __construct(WP_Customize_Manager $wp_manager) {
		// set the private propery to instance of wp_manager
		$this->wp_customize = $wp_manager;

		// register the settings/panels/sections/controls, main method
		$this->register();

		/**
		 * Action and filters
		 */

		// render the CSS and cache it to the theme_mod when the setting is saved
		add_action('customize_save_after', array($this, 'cache_rendered_css'));

		// save logo width/height dimensions
		add_action('customize_save_logo_img', array($this, 'save_logo_dimensions'), 10, 1);

		// flush the rewrite rules after the customizer settings are saved
		add_action('customize_save_after', 'flush_rewrite_rules');

		// handle the postMessage transfer method with some dynamically generated JS in the footer of the theme
		add_action('wp_footer', array($this, 'customize_footer_js'), 30);
		add_action('wp_head', array($this, 'hook_custom_css'));
	}

	/**
	 * This hooks into 'customize_register' (available as of WP 3.4) and allows
	 * you to add new sections and controls to the Theme Customize screen.
	 *
	 * Note: To enable instant preview, we have to actually write a bit of custom
	 * javascript. See live_preview() for more.
	 *
	 * @see add_action('customize_register',$func)
	 */
	public function register() {
		/**
		 * Settings
		 */

		//$this->wp_customize->remove_section( 'colors');
		$this->wp_customize->get_setting('blogname')->transport         = 'postMessage';
		$this->wp_customize->get_setting('blogdescription')->transport  = 'postMessage';



		$this->wp_customize->add_setting('eooten_logo_default', array(
			'sanitize_callback' => 'esc_url'
		));
		$this->wp_customize->add_control(new WP_Customize_Image_Control($this->wp_customize, 'eooten_logo_default', array(
			'priority' => 101,
			'label'    => esc_html_x('Default Logo', 'backend', 'eooten'),
			'section'  => 'title_tagline',
			'settings' => 'eooten_logo_default'
		)));

		$this->wp_customize->add_setting('eooten_logo_width_default', array(
			'sanitize_callback' => 'eooten_sanitize_text'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_logo_width_default', array(
			'label'       => esc_html_x('Default Logo Width', 'backend', 'eooten'),
			'description' => esc_html_x('This is an optional width (example: 150px) settings. maybe this not need if you use 150px x 32px logo.', 'backend', 'eooten'),
			'priority' => 102,
			'section'     => 'title_tagline',
			'settings'    => 'eooten_logo_width_default',
			'type'        => 'text',
		)));

		$this->wp_customize->add_setting('eooten_logo_mobile', array(
			'sanitize_callback' => 'esc_url'
		));
		$this->wp_customize->add_control(new WP_Customize_Image_Control($this->wp_customize, 'eooten_logo_mobile', array(
			'priority' => 103,
			'label'    => esc_html_x('Mobile Logo', 'backend', 'eooten'),
			'section'  => 'title_tagline',
			'settings' => 'eooten_logo_mobile'
		)));


		$this->wp_customize->add_setting('eooten_logo_width_mobile', array(
			'sanitize_callback' => 'eooten_sanitize_text'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_logo_width_mobile', array(
			'label'       => esc_html_x('Mobile Logo Width', 'backend', 'eooten'),
			'description' => esc_html_x('This is an optional width (example: 150px) settings. maybe this not need if you use 150px x 32px logo.', 'backend', 'eooten'),
			'priority' => 104,
			'section'     => 'title_tagline',
			'settings'    => 'eooten_logo_width_mobile',
			'type'        => 'text',
		)));

		$this->wp_customize->add_setting('eooten_mobile_logo_align', array(
			'default' => 'center',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_mobile_logo_align', array(
			'label'    => esc_html_x('Mobile Logo Align', 'backend', 'eooten'),
			'section'  => 'title_tagline',
			'settings' => 'eooten_mobile_logo_align',
			'type'     => 'select',
			'choices'  => array(
				'' => esc_html_x('Hide', 'backend', 'eooten'),
				'left' => esc_html_x('Left', 'backend', 'eooten'),
				'right' => esc_html_x('Right', 'backend', 'eooten'),
				'center' => esc_html_x('Center', 'backend', 'eooten'),
			),
			'priority' => 106,
		)));



		/**
		 * General Customizer Settings
		 */

		//general section
		$this->wp_customize->add_section('general', array(
			'title' => esc_html_x('General', 'backend', 'eooten'),
			'priority' => 21
		));

		$this->wp_customize->add_setting('eooten_global_layout', array(
			'default' => 'full',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_global_layout', array(
			'label'    => esc_html_x('Global Layout', 'backend', 'eooten'),
			'section'  => 'general',
			'settings' => 'eooten_global_layout',
			'type'     => 'select',
			'choices'  => array(
				'full'  => esc_html_x('Fullwidth', 'backend', 'eooten'),
				'boxed' => esc_html_x('Boxed', 'backend', 'eooten'),
			)
		)));

		$this->wp_customize->add_setting('eooten_comment_show', array(
			'default' => 1,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control(
			$this->wp_customize,
			'eooten_comment_show',
			array(
				'label'       => esc_html_x('Show Global Page Comment', 'backend', 'eooten'),
				'description' => esc_html_x('Enable / Disable global page comments (not post comment).', 'backend', 'eooten'),
				'section'     => 'general',
				'settings'    => 'eooten_comment_show',
				'type'        => 'select',
				'choices'     => array(
					1 => esc_html_x('Yes', 'backend', 'eooten'),
					0 => esc_html_x('No', 'backend', 'eooten')
				)
			)
		));

		$this->wp_customize->add_setting('eooten_offcanvas_search', array(
			'default' => 1,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control(
			$this->wp_customize,
			'eooten_offcanvas_search',
			array(
				'label'       => esc_html_x('Offcanvas Search', 'backend', 'eooten'),
				'description' => esc_html_x('Enable / Disable Offcanvas search display', 'backend', 'eooten'),
				'section'     => 'general',
				'settings'    => 'eooten_offcanvas_search',
				'type'        => 'select',
				'choices'     => array(
					1 => esc_html_x('Yes', 'backend', 'eooten'),
					0 => esc_html_x('No', 'backend', 'eooten')
				)
			)
		));
		$this->wp_customize->add_setting('eooten_smooth_scroll', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control(
			$this->wp_customize,
			'eooten_smooth_scroll',
			array(
				'label'       => esc_html_x('Smooth Scroll', 'backend', 'eooten'),
				'description' => esc_html_x('Enable / Disable Smooth Scroll display', 'backend', 'eooten'),
				'section'     => 'general',
				'settings'    => 'eooten_smooth_scroll',
				'type'        => 'select',
				'choices'     => array(
					1 => esc_html_x('Yes', 'backend', 'eooten'),
					0 => esc_html_x('No', 'backend', 'eooten')
				)
			)
		));


		//titlebar section
		$this->wp_customize->add_section('titlebar', array(
			'title' => esc_html_x('Titlebar', 'backend', 'eooten'),
			'priority' => 32,
			'active_callback' => 'eooten_titlebar_check'
		));

		$this->wp_customize->add_setting('eooten_titlebar_layout', array(
			'default' => 'left',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_titlebar_layout', array(
			'label'    => esc_html_x('Titlebar Layout', 'backend', 'eooten'),
			'section'  => 'titlebar',
			'settings' => 'eooten_titlebar_layout',
			'type'     => 'select',
			'priority' => 1,
			'choices'  => array(
				'left'   => esc_html_x('Left Align', 'backend', 'eooten'),
				'center'  => esc_html_x('Center Align', 'backend', 'eooten'),
				'right'  => esc_html_x('Right Align', 'backend', 'eooten'),
				'notitle' => esc_html_x('No Titlebar', 'backend', 'eooten')
			)
		));


		$this->wp_customize->add_setting('eooten_titlebar_bg_style', array(
			'default' => 'muted',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_titlebar_bg_style', array(
			'label'    => esc_html_x('Background Style', 'backend', 'eooten'),
			'section'  => 'titlebar',
			'settings' => 'eooten_titlebar_bg_style',
			'type'     => 'select',
			'choices'  => array(
				'default'   => esc_html_x('Default', 'backend', 'eooten'),
				'muted'     => esc_html_x('Muted', 'backend', 'eooten'),
				'primary'   => esc_html_x('Primary', 'backend', 'eooten'),
				'secondary' => esc_html_x('Secondary', 'backend', 'eooten'),
				'media'     => esc_html_x('Image', 'backend', 'eooten'),
				//'video'     => esc_html_x('Video', 'backend', 'eooten'),
			)
		));


		$this->wp_customize->add_setting('eooten_titlebar_bg_img', array(
			'sanitize_callback' => 'esc_url'
		));
		$this->wp_customize->add_control(new WP_Customize_Image_Control($this->wp_customize, 'eooten_titlebar_bg_img', array(
			'label'           => esc_html_x('Background Image', 'backend', 'eooten'),
			'section'         => 'titlebar',
			'settings'        => 'eooten_titlebar_bg_img',
			'active_callback' => 'eooten_titlebar_bg_check',
		)));


		$this->wp_customize->add_setting('eooten_titlebar_txt_style', array(
			'default'           => 0,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_titlebar_txt_style', array(
			'label'    => esc_html_x('Text Color', 'backend', 'eooten'),
			'section'  => 'titlebar',
			'settings' => 'eooten_titlebar_txt_style',
			'type'     => 'select',
			'choices'  => array(
				0       => esc_html_x('Default', 'backend', 'eooten'),
				'light' => esc_html_x('Light', 'backend', 'eooten'),
				'dark'  => esc_html_x('Dark', 'backend', 'eooten'),
			)
		));


		$this->wp_customize->add_setting('eooten_titlebar_padding', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_titlebar_padding', array(
			'label'    => esc_html_x('Padding', 'backend', 'eooten'),
			'section'  => 'titlebar',
			'settings' => 'eooten_titlebar_padding',
			'type'     => 'select',
			'choices'  => array(
				0        => esc_html_x('Default', 'backend', 'eooten'),
				'medium' => esc_html_x('Medium', 'backend', 'eooten'),
				'small'  => esc_html_x('Small', 'backend', 'eooten'),
				'large'  => esc_html_x('Large', 'backend', 'eooten'),
				'none'   => esc_html_x('None', 'backend', 'eooten'),
			)
		));


		$this->wp_customize->add_setting('eooten_blog_title', array(
			'default' => esc_html_x('Blog', 'backend', 'eooten'),
			'sanitize_callback' => 'esc_attr'
		));
		$this->wp_customize->add_control('eooten_blog_title', array(
			'label'    => esc_html_x('Blog Title: ', 'backend', 'eooten'),
			'section'  => 'titlebar',
			'settings' => 'eooten_blog_title'
		));



		//blog section
		$this->wp_customize->add_section('blog', array(
			'title' => esc_html_x('Blog', 'backend', 'eooten'),
			'priority' => 35
		));


		$this->wp_customize->add_setting('eooten_blog_layout', array(
			'default' => 'sidebar-right',
			'sanitize_callback' => 'eooten_sanitize_choices',
		));
		$this->wp_customize->add_control(new eooten_Customize_Layout_Control(
			$this->wp_customize,
			'eooten_blog_layout',
			array(
				'label'       => esc_html_x('Blog Page Layout', 'backend', 'eooten'),
				'description' => esc_html_x('If you select static blog page so you need to select your blog page layout from here.', 'backend', 'eooten'),
				'section'     => 'blog',
				'settings'    => 'eooten_blog_layout',
				'type'        => 'layout',
				'choices' => array(
					"sidebar-left"  => esc_html_x('Sidebar Left', 'backend', 'eooten'),
					"full"          => esc_html_x('Fullwidth', 'backend', 'eooten'),
					"sidebar-right" => esc_html_x('Sidebar Right', 'backend', 'eooten'),
				),
				//'active_callback' => 'is_front_page',
			)
		));
		$this->wp_customize->add_setting('eooten_blog_posts_limit', array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'eooten_sanitize_number_absint',
			// 'default' => 1,
			'placeholder' => 10,
		));

		$this->wp_customize->add_control('eooten_blog_posts_limit', array(
			'type' => 'number',
			'section' => 'blog', // Add a default or your own section
			'label' => __('Blog Posts Limit Number', 'eooten'),
			'description' => __('Set the number of posts you want to show on the blog page. Leave blank to show all posts.', 'eooten'),
		));

		function eooten_sanitize_number_absint($number, $setting) {
			// Ensure $number is an absolute integer (whole number, zero or greater).
			$number = absint($number);

			// If the input is an absolute integer, return it; otherwise, return the default
			return ($number ? $number : $setting->default);
		}


		$this->wp_customize->add_setting('eooten_blog_readmore', array(
			'default' => 1,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control(
			$this->wp_customize,
			'eooten_blog_readmore',
			array(
				'label'       => esc_html_x('Read More Button in Blog Posts', 'backend', 'eooten'),
				'description' => esc_html_x('Enable / Disable read more button on blog posts.', 'backend', 'eooten'),
				'section'     => 'blog',
				'settings'    => 'eooten_blog_readmore',
				'type'        => 'select',
				'choices'     => array(
					1 => esc_html_x('Yes', 'backend', 'eooten'),
					0  => esc_html_x('No', 'backend', 'eooten')
				)
			)
		));

		$this->wp_customize->add_setting('eooten_blog_meta', array(
			'default' => 1,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control(
			$this->wp_customize,
			'eooten_blog_meta',
			array(
				'label'       => esc_html_x('Metadata on Blog Posts', 'backend', 'eooten'),
				'description' => esc_html_x('Enable / Disable metadata on blog post.', 'backend', 'eooten'),
				'section'     => 'blog',
				'settings'    => 'eooten_blog_meta',
				'type'        => 'select',
				'choices'     => array(
					1 => esc_html_x('Yes', 'backend', 'eooten'),
					0  => esc_html_x('No', 'backend', 'eooten')
				)
			)
		));

		$this->wp_customize->add_setting('eooten_blog_next_prev', array(
			'default' => 1,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control(
			$this->wp_customize,
			'eooten_blog_next_prev',
			array(
				'label'       => esc_html_x('Previous / Next Pagination', 'backend', 'eooten'),
				'description' => esc_html_x('Enable / Disable next previous button on blog posts.', 'backend', 'eooten'),
				'section'     => 'blog',
				'settings'    => 'eooten_blog_next_prev',
				'type'        => 'select',
				'choices'     => array(
					1 => esc_html_x('Yes', 'backend', 'eooten'),
					0  => esc_html_x('No', 'backend', 'eooten')
				)
			)
		));

		$this->wp_customize->add_setting('eooten_author_info', array(
			'default' => 1,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control(
			$this->wp_customize,
			'eooten_author_info',
			array(
				'label'       => esc_html_x('Author Info in Blog Details', 'backend', 'eooten'),
				'description' => esc_html_x('Enable / Disable author info from underneath of blog posts.', 'backend', 'eooten'),
				'section'     => 'blog',
				'settings'    => 'eooten_author_info',
				'type'        => 'select',
				'choices'     => array(
					1 => esc_html_x('Yes', 'backend', 'eooten'),
					0  => esc_html_x('No', 'backend', 'eooten')
				)
			)
		));

		$this->wp_customize->add_setting('eooten_blog_align', array(
			'default' => 'left',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_blog_align', array(
			'label'    => esc_html_x('Titlebar Layout', 'backend', 'eooten'),
			'section'  => 'blog',
			'settings' => 'eooten_blog_align',
			'type'     => 'select',
			'priority' => 1,
			'choices'  => array(
				'left'   => esc_html_x('Left Align', 'backend', 'eooten'),
				'center'  => esc_html_x('Center Align', 'backend', 'eooten'),
				'right'  => esc_html_x('Right Align', 'backend', 'eooten'),
			)
		));

		$this->wp_customize->add_setting('eooten_related_post', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control(
			$this->wp_customize,
			'eooten_related_post',
			array(
				'label'       => esc_html_x('Related Posts in Blog Details', 'backend', 'eooten'),
				'description' => esc_html_x('Enable / Disable related post underneath of blog posts.', 'backend', 'eooten'),
				'section'     => 'blog',
				'settings'    => 'eooten_related_post',
				'type'        => 'select',
				'choices'     => array(
					1 => esc_html_x('Yes', 'backend', 'eooten'),
					0  => esc_html_x('No', 'backend', 'eooten')
				)
			)
		));




		/**
		 * Layout Customizer Settings
		 */

		//Header section
		$this->wp_customize->add_section('header', array(
			'title' => esc_html_x('Header', 'backend', 'eooten'),
			'priority' => 31
		));


		$this->wp_customize->add_setting('eooten_header_layout', array(
			'default'           => 'default',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new eooten_Customize_Header_Layout_Control(
			$this->wp_customize,
			'eooten_header_layout',
			array(
				'label'    => esc_html_x('Header Layout', 'backend', 'eooten'),
				'description' => esc_html_x('Select header layout from here. This header layout for global usage but you can change it from your page setting for specific page.', 'backend', 'eooten'),
				'section'  => 'header',
				'settings' => 'eooten_header_layout',
				'type'     => 'layout_header',
				'choices'  => array(
					'default'      => esc_html_x('Default', 'backend', 'eooten'),
					'custom'       => esc_html_x('Custom Header', 'backend', 'eooten'),
				)
			)
		));


		$this->wp_customize->add_setting('eooten_custom_header', array(
			'default'           => 0,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control(
			$this->wp_customize,
			'eooten_custom_header',
			array(
				'label'           => esc_html_x('Custom Header', 'backend', 'eooten'),
				'description'     => esc_html_x('Select your custom header which you made in eooten custom template section by elementor.', 'backend', 'eooten'),
				'section'         => 'header',
				'settings'        => 'eooten_custom_header',
				'type'            => 'select',
				'choices'         => eooten_custom_template_list(),
				'active_callback' => 'eooten_custom_header_yes_check',
			)
		));




		$this->wp_customize->add_setting('eooten_header_fullwidth', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_checkbox'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_header_fullwidth', array(
			'label'       => esc_html_x('Header Fullwidth', 'backend', 'eooten'),
			'description' => esc_html_x('(Make your header full width like fluid width.)', 'backend', 'eooten'),
			'section'     => 'header',
			'settings'    => 'eooten_header_fullwidth',
			'type'        => 'checkbox',
			'active_callback' => 'eooten_header_layout_check',
		)));

		$this->wp_customize->add_setting('eooten_header_bg_style', array(
			'default'           => 'default',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_header_bg_style', array(
			'label'    => esc_html_x('Background Style', 'backend', 'eooten'),
			'section'  => 'header',
			'settings' => 'eooten_header_bg_style',
			'type'     => 'select',
			'choices'  => array(
				'default'   => esc_html_x('Default', 'backend', 'eooten'),
				'muted'     => esc_html_x('Muted', 'backend', 'eooten'),
				'primary'   => esc_html_x('Primary', 'backend', 'eooten'),
				'secondary' => esc_html_x('Secondary', 'backend', 'eooten'),
				'media'     => esc_html_x('Image', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_header_transparent_check',
		));

		$this->wp_customize->add_setting('eooten_header_bg_img', array(
			'sanitize_callback' => 'esc_url'
		));
		$this->wp_customize->add_control(new WP_Customize_Image_Control($this->wp_customize, 'eooten_header_bg_img', array(
			'label'           => esc_html_x('Background Image', 'backend', 'eooten'),
			'section'         => 'header',
			'settings'        => 'eooten_header_bg_img',
			'active_callback' => 'eooten_header_bg_style_check',
		)));

		$this->wp_customize->add_setting('eooten_header_bg_img_position', array(
			'default' => '',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_header_bg_img_position', array(
			'label'    => esc_html_x('Background Position', 'backend', 'eooten'),
			'section'  => 'header',
			'settings' => 'eooten_header_bg_img_position',
			'type'     => 'select',
			'choices'  => array(
				'top-left'      => esc_html_x('Top Left', 'backend', 'eooten'),
				'top-center'    => esc_html_x('Top Center', 'backend', 'eooten'),
				'top-right'     => esc_html_x('Top Right', 'backend', 'eooten'),
				'center-left'   => esc_html_x('Center Left', 'backend', 'eooten'),
				''              => esc_html_x('Center Center', 'backend', 'eooten'),
				'center-right'  => esc_html_x('Center Right', 'backend', 'eooten'),
				'bottom-left'   => esc_html_x('Bottom Left', 'backend', 'eooten'),
				'bottom-center' => esc_html_x('Bottom Center', 'backend', 'eooten'),
				'bottom-right'  => esc_html_x('Bottom Right', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_header_bg_img_check',
		)));

		$this->wp_customize->add_setting('eooten_header_txt_style', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_header_txt_style', array(
			'label'    => esc_html_x('Header Text Color', 'backend', 'eooten'),
			'section'  => 'header',
			'settings' => 'eooten_header_txt_style',
			'type'     => 'select',
			'choices'  => array(
				0       => esc_html_x('Default', 'backend', 'eooten'),
				'light' => esc_html_x('Light', 'backend', 'eooten'),
				'dark'  => esc_html_x('Dark', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_header_no_check',
		)));


		$this->wp_customize->add_setting('eooten_header_shadow', array(
			'default' => 'small',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_header_shadow', array(
			'label'    => esc_html_x('Shadow', 'backend', 'eooten'),
			'section'  => 'header',
			'settings' => 'eooten_header_shadow',
			'type'     => 'select',
			'choices'  => array(
				0          => esc_html_x('No Shadow', 'backend', 'eooten'),
				'small'    => esc_html_x('Small', 'backend', 'eooten'),
				'medium'   => esc_html_x('Medium', 'backend', 'eooten'),
				'large'    => esc_html_x('Large', 'backend', 'eooten'),
				'xlarge' => esc_html_x('Extra Large', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_header_no_check',
		));


		$this->wp_customize->add_setting('eooten_header_transparent', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_header_transparent', array(
			'label'    => esc_html_x('Header Transparent', 'backend', 'eooten'),
			'section'  => 'header',
			'settings' => 'eooten_header_transparent',
			'type'     => 'select',
			'choices'  => array(
				0       => esc_html_x('No', 'backend', 'eooten'),
				'light' => esc_html_x('Overlay (Light)', 'backend', 'eooten'),
				'dark'  => esc_html_x('Overlay (Dark)', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_header_layout_check',
		)));


		$this->wp_customize->add_setting('eooten_header_sticky', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_header_sticky', array(
			'label'    => esc_html_x('Header Sticky', 'backend', 'eooten'),
			'section'  => 'header',
			'settings' => 'eooten_header_sticky',
			'type'     => 'select',
			'choices'  => array(
				0        => esc_html_x('No', 'backend', 'eooten'),
				'sticky' => esc_html_x('Sticky', 'backend', 'eooten'),
				'smart'  => esc_html_x('Smart Sticky', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_header_layout_check',
		)));

		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'eooten_header_sticky_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'background-color' => array(
					'.bdt-navbar-container.bdt-sticky.bdt-active',
				),
			)
		)));


		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'eooten_header_sticky_color', array(
			'label'       => esc_html_x('Sticky Active Color', 'backend', 'eooten'),
			'section'     => 'header',
			'active_callback' => 'eooten_custom_header_no_check',
		)));



		$this->wp_customize->add_setting('eooten_navbar_style', array(
			'default' => 'style1',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_navbar_style', array(
			'label'    => esc_html_x('Main Menu Style', 'backend', 'eooten'),
			'section'  => 'header',
			'settings' => 'eooten_navbar_style',
			'type'     => 'select',
			'choices'  => array(
				'style1' => esc_html_x('Top Line', 'backend', 'eooten'),
				'style2' => esc_html_x('Bottom Line', 'backend', 'eooten'),
				'style3' => esc_html_x('Top Edge Line', 'backend', 'eooten'),
				'style4' => esc_html_x('Bottom Edge Line', 'backend', 'eooten'),
				'style5' => esc_html_x('Markar Mark', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_header_layout_check',
		)));


		$this->wp_customize->add_setting('eooten_search_position', array(
			'default' => 'header',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_search_position', array(
			'label'    => esc_html_x('Search', 'backend', 'eooten'),
			'description'    => esc_html_x('Select the position that will display the search.', 'backend', 'eooten'),
			'section'  => 'header',
			'settings' => 'eooten_search_position',
			'type'     => 'select',
			'choices'  => array(
				0        => esc_html_x('Hide', 'backend', 'eooten'),
				'header' => esc_html_x('Header', 'backend', 'eooten'),
				'menu'   => esc_html_x('With Menu', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_header_no_check',
		)));

		$this->wp_customize->add_setting('eooten_search_style', array(
			'default' => 'default',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_search_style', array(
			'label'       => esc_html_x('Search Style', 'backend', 'eooten'),
			'description' => esc_html_x('Select search style from here.', 'backend', 'eooten'),
			'section'     => 'header',
			'settings'    => 'eooten_search_style',
			'type'        => 'select',
			'choices'     => array(
				'default'  => esc_html_x('Default', 'backend', 'eooten'),
				'modal'    => esc_html_x('Modal', 'backend', 'eooten'),
				'dropdown' => esc_html_x('Dropdown', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_header_layout_check',
		)));

		$this->wp_customize->add_setting('eooten_mobile_offcanvas_style', array(
			'default' => 'offcanvas',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_mobile_offcanvas_style', array(
			'label'       => esc_html_x('Mobile Menu Style', 'backend', 'eooten'),
			'description' => 'Select the menu style displayed in the mobile position.',
			'section'     => 'header',
			'settings'    => 'eooten_mobile_offcanvas_style',
			'type'        => 'select',
			'choices'     => array(
				'offcanvas' => esc_html_x('Offcanvas', 'backend', 'eooten'),
				'modal'     => esc_html_x('Modal', 'backend', 'eooten'),
				'dropdown'  => esc_html_x('Dropdown', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_header_no_check',
		)));


		$this->wp_customize->add_setting('eooten_mobile_offcanvas_mode', array(
			'default' => 'slide',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_mobile_offcanvas_mode', array(
			'label'       => esc_html_x('Offcanvas Mode', 'backend', 'eooten'),
			'section'     => 'header',
			'settings'    => 'eooten_mobile_offcanvas_mode',
			'type'        => 'select',
			'choices'     => array(
				'slide'  => esc_html_x('Slide', 'backend', 'eooten'),
				'reveal' => esc_html_x('Reveal', 'backend', 'eooten'),
				'push'   => esc_html_x('Push', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_offcanvas_mode_check',
		)));


		$this->wp_customize->add_setting('eooten_mobile_break_point', array(
			'default' => 'm',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_mobile_break_point', array(
			'label'    => esc_html_x('Mobile Break Point', 'backend', 'eooten'),
			'section'  => 'header',
			'settings' => 'eooten_mobile_break_point',
			'type'     => 'select',
			'choices'  => array(
				's' => esc_html_x('Small', 'backend', 'eooten'),
				'm' => esc_html_x('Medium', 'backend', 'eooten'),
				'l' => esc_html_x('Large', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_header_no_check',
		)));


		$this->wp_customize->add_setting('eooten_mobile_menu_align', array(
			'default' => 'left',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_mobile_menu_align', array(
			'label'    => esc_html_x('Mobile Menu Align', 'backend', 'eooten'),
			'section'  => 'header',
			'settings' => 'eooten_mobile_menu_align',
			'type'     => 'select',
			'choices'  => array(
				''      => esc_html_x('Hide', 'backend', 'eooten'),
				'left'  => esc_html_x('Left', 'backend', 'eooten'),
				'right' => esc_html_x('Right', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_header_no_check',
		)));


		$this->wp_customize->add_setting('eooten_mobile_menu_text', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_checkbox'
		));
		$this->wp_customize->add_control('eooten_mobile_menu_text', array(
			'label'       => esc_html_x('Display the menu text next to the icon.', 'backend', 'eooten'),
			'section'     => 'header',
			'settings'    => 'eooten_mobile_menu_text',
			'type'        => 'checkbox',
			'active_callback' => 'eooten_custom_header_no_check',
		));




		// Main Body Settings
		$this->wp_customize->add_section('mainbody', array(
			'title'       => esc_html_x('Main Body', 'backend', 'eooten'),
			'description' => esc_html_x('Default body settings here.', 'backend', 'eooten'),
			'priority'    => 33
		));

		$this->wp_customize->add_setting('eooten_sidebar_position', array(
			'default' => 'sidebar-right',
			'sanitize_callback' => 'eooten_sanitize_choices',
		));
		$this->wp_customize->add_control(new eooten_Customize_Layout_Control(
			$this->wp_customize,
			'eooten_sidebar_position',
			array(
				'label'       => esc_html_x('Sidebar Layout', 'backend', 'eooten'),
				'description' => esc_html_x('Select global page sidebar position from here. If you already set any sidebar setting from specific page so it will not applicable for that page.', 'backend', 'eooten'),
				'section'     => 'mainbody',
				'settings'    => 'eooten_sidebar_position',
				'type'        => 'layout',
				'choices' => array(
					"sidebar-left"  => esc_html_x('Sidebar Left', 'backend', 'eooten'),
					"full"          => esc_html_x('No Sidebar', 'backend', 'eooten'),
					"sidebar-right" => esc_html_x('Sidebar Right', 'backend', 'eooten'),
				),
				'active_callback' => 'eooten_homepage_check',
			)
		));


		$this->wp_customize->add_setting('eooten_main_bg_style', array(
			'default' => 'default',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_main_bg_style', array(
			'label'    => esc_html_x('Background Style', 'backend', 'eooten'),
			'section'  => 'mainbody',
			'settings' => 'eooten_main_bg_style',
			'type'     => 'select',
			'choices'  => array(
				'default'   => esc_html_x('Default', 'backend', 'eooten'),
				'muted'     => esc_html_x('Muted', 'backend', 'eooten'),
				'primary'   => esc_html_x('Primary', 'backend', 'eooten'),
				'secondary' => esc_html_x('Secondary', 'backend', 'eooten'),
				'media'     => esc_html_x('Image', 'backend', 'eooten'),
			)
		));


		$this->wp_customize->add_setting('eooten_main_bg_img', array(
			'sanitize_callback' => 'esc_url'
		));
		$this->wp_customize->add_control(new WP_Customize_Image_Control($this->wp_customize, 'eooten_main_bg_img', array(
			'label'           => esc_html_x('Background Image', 'backend', 'eooten'),
			'section'         => 'mainbody',
			'settings'        => 'eooten_main_bg_img',
			'active_callback' => 'eooten_main_bg_check',
		)));

		$this->wp_customize->add_setting('eooten_main_txt_style', array(
			'default'           => 0,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_main_txt_style', array(
			'label'    => esc_html_x('Text Color', 'backend', 'eooten'),
			'section'  => 'mainbody',
			'settings' => 'eooten_main_txt_style',
			'type'     => 'select',
			'choices'  => array(
				0       => esc_html_x('Default', 'backend', 'eooten'),
				'light' => esc_html_x('Light', 'backend', 'eooten'),
				'dark'  => esc_html_x('Dark', 'backend', 'eooten'),
			)
		));

		$this->wp_customize->add_setting('eooten_sidebar_width', array(
			'default' => '1-4',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_sidebar_width', array(
			'label'    => esc_html_x('Sidebar Width', 'backend', 'eooten'),
			'description' => esc_html_x('Set a sidebar width in percent and the content column will adjust accordingly. The width will not go below the Sidebar\'s min-width, which you can set in the Style section.', 'backend', 'eooten'),
			'section'  => 'mainbody',
			'settings' => 'eooten_sidebar_width',
			'type'     => 'select',
			'choices'  => array(
				'1-5' => esc_html_x('20%', 'backend', 'eooten'),
				'1-4' => esc_html_x('25%', 'backend', 'eooten'),
				'1-3' => esc_html_x('33%', 'backend', 'eooten'),
				'2-5' => esc_html_x('40%', 'backend', 'eooten'),
				'1-2' => esc_html_x('50%', 'backend', 'eooten'),
			)
		));


		$this->wp_customize->add_setting('eooten_sidebar_gutter', array(
			'default' => 'large',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_sidebar_gutter', array(
			'label'    => esc_html_x('Gutter', 'backend', 'eooten'),
			'section'  => 'mainbody',
			'settings' => 'eooten_sidebar_gutter',
			'type'     => 'select',
			'choices'  => array(
				'small'    => esc_html_x('Small', 'backend', 'eooten'),
				'medium'   => esc_html_x('Medium', 'backend', 'eooten'),
				0          => esc_html_x('Default', 'backend', 'eooten'),
				'large'    => esc_html_x('Large', 'backend', 'eooten'),
				'collapse' => esc_html_x('Collapse', 'backend', 'eooten'),
			)
		));

		$this->wp_customize->add_setting('eooten_sidebar_divider', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_checkbox'
		));
		$this->wp_customize->add_control('eooten_sidebar_divider', array(
			'label'           => esc_html_x('Display dividers between body and sidebar', 'backend', 'eooten'),
			'description'     => esc_html_x('(Set the grid gutter width and display dividers between grid cells.)', 'backend', 'eooten'),
			'section'         => 'mainbody',
			'settings'        => 'eooten_sidebar_divider',
			'type'            => 'checkbox'
		));


		$this->wp_customize->add_setting('eooten_sidebar_breakpoint', array(
			'default' => 'm',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_sidebar_breakpoint', array(
			'label'       => esc_html_x('Breakpoint', 'backend', 'eooten'),
			'description' => esc_html_x('Set the breakpoint from which the sidebar and content will stack.', 'backend', 'eooten'),
			'section'     => 'mainbody',
			'settings'    => 'eooten_sidebar_breakpoint',
			'type'        => 'select',
			'choices'     => array(
				's'  => esc_html_x('Small (Phone Landscape)', 'backend', 'eooten'),
				'm'  => esc_html_x('Medium (Tablet Landscape)', 'backend', 'eooten'),
				'l'  => esc_html_x('Large (Desktop)', 'backend', 'eooten'),
				'xl' => esc_html_x('X-Large (Large Screens)', 'backend', 'eooten'),
			)
		));






		$this->wp_customize->add_setting('eooten_main_padding', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_main_padding', array(
			'label'    => esc_html_x('Padding', 'backend', 'eooten'),
			'section'  => 'mainbody',
			'settings' => 'eooten_main_padding',
			'type'     => 'select',
			'choices'  => array(
				0        => esc_html_x('Default', 'backend', 'eooten'),
				'small'  => esc_html_x('Small', 'backend', 'eooten'),
				'medium' => esc_html_x('Medium', 'backend', 'eooten'),
				'large'  => esc_html_x('Large', 'backend', 'eooten'),
				'none'   => esc_html_x('None', 'backend', 'eooten'),
			)
		));



		// Background image for body tag
		$this->wp_customize->add_setting(
			'eooten_bg_note',
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
		$this->wp_customize->add_control(
			new eooten_Customize_Alert_Control($this->wp_customize, 'eooten_bg_note', array(
				'label'       => 'Background Alert',
				'section'     => 'background_image',
				'settings'    => 'eooten_bg_note',
				'type'        => 'alert',
				'priority'    => 1,
				'text'        => esc_html_x('You must set your layout mode Boxed for use this feature. Otherwise you can\'t see what happening in background', 'backend', 'eooten'),
				'alert_type' => 'warning',
			))
		);

		$this->wp_customize->add_panel('colors', array(
			'title' => esc_html_x('Colors', 'backend', 'eooten'),
			'priority' => 45
		));

		$this->wp_customize->add_section('colors_global', array(
			'title' => esc_html_x('Global Colors', 'backend', 'eooten'),
			'panel' => 'colors',
		));

		$this->wp_customize->add_section('colors_button', array(
			'title' => esc_html_x('Button Colors', 'backend', 'eooten'),
			'panel' => 'colors',
		));

		$this->wp_customize->add_section('colors_header', array(
			'title' => esc_html_x('Header Colors', 'backend', 'eooten'),
			'panel' => 'colors',
		));

		$this->wp_customize->add_section('colors_menu', array(
			'title' => esc_html_x('Menu Colors', 'backend', 'eooten'),
			'panel' => 'colors',
		));

		$this->wp_customize->add_section('colors_offcanvas', array(
			'title' => esc_html_x('Offcanvas Colors', 'backend', 'eooten'),
			'panel' => 'colors',
		));

		$this->wp_customize->add_section('colors_footer', array(
			'title' => esc_html_x('Footer Colors', 'backend', 'eooten'),
			'panel' => 'colors',
		));

		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'background_color', array(
			'label'       => esc_html_x('Global Background Color', 'backend', 'eooten'),
			'section'     => 'colors_global',
			'description' => esc_html_x('Please select layout boxed for check your global page background.', 'backend', 'eooten'),
		)));


		// Add global color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'global_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'body',
				),
			)
		)));

		// Add global color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'global_color', array(
			'label'       => esc_html_x('Global Text Color', 'backend', 'eooten'),
			'section'     => 'colors_global',
		)));


		// Add global link color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'primary_background_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'background-color' => array(
					'.bdt-button-primary',
					'.bdt-section-primary',
					'.bdt-background-primary',
					'.bdt-card-primary',

				),
			)
		)));

		// Add global link color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'primary_background_color', array(
			'label'       => esc_html_x('Primary Background Color', 'backend', 'eooten'),
			'section'     => 'colors_global',
		)));


		// Add global link color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'primary_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'a',
					'.bdt-link',
					'.bdt-text-primary',
					'.bdt-alert-primary',
					'.we-are-open li div.bdt-width-expand span',
					'.woocommerce .star-rating span',
				),
				'border-color' => array(
					'.bdt-input:focus',
					'.bdt-select:focus',
					'.bdt-textarea:focus',
					'.tm-bottom.bdt-section-custom .bdt-button-default:hover',
				),
				'background-color' => array(
					'.bdt-label',
					'.bdt-subnav-pill > .bdt-active > a',
					'.tm-header .bdt-navbar-nav>li.bdt-active>a::before',
					'.tm-header .bdt-navbar-nav>li:hover>a::before',
					'.tm-header .bdt-navbar-nav>li>a:focus::before',
					'.tm-header .bdt-navbar-nav>li>a.bdt-open::before',
					'.tm-header .bdt-navbar-nav>li.bdt-active>a::after',
					'.tm-header .bdt-navbar-nav>li:hover>a::after',
					'.tm-header .bdt-navbar-nav>li>a:focus::after',
					'.tm-header .bdt-navbar-nav>li>a.bdt-open::after',
					'.tm-header:not(.bdt-light) .bdt-navbar-nav>li.bdt-active>a::before',
					'.tm-header:not(.bdt-light) .bdt-navbar-nav>li.bdt-active>a::after',
					'.tm-header .bdt-navbar-dropdown-nav>li.bdt-active>a:after',
					'.tm-header .bdt-navbar-dropdown ul.bdt-navbar-dropdown-nav ul li.bdt-active a:after',
					'[class*=\'navbar-style\'] .tm-header .bdt-navbar .bdt-navbar-nav > li:hover > a::before',
					'[class*=\'navbar-style\'] .tm-header .bdt-navbar .bdt-navbar-nav > li:hover > a::after',
					'.tm-header .bdt-navbar-dropdown ul.bdt-navbar-dropdown-nav li.bdt-parent > a:after',
				),
				'background-color|lighten(5)' => array(
					'.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle',
					'.woocommerce .widget_price_filter .ui-slider .ui-slider-handle',
				),
			)
		)));

		// Add global link color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'primary_color', array(
			'label'       => esc_html_x('Primary Color', 'backend', 'eooten'),
			'section'     => 'colors_global',
		)));



		// Add global link hover color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'primary_hover_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'a:hover',
					'.bdt-link:hover',
					'.bdt-text-primary:hover',
					'.bdt-alert-primary:hover',
				),
				'background-color' => array(
					'.tm-header .bdt-navbar-dropdown ul.bdt-navbar-dropdown-nav li.bdt-active > a:after',
					'[class*=\'navbar-style\'] .bdt-navbar .bdt-navbar-nav > li.bdt-active > a::before',
					'[class*=\'navbar-style\'] .bdt-navbar .bdt-navbar-nav > li.bdt-active > a::after',
				),
				'border-color' => array(),
			)
		)));

		// Add global link hover color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'primary_hover_color', array(
			'label'       => esc_html_x('Primary Hover Color', 'backend', 'eooten'),
			'section'     => 'colors_global',
		)));


		// Add secondary color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'secondary_background_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'background-color' => array(
					'.bdt-button-secondary',
					'.bdt-section-secondary',
					'.bdt-background-secondary',
					'.bdt-card-secondary',
				),
			)
		)));

		// Add secondary color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'secondary_background_color', array(
			'label'       => esc_html_x('Secondary Background Color', 'backend', 'eooten'),
			'section'     => 'colors_global',
		)));


		// Add secondary color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'secondary_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.bdt-text-secondary',
					'.bdt-alert-secondary',
				),
			)
		)));

		// Add secondary color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'secondary_color', array(
			'label'       => esc_html_x('Secondary Color', 'backend', 'eooten'),
			'section'     => 'colors_global',
		)));


		// Add muted color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'muted_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.bdt-text-muted',
					'.bdt-alert-muted',
				),
			)
		)));

		// Add muted color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'muted_color', array(
			'label'       => esc_html_x('Muted Text Color', 'backend', 'eooten'),
			'section'     => 'colors_global',
		)));

		// Add muted color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'muted_background_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'background-color' => array(
					'.bdt-button-muted',
					'.bdt-section-muted',
					'.bdt-background-muted',
					'.bdt-card-muted',
				),
			)
		)));

		// Add muted color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'muted_background_color', array(
			'label'       => esc_html_x('Muted Background Color', 'backend', 'eooten'),
			'section'     => 'colors_global',
		)));


		// Add button default color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'button_default_background_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'background-color' => array(
					'.bdt-button-default',
				),
				'background-color|lighten(5)' => array(
					'.bdt-button-default:hover',
				),
			)
		)));

		// Add button default color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'button_default_background_color', array(
			'label'       => esc_html_x('Default Background Color', 'backend', 'eooten'),
			'section'     => 'colors_button',
		)));


		// Add button default color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'button_default_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.bdt-button-default',
				),
				'color|lighten(5)' => array(
					'.bdt-button-default:hover',
				),
			)
		)));

		// Add button default color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'button_default_color', array(
			'label'       => esc_html_x('Default Color', 'backend', 'eooten'),
			'section'     => 'colors_button',
		)));


		// Add button primary color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'button_primary_background_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'background-color' => array(
					'.bdt-button-primary',
					'.bdt-button-primary:active',
					'.bdt-button-primary.bdt-active',
					'.bdt-button-primary:focus',
				),
				'background-color|lighten(5)' => array(
					'.bdt-button-primary:hover',
				),
			)
		)));

		// Add button primary color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'button_primary_background_color', array(
			'label'       => esc_html_x('Primary Background Color', 'backend', 'eooten'),
			'section'     => 'colors_button',
		)));


		// Add button primary color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'button_primary_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.bdt-button-primary',
				),
				'color|lighten(5)' => array(
					'.bdt-button-primary:hover',
				),
			)
		)));

		// Add button primary color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'button_primary_color', array(
			'label'       => esc_html_x('Primary Color', 'backend', 'eooten'),
			'section'     => 'colors_button',
		)));


		// Add button secondary color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'button_secondary_background_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'background-color' => array(
					'.bdt-button-secondary',
				),
				'background-color|lighten(5)' => array(
					'.bdt-button-secondary:hover',
				),
			)
		)));

		// Add button secondary color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'button_secondary_background_color', array(
			'label'       => esc_html_x('Secondary Background Color', 'backend', 'eooten'),
			'section'     => 'colors_button',
		)));


		// Add button secondary color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'button_secondary_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.bdt-button-secondary',
				),
				'color|lighten(5)' => array(
					'.bdt-button-secondary:hover',
				),
			)
		)));

		// Add button secondary color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'button_secondary_color', array(
			'label'       => esc_html_x('Secondary Color', 'backend', 'eooten'),
			'section'     => 'colors_button',
		)));


		// Add button danger color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'button_danger_background_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'background-color' => array(
					'.bdt-button-danger',
				),
				'background-color|lighten(5)' => array(
					'.bdt-button-danger:hover',
				),
			)
		)));

		// Add button danger color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'button_danger_background_color', array(
			'label'       => esc_html_x('Danger Background Color', 'backend', 'eooten'),
			'section'     => 'colors_button',
		)));


		// Add button danger color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'button_danger_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.bdt-button-danger',
				),
				'color|lighten(5)' => array(
					'.bdt-button-danger:hover',
				),
			)
		)));

		// Add button danger color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'button_muted_color', array(
			'label'       => esc_html_x('Danger Color', 'backend', 'eooten'),
			'section'     => 'colors_button',
		)));

		// Add page background color setting and control.
		$this->wp_customize->add_setting('browser_header_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
		));

		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'browser_header_color', array(
			'label'       => esc_html_x('Browser Header Color', 'backend', 'eooten'),
			'section'     => 'colors_global',
			'description' => esc_html_x('This color for mobile browser header. This color works only mobile view.', 'backend', 'eooten'),
		)));



		/**
		 * Footer Customizer Settings
		 */

		// footer appearance
		$this->wp_customize->add_section('footer', array(
			'title' => esc_html_x('Footer', 'backend', 'eooten'),
			'description' => esc_html_x('All Eooten theme specific settings.', 'backend', 'eooten'),
			'priority' => 140
		));

		$this->wp_customize->add_setting('eooten_footer_widgets', array(
			'default' => 1,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control(
			$this->wp_customize,
			'eooten_footer_widgets',
			array(
				'priority'    => 1,
				'label'       => esc_html_x('Footer Widgets', 'backend', 'eooten'),
				'section'     => 'footer',
				'settings'    => 'eooten_footer_widgets',
				'type'        => 'select',
				'choices'     => array(
					1        => esc_html_x('Default', 'backend', 'eooten'),
					0        => esc_html_x('Hide', 'backend', 'eooten'),
					'custom' => esc_html_x('Custom Footer', 'backend', 'eooten')
				)
			)
		));


		$this->wp_customize->add_setting('eooten_custom_footer', array(
			'default'           => 0,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control(
			$this->wp_customize,
			'eooten_custom_footer',
			array(
				'label'    => esc_html_x('Custom Footer', 'backend', 'eooten'),
				'description' => esc_html_x('Select your custom footer which you made in eooten custom template section by elementor.', 'backend', 'eooten'),
				'section'  => 'footer',
				'settings' => 'eooten_custom_footer',
				'type'     => 'select',
				'choices'  => eooten_custom_template_list('footer'),
				'active_callback' => 'eooten_custom_footer_yes_check',
			)
		));


		$this->wp_customize->add_setting('eooten_footer_columns', array(
			'default' => 4,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_footer_columns', array(
			'label'           => esc_html_x('Footer Columns:', 'backend', 'eooten'),
			'section'         => 'footer',
			'settings'        => 'eooten_footer_columns',
			'type'            => 'select',
			'choices'         => array(
				1 => esc_html_x('1 Column', 'backend', 'eooten'),
				2 => esc_html_x('2 Columns', 'backend', 'eooten'),
				3 => esc_html_x('3 Columns', 'backend', 'eooten'),
				4 => esc_html_x('4 Columns', 'backend', 'eooten')
			),
			'active_callback' => 'eooten_custom_footer_no_check',
		));

		$this->wp_customize->add_setting('eooten_footer_fce', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_checkbox'
		));
		$this->wp_customize->add_control('eooten_footer_fce', array(
			'label'       => esc_html_x('First Column Double Width', 'backend', 'eooten'),
			'description' => esc_html_x('some times your need first footer column double size so you can checked it.', 'backend', 'eooten'),
			'section'     => 'footer',
			'settings'    => 'eooten_footer_fce',
			'type'        => 'checkbox',
			'active_callback' => 'eooten_custom_footer_no_check',
		));

		// Add dropdown background color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'menu_link_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.tm-header .bdt-navbar-nav > li > a',
				),
			)
		)));

		// Add dropdown background color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'menu_link_color', array(
			'label'       => esc_html_x('Menu Link Color', 'backend', 'eooten'),
			'section'     => 'colors_menu',
		)));


		// Add dropdown background color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'menu_link_hover_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.tm-header .bdt-navbar-nav > li:hover > a',
				),
			)
		)));

		// Add dropdown background color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'menu_link_hover_color', array(
			'label'       => esc_html_x('Menu Hover Color', 'backend', 'eooten'),
			'section'     => 'colors_menu',
		)));


		// Add menu active color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'menu_link_active_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.tm-header .bdt-navbar-nav > li.bdt-active > a',
				),
			)
		)));

		// Add menu active color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'menu_link_active_color', array(
			'label'       => esc_html_x('Menu Active Color', 'backend', 'eooten'),
			'section'     => 'colors_menu',
		)));


		// Add style active color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'menu_style_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'background-color' => array(
					'.navbar-style2 .tm-header .bdt-navbar .bdt-navbar-nav > li.bdt-active > a::after',
					'.navbar-style4 .tm-header .bdt-navbar .bdt-navbar-nav > li.bdt-active > a::after',
				),
			)
		)));

		// Add style active color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'menu_style_color', array(
			'label'       => esc_html_x('Menu Style Color', 'backend', 'eooten'),
			'section'     => 'colors_menu',
		)));


		// Add dropdown background color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'dropdown_background_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'background-color' => array(
					'.tm-header .bdt-navbar-dropbar',
					'.tm-header .bdt-navbar-dropdown:not(.bdt-navbar-dropdown-dropbar)',
					'.tm-header .bdt-navbar-dropdown:not(.bdt-navbar-dropdown-dropbar) .sub-dropdown>ul',
				),
			)
		)));

		// Add dropdown background color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'dropdown_background_color', array(
			'label'       => esc_html_x('Dropdown Background Color', 'backend', 'eooten'),
			'section'     => 'colors_menu',
		)));


		// Add dropdown link color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'dropdown_link_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.tm-header .bdt-navbar-dropdown-nav>li>a',
					'.tm-header .bdt-nav li>a',
					'.tm-header .bdt-navbar-dropdown-nav .bdt-nav-sub a',
				),
			)
		)));

		// Add dropdown link color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'dropdown_link_color', array(
			'label'       => esc_html_x('Dropdown Link Color', 'backend', 'eooten'),
			'section'     => 'colors_menu',
		)));


		// Add dropdown link hover color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'dropdown_link_hover_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.tm-header .bdt-navbar-dropdown ul.bdt-navbar-dropdown-nav li > a:hover',
					'.tm-header .bdt-navbar-dropdown ul.bdt-navbar-dropdown-nav li > a:focus',
					'.tm-header .bdt-navbar-dropdown-nav .bdt-nav-sub a:hover',
					'.tm-header .bdt-navbar-dropdown-nav .bdt-nav-sub a:focus',
					'.tm-header .bdt-navbar-dropdown-nav li.bdt-active > a',
					'.tm-header .bdt-navbar-dropdown .sub-dropdown > ul li.bdt-active > a',
				),
			)
		)));

		// Add dropdown link hover color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'dropdown_link_hover_color', array(
			'label'       => esc_html_x('Dropdown Link Hover Color', 'backend', 'eooten'),
			'section'     => 'colors_menu',
		)));

		// Add dropdown link hover color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'dropdown_link_active_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.tm-header .bdt-navbar-dropdown ul.bdt-navbar-dropdown-nav li.bdt-active > a',
					'.tm-header .bdt-navbar-dropdown ul.bdt-navbar-dropdown-nav li.bdt-active > a',
					'.tm-header .bdt-navbar-dropdown .sub-dropdown > ul li.bdt-active > a',
				),
			)
		)));

		// Add dropdown link hover color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'dropdown_link_active_color', array(
			'label'       => esc_html_x('Dropdown Link Active Color', 'backend', 'eooten'),
			'section'     => 'colors_menu',
		)));


		// Add offcanvas background color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'offcanvas_background_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'background-color' => array(
					'.bdt-offcanvas-bar',
				),
			)
		)));
		// Add offcanvas background color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'offcanvas_background_color', array(
			'label'       => esc_html_x('Offcanvas Background Color', 'backend', 'eooten'),
			'section'     => 'colors_offcanvas',
		)));


		// Add offcanvas text color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'offcanvas_text_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.bdt-offcanvas-bar',
					'.bdt-offcanvas-bar .bdt-search-input',
					'.bdt-offcanvas-bar .bdt-search-icon.bdt-icon',
					'.bdt-offcanvas-bar .bdt-search-input::placeholder',
				),
			)
		)));
		// Add offcanvas text color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'offcanvas_text_color', array(
			'label'           => esc_html_x('Text Color', 'backend', 'eooten'),
			'section'         => 'colors_offcanvas',
		)));


		// Add offcanvas link color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'offcanvas_link_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.bdt-offcanvas-bar .bdt-icon',
					'.bdt-offcanvas-bar #nav-offcanvas li a',
				),
			)
		)));
		// Add offcanvas link color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'offcanvas_link_color', array(
			'label'           => esc_html_x('Link Color', 'backend', 'eooten'),
			'section'         => 'colors_offcanvas',
		)));


		// Add offcanvas link active color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'offcanvas_link_active_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.bdt-offcanvas-bar #nav-offcanvas li.bdt-active a',
				),
			)
		)));
		// Add offcanvas link active color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'offcanvas_link_active_color', array(
			'label'           => esc_html_x('Link Active Color', 'backend', 'eooten'),
			'section'         => 'colors_offcanvas',
		)));


		// Add offcanvas link hover color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'offcanvas_link_hover_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.bdt-offcanvas-bar .bdt-icon:hover',
					'.bdt-offcanvas-bar #nav-offcanvas li a:hover',
				),
			)
		)));
		// Add offcanvas link hover color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'offcanvas_link_hover_color', array(
			'label'           => esc_html_x('Link Hover Color', 'backend', 'eooten'),
			'section'         => 'colors_offcanvas',
		)));


		// Add offcanvas border color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'offcanvas_border_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'border-color' => array(
					'.bdt-offcanvas-bar .offcanvas-search .bdt-search .bdt-search-input',
					'.bdt-offcanvas-bar hr',
				),
			)
		)));
		// Add offcanvas border color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'offcanvas_border_color', array(
			'label'           => esc_html_x('Border Color', 'backend', 'eooten'),
			'section'         => 'colors_offcanvas',
		)));


		// Bottom bg style setting
		$this->wp_customize->add_setting('eooten_bottom_bg_style', array(
			'default' => 'secondary',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));

		$this->wp_customize->add_control('eooten_bottom_bg_style', array(
			'label'    => esc_html_x('Background Style', 'backend', 'eooten'),
			'section'  => 'footer',
			'settings' => 'eooten_bottom_bg_style',
			'type'     => 'select',
			'choices'  => array(
				'default'   => esc_html_x('Default', 'backend', 'eooten'),
				'muted'     => esc_html_x('Muted', 'backend', 'eooten'),
				'primary'   => esc_html_x('Primary', 'backend', 'eooten'),
				'secondary' => esc_html_x('Secondary', 'backend', 'eooten'),
				'media'     => esc_html_x('Image', 'backend', 'eooten'),
				'custom'    => esc_html_x('Custom Color', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_footer_no_check',
		));

		// Add footer background color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'bottom_background_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'background-color' => array(
					'.tm-bottom.bdt-section-custom',
				),
				'border-color|lighten(5)' => array(
					'.tm-bottom.bdt-section-custom .bdt-grid-divider > :not(.bdt-first-column)::before',
					'.tm-bottom.bdt-section-custom hr',
					'.tm-bottom.bdt-section-custom .bdt-hr',
					'.tm-bottom.bdt-section-custom .bdt-grid-divider.bdt-grid-stack>.bdt-grid-margin::before',
				),
				'background-color|lighten(2)' => array(
					'.tm-bottom.bdt-section-custom .widget_tag_cloud a',
				),
			)
		)));

		// Add footer background color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'bottom_background_color', array(
			'label'           => esc_html_x('Custom Background Color', 'backend', 'eooten'),
			'section'         => 'footer',
			'active_callback' => 'eooten_bottom_bg_custom_color_check',
		)));


		$this->wp_customize->add_setting('eooten_bottom_bg_img', array(
			'sanitize_callback' => 'esc_url'
		));
		$this->wp_customize->add_control(new WP_Customize_Image_Control($this->wp_customize, 'eooten_bottom_bg_img', array(
			'label'    => esc_html_x('Background Image', 'backend', 'eooten'),
			'section'  => 'footer',
			'settings' => 'eooten_bottom_bg_img',
			'active_callback' => 'eooten_bottom_bg_style_check',
		)));


		$this->wp_customize->add_setting('eooten_bottom_bg_img_position', array(
			'default' => '',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_bottom_bg_img_position', array(
			'label'    => esc_html_x('Background Position', 'backend', 'eooten'),
			'description' => esc_html_x('Set the initial background position, relative to the section layer.', 'backend', 'eooten'),
			'section'  => 'footer',
			'settings' => 'eooten_bottom_bg_img_position',
			'type'     => 'select',
			'choices'  => array(
				'top-left'      => esc_html_x('Top Left', 'backend', 'eooten'),
				'top-center'    => esc_html_x('Top Center', 'backend', 'eooten'),
				'top-right'     => esc_html_x('Top Right', 'backend', 'eooten'),
				'center-left'   => esc_html_x('Center Left', 'backend', 'eooten'),
				''              => esc_html_x('Center Center', 'backend', 'eooten'),
				'center-right'  => esc_html_x('Center Right', 'backend', 'eooten'),
				'bottom-left'   => esc_html_x('Bottom Left', 'backend', 'eooten'),
				'bottom-center' => esc_html_x('Bottom Center', 'backend', 'eooten'),
				'bottom-right'  => esc_html_x('Bottom Right', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_bottom_bg_img_check',
		)));

		$this->wp_customize->add_setting('eooten_bottom_bg_img_fixed', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_checkbox'
		));
		$this->wp_customize->add_control('eooten_bottom_bg_img_fixed', array(
			'label'           => esc_html_x('Fix the background with regard to the viewport.', 'backend', 'eooten'),
			'section'         => 'footer',
			'settings'        => 'eooten_bottom_bg_img_fixed',
			'type'            => 'checkbox',
			'active_callback' => 'eooten_bottom_bg_img_check',
		));

		$this->wp_customize->add_setting('eooten_bottom_bg_img_visibility', array(
			'default' => 'm',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_bottom_bg_img_visibility', array(
			'label'       => esc_html_x('Background Visibility', 'backend', 'eooten'),
			'description' => esc_html_x('Display the image only on this device width and larger.', 'backend', 'eooten'),
			'section'     => 'footer',
			'settings'    => 'eooten_bottom_bg_img_visibility',
			'type'        => 'select',
			'choices'     => array(
				's'  => esc_html_x('Small (Phone Landscape)', 'backend', 'eooten'),
				'm'  => esc_html_x('Medium (Tablet Landscape)', 'backend', 'eooten'),
				'l'  => esc_html_x('Large (Desktop)', 'backend', 'eooten'),
				'xl' => esc_html_x('X-Large (Large Screens)', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_bottom_bg_img_check',
		));


		$this->wp_customize->add_setting('eooten_bottom_txt_style', array(
			'default'           => 0,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_bottom_txt_style', array(
			'label'    => esc_html_x('Text Color', 'backend', 'eooten'),
			'section'  => 'footer',
			'settings' => 'eooten_bottom_txt_style',
			'type'     => 'select',
			'choices'  => array(
				0        => esc_html_x('Default', 'backend', 'eooten'),
				'light'  => esc_html_x('Light', 'backend', 'eooten'),
				'dark'   => esc_html_x('Dark', 'backend', 'eooten'),
				'custom' => esc_html_x('Custom', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_footer_no_check',
		));

		// Add footer text color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'footer_text_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'color' => array(
					'.tm-bottom.bdt-section-custom',
					'.tm-bottom a',
					'.tm-bottom .bdt-link',
					'.tm-bottom .bdt-text-primary',
					'.tm-bottom .bdt-alert-primary',
				),
				'color|lighten(30)' => array(
					'.tm-bottom.bdt-section-custom .bdt-card-title',
					'.tm-bottom.bdt-section-custom h3',
					'.tm-bottom a:hover',
					'.tm-bottom .bdt-link:hover',
					'.tm-bottom .bdt-text-primary:hover',
					'.tm-bottom .bdt-alert-primary:hover',
				),
				'color|darken(5)' => array(
					'.tm-bottom.bdt-section-custom .widget_tag_cloud a',
				),
				'border-color' => array(
					'.tm-bottom.bdt-section-custom .bdt-button-default',
				),
			)
		)));

		// Add footer text color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'footer_text_color', array(
			'label'       => esc_html_x('Custom Text Color', 'backend', 'eooten'),
			'section'     => 'footer',
			'active_callback' => 'eooten_bottom_txt_custom_color_check'
		)));


		$this->wp_customize->add_setting('eooten_bottom_width', array(
			'default' => 'default',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_bottom_width', array(
			'label'    => esc_html_x('Width', 'backend', 'eooten'),
			'section'  => 'footer',
			'settings' => 'eooten_bottom_width',
			'type'     => 'select',
			'choices'  => array(
				'default' => esc_html_x('Default', 'backend', 'eooten'),
				'small'   => esc_html_x('Small', 'backend', 'eooten'),
				'large'   => esc_html_x('Large', 'backend', 'eooten'),
				'expand'  => esc_html_x('Expand', 'backend', 'eooten'),
				0        => esc_html_x('Full', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_footer_no_check',
		));


		$this->wp_customize->add_setting('eooten_bottom_padding', array(
			'default' => 'medium',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_bottom_padding', array(
			'label'    => esc_html_x('Padding', 'backend', 'eooten'),
			'section'  => 'footer',
			'settings' => 'eooten_bottom_padding',
			'type'     => 'select',
			'choices'  => array(
				0 		 => esc_html_x('Default', 'backend', 'eooten'),
				'small'  => esc_html_x('Small', 'backend', 'eooten'),
				'medium' => esc_html_x('Medium', 'backend', 'eooten'),
				'large'  => esc_html_x('Large', 'backend', 'eooten'),
				'none'   => esc_html_x('None', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_footer_no_check',
		));

		$this->wp_customize->add_setting('eooten_bottom_gutter', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_bottom_gutter', array(
			'label'    => esc_html_x('Gutter', 'backend', 'eooten'),
			'section'  => 'footer',
			'settings' => 'eooten_bottom_gutter',
			'type'     => 'select',
			'choices'  => array(
				'small'    => esc_html_x('Small', 'backend', 'eooten'),
				'medium'   => esc_html_x('Medium', 'backend', 'eooten'),
				0          => esc_html_x('Default', 'backend', 'eooten'),
				'large'    => esc_html_x('Large', 'backend', 'eooten'),
				'collapse' => esc_html_x('Collapse', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_footer_no_check',
		));



		$this->wp_customize->add_setting('eooten_bottom_column_divider', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_checkbox'
		));
		$this->wp_customize->add_control('eooten_bottom_column_divider', array(
			'label'           => esc_html_x('Display dividers between grid cells', 'backend', 'eooten'),
			'description'     => esc_html_x('(Set the grid gutter width and display dividers between grid cells.)', 'backend', 'eooten'),
			'section'         => 'footer',
			'settings'        => 'eooten_bottom_column_divider',
			'active_callback' => 'eooten_bottom_gutter_collapse_check',
			'type'            => 'checkbox'
		));

		$this->wp_customize->add_setting('eooten_bottom_vertical_align', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_checkbox'
		));
		$this->wp_customize->add_control('eooten_bottom_vertical_align', array(
			'label'       => esc_html_x('Vertically center grid cells.', 'backend', 'eooten'),
			'section'     => 'footer',
			'settings'    => 'eooten_bottom_vertical_align',
			'type'        => 'checkbox',
			'active_callback' => 'eooten_custom_footer_no_check',
		));


		$this->wp_customize->add_setting('eooten_bottom_match_height', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_checkbox'
		));
		$this->wp_customize->add_control('eooten_bottom_match_height', array(
			'label'       => esc_html_x('Stretch the panel to match the height of the grid cell.', 'backend', 'eooten'),
			'section'     => 'footer',
			'settings'    => 'eooten_bottom_match_height',
			'type'        => 'checkbox',
			'active_callback' => 'eooten_custom_footer_no_check',
		));

		$this->wp_customize->add_setting('eooten_bottom_breakpoint', array(
			'default' => 'm',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_bottom_breakpoint', array(
			'label'       => esc_html_x('Breakpoint', 'backend', 'eooten'),
			'description' => esc_html_x('Set the breakpoint from which grid cells will stack.', 'backend', 'eooten'),
			'section'     => 'footer',
			'settings'    => 'eooten_bottom_breakpoint',
			'type'        => 'select',
			'choices'     => array(
				's'  => esc_html_x('Small (Phone Landscape)', 'backend', 'eooten'),
				'm'  => esc_html_x('Medium (Tablet Landscape)', 'backend', 'eooten'),
				'l'  => esc_html_x('Large (Desktop)', 'backend', 'eooten'),
				'xl' => esc_html_x('X-Large (Large Screens)', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_footer_no_check',
		));

		// Copyright Section
		$this->wp_customize->add_section('copyright', array(
			'title' => esc_html_x('Copyright', 'backend', 'eooten'),
			'description' => esc_html_x('Copyright section settings here.', 'backend', 'eooten'),
			'priority' => 142
		));


		$this->wp_customize->add_setting('eooten_copyright_bg_style', array(
			'default' => 'secondary',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_copyright_bg_style', array(
			'label'    => esc_html_x('Background Style', 'backend', 'eooten'),
			'section'  => 'copyright',
			'settings' => 'eooten_copyright_bg_style',
			'type'     => 'select',
			'choices'  => array(
				'default'   => esc_html_x('Default', 'backend', 'eooten'),
				'muted'     => esc_html_x('Muted', 'backend', 'eooten'),
				'primary'   => esc_html_x('Primary', 'backend', 'eooten'),
				'secondary' => esc_html_x('Secondary', 'backend', 'eooten'),
				'media'     => esc_html_x('Image', 'backend', 'eooten'),
				'custom'    => esc_html_x('Custom Color', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_footer_no_check',
		));


		// Add footer background color setting.
		$this->wp_customize->add_setting(new Eooten_Customizer_Dynamic_CSS($this->wp_customize, 'eooten_copyright_background_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
			'css_map' => array(
				'background-color' => array(
					'.tm-copyright.bdt-section-custom',
				),
			)
		)));

		// Add footer background color control.
		$this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'eooten_copyright_background_color', array(
			'label'           => esc_html_x('Custom Background Color', 'backend', 'eooten'),
			'section'         => 'copyright',
			'active_callback' => 'eooten_copyright_bg_custom_color_check',
		)));


		$this->wp_customize->add_setting('eooten_copyright_bg_img', array(
			'sanitize_callback' => 'esc_url'
		));
		$this->wp_customize->add_control(new WP_Customize_Image_Control($this->wp_customize, 'eooten_copyright_bg_img', array(
			'label'    => esc_html_x('Background Image', 'backend', 'eooten'),
			'section'  => 'copyright',
			'settings' => 'eooten_copyright_bg_img',
			'active_callback' => 'eooten_copyright_bg_style_check',
		)));


		$this->wp_customize->add_setting('eooten_copyright_txt_style', array(
			'default'           => 'light',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_copyright_txt_style', array(
			'label'    => esc_html_x('Text Color', 'backend', 'eooten'),
			'section'  => 'copyright',
			'settings' => 'eooten_copyright_txt_style',
			'type'     => 'select',
			'choices'  => array(
				0       => esc_html_x('Default', 'backend', 'eooten'),
				'light' => esc_html_x('Light', 'backend', 'eooten'),
				'dark'  => esc_html_x('Dark', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_footer_no_check',
		));

		$this->wp_customize->add_setting('eooten_copyright_width', array(
			'default' => 'default',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_copyright_width', array(
			'label'    => esc_html_x('Width', 'backend', 'eooten'),
			'section'  => 'copyright',
			'settings' => 'eooten_copyright_width',
			'type'     => 'select',
			'choices'  => array(
				'default' => esc_html_x('Default', 'backend', 'eooten'),
				'small'   => esc_html_x('Small', 'backend', 'eooten'),
				'large'   => esc_html_x('Large', 'backend', 'eooten'),
				'expand'  => esc_html_x('Expand', 'backend', 'eooten'),
				0        => esc_html_x('Full', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_footer_no_check',
		));

		$this->wp_customize->add_setting('eooten_copyright_align', array(
			'default' => 'left',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_copyright_align', array(
			'label'    => esc_html_x('Alignment', 'backend', 'eooten'),
			'section'  => 'copyright',
			'settings' => 'eooten_copyright_align',
			'type'     => 'select',
			'choices'  => array(
				'left' => esc_html_x('Left', 'backend', 'eooten'),
				'center'   => esc_html_x('Center', 'backend', 'eooten'),
				'right'   => esc_html_x('Right', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_footer_no_check',
		));


		$this->wp_customize->add_setting('eooten_copyright_padding', array(
			'default' => 'small',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_copyright_padding', array(
			'label'    => esc_html_x('Padding', 'backend', 'eooten'),
			'section'  => 'copyright',
			'settings' => 'eooten_copyright_padding',
			'type'     => 'select',
			'choices'  => array(
				'small'  => esc_html_x('Small', 'backend', 'eooten'),
				'medium' => esc_html_x('Medium', 'backend', 'eooten'),
				'large'  => esc_html_x('Large', 'backend', 'eooten'),
				'none'   => esc_html_x('None', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_custom_footer_no_check',
		));



		$this->wp_customize->add_setting('eooten_copyright_text_custom_show', array(
			'default' => 0,
			'sanitize_callback' => 'eooten_sanitize_checkbox'
		));
		$this->wp_customize->add_control(new WP_Customize_Control(
			$this->wp_customize,
			'eooten_copyright_text_custom_show',
			array(
				'label'    => esc_html_x('Show Custom Copyright Text', 'backend', 'eooten'),
				'section'  => 'copyright',
				'settings' => 'eooten_copyright_text_custom_show',
				'type'     => 'checkbox',
				'active_callback' => 'eooten_custom_footer_no_check',
			)
		));

		//copyright Content
		$this->wp_customize->add_setting('eooten_copyright_text_custom', array(
			'default'           => 'Theme Designed by <a href="' . esc_url(esc_html_x('https://www.linkedin.com/in/malikihtashamgw/', 'backend', 'eooten')) . ' ">Malik Ihtasham</a>',
			'sanitize_callback' => 'eooten_sanitize_textarea'
		));
		$this->wp_customize->add_control(new eooten_Customize_Textarea_Control($this->wp_customize, 'eooten_copyright_text_custom', array(
			'label'           => esc_html_x('Copyright Text', 'backend', 'eooten'),
			'section'         => 'copyright',
			'settings'        => 'eooten_copyright_text_custom',
			'active_callback' => 'eooten_copyright_text_custom_show_check',
			'type'            => 'textarea',
		)));


		// Copyright Section
		$this->wp_customize->add_section('totop', array(
			'title' => esc_html_x('Go To Top', 'backend', 'eooten'),
			'description' => esc_html_x('Go to top show/hide, layout and style here.', 'backend', 'eooten'),
			'priority' => 143
		));

		/*
		 * "go to top" link
		 */
		$this->wp_customize->add_setting('eooten_totop_show', array(
			'default' => 1,
			'sanitize_callback' => 'eooten_sanitize_checkbox'
		));
		$this->wp_customize->add_control(new WP_Customize_Control(
			$this->wp_customize,
			'eooten_totop_show',
			array(
				'label'    => esc_html_x('Show "Go to top" link', 'backend', 'eooten'),
				'section'  => 'totop',
				'settings' => 'eooten_totop_show',
				'type'     => 'checkbox'
			)
		));

		$this->wp_customize->add_setting('eooten_totop_bg_style', array(
			'default' => 'secondary',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control('eooten_totop_bg_style', array(
			'label'    => esc_html_x('Background Style', 'backend', 'eooten'),
			'section'  => 'totop',
			'settings' => 'eooten_totop_bg_style',
			'type'     => 'select',
			'choices'  => array(
				'default'   => esc_html_x('Default (White)', 'backend', 'eooten'),
				'muted'     => esc_html_x('Muted', 'backend', 'eooten'),
				'primary'   => esc_html_x('Primary', 'backend', 'eooten'),
				'secondary' => esc_html_x('Secondary', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_totop_check',
		));

		$this->wp_customize->add_setting('eooten_totop_align', array(
			'default' => 'left',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_totop_align', array(
			'label'    => esc_html_x('Alignment', 'backend', 'eooten'),
			'description' => esc_html_x('Set go to top alignment from here.', 'backend', 'eooten'),
			'section'  => 'totop',
			'settings' => 'eooten_totop_align',
			'type'     => 'select',
			'choices'  => array(
				'left'      => esc_html_x('Bottom Left', 'backend', 'eooten'),
				'center'    => esc_html_x('Bottom Center', 'backend', 'eooten'),
				'right'     => esc_html_x('Bottom Right', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_totop_check',
		)));

		$this->wp_customize->add_setting('eooten_totop_radius', array(
			'default' => 'circle',
			'sanitize_callback' => 'eooten_sanitize_choices'
		));
		$this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize, 'eooten_totop_radius', array(
			'label'    => esc_html_x('Alignment', 'backend', 'eooten'),
			'description' => esc_html_x('Set go to top alignment from here.', 'backend', 'eooten'),
			'section'  => 'totop',
			'settings' => 'eooten_totop_radius',
			'type'     => 'select',
			'choices'  => array(
				0        => esc_html_x('Squire', 'backend', 'eooten'),
				'rounded' => esc_html_x('Rounded', 'backend', 'eooten'),
				'circle' => esc_html_x('Circle', 'backend', 'eooten'),
			),
			'active_callback' => 'eooten_totop_check',
		)));


		if (isset($this->wp_customize->selective_refresh)) {
			$this->wp_customize->selective_refresh->add_partial('blogname', array(
				'selector' => '.tm-header a.tm-logo-text',
				'container_inclusive' => false,
				'render_callback' => 'eooten_customize_partial_blogname',
			));
			$this->wp_customize->selective_refresh->add_partial('eooten_logo_default', array(
				'selector' => '.tm-header a.tm-logo-img',
				'container_inclusive' => false,
			));
			$this->wp_customize->selective_refresh->add_partial('blogdescription', array(
				'selector' => '.site-description',
				'container_inclusive' => false,
				'render_callback' => 'eooten_customize_partial_blogdescription',
			));

			$this->wp_customize->selective_refresh->add_partial('eooten_show_copyright_text', array(
				'selector' => '.copyright-txt',
				'container_inclusive' => false,
			));

			$this->wp_customize->selective_refresh->add_partial('eooten_copyright_text_custom_show', array(
				'selector' => '.copyright-txt',
				'container_inclusive' => false,
			));

			$this->wp_customize->selective_refresh->add_partial('eooten_search_position', array(
				'selector' => '.tm-header .bdt-search',
				'container_inclusive' => false,
			));

			$this->wp_customize->selective_refresh->add_partial('eooten_search_position', array(
				'selector' => '.tm-header a.bdt-search-icon',
				'container_inclusive' => false,
			));

			$this->wp_customize->selective_refresh->add_partial('eooten_woocommerce_cart', array(
				'selector' => '.tm-cart-popup',
				'container_inclusive' => false,
			));

			$this->wp_customize->selective_refresh->add_partial('nav_menu_locations[primary]', array(
				'selector' => '.tm-header .bdt-navbar-nav',
				'container_inclusive' => false,
			));

			$this->wp_customize->selective_refresh->add_partial('nav_menu_locations[toolbar]', array(
				'selector' => '.tm-toolbar .tm-toolbar-menu',
				'container_inclusive' => false,
			));

			$this->wp_customize->selective_refresh->add_partial('nav_menu_locations[footer]', array(
				'selector' => '.tm-copyright .tm-copyright-menu',
				'container_inclusive' => false,
			));

			$this->wp_customize->selective_refresh->add_partial('eooten_top_link', array(
				'selector' => '.tm-totop-scroller',
				'container_inclusive' => false,
			));


			$this->wp_customize->selective_refresh->add_partial('eooten_mobile_offcanvas_style', array(
				'selector' => '.tm-header-mobile .bdt-navbar-toggle',
				'container_inclusive' => false,
			));

			$this->wp_customize->selective_refresh->add_partial('eooten_titlebar_layout', array(
				'selector' => '.tm-titlebar h1',
				'container_inclusive' => false,
			));
		}
	}

	public function eooten_font_weight() {
		$font_weight = array(
			''    => esc_html_x('Default', 'backend', 'eooten'),
			'100' => esc_html_x('Extra Light: 100', 'backend', 'eooten'),
			'200' => esc_html_x('Light: 200', 'backend', 'eooten'),
			'300' => esc_html_x('Book: 300', 'backend', 'eooten'),
			'400' => esc_html_x('Normal: 400', 'backend', 'eooten'),
			'600' => esc_html_x('Semibold: 600', 'backend', 'eooten'),
			'700' => esc_html_x('Bold: 700', 'backend', 'eooten'),
			'800' => esc_html_x('Extra Bold: 800', 'backend', 'eooten'),
		);
		return $font_weight;
	}

	/**
	 * Render the site title for the selective refresh partial.
	 * @since Eooten 1.0
	 * @see eooten_customize_register_colors()
	 * @return void
	 */
	public function eooten_customize_partial_blogname() {
		bloginfo('name');
	}

	/**
	 * Render the site title for the selective refresh partial.
	 * @since Eooten 1.0
	 * @return void
	 */
	public function eooten_customize_partial_blogdescription() {
		bloginfo('description');
	}

	/**
	 * Cache the rendered CSS after the settings are saved in the DB.
	 * This is purely a performance improvement.
	 * @since Eooten 1.0
	 * @return void
	 */
	public function cache_rendered_css() {
		set_theme_mod('cached_css', $this->render_css());
	}

	/**
	 * Cache the rendered CSS after the settings are saved in the DB.
	 * This is purely a performance improvement.
	 * @since Eooten 1.0
	 * @return void
	 */
	public static function save_logo_dimensions($setting) {
		$logo_width_height = '';
		$img_data          = getimagesize(esc_url($setting->post_value()));

		if (is_array($img_data)) {
			$logo_width_height = $img_data[3];
		}

		set_theme_mod('logo_width_height', $logo_width_height);
	}

	/**
	 * Render the CSS from all the settings which are of type `Eooten_Customizer_Dynamic_CSS`
	 * @since Eooten 1.0
	 * @return string text/css
	 */
	public function render_css() {
		$out = '';
		foreach ($this->get_dynamic_css_settings() as $setting) {
			$out .= $setting->render_css();
		}

		return $out;
	}
	/**
	 * Render the CSS from all the settings which are of type `Eooten_Customizer_Dynamic_CSS`
	 * @since Eooten 1.0
	 * @see Eooten_Customizer_Dynamic_CSS
	 * @return array
	 */
	public function get_dynamic_css_settings() {
		return array_filter($this->wp_customize->settings(), array($this, 'is_dynamic_css_setting'));
	}
	/**
	 * Helper conditional function for filtering the settings.
	 * @since Eooten 1.0
	 * @see Eooten_Customizer_Dynamic_CSS
	 * @param  mixed  $setting
	 * @return boolean
	 */
	protected static function is_dynamic_css_setting($setting) {
		return is_a($setting, 'Eooten_Customizer_Dynamic_CSS');
	}


	/**
	 * Dynamically generate the JS for previewing the settings of type `Eooten_Customizer_Dynamic_CSS`.
	 * This function is better for the UX, since all the color changes are transported to the live
	 * preview frame using the 'postMessage' method. Since the JS is generated on-the-fly and we have a single
	 * entry point of entering settings along with related css properties and classes, we cannnot forget to
	 * include the setting in the customizer itself. Neat, man!
	 * @since Eooten 1.0
	 * @return string text/javascript
	 * @see Eooten_Customizer_Dynamic_CSS
	 * @see Eooten_Customizer::get_dynamic_css_settings()
	 * @return string text/javascript
	 */
	public function customize_footer_js() {
		$settings = $this->get_dynamic_css_settings();

		ob_start();
?>

		<script type="text/javascript">
			'use strict';
			(function($) {
				var style = []

				<?php
				foreach ($settings as $key_id => $setting) :
				?>
					style['<?php echo esc_attr($key_id) ?>'] = '';
					wp.customize('<?php echo esc_attr($key_id); ?>', function(value) {

						value.bind(function(newval) {
							style['<?php echo esc_attr($key_id) ?>'] = '';
							<?php
							foreach ($setting->get_css_map() as $css_prop_raw => $css_selectors) {

								extract($setting->filter_css_property($css_prop_raw));
								if ($lighten) {
									echo 'newval = LightenDarkenColor(newval,' . esc_attr($lighten) . ' ); ';
								}
								if ('background-image' === $css_prop) {
									echo 'newval = "url(\'" + newval + "\')";' . PHP_EOL;
								}
								printf('style["%1$s"]  += "%2$s{ %3$s: "+ newval + " }" %4$s ' .  '+"\r\n"; ' . "\r\n", $key_id, $setting->plain_selectors_for_all_groups($css_prop_raw), $css_prop, PHP_EOL);
							}
							?>
							add_style(style);
						});

					});
					<?php
					foreach ($setting->get_css_map() as $css_prop_raw => $css_selectors) {

						extract($setting->filter_css_property($css_prop_raw));
						if ($lighten) {
							$value = $value;
						} else {
							$value = $setting->render_css_save();
						}

						if ('background-image' === $css_prop) {
							$value = 'url(\'' . $value . '\');';
						}
						printf(
							'style["%1$s"]  += "%2$s{ %3$s: %5$s }" %4$s ' . '+"\r\n"; ' . "\r\n",
							$key_id,
							$setting->plain_selectors_for_all_groups($css_prop_raw),
							$css_prop,
							PHP_EOL,
							$value
						);
					}
					?>
					add_style(style);
				<?php
				endforeach;
				?>

				function add_style(style) {
					var str_style = '';
					var key;
					for (key in style) {
						if (style[key]) {
							str_style += '/*' + key + "*/\r\n";
							str_style += style[key] + "\r\n";
						}
					}
					$('#custome_live_preview').html(str_style)

				}

				function LightenDarkenColor(col, amt) {
					var usePound = false;
					if (col[0] == "#") {
						col = col.slice(1);
						usePound = true;
					}
					var num = parseInt(col, 16);
					var r = (num >> 16) + amt;
					if (r > 255) r = 255;
					else if (r < 0) r = 0;
					var b = ((num >> 8) & 0x00FF) + amt;
					if (b > 255) b = 255;
					else if (b < 0) b = 0;
					var g = (num & 0x0000FF) + amt;
					if (g > 255) g = 255;
					else if (g < 0) g = 0;
					return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16);
				}
			})(jQuery);
		</script>
	<?php
		echo ob_get_clean();
	}

	public function hook_custom_css() { ?>
		<style id='custome_live_preview'></style>
<?php
	}
}
