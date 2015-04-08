<?php

get_template_part("header");
get_template_part("libs/nav");
global $wpdb;
$classQueryPostJob = new QueryPostJob($wpdb);

$titlePage = "News jobs update";

$cat = empty($_GET['cat']) ? false : $_GET['cat'];
$current_cat_id = get_query_var('cat');
if ($cat) {
    $getTerm = get_term_by('slug', $cat, 'custom_job_cat');
    $titlePage = $getTerm->name;
} else if ($current_cat_id) {
    $titlePage = get_cat_name($current_cat_id);
}

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
                            <span class="font-color-BF2026" style=""><?php echo $titlePage; ?></span>
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
                        $argc = $classQueryPostJob->queryJobUpdate($cat, $current_cat_id);
                        echo $classQueryPostJob->buildListJob($argc);
                        ?>
                    </div>

                    <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png"
                         style="width: 100%; height: auto;"/>

                </div>

                <?php get_template_part('libs/pages/sidebar'); ?>
            </div>
        </div>

    </section>
<?php

get_template_part("footer");