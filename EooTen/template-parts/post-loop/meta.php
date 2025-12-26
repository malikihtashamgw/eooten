<?php

/**
 * Template part for loop meta info (date, author, category)
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
if (is_home() or is_single() or is_category() or is_archive()) : ?>
    <p class="bdt-article-meta">
        <?php if (get_the_date()) : ?>
            <time> <?php printf(get_the_date()); ?> </time>
        <?php endif; ?>

        <?php if (get_the_author()) : ?>
            <?php printf(esc_html__('Written by %s.', 'eooten'), '<a href="' . get_author_posts_url(get_the_author_meta('ID')) . '" title="' . get_the_author() . '">' . get_the_author() . '</a>');  ?>
        <?php endif; ?>

        <?php if (get_the_category_list()) : ?>
            <?php printf(esc_html__('Posted in %s', 'eooten'), get_the_category_list(', ')); ?>
        <?php endif; ?>

    </p>
<?php endif; ?>