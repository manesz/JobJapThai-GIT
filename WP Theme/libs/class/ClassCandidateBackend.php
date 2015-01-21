<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19/1/2558
 * Time: 11:20 น.
 */


if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}
if (!class_exists('Candidate')) {
    require_once('ClassCandidate.php');
}

class Candidate_List extends WP_List_Table
{

    var $candidate_data = null;
    var $check_add_payment = true;

    function __construct()
    {
        global $status, $page, $wpdb;

        parent::__construct(array(
            'singular' => __('book', 'mylisttable'), //singular name of the listed records
            'plural' => __('books', 'mylisttable'), //plural name of the listed records
            'ajax' => true //does this table support ajax?

        ));
        add_action('admin_head', array(&$this, 'admin_header'));

        $classCandidate = new Candidate($wpdb);
        $this->candidate_data = array();
        $result = $classCandidate->getListUser();
        $siteUrl = home_url();
        foreach ($result as $key => $value) {
            $strEdit = '<a href="?page=candidate-list&candidate-edit=true&id=' . $value->ID . '">Edit</a> |
            <a class="btn_delete_candidate" href="#" pm-id="' . $value->ID . '">Delete</a> ';
            if ($this->searchInArray((array)$value))
                $this->candidate_data[] = array(
                    "id" => $value->ID,
                    "count" => $key + 1,
                    "name" => "<a href='?page=candidate-list&candidate_page_type=edit&candidate_id=$value->ID'
                >$value->title $value->first_name $value->last_name</a>",
                    "user_login" => $value->user_login,
//                "user_nicename" => $value->user_nicename,
                    "email" => $value->user_email,
                    "fav_job" => '<a href="' . $siteUrl . '/wp-admin/post-new.php?post_type=job&candidate_id=' . $value->can_id . '">view</a>',
                    "apply_job" => '<a href="?page=candidate-list&candidate-edit=true&id=' . $value->ID . '">view</a>',
                    "edit" => $strEdit,
                );
        }

    }

    function searchInArray($data)
    {
        $search = empty($_REQUEST['s']) ? false : $_REQUEST['s'];
        if (!$search)
            return true;
        $haystack = $search;
        $needle = array_values($data);
        $offset = 1;
        if (!is_array($needle)) $needle = array($needle);
        foreach ($needle as $query) {
            if (strpos($query, $haystack) !== false)
                return true; // stop on first true result
        }
        return false;
    }

    function admin_header()
    {
        $page = (isset($_GET['page'])) ? esc_attr($_GET['page']) : false;
        if ('candidate-list' != $page && 'candidate-list-na' != $page)
            return;
        ?>
        <style type="text/css">
            .wp-list-table .column-id {
                width: 1%;
            }

            .wp-list-table .column-count {
                width: 5%;
            }

            .wp-list-table .column-room_name {
                width: 15%;
            }

            /*.wp-list-table .column-candidate_date { width: 10%; }*/
            .wp-list-table .column-name {
                width: 15%;
            }

            /*.wp-list-table .column-email {
                width: 15%;
            }

            .wp-list-table .column-tel {
                width: 10%;
            }*/

            .wp-list-table .column-check_in_date {
                width: 5%;
            }

            .wp-list-table .column-check_out_date {
                width: 5%;
            }

            .wp-list-table .column-adults {
                width: 4%;
            }

            .wp-list-table .column-need_airport_pickup {
                width: 4%;
            }

            .wp-list-table .column-timeout {
                width: 10%;
            }

            .wp-list-table .column-paid {
                width: 5%;
            }

            .wp-list-table .column-pm_create_time {
                width: 10%;
            }

            .wp-list-table .column-edit {
                width: 10%;
            }

            .clock {
                zoom: 0.23;
                -moz-transform: scale(0.5)
            }
        </style>
        <!--        <script type="text/javascript"-->
        <!--                src="--><?php //bloginfo('template_directory'); ?><!--/library/js/candidate_edit.js"></script>-->

        <!--        <link rel="stylesheet" href="--><?php //bloginfo('template_directory'); ?><!--/library/css/flip-clock/flipclock.css">-->
        <!--        <script src="--><?php //bloginfo('template_directory'); ?><!--/library/js/flip-clock/flipclock.js"></script>-->
    <?php
    }

    function no_items()
    {
        _e('No candidate found, dude.');
    }

    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'count':
            case 'name':
            case 'user_login':
//            case 'candidate_date':
//            case 'user_nicename':
//            case 'passport_no':
            case 'email':
            case 'fav_job':
            case 'apply_job':
            case 'edit':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'count' => array('count', true),
            'name' => array('name', true),
            'user_login' => array('user_login', true),
//            'candidate_date' => array('candidate_date', true),
//            'user_nicename' => array('user_nicename', true),
//            'check_in_date' => array('check_in_date', true),
//            'check_out_date' => array('check_out_date', true),
////            'passport_no' => array('passport_no', false),
            'email' => array('email', true),
//            'fav_job' => array('fav_job', false),
//            'apply_job' => array('apply_job', false),
        );
        return $sortable_columns;
    }

    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'count' => __('#', 'mylisttable'),
            'name' => __('Name', 'mylisttable'),
            'user_login' => __('Login name', 'mylisttable'),
