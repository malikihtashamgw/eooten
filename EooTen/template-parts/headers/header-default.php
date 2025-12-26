<?php

/**
 * @package   eooten
 * @author    Malik Ihtasham https://easywebnet.com/
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

$eooten_container_media = [];
$eooten_container_image = '';
// Options
$eooten_layout_c        = get_theme_mod('eooten_header_layout', 'default');
$eooten_layout_m        = get_post_meta(get_the_ID(), 'eooten_header_layout', true);
$eooten_layout          = (!empty($eooten_layout_m) and $eooten_layout_m != 'default') ? $eooten_layout_m : $eooten_layout_c;

$eooten_fullwidth       = get_theme_mod('eooten_header_fullwidth');
$eooten_logo            = get_theme_mod('eooten_logo_default');
$eooten_class           = array_merge(['tm-header', 'bdt-visible@' . get_theme_mod('eooten_mobile_break_point', 'm')]);
$eooten_search          = get_theme_mod('eooten_search_position', 'header');

$eooten_transparent     = get_theme_mod('eooten_header_transparent');

$eooten_sticky          = get_theme_mod('eooten_header_sticky');
$eooten_cart            = get_theme_mod('eooten_woocommerce_cart');
$eooten_menu_text       = get_theme_mod('eooten_mobile_menu_text');
$eooten_offcanvas_mode  = get_theme_mod('eooten_mobile_offcanvas_mode', 'push');
$eooten_shadow          = get_theme_mod('eooten_header_shadow', 'small');

$eooten_bg_style = get_theme_mod('eooten_header_bg_style');
$eooten_width    = get_theme_mod('eooten_header_width');
$eooten_padding  = get_theme_mod('eooten_header_padding');
$eooten_text     = get_theme_mod('eooten_header_txt_style');

$eooten_container_image         = get_theme_mod('eooten_header_bg_img');
$eooten_container_bg_img_pos    = get_theme_mod('eooten_header_bg_img_position');


// Image
if ($eooten_container_image &&  $eooten_bg_style == 'media') {
	$eooten_container_media['style'][] = "background-image: url( '{$eooten_container_image}' );";
	// Settings
	$eooten_container_media['class'][] = 'bdt-background-norepeat';
	$eooten_container_media['class'][] = $eooten_container_bg_img_pos ? "bdt-background-{$eooten_container_bg_img_pos}" : '';
}

// Container
$eooten_container            = ['class' => ['bdt-navbar-container', 'tm-primary-navbar']];
$eooten_container['class'][] = ($eooten_bg_style && ($eooten_transparent == false or $eooten_transparent == 'no')) ? 'navbar-color-' . $eooten_bg_style : '';
$eooten_class[]              = ($eooten_text) ? 'bdt-' . $eooten_text : '';
$eooten_class[]              = ($eooten_shadow) ? 'bdt-box-shadow-' . $eooten_shadow : '';


// Transparent
if ($eooten_transparent != false and $eooten_transparent != 'no') {
	$eooten_class[] = 'tm-header-transparent';
	$eooten_container['class'][] = "bdt-navbar-transparent bdt-{$eooten_transparent}";
}

$eooten_navbar_attrs = ['class' => 'bdt-navbar'];


if (is_admin_bar_showing()) {
	$eooten_offset = '32';
} else {
	$eooten_offset = 0;
}

// Sticky
if ($eooten_sticky != false and $eooten_sticky != 'no') {
	$eooten_container['bdt-sticky'] = json_encode(array_filter([
		'media'       => 768,
		'show-on-up'  => $eooten_sticky == 'smart',
		'animation'   => $eooten_transparent || $eooten_sticky == 'smart' ? 'bdt-animation-slide-top' : '',
		'top'         => $eooten_transparent ? '!.js-sticky' : 1,
		'offset' 	  => $eooten_offset,
		'clsActive'   => 'bdt-active bdt-navbar-sticky',
		'clsInactive' => $eooten_transparent ? "bdt-navbar-transparent bdt-{$eooten_transparent}" : false,
	]));
}
?>

<?php if ($eooten_transparent) : ?>
	<div <?php eooten_helper::attrs(['class' => 'js-sticky']) ?>>
	<?php endif; ?>
	<div <?php eooten_helper::attrs(['class' => $eooten_class]) ?>>
		<?php if ($eooten_layout == 'default') : ?>
			<div <?php eooten_helper::attrs($eooten_container, $eooten_container_media) ?>>
				<div class="bdt-container <?php echo ($eooten_fullwidth) ? 'bdt-container-expand' : '' ?>">
					<nav <?php eooten_helper::attrs($eooten_navbar_attrs) ?>>

						<div class="bdt-navbar-left">
							<?php get_template_part('template-parts/logo-default'); ?>
							<?php if ($eooten_layout == 'default' and has_nav_menu('primary')) : ?>
								<?php get_template_part('template-parts/menu-primary'); ?>
								<?php if ($eooten_search == 'menu') : ?>
									<div class="bdt-navbar-item">
										<?php get_template_part('template-parts/search'); ?>
									</div>
								<?php endif ?>
							<?php endif ?>
						</div>

						<?php if ($eooten_layout == 'horizontal-center' && has_nav_menu('primary')) : ?>
							<div class="bdt-navbar-center">
								<?php get_template_part('template-parts/menu-primary'); ?>
								<?php if ($eooten_search == 'menu') : ?>
									<div class="bdt-navbar-item">
										<?php get_template_part('template-parts/search'); ?>
									</div>
								<?php endif ?>
							</div>
						<?php endif ?>

						<?php if (is_active_sidebar('headerbar') || $eooten_layout == 'horizontal-right' || $eooten_search == 'header' || has_nav_menu('primary') || $eooten_cart == 'header') : ?>
							<div class="bdt-navbar-right">
								<?php if ($eooten_layout == 'horizontal-right' && has_nav_menu('primary')) : ?>
									<?php get_template_part('template-parts/menu-primary'); ?>
								<?php endif ?>

								<?php if ($eooten_layout == 'horizontal-right' && $eooten_search == 'menu') : ?>
									<div class="bdt-navbar-item">
										<?php get_template_part('template-parts/search'); ?>
									</div>
								<?php endif ?>

								<?php if (is_active_sidebar('headerbar')) : ?>
									<div class="bdt-navbar-item">
										<?php dynamic_sidebar('headerbar') ?>
									</div>
								<?php endif; ?>

								<?php if (($eooten_layout == 'default' || $eooten_layout == 'horizontal-center' || $eooten_layout == 'horizontal-right') && $eooten_search == 'header') : ?>
									<div class="bdt-navbar-item">
										<?php get_template_part('template-parts/search'); ?>
									</div>
								<?php endif ?>

								<?php if (($eooten_layout == 'default' || $eooten_layout == 'horizontal-center' || $eooten_layout == 'horizontal-right') && $eooten_cart == 'header') : ?>
									<div class="bdt-navbar-item">
										<?php get_template_part('template-parts/woocommerce-cart'); ?>
									</div>
								<?php endif ?>
							</div>
						<?php endif ?>
					</nav>
				</div>
			</div>
			<?php //endif
			?>
		<?php elseif (in_array($eooten_layout, ['stacked-center-a', 'stacked-center-b', 'stacked-center-split'])) : ?>
			<?php if ($eooten_layout != 'stacked-center-split' || $eooten_layout == 'stacked-center-a' && is_active_sidebar('headerbar')) : ?>
				<div class="tm-headerbar-top">
					<div class="bdt-container<?php echo ($eooten_fullwidth) ? ' bdt-container-expand' : '' ?>">

						<div class="bdt-text-center bdt-position-relative">
							<?php get_template_part('template-parts/logo-default'); ?>
							<?php if ($eooten_layout == 'stacked-center-a') : ?>
								<div>
									<img class="center-logo-art" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/header-art-01.svg" width="250" alt="">
								</div>
							<?php endif; ?>
						</div>

						<?php if ($eooten_layout == 'stacked-center-a' && is_active_sidebar('headerbar')) : ?>
							<div class="tm-headerbar-stacked bdt-grid-medium bdt-child-width-auto bdt-flex-center bdt-flex-middle bdt-margin-medium-top" bdt-grid>
								<?php dynamic_sidebar('headerbar') ?>
							</div>
						<?php endif ?>

					</div>
				</div>
			<?php endif ?>

			<?php if (has_nav_menu('primary')) : ?>
				<div <?php eooten_helper::attrs($eooten_container) ?>>

					<div class="bdt-container <?php echo ($eooten_fullwidth) ? 'bdt-container-expand' : '' ?>">
						<nav <?php eooten_helper::attrs($eooten_navbar_attrs) ?>>
							<div class="bdt-navbar-center">
								<?php get_template_part('template-parts/menu-primary'); ?>
							</div>

						</nav>
					</div>

				</div>
			<?php endif ?>

			<?php if (in_array($eooten_layout, ['stacked-center-b', 'stacked-center-split']) && is_active_sidebar('headerbar')) : ?>
				<div class="tm-headerbar-bottom">
					<div class="bdt-container <?php echo ($eooten_fullwidth) ? 'bdt-container-expand' : '' ?>">
						<div class="bdt-grid-medium bdt-child-width-auto bdt-flex-center bdt-flex-middle" data-bdt-grid>
							<?php dynamic_sidebar('headerbar') ?>
						</div>
					</div>
				</div>
			<?php endif ?>
		<?php elseif ($eooten_layout == 'stacked-left-a' || $eooten_layout == 'stacked-left-b') : ?>
			<?php if ($eooten_logo || is_active_sidebar('headerbar')) : ?>
				<div class="tm-headerbar-top">
					<div class="bdt-container <?php echo ($eooten_fullwidth) ? 'bdt-container-expand' : '' ?> bdt-flex bdt-flex-middle">

						<?php get_template_part('template-parts/logo-default'); ?>

						<?php if (is_active_sidebar('headerbar') or $eooten_search) : ?>
							<div class="bdt-margin-auto-left">
								<div class="bdt-grid-medium bdt-child-width-auto bdt-flex-middle" data-bdt-grid>

									<?php if ($eooten_layout == 'stacked-left-a') : ?>
										<?php dynamic_sidebar('headerbar') ?>
									<?php endif ?>


									<?php if ($eooten_search == 'header') : ?>
										<div>
											<?php get_template_part('template-parts/search'); ?>
										</div>
									<?php endif ?>

									<?php if ($eooten_cart == 'header') : ?>
										<div>
											<?php get_template_part('template-parts/woocommerce-cart'); ?>
										</div>
									<?php endif ?>
								</div>
							</div>
						<?php endif ?>

					</div>
				</div>
			<?php endif ?>

			<?php if (has_nav_menu('primary')) : ?>
				<div <?php eooten_helper::attrs($eooten_container) ?>>
					<div class="bdt-container <?php echo ($eooten_fullwidth) ? 'bdt-container-expand' : '' ?>">
						<nav <?php eooten_helper::attrs($eooten_navbar_attrs) ?>>

							<?php if ($eooten_layout == 'stacked-left-a') : ?>
								<div class="bdt-navbar-left">
									<?php get_template_part('template-parts/menu-primary'); ?>
									<?php if ($eooten_search == 'menu') : ?>
										<div class="bdt-navbar-item">
											<?php get_template_part('template-parts/search'); ?>
										</div>
									<?php endif ?>
								</div>
							<?php endif ?>

							<?php if ($eooten_layout == 'stacked-left-b') : ?>
								<div class="bdt-navbar-left bdt-flex-auto">
									<?php get_template_part('template-parts/menu-primary'); ?>

									<?php if ($eooten_layout == 'stacked-left-b') : ?>
										<div class="bdt-margin-auto-left bdt-navbar-item">
											<?php dynamic_sidebar('headerbar') ?>
										</div>
									<?php endif ?>

									<?php if ($eooten_search == 'menu') : ?>
										<div class="bdt-margin-auto-left bdt-navbar-item">
											<?php get_template_part('template-parts/search'); ?>
										</div>
									<?php endif ?>
								</div>
							<?php endif ?>

						</nav>
					</div>
				</div>
			<?php endif ?>
		<?php elseif ($eooten_layout == 'toggle-offcanvas' || $eooten_layout == 'toggle-modal') : ?>
			<div <?php eooten_helper::attrs($eooten_container) ?>>
				<div class="bdt-container <?php echo ($eooten_fullwidth) ? 'bdt-container-expand' : '' ?>">
					<nav <?php eooten_helper::attrs($eooten_navbar_attrs) ?>>
						<?php if ($eooten_logo) : ?>
							<div class="bdt-navbar-left">
								<?php get_template_part('template-parts/logo-default'); ?>
							</div>
						<?php endif ?>

						<?php if (has_nav_menu('primary')) : ?>
							<div class="bdt-navbar-right">
								<a class="bdt-navbar-toggle" href="#" data-bdt-toggle="target: !.bdt-navbar-container + [bdt-offcanvas], [bdt-modal]">
									<?php if ($eooten_menu_text) : ?>
										<span class="bdt-margin-small-right"><?php esc_html_e('Menu', 'eooten') ?></span>
									<?php endif ?>
									<div data-bdt-navbar-toggle-icon></div>
								</a>
							</div>
						<?php endif ?>

					</nav>
				</div>
			</div>
			<?php if ($eooten_layout == 'toggle-offcanvas' && (has_nav_menu('primary') || is_active_sidebar('headerbar'))) : ?>
				<div data-bdt-offcanvas="flip: true" data-mode="<?php echo esc_html($eooten_offcanvas_mode); ?>" data-overlay>
					<div class="bdt-offcanvas-bar">

						<?php
						if (has_nav_menu('primary')) {
							wp_nav_menu(
								[
									'theme_location' => 'primary',
									'container'      => false,
									'items_wrap'     => '<ul id="%1$eooten_s" class="%2$eooten_s" data-bdt-nav>%3$eooten_s</ul>',
									'menu_id'        => 'nav-offcanvas',
									'menu_class'     => 'bdt-nav bdt-nav-default bdt-nav-parent-icon',
									'echo'           => true,
									'before'         => '',
									'after'          => '',
									'link_before'    => '',
									'link_after'     => '',
									'depth'          => 0,
								]
							);
						}
						?>

						<?php if ($eooten_search == 'menu') : ?>
							<div class="bdt-margin-auto-left bdt-navbar-item">
								<?php get_template_part('template-parts/search'); ?>
							</div>
						<?php endif ?>

						<?php if (is_active_sidebar('headerbar')) : ?>
							<div class="bdt-margin-large-top">
								<?php dynamic_sidebar('headerbar') ?>
							</div>
						<?php endif ?>

						<?php if ($eooten_search == 'header') : ?>
							<div class="bdt-margin-auto-left bdt-navbar-item">
								<?php get_template_part('template-parts/search'); ?>
							</div>
						<?php endif ?>

					</div>
				</div>
			<?php elseif ($eooten_layout == 'toggle-modal' && (has_nav_menu('primary') || is_active_sidebar('headerbar'))) : ?>
				<div class="bdt-modal-full" data-bdt-modal>
					<div class="bdt-modal-dialog bdt-modal-body">
						<button class="bdt-modal-close-full" type="button" data-bdt-close></button>
						<div class="bdt-flex bdt-flex-center bdt-flex-middle bdt-text-center" bdt-height-viewport>
							<div>

								<?php
								if (has_nav_menu('primary')) {
									wp_nav_menu(
										[
											'theme_location' => 'primary',
											'container'      => false,
											'items_wrap'     => '<ul id="%1$eooten_s" class="%2$eooten_s" data-bdt-nav>%3$eooten_s</ul>',
											'menu_id'        => 'nav-offcanvas',
											'menu_class'     => 'bdt-nav bdt-nav-primary bdt-nav-center bdt-nav-parent-icon',
											'echo'           => true,
											'before'         => '',
											'after'          => '',
											'link_before'    => '',
											'link_after'     => '',
											'depth'          => 0,
										]
									);
								}
								?>

								<?php if ($eooten_search == 'menu') : ?>
									<div class="bdt-margin-auto-left bdt-navbar-item">
										<?php get_template_part('template-parts/search'); ?>
									</div>
								<?php endif ?>

								<?php if (is_active_sidebar('headerbar')) : ?>
									<div class="bdt-margin-large-top">
										<?php dynamic_sidebar('headerbar') ?>
									</div>
								<?php endif ?>

								<?php if ($eooten_search == 'header') : ?>
									<div class="bdt-margin-auto-left bdt-navbar-item">
										<?php get_template_part('template-parts/search'); ?>
									</div>
								<?php endif ?>

							</div>
						</div>
					</div>
				</div>
			<?php endif ?>

		<?php elseif ($eooten_layout == 'side-left' || $eooten_layout == 'side-right') : ?>
			<?php
			$eooten_sidebar_position = ($eooten_layout == 'side-left') ? ' bdt-position-left' : ' bdt-position-right';
			$eooten_sidebar_class = ['class' => ['bdt-position-fixed', 'bdt-position-z-index', 'bdt-padding', 'bdt-width-medium']];
			$eooten_sidebar_class['class'][] = $eooten_sidebar_position;
			$eooten_sidebar_class['class'][] = ($eooten_bg_style) ? 'bdt-background-' . $eooten_bg_style : '';
			$eooten_sidebar_class['class'][] = ($eooten_shadow) ? 'bdt-box-shadow-' . $eooten_shadow : '';
			?>
			<div <?php eooten_helper::attrs($eooten_sidebar_class, $eooten_container_media) ?>>
				<div class="">

					<div class="">
						<?php if ($eooten_logo) : ?>
							<div class="bdt-text-center">
								<?php get_template_part('template-parts/logo-default'); ?>
							</div>
						<?php endif ?>

						<?php
						if (has_nav_menu('primary')) {
							wp_nav_menu(
								[
									'theme_location' => 'primary',
									'container'      => false,
									'items_wrap'     => '<ul id="%1$eooten_s" class="%2$eooten_s" data-bdt-nav>%3$eooten_s</ul>',
									'menu_id'        => 'nav-offcanvas',
									'menu_class'     => 'bdt-nav bdt-nav-default bdt-nav-parent-icon bdt-margin-medium-top',
									'echo'           => true,
									'before'         => '',
									'after'          => '',
									'link_before'    => '',
									'link_after'     => '',
									'depth'          => 0,
								]
							);
						}
						?>

						<?php if ($eooten_search == 'menu') : ?>
							<div class="bdt-margin-auto-left bdt-margin-medium-top">
								<?php get_template_part('template-parts/search'); ?>
							</div>
						<?php endif ?>

					</div>



					<?php //if ($eooten_search == 'header' ) :
					?>
					<div class="tm-side-bottom bdt-text-uppercase bdt-text-small bdt-margin-large-top">

						<?php if (is_active_sidebar('headerbar')) : ?>
							<div class="bdt-margin-medium-bottom">
								<?php dynamic_sidebar('headerbar') ?>
							</div>
						<?php endif ?>

						<div class="bdt-margin-small-bottom bdt-grid-divider bdt-grid-small" data-bdt-grid>
							<?php if ($eooten_cart == 'header') : ?>
								<div class="tm-wpml">
									<?php get_template_part('template-parts/toolbars/wpml'); ?>
								</div>
							<?php endif ?>

							<?php if ($eooten_cart == 'header') : ?>
								<div class="">
									<?php get_template_part('template-parts/woocommerce-cart'); ?>
								</div>
							<?php endif ?>

							<?php if ($eooten_search == 'header') : ?>
								<div class="">
									<?php get_template_part('template-parts/search'); ?>
								</div>
							<?php endif ?>
						</div>

						<?php if (get_theme_mod('eooten_copyright_text_custom_show')) : ?>
							<div class="copyright-txt"><?php echo wp_kses_post(get_theme_mod('eooten_copyright_text_custom')); ?></div>
						<?php else : ?>
							<div class="copyright-txt">&copy; <?php esc_html_e('Copyright', 'eooten') ?> <?php echo esc_html(date("Y ")); ?> <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>"> <?php echo esc_html(bloginfo('name')); ?> </a></div>
						<?php endif; ?>
					</div>
					<?php //endif
					?>

				</div>
			</div>
		<?php endif ?>

		<?php if ($eooten_shadow == 'special') : ?>
			<div class="tm-header-shadow">
				<div></div>
			</div>
		<?php endif; ?>
	</div>
	<?php if ($eooten_transparent) : ?>
	</div>
<?php endif; ?>