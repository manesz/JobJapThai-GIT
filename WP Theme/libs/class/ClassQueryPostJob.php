<?php

/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 02/01/2558
 * Time: 14:16 น.
 */
class QueryPostJob
{
    private $wpdb;
    public $tableFavoriteJob = "ics_favorite_job";
    public $tableFavoriteCompany = "ics_favorite_company";
    public $tableCompanyInfo = "ics_company_information_for_contact";
    private $postType = "job";
    private $ClassFavorite = null;
    private $ClassApply = null;
    private $ClassEmployer = null;
    public $categoryLocationID = 0;

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
        $this->ClassFavorite = new Favorite($wpdb);
        $this->ClassApply = new Apply($wpdb);
        $this->ClassEmployer = new Employer($wpdb);

        $this->categoryLocationID = get_cat_ID("Location");
    }

    public function queryFavoriteJob($user_id)
    {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts_per_page = empty($_GET['posts_per_page']) ? 10 : $_GET['posts_per_page'];
        $orderby = empty($_GET['orderby']) ? 1 : $_GET['orderby'];

        $getListFavJob = $this->ClassFavorite->listFavJob(0, 0, $user_id);
        $argc = array(
            'post_type' => $this->postType,
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            //        'meta_query' => array(
            //            array(
            //                'key' => 'company_id',
            //                'value' => $company_id,
            //                'compare' => '='
            //            )
            //
            //        ),
        );

        switch ($orderby) {
            case 1: //last update
                $arrayListJobID = array();
                foreach ($getListFavJob as $value) {
                    $arrayListJobID[] = $value->job_id;
                }
                if (!$arrayListJobID)
                    return null;
                $argc['orderby'] = 'modified';
                $argc['order'] = 'DESC';
                $argc['post__in'] = $arrayListJobID;
                break;
            case 2: //company name
                $arrayCompanyID = array();
                foreach ($getListFavJob as $value) {
                    $arrayCompanyID[] = $value->company_id;
                }
                $objListCompany = $this->ClassEmployer->getCompanyInfo($arrayCompanyID, 0, " ORDER BY company_name");

                $arrayListJobID = array();
                foreach ($objListCompany as $value1) {
                    foreach ($getListFavJob as $value2) {
                        if ($value1->id == $value2->company_id) {
                            $arrayListJobID[] = $value2->job_id;
                        }
                    }
                }
                if (!$arrayListJobID)
                    return null;
                $argc['post__in'] = $arrayListJobID;
                break;
        }
        return $argc;
    }

    public function queryApplyJob($user_id)
    {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts_per_page = empty($_GET['posts_per_page']) ? 10 : $_GET['posts_per_page'];
        $orderby = empty($_GET['orderby']) ? 1 : $_GET['orderby'];

        $getListApplyJob = $this->ClassApply->listApplyJob(0, 0, $user_id);
        $argc = array(
            'post_type' => $this->postType,
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged
        );

        switch ($orderby) {
            case 1: //last update
                $arrayListJobID = array();
                foreach ($getListApplyJob as $value) {
                    $arrayListJobID[] = $value->job_id;
                }
                if (!$arrayListJobID)
                    return null;
                $argc['orderby'] = 'modified';
                $argc['order'] = 'DESC';
                $argc['post__in'] = $arrayListJobID;
                break;
            case 2: //company name
                $arrayCompanyID = array();
                foreach ($getListApplyJob as $value) {
                    $arrayCompanyID[] = $value->company_id;
                }
                $objListCompany = $this->ClassEmployer->getCompanyInfo(0, 0, " ORDER BY company_name");
                $arrayMetaQuery = array();
                foreach ($objListCompany as $value) {
                    $arrayMetaQuery[] = array(
                        'key' => 'company_id',
                        'value' => $value->id,
                        'compare' => '='
                    );
                }
                $argc['meta_query'] = array($arrayMetaQuery);
                if (!$arrayMetaQuery)
                    return null;
                break;
        }
        return $argc;
    }

    public function queryJobUpdate($cat = false, $location = false, $limit = -1)
    {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts_per_page = empty($_GET['posts_per_page']) ? 10 : $_GET['posts_per_page'];
        $orderby = empty($_GET['orderby']) ? 1 : $_GET['orderby'];

        if ($limit > -1) {
            $posts_per_page = $limit;
        }
        $argc = array(
            'post_type' => $this->postType,
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged
        );
        if ($cat) {
            $argc['custom_job_cat'] = $cat;
        }
        if ($location) {
            $argc['category__in'] = array($location);
        }

        switch ($orderby) {
            case 1: //last update
                $argc['orderby'] = 'modified';
                $argc['order'] = 'DESC';
                break;
            case 2: //company name
                $arrayCompanyID = array();
//                foreach ($getListApplyJob as $value) {
//                    $arrayCompanyID[] = $value->company_id;
//                }
//                $objListCompany = $this->ClassEmployer->getCompanyInfo(0, 0, " ORDER BY company_name");
//                $arrayMetaQuery = array();
//                foreach ($objListCompany as $value) {
//                    $arrayMetaQuery[] = array(
//                        'key' => 'company_id',
//                        'value' => $value->id,
//                        'compare' => '='
//                    );
//                }
//                $argc['meta_query'] = array($arrayMetaQuery);
//                if (!$arrayMetaQuery)
                return null;
                break;
        }
        return $argc;
    }

    public function queryHighlightJobs($limit = -1)
    {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts_per_page = empty($_GET['posts_per_page']) ? 10 : $_GET['posts_per_page'];
        $orderby = empty($_GET['orderby']) ? 1 : $_GET['orderby'];

        if ($limit > -1)
            $posts_per_page = $limit;
        $argc = array(
            'post_type' => $this->postType,
//            'category_name' => 'highlight-jobs',
            'meta_key' => 'highlight_jobs',
            'meta_value' => '1',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged
        );

        switch ($orderby) {
            case 1: //last update
                $argc['orderby'] = 'modified';
                $argc['order'] = 'DESC';
                break;
            case 2: //company name
                $arrayCompanyID = array();
//                foreach ($getListApplyJob as $value) {
//                    $arrayCompanyID[] = $value->company_id;
//                }
//                $objListCompany = $this->ClassEmployer->getCompanyInfo(0, 0, " ORDER BY company_name");
//                $arrayMetaQuery = array();
//                foreach ($objListCompany as $value) {
//                    $arrayMetaQuery[] = array(
//                        'key' => 'company_id',
//                        'value' => $value->id,
//                        'compare' => '='
//                    );
//                }
//                $argc['meta_query'] = array($arrayMetaQuery);
//                if (!$arrayMetaQuery)
                return null;
                break;
        }
        return $argc;
    }

    public function querySearchJob()
    {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts_per_page = empty($_GET['posts_per_page']) ? 10 : $_GET['posts_per_page'];
        $orderby = empty($_GET['orderby']) ? 1 : $_GET['orderby'];
        $search = $_GET['s'];

        $getListCompanyInfo = $this->ClassEmployer->getCompanyInfo();
        $argc = array(
            'post_type' => $this->postType,
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
        );
        $advance = empty($_GET['advance']) ? false : true;
        if ($advance) {
            $location = empty($_GET['location']) ? false : $_GET['location'];
            $position = empty($_GET['position']) ? false : $_GET['position'];
            $emp_type = empty($_GET['emp_type']) ? false : $_GET['emp_type'];
            $subCategory = empty($_GET['subCategory']) ? false : $_GET['subCategory'];
        } else {
            $argc['s'] = $search;
        }
        switch ($orderby) {
            case 1: //last update
                $argc['orderby'] = 'modified';
                $argc['order'] = 'DESC';
                break;
            case 2: //company name
                $arrayCompanyID = array();
                foreach ($getListCompanyInfo as $value) {
                    $arrayCompanyID[] = $value->company_id;
                }
//                $objListCompany = $this->ClassEmployer->getCompanyInfo();
//
//                $arrayListJobID = array();
//                foreach ($objListCompany as $value1) {
//                    foreach ($getListCompanyInfo as $value2) {
//                        if ($value1->employer_id == $value2->company_id) {
//                            $arrayListJobID[] = $value2->job_id;
//                        }
//                    }
//                }
//                if (!$arrayListJobID)
//                    return null;
//                $argc['post__in'] = $arrayListJobID;
                break;
        }

        return $argc;
    }

    function queryPostJob($user_id)
    {
        $getCompanyInfo = $this->ClassEmployer->getCompanyInfo(0, $user_id);
        $company_id = $getCompanyInfo[0]->com_id;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts_per_page = empty($_GET['posts_per_page']) ? 10 : $_GET['posts_per_page'];
        $orderby = empty($_GET['orderby']) ? 1 : $_GET['orderby'];
        $argc = array(
            'post_type' => $this->postType,
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'meta_key' => 'company_id',
            'meta_value' => $company_id,
            'paged' => $paged
        );

        switch ($orderby) {
            case 1: //last update
//                $arrayListJobID = array();
//                foreach ($getListApplyJob as $value) {
//                    $arrayListJobID[] = $value->job_id;
//                }
//                if (!$arrayListJobID)
//                    return null;
                $argc['orderby'] = 'modified';
                $argc['order'] = 'DESC';
//                $argc['post__in'] = $arrayListJobID;
                break;
            case 2: //company name
//                $arrayCompanyID = array();
//                foreach ($getListApplyJob as $value) {
//                    $arrayCompanyID[] = $value->company_id;
//                }
//                $objListCompany = $this->ClassEmployer->getCompanyInfo(0, 0, " ORDER BY company_name");
//                $arrayMetaQuery = array();
//                foreach ($objListCompany as $value) {
//                    $arrayMetaQuery[] = array(
//                        'key' => 'company_id',
//                        'value' => $value->id,
//                        'compare' => '='
//                    );
//                }
//                $argc['meta_query'] = array($arrayMetaQuery);
//                if (!$arrayMetaQuery)
//                    return null;
                break;
        }
        return $argc;
    }

    function getArraySubCatLocation()
    {
        $all_cats = get_categories('child_of=' . $this->categoryLocationID . '&hide_empty=0');
        $arrayLocation = array();
        foreach ($all_cats as $value) {
            if ($value->parent) {
                $arrayLocation[] = $value;
            }
        }
        return $arrayLocation;
    }

    function getSubCatLocation($post_id)
    {
        $post_categories = wp_get_post_categories($post_id);
        foreach ($post_categories as $c) {
            $cat = get_category($c);
            if ($cat->category_parent == $this->categoryLocationID) {
                $job_location['name'] = $cat->name;
                $job_location['link'] = get_category_link($cat->term_id);
            }
        }
        return empty($job_location) ? false : "<a href='$job_location[link]'>$job_location[name]</a>";
    }

    public function buildFormQueryJob($user_id, $search = false)
    {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts_per_page = empty($_GET['posts_per_page']) ? 10 : $_GET['posts_per_page'];
        $orderby = empty($_GET['orderby']) ? 10 : $_GET['orderby'];
        $s = empty($_GET['s']) ? '' : $_GET['s'];
        ob_start();
        ?>
        <form method="post" id="frm_query_list_job">
            <input type="hidden" name="paged" value="<?php echo $paged; ?>">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <?php if ($search) : ?>
                <input type="hidden" name="s" value="<?php echo $s; ?>">
            <?php endif; ?>
            <div class="col-md-3 no-padding">
                <span class="pull-left">Positions</span>
                <select name="posts_per_page"
                        onchange="$('#frm_query_list_job').submit();"
                        class="pull-left form-control">
                    <option value="10" <?php echo $posts_per_page == '10' ? 'selected' : ''; ?>>10</option>
                    <option value="50" <?php echo $posts_per_page == '50' ? 'selected' : ''; ?>>50</option>
                    <option value="100" <?php echo $posts_per_page == '100' ? 'selected' : ''; ?>>100</option>
                    <option value="-1" <?php echo $posts_per_page == '-1' ? 'selected' : ''; ?>>All</option>
                </select>
            </div>
            <div class="col-md-push-6 col-md-3 no-padding">
                <span class="pull-right">Sort by</span><br/>
                <select name="orderby"
                        onchange="$('#frm_query_list_job').submit();"
                        class="pull-right form-control col-md-3">
                    <option value="1" <?php echo $orderby == '1' ? 'selected' : ''; ?>>Last Update
                    </option>
                    <option value="2" <?php echo $orderby == '2' ? 'selected' : ''; ?>>Company Name</option>
                    <option value="3" <?php echo $orderby == '3' ? 'selected' : ''; ?>>Less to more competitive jobs
                    </option>
                    <option value="4" <?php echo $orderby == '4' ? 'selected' : ''; ?>>More to less competitive jobs
                    </option>
                </select>
            </div>
        </form>
        <script>
            $(document).on('submit', "#frm_query_list_job", function () {
                var data = $(this).serialize();
                data += "&" + $.param({
                    query_list_job_post: 'true',
                    type: $("#type_query").val()
                });
                showImgLoading();
                $.ajax({
                    type: "POST",
                    url: '',
                    data: data,
                    success: function (result) {
                        hideImgLoading();
                        $("#job_list").replaceWith(result);
                    },
                    error: function (result) {
                        showModalMessage(result.responseText, "Error");
                        hideImgLoading();
                        check_from_post = false;
                    }
                });
                return false;
            });
        </script>
        <?php
        $strForm = ob_get_contents();
        ob_end_clean();

        return $strForm;
    }

    function buildPagingPostJob($loop)
    {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $strPaging = '<p class="navrechts"><a class="selected">1</a></p>';
        if ($loop->max_num_pages > 1) {
            ob_start();
            ?>
            <p class="navrechts">
                <?php
                for ($i = 1; $i <= $loop->max_num_pages; $i++) {
                    ?>
                    <a href="<?php echo '?paged=' . $i; ?>" <?php echo ($paged == $i) ? 'class="selected"' : ''; ?>><?php echo $i; ?></a>
                <?php
                }
                if ($paged != $loop->max_num_pages) {
                    ?>
                    <a href="<?php echo '?paged=' . $i; //next link ?>">></a>
                <?php } ?>
            </p>
            <?php
            $strPaging = ob_get_contents();
            ob_end_clean();
        }
        return $strPaging;
    }

    function buildListJob($argc, $paging = true, $showEdit = false)
    {
        if (is_array($argc) || !$argc)
            $loopJobs = new WP_Query($argc);
        else
            $loopJobs = $this->wpdb->get_results($argc);
        ob_start();
        ?>

        <div id="job_list">

            <?php if ($loopJobs->have_posts()):
                ?>
                <ul class="job-list no-padding">
                    <?php while ($loopJobs->have_posts()) :
                        $loopJobs->the_post();
                        $postID = get_the_id();
                        $url = wp_get_attachment_url(get_post_thumbnail_id($postID));
                        if (empty($url)) {
                            $thumbnail = get_template_directory_uri() . "/libs/img/blank-logo.png";
                        } else {
                            $thumbnail = $url;
                        }
                        $customField = get_post_custom($postID);
                        $job_type = empty($customField["job_type"][0]) ? '' : $customField["job_type"][0];
//                        $job_location = empty($customField["job_location"][0]) ? '' : $customField["job_location"][0];
                        $company_id = empty($customField["company_id"][0]) ? '' : $customField["company_id"][0];
                        $getDataCompany = $company_id ? $this->ClassEmployer->getCompanyInfo($company_id) : false;
                        $company_name = $getDataCompany ? $getDataCompany[0]->company_name : "";
                        $job_location = $this->getSubCatLocation($postID);
                        ?>
                        <li class="clearfix border-bottom-1-ddd padding-top-10 padding-bottom-10">
                            <div class="col-md-12">
                                <div class="col-md-2" style="padding: 0px">
                                    <a href="<?php the_permalink(); ?>" target="_blank"><img
                                            src="<?php echo $thumbnail; ?>"
                                            style="width: 100%;"/></a>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="font-color-BF2026">
                                        <a href="<?php the_permalink(); ?>"
                                           target="_blank"><?php the_title(); ?></a>
                                    </h5>
                                    <?php echo empty($company_name) ? "" : $company_name; ?><br/>
                                    <?php echo empty($job_type) ? "" : $job_type; ?><br/>
                                </div>
                                <div class="col-md-2">
                                    <?php the_date('M d, Y'); ?><br/>
                                    <?php echo empty($job_location) ? "" : $job_location . "<br/>"; ?>
                                    <?php if ($showEdit): ?>
                                        <a class="btn btn-primary"
                                           onclick="loadPostJob(<?php echo $postID; ?>);">Edit</a>
                                        <a class="btn btn-danger" onclick="deletePostJob(<?php echo $postID; ?>);">Delete</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <?php
                if ($paging)
                    echo $this->buildPagingPostJob($loopJobs); ?>
            <?php else: ?>
                <div class="no-padding">Not result</div>
            <?php endif; ?>
            <hr/>
        </div>
        <?php
        $strContent = ob_get_contents();
        ob_end_clean();
        return $strContent;
    }

    function buildHighlightJobs()
    {
        $argc = $this->queryHighlightJobs(-1);
        $loopHighlightJobs = new WP_Query($argc);
        $i = 0;
        ob_start();
        if ($loopHighlightJobs->have_posts()):
            ?>

            <ul class="job-list" style="padding: 0px;">
                <?php while ($loopHighlightJobs->have_posts()) :
                    $loopHighlightJobs->the_post();
                    $postID = get_the_id();
                    $url = wp_get_attachment_url(get_post_thumbnail_id($postID));
                    if (empty($url)) {
                        $thumbnail = get_template_directory_uri() . "/libs/img/blank-logo.png";
                    } else {
                        $thumbnail = $url;
                    }
                    $customField = get_post_custom($postID);
                    $job_type = empty($customField["job_type"][0]) ? '' : $customField["job_type"][0];
                    $job_location = $this->getSubCatLocation($postID);
                    ?>
                    <?php if ($i % 4 == 0 && $i > 0): ?>
                    <div class="item">
                    <ul class="job-list" style="padding: 0px;">
                <?php else: ?>
                    <li class="col-md-6 clearfix">
                        <div class="col-md-4" style="padding: 0px;">
                            <a href="<?php the_permalink(); ?>" target="_blank"><img
                                    src="<?php echo $thumbnail; ?>"
                                    style="width: 100%"/></a>
                        </div>
                        <div class="col-md-8" style="padding: 0 0 0 10px;">
                            <h4 style="font-size: 14px !important; color: #BF2026"><a
                                    href="<?php the_permalink(); ?>"
                                    target="_blank"><?php the_title(); ?></a></h4>

                            <p class="font-size-12">
                                <span class="font-color-4D94CC"><?php echo $job_location; ?></span><br/>
                                <?php echo $job_type; ?><br/>
                                <?php the_date('d F, Y'); ?>
                            </p>
                        </div>
                    </li>
                <?php endif; ?>

                    <?php if ($i % 4 == 0 && $i > 0): ?>
                    </ul>
                    </div>
                <?php endif; ?>

                    <?php $i++;
                endwhile;?>

            </ul> <?php
        endif;
        $strContent = ob_get_contents();
        ob_end_clean();
        return $strContent;

    }

}