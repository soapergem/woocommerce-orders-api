<?php
/**
 * Woocommerce Orders API Widget - Main Class
 *
 * @version 0.1.0
 * @since   0.1.0
 *
 * @author  Gemovation Labs, LLC
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'GEM_WC_Orders_Api' ) ) :

final class GEM_WC_Orders_Api {

	protected $core;

	/**
	 * Plugin version.
	 *
	 * @var   string
	 * @since 0.1.0
	 */
	public $version = GEM_WC_ORDERS_API_VERSION;

	/**
	 * @var   GEM_WC_Orders_Api The single instance of the class
	 * @since 0.1.0
	 */
	protected static $_instance = null;

	/**
	 * Main GEM_WC_Orders_Api Instance
	 *
	 * Ensures only one instance of GEM_WC_Orders_Api is loaded or can be loaded.
	 *
	 * @version 0.1.0
	 * @since   0.1.0
	 *
	 * @static
	 * @return  GEM_WC_Orders_Api - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * GEM_WC_Orders_Api Constructor.
	 *
	 * @version 0.1.0
	 * @since   0.1.0
	 *
	 * @access  public
	 */
	function __construct() {

		// Check for active WooCommerce plugin
		if ( ! function_exists( 'WC' ) ) {
			return;
		}

		// Include required files
		$this->includes();

	}

	/**
	 * includes.
	 *
	 * @version 0.1.0
	 * @since   0.1.0
	 */
	function includes() {
		// Core
		require_once( 'class-gem-wc-orders-api-core.php' );
		$this->core = new GEM_WC_Orders_Api_Core();
	}

	/**
	 * version_updated.
	 *
	 * @version 0.1.0
	 * @since   0.1.0
	 */
	function version_updated() {
		update_option( 'gem_wc_orders_api_version', $this->version );
	}

	/**
	 * plugin_url.
	 *
	 * @version 0.1.0
	 * @since   0.1.0
	 *
	 * @return  string
	 */
	function plugin_url() {
		return untrailingslashit( plugin_dir_url( GEM_WC_ORDERS_API_FILE ) );
	}

	/**
	 * plugin_path.
	 *
	 * @version 0.1.0
	 * @since   0.1.0
	 *
	 * @return  string
	 */
	function plugin_path() {
		return untrailingslashit( plugin_dir_path( GEM_WC_ORDERS_API_FILE ) );
	}

}

endif;
