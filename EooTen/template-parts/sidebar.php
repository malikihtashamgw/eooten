<?php

/**
 * Template part for displaying sidebar
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 */
$eooten_position = (get_post_meta(get_the_ID(), 'eooten_page_layout', true)) ? get_post_meta(get_the_ID(), 'eooten_page_layout', true) : get_theme_mod('eooten_page_layout', 'sidebar-right');

if ($eooten_position == 'sidebar-left' || $eooten_position == 'sidebar-right') { ?>

	<aside <?php echo eooten_helper::sidebar(); ?>>
		<?php get_sidebar(); ?>
	</aside> <!-- end aside -->

<?php }
