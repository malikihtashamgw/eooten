<?php

/**
 * Template Name: Blank Page
 * The template for displaying blank page
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 */

get_header();

$eooten_bg_style         = get_theme_mod('eooten_body_bg_style');
$eooten_text             = get_theme_mod('eooten_body_txt_style');


$eooten_class            = ['bdt-section', 'bdt-padding-remove-vertical'];
$eooten_class[]          = ($eooten_bg_style) ? 'bdt-section-' . $eooten_bg_style : '';
$eooten_class[]          = ($eooten_text) ? 'bdt-' . $eooten_text : '';


?>



<div <?php eooten_helper::attrs(['id' => $id, 'class' => $eooten_class]); ?>>
	<div class="">
		<main class="tm-home">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php the_content(); ?>
			<?php endwhile;
			endif; ?>
		</main> <!-- end main -->

	</div> <!-- end container -->
</div> <!-- end tm main -->

<?php get_footer(); ?>