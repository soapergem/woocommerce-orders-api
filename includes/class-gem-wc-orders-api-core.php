<?php
/**
 * WooCommerce Orders API - Core Class
 *
 * @version 0.1.0
 * @since   0.1.0
 *
 * @author  Gemovation Labs, LLC
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'GEM_WC_Orders_Api_Core' ) ) :

class GEM_WC_Orders_Api_Core {

	/**
	 * Constructor.
	 *
	 * @version 0.1.0
	 * @since   0.1.0
	 */
	function __construct() {
		
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
		
		// Core loaded
		do_action( 'gem_wc_orders_api_core_loaded' );
	}

	/**
	 * register REST route
	 *
	 * @version 0.1.0
	 * @since   0.1.0
	 */
	function register_routes() {
		error_log( 'GEM_WC_Orders_Api_Core::rest_api_init hook fired' );
		register_rest_route( 'wc-orders-api/v1', '/orders', array(
			'methods'				=> 'GET',
			'callback'				=> array( $this, 'handle_request' ),
			'permission_callback'	=> array( $this, 'authenticate_user' )
		) );
	}

	/**
	 * Endpoint handler
	 *
	 * @version 0.1.0
	 * @since   0.1.0
	 */
	function handle_request( WP_REST_Request $request ) {
		$args = array(
			'limit'    => $request->get_param('limit', 25),
			'type'     => 'shop_order',
			'orderby'  => 'ID',
			'order'    => 'DESC',
		);
		if ( $after = $request->get_param('after') ) {
			$args['date_created'] = '>' . $after;
		}
		$orders = wc_get_orders($args);
		$orders = array_map([$this, 'map_order'], $orders);
		return new WP_REST_Response($orders, 200);
	}

	/**
	 * Authentication callback
	 *
	 * @version 0.1.0
	 * @since   0.1.0
	 */
	function authenticate_user() {
		if ( ! is_user_logged_in() ) {
			return new WP_Error(
				'rest_forbidden',
				__( 'Authentication required. Please use HTTP Basic Auth with an Application Password.', 'wc-orders-api' ),
				array( 'status' => 401 )
			);
		}

		$user = wp_get_current_user();
		if ( ! user_can($user, 'administrator') && ! user_can($user, 'read_shop_order') ) {
			return new WP_Error(
				'rest_forbidden',
				__( 'You do not have permission to access this endpoint.', 'wc-orders-api' ),
				array( 'status' => 403 )
			);
		}

		return true;
	}

	/**
	 * reformat_orders
	 *
	 * @version 0.1.0
	 * @since   0.1.0
	 */
	function map_order( $order ) {
		return array(
			'number'		=> intval($order->get_order_number()),
			'url'			=> admin_url('post.php?post=' . $order->get_order_number() . '&action=edit'),
			'date'			=> ( ( $date = $order->get_date_created() ) ? $date->date_i18n( 'c' ) : '' ),
			'total'			=> floatval($order->get_total()),
			'status'		=> wc_get_order_status_name( $order->get_status() ),
			'first_name'	=> $order->get_billing_first_name(),
			'last_name'		=> $order->get_billing_last_name(),
			'state'			=> $order->get_shipping_state(),
			'postcode'		=> $order->get_shipping_postcode(),
			'item_count'	=> $order->get_item_count(),
		);
	}
}

endif;