//            'candidate_date' => __('Candidate Date', 'mylisttable'),
//            'user_nicename' => __('Nicename', 'mylisttable'),
//            'passport_no' => __('Passport', 'mylisttable'),
            'email' => __('Email', 'mylisttable'),
            'fav_job' => __('Favorite Job', 'mylisttable'),
            'apply_job' => __('Apply Job', 'mylisttable'),
            'edit' => __('Edit', 'mylisttable'),
        );
        return $columns;
    }

    function usort_reorder($a, $b)
    {
        // If no sort, default to title
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'id';
        // If no order, default to asc
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'desc';
        // Determine sort order
        $result = strcmp($a[$orderby], $b[$orderby]);
        // Send final sort direction to usort
        return ($order === 'asc') ? $result : -$result;
    }

    function column_booktitle($item)
    {
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&book=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
            'delete' => sprintf('<a href="?page=%s&action=%s&book=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
        );

        return sprintf('%1$s %2$s', $item['pm_create_time'], $this->row_actions($actions));
    }

    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="book[]" value="%s" />', $item['id']
        );
    }

    function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        usort($this->candidate_data, array(&$this, 'usort_reorder'));

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = count($this->candidate_data);

        // only ncessary because we have sample data
        $this->found_data = array_slice($this->candidate_data, (($current_page - 1) * $per_page), $per_page);

        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page //WE have to determine how many items to show on a page
        ));
        $this->items = $this->found_data;
    }

    function candidateAddTemplate()
    {
        global $wpdb;
        $classCandidate = new Candidate($wpdb);
        $userID = empty($_GET['candidate_id']) ? 0 : $_GET['candidate_id'];

        $isLogin = false;
        if ($userID) {
            $isLogin = true;

        }
        ?>

        <style type="text/css">
            .blockDiv {
                position: absolute;
                top: 0px;
                left: 0px;
                background-color: #FFF;
                width: 0px;
                height: 0px;
                z-index: 9998;
            }

            .img_loading {
                position: fixed;
                top: 40%;
                left: 50%;
                z-index: 9999;
            }
        </style>
        <link rel="stylesheet" type="text/css"
              href="<?php echo get_template_directory_uri(); ?>/libs/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/libs/css/style.css"/>
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/jquery.1.11.1.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrap.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrapValidator.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/header.js"></script>
        <div class="wrap"><h2><?php echo $isLogin ? "Edit" : "Add New"; ?> Candidate</h2>


            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/libs/css/jasny-bootstrap.min.css">
            <!-- Latest compiled and minified JavaScript -->
            <script src="<?php echo get_template_directory_uri(); ?>/libs/js/jasny-bootstrap.min.js"></script>
            <script>
                var site_url = '<?php echo get_site_url(); ?>/';
                var is_login = <?php echo $isLogin ? 'true': 'false'; ?>;
                var post_type = '<?php echo $isLogin ? 'edit': 'add'; ?>';
                var candidate_id = <?php echo $userID; ?>;

                var url_post = "<?php echo home_url(); ?>/";
                var str_loading = '<div class="img_loading"><img src="<?php
    bloginfo('template_directory'); ?>/libs/images/loading.gif" width="40"/></div>';
            </script>

            <script src="<?php echo get_template_directory_uri(); ?>/libs/js/candidate.js"></script>
            <section class="container-fluid" style="margin-top: 10px;">

                <div class="container wrapper">
                    <div class="row">
                        <div class="col-md-8">
                            <?php if ($isLogin) {
                                echo $classCandidate->buildHtmlEditProfile1($userID, true);
                            } ?>
                            <div class="clearfix"
                                 style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">

                                <div class="clearfix" style="margin-top: 20px;"></div>
                                <div id="show_message" class="col-md-12">
                                </div>
                                <?php if (!$isLogin): ?>

                                    <?php echo $classCandidate->buildHtmlFormRegister(); ?>
                                <?php else: ?>
                                    <?php echo $classCandidate->buildHtmlEditProfile2($userID, true); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

            <style type="text/css">
                #sectProfile {
                    padding-top: 10px
                }
            </style>
            <script>
                is_page_backend = true;
                function toggleChevron(e) {
                    $(e.target)
                        .prev('.panel-heading')
                        .find("i.indicator")
                        .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
                }
                //    $('.in').collapse({hide: true});
                // in cadidate register page
            </script>
        </div>
        <div class="modal fade" id="modal_show_message" tabindex="-1" role="dialog"
             aria-labelledby="myModalMassage" aria-hidden="true"
             style="font-size: 12px;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalMassage">Error</h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

} //class

