<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 4/1/2558
 * Time: 20:41 น.
 */
global $wpdb;
$classQueryPostJob = new QueryPostJob($wpdb);

?>

<section class="container-fluid" style="margin-top: 10px;">

    <div class="container wrapper">
        <div class="row">

            <div class="col-md-8">
                <div class="clearfix"
                     style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                    <h5 class="pull-left" style="">
                        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png"
                             style="height: 25px;"/>
                        お知らせ
                        <span class="font-color-BF2026" style="">Highlight jobs</span>
                    </h5>

                    <div class="clearfix" style="margin-top: 20px;"></div>
                    <div id="show_message" class="col-md-12">
                    </div>
                    <hr/>
                    <div class="col-md-12 border-bottom-1-ddd no-padding"
                         style="padding-bottom: 10px !important;">
                        <input type="hidden" id="type_query" value="favorite">
                        <?php
                        echo $classQueryPostJob->buildFormQueryJob(0);
                        ?>
                    </div>
                    <?php
                    $argc = $classQueryPostJob->queryHighlightJobs();
                    echo $classQueryPostJob->buildListJob($argc);
                    ?>
                </div>

                <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png"
                     style="width: 100%; height: auto;"/>

            </div>

            <?php include_once("sidebar.php"); ?>
        </div>
    </div>

</section>