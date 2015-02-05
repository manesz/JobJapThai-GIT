<?php

if (is_user_logged_in()) {
    global $current_user, $wpdb;
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
        <td>Super Hotjob</td>
        <td>Hotjob/Time</td>
        <td>Urgent</td>
        <td>Status</td>
        <td>Edit</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($arraySelectPackage as $key => $value) : ?>
        <tr>
            <td><?php echo $key + 1; ?></td>
            <?php echo $classPackage->buildTdList($arrayPackage, $value->string_package, $value->id); ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>