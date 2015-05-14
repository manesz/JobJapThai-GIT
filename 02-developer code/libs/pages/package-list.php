<?php

global $wpdb;
if (is_user_logged_in()) {
    $classEmployer = new Employer($wpdb);
    $page = empty($_REQUEST['page'])? false: $_REQUEST['page'];
    $employer_page_type = empty($_REQUEST['employer_page_type'])? false: $_REQUEST['employer_page_type'];
    $employer_id = empty($_REQUEST['employer_id'])? false: $_REQUEST['employer_id'];
    if ($page && $employer_page_type && $employer_id) {
        $current_user = $classEmployer->getUser($employer_id);
    } else {
        global $current_user;
    }
    get_currentuserinfo();
    $userID = $current_user->ID;


    $classPackage = new Package($wpdb);
    $arrayPackage = $classPackage->getPackage();
    $arraySelectPackage = $classPackage->getSelectPackage($userID);
} else {
    echo "Please Login";
    exit;
}

?>
<table class="table table-bordered table-hover" border="1">
    <thead>
    <tr>
        <td>No.</td>
        <td>Position/Time</td>
        <td>Hotjob</td>
        <td>Auto Update</td>
        <td>Status</td>
        <td>Edit</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($arraySelectPackage as $key => $value) : ?>
        <tr>
            <td><?php echo $key + 1; ?></td>
            <?php echo $classPackage->buildTdList($arrayPackage, $value->string_package, $value->id, $value->status); ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>