<?php

/**
 * Template Name: Testimonials
 * The template for displaying testimonials
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 */

get_header();

// Layout
$eooten_position = (get_post_meta(get_the_ID(), 'eooten_page_layout', true)) ? get_post_meta(get_the_ID(), 'eooten_page_layout', true) : get_theme_mod('eooten_page_layout', 'sidebar-right');

$eooten_grid_class = ['bdt-grid'];


$eooten_large        = rwmb_meta('jetpack_tm_columns');
$eooten_medium       = rwmb_meta('jetpack_tm_columns_medium');
$eooten_small        = rwmb_meta('jetpack_tm_columns_small');

$eooten_grid_class[] = ($eooten_large != null) ? 'bdt-child-width-1-' . $eooten_large . '@l' : 'bdt-child-width-1-3@l';
$eooten_grid_class[] = ($eooten_medium != null) ? 'bdt-child-width-1-' . $eooten_medium . '@m' : 'bdt-child-width-1-2@m';
$eooten_grid_class[] = ($eooten_small != null) ? 'bdt-child-width-1-' . $eooten_small : 'bdt-child-width-1-1';
$eooten_column_gap   = rwmb_meta('jetpack_tm_columns_gap');
$eooten_grid_class[] = ($eooten_column_gap) ? 'bdt-grid-' . $eooten_column_gap : '';

?>

<div <?php eooten_helper::section(); ?>>
	<div <?php eooten_helper::container(); ?>>
		<div <?php eooten_helper::grid(); ?>>

			<div class="bdt-width-expand">
				<main class="tm-content">
					<div <?php eooten_helper::attrs(['class' => $eooten_grid_class]) ?> data-bdt-grid>
						<?php

						global $eooten_wp_query;
						// Pagination fix to work when set as Front Page
						// $eooten_paged = get_query_var('paged') ? get_query_var('paged') : 1;
						if (get_query_var('paged')) {
							$eooten_paged = get_query_var('paged');
						} elseif (get_query_var('page')) {
							$eooten_paged = get_query_var('page');
						} else {
							$eooten_paged = 1;
						}

						$eooten_args = [
							'post_type'      => 'jetpack-testimonial',
							'posts_per_page' => 10,
							'order'          => 'DESC',
							'orderby'        => 'date',
							'post_status'    => 'publish'
						];

						$eooten_wp_query = new WP_Query($eooten_args);

						if (have_posts()) : while (have_posts()) : the_post(); ?>
								<?php get_template_part('template-parts/testimonials/entry'); ?>
						<?php endwhile;
						endif; ?>

						<?php get_template_part('template-parts/pagination'); ?>
					</div>
				</main> <!-- end main -->
			</div> <!-- end content -->

			<?php if ($eooten_position == 'sidebar-left' || $eooten_position == 'sidebar-right') : ?>
				<aside <?php echo eooten_helper::sidebar($eooten_position); ?>>
					<?php get_sidebar(); ?>
				</aside> <!-- end aside -->
			<?php endif; ?>

		</div> <!-- end grid -->
	</div> <!-- end container -->
</div> <!-- end tm main -->

<?php get_footer(); ?>