<?php

// Don't access this directly, please
if ( ! defined( 'ABSPATH' ) ) exit;

?>


<h1><?php echo __( 'Discount Price Settings Page', 'woo-discount-price' );?>/h1>


<form method="POST">
	<label for="woodiscpr_you_save"><?php echo __( 'Enable "You Saved" in cart and checkout page', 'woo-discount-price' );?></label>

	<input type="hidden" name="woodiscpr_you_save" value="0" />
	<input type="checkbox" name="woodiscpr_you_save" id="woodiscpr_you_save" value="1" <?php if ( 1 == get_option('woodiscpr_you_save') ) echo 'checked';

	else echo '';

	?>>

	<input type="submit" value="Save" class="button button-primary button-large">
</form>





