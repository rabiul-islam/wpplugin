<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       woo-schedule-manager
 * @since      1.0.0
 *
 * @package    Woo_Schedule_Manager
 * @subpackage Woo_Schedule_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Schedule_Manager
 * @subpackage Woo_Schedule_Manager/admin
 * @author     Md Rabiul Islam <rabiul.islam@selise.ch>
 */
class Woo_Schedule_Manager_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('admin_menu', array($this, 'store_manager_menu'));    
		add_action('wp_loaded',array($this,'enqueue_scripts')); 
		//echo plugin_dir_url( __FILE__ );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Schedule_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Schedule_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-schedule-manager-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Schedule_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Schedule_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
 
  wp_register_script($this->plugin_name, plugin_dir_url(__FILE__). 'js/woo-schedule-manager-admin.js', array('jquery'), $this->version, TRUE); 
        wp_enqueue_script($this->plugin_name);

	// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-schedule-manager-admin.js', array( 'jquery' ), $this->version, false );

	} 

public function store_manager_menu(){    
	 add_menu_page( 'Store Manager','Store Manager','storeManager', 'storeManager', plugin_dir_url( __FILE__ ) .'/images/settings_gray.png');
	add_submenu_page('storeManager', "Time", "Time Table", 8, 'schedule_times', array($this, 'schedule_page'));
// 3=name, 6=slug 
} 

public function schedule_page(){ 
	include_once(plugin_dir_path( __FILE__ ). 'partials/woo-schedule-manager-admin-display.php');
} 

public function schedule_time_data_func(){
    //get data
    $serialised = get_option( 'schedule_opening_and_closing_time' );
    $data = maybe_unserialize( $serialised );  
    return $data;
}
 



}
