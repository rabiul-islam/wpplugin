<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://http://www.rabiulislam.info/
 * @since      1.0.0
 *
 * @package    Nss_Product_Filter
 * @subpackage Nss_Product_Filter/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="nss_product_filter_wrapper"> 
    <div class="nss_product_filter_input_filter row">
         <div class="col-md-11">
             <form method="post">
                <input type="text" placeholder="Search by location or event">
                <input type="submit" value="Search" class="filter_submit">
             </form>
         </div>
         <div class="col-md-1" id="filter_button_wrap">
             <a href="javascript:void(0);" data-toggle="modal" data-target="#product_filter_modal">
              Filter
            </a>
         </div>
    </div>
<div class="row product_list_item">    
   <p class="product_filter_num">1</p>
<?php 
global $post;
  $args = array(
   'post_type' => 'post',
   'posts_per_page' => 30, 
    );

$search_query = new \WP_Query( $args); 
if( $search_query->have_posts() ) {
   while( $search_query->have_posts() ):
      $search_query->the_post(); 
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );  
     /*$terms = wp_get_object_terms( get_the_ID(), 'transactions_category');

      foreach($terms as $cat){
         $cat_slug_by_post_id = $cat->slug;
      } */ 
      ?>

     <div class="product_filter_post col-md-4">
        <div class="product_filter_post_inner">
            <a href="<?php the_permalink(); ?>">
             <img src="<?php echo $image[0]; ?>" alt="<?php the_title();?>">
            </a>
             <div class="nss_product_filter_wrapper_details"> 
                <a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php the_title(); ?></a>
                <?php the_content();?>  
             </div>
        </div>
      </div>  
      <?php
  endwhile;
} else {
    // no posts found
}
/* Restore original Post Data */
wp_reset_postdata();
?> 
</div>

<div class="nss_product_filter_load_more">
     <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
</div>

</div><!--nss_product_filter_wrapper-->
 


<!-- Modal Html-->
<div class="modal" id="product_filter_modal" >
  <div class="modal-dialog modal-lg">
    <form method="post" id="FormId">
      <div class="modal-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="search_list_inner list"> 
                  
                  <h3>Type Of Events</h3> 

                  <div class="filter_input_group type_of_events"> 
                    <?php
                    $trans_years_args =array( 
                      'taxonomy' => 'type_of_events',
                      'hierarchical' => 0, 
                      'orderby' => 'term_id',
                      'order'  => 'DESC'
                    );
                    $trans_years_query = get_categories($trans_years_args);
                    foreach ($trans_years_query as $key=>$years) { ?>                 
                      <li>
                        <input type="checkbox" name="years_selector" id="<?php echo $years->slug; ?>" value="<?php echo $years->slug; ?>">
                        <label for="<?php echo $years->slug; ?>"><?php echo $years->name; ?></label>
                      </li> 
                      <?php
                    }
                    ?>   
                  </div>  
                </div>
            </div>


            <div class="col-lg-4">
                <div class="search_list_inner last">
                  <h3>Location</h3>
                  <div class="filter_input_group catering_location"> 
                    <?php
                    $trans_sectors_args =array( 
                      'taxonomy' => 'catering_location',
                      'hierarchical' => 0, 
                      'orderby' => 'term_id',
                      'order'  => 'ASC'
                    );
                    $trans_sectors_query = get_categories($trans_sectors_args);
                    foreach ($trans_sectors_query as $key=>$sectors) {?> 
                     <li>                 
                      <input type="checkbox" name="sectors_selector" id="<?php echo $sectors->slug; ?>" value="<?php echo $sectors->slug; ?>">
                      <label for="<?php echo $sectors->slug; ?>"><?php echo $sectors->name; ?></label>
                    </li> 
                    <?php } ?>
                  </div>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="search_list_inner last">
                  <h3>Guests</h3>
                  <div class="filter_input_group catering_guests"> 
                    <?php
                    $trans_sectors_args =array( 
                      'taxonomy' => 'catering_guests',
                      'hierarchical' => 0, 
                      'orderby' => 'term_id',
                      'order'  => 'ASC'
                    );
                    $trans_sectors_query = get_categories($trans_sectors_args);
                    foreach ($trans_sectors_query as $key=>$sectors) {?>
                    <li>                  
                      <input type="checkbox" name="sectors_selector" id="<?php echo $sectors->slug; ?>" value="<?php echo $sectors->slug; ?>">
                      <label for="<?php echo $sectors->slug; ?>"><?php echo $sectors->name; ?></label> 
                    </li>
                    <?php } ?>
                  </div>

                </div>
            </div>
        </div><!--row-->

        <div class="btn_area text-right modal_button"> 
          <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">CANCEL</button>
          <button type="submit" name="submit_btn" class="submit_btn btn btn-secondary"> APPLY </button>
        </div>

      </div>
    </form>
  </div>
</div>