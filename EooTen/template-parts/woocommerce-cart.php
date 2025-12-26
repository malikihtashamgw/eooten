<?php

/**
 * Template part for displaying woocommerce cart
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://docs.woocommerce.com/document/template-structure/
 */


if (class_exists('Woocommerce')) {

	$eooten_layout_c        = get_theme_mod('header_layout', 'default');
	$eooten_layout_m        = get_post_meta(get_the_ID(), 'header_layout', true);
	$eooten_layout          = (!empty($eooten_layout_m) and $eooten_layout_m != 'default') ? $eooten_layout_m : $eooten_layout_c;

	$eooten_cart = get_theme_mod('woocommerce_cart');

	if ($eooten_cart !== 'no') {
		global $woocommerce;
		$eooten_wcrtl = (is_rtl()) ? 'left' : 'right';
		$eooten_offset = ($eooten_cart == 'toolbar') ? 15 : 30;
?>

		<div class="tm-cart-popup">
			<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="tm-shopping-cart" title="<?php esc_attr_e('View Cart', 'eooten'); ?>">
				<span bdt-icon="icon: cart"></span>
				<?php
				$eooten_product_bumber = $woocommerce->cart->cart_contents_count;
				if ($eooten_cart == 'header') {
					if (sizeof($woocommerce->cart->cart_contents) != 0) {
						echo '<span class="pcount">' . esc_html($eooten_product_bumber) . '</span>';
					}
				}
				if ($eooten_cart == 'toolbar') {
					echo '<div class="bdt-hidden-small bdt-display-inline">';
					if (sizeof($woocommerce->cart->cart_contents) == 0) {
						esc_html_e('Cart is Empty', 'eooten');
					} else {
						echo sprintf(_n('%s Item in cart', '%s Items in cart', $eooten_product_bumber, 'eooten'), $eooten_product_bumber);
					}
					echo '</div>';
				}
				?>
			</a>

			<?php if (!in_array($eooten_layout, ['side-left', 'side-right'])) : ?>
				<?php if (sizeof($woocommerce->cart->cart_contents) != 0 and !is_checkout() and !is_cart()) : ?>
					<div class="cart-dropdown bdt-drop" bdt-drop="mode: hover; offset: <?php echo esc_attr($eooten_offset); ?>; pos: bottom-right;">
						<div class="bdt-card bdt-card-body bdt-card-default">
							<?php the_widget('WC_Widget_Cart', ''); ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>

		</div>
<?php }
} ?>