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
//    $classEmployerList = new Employer_List();
    $approvePackage = new Approve_Package();
    require_once('header.php');
    ?>
    <link rel="stylesheet" type="text/css"
          href="<?php echo get_template_directory_uri(); ?>/libs/css/bootstrap.min.css"/>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/jquery.1.11.1.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrapValidator.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/employer-register.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/header.js"></script>
    <script>
        var url_post = "<?php echo home_url(); ?>/";
        var str_loading = '<div class="img_loading"><img src="<?php
    bloginfo('template_directory'); ?>/libs/images/loading.gif" width="40"/></div>';
        function setApprove(id){
            showImgLoading();
            $.ajax({
                type: "GET",
                cache: false,
                dataType: 'json',
                url: '',
                data: {
                    approve_package: 'true',
                    package_id: id
                },
                success: function (data) {
                    if (data.error) {
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                    hideImgLoading();
                }
            })
                .fail(function () {
                    hideImgLoading();
                    alert("เกิดข้อผิดพลาด");
                });
            return false;
        }
    </script>
        <div class="wrap"><h2>Approve</h2>
        <?php $approvePackage->prepare_items();
        ?>

        <form method="post">
            <input type="hidden" name="page" value="render_approve_package_page_list">
        <?php
        $approvePackage->search_box('Search', 'company_name');
        $approvePackage->display();
        ?>
        </form></div>

    <!-- Modal -->
    <div class="modal fade" id="modal_package" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true"
         style="font-size: 12px;">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>
<?php

}
//------------------------------- End Approve Package--------------------------------//

