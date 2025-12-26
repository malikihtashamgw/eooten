<?php

/**
 * The template for displaying all single posts of elementor_library
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */
get_header();

?>

<div class="tm-section bdt-section bdt-padding-remove-vertical">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php the_content(); ?>
	<?php endwhile;
	endif; ?>

</div> <!-- end tm main -->

<?php get_footer(); ?>