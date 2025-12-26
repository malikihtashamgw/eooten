<?php

/**
 * The template for displaying all single posts of Jetpack Testimonial.
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header();

// Layout
$eooten_position = (get_post_meta(get_the_ID(), 'eooten_page_layout', true)) ? get_post_meta(get_the_ID(), 'eooten_page_layout', true) : get_theme_mod('eooten_page_layout', 'sidebar-right');
$eooten_width = '1-3';
?>

<div <?php eooten_helper::section(); ?>>
	<div <?php eooten_helper::container(); ?>>
		<div <?php eooten_helper::grid(); ?>>
			<div class="bdt-width-expand">
				<main class="tm-content">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<?php get_template_part('template-parts/testimonials/entry'); ?>

							<?php if (get_theme_mod('eooten_service_next_prev', 1)) { ?>

								<hr>

								<ul class="bdt-pagination">
									<li>
										<?php
										$eooten_pre_btn_txt = '<span class="bdt-margin-small-right" bdt-pagination-previous></span> ' . esc_html__('Previous', 'eooten');
										previous_post_link('%link', "{$eooten_pre_btn_txt}", FALSE);
										?>

									</li>
									<li class="bdt-margin-auto-left">
										<?php $eooten_next_btn_txt = esc_html__('Next', 'eooten') . ' <span class="bdt-margin-small-left" bdt-pagination-next></span>';
										next_post_link('%link', "{$eooten_next_btn_txt}", FALSE); ?>
									</li>
								</ul>
							<?php } ?>

					<?php endwhile;
					endif; ?>
				</main> <!-- end main -->
			</div> <!-- end expand -->

			<?php if ($eooten_position == 'sidebar-left' || $eooten_position == 'sidebar-right') : ?>
				<aside <?php echo eooten_helper::sidebar($eooten_position, $eooten_width); ?>>
					<?php get_sidebar(); ?>
				</aside> <!-- end aside -->
			<?php endif; ?>

		</div> <!-- end grid -->
	</div> <!-- end container -->
</div> <!-- end tm main -->

<?php get_footer(); ?>