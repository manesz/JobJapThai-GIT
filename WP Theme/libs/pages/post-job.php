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
//        $company_id = $getCompanyInfo[0]->com_id;
    }
}
?>
<script>

</script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/libs/css/jasny-bootstrap.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/libs/js/jasny-bootstrap.min.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/libs/js/post-job.js"></script>
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
                    <?php if (is_user_logged_in()) {
                        include_once('emp_menu.php');
                    } ?>
                    <div id="show_message" class="col-md-12">
                    </div>
                    <hr/>
                    <h5 class="bg-ddd padding-10 clearfix">Post Job List</h5>

                    <div class="col-md-12 border-bottom-1-ddd no-padding"
                         style="padding-bottom: 10px !important;">
                        <input type="hidden" id="type_query" value="post_job">
                        <?php
                        echo $classQueryPostJob->buildFormQueryJob($userID);
                        ?>
                    </div>
                    <?php
                    $argc = $classQueryPostJob->queryPostJob($userID);
                    echo $classQueryPostJob->buildListJob($argc, true, true);
                    ?>
                    <h5 id="head_text_edit_job" class="bg-ddd padding-10 clearfix">Add New Post Job</h5>

                    <div id="div_form_job">
                        <?php echo $classEmployer->buildFormPostJob(); ?>
                    </div>
                </div>

                <?php require_once("banner1.php"); ?>

            </div>
        </div>
    </div>

</section>