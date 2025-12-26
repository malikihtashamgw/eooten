<?php

/**
 * Template part for displaying cookie bar
 * @package eooten
 * @since 1.0.0
 * @version 1.0.0
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

$eooten_message        = get_theme_mod('eooten_cookie_message');
$eooten_accept_button  = get_theme_mod('eooten_cookie_accept_button', true);
$eooten_decline_button = get_theme_mod('eooten_cookie_decline_button', false);
$eooten_policy_button  = get_theme_mod('eooten_cookie_policy_button', false);
$eooten_policy_url     = get_theme_mod('eooten_cookie_policy_url', '/privacy-policy/');
$eooten_expire_days    = get_theme_mod('eooten_cookie_expire_days', 365);
$eooten_position       = get_theme_mod('eooten_cookie_position');
$eooten_dev_mode       = get_theme_mod('eooten_cookie_debug');


$eooten_cookie_settings = [
	'message'       => ($eooten_message) ? esc_html($eooten_message) : esc_html__('We use cookies to ensure that we give you the best experience on our website.', 'eooten'),
	'acceptButton'  => $eooten_accept_button,
	'acceptText'    => esc_html__('I Understand', 'eooten'),
	'declineButton' => $eooten_decline_button,
	'declineText'   => esc_html__('Disable Cookies', 'eooten'),
	'policyButton'  => $eooten_policy_button,
	'policyText'    => esc_html__('Privacy Policy', 'eooten'),
	'policyURL'     => esc_url($eooten_policy_url),
	'expireDays'    => $eooten_expire_days,
	'bottom'        => ($eooten_position) ? true : false,
	'forceShow'     => ($eooten_dev_mode) ? true : false,
]


?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery.cookieBar(<?php echo json_encode($eooten_cookie_settings); ?>);
	});
</script>