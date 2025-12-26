<?php

/**
 * Template part for displaying site copyright
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

if (get_post_meta(get_the_ID(), 'eooten_copyright', true) != 'hide') {

	$eooten_class             = ['tm-copyright', 'bdt-section', 'bdt-section-' . get_theme_mod('eooten_copyright_bg_style') . '', 'bdt-section-' . get_theme_mod('eooten_copyright_padding') . '', 'bdt-text-' . get_theme_mod('eooten_copyright_align', 'left') . ''];
	$eooten_container_class   = ['bdt-container', 'bdt-container-' . get_theme_mod('eooten_copyright_width') . ''];
	$eooten_grid_class        = ['bdt-grid', 'bdt-flex', 'bdt-flex-middle', 'bdt-child-width-expand@m'];
	$background_image = '';

	if (get_theme_mod('eooten_copyright_bg_style') === 'media' and get_theme_mod('eooten_copyright_bg_img') != '') {
		ob_start();
		$background_image .= eooten_helper::attrs(['style' => 'background-image: url(' . get_theme_mod('eooten_copyright_bg_img') . ')']);
		$background_image .= ob_get_clean();
	}

?>

	<div id="tmCopyright" <?php eooten_helper::attrs(['class' => $eooten_class]) ?> <?php echo esc_attr($background_image) ?>>
		<div <?php eooten_helper::attrs(['class' => $eooten_container_class]) ?>>
			<div <?php eooten_helper::attrs(['class' => $eooten_grid_class]) ?> data-bdt-grid>
				<div class="bdt-width-expand@m">
					<?php if (has_nav_menu('copyright')) {
						echo wp_nav_menu(array('theme_location' => 'copyright', 'container_class' => 'tm-copyright-menu bdt-display-inline-block', 'menu_class' => 'bdt-subnav bdt-subnav-line bdt-subnav-divider bdt-margin-small-bottom', 'depth' => 1));
					}

					if (get_theme_mod('eooten_copyright_text_custom_show')) : ?>
						<div class="copyright-txt"><?php echo wp_kses_post(get_theme_mod('eooten_copyright_text_custom')); ?></div>
					<?php else : ?>
						<div class="copyright-txt">&copy; <?php esc_html_e('Copyright', 'eooten') ?> <?php echo esc_html(date("Y ")); ?> <?php esc_html_e('All Rights Reserved by', 'eooten') ?> <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>"> <?php echo esc_html(bloginfo('name')); ?> </a></div>
					<?php endif; ?>
				</div>
				<div class="bdt-width-auto@m">
					<?php get_template_part('template-parts/copyright-social'); ?>
				</div>
			</div>
		</div>
	</div>

<?php
}
