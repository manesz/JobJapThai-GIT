<?php

$isLogin = false;
$userID = 0;
if (is_user_logged_in()) {
    global $current_user, $wpdb;
    $userID = $current_user->ID;
    $userType = get_user_meta($userID, 'user_type', true);
    if ($userType == "employer") {
        $isLogin = true;
        $classEmployer = new Employer($wpdb);
        $classQueryPostJob = new QueryPostJob($wpdb);
//        $getCompanyInfo = $classEmployer->getCompanyInfo(0, $userID);
//        $employer_id = $getCompanyInfo[0]->com_id;
    }
}
if (!$isLogin) {
    wp_redirect(home_url());
    exit;
}
?>
<script>

</script>
<section class="container-fluid" style="margin-top: 10px;">

    <div class="container wrapper">
        <div class="row">
            <div class="col-md-12">

                <div class="clearfix"
                     style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                    <h5 class="pull-left" style="">
                        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png"
                             style="height: 25px;"/>
                        お知らせ
                        <span class="font-color-BF2026" style=""><?php the_title() ?></span>
                    </h5>

                    <div class="clearfix" style="margin-top: 20px;"></div>
                    <?php if ($isLogin) {
                        include_once('emp_menu.php');
                    } ?>
                    <hr/>
                    <h5 class="bg-ddd padding-10 clearfix">Apply Job List</h5>
                    <?php
                    echo $classEmployer->buildHtmlApplyJob($userID);
                    ?>
                </div>

                <?php require_once("banner1.php"); ?>

            </div>
        </div>
    </div>

</section>