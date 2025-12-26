<?php

/**
 * Template part for displaying toolbar
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 */
$eooten_classes            = ['bdt-container', 'bdt-flex bdt-flex-middle'];
$eooten_mb_toolbar         = (get_post_meta(get_the_ID(), 'eooten_toolbar', true) != null) ? get_post_meta(get_the_ID(), 'eooten_toolbar', true) : false;
$eooten_tm_toolbar         = (get_theme_mod('eooten_toolbar', 0)) ? 1 : 0;
$eooten_toolbar_left       = get_theme_mod('eooten_toolbar_left', 'tagline');
$eooten_toolbar_right      = get_theme_mod('eooten_toolbar_right', 'social');
$eooten_toolbar_cart       = get_theme_mod('eooten_woocommerce_cart');
$eooten_classes[]          = (get_theme_mod('eooten_toolbar_fullwidth')) ? 'bdt-container-expand' : '';
$eooten_toolbar_left_hide  = (get_theme_mod('eooten_toolbar_left_hide_mobile')) ? ' bdt-visible@s' : '';
$eooten_toolbar_right_hide = (get_theme_mod('eooten_toolbar_right_hide_mobile')) ? ' bdt-visible@s' : '';
$eooten_toolbar_full_hide  = ($eooten_toolbar_left_hide and $eooten_toolbar_right_hide) ? ' bdt-visible@s' : '';

?>

<?php if ($eooten_tm_toolbar and $eooten_mb_toolbar != true) : ?>
	<div class="tm-toolbar<?php echo esc_attr($eooten_toolbar_full_hide); ?>">
		<div <?php eooten_helper::attrs(['class' => $eooten_classes]) ?>>

			<?php if (!empty($eooten_toolbar_left)) : ?>
				<div class="tm-toolbar-l<?php echo esc_attr($eooten_toolbar_left_hide); ?>"><?php get_template_part('template-parts/toolbars/' . $eooten_toolbar_left); ?></div>
			<?php endif; ?>

			<?php if (!empty($eooten_toolbar_right) or $eooten_toolbar_cart == 'toolbar') : ?>
				<div class="tm-toolbar-r bdt-margin-auto-left bdt-flex<?php echo esc_attr($eooten_toolbar_right_hide); ?>">
					<?php if ($eooten_toolbar_cart == 'toolbar') : ?>
						<div class="bdt-display-inline-block">
							<?php get_template_part('template-parts/toolbars/' . $eooten_toolbar_right); ?>
						</div>
						<div class="bdt-display-inline-block bdt-margin-small-left">
							<?php get_template_part('template-parts/woocommerce-cart'); ?>
						</div>
					<?php else : ?>
						<?php get_template_part('template-parts/toolbars/' . $eooten_toolbar_right); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
<?php endif; ?>