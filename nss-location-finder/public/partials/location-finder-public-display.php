<div class="nss_location_finder_wrapper">
<div class="container" > 
   <div class="nss_location_finder_filter_panel">
      <select class="nss_division">
         <?php
         global $cat;
         $cat_args=array( 
         'taxonomy' => 'nss-division',
         'parent' => 0, 
         //'include_children' => false,
         'hierarchical' => 0, 
         'orderby' => 'term_id',
         'order'  => 'ASC' 
         );
         $categories = get_categories($cat_args); 
         foreach ($categories as $key=>$category) { ?>  
           <option value="<?php echo $category->term_id; ?>" <?php if($key ==0) { ?> selected="selected" <?php } ?>><?php echo $category->name; ?></option> 
         <?php } ?>  
      </select>

       <select class="nss_district">
         <option>District </option> 
      </select>

       <select class="nss_thana">
         <option>Thana/Upazila</option> 
      </select>

      <div class="align-items-center spinner">   
             <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
     </div>

   </div> 

      <?php 
      //total count
      $args = array(      
          'post_type' => 'nss-locator',
          'post_status' => 'publish',  
          'order' => 'ASC',                 
      ); 
      $post = new WP_Query($args); 
      $post_count = $post->post_count +1;//pagination 1 post hide  
      ?> 
      <div class="containers" data-ref="containers">
         <div class="row data-container" id="results"></div>    
      </div> 
      <div id="location-finder-pagination-list" class="pagination"></div> <!--pagination Elements close--> 
   
   </div><!--container-->
</div>

<script type="text/javascript">

 //onload data
 categoryWisePaginationFunc(<?php echo $post_count; ?>); 

function categoryWisePaginationFunc(post_count){  
    var container = jQuery('#location-finder-pagination-list');
    var activeCategory = jQuery('.nss_location_finder_filter_panel select').val(); 

        var sources = function () {
        var result = [];  
        for (var i = 1; i < post_count ; i++) {
        result.push(i);
        } 
        return result;
    }();

    var options = { 
        pageSize: 3, 
        dataSource: sources,
            callback: function (response, pagination) { 
            var page = jQuery('.active').attr('data-num'); 
            jQuery.ajax({ 
                url: location_finder_filter.ajax_url,   
                type: "POST", 
                data: {
                    action:"locator_ajax_action",
                    activeCategory: activeCategory,
                    page:page, 
                },
                beforeSend: function(){ 
                  jQuery(".spinner").show();  
                },
                success: function(response){ 
                     jQuery(".spinner").hide(); 
                    //pagination data onload 
                     //console.log(response);
                     container.prev().html(response); 
                     //jQuery('#results').html(response);
                },error: function(errorThrown){
                    //console.log(errorThrown);
                } 
            });

        }
    };

     jQuery.pagination(container, options); 

    container.addHook('beforeInit', function () {
      window.console && console.log('beforeInit...');
    });
    container.pagination(options);

    container.addHook('beforePageOnClick', function () {
      window.console && console.log('beforePageOnClick...');
      //return false
    }); 
} 


//select on change
jQuery('.nss_location_finder_filter_panel select').on('change',function(){ 
   var activeCategory = jQuery(this).val(); 
  // alert(activeCategory);
   //ajax value 
    jQuery.ajax({ 
    url: location_finder_filter.ajax_url,   
    type: "POST", 
    data: {
        action:"nss_post_count_ajax_action",
        activeCategory: activeCategory,
    }, 
    success: function(response){   
        console.log(response);  
       categoryWisePaginationFunc(response);//paginate data func
    } 
   }); 

});   

 


//district
jQuery('.nss_location_finder_filter_panel .nss_division').on('change',function(){ 
      var activeCategory = jQuery(this).val(); 
      //ajax value 
    jQuery.ajax({ 
    url: location_finder_filter.ajax_url,   
    type: "POST", 
    data: {
        action:"nss_division_post_title_ajax_action",
        activeCategory: activeCategory,
    }, 
    success: function(response){   
         console.log(response); 
       jQuery('.nss_district').html(response);        
    } 
   }); 
  });

//thana
jQuery('.nss_location_finder_filter_panel .nss_district').on('change',function(){ 
  
   var activeCategory = jQuery(this).val(); 
       //ajax value 
    jQuery.ajax({ 
    url: location_finder_filter.ajax_url,   
    type: "POST", 
    data: {
        action:"nss_division_post_title_ajax_action",
        activeCategory: activeCategory,
    }, 
    success: function(response){   
        console.log(response);  
       jQuery('.nss_thana').html(response);        
    } 
   }); 
 });
 

 </script>
<?php return ob_get_clean(); ?>