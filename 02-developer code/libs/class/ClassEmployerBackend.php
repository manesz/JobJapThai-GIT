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
if (!class_exists('Employer')) {
    require_once('ClassEmployer.php');
}

class Employer_List extends WP_List_Table
{

    var $employer_data = null;
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

        $classEmployer = new Employer($wpdb);
        $this->employer_data = array();
        $result = $classEmployer->getListUser();
        $siteUrl = home_url();
        foreach ($result as $key => $value) {
            if ($this->searchInArray((array)$value))
                $this->employer_data[] = array(
                    "id" => $value->ID,
                    "count" => $key + 1,
                    "company_name" => "<a href='?page=employer-list&employer_page_type=edit&employer_id=$value->ID'>$value->company_name</a>",
                    "user_login" => $value->user_login,
                    "user_nicename" => $value->user_nicename,
                    "email" => $value->user_email,
                    "create_time" => $value->create_datetime,
                    "update_time" => $value->update_datetime,
                    //"add_job" => '<a href="' . $siteUrl . '/wp-admin/post-new.php?post_type=job&employer_id=' . $value->com_id . '">add</a>',
                    //"view_job" => '<a href="edit.php?post_type=job&employer_id=' . $value->com_id . '">view</a>',
                    "edit" => '<a class="btn_delete_employer" href="#" pm-id="' . $value->ID . '">Delete</a>',
                );
        }
        /*foreach ($result as $key => $value) {
            $permalink = get_permalink($value->room_id);
            $checkTimeOut = $classEmployer->checkTimeOut($value->pm_create_time, $value->timeout);
            $paid = $value->paid;
            if (!$checkTimeOut || $paid) {
                $strShowPaidField = $paid ? '<input type="checkbox" checked onclick="return setApprove(this, ' .
                    $value->payment_id . ');" />'
                    : '<input type="checkbox" onclick="return setApprove(this, ' . $value->payment_id .
                    ');" />';
            } else {
                $strShowPaidField = "Time Out";
            }
            $strShowTime = '<div class="clock" date-create="' .
                $value->create_time . '" timeout="' . $value->timeout . '" paid="' . $value->paid . '"></div>';
            $strEdit = '<a href="?page=employer-list&employer-edit=true&id=' . $value->payment_id . '">Edit</a> |';
            $strDelete = '<a class="btn_delete_employer" href="#" pm-id="' . $value->payment_id . '">Delete</a> ';
//            if ($checkAddData)
            $this->employer_data[] = array(
                'id' => $value->id,
                'count' => $value->payment_id,
                'room_name' => "<a href='$permalink' target='_blank'>$value->room_name</a>",
//                'employer_date' => $value->employer_date,
                'name' => $value->name ? "$value->name $value->last_name" : '-',
//                'passport_no' => $value->passport_no,
//                'email' => $value->email,
//                'tel' => $value->tel,
                'check_in_date' => $value->check_in_date,
                'check_out_date' => $value->check_out_date,
                'adults' => $value->adults,
                'need_airport_pickup' => $value->need_airport_pickup ? 'YES' : 'NO',
//                'price'=>number_format($value->total),
//                    'timeout' => $strShowTime,
//                    'paid' => $strShowPaidField,
                'pm_create_time' => $value->pm_create_time,
                'edit' => $strEdit . $strDelete,
            );
        }*/

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
        if ('employer-list' != $page && 'employer-list-na' != $page)
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

            /*.wp-list-table .column-employer_date { width: 10%; }*/
            .wp-list-table .column-name {
                width: 5%;
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
        <!--                src="--><?php //bloginfo('template_directory'); ?><!--/library/js/employer_edit.js"></script>-->

        <!--        <link rel="stylesheet" href="--><?php //bloginfo('template_directory'); ?><!--/library/css/flip-clock/flipclock.css">-->
        <!--        <script src="--><?php //bloginfo('template_directory'); ?><!--/library/js/flip-clock/flipclock.js"></script>-->
    <?php
    }

