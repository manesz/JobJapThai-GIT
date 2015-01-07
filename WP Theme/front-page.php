<?php
get_template_part("header");
get_template_part("libs/nav");
get_template_part("libs/front-banner");

global $wpdb;
$classEmployer = new Employer($wpdb);
$classQueryPostJob = new QueryPostJob($wpdb);
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

            <div class="pull-right" style="font-size: 12px; margin-top: 15px;">
                <a href="<?php echo get_site_url(); ?>/highlight-jobs" target="_blank">一覧を見る ></a></div>
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
                        echo $classQueryPostJob->buildHighlightJobs();
                        ?>
                    </div>
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

            <div class="pull-right" style="font-size: 12px; margin-top: 15px;">
                <a href="<?php echo get_site_url(); ?>/job" target="_blank">一覧を見る ></a></div>
            <div class="clearfix"></div>

            <?php
            $argc = $classQueryPostJob->queryJobUpdate(false, false, 10);
            echo $classQueryPostJob->buildListJob($argc, false);
            ?>

        </div>

        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png"
             style="width: 100%; height: auto; margin-top: 10px;"/>
    </div>

    <?php include_once('libs/sidebar.php'); ?>

    </div>
    </div>

    </section><!-- END : section.container-fluid -->
<?php include_once('footer.php'); ?>