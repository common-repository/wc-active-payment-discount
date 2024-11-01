<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           Wc_Active_Payment_Discount
 *
 * @wordpress-plugin
 * Plugin Name:       WC Active Payment Discount
 * Plugin URI:        wc-active-payment-discount
 * Description:       <code>WC Active Payment Discount</code> is used for get discount on activated payment method.
 * Version:           1.3
 * Author:            Kairav, Akash Solanki
 * Author URI:        #
 * Text Domain:       wc-active-payment-discount
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
 
define( 'WC_ACTIVE_PAYMENT_DISCOUNT_VERSION', '1.0.0' );
define( 'WC_ACTIVE_PAYMENT_DISCOUNT_PATH', plugin_dir_path( __FILE__ ) );
define( 'WAP_DIR_PATH', plugin_dir_url( __FILE__ ) );
define( 'WAP_PLUGIN_URL', WC_ACTIVE_PAYMENT_DISCOUNT_PATH  );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wc-active-payment-discount-activator.php
 */
function activate_wc_active_payment_discount() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-active-payment-discount-activator.php';
	Wc_Active_Payment_Discount_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc-active-payment-discount-deactivator.php
 */
function deactivate_wc_active_payment_discount() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-active-payment-discount-deactivator.php';
	Wc_Active_Payment_Discount_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_active_payment_discount' );
register_deactivation_hook( __FILE__, 'deactivate_wc_active_payment_discount' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-active-payment-discount.php';

/**
 * Check woocommerce is active or not  
 */
add_action( 'plugins_loaded', 'activate_woocommerce_check' );

function activate_woocommerce_check()
{
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
	{
		add_action( 'admin_notices', 'activate_woocommerce_check_message' );
		return;
	}
}

function activate_woocommerce_check_message(){
	echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'Woocommerce plugin should be active for use Woocommerce Active payment plugin You can download %s here.', 'wc-active-payment-discount	' ), '<a href="#" target="_blank">Woocommerce</a>' ) . '</strong></p></div>';
	
}


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_active_payment_discount() {

	$plugin = new Wc_Active_Payment_Discount();
	$plugin->run();

}
run_wc_active_payment_discount();
