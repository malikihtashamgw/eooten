<?php

/**
 * The template for displaying all single posts
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
				<main class="tm-content bdt-text-<?php echo esc_html( get_theme_mod('eooten_blog_align', 'left') ); ?>">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<?php get_template_part('template-parts/post-format/entry', get_post_format()); ?>


							<?php get_template_part('template-parts/author'); ?>

							<?php if (get_theme_mod('eooten_related_post')) { ?>

								<?php //for use in the loop, list 5 post titles related to first tag on current post
								$eooten_tags = wp_get_post_tags($post->ID);
								if ($eooten_tags) {
								?>

									<div id="related-posts">
										<h3 class="bdt-heading-bullet bdt-margin-medium-bottom"><?php esc_html_e('Related Posts', 'eooten'); ?></h3>
										<ul class="bdt-list bdt-list-divider">
											<?php $eooten_first_tag = $eooten_tags[0]->term_id;
											$eooten_args = array(
												'tag__in' => array($eooten_first_tag),
												'post__not_in' => array($post->ID),
												'showposts' => 4
											);
											$eooten_my_query = new WP_Query($eooten_args);
											if ($eooten_my_query->have_posts()) {
												while ($eooten_my_query->have_posts()) : $eooten_my_query->the_post(); ?>
													<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Link to <?php the_title_attribute(); ?>" class="bdt-link-reset bdt-margin-small-right"><?php the_title(); ?></a> <span class="bdt-article-meta"><?php the_time(get_option('date_format')); ?></span></li>
											<?php
												endwhile;
												wp_reset_postdata();
											} ?>
										</ul>
									</div>

									<hr class="bdt-margin-large-top bdt-margin-large-bottom">

								<?php } // end if $eooten_tags
								?>

							<?php } ?>

							<?php comments_template(); ?>

							<?php if (get_theme_mod('eooten_blog_next_prev', 1)) { ?>

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

			<?php if (is_active_sidebar('blog-widgets') and ($eooten_position == 'sidebar-left' or $eooten_position == 'sidebar-right')) : ?>
				<aside <?php echo eooten_helper::sidebar($eooten_position); ?>>
					<?php get_sidebar(); ?>
				</aside> <!-- end aside -->
			<?php endif; ?>

		</div> <!-- end grid -->
	</div> <!-- end container -->
</div> <!-- end tm main -->

<?php get_footer(); ?>