<?php

/**
 * Template part for displaying post title
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
if (!is_single() or is_single()) : ?>

	<?php if (!is_single()) : ?>
		<h1 class="bdt-article-title bdt-margin-remove-top">
			<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="bdt-link-reset"><?php the_title(); ?></a>
			<?php if (is_sticky() && is_home() && !is_paged()) : ?>
				<?php printf('<span class="sticky-post featured">%s</span>', esc_html__('Featured', 'eooten')); ?>
			<?php endif; ?>
		</h1>
	<?php elseif (is_single()) : ?>
		<h1 class="bdt-article-title bdt-margin-remove-top"><?php the_title(); ?></h1>
	<?php endif ?>

<?php endif ?>