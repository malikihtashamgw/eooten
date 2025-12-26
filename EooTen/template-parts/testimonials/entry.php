<?php

/**
 * Template part for loop testimonials entry
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

$eooten_rating       = get_post_meta(get_the_ID(), 'bdthemes_tm_rating', true);
$eooten_company_name = get_post_meta(get_the_ID(), 'bdthemes_tm_company_name', true);
// $eooten_color        = 'bdt-' . ($eooten_color != null) ? $eooten_color : 'dark'; //TODO
// $eooten_background   = ' bdt-background-' . ($eooten_background != null) ? $eooten_background : 'default'; // TODO
?>


<div class="bdt-testimonial-item">

    <div class="bdt-grid">
        <div class="bdt-width-3-4">
            <div class="bdt-testimonial-text bdt-position-relative <?php //echo esc_html($eooten_color);
                                                                    ?>">
                <?php get_template_part('template-parts/testimonials/content'); ?>

                <div>
                    <?php get_template_part('template-parts/testimonials/title'); ?>
                    <?php $eooten_separator = ($eooten_company_name) ? ', ' : '' ?>
                    <span class="bdt-text-small"><?php echo esc_html($eooten_separator) . $eooten_company_name; ?></span>
                    <ul class="tm-rating tm-rating-<?php echo esc_html($eooten_rating); ?> bdt-text-muted bdt-grid-collapse" data-bdt-grid>
                        <li class="tm-rating-item"><span bdt-icon="star"></span></li>
                        <li class="tm-rating-item"><span bdt-icon="star"></span></li>
                        <li class="tm-rating-item"><span bdt-icon="star"></span></li>
                        <li class="tm-rating-item"><span bdt-icon="star"></span></li>
                        <li class="tm-rating-item"><span bdt-icon="star"></span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bdt-width-1-4">
            <div class="bdt-testimonial-thumb bdt-display-block bdt-overflow-hidden bdt-background-cover">
                <?php if (has_post_thumbnail()) : ?>
                    <?php echo  the_post_thumbnail('thumbnail'); ?>
                <?php else : ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/member-image.svg" alt="<?php the_title(); ?>" />
                <?php endif; ?>

            </div>
        </div>
    </div>


</div>

<?php if (is_single() and empty($author_desc)) : ?>
    <div class="bdt-margin-large-top"></div>
<?php endif ?>