    function no_items()
    {
        _e('No employer found, dude.');
    }

    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'count':
            case 'company_name':
            case 'user_login':
//            case 'employer_date':
            case 'user_nicename':
//            case 'passport_no':
            case 'email':
            case 'create_time':
            case 'update_time':
//            case 'add_job':
//            case 'view_job':
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
            'company_name' => array('company_name', true),
            'user_login' => array('user_login', true),
//            'employer_date' => array('employer_date', true),
            'user_nicename' => array('user_nicename', true),
//            'check_in_date' => array('check_in_date', true),
//            'check_out_date' => array('check_out_date', true),
////            'passport_no' => array('passport_no', false),
            'create_time' => array('create_time', true),
            'update_time' => array('update_time', true),
            'email' => array('email', true),
//            'add_job' => array('add_job', false),
//            'view_job' => array('view_job', false),
        );
        return $sortable_columns;
    }

    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'count' => __('#', 'mylisttable'),
            'company_name' => __('Company name', 'mylisttable'),
            'user_login' => __('Login name', 'mylisttable'),
//            'employer_date' => __('Employer Date', 'mylisttable'),
            'user_nicename' => __('Nicename', 'mylisttable'),
//            'passport_no' => __('Passport', 'mylisttable'),
            'email' => __('Email', 'mylisttable'),
            'create_time' => __('Create', 'mylisttable'),
            'update_time' => __('Update', 'mylisttable'),
