<aside class="col-md-4" style="">
    <?php include_once("box-signin.php");?>

    <div class="clearfix" style="<?php if(isset($page) && $page == "news"): echo "display: none; "; else: echo "display: block;"; endif;?> border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
        <h4 style="font-size: 16px !important;">
            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png" style="height: 25px;"/>
            Find jobs
        </h4>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="active col-md-6 text-center" style="list-style: none; border: none;"><a href="#search" role="tab" data-toggle="tab">Search</a></li>
            <li class="col-md-6 text-center" style="list-style: none; border: none;"><a href="#advanceSearch" role="tab" data-toggle="tab">Advance Search</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="search" style="padding-top: 20px;">
                <form action="search.php" method="post">
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="location" class="" style="font-size: 12px; padding-right: 0px;">Search:</label>
                        <input type="text" id="textSearch" name="textSearch" class="form-control" placeholder="enter text search"/>
                    </div>
                    <div class="form-group clearfix text-center" style="margin: 10px 0 10px 0;">
                        <button type="submit" class="btn btn-default col-md-12" style="margin-right: 15px; border: none; background: #BF2026; color: #fff;">Find Job</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="advanceSearch">
                <form action="search.php" method="post">
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="location" class="" style="font-size: 12px; padding-right: 0px;">Location</label>
                        <select name="location" class="col-md-12 form-control"><option>All Locations</option></select>
                    </div>
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="position" class="" style="font-size: 12px; padding-right: 0px;">Position</label>
                        <select name="position" class="col-md-12 form-control"><option>All Position</option></select>
                    </div>
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="type" class="" style="font-size: 12px; padding-right: 0px;">Employer Type</label>
                        <select name="type" class="col-md-12 form-control"><option>All Type</option></select>
                    </div>
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="category" class="" style="font-size: 12px; padding-right: 0px;">Category</label>
                        <select name="category" class="col-md-12 form-control"><option>All Categories</option></select>
                    </div>
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="subCategory" class="" style="font-size: 12px; padding-right: 0px;">Subcategory</label>
                        <select name="subCategory" class="col-md-12 form-control"><option>All Subcategory</option></select>
                    </div>
                    <div class="form-group clearfix text-center" style="margin: 10px 0 10px 0;">
                        <button type="submit" class="btn btn-default col-md-12" style="margin-right: 15px; border: none; background: #BF2026; color: #fff;">Find Job</button>
                    </div>
                </form>
            </div>
        </div>


    </div>

    <div class="clearfix" style="<?php if(isset($page) && $page == "news"): echo "display: block; "; else: echo "display: none;"; endif;?>border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
        <h4 class="font-color-BF2026">
            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png" style="height: 25px;"/>
            Top 5 Hilight Job
        </h4>

            <?php
            $argc = array(
                'post_type' => 'job',
//                                        'category_name' => 'highlight-jobs',
                //'orderby' => 'date', //name of category by slug
                //'order' => 'ASC',
                'post_status' => 'publish',
                'posts_per_page' => 10
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
                            <a href="<?php the_permalink(); ?>"><img src="<?php echo $thumbnail; ?>" style="width: 100%;"/> </div></a>
                        <div class="col-md-8">
                            <a href="<?php the_permalink(); ?>"><h5 class="font-color-BF2026 no-margin"><?php the_title(); ?></h5></a>
                            <p class="font-size-12">
                                <span class="font-color-4D94CC">Bangkok</span><br/>
                                Permanent<br/>
                                <span class="font-color-ddd"><?php the_date('M d, Y'); ?></span><br/>
                            </p>
                        </div>
                    </div>
                </li>
            <?php endwhile;?>
            </ul>
                <?php endif; ?>
    </div>

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1380481428850317&version=v2.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <div class="clearfix" style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">

        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1380481428850317&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-like-box" data-href="https://www.facebook.com/Jobjapthai" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="false"></div>

    </div>

    <img class="col-md-12 no-padding clearfix" src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-02.png" width="100%"/>

    </div>
</aside><!-- END : aside.container-fluid -->