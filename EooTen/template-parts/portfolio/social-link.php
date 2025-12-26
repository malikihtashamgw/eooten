<?php

/**
 * Template part for displaying portfolio social link
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */
$eooten_social_link = get_post_meta(get_the_ID(), 'bdthemes_portfolio_social_link', true);
if ($eooten_social_link != null and is_array($eooten_social_link)) : ?>
	<div class="bdt-portfolio-social bdt-position-absolute bdt-position-bottom-center">
		<ul class="bdt-list bdt-margin-remove-bottom">
			<?php foreach ($eooten_social_link as $eooten_link) : ?>
				<?php $eooten_tooltip = ucfirst(eooten_helper::icon($eooten_link)); ?>
				<li class="bdt-display-inline-block">
					<a <?php eooten_helper::attrs(['href' => $eooten_link, 'class' => 'bdt-margin-small-right']); ?> bdt-icon="icon: <?php echo eooten_helper::icon($eooten_link); ?>" title="<?php echo esc_html($eooten_tooltip); ?>" bdt-tooltip></a>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
<?php endif; ?>