<?php

/**
 * The template for taxonomy download_category
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

get_header();

// Layout
$eooten_position = (get_post_meta(get_the_ID(), 'eooten_page_layout', true)) ? get_post_meta(get_the_ID(), 'eooten_page_layout', true) : get_theme_mod('eooten_page_layout', 'sidebar-right');
?>



<div <?php eooten_helper::section(); ?>>
	<div <?php eooten_helper::container(); ?>>
		<div <?php eooten_helper::grid(); ?>>

			<div class="bdt-width-expand">
				<main class="tm-content">
					<div class="bdt-grid bdt-child-width-1-3 tm-download-category" data-bdt-grid data-bdt-height-match="target: > div > div > .tm-edd-item-bottom-part;">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<?php get_template_part('template-parts/download/download-grid'); ?>
						<?php endwhile;
						endif; ?>
					</div>

					<?php get_template_part('template-parts/pagination'); ?>
				</main> <!-- end main -->
			</div> <!-- end content -->


		</div> <!-- end grid -->
	</div> <!-- end container -->
</div> <!-- end tm main -->

<?php get_footer();
