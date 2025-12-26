<?php

/**
 * Template part for displaying drawer
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */



if (is_active_sidebar('drawer')) :
	$eooten_class             = ['tm-drawer', 'bdt-section'];
	$eooten_container_class   = [];
	$eooten_grid_class        = ['bdt-grid'];
?>

	<div class="drawer-wrapper  bdt-background-secondary">
		<div id="tm-drawer" <?php eooten_helper::attrs(['class' => $eooten_class]) ?> data-hidden>
			<div <?php eooten_helper::attrs(['class' => $eooten_container_class]) ?>>
				<div <?php eooten_helper::attrs(['class' => $eooten_grid_class]) ?> data-bdt-grid>
					<?php dynamic_sidebar('drawer'); ?>
				</div>
			</div>
		</div>
		<a href="javascript:void(0);" class="drawer-toggle bdt-position-top-right bdt-margin-small-right" data-bdt-toggle="target: #tm-drawer; animation: bdt-animation-slide-top; queued: true"><span data-bdt-icon="icon: chevron-down"></span></a>
	</div>
<?php
endif; ?>