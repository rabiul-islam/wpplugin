<?php

/**
 * Fired during plugin deactivation
 *
 * @link       woo-schedule-manager
 * @since      1.0.0
 *
 * @package    Woo_Schedule_Manager
 * @subpackage Woo_Schedule_Manager/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Woo_Schedule_Manager
 * @subpackage Woo_Schedule_Manager/includes
 * @author     Md Rabiul Islam <rabiul.islam@selise.ch>
 */
class Woo_Schedule_Manager_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
// Delete all of our plugin's options on uninstall.
global $wpdb;
//$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'schedule_opening_and_closing_time%'" );
//$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE  'store_closed_date%'" );
//$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'sunday_closed%' " );
	}

}
