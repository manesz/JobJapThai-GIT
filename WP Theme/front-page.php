<?php
include_once('header.php');
include_once('libs/nav.php');
include_once('libs/front-banner.php');


$classEmployer = new Employer($wpdb);
?>
    <section class="container-fluid" style="margin-top: 10px;">

    <div class="container wrapper">
    <div class="row">
    <div class="col-md-8">
        <div class="clearfix"
             style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">

            <h4 class="pull-left" style="font-size: 16px !important;">
                <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png"
                     style="height: 25px;"/>
                お知らせ
                <span style="font-size: 16px !important; color: #BF2026; ">Highlight jobs</span>
            </h4>

            <div class="pull-right" style="font-size: 12px; margin-top: 15px;"><a>一覧を見る ></a></div>
            <div class="clearfix"></div>

            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">

                        <?php
                        $argc = array(
                            'post_type' => 'job',
//                                        'category_name' => 'highlight-jobs',
                            //'orderby' => 'date', //name of category by slug
                            //'order' => 'ASC',
                            'post_status' => 'publish',
                            'posts_per_page' => 10
                        );
                        $loopHighlightJobs = new WP_Query($argc);
                        $i = 0;
                        if ($loopHighlightJobs->have_posts()):
                        ?>

                        <ul class="job-list" style="padding: 0px;">
                            <?php while ($loopHighlightJobs->have_posts()) :
                                $loopHighlightJobs->the_post();
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
                                ?>
                                <?php if ($i % 4 == 0 && $i > 0): ?>
                                <div class="item">
                                <ul class="job-list" style="padding: 0px;">
                            <?php else: ?>
                                <li class="col-md-6 clearfix">
                                    <div class="col-md-4" style="padding: 0px;">
                                        <a href="<?php the_permalink(); ?>" target="_blank"><img
                                                src="<?php echo $thumbnail; ?>"
                                                style="width: 100%"/></a>
                                    </div>
                                    <div class="col-md-8" style="padding: 0 0 0 10px;">
                                        <h4 style="font-size: 14px !important; color: #BF2026"><a
                                                href="<?php the_permalink(); ?>"
                                                target="_blank"><?php the_title(); ?></a></h4>

                                        <p class="font-size-12">
                                            <span class="font-color-4D94CC"><?php echo $job_location; ?></span><br/>
                                            <?php echo $job_type; ?><br/>
                                            <?php the_date('d F, Y'); ?>
                                        </p>
                                    </div>
                                </li>
                            <?php endif; ?>

                                <?php if ($i % 4 == 0 && $i > 0): ?>
                                </ul>
                                </div>
                            <?php endif; ?>

                                <?php $i++;
                            endwhile;?>

                        </ul>
                    </div>
                    <?php
                    endif;
                    ?>
                </div>

                <!-- Controls -->
                <!--                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">-->
                <!--                            <span class="glyphicon glyphicon-chevron-left"></span>-->
                <!--                        </a>-->
                <!--                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">-->
                <!--                            <span class="glyphicon glyphicon-chevron-right"></span>-->
                <!--                        </a>-->
            </div>

        </div>

        <div class="clearfix"
             style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px;">
            <h4 class="pull-left" style="font-size: 16px !important;">
                <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png"
                     style="height: 25px;"/>
                メリット
                <span style="font-size: 16px !important; color: #BF2026; ">News jobs update</span>
            </h4>

            <div class="pull-right" style="font-size: 12px; margin-top: 15px;"><a>一覧を見る ></a></div>
            <div class="clearfix"></div>

            <ul class="job-list no-padding">
                <?php
                $argc = array(
                    'post_type' => 'job',
//                                'category_name' => 'highlight-jobs',
                    'orderby' => 'date', //name of category by slug
                    'order' => 'DESC',
                    'post_status' => 'publish',
                    'posts_per_page' => 10
                );
                $loopJobsUpdate = new WP_Query($argc);
                $i = 0;
                if ($loopJobsUpdate->have_posts()):
                    while ($loopJobsUpdate->have_posts()) :
                        $loopJobsUpdate->the_post();
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
                                        <a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a>
                                    </h5>
                                    <?php echo $company_name; ?><br/>
                                    <?php echo $job_type; ?><br/>
                                </div>
                                <div class="col-md-2">
                                    <br/><?php the_date('M d, Y'); ?><br/>
                                    <?php echo $job_location; ?><br/>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; endif; ?>
            </ul>

        </div>

        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png"
             style="width: 100%; height: auto; margin-top: 10px;"/>
    </div>

    <?php include_once('libs/sidebar.php'); ?>

    </div>
    </div>

    </section><!-- END : section.container-fluid -->
<?php include_once('footer.php'); ?>