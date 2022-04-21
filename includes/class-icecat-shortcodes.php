<?php
function slider_images(){
    global $wpdb;
    $images = $wpdb->get_results("select * from rowad_grid_images where show_img='1' and type='slider' and language='".ICL_LANGUAGE_CODE."'","ARRAY_A");
    if(count($images) == 1){
        return '<img style="display: block; width: 100%;" src="'.$images[0]['image_url'].'">';
    }
    $response = '<style> .swiper-pagination-bullet{background:#fff;}</style>
                <div class="elementor-widget-wrap e-swiper-container">
    				<div class="elementor-element elementor-element-fd8b963 elementor-pagination-position-inside elementor-arrows-position-inside elementor-widget elementor-widget-image-carousel" data-id="fd8b963" data-element_type="widget" data-settings="{&quot;slides_to_show&quot;:&quot;1&quot;,&quot;autoplay_speed&quot;:7000,&quot;navigation&quot;:&quot;both&quot;,&quot;autoplay&quot;:&quot;yes&quot;,&quot;pause_on_hover&quot;:&quot;yes&quot;,&quot;pause_on_interaction&quot;:&quot;yes&quot;,&quot;infinite&quot;:&quot;yes&quot;,&quot;effect&quot;:&quot;slide&quot;,&quot;speed&quot;:500}" data-widget_type="image-carousel.default">
        				<div class="elementor-widget-container">
    	    				<div class="elementor-image-carousel-wrapper swiper-container swiper-container-initialized swiper-container-horizontal" dir="ltr">
    			                <div class="elementor-image-carousel swiper-wrapper" style="transform: translate3d(-14773px, 0px, 0px); transition-duration: 0ms;">
    ';
    for($i = 0;$i < count($images) ; $i++){
        $response .= '<div class="swiper-slide swiper-slide-active" data-swiper-slide-index="10" style="width: 1343px;">
    								<a href="'.$images[$i]['link'].'"><figure class="swiper-slide-inner">
    								    <img class="swiper-slide-image" src="'.$images[$i]['image_url'].'" alt="feecfa6d-6d06-4b91-a545-b107ce312349">
    								</figure></a>
								</div>';
    }
    $response .= '</div><div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">';
    for($i = 0;$i < count($images) ; $i++){
        $response .= '<span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 1"></span>';
    }
    $response .= '</div>
							<div class="elementor-swiper-button elementor-swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide">
						        <i aria-hidden="true" class="eicon-chevron-left"></i>
						        <span class="elementor-screen-only">السابق</span>
					        </div>
        					<div class="elementor-swiper-button elementor-swiper-button-next" tabindex="0" role="button" aria-label="Next slide">
        						<i aria-hidden="true" class="eicon-chevron-right"></i>
        						<span class="elementor-screen-only">التالي</span>
        					</div>
							<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
						</div>
				    </div>
				</div>
			</div>';
    return $response;
}
add_shortcode("slider_images","slider_images");


function grid_images_offers(){
    global $wpdb;
    $images = $wpdb->get_results("select * from rowad_grid_images where show_img='1' and type='grid' and language='".ICL_LANGUAGE_CODE."'","ARRAY_A");
    $return = "<style> .image_grid{ display:inline-block; width: 30%; height:150px; object-fit: cover; margin: 15px;}
    @media only screen and (max-width: 600px){ .image_grid{ width: 100%; margin: 10px 0 10px 0;} }
    </style><div style='display:block; width: 100%; text-align: center; box-sizing: border-box; padding: 2%'>";
    foreach($images as $img){
        $return .= "<a href='".$img['link']."'><img class='image_grid' src='".$img['image_url']."'></a>";
    }
    $return .= "</div>";
    return $return;
}
add_shortcode("grid_images_offers","grid_images_offers");

