<?php

/**
 * Template part for loop testimonials content
 * @package eooten
 * @since 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
if (!is_single() or is_single()) : ?>
	<?php if (!is_single()) : ?>
		<p><?php echo wp_kses_post(eooten_custom_excerpt(50)); ?></p>
	<?php elseif (is_single()) : ?>
		<?php the_content(); ?>
	<?php endif ?>

	<?php wp_link_pages(
		[
			'before'      => '<div class="page-links"><span>' . esc_html__('Pages:', 'eooten') . '</span>',
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		]
	); ?>
<?php endif ?>