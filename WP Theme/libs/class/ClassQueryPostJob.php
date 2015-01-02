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

        switch($orderby) {
            case 1://last update
                $arrayListJobID = array();
                foreach($getListFavJob as $value){
                    $arrayListJobID[] = $value->job_id;
                }
                if (!$arrayListJobID)
                    return null;
                $argc['orderby'] = 'modified';
                $argc['order'] = 'DESC';
                $argc['post__in'] = $arrayListJobID;
                break;
            case 2://company name
                $arrayCompanyID = array();
                foreach($getListFavJob as $value){
                    $arrayCompanyID[] = $value->company_id;
                }
                $objListCompany = $this->ClassEmployer->getCompanyInfo($arrayCompanyID, 0, " ORDER BY company_name");

                $arrayListJobID = array();
                foreach($objListCompany as $value1) {
                   foreach($getListFavJob as $value2) {
                     if ($value1->id == $value2->company_id) {
                         $arrayListJobID[] = $value2->job_id;
                     }  
                   } 
                }var_dump($arrayCompanyID);
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

        switch($orderby) {
            case 1://last update
                $arrayListJobID = array();
                foreach($getListApplyJob as $value){
                    $arrayListJobID[] = $value->job_id;
                }
                $argc['orderby'] = 'modified';
                $argc['order'] = 'DESC';
                $argc['post__in'] = $arrayListJobID;
                break;
            case 2://company name
                $arrayCompanyID = array();
                foreach($getListApplyJob as $value){
                    $arrayCompanyID[] = $value->company_id;
                }
                $objListCompany = $this->ClassEmployer->getCompanyInfo($arrayCompanyID, 0, " ORDER BY company_name");

                $arrayListJobID = array();
                foreach($objListCompany as $value1) {
                    foreach($getListApplyJob as $value2) {
                        if ($value1->employer_id == $value2->company_id) {
                            $arrayListJobID[] = $value2->job_id;
                        }
                    }
                }
                $argc['post__in'] = $arrayListJobID;
                break;
        }
        return $argc;
    }

    public function buildFormQueryJob()
    {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts_per_page = empty($_GET['posts_per_page']) ? 10 : $_GET['posts_per_page'];
        $orderby = empty($_GET['orderby']) ? 10 : $_GET['orderby'];
        ob_start();
        ?>
        <form method="get" id="frm_query">
            <input type="hidden" name="paged" value="<?php echo $paged; ?>">

            <div class="col-md-3 no-padding">
                <span class="pull-left">Positions</span>
                <select name="posts_per_page"
                        onchange="$('#frm_query').submit();"
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
                        onchange="$('#frm_query').submit();"
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
}