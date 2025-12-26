<?php

/**
 * Template part for displaying author info
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
$eooten_author_desc = get_the_author_meta('description');
$eooten_archive_page = is_archive();

?>

<?php if (get_theme_mod('eooten_author_info', 1) && !empty($eooten_author_desc)) { ?>

	<?php if (!$eooten_archive_page) : ?>
		<hr class="bdt-margin-large-top bdt-margin-large-top bdt-margin-large-bottom">
	<?php endif; ?>

	<div id="author-info" class="bdt-clearfix">
		<div class="author-image bdt-float-left bdt-margin-right">
			<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo get_avatar(esc_attr(get_the_author_meta('user_email')), '80', ''); ?></a>
		</div>
		<div class="author-bio">
			<h4 class="bdt-margin-small-bottom"><?php esc_html_e('About', 'eooten'); ?> <?php the_author(); ?></h4>
			<?php the_author_meta('description'); ?>
		</div>
	</div>

	<hr class="bdt-margin-large-top bdt-margin-large-bottom">

<?php } ?>