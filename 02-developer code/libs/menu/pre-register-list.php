<?php

//------------------------------- Pre Register List--------------------------------//

add_action('admin_menu', 'my_add_pre_register_list_menu_items');
function my_add_pre_register_list_menu_items()
{
    $hook = add_submenu_page(
        'ics_theme_settings',
        'Pre Register List',
        'Pre Register List',
        'manage_options',
        'pre-register-list',
        'render_pre_register_list_page_list'
    );
    add_action("load-$hook", 'add_pre_register_options');

}

function add_pre_register_options()
{
    global $classCandidateList;
    $option = 'per_page';
    $args = array(
        'label' => 'Seeking for Job',
        'default' => 10,
        'option' => 'pre_register_per_page',
    );
    add_screen_option($option, $args);
}

//add_action('admin_menu', 'my_add_pre_register_list_menu_items');


function render_pre_register_list_page_list()
{
    $classCandidateList = new Pre_Register();
    $pageType = empty($_GET['page_type'])? false: $_GET['page_type'];
    if ($pageType == 'add') {
        $classCandidateList->candidateAddTemplate();
    }  else if ($pageType == 'edit') {
        $classCandidateList->candidateAddTemplate();
    } else {
        echo '</pre><div class="wrap"><h2>Pre Register List</h2>';
        $classCandidateList->prepare_items();
        ?>

        <form method="post">
            <input type="hidden" name="page" value="render_pre_register_list_page_list">
        <?php
        $classCandidateList->search_box('Search', 'name');
        $classCandidateList->display();
        echo '</form></div>';
    }
}
//------------------------------- End Pre Register List--------------------------------//

