<?php

$eooten_id             = 'tm-titlebar';
$eooten_titlebar_show  = ''; //rwmb_meta('eooten_titlebar');
$eooten_class          = '';
$eooten_section_media  = [];
$eooten_section_image  = '';
$eooten_layout         = get_post_meta(get_the_ID(), 'eooten_titlebar_layout', true);
$eooten_metabox_layout = (!empty($eooten_layout) and $eooten_layout != 'default') ? true : false;
$eooten_position       = (get_post_meta(get_the_ID(), 'eooten_page_layout', true)) ? get_post_meta(get_the_ID(), 'eooten_page_layout', true) : get_theme_mod('eooten_page_layout', 'sidebar-right');


$eooten_bg_style = get_theme_mod('eooten_titlebar_bg_style', 'muted');
$eooten_width    = get_theme_mod('eooten_titlebar_width', 'default');
$eooten_padding  = get_theme_mod('eooten_titlebar_padding', 'medium');
$eooten_text     = get_theme_mod('eooten_titlebar_txt_style');


if (is_array($eooten_class)) {
	$eooten_class = implode(' ', array_filter($eooten_class));
}


$eooten_section_image         = get_theme_mod('eooten_titlebar_bg_img');


// Image
if ($eooten_section_image &&  $eooten_bg_style == 'media') {
	$eooten_section_media['style'][] = "background-image: url('{$eooten_section_image}');";
	$eooten_section_media['class'][] = 'bdt-background-norepeat';
}


$eooten_class   = ['tm-titlebar', 'bdt-section', $eooten_class];

$eooten_class[] = ($eooten_bg_style) ? 'bdt-section-' . $eooten_bg_style : '';
$eooten_class[] = ($eooten_text) ? 'bdt-' . $eooten_text : '';
if ($eooten_padding != 'none') {
	$eooten_class[]       = ($eooten_padding) ? 'bdt-section-' . $eooten_padding : '';
} elseif ($eooten_padding == 'none') {
	$eooten_class[]       = ($eooten_padding) ? 'bdt-padding-remove-vertical' : '';
}



