<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://http://www.rabiulislam.info/
 * @since      1.0.0
 *
 * @package    Nss_Product_Filter
 * @subpackage Nss_Product_Filter/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Nss_Product_Filter
 * @subpackage Nss_Product_Filter/public
 * @author     Md Rabiul Islam <rabiul.islam@selise.ch>
 */
class Nss_Product_Filter_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_shortcode('product_filter_shortcode', [$this,'product_filter_shortcode_func']);

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nss_Product_Filter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nss_Product_Filter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nss-product-filter-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nss_Product_Filter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nss_Product_Filter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nss-product-filter-public.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script($this->plugin_name);       	
       	wp_localize_script($this->plugin_name, 'filter_ajax', array('ajax_url' => admin_url('admin-ajax.php')));


	}
     public function product_filter_shortcode_func(){
        ob_start();
        require plugin_dir_path( __FILE__ ) . 'partials/nss-product-filter-public-display.php';
        return  ob_get_clean();
     }
	public function nss_product_filter_method_init() {
	    $this->product_filter_shortcode_func(); 
	}


//pagination ajax function
//ajax data
public function post_count_ajax_function_callback(){   
 
   $activeCategory =  $_REQUEST['activeCategory']; 
   $page = $_REQUEST['page'];  

   //for pagination 
   $total_post_args = array(
      'post_type' => 'post',
      'posts_per_page' => 300, 
   );
  

$total_post_args_query = new WP_Query( $total_post_args);
   $post_count =  $total_post_args_query->post_count;  
   //$per_page =  ceil( $post_count / 3); 
   echo $post_count; 
   die();
}


//onload data for transaction ajax data

public function pagination_ajax_function_callback(){   
	global $wpdb;
	//$posts_per_page = 15;   
	$activeCategory =  $_REQUEST['activeCategory']; 
	echo $page = $_REQUEST['page'];   

	$args = array(
	'post_type' => 'post',
	'posts_per_page' => 30, 
	);  
	$pagination_query = new \WP_Query( $args); 
	?>
	<div class="row" id="results">
	 <?php
			
	if( $pagination_query->have_posts() ) {
	   $i = 1;
	   while( $pagination_query->have_posts() ) { 
	     $pagination_query->the_post();
	     $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); 
	      ?>
	       <div class="product_filter_post col-md-4">
	        <div class="product_filter_post_inner">
	            <a href="#">
	             <img src="<?php echo $image[0]; ?>" alt="<?php the_title();?>">
	            </a>
	             <div class="nss_product_filter_wrapper_details"> 
	                <a href="#" title="<?php the_title();?>"><?php the_title(); ?></a>
	                <?php the_content();?>  
	             </div>
	        </div>
	      </div>  
	      <?php	      
	      $i++;
	    }
	}else{
	   echo 'No data found..';
	} 
	?>
	</div>
	<?php
	die(); 
	}//ajax close

}