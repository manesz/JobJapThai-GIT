<!--<div class="row">-->
    <div class="btn-group">
        <a class="btn btn-default <?php if (is_page("employer-register") || is_page("Edit Resume")) { ?> active<?php } ?>"
           href="<?php echo get_site_url(); ?>/edit-resume/"
           role="button"><?php if (is_page("employer-register") || is_page("Edit Resume")) { ?><strong>Edit
                Resume</strong><?php } else { ?>Edit Resume<?php } ?></a>
        <a class="btn btn-default <?php if (is_page("Post Job")) { ?> active<?php } ?>"
           href="<?php echo get_site_url(); ?>/post-job/" role="button"><?php if (is_page("Post Job")) { ?>
                <strong>Post Job</strong><?php } else { ?>Post Job<?php } ?></a>
        <a class="btn btn-default <?php if (is_page("Request Resume")) { ?> active<?php } ?>"
           href="<?php echo get_site_url(); ?>/request-resume/" role="button"><?php if (is_page("Request Resume")) { ?>
                <strong>Request Resume</strong><?php } else { ?>Request Resume<?php } ?></a>
        <a class="btn btn-default <?php if (is_page("Favorite Candidate")) { ?> active<?php } ?>"
           href="<?php echo get_site_url(); ?>/favorite-candidate/"
           role="button"><?php if (is_page("Favorite Candidate")) { ?><strong>Favorite
                Candidate</strong><?php } else { ?>Favorite Candidate<?php } ?></a>
        <a class="btn btn-default <?php if (is_page("Contact Candidate")) { ?> active<?php } ?>"
           href="<?php echo get_site_url(); ?>/contact-candidate/"
           role="button"><?php if (is_page("Contact Candidate")) { ?><strong>Contact
                Candidate</strong><?php } else { ?>Contact Candidate<?php } ?></a>
<!--        <a class="btn btn-default --><?php //if (is_page("Search Candidate")) { ?><!-- active--><?php //} ?><!--"-->
<!--           href="--><?php //echo get_site_url(); ?><!--/search-candidate/"-->
<!--           role="button">--><?php //if (is_page("Search Candidate")) { ?><!--<strong>Search-->
<!--                Candidate</strong>--><?php //} else { ?><!--Search Candidate--><?php //} ?><!--</a>-->
        <a class="btn btn-default <?php if (is_page("Candidate List")) { ?> active<?php } ?>"
           href="<?php echo get_site_url(); ?>/candidate-list/" role="button"><?php if (is_page("Candidate List")) { ?>
                <strong>Candidate List</strong><?php } else { ?>Candidate List<?php } ?></a>
        <a class="btn btn-info" href="<?php echo wp_logout_url(home_url()); ?>" role="button">Logout</a>
    </div>
<!--</div>-->