<?php

global $wpdb;
if (is_user_logged_in()) {
    $classEmployer = new Employer($wpdb);
    $employer_id = empty($_REQUEST['employer_id'])? false: $_REQUEST['employer_id'];
    if ($employer_id) {
//        $current_user = $classEmployer->getUser($employer_id);
        $userID = $employer_id;
    } else {
        global $current_user;
        get_currentuserinfo();
        $userID = $current_user->ID;
    }

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
        <td>Create Time</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($arraySelectPackage as $key => $value) : ?>
        <tr>
            <td id="package_no<?php echo $value->id; ?>"><?php echo str_pad($value->id, 5, '0', STR_PAD_LEFT); ?></td>
            <?php echo $classPackage->buildTdList($arrayPackage, $value->string_package, $value->id, $value->status); ?>
            <td><?php echo $value->create_datetime; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>