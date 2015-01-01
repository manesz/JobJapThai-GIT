
<div class="btn-group">
    <a href="<?php echo get_site_url(); ?>/candidate"
       class="btn btn-default <?php echo is_page("candidate-register") || is_page("candidate") ? 'active' : ''; ?>">Edit
        Resume</a>
    <a href="<?php echo get_site_url(); ?>/applied-job" class="btn btn-default <?php
    echo is_page("applied-job") ? 'active' : ''; ?>">Applied Job</a>
    <a href="<?php echo get_site_url(); ?>/favorite-job" class="btn btn-default <?php
    echo is_page("favorite-job") ? 'active' : ''; ?>">Favorite Job</a>
    <a href="#" class="btn btn-default">View by Company</a>
    <a href="#" class="btn btn-default">Account Setting</a>
</div>