<?php
$canID = empty($_GET['canid']) ? "" : $_GET['canid'];
$siteUrl = get_site_url();
?>
<div class="btn-group">
    <a href="<?php echo $siteUrl; ?>/candidate?canid=<?php echo $canID; ?>"
       class="btn btn-default <?php echo is_page("candidate-register") || is_page("candidate") ? 'active' : ''; ?>">Edit
        Resume</a>
    <a href="<?php echo $siteUrl; ?>/applied-job?canid=<?php echo $canID; ?>" class="btn btn-default <?php
    echo is_page("applied-job") ? 'active' : ''; ?>">Applied Job</a>
    <a href="<?php echo $siteUrl; ?>/favorite-job?canid=<?php echo $canID; ?>" class="btn btn-default <?php
    echo is_page("favorite-job") ? 'active' : ''; ?>">Favorite Job</a>
    <a href="#" class="btn btn-default">View by Company</a>
    <a href="#" class="btn btn-default">Account Setting</a>
</div>