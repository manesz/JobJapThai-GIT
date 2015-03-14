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
            //                'key' => 'employer_id',
            //                'value' => $employer_id,
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
                $arrayEmployerID = array();
                foreach ($getListFavJob as $value) {
                    $arrayEmployerID[] = $value->employer_id;
                }
                $objListCompany = $this->ClassEmployer->getCompanyInfo(0, $arrayEmployerID, " ORDER BY company_name");

                $arrayListJobID = array();
                foreach ($objListCompany as $value1) {
                    foreach ($getListFavJob as $value2) {
                        if ($value1->id == $value2->employer_id) {
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

    function queryFavoriteEmployer($user_id)
    {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts_per_page = empty($_GET['posts_per_page']) ? 10 : $_GET['posts_per_page'];
        $orderby = empty($_GET['orderby']) ? 1 : $_GET['orderby'];

        $getListFavJob = $this->ClassFavorite->listFavEmployer(0, 0, $user_id);
        return $getListFavJob;
        $argc = array(
            'post_type' => $this->postType,
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            //        'meta_query' => array(
            //            array(
            //                'key' => 'employer_id',
            //                'value' => $employer_id,
            //                'compare' => '='
            //            )
            //
            //        ),
        );

        switch ($orderby) {
            case 1: //last update
                $arrayListJobID = array();
                foreach ($getListFavJob as $value) {
                    $arrayListJobID[] = $value->employer_id;
                }
                if (!$arrayListJobID)
                    return null;
                $argc['orderby'] = 'modified';
                $argc['order'] = 'DESC';
                $argc['post__in'] = $arrayListJobID;
                break;
            case 2: //company name
                $arrayEmployerID = array();
                foreach ($getListFavJob as $value) {
                    $arrayEmployerID[] = $value->employer_id;
                }
                $objListCompany = $this->ClassEmployer->getCompanyInfo(0, $arrayEmployerID, " ORDER BY company_name");

                $arrayListJobID = array();
                foreach ($objListCompany as $value1) {
                    foreach ($getListFavJob as $value2) {
                        if ($value1->id == $value2->employer_id) {
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

    function queryApplyJob($user_id)
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
                $arrayEmployerID = array();
                foreach ($getListApplyJob as $value) {
                    $arrayEmployerID[] = $value->employer_id;
                }
                $objListCompany = $this->ClassEmployer->getCompanyInfo(0, 0, " ORDER BY company_name");
                $arrayMetaQuery = array();
                foreach ($objListCompany as $value) {
                    $arrayMetaQuery[] = array(
                        'key' => 'employer_id',
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
                $arrayEmployerID = array();
//                foreach ($getListApplyJob as $value) {
//                    $arrayEmployerID[] = $value->employer_id;
//                }
//                $objListCompany = $this->ClassEmployer->getCompanyInfo(0, 0, " ORDER BY company_name");
//                $arrayMetaQuery = array();
//                foreach ($objListCompany as $value) {
//                    $arrayMetaQuery[] = array(
//                        'key' => 'employer_id',
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
                $arrayEmployerID = array();
//                foreach ($getListApplyJob as $value) {
//                    $arrayEmployerID[] = $value->employer_id;
//                }
//                $objListCompany = $this->ClassEmployer->getCompanyInfo(0, 0, " ORDER BY company_name");
//                $arrayMetaQuery = array();
//                foreach ($objListCompany as $value) {
//                    $arrayMetaQuery[] = array(
//                        'key' => 'employer_id',
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
                $arrayEmployerID = array();
                foreach ($getListCompanyInfo as $value) {
                    $arrayEmployerID[] = $value->employer_id;
                }
//                $objListCompany = $this->ClassEmployer->getCompanyInfo();
//
//                $arrayListJobID = array();
//                foreach ($objListCompany as $value1) {
//                    foreach ($getListCompanyInfo as $value2) {
//                        if ($value1->employer_id == $value2->employer_id) {
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

    function countPostJob($user_id)
    {
//        $getCompanyInfo = $this->ClassEmployer->getCompanyInfo(0, $user_id);
        $employer_id = $user_id;
        $argc = array(
            'post_type' => $this->postType,
            'post_status' => 'publish',
//            'posts_per_page' => $posts_per_page,
            'meta_key' => 'employer_id',
            'meta_value' => $employer_id,
//            'paged' => $paged
        );
        $my_query = new WP_Query($argc);
        $count = $my_query->post_count;
        return $count;
    }

    function queryPostJob($user_id)
    {
//        $getCompanyInfo = $this->ClassEmployer->getCompanyInfo(0, $user_id);
        $employer_id = $user_id;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts_per_page = empty($_GET['posts_per_page']) ? 10 : $_GET['posts_per_page'];
        $orderby = empty($_GET['orderby']) ? 1 : $_GET['orderby'];
        $argc = array(
            'post_type' => $this->postType,
            'post_status' => array('draft', 'publish'),
            'posts_per_page' => $posts_per_page,
            'meta_key' => 'employer_id',
            'meta_value' => $employer_id,
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
//                $arrayEmployerID = array();
//                foreach ($getListApplyJob as $value) {
//                    $arrayEmployerID[] = $value->employer_id;
//                }
//                $objListCompany = $this->ClassEmployer->getCompanyInfo(0, 0, " ORDER BY company_name");
//                $arrayMetaQuery = array();
//                foreach ($objListCompany as $value) {
//                    $arrayMetaQuery[] = array(
//                        'key' => 'employer_id',
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

    function buildFormQueryJob($user_id, $search = false, $show_edit = false)
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
            <input type="hidden" name="show_edit" value="<?php echo $show_edit ? "true" : ""; ?>">
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
        global $wpdb;
        if (!$showEdit) {
            $showEdit = empty($_REQUEST['show_edit']) ? false : $_REQUEST['show_edit'];
        }
        if (is_array($argc) || !$argc)
            $loopJobs = new WP_Query($argc);
        else
            $loopJobs = $this->wpdb->get_results($argc);
        $classCandidate = new Candidate($wpdb);
        $classEmployer = new Employer($wpdb);
        $classPackage = new Package($wpdb);
        ob_start();
        ?>

        <div id="job_list">

            <?php if ($loopJobs->have_posts()):
                ?>
                <ul class="job-list no-padding">
                    <?php while ($loopJobs->have_posts()) :
                        $loopJobs->the_post();
                        $postID = get_the_id();
                        $customField = get_post_custom($postID);
                        $dateCreate = $classPackage->getDateCreateJob($postID);
                        $dayDisplay = $classPackage->getDayDisplay($postID);
                        $checkDisplayPost = $classPackage->checkDisplayJob($dateCreate, $dayDisplay);
                        $employer_id = empty($customField["employer_id"][0]) ? '' : $customField["employer_id"][0];
                        $getPostStatus = get_post_status($postID);
                        $getHavePackage = $classPackage->checkHavePackage($employer_id);
                        $getTotalPostJob = $classPackage->getTotalPost($employer_id);
                        if ($checkDisplayPost && $employer_id || $showEdit):
                            $getLogo = $classEmployer->getLogoPath($employer_id);
                            if ($getLogo['have_image']) {
                                $thumbnail = $getLogo['path'];
                            } else {
                                $thumbnail = get_template_directory_uri() . "/libs/img/blank-logo.png";
                            }
                            $job_type = empty($customField["job_type"][0]) ? '' : $customField["job_type"][0];
//                        $job_location = empty($customField["job_location"][0]) ? '' : $customField["job_location"][0];
                            $getDataCompany = $employer_id ? $this->ClassEmployer->getCompanyInfo(0, $employer_id) : false;
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
                                    <div class="col-md-8 position">
                                        <h5 class="font-color-BF2026">
                                            <a href="<?php the_permalink(); ?>" class="<?php
                                            if ($showEdit) {
                                                if ($getPostStatus == 'publish')
                                                    echo "font-color-4BB748";
                                                else
                                                    echo "font-color-999";
                                            } else {
                                                echo "font-color-BF2026";
                                            }
                                            ?>"
                                               target="_blank"><?php the_title(); ?>
                                                <?php if ($showEdit):
                                                    if ($checkDisplayPost):
                                                        ?>
                                                        <span
                                                            class="font-color-4BB748 glyphicon glyphicon-ok"></span>
                                                    <?php else: ?><span
                                                        class="glyphicon glyphicon-remove"></span>
                                                    <?php endif;endif; ?>
                                            </a>
                                        </h5>
                                        <?php echo empty($company_name) ? "" : "<a target='_blank' href='company-profile/?id=$employer_id'>$company_name</a>"; ?>
                                        <br/>
                                        <?php echo empty($job_type) ? "" : $job_type; ?><br/>
                                        <?php if ($showEdit): ?>
                                            <a class="btn btn-primary" title="Edit"
                                               onclick="loadPostJob(<?php echo $postID; ?>);"><span
                                                    class="glyphicon glyphicon-pencil"></span></a>
                                            <a title="Delete"
                                               class="btn btn-danger" onclick="deletePostJob(<?php echo $postID; ?>);">
                                                <span class="glyphicon glyphicon-trash"></span></a>
                                            <a class="btn btn-info"
                                               onclick="changeStatusJob(<?php echo $postID; ?>,
                                                   '<?php echo $getPostStatus == "publish" ? "draft" : "publish"; ?>');"><?php
                                                if ($getPostStatus == "publish")
                                                    echo "Draft";
                                                else echo "Published";
                                                ?></a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-2">
                                        <?php echo get_the_date('M d, Y', $postID); ?><br/>
                                        <?php echo empty($job_location) ? "" : $job_location . "<br/>"; ?>

                                        <?php if ($showEdit && !$checkDisplayPost && $getHavePackage && $getTotalPostJob > 0): ?>
                                            <a title="Add Package" onclick="setPackageForJob(<?php echo $postID; ?>);"
                                               class="btn btn-success">Add Package To Job</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endif; ?>
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

    function buildListEmployer($data)
    {
        $showEdit = false;
//        if (!$showEdit) {
//            $showEdit = empty($_REQUEST['show_edit'])? false: $_REQUEST['show_edit'];
//        }
//        if (is_array($argc) || !$argc)
//            $loopJobs = new WP_Query($argc);
//        else
//            $loopJobs = $this->wpdb->get_results($argc);
        ob_start();
        ?>

        <div id="job_list">

            <?php if ($data):
                ?>
                <ul class="job-list no-padding">
                    <?php foreach ($data as $key => $value):
                        $thumbnail = "";
                        ?>
                        <li class="clearfix border-bottom-1-ddd padding-top-10 padding-bottom-10">
                            <div class="col-md-12">
                                <div class="col-md-2" style="padding: 0px">
                                    <a href="<?php echo home_url(); ?>/company-profile?id=<?php echo $value->employer_id; ?>"
                                       target="_blank"><img
                                            src="<?php echo $thumbnail; ?>"
                                            style="width: 100%;"/></a>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="font-color-BF2026">
                                        <a href="<?php echo home_url(); ?>/company-profile?id=<?php echo $value->employer_id; ?>"
                                           target="_blank"><?php echo $value->company_name; ?></a>
                                    </h5>
                                </div>
                                <div class="col-md-2">
                                    <?php echo date_i18n('M d, Y', strtotime($value->fav_time)); ?><br/>
                                    <?php echo empty($job_location) ? "" : $job_location . "<br/>"; ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
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
        $classPackage = new Package($this->wpdb);
        $classEmployer = new Employer($this->wpdb);
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
                    $customField = get_post_custom($postID);

                    $dateCreate = $classPackage->getDateCreateJob($postID);
                    $dayDisplay = $classPackage->getDayDisplay($postID);
                    $checkDisplayPost = $classPackage->checkDisplayJob($dateCreate, $dayDisplay);
                    $employer_id = empty($customField["employer_id"][0]) ? '' : $customField["employer_id"][0];

                    if ($checkDisplayPost && $employer_id):
                        $getLogo = $classEmployer->getLogoPath($employer_id);
                        if ($getLogo['have_image']) {
                            $thumbnail = $getLogo['path'];
                        } else {
                            $thumbnail = get_template_directory_uri() . "/libs/img/blank-logo.png";
                        }


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