<?php
global $wpdb;
$classQueryPostJob = new QueryPostJob($wpdb);
$s = empty($_GET['s']) ? false : $_GET['s'];
$location = empty($_GET['location']) ? false : $_GET['location'];
$position = empty($_GET['position']) ? false : $_GET['position'];
$emp_type = empty($_GET['emp_type']) ? false : $_GET['emp_type'];
$job_cat = empty($_GET['job_cat']) ? false : $_GET['job_cat'];
$sub_cat = empty($_GET['sub_cat']) ? false : $_GET['sub_cat'];



?>
<aside class="col-md-4" style="">

    <?php include_once("box-signin.php"); ?>

    <div class="clearfix" style="<?php if (isset($page) && $page == "news"): echo "display: none; ";
    else: echo "display: block;"; endif; ?> border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
        <h4 style="font-size: 16px !important;">
            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png" style="height: 25px;"/>
            Find jobs
        </h4>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="col-md-6 text-center <?php echo $s != 'advance' ? 'active' : ''; ?>"
                style="list-style: none; border: none;">
                <a href="#search" role="tab"
                   data-toggle="tab">Search</a>
            </li>
            <li class="col-md-6 text-center <?php echo $s == 'advance' ? 'active' : ''; ?>"
                style="list-style: none; border: none;">
                <a href="#advanceSearch" role="tab"
                   data-toggle="tab">Advance
                    Search</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane" id="search" style="padding-top: 20px;">
                <form role="search" action="<?php echo esc_url(home_url('/')); ?>" method="get">
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="textSearch1" class="" style="font-size: 12px; padding-right: 0px;">Search:</label>
                        <input type="text" id="textSearch1" name="s" class="form-control"
                               placeholder="enter text search"
                               value="<?php echo get_search_query() != 'advance' ? get_search_query() : ''; ?>"/>
                    </div>
                    <div class="form-group clearfix text-center" style="margin: 10px 0 10px 0;">
                        <button type="submit" class="btn btn-default col-md-12"
                                style="margin-right: 15px; border: none; background: #BF2026; color: #fff;">Find Job
                        </button>
                    </div>
                </form>
            </div>
            <div class="tab-pane <?php echo $s == 'advance' ? 'active' : ''; ?>" id="advanceSearch">
                <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                    <input type="hidden" name="s" value="advance"/>

                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="location" class="" style="font-size: 12px; padding-right: 0px;">Location</label>
                        <select name="location" id="location" class="col-md-12 form-control">
                            <option value="">All Locations</option>
                            <?php
                            $all_cats = get_categories('child_of=' . $classQueryPostJob->categoryLocationID . '&hide_empty=0');
                            $arrayLocation = array();
                            foreach ($all_cats as $value) {
                                if ($value->parent) {
                                    $arrayLocation[] = $value;
                                }
                            }
                            foreach ($arrayLocation as $value) : ?>
                                <option <?php echo $location == $value->slug ? "selected" : ""; ?>
                                    value="<?php echo $value->slug; ?>"><?php echo $value->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="position" class="" style="font-size: 12px; padding-right: 0px;">Position</label>
                        <select name="position" class="col-md-12 form-control">
                            <option>All Position</option>
                        </select>
                    </div>
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="emp_type" class="" style="font-size: 12px; padding-right: 0px;">Employer
                            Type</label>
                        <select name="emp_type" class="col-md-12 form-control">
                            <option>All Type</option>
                        </select>
                    </div>
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="category" class="" style="font-size: 12px; padding-right: 0px;">Category</label>
                        <select id="category" name="job_cat" class="col-md-12 form-control">
                            <option value="">All Categories</option>

                            <?php $termsJobCat = get_terms('custom_job_cat');
                            if (!empty($termsJobCat) && !is_wp_error($termsJobCat)) :
                                ?>
                                <?php
                                foreach ($termsJobCat as $term):
                                    ?>
                                    <option <?php echo $term->slug == $job_cat ? "selected" : ""; ?>
                                        value="<?php echo $term->slug ?>"><?php echo $term->name ?></option>
                                <?php endforeach; ?>
                            <?php
                            endif;
                            ?>
                        </select>
                    </div>
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="sub_cat" class=""
                               style="font-size: 12px; padding-right: 0px;">Subcategory</label>
                        <select name="sub_cat" id="sub_cat" class="col-md-12 form-control">
                            <option>All Subcategory</option>
                        </select>
                    </div>
                    <div class="form-group clearfix text-center" style="margin: 10px 0 10px 0;">
                        <button type="submit" class="btn btn-default col-md-12"
                                style="margin-right: 15px; border: none; background: #BF2026; color: #fff;">Find Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="clearfix" style="<?php if (isset($page) && $page == "news"): echo "display: block; ";
    else: echo "display: none;"; endif; ?>border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
        <h4 class="font-color-BF2026">
            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png" style="height: 25px;"/>
            Top 5 Hilight Job
        </h4>

        <?php
        $argc = array(
            'post_type' => 'job',
            'category_name' => 'highlight-jobs',
            'orderby' => 'date', //name of category by slug
            'order' => 'DESC',
            'post_status' => 'publish',
            'posts_per_page' => 5
        );
        $loopHighlightJobs = new WP_Query($argc);
        $i = 0;
        if ($loopHighlightJobs->have_posts()):
            ?>
            <ul class="job-list no-padding margin-top-10">
                <?php while ($loopHighlightJobs->have_posts()) :
                    $loopHighlightJobs->the_post();
                    $postID = get_the_id();
                    $url = wp_get_attachment_url(get_post_thumbnail_id($postID));
                    if (empty($url)) {
                        $thumbnail = get_template_directory_uri() . "/libs/img/blank-logo.png";
                    } else {
                        $thumbnail = $url;
                    }
                    ?>
                    <li class="clearfix border-bottom-1-ddd padding-top-10 padding-bottom-10">
                        <div class="col-md-12">
                            <div class="col-md-4" style="padding: 0px">
                                <a href="<?php the_permalink(); ?>"><img src="<?php echo $thumbnail; ?>"
                                                                         style="width: 100%;"/></div>
                            </a>
                            <div class="col-md-8">
                                <a href="<?php the_permalink(); ?>"><h5
                                        class="font-color-BF2026 no-margin"><?php the_title(); ?></h5></a>

                                <p class="font-size-12">
                                    <span class="font-color-4D94CC">Bangkok</span><br/>
                                    Permanent<br/>
                                    <span class="font-color-ddd"><?php the_date('M d, Y'); ?></span><br/>
                                </p>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div id="fb-root"></div>
    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1380481428850317&version=v2.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <div class="clearfix"
         style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">

        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1380481428850317&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-like-box" data-href="https://www.facebook.com/Jobjapthai" data-colorscheme="light"
             data-show-faces="true" data-header="true" data-stream="false" data-show-border="false"></div>

    </div>

    <img class="col-md-12 no-padding clearfix"
         src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-02.png" width="100%"/>

</aside><!-- END : aside.container-fluid -->