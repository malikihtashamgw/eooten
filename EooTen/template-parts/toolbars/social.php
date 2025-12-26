<?php

/**
 * Template part for displaying social toolbar
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
$eooten_attrs['class']        = get_theme_mod('eooten_toolbar_social_style') ? 'bdt-icon-button' : 'bdt-icon-link';
$eooten_attrs['target']       = get_theme_mod('eooten_toolbar_social_target') ? '_blank' : '';

// Grid
$eooten_attrs_grid            = [];
$eooten_attrs_grid['class'][] = 'bdt-grid-small bdt-flex-middle';
$eooten_attrs_grid['bdt-grid'] = true;

$eooten_links = (get_theme_mod('eooten_toolbar_social')) ? explode(',', get_theme_mod('eooten_toolbar_social')) : null;
if (count($eooten_links)) : ?>
	<div class="social-link">
		<ul <?php eooten_helper::attrs($eooten_attrs_grid) ?>>
			<?php foreach ($eooten_links as $eooten_link) : ?>
				<li>
					<a <?php eooten_helper::attrs(['href' => $eooten_link], $eooten_attrs); ?> bdt-icon="icon: <?php echo eooten_helper::icon($eooten_link); ?>; ratio: 0.8" title="<?php echo ucfirst(eooten_helper::icon($eooten_link)); ?>" bdt-tooltip="pos: bottom"></a>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
<?php endif; ?>