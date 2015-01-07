<?php

global $wpdb;
$objClassContact = new Contact($wpdb);
$classQueryPostJob = new QueryPostJob($wpdb);
$arrayContact = $objClassContact->getContact(1);
if ($arrayContact) {
    extract((array)$arrayContact[0]);
}

?>
<footer>
    <div class="container-fluid clearfix" style="background: #fff; padding-top: 20px; margin-top: 10px; ">
        <div class="col-md-3">
            <?php if (has_nav_menu('jobseeker')) {
                $primenu = wp_nav_menu(array('theme_location' => 'jobseeker', 'echo' => TRUE, 'container' => '', 'items_wrap' => '<ul class="clearfix" style="list-style: none; margin-bottom: 20px; border: none;"><li><span style="color: #BF2026">Job Seeker</span></li>%3$s</ul>'));
                echo $primenu;
                unset($primenu);
            } else {
                ?>
                <ul class="clearfix" style="list-style: none; margin-bottom: 20px; border: none;">
                    <li><span style="color: #BF2026">Job Seeker</span></li>

                    <li>Store Resume (Member)</li>
                    <li>Search Job</li>
                    <li>All Category</li>
                    <li>Overseas Jobs</li>
                    <li>Industrial Jobs</li>
                    <li>Disability Jobs</li>
                    <li>Feature Guide</li>

                </ul><?php } ?>
            <?php if (has_nav_menu('employer')) {
                $primenu = wp_nav_menu(array('theme_location' => 'employer', 'echo' => TRUE, 'container' => '', 'items_wrap' => '<ul class="clearfix" style="list-style: none; border: none;"><li><span style="color: #BF2026">Employers</span></li>%3$s</ul>'));
                echo $primenu;
                unset($primenu);
            } else {
                ?>
                <ul class="clearfix" style="list-style: none; border: none;">
                    <li><span style="color: #BF2026">Employers</span></li>

                    <li>Post Job</li>
                    <li>Advertise Rate</li>
                    <li>Search Resume</li>
                    <li>Feature Guide</li>

                </ul><?php } ?>
        </div>
        <div class="col-md-3">
            <?php $termsJobCat = get_terms('custom_job_cat');
            if (!empty($termsJobCat) && !is_wp_error($termsJobCat)) :
                ?>
                <ul class="clearfix" style="list-style: none; border: none;">
                <li><span style="color: #BF2026">Category</span></li>
                <?php
                foreach ($termsJobCat as $term):
                    ?>
                    <li>
                        <a href="<?php echo home_url(); ?>/job?cat=<?php echo $term->slug ?>"><?php echo $term->name; ?></a>
                    </li>
                <?php endforeach; ?>
                </ul><?php
            endif;
            ?>

        </div>
        <div class="col-md-3">
            <ul class="clearfix" style="list-style: none; border: none;">
                <li><span style="color: #BF2026">Location</span></li>
                <!--                <li>Jobs in Bangkok</li>-->
                <!--                <li>Jobs in Chachoengsao</li>-->
                <!--                <li>Jobs in Chonburi</li>-->
                <!--                <li>Jobs in Nonthaburi</li>-->
                <!--                <li>Jobs in Pathum Thani</li>-->
                <!--                <li>Jobs in Ratonh</li>-->
                <!--                <li>Jobs in Samut Prakan</li>-->
                <!--                <li>Jobs in Samut Sakhon</li>-->
                <?php
                $all_cats = get_categories('child_of=' . $classQueryPostJob->categoryLocationID . '&hide_empty=0');
                $arrayLocation = array();
                foreach ($all_cats as $value) {
                    if ($value->parent) {
                        $arrayLocation[] = $value;
                    }
                }
                foreach ($arrayLocation as $value) : ?>
                    <li><a href="<?php echo get_category_link($value->term_taxonomy_id); ?>">Jobs
                            in <?php echo $value->name; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-3">
            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/nav-logo.png"/>

            <p style="margin: 50px 0 50px 0; ">
                JobJapThai Co., Ltd.<br/>
                1 Infinite Loop Cupertino, CA 95014<br/>
                Tel. +6686 627 0681<br/>
                contact@jobjapthai.com
            </p>

            <?php if ($link_facebook): ?>
                <a href="<?php echo $link_facebook; ?>" target="_blank">
                    <img src="<?php echo get_template_directory_uri(); ?>/libs/img/social-fb.png"/></a>
            <?php endif; ?>
            <?php if ($link_twitter): ?>
                <a href="<?php echo $link_twitter; ?>" target="_blank">
                    <img src="<?php echo get_template_directory_uri(); ?>/libs/img/social-tw.png"/></a>
            <?php endif; ?>
            <?php if ($link_ggp): ?>
                <a href="<?php echo $link_ggp; ?>" target="_blank">
                    <img src="<?php echo get_template_directory_uri(); ?>/libs/img/social-ggp.png"/></a>
            <?php endif; ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="container-fluid bg-f3f3f4 clearfix margin-top-10">
        <div class="col-md-6">
            <p class="text-left">Copyright 2014 <span class="font-color-BF2026">JobJapThai.com</span> All right reserved
            </p>
        </div>
        <div class="col-md-6">
            <ul class="sitemaps pull-right no-margin">
                <li class="no-margin" style="float: left; width: auto;"><a href="<?php echo home_url(); ?>">Home</a>
                </li>
                <li class="no-margin" style="float: left; width: auto;"><a href="<?php echo home_url(); ?>/about-us">About
                        Us</a></li>
                <li class="no-margin" style="float: left; width: auto;"><a href="<?php echo home_url(); ?>/contact">Contact
                        Us</a></li>
                <li class="no-margin" style="float: left; width: auto;"><a href="<?php echo home_url(); ?>/news">JobJapThai
                        News</a></li>
                <li class="no-margin" style="float: left; width: auto;"><a
                        href="<?php echo home_url(); ?>/">Sitemaps</a></li>
            </ul>
        </div>
    </div>

</footer><!-- END : footers.container-fluid -->

<?php
include_once('libs/pages/modal.php');
?>

<!-- Modal -->
<style type="text/css">
    .blockDiv {
        position: absolute;
        top: 0px;
        left: 0px;
        background-color: #FFF;
        width: 0px;
        height: 0px;
        z-index: 9998;
    }

    .img_loading {
        position: fixed;
        top: 40%;
        left: 50%;
        z-index: 9999;
    }
</style>
<script>
    var str_loading = '<div class="img_loading"><img src="<?php
    bloginfo('template_directory'); ?>/libs/images/loading.gif" width="40"/></div>';
</script>
<script src="<?php echo get_template_directory_uri(); ?>/libs/js/footer.js"></script>

</body>
</html>