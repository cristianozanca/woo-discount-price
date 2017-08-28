<?php

// display at the bottom of cart and checkout page the "You saved" feature

function woodiscpr_wc_discount_total_30() {

	if ( 1 == get_option('woodiscpr_you_save') ) {

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
   					<th>'. __( 'You Saved', 'woo-discount-price' ) .'</th>
			            <td data-title=" '. __( 'You Saved', 'woo-discount-price' ) .' "><strong><u>'
						. wc_price( $discount_total + $woocommerce->cart->discount_cart ) .'</u></strong></td>
                 </tr>';

						}


			}


	
}