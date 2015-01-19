<?php

//------------------------------- Employer List--------------------------------//

add_action('admin_menu', 'my_add_employer_list_menu_items');
function my_add_employer_list_menu_items()
{
    $hook = add_submenu_page(
        'ics_theme_settings',
        'Employer List',
        'Employer List',
        'manage_options',
        'employer-list',
        'render_employer_list_page_list'
    );
    add_action("load-$hook", 'add_options');

}

function add_options()
{
    global $classEmployer;
    $option = 'per_page';
    $args = array(
        'label' => 'Employer',
        'default' => 10,
        'option' => 'employer_per_page',
    );
    add_screen_option($option, $args);
    $classEmployer = new Employer_List();
}

//add_action('admin_menu', 'my_add_employer_list_menu_items');


function render_employer_list_page_list()
{
    global $classEmployer;
    $siteUrl = home_url();
    $getEditEmployer = empty($_GET['employer_page_type'])? false: $_GET['employer_page_type'];
    if ($getEditEmployer == 'add') {
        $classEmployer->employerAddTemplate();
    }  else if ($getEditEmployer == 'edit') {
        $classEmployer->employerAddTemplate();
    } else {
        echo '</pre><div class="wrap"><h2>Employer List
        <a href="?page=employer-list&employer_page_type=add" class="add-new-h2">Add New</a></h2>';
        $classEmployer->prepare_items();
        ?>

        <form method="post">
            <input type="hidden" name="page" value="render_employer_list_page_list">
        <?php
        //$classEmployer->search_box('Search', 'room_name');
        $classEmployer->display();
        echo '</form></div>';
    }
}
//------------------------------- End Employer List--------------------------------//

