<?php

/**
 * Template part for displaying portfolio metadata
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

if (is_single()) : ?>
    <?php
    $eooten_email            = get_post_meta(get_the_ID(), 'bdthemes_portfolio_email', true);
    $eooten_phone            = get_post_meta(get_the_ID(), 'bdthemes_portfolio_phone', true);
    $eooten_appointment_link = get_post_meta(get_the_ID(), 'bdthemes_portfolio_appointment_link', true);
    $eooten_link_title       = get_post_meta(get_the_ID(), 'bdthemes_portfolio_appointment_link_title', true);
    $eooten_badge            = get_post_meta(get_the_ID(), 'bdthemes_portfolio_badge', true);
    $eooten_social_link      = get_post_meta(get_the_ID(), 'bdthemes_portfolio_social_link', true);
    ?>
    <div class="bdt-card bdt-card-default">

        <div class="bdt-position-relative">
            <?php get_template_part('template-parts/portfolio/media'); ?>
            <div class="bdt-position-cover bdt-overlay bdt-overlay-gradient bdt-position-z-index"></div>

            <?php if ($eooten_social_link != null) : ?>
                <ul class="bdt-list bdt-position-medium bdt-position-bottom-left bdt-position-z-index bdt-margin-remove-bottom">
                    <?php foreach ($eooten_social_link as $eooten_link) : ?>
                        <?php $eooten_tooltip = ucfirst(eooten_helper::icon($eooten_link)); ?>
                        <li class="bdt-display-inline-block">
                            <a <?php eooten_helper::attrs(['href' => $eooten_link, 'class' => 'bdt-margin-small-right']); ?> bdt-icon="icon: <?php echo eooten_helper::icon($eooten_link); ?>" title="<?php echo esc_attr($eooten_tooltip); ?>" bdt-tooltip></a>
                        </li>
                    <?php endforeach ?>
                </ul>
            <?php endif; ?>


        </div>

        <div class="bdt-card-header">
            <h3 class="bdt-card-title"><?php echo get_the_title() . ' ';
                                        esc_html_e('Info', 'eooten'); ?></h3>
        </div>

        <div class="bdt-card-body">
            <?php if ($eooten_badge != null) : ?>
                <div class="bdt-card-badge bdt-label"><?php echo esc_html($eooten_badge); ?></div>
            <?php endif; ?>

            <ul class="bdt-list bdt-list-divider bdt-margin-small-bottom bdt-padding-remove">

                <?php if ($eooten_email != null) : ?>
                    <li class="">
                        <div class="bdt-grid-small bdt-flex-bottom" bdt-grid>
                            <div class="bdt-width-expand" bdt-leader><?php echo esc_html_e('Email: ', 'eooten'); ?></div>
                            <div class="bdt-width-auto bdt-text-bold"><?php echo esc_html($eooten_email); ?></div>
                        </div>

                    </li>
                <?php endif; ?>

                <?php if ($eooten_phone != null) : ?>
                    <li class="">
                        <div class="bdt-grid-small bdt-flex-bottom" bdt-grid>
                            <div class="bdt-width-expand" bdt-leader><?php echo esc_html_e('Phone Number: ', 'eooten'); ?></div>
                            <div class="bdt-width-auto bdt-text-bold"><?php echo esc_html($eooten_phone); ?></div>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <?php if ($eooten_appointment_link != null) : ?>
            <div class="bdt-card-footer">
                <a href="<?php echo esc_url($eooten_appointment_link); ?>" class="bdt-button bdt-button-primary bdt-border-rounded bdt-text-bold bdt-width-1-1"><?php echo ($eooten_link_title) ? $eooten_link_title : esc_html__('Appointment Now', 'eooten'); ?></a>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>