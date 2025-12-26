<?php

/**
 * Template Name: Blog
 * The template for displaying blog page
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 */

get_header();

// Layout
$eooten_position = (get_post_meta(get_the_ID(), 'eooten_page_layout', true)) ? get_post_meta(get_the_ID(), 'eooten_page_layout', true) : get_theme_mod('eooten_page_layout', 'sidebar-right');

$eooten_grid_class = ['bdt-grid'];


$eooten_large        = rwmb_meta('eooten_blog_columns');
$eooten_medium       = rwmb_meta('eooten_blog_columns_medium');
$eooten_small        = rwmb_meta('eooten_blog_columns_small');

$eooten_grid_class[] = ($eooten_large != null) ? 'bdt-child-width-1-' . $large . '@l' : 'bdt-child-width-1-3@l';
$eooten_grid_class[] = ($eooten_medium != null) ? 'bdt-child-width-1-' . $eooten_medium . '@m' : 'bdt-child-width-1-2@m';
$eooten_grid_class[] = ($eooten_small != null) ? 'bdt-child-width-1-' . $eooten_small : 'bdt-child-width-1-1';
$eooten_column_gap   = rwmb_meta('eooten_blog_columns_gap');
$eooten_limit        = get_theme_mod('eooten_blog_posts_limit', '-1');
$eooten_grid_class[] = ($eooten_column_gap) ? 'bdt-grid-' . $eooten_column_gap : '';


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

// Get Categories
//$eooten_categories = rwmb_meta( 'eooten_blog_categories');

$eooten_args = [
	'posts_per_page' => 3,
	// 'posts_per_page' => intval($eooten_limit),
	'post_status' => 'publish',
	'orderby'     => 'date',
	'order'       => 'DESC',
	//'cat'         => $eooten_categories,
	'paged'       => $eooten_paged
];
$eooten_wp_query = new WP_Query($eooten_args);

?>

<div <?php eooten_helper::section('main'); ?>>
	<div <?php eooten_helper::container(); ?>>
		<div <?php eooten_helper::grid(); ?>>

			<div class="bdt-width-expand">
				<main class="tm-content">
					<?php if ($eooten_large != 1) : ?>
						<div <?php eooten_helper::attrs(['class' => $eooten_grid_class]) ?> data-bdt-grid>
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
									<div>
										<?php get_template_part('template-parts/post-format/entry', get_post_format()); ?>
									</div>
							<?php endwhile;
							endif; ?>
						</div>
					<?php else : ?>
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<?php get_template_part('template-parts/post-format/entry', get_post_format()); ?>
						<?php endwhile;
						endif; ?>
					<?php endif; ?>

					<?php get_template_part('template-parts/pagination'); ?>
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