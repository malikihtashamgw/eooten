<?php

defined('ABSPATH') or exit;
/**
 * Eooten Theme Support Class
 * @since 3.1.0
 * @package Eooten
 */
class Eooten_Theme_MetaBox {

    /**
     * Instance of Eooten Theme Support Class
     * @var Eooten Theme Support Class Instance of Eooten Theme Support Class
     * @since 3.1.0
     * @access private
     * @static
     * @var Eooten_Theme_MetaBox
     */
    private static $_instance = null;
    /**
     * Instance of Elementor
     * @var Elementor Instance of Elementor
     * @since 3.1.0
     * @access private
     * @static
     */
    private static $elementor_instance;

    /**
     * Instance of Eooten Theme Support Class
     * @return Eooten Theme Support Class Instance of Eooten Theme Support Class
     */
    public static function instance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * Constructor
     * @since 3.1.0
     * @access private
     */
    private function __construct() {
        self::$elementor_instance = Elementor\Plugin::instance();
        add_action('admin_init', [$this, 'eooten_page_settings_metabox']);
        add_action('save_post', [$this, 'eooten_custom_template_save_metabox']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
    }
    /**
     * Eooten Page Settings Metabox
     * @return void
     * @since 3.1.0
     * @access public
     */
    public function eooten_page_settings_metabox() {
        add_meta_box('_pagesettings', __('Page Settings', 'eooten'), [$this, 'eooten_template_metabox_fields_callback'], 'page', 'side');
    }
    /**
     * Eooten Template Metabox Fields Callback
     * @param  mixed $post
     */
    public function enqueue_admin_scripts() {
        wp_enqueue_style('rooetn-metabox-admin-css', get_template_directory_uri() . '/inc/meta-box/assets/css/style.css', null, '1.0.0', false);
        wp_enqueue_script('rooetn-metabox-admin-js', get_template_directory_uri() . '/inc/meta-box/assets/js/script.js', null, '1.0.0', true);
    }

    /**
     * Eooten Template Metabox Fields Callback
     * @param  mixed $post
     *
     */

    private function eooten_get_sidebars_array() {
        global $wp_registered_sidebars;
        $list_sidebars = [];
        foreach ($wp_registered_sidebars as $sidebar) {
            $list_sidebars[$sidebar['id']] = $sidebar['name'];
        }
        // remove them from the list for better understand purpose
        unset($list_sidebars['footer-widgets']);
        unset($list_sidebars['footer-widgets-2']);
        unset($list_sidebars['footer-widgets-3']);
        unset($list_sidebars['footer-widgets-4']);
        unset($list_sidebars['offcanvas']);
        unset($list_sidebars['fixed-left']);
        unset($list_sidebars['fixed-right']);
        unset($list_sidebars['headerbar']);
        unset($list_sidebars['drawer']);
        unset($list_sidebars['bottom']);
        return $list_sidebars;
    }

    /**
     * Eooten Saved Header Template list maker
     * @return template type with array
     * @since 3.1.2
     * @access private
     * @param string $type
     * @return array

     */
    private function eooten_custom_template_list($type = 'header') {

        if (!defined('ELEMENTOR_VERSION')) {
            return ['0' => esc_html__('Install Elementor First', 'eooten')];
        }

        $args = [
            'numberposts' => 20,
            'post_type'   => 'bdt-custom-template',
            'meta_query'   => [
                'relation' => 'OR',
                [
                    'key'     => 'eooten_template_type',
                    'value'   => $type,
                    'compare' => '==',
                    'type'    => 'post',
                ]
            ]
        ];

        $post_list = get_posts($args);

        $post_list_options = [0 => sprintf(__('Select %s', 'eooten'), ucfirst($type))];

        foreach ($post_list as $list) :
            $post_list_options[$list->ID] = $list->post_title;
        endforeach;

        return $post_list_options;
    }

    /**
     * Disiplay the metabox fields for Eooten Custom Template.
     * @since 3.1.2
     * Display metabox fields -> Eooten Custom Template
     */
    function eooten_template_metabox_fields_callback($post) {
        wp_nonce_field('eooten_metabox_page_settings_action', 'eooten_metabox_page_settings_field');

        $label_page_layout         = __('Page Layout', 'eooten');
        $label_sidebar             = __('Sidebar', 'eooten');
        $label_header              = __('Header', 'eooten');
        $label_custom_header       = __('Custom Header', 'eooten');
        $label_footer_widget       = __('Footer Widgets', 'eooten');
        $label_custom_footer       = __('Custom Footer', 'eooten');
        $sidebar_desc              = __('Select the sidebar you wish to display on this page.', 'eooten');
        $header_desc               = __('Override the header style for this page.', 'eooten');
        $footer_widget_desc        = __('Enable or disable the Footer Widgets on this Page.', 'eooten');
        $custom_header_desc        = __('Enable or disable the Footer Widgets on this Page.', 'eooten');
        $custom_footer_desc        = __('Select your custom footer from here.', 'eooten');
        $page_layout_default       = __('<strong>Default:</strong> For usage normal Text Pages', 'eooten');
        $page_layout_full_width    = __('<strong>Full Width:</strong> For pages using Elementor (commonly used)', 'eooten');
        $page_layout_sidebar_left  = __('<strong>Sidebar Left:</strong> Sidebar Left Template', 'eooten');
        $page_layout_sidebar_right = __('<strong>Sidebar Right:</strong> Sidebar Right Template', 'eooten');

        $page_layouts = [
            'default'       => esc_html_x('Default', 'backend', 'eooten'),
            'full'          => esc_html_x('Fullwidth', 'backend', 'eooten'),
            'sidebar-right' => esc_html_x('Sidebar Right', 'backend', 'eooten'),
            'sidebar-left'  => esc_html_x('Sidebar Left', 'backend', 'eooten'),
        ];
        $header_layouts = [
            null       => esc_html_x('Default (as customizer)', 'backend', 'eooten'),
            'custom'   => esc_html_x('Custom', 'backend', 'eooten'),
        ];
        $footer_widgets = [
            null       => esc_html_x('Default (as customizer)', 'backend', 'eooten'),
            'custom'   => esc_html_x('Custom Footer', 'backend', 'eooten'),
        ];
        $sidebars = $this->eooten_get_sidebars_array();
        $custom_headers = $this->eooten_custom_template_list();
        $custom_footer_widgets = eooten_custom_template_list('footer');

        $layout_html = '';
        $selected_layout   = get_post_meta($post->ID, 'eooten_page_layout', true);
        $selected_val = '';

        foreach ($page_layouts as $layout_key => $layout) {
            $selected = '';
            if ($layout_key == $selected_layout) {
                $selected = 'selected';
                $selected_val = $layout_key;
            }
            $layout_html .= sprintf("<option %s value='%s'>%s</option>", $selected, $layout_key, ucwords($layout));
        }

        $sidebar_html = '';
        $selected_sidebar   = get_post_meta($post->ID, 'eooten_sidebar', true);
        foreach ($sidebars as $key => $sidebar) {
            $selected = '';
            if ($key == $selected_sidebar) {
                $selected = 'selected';
            }
            $sidebar_html .= sprintf("<option %s value='%s'>%s</option>", $selected, $key, ucwords($sidebar));
        }

        $header_html = '';
        $selected_header   = get_post_meta($post->ID, 'eooten_header_layout', true);
        foreach ($header_layouts as $header_key => $header) {
            $selected = '';
            if ($header_key == $selected_header) {
                $selected = 'selected';
                $header_selected_val = $header_key;
            }
            $header_html .= sprintf("<option %s value='%s'>%s</option>", $selected, $header_key, ucwords($header));
        }

        $custom_header_html = '';
        $selected_custom_header   = get_post_meta($post->ID, 'eooten_custom_header', true);
        foreach ($custom_headers as $key => $custom_header) {
            $selected = '';
            if ($key == $selected_custom_header) {
                $selected = 'selected';
            }
            $custom_header_html .= sprintf("<option %s value='%s'>%s</option>", $selected, $key, ucwords($custom_header));
        }

        $footer_widget_html = '';
        $selected_footer_widget   = get_post_meta($post->ID, 'eooten_footer_widgets', true);
        foreach ($footer_widgets as $footer_widget_key => $footer_widget) {
            $selected = '';
            if ($footer_widget_key == $selected_footer_widget) {
                $selected = 'selected';
                $footer_selected_val = $footer_widget_key;
            }
            $footer_widget_html .= sprintf("<option %s value='%s'>%s</option>", $selected, $footer_widget_key, ucwords($footer_widget));
        }

        $custom_footer_widget_html = '';
        $selected_footer_widget   = get_post_meta($post->ID, 'eooten_custom_footer', true);
        foreach ($custom_footer_widgets as $key => $custom_footer_widget) {
            $selected = '';
            if ($key == $selected_footer_widget) {
                $selected = 'selected';
            }
            $custom_footer_widget_html .= sprintf("<option %s value='%s'>%s</option>", $selected, $key, ucwords($custom_footer_widget));
        }

        $metabox_html = <<<EOD

        <div class="bdt-metabox-page-settings">
            <div class="bdt-page-layout">
                <div class="page-settings-label">
                    <label for="eooten_page_layout">{$label_page_layout}: </label>
                </div>
                <div class="bdt-metabox-input-fields">
                    <select name="eooten_page_layout" id="eooten_page_layout" data-selected="{$selected_val}">
                        {$layout_html}
                    </select>
                    <p class="page-settings-desc">{$page_layout_default}<br>{$page_layout_full_width}<br>{$page_layout_sidebar_left}<br>{$page_layout_sidebar_right}</p>
                </div>
            </div>
            <div class="bdt-sidebar">
                <div class="page-settings-label">
                    <label for="eooten_sidebar">{$label_sidebar}: </label>
                </div>
                <div class="bdt-metabox-input-fields">
                    <select name="eooten_sidebar" id="eooten_sidebar">
                        {$sidebar_html}
                    </select>
                    <p class="page-settings-desc">{$sidebar_desc}</p>
                </div>
            </div>

            <div class="bdt-header">
                <div class="page-settings-label">
                    <label for="eooten_header_layout">{$label_header}: </label>
                </div>
                <div class="bdt-metabox-input-fields">
                    <select name="eooten_header_layout" id="eooten_header_layout" data-selected="{$header_selected_val}">
                        {$header_html}
                    </select>
                    <p class="page-settings-desc">{$header_desc}</p>
                </div>
            </div>

            <div class="bdt-custom-header">
                <div class="page-settings-label">
                    <label for="eooten_custom_header">{$label_custom_header}: </label>
                </div>
                <div class="bdt-metabox-input-fields">
                    <select name="eooten_custom_header" id="eooten_custom_header">
                        {$custom_header_html}
                    </select>
                    <p class="page-settings-desc">{$custom_header_desc}</p>
                </div>
            </div>

            <div class="bdt-footer">
                <div class="page-settings-label">
                    <label for="eooten_footer_widgets">{$label_footer_widget}: </label>
                </div>
                <div class="bdt-metabox-input-fields">
                    <select name="eooten_footer_widgets" id="eooten_footer_widgets" data-selected="{$footer_selected_val}">
                        {$footer_widget_html}
                    </select>
                    <p class="page-settings-desc">{$footer_widget_desc}</p>
                </div>
            </div>

            <div class="bdt-custom-footer">
                <div class="page-settings-label">
                    <label for="eooten_custom_footer">{$label_custom_footer}: </label>
                </div>
                <div class="bdt-metabox-input-fields">
                    <select name="eooten_custom_footer" id="eooten_custom_footer">
                        {$custom_footer_widget_html}
                    </select>
                    <p class="page-settings-desc">{$custom_footer_desc}</p>
                </div>
            </div>
	</div>
EOD;

        echo $metabox_html; // WPCS: XSS ok.
    }


    /**
     * Save the metabox fields for Eooten Custom Template.
     * @since 3.1.2
     * Save metabox fields -> Eooten Custom Template
     */
    public function eooten_custom_template_save_metabox($post_id) {
        if (!$this->is_secured('eooten_metabox_page_settings_field', 'eooten_metabox_page_settings_action', $post_id)) {
            return $post_id;
        }
        $layout             = isset($_POST['eooten_page_layout']) ? $_POST['eooten_page_layout'] : '';
        $sidebar            = isset($_POST['eooten_sidebar']) ? $_POST['eooten_sidebar'] : '';
        $header             = isset($_POST['eooten_header_layout']) ? $_POST['eooten_header_layout'] : '';
        $footer_widget      = isset($_POST['eooten_footer_widgets']) ? $_POST['eooten_footer_widgets'] : '';
        $custom_header      = isset($_POST['eooten_custom_header']) ? $_POST['eooten_custom_header'] : '';
        $custom_footer      = isset($_POST['eooten_custom_footer']) ? $_POST['eooten_custom_footer'] : '';

        update_post_meta($post_id, 'eooten_page_layout', $layout);
        update_post_meta($post_id, 'eooten_sidebar', $sidebar);
        update_post_meta($post_id, 'eooten_header_layout', $header);
        update_post_meta($post_id, 'eooten_footer_widgets', $footer_widget);
        update_post_meta($post_id, 'eooten_custom_header', $custom_header);
        update_post_meta($post_id, 'eooten_custom_footer', $custom_footer);
    }


    private function is_secured($nonce_field, $action, $post_id) {
        $nonce = isset($_POST[$nonce_field]) ? $_POST[$nonce_field] : '';

        if ($nonce == '') {
            return false;
        }
        if (!wp_verify_nonce($nonce, $action)) {
            return false;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return false;
        }

        if (wp_is_post_autosave($post_id)) {
            return false;
        }

        if (wp_is_post_revision($post_id)) {
            return false;
        }

        return true;
    }
}

/**
 * Initialize the class instance only once.
 * @since 3.1.2
 * @return object
 */
Eooten_Theme_MetaBox::instance();
