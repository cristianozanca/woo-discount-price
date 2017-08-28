<?php

// Allow to use custom template files in template directory like a Child Theme

function woodiscpr_custom_woocommerce_locate_template( $template, $template_name, $template_path ) {

	global $woocommerce;

	$_template = $template;

	if ( !$template_path ) $template_path = $woocommerce->template_url;

	$plugin_path  = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/../templates/';

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