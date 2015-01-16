<?php
get_template_part('header');
get_template_part("libs/nav");
get_template_part("libs/front-banner");


$classQueryPostJob = new QueryPostJob($wpdb);
?>
<section class="container-fluid" style="margin-top: 10px;">

        <div class="container wrapper">
            <div class="row">
                <div class="col-md-8">

                    <div class="clearfix" style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                        <h5 class="pull-left" style="">
                            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png" style="height: 25px;"/>
                            お知らせ
                            <span class="font-color-BF2026" style="" >Search Job Result</span>
                        </h5>
                        <div class="col-md-12 border-bottom-1-ddd padding-bottom-10 margin-bottom-10">
                            <input type="hidden" id="type_query" value="search">
                            <?php echo $classQueryPostJob->buildFormQueryJob(0, true); ?>
                        </div>
                        <div class="clearfix" style="margin-top: 20px;"></div>

                        <?php
                        $argc = $classQueryPostJob->querySearchJob();
                        echo $classQueryPostJob->buildListJob($argc);
                        ?>

                    </div>

                    <?php get_template_part("libs/pages/banner2"); ?>

                </div>
                <?php get_template_part('libs/pages/sidebar'); ?>
            </div>
        </div>

    </section>
<?php get_template_part('footer');?>