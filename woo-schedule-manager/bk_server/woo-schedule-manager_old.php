<?php

	/**
	* The plugin bootstrap file
	*
	* This file is read by WordPress to generate the plugin information in the plugin
	* admin area. This file also includes all of the dependencies used by the plugin,
	* registers the activation and deactivation functions, and defines a function
	* that starts the plugin.
	*
	* @link              https://selise.ch/
	* @since             1.0.0
	* @package           Woo_Schedule_Manager
	*
	* @wordpress-plugin
	* Plugin Name:       Woo Schedule Manager
	* Plugin URI:        https://selise.ch/
	* Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
	* Version:           1.0.0
	* Author:            Md Rabiul Islam
	* Author URI:        https://selise.ch/
	* License:           GPL-2.0+
	* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
	* Text Domain:       woo-schedule-manager
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
	define( 'WOO_SCHEDULE_MANAGER_VERSION', '1.0.0' );

	/**
	* The code that runs during plugin activation.
	* This action is documented in includes/class-woo-schedule-manager-activator.php
	*/
	function activate_woo_schedule_manager() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-schedule-manager-activator.php';
		Woo_Schedule_Manager_Activator::activate();
	}

	/**
	* The code that runs during plugin deactivation.
	* This action is documented in includes/class-woo-schedule-manager-deactivator.php
	*/
	function deactivate_woo_schedule_manager() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-schedule-manager-deactivator.php';
		Woo_Schedule_Manager_Deactivator::deactivate();
	}

	register_activation_hook( __FILE__, 'activate_woo_schedule_manager' );
	register_deactivation_hook( __FILE__, 'deactivate_woo_schedule_manager' );

	/**
	* The core plugin class that is used to define internationalization,
	* admin-specific hooks, and public-facing site hooks.
	*/
	require plugin_dir_path( __FILE__ ) . 'admin/crud-schedule-page-func.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-woo-schedule-manager.php';

	/**
	* Begins execution of the plugin.
	*
	* Since everything within the plugin is registered via hooks,
	* then kicking off the plugin from this point in the file does
	* not affect the page life cycle.
	*
	* @since    1.0.0
	*/ 
	//time zone
	 date_default_timezone_set("Europe/Zurich");   

	// Set session variables
	 //$_SESSION["shipping_type"] = "takeaway";  

	//ajax data
	function schedule_ajax_function(){ 	 
		
		//get data from database
		$serialised = get_option( 'schedule_opening_and_closing_time' );
		$data = maybe_unserialize( $serialised );
		 
		if($serialised){
			//server date and time 		
			$recent_date =  date('d-m-Y');

			$select_date =  $_POST['selectDate'];//choose dropdown
			$deliverySchedule =  $_POST['deliverySchedule']; //checked radio 		
			$deliveryMethod =  $_POST['deliveryMethod'];  //get session data by input hidden


			/*------ deliveryMethod takeaway start -------*/
			//if takeaway and asap selected
			if($deliveryMethod == 'takeaway' AND  $deliverySchedule == 'asap'){ 
				$delivery_method_wise_opening_time = +0;
				$delivery_method_wise_closing_time = -30; 
			}
			//if takeaway and schedule selected
			if($deliveryMethod == 'takeaway' AND  $deliverySchedule == 'schedule'){

				$delivery_method_wise_opening_time = +15;
				$delivery_method_wise_closing_time = -15; 
			}
			/*------ deliveryMethod takeaway close -------*/

			

			/*------ deliveryMethod delivery start -------*/
			
			//if delivery and asap selected
			if($deliveryMethod == 'delivery' AND  $deliverySchedule == 'asap'){ 
				$delivery_method_wise_opening_time = +0;
				$delivery_method_wise_closing_time = -30; 
			}
			//if delivery and schedule selected
			if($deliveryMethod == 'delivery' AND  $deliverySchedule == 'schedule'){

				$delivery_method_wise_opening_time = +60;
				$delivery_method_wise_closing_time = +0; 
			}

			/*------ deliveryMethod delivery close -------*/  


			$day_name = date("l", strtotime($select_date)); 
			
			//admin settings data from database
			$day_wise_opening_time_data   = $data[strtolower($day_name)]['opening']; //9:00
			$day_wise_closing_time_data  = $data[strtolower($day_name)]['closing']; //20:00 

			//time diff by delivery method opening and closing time
			$day_wise_opening_time = date("H:i", strtotime($delivery_method_wise_opening_time.' minutes', strtotime($day_wise_opening_time_data))); 
			$day_wise_closing_time = date("H:i", strtotime($delivery_method_wise_closing_time.' minutes', strtotime($day_wise_closing_time_data)));  		


			//today date conditions
			$time_is_over =0;
			if($recent_date == $select_date){  	

				//below current time from db start time 
				$now_recent_time_stemp =  strtotime(date('H:i'));   
				$day_wise_opening_time_data_time_stemp = strtotime($day_wise_opening_time_data);//db opening time

				//for delivery before recent time
				if($now_recent_time_stemp >= $day_wise_opening_time_data_time_stemp AND $deliveryMethod == 'delivery'){
					//echo 'before_deivery'; 
					$add_hour = date("H:i", strtotime('+1 hour +38 minutes', $now_recent_time_stemp)); 
					$day_wise_opening_time = rounded_time_func($add_hour);  
					if(strtotime($day_wise_opening_time) > strtotime($day_wise_closing_time)){
							$time_is_over = 1;
						}

				}else{ 
					//for delivery after recent time
					$create_timestemp_today_opening_time = strtotime($day_wise_opening_time);	
					if($now_recent_time_stemp >= $create_timestemp_today_opening_time AND $deliveryMethod == 'delivery'){
						//echo 'after_delivery';
						$add_hour = date("H:i", strtotime('+1 hour +38 minutes')); 
						$day_wise_opening_time = rounded_time_func($add_hour);  
						if(strtotime($day_wise_opening_time) > strtotime($day_wise_closing_time)){
							$day_wise_closing_time = $day_wise_opening_time;
						}
					}

					//for takeaway before recent time	 
						    
					if($now_recent_time_stemp >= $day_wise_opening_time_data_time_stemp AND $deliveryMethod == 'takeaway'){  
						 //echo 'before_takeaway'; 
						$add_hour = date("H:i", strtotime('+23 minutes', $now_recent_time_stemp)); 
						$day_wise_opening_time = rounded_time_func($add_hour);				
						if(strtotime($day_wise_opening_time) > strtotime($day_wise_closing_time)){
							$time_is_over = 1;
						}
					}else{
						//echo $day_wise_opening_time_data_time_stemp;
						  
						if($now_recent_time_stemp >= $day_wise_opening_time_data_time_stemp AND $deliveryMethod == 'takeaway'){ 
							// echo 'after_takeaway';
							$add_hour = date("H:i", strtotime('+23 minutes')); 
							$day_wise_opening_time = rounded_time_func($add_hour); 
							if(strtotime($day_wise_opening_time) > strtotime($day_wise_closing_time)){
								$day_wise_closing_time = $day_wise_opening_time;
							}
						}
					}  			
				}  

			} 
			if($time_is_over ==1){
				echo '<option value="">'. __('No slot available today', 'sesh').'</option>';
			}else{
				$range=range(strtotime($day_wise_opening_time),strtotime($day_wise_closing_time),15*60);  
				 foreach($range as $key => $time){   
					 echo '<option value="'.date("H:i",$time).'">'.date("H:i",$time).'</option>';	 
				} 
			}

		}else{
		echo '<option value="">'. __('No data found.', 'sesh').'</option>'; //no data here
		}

	die();
	} 

	//for rounded date
	function rounded_time_func($add_hour){
		$time = strtotime($add_hour);				
		$round = 15*60;
		$rounded = round($time / $round) * $round;  
		return $day_wise_opening_time = date("H:i", $rounded);  
	}

	//ajax add action
	add_action('wp_ajax_schedule_ajax_action', 'schedule_ajax_function');
	add_action('wp_ajax_nopriv_schedule_ajax_action', 'schedule_ajax_function'); 
	function action_woocommerce_before_checkout_form() {  ?>

		<div class="schedule_date_time" id="schedule_date_time">
			<div class="visibility_on_load"></div>
			<?php
			//opening/closing time conditions 
			if(isset($_POST['shipping_type'])){ 
				$deliveryMethod = $_POST['shipping_type'];
			}else{ 
				$deliveryMethod = $_SESSION['shipping_type']; 
				//from theme session save_delivery_date_to_session() --- page functions.php 
			}
			//get store closed data
			$serialised_closed = get_option( 'store_closed_date' );
			//$data_closed_date =[];
			$data_closed_date = maybe_unserialize( $serialised_closed );			

			//get sunday_closed data
			$serialised_sunday_closed = get_option( 'sunday_closed' );
			$data_sunday_closed_status = maybe_unserialize( $serialised_sunday_closed ); 

			/*------------------as soon as posible status----------------*/
			//if below time at db time
			//get data
			$serialised = get_option( 'schedule_opening_and_closing_time' );
			$data = maybe_unserialize( $serialised );		 

			$recent_time_stemp = strtotime(date('H:i')); 
			$day_name = date("l", strtotime(date('d-m-Y'))); 
			//admin data from database
			$day_wise_opening_time   = $data[strtolower($day_name)]['opening']; //9:00
			$day_wise_closing_time  = $data[strtolower($day_name)]['closing']; //20:00  

			$day_wise_closing_time = date("H:i", strtotime('-30 minutes', strtotime($day_wise_closing_time))); //as soon as posible closed before 30min

			/*if($deliveryMethod == 'delivery'){
			$day_wise_closing_time = date("H:i", strtotime('-1 hour -30 minutes', strtotime($day_wise_closing_time))); //as soon as posible closed before 1hour 30min
			}*/ 
			  
			$today_db_opening_time_stemp = strtotime($day_wise_opening_time); 
			$create_timestemp_today_closing_time = strtotime($day_wise_closing_time); 
			   	
			//opening time 
			$as_soon_as_open_status = 0;     
			if($recent_time_stemp >= $today_db_opening_time_stemp) { // if db opening time smaller than current time -- (db_opening_time=9:00, current_time = 9:15 == as soon as posible show)	 
				$as_soon_as_open_status = 1; 
				$hide_select_wrapper_class = 'select_hide';
			}
			//time over
			$time_over = 0;	 
			if( $recent_time_stemp >= $create_timestemp_today_closing_time ){ //if db closing time  smaller than current time -- (db_closing_time=18:30, current_time = 17:15 == as soon as posible hide)
				$time_over =  1; 
				$as_soon_as_open_status = 0;
				$hide_select_wrapper_class = 'select_show'; 
				$time_over_closed_date = date('Y-m-d');  				 
			} 
             
			/*------------------as soon as posible status----------------*/
			if($time_over_closed_date){
				$data_closed_date = array_merge($data_closed_date, array($time_over_closed_date));
			}


			$count_row=1;
			$count = 0;
			$closed_date = array();
			foreach($data_closed_date as $closed_date_row){  
				$closed_date[] = $closed_date_row;
				$count =$count_row;
				if($closed_date_row == date('Y-m-d')){
					$as_soon_as_open_status = 0; //all closed date soon as posible hide
					$hide_select_wrapper_class = 'select_show'; 
				} 
				$count_row++;				 
			}			

			$total_days  = $count + 7; 
			$recent_date = date('d-m-Y');
			$begin = new DateTime( $recent_date);
			$end   = new DateTime( '+ '.$total_days.'day');

			$calender_with_closed_date = array();			
			for($i = $begin; $i <= $end; $i->modify('+1 day')){   
			//sunday closed condtions
				$sunday_closed_date=  $i->format("l"); 
				if($data_sunday_closed_status =='yes'){
					if($sunday_closed_date != "Sunday"){ 
						$calender_with_closed_date[] =  $i->format("Y-m-d");  
					}

				}else{
					 $calender_with_closed_date[] =  $i->format("Y-m-d");  					
				} 
			} 
			   
			//all sunday closed if checked sunday
			//$day_name ='Monday';
			if($data_sunday_closed_status =='yes'){
				if($day_name =='Sunday'){
					$as_soon_as_open_status = 0; //all sunday as soon as posible hide
					$hide_select_wrapper_class = 'select_show';  
				}
			}


		$exact_date = array_diff($calender_with_closed_date, $closed_date); //removed closed date


	?>	 
	<!-- <div style="border:1px solid #ddd; margin-bottom: 30px">
		<table>
			<tr>
				<td>Zurich GMT: </td>
				<td>+2</td>
			</tr>
			<tr>
				<td>Zurich Date: </td>
				<td><?php echo date('l j F, Y');?></td>
			</tr>
			<tr>
				<td>Zurich Time: </td>
				<td> <?php  echo date('H:i:s A');?></td>
			</tr>
		</table>
	</div> -->

	<input type="hidden" value="<?php echo $deliveryMethod; ?>" name="delivery_method" id="delivery_method_delivery"> <!--hidden delivery_method session data-->  


	<input type="hidden" value="<?php echo __('Loading...', 'sesh'); ?>" id="loading_localization_text"> <!--hidden loading_text-->  

	<input type="hidden" value="<?php echo __('Select time', 'sesh'); ?>" id="select_time_localization_text"> <!--hidden select_time_localization_text-->  


	<p class="delivery-schedule-field checkout-radio-field" id="delivery_schedule_field">
		<span class="delivery_schedule_wrapper">
			<?php 
			if($as_soon_as_open_status == 1){   
				?>
				<input type="radio" class="input-radio" value="asap" name="delivery_schedule" id="delivery_schedule_asap" checked="checked">
				<label for="delivery_schedule_asap" class="radio "><?php echo __('As Soon as Possible', 'sesh');?></label>

			<?php } ?>  
			<input type="radio" class="input-radio " <?php if($as_soon_as_open_status == 0 ) { ?> checked="checked" <?php } ?> value="schedule" name="delivery_schedule" id="delivery_schedule_takeaway">
			<label for="delivery_schedule_takeaway" class="radio "><?php echo __('Schedule', 'sesh');?></label>
		</span> 
	</p>
	<div class="show_hide_select_wrapper <?php if($hide_select_wrapper_class) { echo $hide_select_wrapper_class; } ?>" id="show_hide_select_wrapper">
		<select name="schedule_day" id="schedule_day">
			<option value=""><?php echo __('Select date', 'sesh'); ?></option>
			<?php  
			foreach($exact_date as $option_date){ 
				echo '<option class="" value="'.date('d-m-Y', strtotime($option_date)).'">'.date('d F Y', strtotime($option_date)).'</option>'; 
			}
			?>
		</select> 
		<select id="time_nxtday" name="schedule_time_nxt_day">
			<option value=""><?php echo __('Select time', 'sesh'); ?></option> 
		</select>
	</div>
	</div>
	<?php }
	//add html in before checkout form
	add_action( 'woocommerce_before_checkout_billing_form', 'action_woocommerce_before_checkout_form', 10, 1 );  

	//close custom code



	function run_woo_schedule_manager() {

		$plugin = new Woo_Schedule_Manager();
		$plugin->run();

	}
	run_woo_schedule_manager();
