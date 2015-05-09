<?php
global $current_user, $wpdb;
$classCandidate = new Candidate($wpdb);
if (is_user_logged_in()) {
    $userID = $current_user->ID;
    $userType = get_user_meta($userID, 'user_type', true);
    if ($userType == "employer") {
        $isLogin = false;
        $userID = 0;
    } else {
        $isLogin = true;
    }
} else {
    $isLogin = false;
    $userID = 0;
}
$objInformation = $classCandidate->getInformation($userID);
if ($objInformation)
    extract((array)$objInformation[0]);

?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/libs/css/jasny-bootstrap.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="<?php echo get_template_directory_uri(); ?>/libs/js/jasny-bootstrap.min.js"></script>
<script>
    var site_url = '<?php echo get_site_url(); ?>/';
    var is_login = <?php echo $isLogin ? 'true': 'false'; ?>;
    var post_type = '<?php echo $isLogin ? 'edit': 'add'; ?>';
    var candidate_id = <?php echo $userID; ?>;
    var distinct = <?php echo empty($district) ? 0: $district; ?>;
    var sub_district = <?php echo empty($city) ? 0: $city; ?>;
</script>

<script src="<?php echo get_template_directory_uri(); ?>/libs/js/candidate.js"></script>
<section class="container-fluid" style="margin-top: 10px;">

<div class="container wrapper">
<div class="row">
<div class="col-md-8">
<?php if ($isLogin) { echo $classCandidate->buildHtmlEditProfile1($userID); } ?>
<div class="clearfix"
     style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
<h5 class="pull-left" style="">
    <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png" style="height: 25px;"/>
    お知らせ
    <span class="font-color-BF2026" style="">Candidate Register</span>
</h5>

<div class="clearfix" style="margin-top: 20px;"></div>
<div id="show_message" class="col-md-12">
</div>
<?php if (!$isLogin): ?>
    <?php echo $classCandidate->buildHtmlFormRegister(); ?>
<?php else: ?>
    <?php  echo $classCandidate->buildHtmlEditProfile2($userID); ?>
<?php endif; ?>
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