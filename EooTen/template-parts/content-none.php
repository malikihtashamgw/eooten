<?php

/**
 * Template part for displaying a message that posts cannot be found.
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e('Nothing Found', 'eooten'); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if (is_home() && current_user_can('publish_posts')) : ?>

			<p><?php printf(wp_kses(esc_html__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'eooten'), array('a' => array('href' => array()))), esc_url(admin_url('post-new.php'))); ?></p>

		<?php elseif (is_search()) : ?>

			<p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'eooten'); ?></p>
		<?php
			get_search_form();

		else : ?>

			<p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'eooten'); ?></p>
		<?php
			get_search_form();

		endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->