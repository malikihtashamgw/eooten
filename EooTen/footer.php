<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 */

$eooten_totop_show        = get_theme_mod('eooten_totop_show', 1);
$eooten_totop_class       = ['tm-totop-scroller', 'bdt-totop', 'bdt-position-medium', 'bdt-position-fixed', 'bdt-border-' . get_theme_mod('eooten_totop_radius', 'circle') . '', 'bdt-background-' . get_theme_mod('eooten_totop_bg_style', 'default') . '', 'bdt-position-bottom-' . get_theme_mod('eooten_totop_align', 'right') . ''];
$eooten_mb_custom_footer  = get_post_meta(get_the_ID(), 'eooten_custom_footer', true);
$eooten_mb_footer_widgets = get_post_meta(get_the_ID(), 'eooten_footer_widgets', true);

$eooten_tm_custom_footer  = get_theme_mod('eooten_custom_footer');
$eooten_tm_footer_widgets = get_theme_mod('eooten_footer_widgets');

$eooten_custom_footer     = '';

if ('custom' == $eooten_mb_footer_widgets and  isset($eooten_mb_custom_footer)) {
	$eooten_custom_footer =  $eooten_mb_custom_footer;
} elseif ('custom' == $eooten_tm_footer_widgets and  isset($eooten_tm_custom_footer)) {
	$eooten_custom_footer =  $eooten_tm_custom_footer;
}

?>

<?php if (!function_exists('elementor_theme_do_location') or !elementor_theme_do_location('footer')) : ?>
	<?php if (!is_page_template('page-blank.php') and !is_404()) : ?>
		<?php if ($eooten_custom_footer) : ?>
			<?php echo Elementor\Plugin::$instance->frontend->get_builder_content_for_display($eooten_custom_footer); ?>
		<?php else : ?>
			<?php get_template_part('template-parts/bottom'); ?>
			<?php get_template_part('template-parts/copyright'); ?>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>

<?php get_template_part('template-parts/fixed-left'); ?>
<?php get_template_part('template-parts/fixed-right'); ?>


<?php if (!function_exists('elementor_theme_do_location') or !elementor_theme_do_location('footer')) : ?>
	<?php if ($eooten_totop_show and !is_page_template('page-blank.php')) : ?>
		<a <?php eooten_helper::attrs(['class' => $eooten_totop_class]); ?> href="#" data-bdt-totop data-bdt-scroll></a>
	<?php endif; ?>
<?php endif; ?>

<?php wp_footer(); ?>

</body>

</html>