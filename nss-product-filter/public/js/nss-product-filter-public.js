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

	

	
	var custom_page_wrapper = jQuery(window).height();
	//alert(custom_page_wrapper);
   

    
    jQuery( window ).scroll(function() {  
     jQuery("#custom_page_wrapper").css('height', custom_page_wrapper);  

        var header_height 	  		= jQuery('#site-header').height();
        var product_list_item 		= jQuery('.product_list_item').height(); 
        var product_list_item_total = product_list_item + header_height;   
		
        if(jQuery(window).scrollTop() + jQuery(window).height() >= product_list_item_total) {  
           
           var PageNum 		= jQuery('.product_filter_num').text(); 
           //console.log(PageNum);
           var track_page 	= PageNum;  
           var variable 	= 0;    
           load_contents(track_page, variable);//ajax function
        }
    }); 

    function load_contents(track_page, variable){
		var active_category = 0;
		jQuery.ajax({ 
		    url: filter_ajax.ajax_url,   
		    type: "POST", 
		    data: {
		        action:"nss_product_pagination_ajax_action",
		        activeCategory: active_category,
		        page: track_page,  
		    },
		    beforeSend: function(){ 
		       jQuery(".nss_product_filter_load_more").show();  
		    },
		    success: function(response){ 		        
		        jQuery(".nss_product_filter_load_more").hide(); 
		        //pagination data onload 
		        jQuery('.product_list_item').append(response);

				var PageNum  = jQuery('.product_filter_num').text(); 
				var incrPage = parseInt(PageNum) + 1; 
				jQuery('.product_filter_num').text(incrPage); 

		    },error: function(errorThrown){
		        //console.log(errorThrown);
		    } 
		}); 
    }


})( jQuery );
