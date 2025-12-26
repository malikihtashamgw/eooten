<?php

/**
 * Template part for displaying post read more
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/

 */

if (is_home() and get_theme_mod('eooten_blog_readmore', 1)) : ?>
	<p class="bdt-margin-medium">
		<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="bdt-button bdt-button-text tm-read-more-button"><?php esc_html_e('Read More', 'eooten'); ?> <i bdt-icon="arrow-right"></i> </a>
	</p>
<?php endif; ?>