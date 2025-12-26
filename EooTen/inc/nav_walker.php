<?php
class eooten_menu_walker extends Walker_Nav_Menu {
    /**
     * Starts the list before the elements are added.
     * @see Walker::start_lvl()
     * @since 3.0.0
     * @access public
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     * @param array $args An array of arguments. @see wp_nav_menu()
     * @return void
     *
     */
    public function start_lvl(&$output, $depth = 0, $args = []) {
        $indent = str_repeat("\t", $depth);
        if ($args->theme_location === 'offcanvas') {
            $output .= "\n$indent<ul class=\"bdt-nav-sub\">\n";
        } else {
            $output .= "\n$indent<ul class=\"bdt-dropdown bdt-nav bdt-dropdown-nav\" bdt-dropdown>\n";
        }
    }

    /**
     * Ends the list of after the elements are added.
     * @see Walker::end_lvl()
     * @since 3.0.0
     * @access public
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     * @param array $args An array of arguments. @see wp_nav_menu()
     * @return void
     */
    public function end_lvl(&$output, $depth = 0, $args = []) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     * @access public
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param array $args An array of arguments. @see wp_nav_menu()
     * @param int $id Current item ID.
     * @return void
     * @global int $_wp_nav_menu_max_depth
     * @global array $wp_registered_sidebars
     * @global array $wp_registered_widgets
     * @global array $wp_registered_widget_controls
     * @global array $wp_registered_widget_updates
     * @global array $wp_registered_widget_defaults
     * @global array $wp_registered_widget_factory
     * @global array $wp_registered_widget_classes
     * @global array $wp_registered_widget_callbacks
     * @global array $wp_registered_widget_control_callbacks
     * @global array $wp_registered_widget_update_callbacks
     * @global array $wp_registered_widget_id_bases
     */
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0) {
        $indent    = ($depth) ? str_repeat("\t", $depth) : '';
        $classes   = empty($item->classes) ? [] : (array)$item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        /**
         * Filter the CSS class(es) applied to a menu item's list item element.
         */
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names .= ' nav-item';
        if (in_array('current-menu-item', $classes)) {
            $class_names .= ' active';
        }
        if (in_array('menu-item-has-children', $classes)) {
            $class_names .= ' bdt-parent';
        }

        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        /**
         * Filter the ID applied to a menu item's list item element.
         */
        $id        = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id        = $id ? ' id="' . esc_attr($id) . '"' : '';
        $data_attr = '';

        $output         .= $indent . '<li' . $id . $class_names . $data_attr . '>';
        $atts           = [];
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        $atts['class']  = !empty($item->classes) ? implode(' ', $item->classes) : '';


        $submenu_indicator = '';

        if ($depth === 0) {
            $atts['class'] .= ' bdt-link-text';
        }

        /**
         * Filter the HTML attributes applied to a menu item's anchor element.
         */

        $atts       = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        $attributes = '';

        foreach ($atts as $attr => $value) {

            if (!empty($value)) {
                $value      = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;

        $item_output .= '<a' . $attributes . '>';
        if (in_array('menu-item-has-children', $classes)) {
            $submenu_indicator .= '<span class="bdt-icon bdt-nav-parent-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><polyline fill="none" stroke="#000" stroke-width="1.03" points="16 7 10 13 4 7"/></svg></span>';
        }

        /**
         * This filter is documented in wp-includes/post-template.php
         */
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= $submenu_indicator . '</a>';
        $item_output .= $args->after;

        /**
         * Filter a menu item's starting output.
         */
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * @see Walker::end_el()
     * @since 3.0.0
     * @access public
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Page data object. Not used.
     * @param int $depth Depth of page. Not Used.
     * @param array $args An array of arguments. @see wp_nav_menu()
     * @return void
     */
    public function end_el(&$output, $item, $depth = 0, $args = []) {
        if ($depth === 0) {
            $output .= "</li>\n";
        }
    }
}
