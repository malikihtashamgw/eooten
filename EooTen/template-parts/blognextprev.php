<?php

/**
 * Template part for displaying next/previous post
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */
if (get_theme_mod('eooten_blog_next_prev', 1)) { ?>
	<ul class="bdt-pagination">
		<li>
			<?php
			$eooten_pre_btn_txt = '<span class="bdt-margin-small-right" data-bdt-pagination-previous></span> ' . esc_html__('Previous', 'eooten');
			previous_post_link('%link', "{$eooten_pre_btn_txt}", FALSE);
			?>
		</li>
		<li class="bdt-margin-auto-left">
			<?php
			$eooten_next_btn_txt = esc_html__('Next', 'eooten') . ' <span class="bdt-margin-small-left" data-bdt-pagination-next></span>';
			next_post_link('%link', "{$eooten_next_btn_txt}", FALSE);
			?>
		</li>
	</ul>
<?php }
