<?php

/**
 * Template part for loop gallery post format
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

?>


<article id="post-<?php the_ID() ?>" <?php post_class('bdt-article post-format-gallery') ?> data-permalink="<?php the_permalink() ?>" typeof="Article">

    <?php get_template_part('template-parts/post-format/schema-meta'); ?>

    <?php
    //$eooten_images = get_post_meta( get_the_ID(), 'eooten_blog_gallery', true );
    $eooten_images = rwmb_meta('eooten_blog_gallery', 'type=image_advanced&size=eooten_blog');
    if (!empty($eooten_images)) : ?>

        <div class="post-image-gallery<?php echo (is_single()) ? ' bdt-margin-large-bottom' : ' bdt-margin-bottom'; ?>">
            <div class="image-lightbox owl-carousel owl-theme" data-owl-carousel='{"margin": 10, "items": 1, "nav": true, "navText": "", "loop": true}'>
                <?php
                foreach ($eooten_images as $eooten_image) {
                    echo '<div class="carousel-cell"><a href="' . esc_url($eooten_image['full_url']) . '" title="' . esc_attr($eooten_image['title']) . '"><img src="' . esc_url($eooten_image['url']) . '" alt="' . esc_attr($eooten_image['alt']) . '" width="' . esc_attr($eooten_image['width']) . '" height="' . esc_attr($eooten_image['height']) . '" class="bdt-border-rounded" /></a></div>';
                } ?>
            </div>
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