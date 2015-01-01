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
//        $resumeCode = str_pad($userID, 7, '0', STR_PAD_LEFT);
//        $lastLogin = get_user_meta($userID, 'last_login', true);
//        $lastLogin = date_i18n('d M y', strtotime($lastLogin));
//        $lastUpdate = the_modified_author();
//        $lastUpdate = date_i18n('d M y', strtotime($lastUpdate));
//        $memberSince = $current_user->user_registered;
//        $memberSince = date_i18n('d M y', strtotime($memberSince));
//        $date_format = get_option('date_format') . ' ' . get_option('time_format');
//        $the_last_login = mysql2date($date_format, $lastLogin, false);
//        echo $the_last_login;

        $classCandidate = new Candidate($wpdb);
        $classEmployer = new Employer($wpdb);
//        $objInformation = $classCandidate->getInformation($userID);
//        if ($objInformation)
//            extract((array)$objInformation[0]);
//
//        $objCareerProfile = $classCandidate->getCareerProfile($userID);
//        if ($objCareerProfile)
//            extract((array)$objCareerProfile[0]);
//
//        $objDesiredJob = $classCandidate->getDesiredJob($userID);
//        if ($objDesiredJob)
//            extract((array)$objDesiredJob[0]);
//
//        $objSkillLanguage = $classCandidate->getSkillLanguages($userID);
//        if ($objSkillLanguage)
//            extract((array)$objSkillLanguage[0]);
    }
} else {
    $isLogin = false;
    $userID = 0;
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
                        <?php include_once('candidate-menu.php'); ?>
                    </div>
                <?php } ?>
                <div class="clearfix"
                     style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                    <h5 class="pull-left" style="">
                        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png"
                             style="height: 25px;"/>
                        お知らせ
                        <span class="font-color-BF2026" style="">Favorite Job</span>
                    </h5>

                    <div class="clearfix" style="margin-top: 20px;"></div>
                    <div id="show_message" class="col-md-12">
                    </div>
                    <hr/>
                    <h5 class="font-color-BF2026">Favorite Job List</h5>

                    <div class="col-md-12 border-bottom-1-ddd no-padding"
                         style="padding-bottom: 10px !important;">
                        <?php
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $posts_per_page = empty($_GET['posts_per_page']) ? 10 : $_GET['posts_per_page'];
                        $orderby = empty($_GET['orderby']) ? 10 : $_GET['orderby'];
                        ?>
                        <form method="get" id="frm_query">
                            <input type="hidden" name="paged" value="<?php echo $paged; ?>">

                            <div class="col-md-3 no-padding">
                                <span class="pull-left">Positions</span>
                                <select name="posts_per_page"
                                        onchange="$('#frm_query').submit();"
                                        class="pull-left form-control">
                                    <option value="10" <?php echo $posts_per_page == '10' ? 'selected' : ''; ?>>10</option>
                                    <option value="50" <?php echo $posts_per_page == '50' ? 'selected' : ''; ?>>50</option>
                                    <option value="100" <?php echo $posts_per_page == '100' ? 'selected' : ''; ?>>100</option>
                                    <option value="-1" <?php echo $posts_per_page == '-1' ? 'selected' : ''; ?>>All</option>
                                </select>
                            </div>
                            <div class="col-md-push-6 col-md-3 no-padding">
                                <span class="pull-right">Sort by</span><br/>
                                <select name="orderby"
                                        onchange="$('#frm_query').submit();"
                                        class="pull-right form-control col-md-3">
                                    <option value="modified" <?php echo $orderby == 'modified' ? 'selected' : ''; ?>>Last Update</option>
                                    <option value="company" <?php echo $orderby == 'company' ? 'selected' : ''; ?>>Company Name</option>
                                    <option value="" <?php echo $orderby == '' ? 'selected' : ''; ?>>Less to more competitive jobs</option>
                                    <option value="" <?php echo $orderby == '' ? 'selected' : ''; ?>>More to less competitive jobs</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <?php
                    $argc = array(
                        'post_type' => 'job',
//                                        'category_name' => 'highlight-jobs',
                        //'orderby' => 'date', //name of category by slug
                        //'order' => 'DESC',
                        'post_status' => 'publish',
                        'posts_per_page' => $posts_per_page,
                        'paged' => $paged
            //        'meta_query' => array(
            //            array(
            //                'key' => 'company_id',
            //                'value' => $company_id,
            //                'compare' => '='
            //            )
            //
            //        ),
                    );
                    $loopJobs = new WP_Query($argc);
                    if ($loopJobs->have_posts()):
                        ?>
                        <ul class="job-list no-padding">
                            <?php while ($loopJobs->have_posts()) :
                                $loopJobs->the_post();
                                $postID = get_the_id();
                                $url = wp_get_attachment_url(get_post_thumbnail_id($postID));
                                if (empty($url)) {
                                    $thumbnail = get_template_directory_uri() . "/libs/img/blank-logo.png";
                                } else {
                                    $thumbnail = $url;
                                }
                                $customField = get_post_custom($postID);
                                $job_type = empty($customField["job_type"][0]) ? '' : $customField["job_type"][0];
                                $job_location = empty($customField["job_location"][0]) ? '' : $customField["job_location"][0];
                                $company_id = empty($customField["company_id"][0]) ? '' : $customField["company_id"][0];
                                $getDataCompany = $company_id ? $classEmployer->getCompanyInfo($company_id) : false;
                                $company_name = $getDataCompany ? $getDataCompany[0]->company_name : "";
                                ?>
                                <li class="clearfix border-bottom-1-ddd padding-top-10 padding-bottom-10">
                                    <div class="col-md-12">
                                        <div class="col-md-2" style="padding: 0px">
                                            <a href="<?php the_permalink(); ?>" target="_blank"><img
                                                    src="<?php echo $thumbnail; ?>"
                                                    style="width: 100%;"/></a>
                                        </div>
                                        <div class="col-md-8">
                                            <h5 class="font-color-BF2026">
                                                <a href="<?php the_permalink(); ?>"
                                                   target="_blank"><?php the_title(); ?></a>
                                            </h5>
                                            <?php echo empty($company_name) ? "" : $company_name; ?><br/>
                                            <?php echo empty($job_type) ? "" : $job_type; ?><br/>
                                        </div>
                                        <div class="col-md-2">
                                            <br/><?php the_date('M d, Y'); ?><br/>
                                            <?php echo empty($job_location) ? "" : $job_location; ?><br/>
                                        </div>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                        <hr/>

                    <?php endif; ?>
                    <?php
                    if ($loopJobs->max_num_pages > 1) {
                        ?>
                        <p class="navrechts">
                            <?php
                            for ($i = 1; $i <= $loopJobs->max_num_pages; $i++) {
                                ?>
                                <a href="<?php echo '?paged=' . $i; ?>" <?php echo ($paged == $i) ? 'class="selected"' : ''; ?>><?php echo $i; ?></a>
                            <?php
                            }
                            if ($paged != $loopJobs->max_num_pages) {
                                ?>
                                <a href="<?php echo '?paged=' . $i; //next link ?>">></a>
                            <?php } ?>
                        </p>
                    <?php } ?>
                </div>

                <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png"
                     style="width: 100%; height: auto;"/>

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