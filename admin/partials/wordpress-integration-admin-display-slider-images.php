<?php

global $wpdb;
add_thickbox();
if(isset($_POST['add_image'])){
    $wordpress_upload_dir = wp_upload_dir();
    
    $i = 1; 
    
    $offerimage = $_FILES['image'];
    $new_file_path = $wordpress_upload_dir['path'] . '/' . $offerimage['name'];
    $new_file_mime = mime_content_type( $offerimage['tmp_name'] );
    
    if( empty( $offerimage ) )
    	die( 'File is not selected.' );
    
    if( $offerimage['error'] )
    	die( $offerimage['error'] );
    	
    if( $offerimage['size'] > wp_max_upload_size() )
    	die( 'It is too large than expected.' );
    	
    if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
    	die( 'WordPress doesn\'t allow this type of uploads.' ); 
    	
    while( file_exists( $new_file_path ) ) {
    	$i++;
    	$new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $offerimage['name'];
    }
    
    // looks like everything is OK
    if( move_uploaded_file( $offerimage['tmp_name'], $new_file_path ) ) {
    	
    
    	$upload_id = wp_insert_attachment( array(
    		'guid'           => $new_file_path, 
    		'post_mime_type' => $new_file_mime,
    		'post_title'     => preg_replace( '/\.[^.]+$/', '', $offerimage['name'] ),
    		'post_content'   => '',
    		'post_status'    => 'inherit'
    	), $new_file_path );
    
    	// wp_generate_attachment_metadata() won't work if you do not include this file
    	require_once( ABSPATH . 'wp-admin/includes/image.php' );
    
    	// Generate and save the attachment metas into the database
    	wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
    
    
     $uploaded_image = $wordpress_upload_dir['url']. '/' . basename( $new_file_path );
    }
    $wpdb->query("insert into rowad_grid_images(image_url,link,show_img,language,type) values ('$uploaded_image','".$_POST['link']."', '1','".$_POST['lang']."','slider')");


    
}
if(isset($_GET['lang'])){
    $where = " and language='".$_GET['lang']."'";
}
else{
    $where = " and language='ar'";
}
$grid_images = $wpdb->get_results("select * from rowad_grid_images where type='slider' $where","ARRAY_A");
?>
<style>
.onoffswitch {
    position: relative; width: 90px;
    direction:ltr;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
}
.onoffswitch-checkbox {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}
.onoffswitch-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 2px solid #999999; border-radius: 20px;
}
.onoffswitch-inner {
    display: block; width: 200%; margin-left: -100%;
    transition: margin 0.3s ease-in 0s;
}
.onoffswitch-inner:before, .onoffswitch-inner:after {
    display: block; float: left; width: 50%; height: 30px; padding: 0; line-height: 30px;
    font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
    box-sizing: border-box;
}
.onoffswitch-inner:before {
    content: "ON";
    padding-left: 10px;
    background-color: #34A7C1; color: #FFFFFF;
}
.onoffswitch-inner:after {
    content: "OFF";
    padding-right: 10px;
    background-color: #EEEEEE; color: #999999;
    text-align: right;
}
.onoffswitch-switch {
    display: block; width: 18px; margin: 6px;
    background: #FFFFFF;
    position: absolute; top: 0; bottom: 0;
    right: 56px;
    border: 2px solid #999999; border-radius: 20px;
    transition: all 0.3s ease-in 0s; 
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
    margin-left: 0;
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
    right: 0px; 
}
.add_image{
    display:block;
    box-sizing:border-box;
    width: 15%;
    height: 50px;
    background-color: blue;
    color: white;
    border-radius:10px;
    text-decoration:none;
    text-align:center;
    padding-top: 15px;
    font-size: 18px;
    margin-bottom: 15px;
}
.add_image:hover{
    background-color: transparent;
    border:solid 1px blue;
    color: blue;
}
</style>
<div class="wrap">
    <div id="modal-window-id" style="display:none;" dir="rtl">
        <h3>Add New Image</h3>
        <form method="POST" enctype="multipart/form-data">
            <label>Upload Image</label><br>
            <input type="file" name="image" required>
            <br>
            <label>Link</label><br>
            <input type="text" name="link" required>
            <br>
            <br>
            <label>Choose language</label><br>
            <select name='lang' required>
                <option value="">choose</option>
                <option value="en">English</option>
                <option value="ar">العربية</option>
            </select>
            <br>
            <input type="submit" name="add_image" value="Submit">
        </form>
    </div>
    <h1>Slider Homepage Images</h1>
    <h3>Shortcode to use in page builders: [slider_images]</h3>
    <a href="#TB_inline?width=600&height=550&inlineId=modal-window-id" class="thickbox add_image">Add New Image</a>
    <table class="widefat fixed" cellspacing="0">
        <thead>
            <tr>
                <th id="image" class="manage-column column-image" scope="col">Image</th>
                <th id="show" class="manage-column column-show" scope="col">Language</th>
                <th id="show" class="manage-column column-show" scope="col">Link</th>
                <th id="show" class="manage-column column-show" scope="col">Show in Homepage</th>
                <th id="date" class="manage-column column-date num" scope="col">Date</th> 
            </tr>
        </thead>
        <tbody>
            <?php for($i=0;$i<count($grid_images);$i++){ ?>
                <tr <?php if($i % 2 == 0){?> class="alternate" <?php } ?> valign="top" id="tr_<?php echo $grid_images[$i]['id']?>"> 
                    <td class="column-image">
                        <img src="<?php echo $grid_images[$i]['image_url']?>" width="150">
                        <div class="row-actions">
                            <span><a onclick="delete_img(<?php echo $grid_images[$i]['id']?>)">Delete</a></span>
                        </div>
                    </td>
                    <td class="column-date"><?php echo $grid_images[$i]['language']?></td>
                    <td class="column-date"><?php echo $grid_images[$i]['link']?></td>
                    <td class="column-show">
                        <div class="onoffswitch">
                            <input type="checkbox" name="showoffer" class="onoffswitch-checkbox" id="myonoffswitch-<?php echo $grid_images[$i]['id']?>" onchange="update_activation(this.checked,<?php echo $grid_images[$i]['id']?>)" tabindex="0" <?php if($grid_images[$i]['show_img']){ ?> checked <?php }?>>
                            <label class="onoffswitch-label" for="myonoffswitch-<?php echo $grid_images[$i]['id']?>">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </td>
                    <td class="column-date"><?php echo $grid_images[$i]['created_at']?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
    function update_activation(val,id){
        console.log(val);
        if(val){
            val = "1";
        }
        else{
            val = "0";
        }
        jQuery.ajax({
            data: { id : id , value: val },
            type: 'POST',
            url: "https://rowadshop.typhon.agency/wp-json/das/v1/update-image-grid-status",
            cache: false,
            success: function (response) {
                console.log(response);
            }
        });
    }
    function delete_img(id){
        jQuery.ajax({
            data: { id : id },
            type: 'POST',
            url: "https://rowadshop.typhon.agency/wp-json/das/v1/delete-image-grid",
            cache: false,
            success: function (response) {
                jQuery("#tr_"+id).remove();
            }
        });
    }
</script>
