<?php

/**
 * Template part for displaying fixed left sidebar
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

?>

<?php if (is_active_sidebar('fixed-left')) : ?>
	<div id="tmFixedLeft" class="bdt-position-center-left">
		<div class="bdt-fixed-l-wrapper">
			<?php dynamic_sidebar('fixed-left'); ?>
		</div>
	</div>
<?php endif; ?>