<?php
add_filter ( 'woocommerce_product_thumbnails_columns', 'bbloomer_change_gallery_columns' );
 
function bbloomer_change_gallery_columns() {
     return 1; 
}
add_filter ( 'storefront_product_thumbnail_columns', 'bbloomer_change_gallery_columns_storefront' );
 
function bbloomer_change_gallery_columns_storefront() {
     return 1; 
}



function get_product_by_gtin_from_icecat($gtin,$lang){
    global $wpdb;
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://live.icecat.biz/api/?UserName=nabil.kashlan&Language='.$lang.'&GTIN='.$gtin,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    $ret = json_decode(curl_exec($curl),true);
    curl_close($curl);
    if(isset($ret['msg'])){
        
    }
    else{
        $msg_code = $ret['Code'];
    }
}

// api for update offer image grid display in homepage
add_action( 'rest_api_init', function () {
  register_rest_route( 'das/v1', '/update-sale-package', array(
    'methods' => 'POST',
    'callback' => 'update_sale_package','permission_callback' => function($request){
            // This always returns false
            return true;
        },
  ) );
} );
function update_sale_package( $data ) {
    global $wpdb;
    $image_id = $data->get_param('id');
    $val = $data->get_param('value');
    $query = $wpdb->query("update rowad_sale_packages set status='$val' where id='$image_id'");
    return true;
}
// api for delete offer image grid in homepage
add_action( 'rest_api_init', function () {
  register_rest_route( 'das/v1', '/delete-sale-package', array(
    'methods' => 'POST',
    'callback' => 'delete_sale_package','permission_callback' => function($request){
            // This always returns false
            return true;
        },
  ) );
} );
function delete_sale_package( $data ) {
    global $wpdb;
    $image_id = $data->get_param('id');
    $tag = $wpdb->get_var("select tag_name from rowad_sale_packages where id='$image_id'");
    $tag_woocommerce = get_term_by('name', $tag, 'product_tag');
    wp_delete_term( $tag_woocommerce->term_id, 'product_tag' );
    $query = $wpdb->query("delete from rowad_sale_packages where id='$image_id'");
    return $query;
}


// api for update offer image grid display in homepage
add_action( 'rest_api_init', function () {
  register_rest_route( 'das/v1', '/update-image-grid-status', array(
    'methods' => 'POST',
    'callback' => 'update_grid_image','permission_callback' => function($request){
            // This always returns false
            return true;
        },
  ) );
} );
function update_grid_image( $data ) {
    global $wpdb;
    $image_id = $data->get_param('id');
    $val = $data->get_param('value');
    $query = $wpdb->query("update rowad_grid_images set show_img='$val' where id='$image_id'");
    return true;
}
// api for delete offer image grid in homepage
add_action( 'rest_api_init', function () {
  register_rest_route( 'das/v1', '/delete-image-grid', array(
    'methods' => 'POST',
    'callback' => 'delete_grid_image','permission_callback' => function($request){
            // This always returns false
            return true;
        },
  ) );
} );
function delete_grid_image( $data ) {
    global $wpdb;
    $image_id = $data->get_param('id');
    $query = $wpdb->query("delete from rowad_grid_images where id='$image_id'");
    return true;
}


// adding tawtk code to header
add_action('wp_head', 'tawk_chatbot');
function tawk_chatbot(){
   if(ICL_LANGUAGE_CODE=='en'): ?>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/61dbfd5eb84f7301d32a3651/1fp74r9km';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
    <?php elseif(ICL_LANGUAGE_CODE=='ar'): ?>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/61dbfd5eb84f7301d32a3651/1fp1lbevf';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
    <?php endif;
}


// for switching currency in languages
add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);
   
function change_existing_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        case 'SAR':         
        if(ICL_LANGUAGE_CODE=='ar'){        
        $currency_symbol = 'ر.س'; 
        }else{
                 $currency_symbol = 'SAR'; 
            } 
        break;          
    }
    return $currency_symbol;
}
