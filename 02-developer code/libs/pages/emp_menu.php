
<script>
    function viewCandidateProfile(canID) {
        showImgLoading();
        $("#body_candidate_profile").load("?employer_post=true&post_type=view_candidate&candidate_id=" + canID, function(){
            hideImgLoading();
        })
    }
</script>
<!--<div class="row">-->
    <div class="btn-group">
        <a class="btn btn-default <?php if (is_page("Seeking for Manpower Register") || is_page("Edit Profile")) { ?> active<?php } ?>"
           href="<?php echo get_site_url(); ?>/edit-profile/"
           role="button"><?php if (is_page("Seeking for Manpower Register") || is_page("Edit Profile")) { ?><strong>Edit
                Profile</strong><?php } else { ?>Edit Profile<?php } ?></a>
        <a class="btn btn-default <?php if (is_page("Post Job")) { ?> active<?php } ?>"
           href="<?php echo get_site_url(); ?>/post-job/" role="button"><?php if (is_page("Post Job")) { ?>
                <strong>Post Job</strong><?php } else { ?>Post Job<?php } ?></a>
        <a class="btn btn-default <?php if (is_page("Apply Job")) { ?> active<?php } ?>"
           href="<?php echo get_site_url(); ?>/apply-job/" role="button"><?php if (is_page("Apply Job")) { ?>
                <strong>Apply Job</strong><?php } else { ?>Apply Job<?php } ?></a>
        <a class="btn btn-default <?php if (is_page("Request Resume")) { ?> active<?php } ?>"
           href="<?php echo get_site_url(); ?>/request-resume/" role="button"><?php if (is_page("Request Resume")) { ?>
                <strong>Request Resume</strong><?php } else { ?>Request Resume<?php } ?></a>
        <a class="btn btn-default <?php if (is_page("Favorite Seeking for Job")) { ?> active<?php } ?>"
           href="<?php echo get_permalink(get_page_by_title('Favorite Seeking for Job')); ?>"
           role="button"><?php if (is_page("Favorite Seeking for Job")) { ?><strong>Favorite
                Seeking for Job</strong><?php } else { ?>Favorite Seeking for Job<?php } ?></a>
<!--        <a class="btn btn-default --><?php //if (is_page("Contact Candidate")) { ?><!-- active--><?php //} ?><!--"-->
<!--           href="--><?php //echo get_site_url(); ?><!--/contact-candidate/"-->
<!--           role="button">--><?php //if (is_page("Contact Candidate")) { ?><!--<strong>Contact-->
<!--                Candidate</strong>--><?php //} else { ?><!--Contact Candidate--><?php //} ?><!--</a>-->
<!--        <a class="btn btn-default --><?php //if (is_page("Search Candidate")) { ?><!-- active--><?php //} ?><!--"-->
<!--           href="--><?php //echo get_site_url(); ?><!--/search-candidate/"-->
<!--           role="button">--><?php //if (is_page("Search Candidate")) { ?><!--<strong>Search-->
<!--                Candidate</strong>--><?php //} else { ?><!--Search Candidate--><?php //} ?><!--</a>-->
        <a class="btn btn-default <?php if (is_page("Seeking for Job List")) { ?> active<?php } ?>"
           href="<?php echo get_permalink(get_page_by_title('Seeking for Job List')); ?>" role="button"><?php
            if (is_page("Seeking for Job List")) { ?>
                <strong>Seeking for Job List</strong><?php } else { ?>Seeking for Job List<?php } ?></a>
        <a class="btn btn-info" href="<?php echo wp_logout_url(home_url()); ?>" role="button">Logout</a>
    </div>
<!--</div>-->