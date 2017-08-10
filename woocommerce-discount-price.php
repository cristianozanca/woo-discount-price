<?php
/*
Plugin Name: WooCommerce discount price
Plugin URI:  https://zanca.it/plugin
Description: display the discounted price in cart
Version:     0.1
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
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {


	function woodiscpr_error_notice() {
		?>
		<div class="notice error is-dismissible">
			<p><?php _e( 'Please install or activate WooCommerce Plugin, it is required for WooCommerce Discount Price Plugin to work ', 'woodiscpr_textdomain' ); ?></p>
		</div>
		<?php
	}
	add_action( 'admin_notices', 'woodiscpr_error_notice' );

}

/**
 * Check if WooCommerce is 3.0 or higher
 **/
function check_wc_version(){
	if ( function_exists( 'WC' ) && ( version_compare( WC()->version, '3.0', "<" ) )) {
		?>
		<div class="notice error is-dismissible">
			<p><?php _e('WooCommerce version detected: '. WC()->version.' please update to 3.0','woodiscpr_textdomain' ); ?></p>
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

/**
 * @snippet Display Total Discount / Savings @ WooCommerce Cart/Checkout
 * @how-to Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode https://businessbloomer.com/?p=20362
 * @author Rodolfo Melogli, Bülent Sakarya
 * @testedwith WooCommerce 3.0
 */

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





