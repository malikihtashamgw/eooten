<?php

/**
 * Template part for displaying preloader
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 */


$eooten_loading_html   = [];
$eooten_logo_default   = get_theme_mod('eooten_logo_default');
$eooten_custom_logo    = get_theme_mod('eooten_preloader_custom_logo');
$eooten_logo           = get_theme_mod('eooten_preloader_logo', 1);
$eooten_final_logo     = ($eooten_logo == 'custom') ? $eooten_custom_logo : $eooten_logo_default;
$eooten_text           = get_theme_mod('eooten_preloader_text', 1);
$eooten_custom_text    = get_theme_mod('eooten_preloader_custom_text');
$eooten_site_name      = get_bloginfo('name');
$eooten_default_text   = sprintf(esc_html__('Please Wait, %s is Loading...', 'eooten'), $eooten_site_name);
$eooten_animation      = get_theme_mod('eooten_preloader_animation', 1);
$eooten_animation_html = '<div class="tm-spinner tm-spinner-three-bounce"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
if ($eooten_animation) {
	$eooten_loading_html[] = $eooten_animation_html;
}

if ($eooten_text) {
	$eooten_loading_html[]   = $eooten_default_text;
} elseif ($eooten_text == 'custom') {
	$eooten_loading_html[]   = $eooten_custom_text;
}


$eooten_settings = [
	'logo'        => ($eooten_logo) ? $eooten_final_logo : '',
	'loadingHtml' => implode(" ", $eooten_loading_html),
];


?>
<script type="text/javascript">
	window.loading_screen = window.pleaseWait(<?php echo json_encode($eooten_settings); ?>);
	window.onload = function() {
		window.setTimeout(function() {
			loading_screen.finish();
		}, 3000);
	}
</script>