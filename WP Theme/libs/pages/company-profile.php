<?php
$classEmployer = new Employer($wpdb);
$company_id = empty($_REQUEST['id']) ? false : $_REQUEST['id'];
if ($company_id):
    $getDataCompany = $company_id ? $classEmployer->getCompanyInfo($company_id) : false;
    if ($getDataCompany):
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

                            <h4 class="font-color-BF2026 clearfix" style="">
                                <span class="pull-left"><?php echo empty($company_name) ? "" : $company_name; ?></span>
                            <span class="pull-right">
                                <i class="glyphicon glyphicon-star font-color-BF2026"></i>
                                <button class="btn btn-warning" style="background: #BF2026; border: none;">Edit</button>
                            </span>
                            </h4>
                            <hr/>
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 30%">Company Website:</td>
                                    <td style="width: 70%"><?php echo empty($website) ? "" : "<a target='_blank'
                                    href='$website'>$website</a>"; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%">Address:</td>
                                    <td style="width: 70%"><?php echo empty($address) ? "" : $address; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%">Tel:</td>
                                    <td style="width: 70%"><?php echo empty($tel) ? "" : $tel; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%">Fax:</td>
                                    <td style="width: 70%"><?php echo empty($fax) ? "" : $fax; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%">Email:</td>
                                    <td style="width: 70%"><?php echo empty($empEmail) ? "" : $empEmail; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%">Contact:</td>
                                    <td style="width: 70%"><?php echo empty($contact_person) ? "" : $contact_person; ?></td>
                                </tr>
                            </table>
                            <hr/>
                            <h5><strong>Company Profile</strong></h5>

                            <p>
                                <?php echo empty($company_profile_and_business_oparation) ? "" : nl2br($company_profile_and_business_oparation); ?>
                            </p>
                            <hr/>
                            <h5 class="font-color-BF2026">All Job List</h5>

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
                            $argc = array(
                                'post_type' => 'job',
//                                        'category_name' => 'highlight-jobs',
                                //'orderby' => 'date', //name of category by slug
                                //'order' => 'ASC',
                                'post_status' => 'publish',
                                'posts_per_page' => 10,
                                'meta_query' => array(
                                    array(
                                        'key' => 'company_id',
                                        'value' => $company_id,
                                        'compare' => '='
                                    )

                                ),
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
                            <?php endif; ?>
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

                        </div>

                        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png"
                             style="width: 100%; height: auto;"/>

                    </div>

                    <?php get_template_part("libs/pages/sidebar"); ?>
                </div>
            </div>

        </section>
    <?php endif; ?>
<?php endif; ?>
<?php get_template_part("footer"); ?>