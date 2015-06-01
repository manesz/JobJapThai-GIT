<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        if (is_page('Apply Seeking for Manpower Register')) {
            get_template_part("libs/pages/apply-employer-register");
            exit();
        }

        get_template_part("header");
        get_template_part("libs/nav");

        if (is_page("about-us")) {
            get_template_part('libs/pages/about-us'); //change to call full page UI
            //get_template_part('post-formats/format');
        } else if (is_page("Seeking for Manpower Register")) {
            get_template_part('libs/pages/employer-register');
        } else if (is_page("Post Job")) {
            get_template_part('libs/pages/post-job');
        } else if (is_page("Apply Job")) {
            get_template_part('libs/pages/apply-job');
        } else if (is_page("Edit Profile")) {
            if (is_user_logged_in()) {
                global $current_user;
                get_currentuserinfo();
                $userID = $current_user->ID;
                $userType = get_user_meta($userID, 'user_type', $single);
                if ($userType) {
                    if ($userType == 'employer') {
                        get_template_part('libs/pages/employer-register');
                    } else if ($userType == 'candidate') {
                        get_template_part('libs/pages/candidate-register');
                    }
                } else {
                    ?>
                    <script>
                        window.location.href = '<?php echo home_url(); ?>/wp-admin/profile.php';
                    </script>
                <?php
                }
                //get_template_part('libs/pages/employer-register');
            } else {
                ?>
                <script>
                    window.location.href = '<?php echo home_url(); ?>?show_register=true';
                </script>
            <?php
            }
        } else if (is_page("request-resume")) {
            get_template_part('libs/pages/request-resume');
        } else if (is_page("favorite-seeking-for-job")) {
            get_template_part('libs/pages/favorite-candidate');
        } else if (is_page("Contact Seeking for Job")) {
            get_template_part('libs/pages/contact-candidate');
        } else if (is_page("Search Seeking for Job")) {
            get_template_part('libs/pages/search-candidate');
        } else if (is_page("Seeking for Job List")) {
            get_template_part('libs/pages/candidate-list');
        } else if (is_page("Seeking for Manpower")) {
            get_template_part('libs/pages/employer');
        } else if (is_page("company-profile")) {
            get_template_part('libs/pages/company-profile');
        } else if (is_page("contact")) {
            get_template_part('libs/pages/contact');
        } else if (is_page("Seeking for Job Register") || is_page("Seeking for Job")) {
            get_template_part('libs/pages/candidate-register');
//            get_template_part('libs/pages/cover-register');
            //exit;
        } else if (is_page("Seeking for Job View")) {
            get_template_part('libs/pages/candidate-view');
        } else if (is_page("favorite-job")) {
            get_template_part('libs/pages/favorite-job');
        } else if (is_page("Favorite Seeking for Manpower")) {
            get_template_part('libs/pages/favorite-employer');
        } else if (is_page("Request Profile By Company")) {
            get_template_part('libs/pages/request-profile-by-company');
        } else if (is_page("applied-job")) {
            get_template_part('libs/pages/applied-job');
        } else if (is_page("highlight-jobs")) {
            get_template_part('libs/pages/highlight-jobs');
        } else if (is_page("register-success")) {
            $getCheckPage = empty($_REQUEST['emp']) ? false : true;
            if ($getCheckPage)
                get_template_part('libs/pages/employer-register-success');
            else
                get_template_part('libs/pages/candidate-register-success');

        } else if (is_page("confirm-register")) {
            get_template_part('libs/pages/confirm-register');
        } else if (is_page("confirm-success")) {
            get_template_part('libs/pages/register-success');
        }

    endwhile;
else :
    ?>
    <article id="post-not-found" class="hentry cf">
        <header class="article-header">
            <h1><?php _e('Oops, Post Not Found!', 'bonestheme'); ?></h1>
        </header>
        <section class="entry-content">
            <p><?php _e('Uh Oh. Something is missing. Try double checking things.', 'bonestheme'); ?></p>
        </section>
        <footer class="article-footer">
            <p><?php _e('This is the error message in the single.php template.', 'bonestheme'); ?></p>
        </footer>
    </article>
<?php
endif;

get_template_part('footer'); ?>
