<?php

/**
 * Template part for loop video post format
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

?>

<article id="post-<?php the_ID() ?>" <?php post_class('bdt-article post-format-video') ?> data-permalink="<?php the_permalink() ?>" typeof="Article">

    <?php get_template_part('template-parts/post-format/schema-meta'); ?>

    <?php
    $eooten_video = get_post_meta(get_the_ID(), 'eooten_blog_video', true);
    if (!empty($eooten_video)) : ?>
        <?php $eooten_video_src = get_post_meta(get_the_ID(), 'eooten_blog_videosrc', true);
        if (!empty($eooten_video_src) and $eooten_video_src = 'embedcode') : ?>
            <div class="post-video<?php echo (is_single()) ? ' bdt-margin-large-bottom' : ' bdt-margin-bottom'; ?>">
                <?php echo wp_kses(get_post_meta(get_the_ID(), 'eooten_blog_video', true), eooten_allowed_tags('iframe')); ?>
            </div>
        <?php else : ?>

            <div class="post-video<?php echo (is_single()) ? ' bdt-margin-large-bottom' : ' bdt-margin-bottom'; ?>">
                <?php echo wp_oembed_get(esc_url($eooten_video)); ?>
            </div>

        <?php endif; ?>


    <?php endif ?>


    <div class="bdt-margin-medium-bottom bdt-container bdt-container-small bdt-text-center">
        <?php get_template_part('template-parts/post-format/title'); ?>

        <?php if (get_theme_mod('eooten_blog_meta', 1)) : ?>
            <?php get_template_part('template-parts/post-format/meta'); ?>
        <?php endif; ?>
    </div>

    <div class="bdt-container bdt-container-small">
        <?php get_template_part('template-parts/post-format/content'); ?>

        <?php get_template_part('template-parts/post-format/read-more'); ?>
    </div>

</article>