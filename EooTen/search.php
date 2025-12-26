<?php

/**
 * The template for displaying search results pages.
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 */

get_header();

// Layout
$eooten_position = (is_active_sidebar('search-results-widgets')) ? get_theme_mod('eooten_page_layout', 'sidebar-right') : '';

?>

<div <?php eooten_helper::section(); ?>>
	<div <?php eooten_helper::container(); ?>>
		<div <?php eooten_helper::grid(); ?>>
			<div class="bdt-width-expand">
				<main class="tm-content">

					<h3><?php esc_html_e('New Search', 'eooten') ?></h3>
					<p><?php esc_html_e('If you are not happy with the results below please do another search', 'eooten') ?></p>
					<?php get_search_form(); ?>

					<div class="bdt-clearfix"></div>
					<hr class="bdt-article-divider">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class('bdt-article entry-search'); ?>>
								<div class="entry-wrap">
									<div class="entry-title">
										<h3 class="bdt-article-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'eooten'), the_title_attribute('echo=0')); ?>" rel="bookmark" class="bdt-link-reset"><?php the_title(); ?></a></h3>
									</div>

									<div class="entry-type">
										<?php if (get_post_type($post->ID) == 'post') { ?>
											<?php echo esc_html__('Blog Post', 'eooten'); ?>
										<?php } elseif (get_post_type($post->ID) == 'page') { ?>
											<?php echo esc_html__('Page', 'eooten'); ?>
										<?php } elseif (get_post_type($post->ID) == 'tribe_events') { ?>
											<?php echo esc_html__('Event', 'eooten'); ?>
										<?php } elseif (get_post_type($post->ID) == 'campaign') { ?>
											<?php echo esc_html__('Campaign', 'eooten'); ?>
										<?php } elseif (get_post_type($post->ID) == 'product') { ?>
											<?php echo esc_html__('Product', 'eooten'); ?>
										<?php } ?>
									</div>

									<?php if (eooten_custom_excerpt(100) != '') { ?>
										<div class="entry-content">
											<?php echo wp_kses_post(eooten_custom_excerpt(100)); ?>
										</div>
									<?php } ?>

									<?php
									$eooten_post_title = get_the_title();
									if (empty($eooten_post_title)) : ?>
										<p class="bdt-article-meta">
											<?php if (get_the_date()) : ?>
												<a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'eooten'), the_title_attribute('echo=0')); ?>" rel="bookmark" class="bdt-link-reset"><time><?php printf(get_the_date()); ?></time></a>
											<?php endif; ?>
											<?php if (get_the_author()) : ?>
												<?php printf(esc_html__('Written by %s.', 'eooten'), '<a href="' . get_author_posts_url(get_the_author_meta('ID')) . '" title="' . get_the_author() . '">' . get_the_author() . '</a>'); ?>
											<?php endif; ?>

											<?php if (get_the_category_list()) : ?>
												<?php printf(esc_html__('Posted in %s', 'eooten'), get_the_category_list(', ')); ?>
											<?php endif; ?>
										</p>
									<?php endif; ?>

								</div>

							</article><!-- #post -->

						<?php endwhile; ?>

						<?php get_template_part('template-parts/pagination'); ?>

					<?php else : ?>
						<div class="bdt-alert bdt-alert-warning bdt-text-large"><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'eooten') ?></div>
					<?php endif; ?>
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