<?php

/**
 * Template part for displaying custom left toolbar
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */ ?>

<div class="custom-text">
	<?php
	if (get_theme_mod('eooten_toolbar_left_custom')) {
		echo wp_kses_post(get_theme_mod('eooten_toolbar_left_custom'));
	} ?>
</div>