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
                        <span class="font-color-BF2026" style="">Applied Job</span>
                    </h5>

                    <div class="clearfix" style="margin-top: 20px;"></div>
                    <div id="show_message" class="col-md-12">
                    </div>
                    <hr/>
                    <h5 class="font-color-BF2026">Applied Job List</h5>

                    <div class="col-md-12 border-bottom-1-ddd no-padding"
                         style="padding-bottom: 10px !important;">
                        <form>
                            <div class="col-md-3 no-padding">
                                <span class="pull-left">Positions</span>
                                <select id="searchList" class="pull-left form-control">
                                    <option>10</option>
                                    <option>50</option>
                                    <option>100</option>
                                    <option>All</option>
                                </select>
                            </div>
                            <div class="col-md-push-6 col-md-3 no-padding">
                                <span class="pull-right">Sort by</span><br/>
                                <select id="searchSort" class="pull-right form-control col-md-3">
                                    <option>Last Update</option>
                                    <option>Company Name</option>
                                    <option>Less to more competitive jobs</option>
                                    <option>More to less competitive jobs</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <?php
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $argc = array(
                        'post_type' => 'job',
//                                        'category_name' => 'highlight-jobs',
                        //'orderby' => 'date', //name of category by slug
                        //'order' => 'ASC',
                        'post_status' => 'publish',
                        'posts_per_page' => 1,
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