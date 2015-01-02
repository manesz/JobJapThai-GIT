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
    private $ClassFavorite = null;
    private $ClassApply = null;
    private $ClassEmployer = null;

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
        $this->ClassFavorite = new Favorite($wpdb);
        $this->ClassApply = new Apply($wpdb);
        $this->ClassEmployer = new Employer($wpdb);
    }

    public function queryFavoriteJob($user_id)
    {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts_per_page = empty($_GET['posts_per_page']) ? 10 : $_GET['posts_per_page'];
        $orderby = empty($_GET['orderby']) ? 1 : $_GET['orderby'];

        $getListFavJob = $this->ClassFavorite->listFavJob(0, 0, $user_id);
        $argc = array(
            'post_type' => 'job',
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
            'post_type' => 'job',
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
                $objListCompany = $this->ClassEmployer->getCompanyInfo($arrayCompanyID, 0, " ORDER BY company_name");

                $arrayListJobID = array();
                foreach ($objListCompany as $value1) {
                    foreach ($getListApplyJob as $value2) {
                        if ($value1->employer_id == $value2->company_id) {
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
            $(document).on('submit', "#frm_query_list_job", function(){
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
                            alert("Error:\n" + result.responseText);
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

    function buildListJob($argc)
    {
        $loopJobs = new WP_Query($argc);
        ob_start();
        if ($loopJobs->have_posts()):
            ?>
            <ul id="job_list" class="job-list no-padding">
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
                    $job_location = empty($customField["job_location"][0]) ? '' : $customField["job_location"][0];
                    $company_id = empty($customField["company_id"][0]) ? '' : $customField["company_id"][0];
                    $getDataCompany = $company_id ? $this->ClassEmployer->getCompanyInfo($company_id) : false;
                    $company_name = $getDataCompany ? $getDataCompany[0]->company_name : "";
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
                                <br/><?php the_date('M d, Y'); ?><br/>
                                <?php echo empty($job_location) ? "" : $job_location; ?><br/>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
            <hr/>
            <?php
            echo $this->buildPagingPostJob($loopJobs); ?>
        <?php endif;
        $strContent = ob_get_contents();
        ob_end_clean();
        return $strContent;
    }
}