<?php
/*
Plugin Name: Discount and regular price cart and checkout page display WooCommerce
Plugin URI:  https://zanca.it/plugin
Description: display the regular and discounted price in cart and checkout page
Version:     0.1.3
Author:      Cristiano Zanca
Author URI:  https://zanca.it
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: woocommerce-discount-price
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active
 **/
/*
 * this was the old way >>
 * if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
*/
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if(! is_plugin_active( 'woocommerce/woocommerce.php')) {

	function woodiscpr_error_notice() {
		?>
		<div class="notice error is-dismissible">
			<p><?php _e( 'Please install or activate WooCommerce Plugin, it is required for WooCommerce Discount Price Plugin to work ', 'woo-discount-price' ); ?></p>
		</div>
		<?php
	}
	add_action( 'admin_notices', 'woodiscpr_error_notice' );

}

/* check network activation */


/**
 * Check if WooCommerce is 3.0 or higher
 **/
function check_wc_version(){
	if ( function_exists( 'WC' ) && ( version_compare( WC()->version, '3.0', "<" ) )) {
		?>
		<div class="notice error is-dismissible">
			<p><?php _e('WooCommerce version detected: '. WC()->version.' please update to 3.0','woo-discount-price' ); ?></p>
		</div>
		<?php
	}
}
add_action('admin_notices', 'check_wc_version');

###############################################à

add_filter( 'woocommerce_cart_item_price', 'woodiscpr_change_cart_table_price_display', 30, 3 );

function woodiscpr_change_cart_table_price_display( $price, $values, $cart_item_key ) {
	$slashed_price = $values['data']->get_price_html();
	$is_on_sale = $values['data']->is_on_sale();
	if ( $is_on_sale ) {
		$price = $slashed_price;
	}
	return $price;
}
##################

function woodiscpr_wc_discount_total_30() {

	global $woocommerce;

	$discount_total = 0;

	foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values) {

		$_product = $values['data'];

		if ( $_product->is_on_sale() ) {
			$regular_price = $_product->get_regular_price();
			$sale_price = $_product->get_sale_price();
			$discount = ($regular_price - $sale_price) * $values['quantity'];
			$discount_total += $discount;
		}

	}

	if ( $discount_total > 0 ) {
		echo '<tr class="cart-discount">
    <th>'. __( 'You Saved', 'woocommerce' ) .'</th>
    <td data-title=" '. __( 'You Saved', 'woocommerce' ) .' "><strong><u>'
		     . wc_price( $discount_total + $woocommerce->cart->discount_cart ) .'</u></strong></td>
    </tr>';
	}

}

// Hook our values to the Basket and Checkout pages

add_action( 'woocommerce_cart_totals_after_order_total', 'woodiscpr_wc_discount_total_30', 99);
add_action( 'woocommerce_review_order_after_order_total', 'woodiscpr_wc_discount_total_30', 99);
####################################################

/*
 * Use our custom woo checkout form template
 * Source: apppresser.com
 */
add_filter( 'woocommerce_locate_template', 'custom_woocommerce_locate_template', 10, 3 );

function custom_woocommerce_locate_template( $template, $template_name, $template_path ) {

	global $woocommerce;

	$_template = $template;

	if ( !$template_path ) $template_path = $woocommerce->template_url;

	$plugin_path  = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/';

	// Look within passed path within the theme
	$template = locate_template(
		array(
			$template_path . $template_name,
			$template_name
		)
	);

	// Modification: Get the template from this plugin, if it exists
	if ( file_exists( $plugin_path . $template_name ) ) {
		$template = $plugin_path . $template_name;
	}

	// Use default template if no other exists
	if ( !$template ) {
		$template = $_template;
	}

	// Return what we found
	return $template;

}



