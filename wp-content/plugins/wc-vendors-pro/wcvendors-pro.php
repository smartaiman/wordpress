<?php
/**
 * Plugin Name:       WC Vendors Pro
 * Plugin URI:        https://www.wcvendors.com/product/wc-vendors-pro/
 * Description:       The WC Vendors Pro plugin 
 * Version:           1.3.6
 * Author:            WC Vendors
 * Author URI:        http://www.wcvendors.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wcvendors-pro
 * Domain Path:       /languages
 *
 * @link              http://www.wcvendors.com
 * @since             1.0.5
 * @package           WCVendors_Pro
 *

WC Vendors Pro is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
WC Vendors Pro is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with WC Vendors. If not, see http://www.gnu.org/licenses/gpl-2.0.txt.

You have purchased a support contract for the duration of one year from the date 
of purchase that entitles you access to updates of WC Vendors Pro and support 
for WC Vendors Pro. 

*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WCV_PRO_VERSION', '1.3.6' ); 

/**
 * The code that runs during plugin activation.
 */
function activate_wcvendors_pro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wcvendors-pro-activator.php';
	WCVendors_Pro_Activator::activate( __FILE__ );
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_wcvendors_pro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wcvendors-pro-deactivator.php';
	WCVendors_Pro_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wcvendors_pro' );
register_deactivation_hook( __FILE__, 'deactivate_wcvendors_pro' );

if ( get_option( 'wcvendors_pro_api_manager_activated' ) != 'Activated' ) {
    add_action( 'admin_notices', 'WCVendors_Pro_API_Manager::license_inactive_notice' );
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-wcvendors-pro-updater.php';

function wcvendors_pro_api_manager_instance() {
    return WCVendors_Pro_API_Manager::instance( __FILE__, WCV_PRO_VERSION );
}

wcvendors_pro_api_manager_instance();

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wcvendors-pro.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wcvendors_pro() {

	$plugin = new WCVendors_Pro();
	$plugin->run();
	return $plugin;

}
$wcvendors_pro = run_wcvendors_pro();
