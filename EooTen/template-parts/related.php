<?php

/**
 * Template part for displaying related posts
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://codex.wordpress.org/Template_Tags/get_the_tag_list
 */

if (get_theme_mod('eooten_related_post')) : ?>
	<?php $eooten_tags = wp_get_post_tags($post->ID); ?>
	<?php if ($eooten_tags) : ?>
		<hr class="bdt-divider-icon">
		<div id="related-posts">
			<h3><?php esc_html_e('Related Posts', 'eooten'); ?></h3>
			<ul class="bdt-list bdt-list-line">
				<?php $eooten_first_tag = $eooten_tags[0]->term_id;
				$eooten_args = array(
					'tag__in' => array($eooten_first_tag),
					'post__not_in' => array($post->ID),
					'showposts' => 4
				);
				$eooten_my_query = new WP_Query($eooten_args);
				if ($eooten_my_query->have_posts()) {
					while ($eooten_my_query->have_posts()) : $eooten_my_query->the_post(); ?>
						<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a> <span class="bdt-article-meta"><?php the_time(get_option('date_format')); ?></span></li>
				<?php
					endwhile;
					wp_reset_postdata();
				} ?>
			</ul>
		</div>
	<?php endif ?>
<?php endif; ?>