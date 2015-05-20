<?php

//------------------------------- Approve Package--------------------------------//

add_action('admin_menu', 'my_add_approve_package_menu_items');
function my_add_approve_package_menu_items()
{
    $hook = add_submenu_page(
        'ics_theme_settings',
        'Approve Package',
        'Approve Package',
        'manage_options',
        'approve-package',
        'render_approve_package_page_list'
    );
    add_action("load-$hook", 'add_approve_package_options');

}

function add_approve_package_options()
{
    $option = 'per_page';
    $args = array(
        'label' => 'Approve Package',
        'default' => 10,
        'option' => 'employer_per_page',
    );
    add_screen_option($option, $args);
}

//add_action('admin_menu', 'my_add_approve_package_menu_items');


function render_approve_package_page_list()
{
    global $wpdb;
    $approvePackage = new Approve_Package();
    $pageApprove = empty($_REQUEST['page_approve']) ? false : true;
    require_once('header.php');

if ($pageApprove) {
    $approvePackage->approvePackageTemplate();
} else {
    ?>
    <style type="text/css">
        .blockDiv {
            position: absolute;
            top: 0px;
            left: 0px;
            background-color: #FFF;
            width: 0px;
            height: 0px;
            z-index: 9998;
        }

        .img_loading {
            position: fixed;
            top: 40%;
            left: 50%;
            z-index: 99999 !important;
        }
    </style>
<link rel="stylesheet" type="text/css"
      href="<?php echo get_template_directory_uri(); ?>/libs/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/libs/css/style.css"/>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/jquery.1.11.1.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrapValidator.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/employer-register.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/header.js"></script>
    <script>
        var user_id = 0;
        var url_post = "<?php echo home_url(); ?>/";
        var str_loading = '<div class="img_loading"><img src="<?php
    bloginfo('template_directory'); ?>/libs/images/loading.gif" width="40"/></div>';

        function deleteSelectPackage(id){
            if (!confirm("คุณต้องการลบ Package: " + id + " ใช่ หรือไม่") || check_post_data){
                return false;
            }
            showImgLoading();
            $.ajax({
                type: "POST",
                cache: false,
                dataType: 'json',
                url: '',
                data: {
                    post_package: 'true',
                    type_post: 'delete_select_package',
                    package_id: id
                },
                success: function (data) {
                    hideImgLoading();
                    alert(data.msg);
                    if (!data.error) {
                        window.location.reload();
                    }
                }
            })
                .fail(function () {
                    hideImgLoading();
                    alert("เกิดข้อผิดพลาด");
                });
            return false;
        }
    </script>
    <div class="wrap"><h2>Approve Package</h2>
        <?php $approvePackage->prepare_items();
        ?>

        <form method="post">
            <input type="hidden" name="page" value="render_approve_package_page_list">
            <?php
            $approvePackage->search_box('Search', 'company_name');
            $approvePackage->display();
            ?>
        </form>
        <?php
        }
        ?>
    </div><?php

}
//------------------------------- End Approve Package--------------------------------//

