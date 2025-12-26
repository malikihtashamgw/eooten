<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Show in WP Dashboard notice about the plugin is not activated.
 *
 * @return void
 */
function eooten_elementor_fail_load_admin_notice() {
	// Leave to Elementor Pro to manage this.
	if ( function_exists( 'elementor_pro_load_plugin' ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	if ( 'true' === get_user_meta( get_current_user_id(), '_eooten_elementor_install_notice', true ) ) {
		return;
	}

	$plugin = 'elementor/elementor.php';

	$installed_plugins = get_plugins();

	$is_elementor_installed = isset( $installed_plugins[ $plugin ] );

	if ( $is_elementor_installed ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$message = __( 'Eooten theme is a lightweight starter theme designed to work perfectly with Elementor Page Builder and Element Pack plugins.', 'eooten' );

		$button_text = __( 'Activate Elementor', 'eooten' );
		$button_link = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$message = __( 'Eooten theme is a lightweight starter theme. We recommend you use it together with Elementor Page Builder plugin, they work perfectly together!', 'eooten' );

		$button_text = __( 'Install Elementor', 'eooten' );
		$button_link = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
	}

	?>
	<style>
		.notice.eooten-notice {
			border: 1px solid #ccd0d4;
			border-left: 4px solid #9b0a46 !important;
			box-shadow: 0 1px 4px rgba(0,0,0,0.15);
			display: flex;
			padding: 0px;
		}
		.rtl .notice.eooten-notice {
			border-right-color:#798184 !important;
		}
		.notice.eooten-notice .eooten-notice-aside {
			width: 100px;
			display: flex;
			align-items: start;
			justify-content: center;
			padding-top: 15px;
			background: rgba(215,43,63,0.04);
		}
		.notice.eooten-notice .eooten-notice-aside img{
			width: 4.5rem;
		}
		.notice.eooten-notice .eooten-notice-inner {
			display: table;
			padding: 20px 0px;
			width: 100%;
		}
		.notice.eooten-notice .eooten-notice-content {
			padding: 0 20px;
		}
		.notice.eooten-notice p {
			padding: 0;
			margin: 0;
		}
		.notice.eooten-notice h3 {
			margin: 0 0 5px;
		}
		.notice.eooten-notice .eooten-install-now {
			display: block;
			margin-top: 15px;
		}
		.notice.eooten-notice .eooten-install-now .eooten-install-button {
			background: #127DB8;
			border-radius: 3px;
			color: #fff;
			text-decoration: none;
			height: auto;
			line-height: 20px;
			padding: 0.4375rem 0.75rem;
			text-transform: capitalize;
		}
		.notice.eooten-notice .eooten-install-now .eooten-install-button:active {
			transform: translateY(1px);
		}
		@media (max-width: 767px) {
			.notice.eooten-notice.eooten-install-elementor {
				padding: 0px;
			}
			.notice.eooten-notice .eooten-notice-inner {
				display: block;
				padding: 10px;
			}
			.notice.eooten-notice .eooten-notice-inner .eooten-notice-content {
				display: block;
				padding: 0;
			}
			.notice.eooten-notice .eooten-notice-inner .eooten-install-now {
				display: none;
			}
		}
	</style>
	<script>jQuery( function( $ ) {
			$( 'div.notice.eooten-install-elementor' ).on( 'click', 'button.notice-dismiss', function( event ) {
				event.preventDefault();

				$.post( ajaxurl, {
					action: 'eooten_elementor_set_admin_notice_viewed'
				} );
			} );
		} );</script>
	<div class="notice updated is-dismissible eooten-notice eooten-install-elementor">
		<div class="eooten-notice-aside">
			<img src="<?php echo esc_url( get_template_directory_uri() ) . '/images/logo-png.png'; ?>" alt="<?php _e( 'Get Elementor', 'eooten' ); ?>" />
		</div>
		<div class="eooten-notice-inner">
			<div class="eooten-notice-content">
				<h3><?php esc_html_e( 'Thanks for installing Eooten Theme!', 'eooten' ); ?></h3>
				<p><?php echo esc_html( $message ); ?></p>
				<div class="eooten-install-now">
					<a class="eooten-install-button" href="<?php echo esc_attr( $button_link ); ?>"><?php echo esc_html( $button_text ); ?></a>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Set Admin Notice Viewed.
 *
 * @return void
 */
function ajax_eooten_elementor_set_admin_notice_viewed() {
	update_user_meta( get_current_user_id(), '_eooten_elementor_install_notice', 'true' );
	die;
}

add_action( 'wp_ajax_eooten_elementor_set_admin_notice_viewed', 'ajax_eooten_elementor_set_admin_notice_viewed' );
if ( ! did_action( 'elementor/loaded' ) ) {
	add_action( 'admin_notices', 'eooten_elementor_fail_load_admin_notice' );
}
