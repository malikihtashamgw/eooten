<?php

/**
 * Template part for displaying default logo
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
$eooten_layout_c    = get_theme_mod('eooten_header_layout', 'default');
$eooten_layout_m    = get_post_meta(get_the_ID(), 'eooten_header_layout', true);
$eooten_layout      = (!empty($eooten_layout_m) and $eooten_layout_m != 'default') ? $eooten_layout_m : $eooten_layout_c;
$eooten_logo        = get_theme_mod('eooten_logo_default');
$eooten_logo_width  = get_theme_mod('eooten_logo_width_default');


$eooten_logo_mode              = ($eooten_logo) ? 'tm-logo-img' : 'tm-logo-text';
$eooten_class                  = ['bdt-logo'];
$eooten_class[]                = (!in_array($eooten_layout, ['stacked-left-a', 'stacked-left-b', 'stacked-center-b', 'stacked-center-a', 'side-left', 'side-right']))  ? 'bdt-navbar-item' : '';
$eooten_class[]                = $eooten_logo_mode;
$eooten_width                  = ($eooten_logo_width) ? $eooten_logo_width : '';
$eooten_img_atts               = [];
$eooten_img_atts['class'][]    = 'bdt-responsive-height';
$eooten_img_atts['itemprop'][] = 'logo';
$eooten_img_atts['alt'][]      = get_bloginfo('name');

$eooten_img_atts['src'][]      = esc_url($eooten_logo);
$eooten_img_atts['style'][]    = 'width:' . esc_attr($eooten_width);


?>

<a href="<?php echo esc_url(home_url('/')); ?>" <?php eooten_helper::attrs(['class' => $eooten_class]) ?> itemprop="url">
    <?php if ($eooten_logo or !empty($eooten_custom_logo)) : ?>
        <img <?php eooten_helper::attrs($eooten_img_atts) ?>>
    <?php else : ?>
        <?php bloginfo('name'); ?>
    <?php endif; ?>
</a>