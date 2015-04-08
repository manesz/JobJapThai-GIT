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
    $classEmployerList = new Employer_List();
    require_once('header.php');
    $siteUrl = home_url();
    $getEditEmployer = empty($_GET['employer_page_type'])? false: $_GET['employer_page_type'];
    if ($getEditEmployer == 'add') {
        $classEmployerList->employerAddTemplate();
    }  else if ($getEditEmployer == 'edit') {
        $classEmployerList->employerAddTemplate();
    } else {?>
        <div class="wrap"><h2>Approve</h2>
        <?php $classEmployerList->prepare_items();
        ?>

        <form method="post">
            <input type="hidden" name="page" value="render_approve_package_page_list">
        <?php
        $classEmployerList->search_box('Search', 'company_name');
        $classEmployerList->display();
        echo '</form></div>';
    }
}
//------------------------------- End Approve Package--------------------------------//