function carousellfunc($atts){ 
    $name = $atts['name'];
    ob_start();
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <style>
    .nav-button{
        margin: 0 !important;
        padding: 0 !important;
    }
    .carousel-wrapper {
      width: 100%;
      margin: 0 auto;
      position: relative;
      text-align: center;
      font-family: sans-serif;
    }

    .owl-carousel .owl-nav {
      overflow: hidden;
      height: 0px;
    }

    .owl-theme .owl-dots .owl-dot.active span,
    .owl-theme .owl-dots .owl-dot:hover span {
      background: #5110e9;
    }


    .owl-carousel .item {
      text-align: center;
    }

    .owl-carousel .nav-button {
      height:60px;
      width: 25px;
      cursor: pointer;
      position: absolute;
      top: 220px !important;
      
    }

    .owl-carousel .owl-prev.disabled,
    .owl-carousel .owl-next.disabled {
      pointer-events: none;
      opacity: 0.0;
    
    }

    .owl-carousel .owl-prev {
      left: -35px;
    }

    .owl-carousel .owl-next {
      right: -35px;
    }

    .owl-theme .owl-nav [class*=owl-] {
      color: rgba(0, 0, 0, 0.1);
      font-size: 90px;
      background: #ffffff;
      border-radius: 3px;
      display: flex;
      flex-wrap: wrap;
      align-content: flex-end;
      
      
    }
    .owl-theme .owl-nav [class*=owl-]:hover{
         background-color:#ffffff;
         color:#000000;
         font-size: 90px;
         
     }
    .owl-carousel .prev-carousel:hover {
      background-position: 0px -53px;
    }

    .owl-carousel .next-carousel:hover {
      background-position: -24px -53px;
    }
    .item{
	min-height:365px;
	margin:0 15px;
	overflow: hidden;
    }
    .item img{
    width: 100%;
	height: 200px;
	
    }
    .woocommerce-loop-product__title:link{
    margin : 0;
    text-decoration:none;
	font-family:"Noto Kufi Arabic";
	font-weight:400;
	position: relative;
	left:10%;
	right:50%;
    }
    .yellow-but{
        height:40px;
        border-style:solid;
        border-width:1px;
    	background-color:#000000;
    	color:#FFFFFF;
    	font-weight: 700;
    	margin-top:0px;
    	font-size:100%;
    	position : absolute;
    	align-items:center;
    	align-content:flex-end;
    	bottom : 8px;
    	left :15%;
    	right :15%;
        text-decoration: none !important;
        padding-top: 2%;
    }
    .yellow-but:hover{
        background-color:#FFFFFF;
        color:#000000;
    }
    .slice{
        border: 0.1px solid;
        border-color:rgba(0, 0 ,0, 0.1);
    }
    .slice:hover{
        border-color:#3159A0;
    }
  
    
    .before-sale{
        font-weight:700;
        font-size: 0.9em !important;
        color: rgba(0, 0, 0, 0.5) !important;
        text-decoration:line-through;
        position : absolute;
        bottom :45px;
	    left :20%;
	    right :20%;
    }
    .normal-pr{
        font-weight:700;
        font-size: 0.9em !important;
        color: #000 !important;
        position : absolute;
        bottom :30px;
        left :20%;
	    right :20%;
    }
    .woocommerce-loop-product__title{
        font-size: 13px !important;
        color: #4B4B4B !important;
    }
    .onsale{
        color:#ffffff;
        display: block;
        background-color: #B80000;
        font-family: "Noto Kufi Arabic", Sans-serif;
        font-size: 14px;
        font-weight: 400;
        border-radius: 20px;
        min-width: 75px;
        position : absolute;
        right: 5px;
        margin: 10px;
        padding: 10px;
    }

    
    
    
    
  </style>
    <div class="carousel-wrapper">
    <div class="owl-carousel owl-theme" id="owl_<?php echo $name?>" dir="ltr">
    <?php
    $args = array(
        'post_type' => 'product',
        'tax_query' => array( array('taxonomy' => 'product_tag','field' => 'slug','terms' => $name))
    );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post(); 
    global $product; ?>
    <div class ="slice">
        <div class="item">
            <?php if($product->is_on_sale()): ?>
            <?php if(ICL_LANGUAGE_CODE=='en'): ?>
            <span class="onsale">Sale!</span>
            <?php elseif(ICL_LANGUAGE_CODE=='ar'): ?>
            <span class="onsale">!تخفيض</span>
            <?php endif; ?>
            <?php endif; ?>
            <a href="<?php the_permalink(); ?>" id="id-<?php the_id(); ?>" title="<?php the_title(); ?>" style="text-decoration: none !important">
                <?php
                if (has_post_thumbnail( $loop->post->ID )) 
                    echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); 
                else
                    echo '<img src="'.woocommerce_placeholder_img_src().'" alt="product placeholder Image" width="65px" height="115px" />'; ?>
                <h2 class="woocommerce-loop-product__title"><?php the_title();?></h3>
            </a>
            <?php if($product->is_on_sale()): ?>
            <h4 class="before-sale"><?php echo woocommerce_price($product->get_regular_price());?></h4>
            <h4 class="normal-pr"><?php echo woocommerce_price($product->get_price());?></h4>
            
            <?php else: ?><h4 class ="normal-pr"><?php echo woocommerce_price($product->get_price());?></h4><?php endif; ?>
            
            <div class="best_seller_button">
                <?php if(ICL_LANGUAGE_CODE=='en'): ?>
                <a href="<?php echo home_url(); ?>?add-to-cart=<?php echo get_the_ID() ?>" class="yellow-but" >Add to Cart</a>
                <?php elseif(ICL_LANGUAGE_CODE=='ar'): ?>
                <a href="<?php echo home_url(); ?>?add-to-cart=<?php echo get_the_ID() ?>" class="yellow-but" >إضافة الى السلة</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php endwhile; 
    ?>
    </div>
    </div>
    <?php wp_reset_query(); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    <script>
        $('#owl_<?php echo $name?>').owlCarousel({
          margin: 15,
          nav: true,
          navText: ["<div class='nav-button owl-prev'>‹</div>", "<div class='nav-button owl-next'>›</div>"],
          responsive: {
            0: {
              items: 2
            },
            600: {
              items: 3
            },
            1000: {
              items: 6
            }
          }
        });
    </script>
    <?php
    // ob_end_clean();
} 

function test_sh($atts){
    return "test";
}
add_shortcode('sale_packages', 'carousellfunc');