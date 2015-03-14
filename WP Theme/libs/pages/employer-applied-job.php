<?php
if (is_user_logged_in()) {
    global $current_user, $wpdb;
    $userID = $current_user->ID;
    $userType = get_user_meta($userID, 'user_type', true);
    if ($userType == "employer") {
        $isLogin = false;
        $userID = 0;
    } else {
        $isLogin = true;

        $classCandidate = new Candidate($wpdb);
        $classEmployer = new Employer($wpdb);
        $classQueryPostJob = new QueryPostJob($wpdb);
    }
} else {
    $isLogin = false;
    $userID = 0;
}

if (!$isLogin) {
    wp_redirect(home_url());
    exit;
}
?>
<script>
    var site_url = '<?php echo get_site_url(); ?>/';
    var is_login = <?php echo $isLogin ? 'true': 'false'; ?>;
</script>
<section class="container-fluid" style="margin-top: 10px;">

    <div class="container wrapper">
        <div class="row">

            <div class="col-md-8">
                <?php if ($isLogin) { ?>
                    <div id="sectProfile" class="col-md-12">
                        <?php echo $classCandidate->candidateMenu(); ?>
                    </div>
                <?php } ?>
                <div class="clearfix"
                     style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                    <h5 class="pull-left" style="">
                        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png"
                             style="height: 25px;"/>
                        お知らせ
                        <span class="font-color-BF2026" style="">Applied Job</span>
                    </h5>

                    <div class="clearfix" style="margin-top: 20px;"></div>
                    <div id="show_message" class="col-md-12">
                    </div>
                    <hr/>
                    <h5 class="font-color-BF2026">Applied Job List</h5>

                    <div class="col-md-12 border-bottom-1-ddd no-padding"
                         style="padding-bottom: 10px !important;">
                        <input type="hidden" id="type_query" value="apply">
                        <?php
                        echo $classQueryPostJob->buildFormQueryJob($userID);
                        ?>
                    </div>
                    <?php
                        $argc = $classQueryPostJob->queryApplyJob($userID);
                        echo $classQueryPostJob->buildListJob($argc);
                    ?>
                </div>

                <?php require_once("banner1.php"); ?>

            </div>

            <?php include_once("sidebar.php"); ?>
        </div>
    </div>

</section>

<style type="text/css">
    #sectProfile {
        padding-top: 10px
    }
</style>
<script>

    function toggleChevron(e) {
        $(e.target)
            .prev('.panel-heading')
            .find("i.indicator")
            .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
    }
    //    $('.in').collapse({hide: true});
    // in cadidate register page
</script>