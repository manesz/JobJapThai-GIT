<?php
if (is_user_logged_in()) {
    global $current_user, $wpdb;
    $userID = $current_user->ID;
    $userType = get_user_meta($userID, 'user_type', true);
    if ($userType == "employer") {
        $isLogin = false;
        $userID = 0;
    } else {
        $isLogin = true;

        $classCandidate = new Candidate($wpdb);
        $classEmployer = new Employer($wpdb);
        $classQueryPostJob = new QueryPostJob($wpdb);
    }
} else {
    $isLogin = false;
    $userID = 0;
}

if (!$isLogin) {
    wp_redirect(home_url());
    exit;
}
?>
<script>
    var site_url = '<?php echo get_site_url(); ?>/';
    var is_login = <?php echo $isLogin ? 'true': 'false'; ?>;
    function setApprove(reqID, comName) {
        if (!confirm("You want to send profile to " + '"' + comName + '"'))
            return;
        showImgLoading();
        $.ajax({
            dataType: 'json',
            cache: false,
            type: "GET",
            url: '',
            data: {
                candidate_post: 'true',
                post_type: 'approve_request_profile',
                request_id: reqID
            },
            success: function (result) {
                hideImgLoading();
                showModalMessage(result.msg, "Message Candidate");
                if (!result.error) {
                    window.location.reload();
                }
            },
            error: function (result) {
                showModalMessage(result.responseText, "Error");
                hideImgLoading();
            }
        });
    }
</script>
<section class="container-fluid" style="margin-top: 10px;">

    <div class="container wrapper">
        <div class="row">

            <div class="col-md-8">
                <?php if ($isLogin) { ?>
                    <div id="sectProfile" class="col-md-12">
                        <?php echo $classCandidate->candidateMenu(); ?>
                    </div>
                <?php } ?>
                <div class="clearfix"
                     style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                    <h5 class="pull-left" style="">
                        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png"
                             style="height: 25px;"/>
                        お知らせ
                        <span class="font-color-BF2026" style=""><?php the_title(); ?></span>
                    </h5>

                    <div class="clearfix" style="margin-top: 20px;"></div>
                    <div id="show_message" class="col-md-12">
                    </div>
                    <hr/>
                    <h5 class="font-color-BF2026"><?php the_title(); ?> List</h5>
                    <?php
                    $getRequestResume = $classCandidate->getRequestResumeByCandidate(0, $userID);

                    ?>
                    <ul class="job-list no-padding">
                        <?php foreach ($getRequestResume as $key => $value):
                            $employer_id = $value->employer_id;
                            $getLogo = $classEmployer->getLogoPath($employer_id);
                            if ($getLogo['have_image']) {
                                $thumbnail = $getLogo['path'];
                            } else {
                                $thumbnail = get_template_directory_uri() . "/libs/img/blank-logo.png";
                            }
                            ?>
                            <li class="clearfix border-bottom-1-ddd padding-top-10 padding-bottom-10">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="padding: 0px">
                                        <a href="company-profile?id=<?php echo $employer_id; ?>" target="_blank"><img
                                                src="<?php echo $thumbnail; ?>"
                                                style="width: 100%;"/></a>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="font-color-BF2026">
                                            <a href="company-profile?id=<?php echo $employer_id; ?>"
                                               target="_blank"><?php echo $value->company_name; ?></a>
                                        </h5>
                                        <?php echo date_i18n('M d, Y H:i:s', strtotime($value->req_date)); ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php if ($value->approve): ?>
                                            <span class="font-color-4BB748 pull-right">Send completed</span>
                                        <?php else: ?>
                                            <a class="btn btn-success pull-right"
                                               onclick="setApprove(<?php echo $value->req_id; ?>,
                                                   '<?php echo $value->company_name; ?>');">Send Profile</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <?php require_once("banner1.php"); ?>

            </div>

            <?php include_once("sidebar.php"); ?>
        </div>
    </div>

</section>

<style type="text/css">
    #sectProfile {
        padding-top: 10px
    }
</style>
<script>

    function toggleChevron(e) {
        $(e.target)
            .prev('.panel-heading')
            .find("i.indicator")
            .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
    }
    //    $('.in').collapse({hide: true});
    // in cadidate register page
</script>