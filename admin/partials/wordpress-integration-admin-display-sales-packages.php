<?php 
global $wpdb;
if(isset($_POST['add_package'])){
    $check_package = $wpdb->get_results("select * from rowad_sale_packages where name='".$_POST['name']."'");
    if(count($check_package) > 0){
        $name = $_POST['name']."_1";
    }
    else{
        $name = $_POST['name'];
    }
    wp_insert_term( $name, 'product_tag', array(
        'parent' => 0, // optional
        'slug' => str_replace(" ","-",$name) // optional
    ) );
    $shortcode = "[sale-packages name=\'".str_replace(" ","-",$name)."\']";
    $id = $wpdb->query("insert into rowad_sale_packages(name,title_ar,title_en,shortcode,tag_name) values('$name','".$_POST['title_ar']."','".$_POST['title_en']."','".$shortcode."','".str_replace(" ","-",$name)."')");
}

$packages = $wpdb->get_results("select * from rowad_sale_packages","ARRAY_A");
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
    <h2>Sales Packages</h2>
    <p>Here you can add sales packages for products, all what you have to do is to create one and take the tag created and choose it when adding new product.</p>
    <p>Each package will have a shortcode to use it in pages.</p>
    <a href="#TB_inline?width=600&height=550&inlineId=modal-window-id" class="thickbox add_image">Add New Pacakge</a>
    <table class="widefat fixed" cellspacing="0">
        <thead>
            <tr>
                <th id="name" class="manage-column column-name" scope="col">Package Name</th>
                <th id="title-ar" class="manage-column column-title-ar" scope="col">Package Title AR</th>
                <th id="title-en" class="manage-column column-title-en" scope="col">Package Title EN</th>
                <th id="tag" class="manage-column column-tag" scope="col">Tag Name</th>
                <th id="shortcode" class="manage-column column-shortcode" scope="col">Shortcode</th>
                <th id="show" class="manage-column column-show" scope="col">Status</th>
                <th id="date" class="manage-column column-date num" scope="col">Date</th> 
            </tr>
        </thead>
        <tbody>
            <?php for($i=0;$i<count($packages);$i++){ ?>
                <tr <?php if($i % 2 == 0){?> class="alternate" <?php } ?> valign="top" id="tr_<?php echo $packages[$i]['id']?>"> 
                    <td class="column-name">
                        <p><?php echo $packages[$i]['name']?></p>
                        <div class="row-actions">
                            <span><a onclick="delete_img(<?php echo $packages[$i]['id']?>)">Delete</a></span>
                        </div>
                    </td>
                    <td class="column-title-ar"><?php echo $packages[$i]['title_ar']?></td>
                    <td class="column-title-en"><?php echo $packages[$i]['title_en']?></td>
                    <td class="column-tag"><?php echo $packages[$i]['tag_name']?></td>
                    <td class="column-shortcode"><?php echo $packages[$i]['shortcode']?></td>
                    <td class="column-show">
                        <div class="onoffswitch">
                            <input type="checkbox" name="showoffer" class="onoffswitch-checkbox" id="myonoffswitch-<?php echo $packages[$i]['id']?>" onchange="update_activation(this.checked,<?php echo $packages[$i]['id']?>)" tabindex="0" <?php if($packages[$i]['status']){ ?> checked <?php }?>>
                            <label class="onoffswitch-label" for="myonoffswitch-<?php echo $packages[$i]['id']?>">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </td>
                    <td class="column-date"><?php echo $packages[$i]['created_at']?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div id="modal-window-id" style="display:none;" dir="ltr">
    <h3>Add New Package</h3>
    <form method="POST" enctype="multipart/form-data">
        <label>Package Name</label><br>
        <input type="text" name="name" placeholder="Enter Package Name..." required><br>
        <label>Package Title EN</label><br>
        <input type="text" name="title_en" placeholder="Enter Package Title EN..." required><br>
        <label>Package Title AR</label><br>
        <input type="text" name="title_ar" placeholder="Enter Package Title AR..." required><br>
        <input type="submit" name="add_package" value="Submit">
    </form>
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
            url: "https://rowadshop.typhon.agency/wp-json/das/v1/update-sale-package",
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
            url: "https://rowadshop.typhon.agency/wp-json/das/v1/delete-sale-package",
            cache: false,
            success: function (response) {
                jQuery("#tr_"+id).remove();
                // console.log(response);
            }
        });
    }
</script>