//            'add_job' => __('Add Job', 'mylisttable'),
//            'view_job' => __('View Job', 'mylisttable'),
            'edit' => __('Delete', 'mylisttable'),
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
        usort($this->employer_data, array(&$this, 'usort_reorder'));

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = count($this->employer_data);

        // only ncessary because we have sample data
        $this->found_data = array_slice($this->employer_data, (($current_page - 1) * $per_page), $per_page);

        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page //WE have to determine how many items to show on a page
        ));
        $this->items = $this->found_data;
    }

    function employerAddTemplate()
    {
        global $webSiteName, $wpdb;
        $classEmployer = new Employer($wpdb);
        $classQueryPostJob = new QueryPostJob($wpdb);
        $userID = empty($_GET['employer_id']) ? 0 : $_GET['employer_id'];
        $dataEmployer = null;
        if ($userID) {
            $current_user = $classEmployer->getUser($userID);
            $arrayCompanyInfo = $classEmployer->getCompanyInfo(0, $userID);
            if ($arrayCompanyInfo) {
                extract((array)$arrayCompanyInfo[0]);
                $dataEmployer = (array)$arrayCompanyInfo[0];
            }
            $isEdit = true;
        } else {
            $isEdit = false;
        }
        ?>
        </pre>
        <div class="wrap"><h2><?php echo $isEdit ? "Edit" : "Add New"; ?> Employer</h2>
        <link rel="stylesheet" type="text/css"
              href="<?php echo get_template_directory_uri(); ?>/libs/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/libs/css/style.css"/>
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/jquery.1.11.1.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrap.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrapValidator.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/header.js"></script>
        <section class="container-fluid" style="margin-top: 10px;">
            <script>
                var site_url = '<?php echo get_site_url(); ?>/';
                var is_login = <?php echo $isEdit? "true": "false"; ?>;
                var url_post = "<?php echo home_url(); ?>/";
                var str_loading = '<div class="img_loading"><img src="<?php
    bloginfo('template_directory'); ?>/libs/images/loading.gif" width="40"/></div>';
            </script>

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
            <script src="<?php echo get_template_directory_uri(); ?>/libs/js/employer-register.js"></script>

            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/libs/css/jasny-bootstrap.min.css">
            <!-- Latest compiled and minified JavaScript -->
            <script src="<?php echo get_template_directory_uri(); ?>/libs/js/jasny-bootstrap.min.js"></script>

            <script src="<?php echo get_template_directory_uri(); ?>/libs/js/post-job.js"></script>

            <div class="container wrapper">
                <!--<div class="form-group">-->
                <div class="row">
                    <div class="col-md-12">

                        <div class="clearfix"
                             style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">


                            <div class="clearfix" style="margin-top: 20px;"></div>
                            <form action="<?php echo get_site_url(); ?>/apply-employer-register/" method="post"
                                  id="frm_employer_register" class="form-horizontal"
                                  data-bv-message="This value is not valid"
                                  data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                                  data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                                  data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                                <!-- ---------------------------------------------------------------- Section : username -->

                                <input type="hidden" name="employer_id" value="<?php echo $userID; ?>">
                                <input type="hidden" name="employer_post" value="true">
                                <input type="hidden" name="post_type"
                                       value="<?php echo $isEdit ? "edit" : "add"; ?>">
                                <input type="hidden" name="post_backend"
                                       value="true">
                                <h5 class="bg-ddd padding-10 clearfix">Username and Password</h5>


                                <div class="form-group col-md-12">
                                    <div class="col-md-2 text-right clearfix"><label
                                            for="employerUsername">Username<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-10">
                                        <?php if ($isEdit): ?>
                                            <span class="form-control"><?php echo $current_user->user_login; ?></span>
                                        <?php else: ?>
                                            <input type="text" class="form-control"
                                                   maxlength="20"
                                                   data-bv-stringlength="true"
                                                   data-bv-stringlength-min="4"
                                                   data-bv-message="The username is not valid" id="employerUsername"
                                                   name="employerUsername"
                                                   required
                                                   data-bv-notempty-message="The username is required and cannot be empty"
                                                   pattern="^[a-zA-Z0-9]+$"
                                                   data-bv-regexp-message="The username can only consist of alphabetical, number"/>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-2 text-right clearfix"><label for="employerEmail">Email<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-10">

                                        <?php if ($isEdit): ?>
                                            <span class="form-control"><?php echo $current_user->user_email; ?></span>
                                        <?php else: ?>
                                            <input type="email" id="employerEmail" name="employerEmail"
                                                   class="form-control"
                                                   data-bv-emailaddress="true"
                                                   required
                                                   data-bv-emailaddress-message="The input is not a valid email address"/>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-2 text-right clearfix">
                                        <label for="employerPassword">Password<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-10">
                                        <input type="password" id="employerPassword" name="employerPassword"
                                               class="form-control"
                                            <?php echo $isEdit ? '' : 'required'; ?>
                                               data-bv-stringlength="true"
                                               data-bv-stringlength-min="8"/>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <?php if ($isEdit): ?>
                                    <!-- ----------------------------------------------------------------- Section : package -->
                                    <h5 class="bg-ddd padding-10 clearfix">Package</h5>
                                    <div id="list_package">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-12">
                                            <input type="button" class="btn btn-primary col-md-12"
                                                   value="New Package" data-toggle="modal" id="new_package"
                                                   data-target="#modal_package"/>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                <?php endif; ?>

                                <!-- ----------------------------------------- Section : Company information for contact -->
                                <h5 class="bg-ddd padding-10 clearfix">Company information for contact</h5>

                                <?php echo $classEmployer->buildHtmlCompanyInfo($dataEmployer); ?>
                                <div class="form-group col-md-12" style="">
                                    <div id="show_message"></div>
                                    <a type="button" id="btn_success"
                                       style="display: <?php echo $userID ? 'block' : 'none' ?>;"
                                       class="btn btn-success pull-right"
                                       href="?page=employer-list">Finish </a>
                                    <button type="submit" id="btn_submit" class="btn btn-primary pull-right">Submit
                                    </button>
                                    <button type="reset" class="btn btn-default pull-right" style="border: none;">
                                        Reset
                                    </button>
                                    <a type="button" class="btn btn-info pull-right"
                                       href="?page=employer-list">Back </a>
                                </div>

                            </form>

                        </div>


                    <?php if ($userID) $classEmployer->buildPostJob($userID); ?>

                    </div>
                    <!--</div>-->
                </div>
            </div>

        </section>

        <!-- Modal -->
        <div class="modal fade" id="modal_package" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true"
             style="font-size: 12px;">
            <div class="modal-dialog">
                <div class="modal-content">

                </div>
            </div>
        </div>
        <style type="text/css">
            #aupher-select {
                display: none
            }

            #distinct-select {
                display: none
            }
        </style>
        <script type="text/javascript">
            var employer_id = <?php echo $userID; ?>;
            var user_id = <?php echo $userID; ?>;
            var ajaxPageurl = '<?php echo get_home_url() ?>/';
            var ajaxDropurl = '<?php echo get_template_directory_uri() . '/libs/ajax'; ?>/';
            var distinct = <?php echo empty($district) ? 0: $district; ?>;
            var sub_district = <?php echo empty($sub_district) ? 0: $sub_district; ?>;
            var proselect = {
                proval: 0,
                amval: 0,
                init: function () {
                    proselect.proval = $('#employerContactProvince').val();
                    proselect.selectProvince();
                    proselect.setEvent();
                },
                setEvent: function () {
                    $('#employerContactProvince').on('change', proselect.selectProvince);
                },
                selectProvince: function () {
                    proselect.proval = $('#employerContactProvince').val();
                    proselect.clearampporSelect();
                    $('#aupher-select').slideUp('fast', function () {
                        if (proselect.proval !== '0') {
                            $.getJSON(ajaxPageurl + '?adminPage=getamphor&type=provice', {proid: proselect.proval}, function (data) {
                                if (typeof data['hasfile'] === 'undefined') {
                                    proselect.createSelect(data);
                                    $('#aupher-select').slideDown('fast');
                                } else {
                                    $.getJSON(ajaxDropurl + 'amphur/' + proselect.proval + '.json', function (data) {
                                        proselect.createSelect(data);
                                        $('#aupher-select').slideDown('fast');
                                    });
                                }
                            });
                        }
                    });

                },
                createSelect: function (data) {
                    $.each(data, function (index, dat) {
                        var checkSelect = dat.AMPHUR_ID == distinct ? 'selected' : '';
                        var mytxt = '<option value="' + dat.AMPHUR_ID + '" ' + checkSelect + '>' +
                            dat.AMPHUR_NAME + '</option>';
                        $('#employerContactDistinct').append(mytxt);
                    });
                    if ($('#employerContactDistinct').html()) {
                        proselect.selectAmphor();
                    }
                    $('#employerContactDistinct').unbind('change');
                    $('#employerContactDistinct').on('change', proselect.selectAmphor);
                },
                clearampporSelect: function () {
                    $('#employerContactDistinct option[value!=0]').remove();
                    $('#employerContactDistinct').val(0);
                    proselect.clearDistinctSelect();
                },
                clearDistinctSelect: function () {
                    $('#employerContactSubDistinct option[value!=0]').remove();
                    $('#employerContactSubDistinct').val(0);
                    $('#distinct-select').css('display', 'none');
                },
                selectAmphor: function () {
                    proselect.amval = $('#employerContactDistinct').val();
                    proselect.clearDistinctSelect();
                    $('#distinct-select').slideUp('fast', function () {
                        if (proselect.amval != '0') {
                            $.getJSON(ajaxPageurl + '?adminPage=getamphor&type=amphur', {amid: proselect.amval}, function (data) {
                                if (typeof data['hasfile'] === 'undefined') {
                                    proselect.createDistinctSelect(data);
                                    $('#distinct-select').slideDown('fast');
                                } else {
                                    $.getJSON(ajaxDropurl + 'district/' + proselect.amval + '.json', function (data) {
                                        proselect.createDistinctSelect(data);
                                        $('#distinct-select').slideDown('fast');
                                    });
                                }
                            });
                        }
                    });
                },
                createDistinctSelect: function (data) {//console.log(data);
                    $.each(data, function (index, dat) {
                        var checkSelect = dat.DISTRICT_ID == sub_district ? 'selected' : '';
                        var mytxt = '<option value="' + dat.DISTRICT_ID + '" ' + checkSelect + '> ' + dat.DISTRICT_NAME + '</option>';
                        $('#employerContactSubDistinct').append(mytxt);
                    });
                }
            };
            $(document).ready(function () {
                proselect.init();
            });
            is_page_backend = true;
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

