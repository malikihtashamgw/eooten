<?php

/**
 * Template part for displaying primary menu
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
 */
$eooten_main_menu = get_theme_mod('eooten_menu_show', true);

if ($eooten_main_menu) {

	if (has_nav_menu('primary')) {
		$eooten_navbar = wp_nav_menu(
			[
				'theme_location' => 'primary',
				'container'      => false,
				'menu_id'        => 'nav',
				'menu_class'     => 'bdt-navbar-nav',
				'echo'           => false,
				'before'         => '',
				'after'          => '',
				'link_before'    => '',
				'link_after'     => '',
				'depth'          => 0,
				'parent_id'      => 'tmMainMenu',
			]
		);
		echo $eooten_navbar; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		echo '<ul class="no-menu bdt-hidden-small"><li><a href="' . admin_url('/nav-menus.php') . '"><strong>NO MENU ASSIGNED</strong> <span>Go To Appearance > Menus and create a Menu</span></a></li></ul>';
	}
}
