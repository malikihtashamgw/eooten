<?php

/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package eooten
 */

// Those settings comes from customizer for control boxed layout + preloader loading
$eooten_layout           = get_theme_mod('eooten_global_layout', 'full');
$eooten_padding          = get_theme_mod('eooten_global_padding');
$eooten_boxed_class      = ['tm-page'];
$eooten_boxed_class[]    = $eooten_padding ? 'tm-page-padding' : '';
$eooten_preloader        = get_theme_mod('eooten_preloader');

$eooten_tm_custom_header = get_theme_mod('eooten_custom_header');
$eooten_tm_header_layout = get_theme_mod('eooten_header_layout');

$eooten_mb_custom_header = get_post_meta(get_the_ID(), 'eooten_custom_header', true);
$eooten_mb_header_layout = get_post_meta(get_the_ID(), 'eooten_header_layout', true);
$eooten_custom_header    = '';

if ('custom' == $eooten_mb_header_layout and  isset($eooten_mb_custom_header)) {
	$eooten_custom_header =  $eooten_mb_custom_header;
} elseif ('custom' == $eooten_tm_header_layout and  isset($eooten_tm_custom_header)) {
	$eooten_custom_header =  $eooten_tm_custom_header;
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if (is_singular() && pings_open(get_queried_object())) : ?>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php endif; ?>
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">


	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<?php if ($eooten_preloader) : ?>
		<?php get_template_part('template-parts/preloader'); ?>
	<?php endif ?>

	<?php // this condition for boxed mode layout those started div end in end of the footer.php file
	?>
	<?php if ($eooten_layout == 'boxed') : ?>
		<div <?php eooten_helper::attrs(['class' => $eooten_boxed_class]); ?>>
			<div <?php echo ($eooten_layout == 'boxed') ? 'class="bdt-margin-auto"' : '' ?>>
			<?php endif ?>

			<?php // If you select page template blank so this condition will be activate
			?>
			<?php if (!function_exists('elementor_theme_do_location') or !elementor_theme_do_location('header')) : ?>

				<?php if (!is_page_template('page-blank.php') and !is_404()) : ?>
					<?php get_template_part('template-parts/drawer');	?>

					<?php if ($eooten_custom_header) : ?>

						<?php echo Elementor\Plugin::$instance->frontend->get_builder_content_for_display($eooten_custom_header); ?>

						<?php if (!is_front_page() and !is_page_template('page-homepage.php')) : ?>
							<?php get_template_part('template-parts/titlebar');	?>
						<?php endif; ?>

					<?php else : ?>

						<div class="tm-header-wrapper">
							<?php get_template_part('template-parts/toolbar'); ?>


							<?php get_template_part('template-parts/headers/header-mobile'); ?>

							<?php get_template_part('template-parts/headers/header-default'); ?>
						</div>

						<?php // this is page title that show after header and top of body section
						?>
						<?php if ((!is_front_page() and !is_page_template('page-homepage.php')) or $eooten_custom_header) : ?>
							<?php get_template_part('template-parts/titlebar');	?>
						<?php endif; ?>

						<?php get_template_part('template-parts/slider');	?>

					<?php endif; ?>

				<?php endif; ?>


			<?php endif; ?>