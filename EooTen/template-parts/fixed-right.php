<?php

/**
 * Template part for displaying fixed right sidebar
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
?>

<?php if (is_active_sidebar('fixed-right')) : ?>
	<div id="tmFixedRight" class="bdt-position-center-right">
		<div class="bdt-fixed-r-wrapper">
			<?php dynamic_sidebar('fixed-right'); ?>
		</div>
	</div>
<?php endif; ?>