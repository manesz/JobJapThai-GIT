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
        $classPackage = new Package($wpdb);
//        $getCompanyInfo = $classEmployer->getCompanyInfo(0, $userID);
//        $employer_id = $getCompanyInfo[0]->com_id;
    }
}
if (!$isLogin) {
    wp_redirect(home_url());
    exit;
}

//echo $classPackage->getTotalPost($userID);
//echo "<br>";

//echo $classPackage->getTotalHotJob($userID);
//var_dump($classPackage->checkDisplayJob("2015-03-10 22:00:00", 6));
//echo $classPackage->addApplyHotJob($userID, 0);


?>
<script>

</script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/libs/css/jasny-bootstrap.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/libs/js/jasny-bootstrap.min.js"></script>


<!--        <link rel="stylesheet" type="text/css"-->
<!--              href="--><?php //echo get_template_directory_uri(); ?><!--/libs/js/libs/bootstrap-wysihtml5/css/bootstrap.min.css"></link>-->
<link rel="stylesheet" type="text/css"
      href="<?php echo get_template_directory_uri(); ?>/libs/js/libs/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css"></link>
<script>
    var wysiwyg_color = "<?php echo get_template_directory_uri(); ?>/libs/js/libs/bootstrap-wysihtml5/css/wysiwyg-color.css";
    var user_id = <?php echo $userID; ?>;
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
                    <?php if (is_user_logged_in()) {
                        include_once('emp_menu.php');
                    } ?>
                    <?php $classEmployer->buildPostJob($userID); ?>
                </div>

                <?php require_once("banner1.php"); ?>

            </div>
        </div>
    </div>

</section>