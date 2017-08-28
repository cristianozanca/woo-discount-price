<?php

// better separated voice to check quicker what every single value in add_menu_page is

function woodiscpr_plugin_setup_menu() {
	$page_title = 'Discount Price WooCommerce Admin Page';
	$menu_title = 'Discount Price WooCommerce';
	$capability = 'manage_options';
	$menu_slug = 'woodiscpr-plugin';
	$function = 'woodiscpr_setup_page_display';
	$icon_url = '';
	$position = 59;

	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}