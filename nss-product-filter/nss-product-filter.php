<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://http://www.rabiulislam.info/
 * @since             1.0.0
 * @package           Nss_Product_Filter
 *
 * @wordpress-plugin
 * Plugin Name:       Nss Product Filter
 * Plugin URI:        https://http://www.rabiulislam.info/
 * Description:       Customer display products by this plugin.
 * Version:           1.0.0
 * Author:            Md Rabiul Islam
 * Author URI:        https://http://www.rabiulislam.info/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nss-product-filter
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
define( 'NSS_PRODUCT_FILTER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nss-product-filter-activator.php
 */
function activate_nss_product_filter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nss-product-filter-activator.php';
	Nss_Product_Filter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nss-product-filter-deactivator.php
 */
function deactivate_nss_product_filter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nss-product-filter-deactivator.php';
	Nss_Product_Filter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nss_product_filter' );
register_deactivation_hook( __FILE__, 'deactivate_nss_product_filter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nss-product-filter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nss_product_filter() {

	$plugin = new Nss_Product_Filter();
	$plugin->run();

}
run_nss_product_filter();
