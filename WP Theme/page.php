<?php

if (have_posts()) :
    while (have_posts()) : the_post();
        if (is_page('Apply Employer Register')) {
            get_template_part("libs/pages/apply-employer-register");
            exit();
        }

        get_template_part("header");
        get_template_part("libs/nav");

        if (is_page("about-us")) {
            get_template_part('libs/pages/about-us'); //change to call full page UI
            //get_template_part('post-formats/format');
        }else if (is_page("employer-register")) {
            get_template_part('libs/pages/employer-register');
        } else if (is_page("Post Job")) {
            get_template_part('libs/pages/post-job');
        } else if (is_page("Edit Resume")) {
            get_template_part('libs/pages/employer-register');
        } else if (is_page("request-resume")) {
            get_template_part('libs/pages/request-resume');
        } else if (is_page("favorite-candidate")) {
            get_template_part('libs/pages/favorite-candidate');
        } else if (is_page("contact-candidate")) {
            get_template_part('libs/pages/contact-candidate');
        } else if (is_page("search-candidate")) {
            get_template_part('libs/pages/search-candidate');
        } else if (is_page("candidate-list")) {
            get_template_part('libs/pages/candidate-list');
        } else if (is_page("employer")) {
            get_template_part('libs/pages/employer');
        } else if (is_page("company-profile")) {
            get_template_part('libs/pages/company-profile');
        } else if (is_page("contact")) {
            get_template_part('libs/pages/contact');
        } else if (is_page("candidate-register") || is_page("candidate")) {
            get_template_part('libs/pages/candidate-register');
        } else if (is_page("favorite-job")) {
            get_template_part('libs/pages/favorite-job');
        } else if (is_page("applied-job")) {
            get_template_part('libs/pages/applied-job');
        } else if (is_page("highlight-jobs")) {
            get_template_part('libs/pages/highlight-jobs');
        } else if (is_page("register-success")) {
            get_template_part('libs/pages/register-success');
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

get_template_part('footer');?>
