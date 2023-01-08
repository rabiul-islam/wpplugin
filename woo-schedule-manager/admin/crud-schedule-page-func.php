<?php 
error_reporting(0);

//store closed submit
if(isset($_POST['store_closed_submit_btn'])){ 
	//first delete options
	delete_option( 'store_closed_date' );
	delete_option( 'sunday_closed' );
	
	$store_closed_date = $_POST['store_closed_date'];
	$sunday_closed = $_POST['sunday_closed'];
	 
	$closed_date_array =array();
	foreach($store_closed_date as $row_date){    
		if(!empty($row_date)){ 
			$closed_date_array[] = $row_date;
		}
	}  
	if($store_closed_date){
		add_option('store_closed_date',  serialize($closed_date_array), '', 'yes'); 
	}
	if($sunday_closed == 'yes'){
		add_option('sunday_closed',  serialize($sunday_closed), '', 'yes'); 
	}
	//alert message
	$msg = 'success';  
}


//schedule submit
if(isset($_POST['schedule_submit_btn'])){ 

	delete_option( 'schedule_opening_and_closing_time' );
	$day = array();
	$day['saturday'] = array(
	    'opening' => $_POST['schedule_time_saturday_opening'], 
	    'closing' => $_POST['schedule_time_saturday_closing'], 
	);

	$day['sunday'] = array(
	    'opening' => $_POST['schedule_time_sunday_opening'], 
	    'closing' => $_POST['schedule_time_sunday_closing'], 
	); 
	$day['monday'] = array(
	    'opening' => $_POST['schedule_time_monday_opening'], 
	    'closing' => $_POST['schedule_time_monday_closing'], 
	);

	$day['tuesday'] = array(
	    'opening' => $_POST['schedule_time_tuesday_opening'], 
	    'closing' => $_POST['schedule_time_tuesday_closing'], 
	);

	$day['wednesday'] = array(
	    'opening' => $_POST['schedule_time_wednesday_opening'], 
	    'closing' => $_POST['schedule_time_wednesday_closing'], 
	);

	$day['thursday'] = array(
	    'opening' => $_POST['schedule_time_thursday_opening'], 
	    'closing' => $_POST['schedule_time_thursday_closing'], 
	);

	$day['friday'] = array(
	    'opening' => $_POST['schedule_time_friday_opening'], 
	    'closing' => $_POST['schedule_time_friday_closing'], 
	); 

	add_option('schedule_opening_and_closing_time',  serialize($day), '', 'yes'); 
	//alert message
	$msg = 'success'; 
} 
 
?>