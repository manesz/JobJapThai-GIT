<?php

$objClassContact = new Contact($wpdb);
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
                    <li><a href="job?cat=<?php echo $term->slug?>"><?php echo $term->name; ?></a></li>
                <?php endforeach; ?>
                </ul><?php
            endif;
            ?>

        </div>
        <div class="col-md-3">
            <ul class="clearfix" style="list-style: none; border: none;">
                <li><span style="color: #BF2026">Location</span></li>
                <li>Jobs in Bangkok</li>
                <li>Jobs in Chachoengsao</li>
                <li>Jobs in Chonburi</li>
                <li>Jobs in Nonthaburi</li>
                <li>Jobs in Pathum Thani</li>
                <li>Jobs in Ratonh</li>
                <li>Jobs in Samut Prakan</li>
                <li>Jobs in Samut Sakhon</li>
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
                <li class="no-margin" style="float: left; width: auto;">Home</li>
                <li class="no-margin" style="float: left; width: auto;">About Us</li>
                <li class="no-margin" style="float: left; width: auto;">Contact Us</li>
                <li class="no-margin" style="float: left; width: auto;">JobJapThai News</li>
                <li class="no-margin" style="float: left; width: auto;">Sitemaps</li>
            </ul>
        </div>
    </div>

</footer><!-- END : footers.container-fluid -->

<script>
    var str_loading = '<div class="img_loading" style="position: fixed; top: 40%; left: 50%;"><img src="<?php
    bloginfo('template_directory'); ?>/libs/images/loading.gif" width="64"/></div>';

    function showImgLoading() {
        $("body").append(str_loading);
    }

    function hideImgLoading() {
        $(".img_loading").remove();
    }

    function scrollToTop(fade_in) {
        fade_in = fade_in || false;
        $("body, html").animate({
                scrollTop: $("body").position().top
            },
            500,
            function () {
                if (fade_in)
                    $(fade_in).fadeIn();
            });
    }

    var wppage = {
        init: function () {
            wppage.addEvent();
            if (typeof jshook !== 'undefined') {
                jshook.init();
            }
        },
        addEvent: function () {
            $('.carousel').carousel({
                interval: 5000
            });
            $('#myTab a').on('click', function (e) {
                e.preventDefault()
                $(this).tab('show', 'fast');
            });
        },
        onready: function () {
            wppage.init();
            return false;
        }
    };
    $(document).ready(wppage.onready);
</script>

</body>
</html>