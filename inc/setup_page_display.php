<?php

// check user permission to admin setup values

function woodiscpr_setup_page_display() {
	if (!current_user_can('manage_options')) {
		wp_die('Unauthorized user');
	}

// get values from setup-file.php

	if (isset($_POST['woodiscpr_you_save'])) {
		update_option('woodiscpr_you_save', $_POST['woodiscpr_you_save']);

// include setup form external

	}

	include_once( plugin_dir_path( __FILE__ ) . '../inc/setup-file.php' );

}