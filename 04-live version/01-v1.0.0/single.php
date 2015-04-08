<?php
$postType = get_post_type(get_the_ID());
if (have_posts()) : while (have_posts()) : the_post();
    if ($postType == 'job')
        get_template_part('libs/pages/job-view', get_post_format());
    else if ($postType == 'company')
        get_template_part('libs/pages/company-view', get_post_format());
    else {

        get_template_part("header", get_post_format());
        get_template_part("libs/nav", get_post_format());
        ?>
        <div id="content">
            <h1>Is single</h1>

            <div id="inner-content" class="wrap cf">

                <div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                        <?php
                        /*
                         * Ah, post formats. Nature's greatest mystery (aside from the sloth).
                         *
                         * So this function will bring in the needed template file depending on what the post
                         * format is. The different post formats are located in the post-formats folder.
                         *
                         *
                         * REMEMBER TO ALWAYS HAVE A DEFAULT ONE NAMED "format.php" FOR POSTS THAT AREN'T
                         * A SPECIFIC POST FORMAT.
                         *
                         * If you want to remove post formats, just delete the post-formats folder and
                         * replace the function below with the contents of the "format.php" file.
                        */
                        get_template_part('post-formats/format', get_post_format());

                        ?>

                    <?php endwhile; ?>

                    <?php else : ?>

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

                    <?php endif; ?>

                </div>
                <?php get_template_part("pages/sidebar", get_post_format()); ?>
            </div>
        </div>
        <?php get_template_part("footer", get_post_format());
    }
endwhile;
endif;
