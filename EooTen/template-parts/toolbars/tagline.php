<?php

/**
 * Template part for displaying site tagline
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
$eooten_description = get_bloginfo('description', 'display');
if ($eooten_description || is_customize_preview()) : ?>
	<p class="site-description"><?php echo esc_html($eooten_description); ?></p>
<?php endif; ?>