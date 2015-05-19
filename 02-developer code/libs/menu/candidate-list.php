<?php

//------------------------------- Candidate List--------------------------------//

add_action('admin_menu', 'my_add_candidate_list_menu_items');
function my_add_candidate_list_menu_items()
{
    $hook = add_submenu_page(
        'ics_theme_settings',
        'Seeking for Job List',
        'Seeking for Job List',
        'manage_options',
        'candidate-list',
        'render_candidate_list_page_list'
    );
    add_action("load-$hook", 'add_candidate_options');

}

function add_candidate_options()
{
    global $classCandidateList;
    $option = 'per_page';
    $args = array(
        'label' => 'Seeking for Job',
        'default' => 10,
        'option' => 'candidate_per_page',
    );
    add_screen_option($option, $args);
}

//add_action('admin_menu', 'my_add_candidate_list_menu_items');


function render_candidate_list_page_list()
{
//    global $classCandidateList;
    $classCandidateList = new Candidate_List();
    $siteUrl = home_url();
    $getEditCandidate = empty($_GET['candidate_page_type'])? false: $_GET['candidate_page_type'];
    if ($getEditCandidate == 'add') {
        $classCandidateList->candidateAddTemplate();
    }  else if ($getEditCandidate == 'edit') {
        $classCandidateList->candidateAddTemplate();
    } else {
        echo '</pre><div class="wrap"><h2>Seeking for Job List
        <a href="?page=candidate-list&candidate_page_type=add" class="add-new-h2">Add New</a></h2>';
        $classCandidateList->prepare_items();
        ?>

        <form method="post">
            <input type="hidden" name="page" value="render_candidate_list_page_list">
        <?php
        $classCandidateList->search_box('Search', 'name');
        $classCandidateList->display();
        echo '</form></div>';
    }
}
//------------------------------- End Candidate List--------------------------------//

