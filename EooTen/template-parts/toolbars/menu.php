<?php

/**
 * Template part for displaying menu toolbar
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
if (has_nav_menu('toolbar')) {
	echo wp_nav_menu([
		'theme_location' => 'toolbar',
		'container_class' => 'tm-toolbar-menu',
		'menu_class' => 'bdt-subnav bdt-subnav-divider',
		'depth' => 1,
	]);
} else {
	echo '<ul class="no-menu bdt-hidden-small"><li><a href="' . admin_url('/nav-menus.php') . '"><strong>NO MENU ASSIGNED</strong></a></li></ul>';
}
