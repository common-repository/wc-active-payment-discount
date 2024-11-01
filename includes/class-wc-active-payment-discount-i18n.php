<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.webindiainc.com/
 * @since      1.0.0
 *
 * @package    Wc_Active_Payment_Discount
 * @subpackage Wc_Active_Payment_Discount/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wc_Active_Payment_Discount
 * @subpackage Wc_Active_Payment_Discount/includes
 * @author     Webindia <akash@webindiainc.com>
 */
class Wc_Active_Payment_Discount_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wc-active-payment-discount',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
