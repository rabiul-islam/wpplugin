<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       woo-schedule-manager
 * @since      1.0.0
 *
 * @package    Woo_Schedule_Manager
 * @subpackage Woo_Schedule_Manager/admin/partials
 */
$data_controller = new Woo_Schedule_Manager_Admin($plugin_name='', $version='');
/*$data_controller->shcedule_submit_func($_POST); */ 
$data = $data_controller->schedule_time_data_func();
$range =range(strtotime('00:15'),strtotime('23:45'),15*60);

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap schedule_time_admin">
	 <?php  
	if(isset($msg)){
		echo __('<div id="message" class="updated inline"><p><strong>Your settings have been saved.</strong></p></div>'); 
	} 
	?>
	
	 <h2><?php echo __('Schedule For Order');?></h2>

		<table class="wp-list-table widefat fixed striped table-view-list pages"> 
			
			<form method="post" id="schedule_form_id" autocomplete="off">

			<thead>
				<tr>
					<th></th>
					<th><?php echo __('Opening Time');?></th>
					<th><?php echo __('Closing Time');?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<th><?php echo __('Saturday');?></th>
					<td>
						<select id="schedule_time_saturday_opening" name="schedule_time_saturday_opening" >
							<option value=""><?php echo __('Opening Time');?></option>
							<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['saturday']['opening'] == date("H:i",$time)){  echo'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time); ?></option>
							<?php } ?>  
						</select>
					</td>
					<td> 
						<select class="next_selector" id="schedule_time_saturday_closing" name="schedule_time_saturday_closing" >
							<option value=""><?php echo __('Closing Time');?></option>
							<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['saturday']['closing'] == date("H:i",$time)){  echo 'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time); ?></option>
							<?php } ?>  

						</select>
					</td>
				</tr>
				<tr>
					<th><?php echo __('Sunday');?></th>
					<td><select id="schedule_time_sunday_opening" name="schedule_time_sunday_opening" >
						<option value=""><?php echo __('Opening Time');?></option>
						<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['sunday']['opening'] == date("H:i",$time)){  echo 'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time);?></option>
							<?php } ?>  
					</select></td>
					<td> 
						<select class="next_selector" id="schedule_time_sunday_closing" name="schedule_time_sunday_closing" >
							<option value=""><?php echo __('Closing Time');?></option>
							<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['sunday']['closing'] == date("H:i",$time)){  echo'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time); ?></option>
							<?php } ?>  

						</select>
					</td>
				</tr> 

				<tr>
					<th><?php echo __('Monday');?></th>
					<td><select id="schedule_time_monday_opening" name="schedule_time_monday_opening" >
						<option value=""><?php echo __('Opening Time'); ?></option>
						<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['monday']['opening'] == date("H:i",$time)){  echo 'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time); ?></option>
							<?php } ?>  
					</select></td>
					<td> 
						<select class="next_selector" id="schedule_time_monday_closing" name="schedule_time_monday_closing" >
							<option value=""><?php echo __('Closing Time');?></option>
							<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['monday']['closing'] == date("H:i",$time)){  echo 'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time); ?></option>
							<?php } ?>  
						</select>
					</td>
				</tr>
				<tr>
					<th><?php echo __('Tuesday');?></th>
					<td><select id="schedule_time_tuesday_opening" name="schedule_time_tuesday_opening" >
						<option value=""><?php echo __('Opening Time');?></option>
						<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['tuesday']['opening'] == date("H:i",$time)){  echo 'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time); ?></option>
							<?php } ?>  
					</select></td>
					<td> 
						<select  class="next_selector" id="schedule_time_tuesday_closing" name="schedule_time_tuesday_closing" >
							<option value=""><?php echo __('Closing Time');?></option>
							<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['tuesday']['closing'] == date("H:i",$time)){ echo 'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time); ?></option>
							<?php } ?>  
						</select>
					</td>
				</tr>

				<tr>
					<th><?php echo __('Wednesday');?></th>
					<td><select  id="schedule_time_wednesday_opening" name="schedule_time_wednesday_opening" >
						<option value=""><?php echo __('Opening Time');?></option>
						<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['wednesday']['opening'] == date("H:i",$time)){  echo 'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time); ?></option>
							<?php } ?>  
					</select></td>
					<td> 
						<select class="next_selector" id="schedule_time_wednesday_closing" name="schedule_time_wednesday_closing" >
							<option value=""><?php echo __('Closing Time');?></option>
							<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['wednesday']['closing'] == date("H:i",$time)){  echo 'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time); ?></option>
							<?php } ?>  
						</select>
					</td>
				</tr>

				<tr>
					<th><?php echo __('Thursday');?></th>
					<td><select id="schedule_time_thursday_opening" name="schedule_time_thursday_opening" >
						<option value=""><?php echo __('Opening Time'); ?></option>
						<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['thursday']['opening'] == date("H:i",$time)){  echo 'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time); ?></option>
							<?php } ?>  
					</select></td>
					<td> 
						<select class="next_selector" id="schedule_time_thursday_closing" name="schedule_time_thursday_closing" >
							<option value=""><?php echo __('Closing Time');?></option>
							<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['thursday']['closing'] == date("H:i",$time)){  echo 'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time); ?></option>
							<?php } ?>  
						</select>
					</td>
				</tr>

				<tr>
					<th><?php echo __('Friday');?></th>
					<td><select id="schedule_time_friday_opening" name="schedule_time_friday_opening" >
						<option value=""><?php echo __('Opening Time');?></option>
						<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['friday']['opening'] == date("H:i",$time)){  echo 'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time); ?></option>
							<?php } ?>  
					</select></td>
					<td> 
						<select class="next_selector" id="schedule_time_friday_closing" name="schedule_time_friday_closing" >
							<option value=""><?php echo __('Closing Time'); ?></option>
							<?php  
							foreach($range as $time){  
							 ?>
								<option <?php if($data['friday']['closing'] == date("H:i",$time)){  echo 'selected'; } ?> value="<?php echo date("H:i",$time); ?>"><?php echo date("H:i",$time); ?></option>
							<?php } ?>  
						</select>
					</td>
				</tr>
				<tr> 
					<td colspan="3" align="left"><input class="button-primary  schedule_submit_btn" type="submit" name="schedule_submit_btn" value="<?php echo __('Save Schedule');?>"></td>
				</tr>

			</tbody>
		 </form>
		</table>
 
	
	 
		<div class="closed_wrapper">	
			<form method="post" id="store_closed_form_id" autocomplete="off">
				<h2><?php echo __('Store Closed Date');?></h2>
 <!-- Repeater Html Start -->
                <div id="repeater">

                	<?php  
                	//get closed data
					$serialised_closed = get_option( 'store_closed_date' );
					$data_closed_date = maybe_unserialize( $serialised_closed );
					//print_r($data_closed_date);
					 if($data_closed_date){
					 	$i=1;
					foreach($data_closed_date as $closed_date_row){
						  ?> 
                   
                    <!-- Repeater Items -->
                    <div class="schedule_items" data-group="test">
                        <!-- Repeater Content -->
                        <div class="item-content">
                            <div class="form-group date_input ">  
                                    <input type="date" value="<?php echo $closed_date_row; ?>" class="form-control"  >
                                
                            </div>
                           
                        </div> 
                         <!-- Repeater Remove Btn -->
                        <div class="pull-right repeater-remove-btn">
                            <button type="button" class="btn btn-danger remove-btn">
                                <?php echo __('Remove');?>
                            </button>
                        </div>
                    </div>
                <?php $i++; } }else{?>
                	 <!-- Repeater Items -->
                    <div class="schedule_items" data-group="test">
                        <!-- Repeater Content -->
                        <div class="item-content">
                            <div class="form-group date_input">  
                               <input type="date" class="form-control first_fields" >
                                
                            </div>
                           
                        </div> 
                         <!-- Repeater Remove Btn -->
                        <div class="pull-right repeater-remove-btn">
                            <button type="button" class="btn btn-danger remove-btn first_fields_btn_click">
                                <?php echo __('Remove');?>
                            </button>
                        </div>
                    </div>
                <?php } ?>

                     <!-- Repeater Heading -->
                    <div class="repeater-heading">
                        
                        <button type="button" class="button-primary  pt-5 pull-right repeater-add-btn">
                            <?php echo __('Add');?>
                        </button>
                    </div> 

                   
                </div>
                <!-- Repeater End -->
                 <div class="sunday_closed_wrapper"> 
                 	<?php 
                 	//get sunday_closed data
					$serialised_sunday_closed = get_option( 'sunday_closed' );
					$data_sunday_closed_status = maybe_unserialize( $serialised_sunday_closed ); 
				    ?>
				    <label for="sunday_closed"><strong><?php echo __('Sunday Closed');?></strong></label>
                    <input type="checkbox" name="sunday_closed" id="sunday_closed" value="yes" <?php if($data_sunday_closed_status == 'yes'){ ?> checked="checked" <?php } ?>> 
                  </div>


			 <div class="closed_submit_warpper"><input class="button-primary  store_closed_submit_btn" type="submit" name="store_closed_submit_btn" value="<?php echo __('Save Store Closed');?>"></div>
					   
			</form>
	 </div>
	
</div>  

 