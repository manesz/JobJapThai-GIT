<?php

//------------------------------- Employer List--------------------------------//

add_action('admin_menu', 'my_add_employer_list_menu_items');
function my_add_employer_list_menu_items()
{
    $hook = add_submenu_page(
        'ics_theme_settings',
        'Seeking for Manpower List',
        'Seeking for Manpower List',
        'manage_options',
        'employer-list',
        'render_employer_list_page_list'
    );
    add_action("load-$hook", 'add_employer_options');

}

function add_employer_options()
{
    $option = 'per_page';
    $args = array(
        'label' => 'Seeking for Manpower',
        'default' => 10,
        'option' => 'employer_per_page',
    );
    add_screen_option($option, $args);
}

//add_action('admin_menu', 'my_add_employer_list_menu_items');


function render_employer_list_page_list()
{
    $classEmployerList = new Employer_List();
    $siteUrl = home_url();
    $getEditEmployer = empty($_GET['employer_page_type'])? false: $_GET['employer_page_type'];
    if ($getEditEmployer == 'add') {
        $classEmployerList->employerAddTemplate();
    } else if ($getEditEmployer == 'edit') {
        $classEmployerList->employerAddTemplate();
    } else {
        echo '</pre><div class="wrap"><h2>Seeking for Manpower List
        <a href="?page=employer-list&employer_page_type=add" class="add-new-h2">Add New</a></h2>';
        $classEmployerList->prepare_items();
        ?>

        <form method="post">
            <input type="hidden" name="page" value="render_employer_list_page_list">
        <?php
        $classEmployerList->search_box('Search', 'company_name');
        $classEmployerList->display();
        echo '</form></div>';
    }
}
//------------------------------- End Employer List--------------------------------//

