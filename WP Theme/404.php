<?php
get_template_part("header");
get_template_part("libs/nav");
?>

<section class="container-fluid" style="margin-top: 10px;">

    <div class="container wrapper">
        <div class="row">

            <div class="col-md-8">

                <article id="post-not-found" class="hentry cf">

                    <header class="article-header">

                        <h1><?php _e('Epic 404 - Article Not Found', 'bonestheme'); ?></h1>

                    </header>

                    <section class="entry-content">

                        <p><?php _e('The article you were looking for was not found, but maybe try looking again!', 'bonestheme'); ?></p>

                    </section>

                    <section class="search">

                        <p><?php get_search_form(); ?></p>

                    </section>

                </article>

            </div>
            <?php
            get_template_part("libs/pages/sidebar");
            ?>
        </div>
    </div>
</section>
<?php
get_template_part("footer"); ?>
