<?php

/**
 * Template part for displaying slider
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 */

$eooten_show_rev_slider = get_post_meta(get_the_ID(), 'eooten_show_rev_slider', true);
$eooten_rev_slider = get_post_meta(get_the_ID(), 'eooten_rev_slider', true);

if (shortcode_exists("rev_slider") && ($eooten_show_rev_slider == 'yes') && !is_search()) : ?>

	<div class="slider-wrapper" id="tmSlider">
		<div>
			<section class="tm-slider bdt-child-width-expand@s" data-bdt-grid>
				<div>
					<?php echo (do_shortcode('[rev_slider ' . $eooten_rev_slider . ']')); ?>
				</div>
			</section>
		</div>
	</div>

<?php endif; ?>