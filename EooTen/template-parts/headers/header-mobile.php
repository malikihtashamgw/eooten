<?php

// Options
$eooten_logo            = get_theme_mod('eooten_logo_mobile');;
$eooten_mobile          = get_theme_mod('mobile', []);
$eooten_logo_align      = get_theme_mod('eooten_mobile_logo_align', 'center');
$eooten_menu_align      = get_theme_mod('eooten_mobile_menu_align', 'left');
$eooten_search_align    = get_theme_mod('eooten_mobile_search_align', 'right');
$eooten_offcanvas_style = get_theme_mod('eooten_mobile_offcanvas_style', 'offcanvas');
$eooten_offcanvas_mode  = get_theme_mod('eooten_mobile_offcanvas_mode', 'slide');
$eooten_menu_text       = get_theme_mod('eooten_mobile_menu_text');
$eooten_shadow          = get_theme_mod('eooten_header_shadow', 'small');
$eooten_break_point     = 'bdt-hidden@' . get_theme_mod('eooten_mobile_break_point', 'm');
$eooten_class           = ['tm-header-mobile', $eooten_break_point];
$eooten_class[]         = ($eooten_shadow) ? 'bdt-box-shadow-' . $eooten_shadow : '';


$eooten_offcanvas_color = get_theme_mod('eooten_offcanvas_color', 'dark');
$eooten_offcanvas_color = ($eooten_offcanvas_color !== 'custom') ? 'bdt-' . $eooten_offcanvas_color : 'custom-color';


$eooten_search_align = false; // TODO

?>
<div <?php eooten_helper::attrs(['class' => $eooten_class]) ?>>
    <nav class="bdt-navbar-container" data-bdt-navbar>

        <?php if ($eooten_logo_align == 'left' || $eooten_menu_align == 'left' || $eooten_search_align == 'left') : ?>
            <div class="bdt-navbar-left">

                <?php if ($eooten_menu_align == 'left') : ?>
                    <a class="bdt-navbar-toggle" href="#tm-mobile" data-bdt-toggle<?php echo ($eooten_offcanvas_style == 'dropdown') ? '="animation: true"' : '' ?>>
                        <span data-bdt-navbar-toggle-icon></span>
                        <?php if ($eooten_menu_text) : ?>
                            <span class="bdt-margin-small-left"><?php esc_html_e('Menu', 'eooten') ?></span>
                        <?php endif ?>
                    </a>
                <?php endif ?>

                <?php if ($eooten_search_align == 'left') : ?>
                    <a class="bdt-navbar-item"><?php esc_html_e('Search', 'eooten') ?></a>
                <?php endif ?>

                <?php if ($eooten_logo_align == 'left') : ?>
                    <?php get_template_part('template-parts/logo-mobile'); ?>
                <?php endif ?>

            </div>
        <?php endif ?>

        <?php if ($eooten_logo_align == 'center') : ?>
            <div class="bdt-navbar-center">
                <?php get_template_part('template-parts/logo-mobile'); ?>
            </div>
        <?php endif ?>

        <?php if ($eooten_logo_align == 'right' || $eooten_menu_align == 'right' || $eooten_search_align == 'right') : ?>
            <div class="bdt-navbar-right">

                <?php if ($eooten_logo_align == 'right') : ?>
                    <?php get_template_part('template-parts/logo-mobile'); ?>
                <?php endif ?>

                <?php if ($eooten_search_align == 'right') : ?>
                    <a class="bdt-navbar-item"><?php esc_html_e('Search', 'eooten') ?></a>
                <?php endif ?>

                <?php if ($eooten_menu_align == 'right') : ?>
                    <a class="bdt-navbar-toggle" href="#tm-mobile" data-bdt-toggle<?php echo ($eooten_offcanvas_style) == 'dropdown' ? '="animation: true"' : '' ?>>
                        <?php if ($eooten_menu_text) : ?>
                            <span class="bdt-margin-small-right"><?php esc_html_e('Menu', 'eooten') ?></span>
                        <?php endif ?>
                        <span data-bdt-navbar-toggle-icon></span>
                    </a>
                <?php endif ?>

            </div>
        <?php endif ?>

    </nav>

    <?php if ($eooten_shadow == 'special') : ?>
        <div class="tm-header-shadow">
            <div></div>
        </div>
    <?php endif; ?>

    <?php if (is_active_sidebar('offcanvas') or has_nav_menu('offcanvas')) :

        if ($eooten_offcanvas_style == 'offcanvas') : ?>
            <div id="tm-mobile" class="<?php echo esc_attr($eooten_offcanvas_color); ?>" bdt-offcanvas mode="<?php echo esc_html($eooten_offcanvas_mode); ?>" overlay>
                <div class="bdt-offcanvas-bar bdt-dark">
                    <?php get_template_part('template-parts/offcanvas'); ?>
                </div>
            </div>
        <?php endif ?>

        <?php if ($eooten_offcanvas_style == 'modal') : ?>
            <div id="tm-mobile" class="bdt-modal-full <?php echo esc_attr($eooten_offcanvas_color); ?>" bdt-modal>
                <div class="bdt-modal-dialog bdt-modal-body">
                    <button class="bdt-modal-close-full" type="button" bdt-close></button>
                    <div class="bdt-flex bdt-flex-center bdt-flex-middle" bdt-height-viewport>
                        <?php get_template_part('template-parts/offcanvas'); ?>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <?php if ($eooten_offcanvas_style == 'dropdown') : ?>
            <div class="bdt-position-relative bdt-position-z-index">
                <div id="tm-mobile" class="bdt-box-shadow-medium<?php echo ($eooten_offcanvas_mode == 'slide') ? ' bdt-position-top' : '' ?> <?php echo esc_attr($eooten_offcanvas_color); ?>" hidden>
                    <div class="bdt-background-default bdt-padding">
                        <?php get_template_part('template-parts/offcanvas'); ?>
                    </div>
                </div>
            </div>
        <?php endif ?>

    <?php else : ?>
        <div id="tm-mobile" class="<?php echo esc_attr($eooten_offcanvas_color); ?>" bdt-offcanvas mode="<?php echo esc_html($eooten_offcanvas_mode); ?>" overlay>
            <div class="bdt-offcanvas-bar">
                <?php esc_html_e('Ops! You don\'t have any menu or widget in Off-canvas. Please add some menu in Off-canvas menu position or add some widget in Off-canvas widget position for view them here.', 'eooten'); ?>
            </div>
        </div>
    <?php endif; ?>
</div>