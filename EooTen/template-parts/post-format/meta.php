<?php

/**
 * Template part for displaying post meta
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
if (is_home() or is_single() or is_category() or is_archive()) : ?>
    <p class="bdt-article-meta">
        <?php if (get_the_date()) : ?>

            <time>
                <?php printf(get_the_date()); ?>
            </time>

        <?php endif; ?>

        <?php if (get_the_author()) : ?>

            <?php
            printf(esc_html__('Written by %s.', 'eooten'), '<a href="' . get_author_posts_url(get_the_author_meta('ID')) . '" title="' . get_the_author() . '">' . get_the_author() . '</a>');
            ?>

        <?php endif; ?>

        <?php if (get_the_category_list()) : ?>

            <?php
            printf(esc_html__('Posted in %s', 'eooten'), get_the_category_list(', '));
            ?>

        <?php endif; ?>

        <?php if (comments_open() || get_comments_number()) : ?>

            <?php comments_popup_link(esc_html__('No Comments', 'eooten'), esc_html__('1 Comment', 'eooten'), esc_html__('% Comments', 'eooten'), "", ""); ?>

        <?php endif; ?>

        <?php edit_post_link(esc_html__('Edit this post', 'eooten'), '<div class="bdt-link-reset">', '</div>'); ?>
    </p>
<?php endif; ?>