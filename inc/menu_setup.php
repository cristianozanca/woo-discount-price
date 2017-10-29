<?php

// better separated voice to check quicker what every single value in add_menu_page is

function woodiscpr_plugin_setup_menu() {
    $parent_slug= 'woocommerce';
    $page_title = 'Discount Price WooCommerce Admin Page';
    $menu_title = 'Discount Price';
	$capability = 'manage_options';
	$menu_slug  = 'woodiscpr-plugin';
	$function   = 'woodiscpr_setup_page_display';

	add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
}