if ($eooten_titlebar_show !== 'hide') : ?>

	<?php
	global $post;
	$eooten_blog_title        = get_theme_mod('eooten_blog_title', esc_html__('Blog', 'eooten'));
	$eooten_woocommerce_title = get_theme_mod('eooten_woocommerce_title', esc_html__('Shop', 'eooten'));
	$eooten_titlebar_global   = get_theme_mod('eooten_titlebar_layout', 'left');
	$eooten_titlebar_metabox  = get_post_meta(get_the_ID(), 'eooten_titlebar_layout', true);
	$eooten_title             = get_the_title();

	?>

	<?php if (is_object($post) && !is_archive() && !is_search() && !is_404() && !is_author() && !is_home() && !is_page()) { ?>

		<?php if ($eooten_titlebar_metabox != 'default' && !empty($eooten_titlebar_metabox)) { ?>

			<?php if ($eooten_titlebar_metabox == 'left' or $eooten_titlebar_metabox == 'center' or $eooten_titlebar_metabox == 'right') { ?>
				<div <?php eooten_helper::attrs(['id' => $eooten_id, 'class' => $eooten_class], $eooten_section_media); ?>>
					<div <?php eooten_helper::container(); ?>>
						<div <?php eooten_helper::grid(); ?>>
							<div id="title" class="bdt-width-expand<?php echo ($eooten_titlebar_metabox == 'center') ? ' bdt-text-center' : ''; ?>">
								<h1 class="bdt-margin-small-bottom"><?php echo wp_kses_post($eooten_title); ?></h1>
								<?php eooten_breadcrumbs($eooten_titlebar_global); ?>
							</div>
							<?php if ($eooten_titlebar_metabox != 'center') : ?>
								<div class="bdt-margin-auto-left bdt-position-relative bdt-width-small bdt-visible@s">
									<div class="bdt-position-center-right">
										<a class="bdt-button-text bdt-link-reset" onclick="history.back()"><span class="bdt-margin-small-right" bdt-icon="icon: arrow-left"></span> <?php esc_html_e('Back', 'eooten'); ?></a>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php } ?>

		<?php } else { ?>
			<?php
			// Define the Title for different Pages
			if (is_home()) {
				$eooten_title = $eooten_blog_title;
			} elseif (is_search()) {
				$eooten_allsearch = new WP_Query("s=$s&showposts=-1");
				$eooten_count = $eooten_allsearch->post_count;
				wp_reset_postdata();
				$eooten_title = $eooten_count . ' ';
				$eooten_title .= esc_html__('Search results for:', 'eooten');
				$eooten_title .= ' ' . get_search_query();
			} elseif (class_exists('Woocommerce') && is_woocommerce()) {
				$eooten_title = $eooten_woocommerce_title;
			} elseif (is_archive()) {
				if (is_category()) {
					$eooten_title = single_cat_title('', false);
				} elseif (is_tag()) {
					$eooten_title = esc_html__('Posts Tagged:', 'eooten') . ' ' . single_tag_title('', false);
				} elseif (is_day()) {
					$eooten_title = esc_html__('Archive for', 'eooten') . ' ' . get_the_time('F jS, Y');
				} elseif (is_month()) {
					$eooten_title = esc_html__('Archive for', 'eooten') . ' ' . get_the_time('F Y');
				} elseif (is_year()) {
					$eooten_title = esc_html__('Archive for', 'eooten') . ' ' . get_the_time('Y');
				} elseif (is_author()) {
					$eooten_title = esc_html__('Author Archive for', 'eooten') . ' ' . get_the_author();
				} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
					$eooten_title = esc_html__('Blog Archives', 'eooten');
				} else {
					$eooten_title = single_term_title("", false);
					if ($eooten_title == '') { // Fix for templates that are archives
						$eooten_post_id = $post->ID;
						$eooten_title = get_the_title($eooten_post_id);
					}
				}
			} elseif (is_404()) {
				$eooten_title = esc_html__('Oops, this Page could not be found.', 'eooten');
			} elseif (get_post_type() == 'post') {
				$eooten_title = $eooten_blog_title;
			} else {
				$eooten_title = get_the_title();
			}
			?>

			<div <?php eooten_helper::attrs(['id' => $eooten_id, 'class' => $eooten_class], $eooten_section_media); ?>>
				<div <?php eooten_helper::container(); ?>>
					<div <?php eooten_helper::grid(); ?>>
						<div id="title" class="<?php echo ($eooten_titlebar_metabox == 'center') ? 'bdt-text-center' : ''; ?>">
							<h1 class="bdt-margin-small-bottom"><?php echo wp_kses_post($eooten_title); ?></h1>
							<?php eooten_breadcrumbs($eooten_titlebar_global); ?>
						</div>
						<?php if ($eooten_titlebar_metabox != 'center') : ?>
							<div class="bdt-margin-auto-left bdt-position-relative bdt-width-small bdt-visible@s">
								<div class="bdt-position-center-right">
									<a class="bdt-button-text bdt-link-reset" onclick="history.back()"><span class="bdt-margin-small-right" bdt-icon="icon: arrow-left"></span> <?php esc_html_e('Back', 'eooten'); ?></a>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

		<?php } // End Else
		?>

	<?php } else { // If no post page
	?>

		<?php if ($eooten_titlebar_metabox != 'default' && !empty($eooten_titlebar_metabox)) { ?>

			<?php if ($eooten_titlebar_metabox == 'left' or $eooten_titlebar_metabox == 'center' or $eooten_titlebar_metabox == 'right') { ?>
				<div <?php eooten_helper::attrs(['id' => $eooten_id, 'class' => $eooten_class], $eooten_section_media); ?>>
					<div <?php eooten_helper::container(); ?>>
						<div <?php eooten_helper::grid(); ?>>
							<div id="title" class="bdt-width-expand<?php echo ($eooten_titlebar_metabox == 'center') ? ' bdt-text-center' : ''; ?>">
								<h1 class="bdt-margin-small-bottom"><?php echo wp_kses_post($eooten_title); ?></h1>
								<?php eooten_breadcrumbs($eooten_titlebar_global); ?>
							</div>
							<?php if ($eooten_titlebar_metabox != 'center') : ?>
								<div class="bdt-margin-auto-left bdt-position-relative bdt-width-small bdt-visible@s">
									<div class="bdt-position-center-right">
										<a class="bdt-button-text bdt-link-reset" onclick="history.back()"><span class="bdt-margin-small-right" bdt-icon="icon: arrow-left"></span> <?php esc_html_e('Back', 'eooten'); ?></a>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php } ?>

		<?php } else { ?>

			<?php
			// Define the Title for different Pages
			if (is_home()) {
				$eooten_title = $eooten_blog_title;
			} elseif (is_search()) {
				$eooten_allsearch = new WP_Query("s=$s&showposts=-1");
				$eooten_count = $eooten_allsearch->post_count;
				wp_reset_postdata();
				$eooten_title = $eooten_count . ' ';
				$eooten_title .= esc_html__('Search results for:', 'eooten');
				$eooten_title .= ' ' . get_search_query();
			} elseif (class_exists('Woocommerce') && is_woocommerce()) {
				$eooten_title = $eooten_woocommerce_title;
			} elseif (is_archive()) {
				if (is_category()) {
					$eooten_title = single_cat_title('', false);
				} elseif (is_tag()) {
					$eooten_title = esc_html__('Posts Tagged:', 'eooten') . ' ' . single_tag_title('', false);
				} elseif (is_day()) {
					$eooten_title = esc_html__('Archive for', 'eooten') . ' ' . get_the_time('F jS, Y');
				} elseif (is_month()) {
					$eooten_title = esc_html__('Archive for', 'eooten') . ' ' . get_the_time('F Y');
				} elseif (is_year()) {
					$eooten_title = esc_html__('Archive for', 'eooten') . ' ' . get_the_time('Y');
				} elseif (is_author()) {
					$eooten_title = esc_html__('Author Archive for', 'eooten') . ' ' . get_the_author();
				} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
					$eooten_title = esc_html__('Blog Archives', 'eooten');
				} else {
					$eooten_title = single_term_title("", false);
					if ($eooten_title == '') { // Fix for templates that are archives
						$eooten_post_id = $post->ID;
						$eooten_title = get_the_title($eooten_post_id);
					}
				}
			} elseif (is_404()) {
				$eooten_title = esc_html__('Oops, this Page could not be found.', 'eooten');
			} elseif (get_post_type() == 'post') {
				$eooten_title = $eooten_blog_title;
			} else {
				$eooten_title = get_the_title();
			}
			?>

			<?php if ($eooten_titlebar_global == 'left' or $eooten_titlebar_global == 'center' or $eooten_titlebar_global == 'right') { ?>
				<div <?php eooten_helper::attrs(['id' => $eooten_id, 'class' => $eooten_class], $eooten_section_media); ?>>
					<div <?php eooten_helper::container(); ?>>
						<div <?php eooten_helper::grid(); ?>>
							<div id="title" class="bdt-width-expand<?php echo ($eooten_titlebar_global == 'center') ? ' bdt-text-center' : ''; ?>">
								<h1 class="bdt-margin-small-bottom"><?php echo wp_kses_post($eooten_title); ?></h1>
								<?php eooten_breadcrumbs($eooten_titlebar_global); ?>
							</div>
							<?php if ($eooten_titlebar_global != 'center') : ?>
								<div class="bdt-margin-auto-left bdt-position-relative bdt-width-small bdt-visible@s">
									<div class="bdt-position-center-right">
										<a class="bdt-button-text bdt-link-reset" onclick="history.back()"><span class="bdt-margin-small-right" bdt-icon="icon: arrow-left"></span> <?php esc_html_e('Back', 'eooten'); ?></a>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php } elseif ($eooten_titlebar_global == 'notitle') { ?>
				<div id="notitlebar" class="titlebar-no"></div>
			<?php } ?>
		<?php } ?>

	<?php } // End Else
	?>

<?php endif;
