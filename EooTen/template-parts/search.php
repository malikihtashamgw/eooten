<?php

/**
 * Template part for displaying search form
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 */
$eooten_style             = get_theme_mod('eooten_search_style', 'default');
$eooten_search            = [];
$eooten_toggle            = ['class' => 'bdt-search-icon bdt-padding-remove-horizontal'];
$eooten_layout_c          = get_theme_mod('eooten_header_layout', 'default');
$eooten_layout_m          = get_post_meta(get_the_ID(), 'eooten_header_layout', true);
$eooten_layout            = (!empty($eooten_layout_m) and $eooten_layout_m != 'default') ? $eooten_layout_m : $eooten_layout_c;
$eooten_position          = get_theme_mod('eooten_search_position', 'header');
$eooten_id                = esc_attr(uniqid('search-form-'));
$eooten_attrs['class']    = array_merge(['bdt-search'], isset($eooten_attrs['class']) ? (array) $eooten_attrs['class'] : []);
$eooten_search            = [];
$eooten_search['class']   = [];
$eooten_search['class'][] = 'bdt-search-input';

if (($eooten_layout == 'side-left' or $eooten_layout == 'side-right') and $eooten_position == 'menu') {
    $eooten_style = 'default';
}
// TODO
$eooten_navbar = [
    'dropdown_align'    => get_theme_mod('eooten_dropdown_align', 'left'),
    'dropdown_click'    => get_theme_mod('eooten_dropdown_click'),
    'dropdown_boundary' => get_theme_mod('eooten_dropdown_boundary'),
    'dropbar'           => get_theme_mod('eooten_dropbar'),
];

if ($eooten_style) {
    $eooten_search['autofocus'] = true;
}

if ($eooten_style == 'modal') {
    $eooten_search['class'][] = 'bdt-text-center';
    $eooten_attrs['class'][] = 'bdt-search-large';
} else {
    $eooten_attrs['class'][] = 'bdt-search-default';
}

if (in_array($eooten_style, ['dropdown', 'justify'])) {
    $eooten_attrs['class'][] = 'bdt-search-navbar';
    $eooten_attrs['class'][] = 'bdt-width-1-1';
}

?>

<?php if ($eooten_style == 'default') : // TODO renders the default style only
?>

    <?php get_search_form() ?>

<?php elseif ($eooten_style == 'drop') : ?>

    <a <?php eooten_helper::attrs($eooten_toggle) ?> href="#" data-bdt-search-icon></a>
    <div data-bdt-drop="mode: click; pos: left-center; offset: 0">
        <?php get_search_form() ?>
    </div>

<?php elseif (in_array($eooten_style, ['dropdown', 'justify'])) :

    $eooten_drop = [
        'mode'           => 'click',
        'cls-drop'       => 'bdt-navbar-dropdown',
        'boundary'       => $eooten_navbar['dropdown_align'] ? '!nav' : false,
        'boundary-align' => $eooten_navbar['dropdown_boundary'],
        'pos'            => $eooten_style == 'justify' ? 'bottom-justify' : 'bottom-right',
        'flip'           => 'x',
        'offset'         => !$eooten_navbar['dropbar'] ? 28 : 0
    ];

?>

    <a <?php eooten_helper::attrs($eooten_toggle) ?> href="#" data-bdt-search-icon></a>
    <div class="bdt-navbar-dropdown bdt-width-medium" <?php eooten_helper::attrs(['bdt-drop' => json_encode(array_filter($eooten_drop))]) ?>>
        <div class="bdt-grid bdt-grid-small bdt-flex-middle">
            <div class="bdt-width-expand">
                <?php get_search_form() ?>
            </div>
            <div class="bdt-width-auto">
                <a class="bdt-navbar-dropdown-close" href="#" data-bdt-close></a>
            </div>
        </div>

    </div>

<?php elseif ($eooten_style == 'modal') : ?>

    <a <?php eooten_helper::attrs($eooten_toggle) ?> href="#<?php echo esc_attr($eooten_id) . '-modal' ?>" data-bdt-search-icon data-bdt-toggle></a>

    <div id="<?php echo esc_attr($eooten_id) . '-modal' ?>" class="bdt-modal-full" data-bdt-modal>
        <div class="bdt-modal-dialog bdt-modal-body bdt-flex bdt-flex-center bdt-flex-middle" data-bdt-height-viewport>
            <button class="bdt-modal-close-full" type="button" data-bdt-close></button>
            <div class="bdt-search bdt-search-large">
                <?php get_search_form() ?>
            </div>
        </div>
    </div>

<?php endif ?>