<?php

/**
 * Template part for loop post audio
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
?>

<article id="post-<?php the_ID() ?>" <?php post_class('bdt-article post-format-audio') ?> data-permalink="<?php the_permalink() ?>" typeof="Article">

    <?php get_template_part('template-parts/post-format/schema-meta'); ?>

    <?php
    $eooten_audio = get_post_meta(get_the_ID(), 'eooten_blog_audio', true);
    if (!empty($eooten_audio)) : ?>

        <div class="post-audio<?php echo (is_single()) ? ' bdt-margin-large-bottom' : ' bdt-margin-bottom'; ?>">
            <?php echo wp_kses($eooten_audio, eooten_allowed_tags('iframe')); ?>
        </div>

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