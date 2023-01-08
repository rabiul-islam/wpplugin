(function( $ ) {
	'use strict';


	/**
	 * All of the code for your admin-facing JavaScript source
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

  
  var validation_msg = '<p class="alert_msg_arrow">Closing time will bigger than opening time.</p>';
  $(".next_selector").on("change", function(){ 
    
   var last_selected_val = $(this).val(); 
   var prev_secletor_val = $(this).parents().first().prev().find('select').val(); 
   if(prev_secletor_val  >= last_selected_val  ){
     $('.alert_msg_arrow').remove();
     $(this).parents().first().prev().append(validation_msg); 
     $('.alert_msg_arrow').fadeIn('slow').fadeOut(7000);
   } 
 });

$("form#schedule_form_id").submit(function(){
     
    var schedule_time_saturday_opening = $('#schedule_time_saturday_opening').val(); 
    var schedule_time_saturday_closing = $('#schedule_time_saturday_closing').val(); 

    var schedule_time_sunday_opening = $('#schedule_time_sunday_opening').val(); 
    var schedule_time_sunday_closing = $('#schedule_time_sunday_closing').val(); 

    var schedule_time_monday_opening = $('#schedule_time_monday_opening').val(); 
    var schedule_time_monday_closing = $('#schedule_time_monday_closing').val(); 

    var schedule_time_tuesday_opening = $('#schedule_time_tuesday_opening').val(); 
    var schedule_time_tuesday_closing = $('#schedule_time_tuesday_closing').val(); 

    var schedule_time_wednesday_opening = $('#schedule_time_wednesday_opening').val(); 
    var schedule_time_wednesday_closing = $('#schedule_time_wednesday_closing').val(); 

    var schedule_time_thursday_opening = $('#schedule_time_thursday_opening').val(); 
    var schedule_time_thursday_closing = $('#schedule_time_thursday_closing').val(); 


    var schedule_time_friday_opening = $('#schedule_time_friday_opening').val(); 
    var schedule_time_friday_closing = $('#schedule_time_friday_closing').val();     


    if(schedule_time_saturday_opening >= schedule_time_saturday_closing) {
     $('.alert_msg_arrow').remove();
     $("#schedule_time_saturday_closing").parents().first().prev().append(validation_msg); 
     $('.alert_msg_arrow').fadeIn('slow').fadeOut(7000);
     return false;
   }else if(schedule_time_sunday_opening >= schedule_time_sunday_closing) {
     $('.alert_msg_arrow').remove();
     $("#schedule_time_sunday_closing").parents().first().prev().append(validation_msg); 
     $('.alert_msg_arrow').fadeIn('slow').fadeOut(7000);
     return false; 
   }else if(schedule_time_monday_opening >= schedule_time_monday_closing) {
     $('.alert_msg_arrow').remove();
     $("#schedule_time_monday_closing").parents().first().prev().append(validation_msg); 
     $('.alert_msg_arrow').fadeIn('slow').fadeOut(7000);
     return false; 
   }else if(schedule_time_tuesday_opening >= schedule_time_tuesday_closing) {
     $('.alert_msg_arrow').remove();
     $("#schedule_time_tuesday_closing").parents().first().prev().append(validation_msg); 
     $('.alert_msg_arrow').fadeIn('slow').fadeOut(7000);
     return false; 
   } else if(schedule_time_wednesday_opening >= schedule_time_wednesday_closing) {
     $('.alert_msg_arrow').remove();
     $("#schedule_time_wednesday_closing").parents().first().prev().append(validation_msg); 
     $('.alert_msg_arrow').fadeIn('slow').fadeOut(7000);
     return false; 
   } else if(schedule_time_thursday_opening >= schedule_time_thursday_closing) {
     $('.alert_msg_arrow').remove();
     $("#schedule_time_thursday_closing").parents().first().prev().append(validation_msg); 
     $('.alert_msg_arrow').fadeIn('slow').fadeOut(7000);
     return false; 
   }else if(schedule_time_friday_opening >= schedule_time_friday_closing) {
     $('.alert_msg_arrow').remove();
     $("#schedule_time_friday_closing").parents().first().prev().append(validation_msg); 
     $('.alert_msg_arrow').fadeIn('slow').fadeOut(7000);
     return false; 
   }
   
 });


//store closed query
   jQuery.fn.extend({

    createRepeater: function (options = {}) {
        var hasOption = function (optionKey) {
            return options.hasOwnProperty(optionKey);
        };

        var option = function (optionKey) {
            return options[optionKey];
        };

        var generateId = function (string) {
            return string
                .replace(/\[/g, '_')
                .replace(/\]/g, '')
                .toLowerCase();
        };
         var last_item =0;
        var addItem = function (items, key, last_item = 0) {
            var itemContent = items;
            var group = itemContent.data("group");
            var item = itemContent;
            var input = item.find('input,select,textarea');

            input.each(function (index, el) {
                var attrName = jQuery(el).data('name');
                var skipName = jQuery(el).data('skip-name');
                if (skipName != true) {
                    //$(el).attr("name", group + "[" + key + "]" + "[" + attrName + "]");
                    jQuery(el).attr("name",  "store_closed_date[]");
                } else {
                    if (attrName != 'undefined') {
                        jQuery(el).attr("name", attrName);
                        jQuery(el).attr("name", "store_closed_date[]");
                    }
                }
                if (last_item == 0) { 
                     //$(el).attr('value', '');
                } 
                jQuery(el).attr('id', generateId(jQuery(el).attr('name'))+key);
                jQuery(el).parent().find('label').attr('for', generateId(jQuery(el).attr('name')));
            })

            var itemClone = items;

            /* Handling remove btn */
            var removeButton = itemClone.find('.remove-btn');

            if (key == 0) {
             
               // removeButton.attr('disabled', true);

            } else {
                removeButton.attr('disabled', false);
               
            } 
          removeButton.attr('onclick', 'jQuery(this).parents(\'.schedule_items\').remove()');
            var newItem = jQuery("<div class='schedule_items'>" + itemClone.html() + "<div/>");
            newItem.attr('data-index', key)

            newItem.appendTo(repeater);
        };

        /* find elements */
        var repeater = this;
         var sign = jQuery;
        var items = repeater.find(".schedule_items");
        var key = 0;
        var addButton = repeater.find('.repeater-add-btn');

        items.each(function (index, item) {

            items.remove();
            if (hasOption('showFirstItemToDefault') && option('showFirstItemToDefault') == true) {
                addItem(sign(item), key); 
                key++;
            } else {
                if (items.length > 1) { 
                     
                    addItem(sign(item), key);
                    key++;
                }
            }
        });

        /* handle click and add items */
        addButton.on("click", function () { 
            addItem(jQuery(items[0]), key);
             $( '#store_closed_date_'+key ).attr( "value", '' );
            key++;
        });
    }
});
  $("#repeater").createRepeater({

     showFirstItemToDefault: true,
  });
  //date first 
   /*$(".first_fields_btn_click").click(function(){
     $('.first_fields').attr("value", "");
     alert(11111111);
   });*/

 })(jQuery);


