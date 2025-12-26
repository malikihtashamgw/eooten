<?php
/**
 * Template part for displaying portfolio experiences entry
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

    $eooten_title       = 'yes';  // TODO
    $eooten_meta        = 'yes';  // TODO
    $eooten_excerpt     = 'no';  // TODO
    $eooten_align       = 'center';  // TODO
    $eooten_social_link = 'yes'; // TODO

?>

<div class="bdt-portfolio-content-wrapper bdt-box-shadow-small bdt-portfolio-align-<?php echo esc_attr($eooten_align); ?>">

    <?php if (has_post_thumbnail()) : ?>
        <div class="portfolio-thumbnail bdt-position-relative bdt-overflow-hidden">
            <div class="portfolio-thumbnail-design">
                <?php get_template_part( 'template-parts/portfolio/media' ); ?>
                <div class="bdt-portfolio-overlay bdt-position-cover bdt-overlay bdt-overlay-gradient bdt-position-z-index"></div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(( $eooten_title==='yes') or ( $eooten_meta==='yes') or ( $eooten_excerpt==='yes')) { ?>
        <div class="bdt-portfolio-desc bdt-padding bdt-position-relative bdt-position-z-index">

            <?php if( $eooten_title==='yes') { ?>
                <?php get_template_part( 'template-parts/portfolio/title' ); ?>
            <?php };

            if( $eooten_meta==='yes') {

                echo get_the_term_list(get_the_ID(),'experiences', '<ul class="bdt-portfolio-meta bdt-flex-'.$eooten_align.' bdt-margin-small-top bdt-margin-remove"><li>', '</li><li>', '</li></ul>' );
            };

            if( $eooten_social_link === 'yes') {
                get_template_part( 'template-parts/portfolio/social-link' );
            }; ?>


            <?php if( $eooten_excerpt==='yes') { ?>
                <div class="bdt-container bdt-text-<?php echo esc_attr($eooten_align); ?> bdt-container-small">
                        <?php get_template_part( 'template-parts/portfolio/content' ); ?>
                </div>
            <?php }; ?>
        </div>
    <?php }; ?>
</div>