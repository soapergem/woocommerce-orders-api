<?php
/*
Plugin Name: WooCommerce Orders API
Plugin URI: https://github.com/soapergem/woocommerce-orders-api
Description: Retrieve recent WooCommerce orders via a REST API
Version: 0.1.0
Author: Gemovation Labs, LLC
Author URI: https://gemovationlabs.com/
Text Domain: woocommerce-orders-api
WC tested up to: 9.5.1
Requires Plugins: woocommerce
*/

defined( 'ABSPATH' ) || exit;

defined( 'GEM_WC_ORDERS_API_VERSION' ) || define( 'GEM_WC_ORDERS_API_VERSION', '0.1.0' );

defined( 'GEM_WC_ORDERS_API_FILE' ) || define( 'GEM_WC_ORDERS_API_FILE', __FILE__ );

require_once( 'includes/class-gem-wc-orders-api.php' );

if ( ! function_exists( 'gem_wc_orders_api' ) ) {
	/**
	 * Returns the main instance of GEM_WC_Orders_Api to prevent the need to use globals.
	 *
	 * @version 0.1.0
	 * @since   0.1.0
	 */
	function gem_wc_orders_api() {
		return GEM_WC_Orders_Api::instance();
	}
}

add_action( 'plugins_loaded', 'gem_wc_orders_api' );
