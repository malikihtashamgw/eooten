<?php

/**
 * The template for displaying woocommerce pages.
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */


get_header(); ?>


<?php
$eooten_product_columns = get_theme_mod('eooten_woocommerce_columns', 3);
$eooten_wooclass = 'product-columns-' . $eooten_product_columns;
// Get WooCommerce Layout from Theme Options
$eooten_position = get_theme_mod('eooten_woocommerce_sidebar', 'sidebar-left');

?>

<div <?php eooten_helper::section('main'); ?>>
	<div <?php eooten_helper::container(); ?>>
		<div <?php eooten_helper::grid(); ?>>


			<?php
			// Single Products Page
			if (is_product()) {
			?>

				<div class="bdt-width-expand">
					<main class="tm-content">

						<?php woocommerce_content(); ?>

					</main> <!-- end main -->
				</div> <!-- end width -->

			<?php

				// Main Shop Layout
			} else { ?>
				<div class="bdt-width-expand">
					<main class="tm-content <?php echo esc_attr($eooten_wooclass); ?>">
						<?php woocommerce_content(); ?>
					</main> <!-- end main -->
				</div> <!-- end width -->
			<?php } // end-if main shop layout
			?>


			<?php if (is_active_sidebar('shop-widgets') and ($eooten_position == 'sidebar-left' or $eooten_position == 'sidebar-right')) : ?>
				<aside <?php echo eooten_helper::sidebar($eooten_position); ?>>
					<?php if (is_woocommerce()) {
						/* WooCommerce Sidebar */
						if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('shop-widgets'));
					} ?>
				</aside> <!-- end aside -->
			<?php endif; ?>

		</div> <!-- end grid -->
	</div> <!-- end container -->
</div> <!-- end tm main -->

<?php get_footer(); ?>