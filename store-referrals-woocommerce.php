<?php
/**
 * Plugin Name: Store Referrals WooCommerce
 * Plugin URI: https://www.storereferrals.com
 * Description: Store Referrals allows you to create, manage, and track multiple campaigns with tiered rewards.
 * Version: 1.0.6
 * Author: Store Referrals
 * Author URI: https://www.storereferrals.com
 * License: GPL2
 */

if ( ! class_exists( 'WC_Store_Referrals' ) ) :
class WC_Store_Referrals {
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function init() {
		if ( class_exists( 'WC_Integration' ) ) {
			include_once 'wc-store-referrals-integration.php';
			add_filter( 'woocommerce_integrations', array( $this, 'add_integration' ) );
		}
	}

	public function add_integration( $integrations ) {
		$integrations[] = 'WC_Store_Referrals_Integration';
		return $integrations;
	}
}

function plugin_settings_link($links) {
 	$settings_link = '<a href="admin.php?page=wc-settings&tab=integration&section=store-referrals-integration">Settings</a>';
  	array_unshift( $links, $settings_link );
  	return $links;
}

add_filter( 'plugin_action_links_'. plugin_basename( __FILE__ ), 'plugin_settings_link' );

$WC_Store_Referrals = new WC_Store_Referrals( __FILE__ );
endif;
