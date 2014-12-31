<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 31/12/2557
 * Time: 11:09 น.
 */

get_template_part("header");
get_template_part("libs/nav");

$classEmployer = new Employer($wpdb);
$postID = get_the_id();
$url = wp_get_attachment_url(get_post_thumbnail_id($postID));
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
?>
    <section class="container-fluid" style="margin-top: 10px;">

        <div class="container wrapper">
            <div class="row">
                <div class="col-md-8">

                    <div class="clearfix"
                         style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">

                        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/job-desc-01.jpg"
                             style="width: 100%"/>

                        <h4 class="font-color-3 clearfix" style="">
                            <span class="pull-left"><?php the_title(); ?></span>
                            <span class="pull-right"><i class="glyphicon glyphicon-star font-color-BF2026"></i></span>
                        </h4>
                        <h5 class="font-color-BF2026 clearfix"
                            style=""><?php echo empty($company_name) ? "" : $company_name; ?>
                            <a href="<?php echo get_site_url();?>/company-profile?id=<?php echo $company_id; ?>" target="_blank">(View company profile)</a></h5>
                        <hr/>
                        <h5><strong>Company Profile</strong></h5>

                        <p>
                            <?php echo empty($company_profile_and_business_oparation) ? "" : nl2br($company_profile_and_business_oparation); ?>
                        </p>

                        <div class="jumbotron clearfix">
                            <h5><strong>Job Detail</strong></h5>
                            <table style="width: 100%">
                                <tr>
                                    <td style="50%">Date Posted :</td>
                                    <td style="50%"><?php the_date('d F, Y'); ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">Category :</td>
                                    <td style="50%"><?php $categories = get_the_category();
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
                                    <td style="50%"><?php echo $salary; ?></td>
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
                        <h5 class="margin-top-20"><strong>Qualification</strong></h5>

                        <p><?php echo nl2br($qualification); ?></p>
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

                        <div class="col-md-12 margin-top-20">
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
                            <button type="button" id="viewAllFavorite" name="viewAllFavorite"
                                    class="btn btn-default no-border col-md-2">
                                <span class="glyphicon glyphicon-folder-open"></span>
                                all favorite
                            </button>
                            <button type="button" id="map" name="map" class="btn btn-default no-border col-md-2">
                                <span class="glyphicon glyphicon-map-marker"></span>
                                map
                            </button>
                            <button type="button" id="print" name="print" class="btn btn-default no-border col-md-2">
                                <span class="glyphicon glyphicon-print"></span>
                                print
                            </button>
                            <button type="button" id="share" name="share" class="btn btn-default no-border col-md-2">
                                <span class="glyphicon glyphicon-share"></span>
                                share
                            </button>
                        </div>

                    </div>

                    <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png"
                         style="width: 100%; height: auto;"/>

                </div>

                <?php get_template_part("libs/pages/sidebar"); ?>
            </div>
        </div>

    </section>

<?php get_template_part("footer"); ?>