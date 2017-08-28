<?php
/*
Plugin Name: Discount and regular price cart and checkout page display WooCommerce
Plugin URI:  https://zanca.it/plugin
Description: display the regular and discounted price in cart and checkout page
Version:     0.2.0
Contributors: cristianozanca
Author:      Cristiano Zanca
Author URI:  https://zanca.it
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: woo-discount-price
Domain Path: /languages
*/


/* TODO  check network activation */

if ( ! class_exists( 'woodiscpr' ) ) :
{
	class woodiscpr
	{

		public function __construct() {

			if ( ! defined( 'ABSPATH' ) ) {
				exit; // Exit if accessed directly
			}

			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			include_once( plugin_dir_path( __FILE__ ) . 'inc/custom_template.php' );

			include_once( plugin_dir_path( __FILE__ ) . 'inc/display_cart.php' );

			include_once( plugin_dir_path( __FILE__ ) . 'inc/display_total.php' );

			include_once( plugin_dir_path( __FILE__ ) . 'inc/menu_setup.php' );

			include_once( plugin_dir_path( __FILE__ ) . 'inc/setup_page_display.php' );

			

			function woodiscpr_error_notice() {
				if(! is_plugin_active( 'woocommerce/woocommerce.php')) {

					?>
					<div class="notice error is-dismissible">
						<p><?php _e( 'Please install or activate WooCommerce Plugin, it is required for WooCommerce Discount Price Plugin to work ', 'woo-discount-price' ); ?></p>
					</div>
					<?php
				}


			}

			function check_wc_version(){
				if ( function_exists( 'WC' ) && ( version_compare( WC()->version, '3.0', "<" ) )) {
					?>
					<div class="notice error is-dismissible">
						<p><?php _e('WooCommerce version detected: '. WC()->version.' please update to 3.0 to activate to use Discount Price Plugin','woo-discount-price' ); ?></p>
					</div>
					<?php
				}
			}

			function set_up_woodiscpr_options(){
				update_option('woodiscpr_you_save', 1);
			}

			add_action( 'admin_notices', 'check_wc_version');
			add_action( 'admin_notices', 'woodiscpr_error_notice' );
			add_filter( 'woocommerce_cart_item_price', 'woodiscpr_change_cart_table_price_display', 30, 3 );
			add_action( 'woocommerce_cart_totals_after_order_total', 'woodiscpr_wc_discount_total_30', 99);
			add_action( 'woocommerce_review_order_after_order_total', 'woodiscpr_wc_discount_total_30', 99);
			add_filter( 'woocommerce_locate_template', 'woodiscpr_custom_woocommerce_locate_template', 10, 3 );
			add_action( 'admin_menu', 'woodiscpr_plugin_setup_menu');
			register_activation_hook( __FILE__, 'set_up_woodiscpr_options' );

		}


	}

}



//Creates a new instance
new woodiscpr;

endif;










