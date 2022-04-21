<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://typhon.agency
 * @since      1.0.0
 *
 * @package    Icecat_Integration
 * @subpackage Icecat_Integration/admin/partials
 */
// if(isset($_POST['import'])){
    // $return = import_from_excel_to_db();
    // echo $return;
// }
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<form method="POST">
    <label>Import Excel File</label>
    <br>
    <input type="file" name="excel">
    <br>
    <input type="submit" value="import">
</form>