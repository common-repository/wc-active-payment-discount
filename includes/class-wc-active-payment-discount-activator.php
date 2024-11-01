<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.webindiainc.com/
 * @since      1.0.0
 *
 * @package    Wc_Active_Payment_Discount
 * @subpackage Wc_Active_Payment_Discount/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wc_Active_Payment_Discount
 * @subpackage Wc_Active_Payment_Discount/includes
 * @author     Webindia <akash@webindiainc.com>
 */
class Wc_Active_Payment_Discount_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			wp_die( 'Sorry, but this plugin requires the Woocommerce Plugin to be installed and active. <br><a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">&laquo; Return to Plugins</a>' );
		}else{
			update_option( 'wap_status', '0' );
		}
	}

}
