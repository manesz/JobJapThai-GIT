<?php

if (have_posts()) :
    while (have_posts()) : the_post();
        if (is_page('Apply Employer Register')) {
            get_template_part("libs/pages/apply-employer-register", get_post_format());
            exit();
        }

        get_template_part("header", get_post_format());
        get_template_part("libs/nav", get_post_format());
		
        if (is_page("about-us")) {
            include_once('libs/pages/about-us.php');//change to call full page UI
			//get_template_part('post-formats/format.php');
        } else if (is_page("news")) {
            include_once('libs/pages/news.php');
        } else if (is_page("employer-register")) {
            include_once('libs/pages/employer-register.php');
        } else if (is_page("Edit Resume")) {
            include_once('libs/pages/employer-register.php');
        } else if (is_page("request-resume")) {
            include_once('libs/pages/request-resume.php');
        } else if (is_page("favorite-candidate")) {
            include_once('libs/pages/favorite-candidate.php');
        } else if (is_page("contact-candidate")) {
            include_once('libs/pages/contact-candidate.php');
        } else if (is_page("search-candidate")) {
            include_once('libs/pages/search-candidate.php');
        } else if (is_page("candidate-list")) {
            include_once('libs/pages/candidate-list.php');
        } else if (is_page("employer")) {
            include_once('libs/pages/employer.php');
        } else if (is_page("company-profile")) {
            echo $_REQUEST['company'];
        } else if (is_page("contact")) {
            include_once('libs/pages/contact.php');
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

include_once('footer.php');?>
