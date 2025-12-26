<?php

/**
 * Template part for displaying mobile logo
 * @package eooten
 * @since 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
$eooten_logo                   = get_theme_mod('eooten_logo_mobile');
$eooten_logo_width             = get_theme_mod('eooten_logo_width_mobile');
$eooten_width                  = ($eooten_logo_width) ? $eooten_logo_width : '';
$eooten_img_atts               = [];
$eooten_img_atts['class'][]    = 'bdt-responsive-height';
$eooten_img_atts['style'][]    = 'width:' . esc_attr($eooten_width);
$eooten_img_atts['src'][]      = esc_url($eooten_logo);
$eooten_img_atts['itemprop'][] = 'logo';
$eooten_img_atts['alt'][]      = get_bloginfo('name');

?>

<a href="<?php echo esc_url(home_url('/')); ?>" <?php eooten_helper::attrs(['class' => 'bdt-logo bdt-navbar-item']) ?> itemprop="url">
    <?php if ($eooten_logo) : ?>
        <img <?php eooten_helper::attrs($eooten_img_atts) ?>>
    <?php else : ?>
        <?php bloginfo('name'); ?>
    <?php endif; ?>
</a>