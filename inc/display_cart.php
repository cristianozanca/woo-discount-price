<?php

// show discount price in cart page

function woodiscpr_change_cart_table_price_display( $price, $values, $cart_item_key ) {
	$slashed_price = $values['data']->get_price_html();
	$is_on_sale = $values['data']->is_on_sale();
	if ( $is_on_sale ) {
		$price = $slashed_price;
	}
	return $price;
}

##################################
/*
 * alternative code , decimal separator point instead of comma
 *
function woodiscpr_change_cart_table_price_display( $price, $values, $cart_item_key ) {
	$prezzo_scontato = wc_format_decimal($values['data']->get_sale_price(),2, ''  );
	$prezzo_pieno = wc_format_decimal($values['data']->get_regular_price(),2, '','');
	$valuta = get_woocommerce_currency_symbol();
	$is_on_sale = $values['data']->is_on_sale();
	if ( $is_on_sale ) {
		$price = '<del>'.$valuta.$prezzo_pieno.'</del> ' . $valuta.$prezzo_scontato;
	}
	return $price;
}

*/
###############################