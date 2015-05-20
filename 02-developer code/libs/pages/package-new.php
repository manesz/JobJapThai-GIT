<?php
if (is_user_logged_in()) {
    global $current_user;
    get_currentuserinfo();
    $packageID = empty($_GET['package_id']) ? 0 : $_GET['package_id'];
    $employerID = empty($_GET['user_id']) ? 0 : $_GET['user_id'];
    if (!$employerID) {
        $employerID = $current_user->ID;
    }
    $classPackage = new Package($wpdb);
    $arrayPackage = $classPackage->getPackage();
    $arraySelectPackage = $packageID ? $classPackage->getSelectPackage($employerID, $packageID) : null;
    $strSelectPackage = $packageID ? $arraySelectPackage[0]->string_package : '';
    $isApprove = $packageID ? $arraySelectPackage[0]->status : '';
} else {
    echo "Please Login";
    exit;
}
?>
    <div class="modal-body">
        <?php
        echo $classPackage->buildHtmlFormNewPackage($packageID, $employerID);
        ?>
    </div>
    <div class="modal-footer">
        <?php //if ($employerID && $isApprove == 'edit'): ?>
        <?php //endif; ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?php if ($isApprove != 'approve'): ?>
            <button type="button" class="btn btn-primary" onclick="$('#frm_package').submit();">Save changes</button>
        <?php endif; ?>
    </div>

<?php
echo $classPackage->buildJavaFormNewPackage($packageID, $employerID);
?>