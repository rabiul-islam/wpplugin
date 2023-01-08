(function( $ ) {
  'use strict';

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */ 
 var loading_localization_text = $("#loading_localization_text").val();
 var select_time_localization_text = $("#select_time_localization_text").val();
    $("#schedule_day").on("change", function(){
      var select_date_val = $(this).val();  
      var delivery_method = $("#delivery_method_delivery").val();
      var delivery_schedule = $(".delivery_schedule_wrapper input[name='delivery_schedule']:checked").val();
      //alert(select_date_val);
      if(select_date_val !=''){       
        $.ajax({ 
          url: schedule_time_ajax.custom_ajax_url, //did not same function wordpress susch as ajax_url
          type: "POST", 
          data: {
            action:"schedule_ajax_action",
            selectDate: select_date_val,
            deliveryMethod: delivery_method,
            deliverySchedule: delivery_schedule,
          },
          beforeSend: function(){ 
            $("#time_nxtday").empty();
            $("#time_nxtday").append("<option value=''>"+loading_localization_text+"</option>");
          }, 
          success: function(html){
           // console.log(html); 
             $("#time_nxtday").html(html); 

          //removed duplicate options
           /* var options = {};
            $('#time_nxtday').find('option').each(function() {
              var val = $(this).val(); 
              if (options[val]) {
                $(this).remove();
                return;
              } 
              options[val] = 1;
            });   */     

          }, 
        });
    }else{ 
      $("#time_nxtday").html("<option selected='selected' value=''>"+select_time_localization_text+"</option>"); 
    }

    });  


 
 
$( document ).ready(function() {
    //console.log( "ready!" );
    $(".visibility_on_load").hide(); 
});

   //on checked schedule
    $(".delivery_schedule_wrapper input[name='delivery_schedule']").on("change", function(){
       
       var cheked_delevery_schedule = $(this).val();
       //alert(cheked_delevery_schedule);
        if(cheked_delevery_schedule == 'asap'){
          $("#show_hide_select_wrapper").hide(); 
        }else{
           $("#show_hide_select_wrapper").show(); 
        }
       $("#schedule_day option:selected").removeAttr("selected");
       $("#time_nxtday").html("<option selected='selected' value=''>"+select_time_localization_text+"</option>");

   });
 
 
})(jQuery);
