<?php

//------------------------------- Package--------------------------------//

add_action('admin_menu', 'my_add_package_menu_items');
function my_add_package_menu_items()
{
    $hook = add_submenu_page(
        'ics_theme_settings',
        'Package Setting',
        'Package Setting',
        'manage_options',
        'package-page',
        'render_package_page'
    );
    add_action("load-$hook", 'add_package_options');

}

function add_package_options()
{
    $option = 'per_page';
    $args = array(
        'label' => 'Package',
        'default' => 10,
        'option' => 'package_per_page',
    );
    add_screen_option($option, $args);
}

//add_action('admin_menu', 'my_add_package_menu_items');


function render_package_page()
{
    global $wpdb;
    require_once('header.php');
    $classPackage = new Package($wpdb);
    $getPage = empty($_GET['page-position']) ? 1 : $_GET['page-position'];
    ?>
    <h2>Package Setting</h2>
    <script type="text/javascript"
            src="<?php bloginfo('template_directory'); ?>/libs/js/package.js"></script>
    <link rel="stylesheet" type="text/css"
          href="<?php echo get_template_directory_uri(); ?>/libs/css/bootstrap.min.css"/>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrap.min.js"></script>
<!--    <script src="--><?php //echo get_template_directory_uri();
    ?><!--/libs/js/bootstrapValidator.min.js"></script>-->
    <div class="btn-group">
        <a class="btn btn-default <?php echo $getPage == 1 ? "active" : "";?>" href="?page=package-page&page-position=1" role="button">จำนวนโพส</a>
        <a class="btn btn-default <?php echo $getPage == 2 ? "active" : "";?>" href="?page=package-page&page-position=2" role="button">ระยะเวลาของโพส</a>
        <a class="btn btn-default <?php echo $getPage == 3 ? "active" : "";?>" href="?page=package-page&page-position=3" role="button">Hotjob</a>
        <a class="btn btn-default <?php echo $getPage == 4 ? "active" : "";?>" href="?page=package-page&page-position=4" role="button">ระยะเวลา Auto update</a>
    </div>
    <?php
    echo $classPackage->buildTabPosition($getPage);
    ?>
    <form method="post" id="frm_package">
        <input type="hidden" name="post_package" value="true">
        <input type="hidden" id="package_id" name="package_id" value="0">
        <input type="hidden" id="type_post" name="type_post" value="admin_add">
        <input type="hidden" id="position" name="position" value="<?php echo $getPage; ?>">
        <table class="wp-list-table widefat" cellspacing="0" width="100%">
            <tbody>
            <tr class="alternate">
                <td><label for="p_count">#</label></td>
                <td colspan="3"><input size="50" disabled type="text" id="p_count" name="p_count"/></td>
            </tr>
            <tr class="alternate">
                <td><label for="p_text">Text :</label></td>
                <td colspan="3"><input size="50" type="text" id="p_text" name="p_text" required=""/></td>
            </tr>
            <tr class="alternate">
                <td><label for="p_value">Value :</label></td>
                <td colspan="3"><input size="50" onkeypress="return validateNum(event);"
                type="text" id="p_value" name="p_value" required=""/>
                </td>
            </tr>
            <tr class="alternate">
                <td><label for="p_price">Price :</label></td>
                <td colspan="3"><input size="50" onkeypress="return validateNum(event);"
                type="text" id="p_price" name="p_price" required=""/>
                </td>
            </tr>
            <tr class="alternate">
                <td><label for="p_require">Require :</label></td>
                <td colspan="3">
                    <input type="checkbox" id="p_require" name="p_require"
                    onclick=""/>
                </td>
            </tr>
            <tr class="alternate">
                <td><label for="description">Description :</label></td>
                <td colspan="3">
                            <textarea cols="50" rows="4"
                                      id="description" name="description"></textarea>
                </td>
            </tr>
            <tr class="alternate">
                <td></td>
                <td colspan="3">
                    <a href="javascript:cancelForm();"
                       id="btn_cancel" class="button" style="display: none;">Cancel</a>
                    <input type="submit" class="button-primary" value="Save">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div><?php
}
//------------------------------- End Package--------------------------------//

