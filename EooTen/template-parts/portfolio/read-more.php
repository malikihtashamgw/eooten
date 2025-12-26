<?php

/**
 * Template part for displaying posts
 *
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */
if (is_home() and get_theme_mod('eooten_blog_readmore', 1)) : ?>
	<p class="bdt-margin-remove">
		<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="bdt-button bdt-button-secondary"><?php esc_html_e('Read More...', 'eooten'); ?></a>
	</p>
<?php endif; ?>