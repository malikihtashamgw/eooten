<?php

/**
 * Template part for displaying posts.
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

if (get_theme_mod('eooten_footer_widgets', 1) && get_post_meta(get_the_ID(), 'eooten_footer_widgets', true) != 'hide') {

	$eooten_id                  = 'tm-bottom';
	$eooten_class               = ['tm-bottom', 'bdt-section'];
	$eooten_section             = '';
	$eooten_section_media       = [];
	$eooten_section_image       = '';
	$eooten_container_class     = [];
	$eooten_grid_class          = ['bdt-grid', 'bdt-margin'];
	$eooten_bottom_width        = get_theme_mod('eooten_bottom_width', 'default');
	$eooten_breakpoint          = get_theme_mod('eooten_bottom_breakpoint', 'm');
	$eooten_vertical_align      = get_theme_mod('eooten_bottom_vertical_align');
	$eooten_match_height        = get_theme_mod('eooten_bottom_match_height');
	$eooten_column_divider      = get_theme_mod('eooten_bottom_column_divider');
	$eooten_gutter              = get_theme_mod('eooten_bottom_gutter');
	$eooten_columns             = get_theme_mod('eooten_footer_columns', 4);
	$eooten_first_column_expand = get_theme_mod('eooten_footer_fce');


	$eooten_layout         = get_post_meta(get_the_ID(), 'eooten_bottom_layout', true);
	$eooten_metabox_layout = (!empty($eooten_layout) and $eooten_layout != 'default') ? true : false;
	$eooten_position       = (get_post_meta(get_the_ID(), 'eooten_page_layout', true)) ? get_post_meta(get_the_ID(), 'eooten_page_layout', true) : get_theme_mod('eooten_page_layout', 'sidebar-right');

	if ($eooten_metabox_layout) {
		$eooten_bg_style = get_post_meta(get_the_ID(), 'eooten_bottom_bg_style', true);
		$eooten_bg_style = (!empty($eooten_bg_style)) ? $eooten_bg_style : get_theme_mod('eooten_bottom_bg_style');
		$eooten_padding  = get_post_meta(get_the_ID(), 'eooten_bottom_padding', true);
		$eooten_text     = get_post_meta(get_the_ID(), 'eooten_bottom_txt_style', true);
	} else {
		$eooten_bg_style = get_theme_mod('eooten_bottom_bg_style', 'secondary');
		$eooten_padding  = get_theme_mod('eooten_bottom_padding', 'medium');
		$eooten_text     = get_theme_mod('eooten_bottom_txt_style');
	}

	$eooten_section_image         = get_theme_mod('eooten_bottom_bg_img');
	$eooten_section_bg_img_pos    = get_theme_mod('eooten_bottom_bg_img_position');
	$eooten_section_bg_img_attach = get_theme_mod('eooten_bottom_bg_img_fixed');
	$eooten_section_bg_img_vis    = get_theme_mod('eooten_bottom_bg_img_visibility');


	// Image
	if ($eooten_section_image &&  $eooten_bg_style == 'media') {
		$eooten_section_media['style'][] = "background-image: url('{$eooten_section_image}');";
		// Settings
		$eooten_section_media['class'][] = 'bdt-background-norepeat';
		$eooten_section_media['class'][] = $eooten_section_bg_img_pos ? "bdt-background-{$eooten_section_bg_img_pos}" : '';
		$eooten_section_media['class'][] = $eooten_section_bg_img_attach ? "bdt-background-fixed" : '';
		$eooten_section_media['class'][] = $eooten_section_bg_img_vis ? "bdt-background-image@{$eooten_section_bg_img_vis}" : '';
	}

	$eooten_class[] = ($eooten_position == 'full' and $name == 'tm-main') ? 'bdt-padding-remove-vertical' : ''; // section spacific override

	$eooten_class[] = ($eooten_bg_style) ? 'bdt-section-' . $eooten_bg_style : '';

	$eooten_class[] = ($eooten_text) ? 'bdt-' . $eooten_text : '';
	if ($eooten_padding != 'none') {
		$eooten_class[]       = ($eooten_padding) ? 'bdt-section-' . $eooten_padding : '';
	} elseif ($eooten_padding == 'none') {
		$eooten_class[]       = ($eooten_padding) ? 'bdt-padding-remove-vertical' : '';
	}



	$eooten_container_class[] = ($eooten_bottom_width) ? 'bdt-container bdt-container-' . $eooten_bottom_width : '';

	$eooten_grid_class[]      = ($eooten_gutter) ? 'bdt-grid-' . $eooten_gutter : '';
	$eooten_grid_class[]      = ($eooten_column_divider && $eooten_gutter != 'collapse') ? 'bdt-grid-divider' : '';
	$eooten_grid_class[]      = ($eooten_breakpoint) ? 'bdt-child-width-expand@' . $eooten_breakpoint : '';
	$eooten_grid_class[]      = ($eooten_vertical_align) ? 'bdt-flex-middle' : '';
	$eooten_match_height = (!$eooten_vertical_align && $eooten_match_height) ? ' bdt-height-match="target: > div > div > .bdt-card"' : '';

	$eooten_expand_columns    = intval($eooten_columns) + 1;
	$eooten_column_class      = ($eooten_first_column_expand) ? ' bdt-width-1-' . $eooten_expand_columns . '@l' : '';

	if (is_active_sidebar('footer-widgets')) : ?>
		<div <?php eooten_helper::attrs(['id' => $eooten_id, 'class' => $eooten_class], $eooten_section_media); ?>>
			<div <?php eooten_helper::attrs(['class' => $eooten_container_class]) ?>>

				<?php if (is_active_sidebar('bottom-widgets')) : ?>
					<div class="bottom-widgets bdt-child-width-expand@s" data-bdt-grid><?php if (dynamic_sidebar('bottom-widgets')); ?></div>
					<hr class="bdt-margin-medium">
				<?php endif; ?>

				<div <?php eooten_helper::attrs(['class' => $eooten_grid_class]) ?> data-bdt-grid<?php echo esc_attr($eooten_match_height); ?>>

					<?php if (is_active_sidebar('footer-widgets') && $eooten_columns) : ?>
						<div class="bottom-columns"><?php if (dynamic_sidebar('Footer Widgets')); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
<?php endif;
}
