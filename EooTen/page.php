<?php

/**
 * The template for displaying all pages
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 */

get_header();

// Layout
$eooten_layout = get_post_meta(get_the_ID(), 'eooten_page_layout', true);
$eooten_position = (!empty($eooten_layout)) ? $eooten_layout : get_theme_mod('eooten_page_layout', 'sidebar-right');

$eooten_class[] = ($eooten_layout !== 'full') ? 'bdt-container' : '';

?>



<div <?php eooten_helper::section('main'); ?>>
	<div <?php eooten_helper::attrs(['class' => $eooten_class]) ?>>
		<div <?php eooten_helper::grid(); ?>>
			<div class="bdt-width-expand">
				<main class="tm-content">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<?php the_content(); ?>
							<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

							<?php if (get_theme_mod('eooten_comment_show', 1) == 1 and comments_open()) { ?>
								<hr class="bdt-margin-large-top bdt-margin-large-bottom">
								<?php comments_template(); ?>
							<?php } ?>

					<?php endwhile;
					endif; ?>
				</main> <!-- end main -->
			</div> <!-- end content -->

			<?php if ($eooten_position == 'sidebar-left' or $eooten_position == 'sidebar-right') : ?>
				<aside <?php echo eooten_helper::sidebar($eooten_position); ?>>
					<?php get_sidebar(); ?>
				</aside> <!-- end aside -->
			<?php endif; ?>

		</div> <!-- end grid -->
	</div> <!-- end container -->
</div> <!-- end tm main -->

<?php get_footer(); ?>