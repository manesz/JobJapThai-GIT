<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 31/12/2557
 * Time: 11:09 น.
 */

get_template_part("header");
get_template_part("libs/nav");

global $current_user, $wpdb;
$userID = $current_user->ID;
$classEmployer = new Employer($wpdb);
$classFavorite = new Favorite($wpdb);
$classApply = new Apply($wpdb);
$postID = get_the_id();
$url = wp_get_attachment_url(get_post_thumbnail_id($postID));
if (empty($url)) {
    $thumbnail = get_template_directory_uri() . "/libs/img/blank-logo.png";
} else {
    $thumbnail = $url;
}
$customField = get_post_custom($postID);
$qualification = empty($customField["qualification"][0]) ? '' : $customField["qualification"][0];
$job_type = empty($customField["job_type"][0]) ? '' : $customField["job_type"][0];
$jlpt_level = empty($customField["jlpt_level"][0]) ? '' : $customField["jlpt_level"][0];
$job_location = empty($customField["job_location"][0]) ? '' : $customField["job_location"][0];
$japanese_skill = empty($customField["japanese_skill"][0]) ? '' : $customField["japanese_skill"][0];
$salary = empty($customField["salary"][0]) ? '' : $customField["salary"][0];
$working_day = empty($customField["working_day"][0]) ? '' : $customField["working_day"][0];
$company_id = empty($customField["company_id"][0]) ? '' : $customField["company_id"][0];
$getDataCompany = $company_id ? $classEmployer->getCompanyInfo($company_id) : false;
if ($getDataCompany) {
    extract((array)$getDataCompany[0]);
    $empEmail = $getDataCompany[0]->email;
}
if (is_user_logged_in()) {
    $isJobFavorite = $classFavorite->checkJobIsFavorite($userID, $postID);
    $isJobApply = $classApply->checkJobIsApply($userID, $postID);
    $userType = get_user_meta($userID, 'user_type', true);
} else {
    $isJobFavorite = false;
    $isJobApply = false;
}
$isAdmin = current_user_can('manage_options');
?>
    <section class="container-fluid" style="margin-top: 10px;">

        <div class="container wrapper">
            <div class="row">
                <div class="col-md-8">

                    <div class="clearfix"
                         style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">

                        <img src="<?php echo $thumbnail; ?>"
                             style="width: 100%"/>

                        <h4 class="font-color-3 clearfix" style="">
                            <span class="pull-left"><?php the_title(); ?></span>
                                <span class="pull-right" id="icon_fav" style="<?php
                                if (!$userType == "candidate" || !$isAdmin) {
                                    if (!$isJobFavorite){
                                        echo 'display: none;';
                                    }
                                }
                                ?>">
                                    <i class="glyphicon glyphicon-star font-color-BF2026"></i>
                                </span>
                        </h4>
                        <h5 class="font-color-BF2026 clearfix"
                            style=""><?php echo empty($company_name) ? "" : $company_name; ?>
                            <a href="<?php echo get_site_url(); ?>/company-profile?id=<?php echo $company_id; ?>"
                               target="_blank">(View company profile)</a></h5>
                        <hr/>
                        <?php if (!empty($company_profile_and_business_operation)): ?>
                            <h5><strong>Company Profile</strong></h5>

                            <p>
                                <?php echo empty($company_profile_and_business_operation) ? "" : nl2br($company_profile_and_business_operation); ?>
                            </p>
                        <?php endif; ?>
                        <div class="jumbotron clearfix">
                            <h5><strong>Job Detail</strong></h5>
                            <table style="width: 100%">
                                <tr>
                                    <td style="50%">Date Posted :</td>
                                    <td style="50%"><?php the_date('d F, Y'); ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">Category :</td>
                                    <td style="50%"><?php
                                        $categories = get_the_category();
                                        $separator = ' ';
                                        $output = '';
                                        if ($categories) {
                                            foreach ($categories as $category) {
                                                $output .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $category->name)) . '">' . $category->cat_name . '</a>' . $separator;
                                            }
                                            echo trim($output, $separator);
                                        } ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">Job Type :</td>
                                    <td style="50%"><?php echo $job_type; ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">JLPT LEVEL :</td>
                                    <td style="50%"><?php echo $jlpt_level; ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">JOB LOCATION :</td>
                                    <td style="50%"><?php echo $job_location; ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">JAPANESE SKILLS :</td>
                                    <td style="50%"><?php echo $japanese_skill; ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">Salary :</td>
                                    <td style="50%"><?php echo is_numeric($salary) ? number_format($salary) : $salary; ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">Working Day :</td>
                                    <td style="50%"><?php echo $working_day; ?></td>
                                </tr>
                            </table>
                        </div>

                        <h5><strong>Job Description</strong></h5>

                        <p>
                            <?php the_content(); ?>
                        </p>
                        <?php if ($qualification): ?>
                            <h5 class="margin-top-20"><strong>Qualification</strong></h5>

                            <p><?php echo nl2br($qualification); ?></p>
                        <?php endif; ?>
                        <h5 class="margin-top-20">
                            <strong>Contact</strong></h5>

                        <p>
                            <?php
                            echo empty($company_name) ? "" : $company_name . "<br/>";
                            echo empty($walfare_and_benefit) ? "" : nl2br($walfare_and_benefit) . "<br/>";
                            echo empty($apply_method) ? "" : nl2br($apply_method) . "<br/>";
                            echo empty($address) ? "" : nl2br($address) . "<br/>";
                            echo empty($tel) ? "" : "Tel. $tel<br/>";
                            echo empty($fax) ? "" : "Fax. $fax<br/>";
                            echo empty($empEmail) ? "" : "E-mail. $empEmail<br/>";
                            echo empty($website) ? "" : "Website: <a target='_blank' href='$website'>$website</a><br/>";
                            //E-mail. pattarat@bjc.co.th, kusumad@bjc.co.th-->
                            ?>
                        </p>
                        <?php
                        if (is_user_logged_in()): ?>
                            <div class="col-md-12 margin-top-20">
                                <?php if ($userType == 'candidate' || $isAdmin): ?>
                                    <button type="button" id="applyNow" name="applyNow"
                                            class="btn btn-default no-border col-md-2">
                                        <span class="glyphicon glyphicon-ok"></span>
                                        apply now
                                    </button>
                                    <button type="button" id="addFavorite" name="addFavorite"
                                            class="btn btn-default no-border col-md-2">
                                        <span class="glyphicon glyphicon-star"></span>
                                        add favorite
                                    </button>
                                    <a href="<?php echo get_site_url(); ?>/favorite-job" id="viewAllFavorite"
                                       name="viewAllFavorite"
                                       class="btn btn-default no-border col-md-2">
                                        <span class="glyphicon glyphicon-folder-open"></span>
                                        all favorite
                                    </a>
                                <?php endif; ?>
                                <button type="button" id="map" name="map" class="btn btn-default no-border col-md-2">
                                    <span class="glyphicon glyphicon-map-marker"></span>
                                    map
                                </button>
                                <button type="button" id="print" name="print"
                                        class="btn btn-default no-border col-md-2">
                                    <span class="glyphicon glyphicon-print"></span>
                                    print
                                </button>
                                <button type="button" id="share" name="share"
                                        class="btn btn-default no-border col-md-2">
                                    <span class="glyphicon glyphicon-share"></span>
                                    share
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png"
                         style="width: 100%; height: auto;"/>

                </div>

                <?php get_template_part("libs/pages/sidebar"); ?>
            </div>
        </div>

    </section>
    <script>
        var is_job_favorite = <?php echo $isJobFavorite? "true": "false"; ?>;
        var is_job_apply = <?php echo $isJobApply ? "true": "false"; ?>;
        $(document).ready(function () {
            $("#addFavorite").click(function () {
                if (is_job_favorite) {
                    showModalMessage('<div class="font-color-4BB748"><p>Favorite Success.</p></div>',
                        "Message Job View");
                } else {
                    showImgLoading();
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: '',
                        data: {
                            favorite: 'true',
                            favorite_type: 'job',
                            user_id: <?php echo $userID; ?>,
                            company_id: <?php echo $company_id; ?>,
                            id: <?php echo $postID; ?>,
                            is_favorite: 'true'
                        },
                        success: function (result) {
                            hideImgLoading();
                            showModalMessage(result.msg, "Message Job View");
                            if (!result.error) {
                                is_job_favorite = true;
                                $("#icon_fav").show();
                            }
                        }
                    })
                        .fail(function () {
                            hideImgLoading();
                            showModalMessage('<div class="font-color-BF2026"><p>Sorry Favorite Error.</p></div>',
                                "Message Job View");
                        });
                }
                return false;
            });

            $("#applyNow").click(function () {
                if (is_job_apply) {
                    showModalMessage('<div class="font-color-4BB748"><p>Apply Success.</p></div>',
                        "Message Job View");
                } else {
                    showImgLoading();
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: '',
                        data: {
                            apply_post: 'true',
                            apply_type: 'job',
                            user_id: <?php echo $userID; ?>,
                            id: <?php echo $postID; ?>,
                            company_id: <?php echo $company_id; ?>,
                            is_apply: 'true'
                        },
                        success: function (result) {
                            hideImgLoading();
                            showModalMessage(result.msg, "Message Job View");
                            if (!result.error)
                                is_job_apply = true;
                        }
                    })
                        .fail(function () {
                            hideImgLoading();
                            showModalMessage('<div class="font-color-BF2026"><p>Sorry Apply Error.</p></div>',
                                "Message Job View");
                        });
                }
                return false;
            });
        });
    </script>

<?php get_template_part("footer"); ?>