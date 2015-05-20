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
if (!class_exists('Package')) {
    require_once('ClassPackage.php');
}

class Approve_Package extends WP_List_Table
{

    var $approve_data = null;
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

        $classPackage = new Package($wpdb);
        $this->approve_data = array();
        $result = $classPackage->getUserSelectPackage();
        foreach ($result as $key => $value) {
            $packageNo = str_pad($value->select_package_id, 5, '0', STR_PAD_LEFT);
            $linkEdit = "admin.php?page=approve-package&page_approve=true&package_id=$value->select_package_id&employer_id=$value->ID";
            if ($this->searchInArray((array)$value))
                $this->approve_data[] = array(
                    "id" => "<a href='$linkEdit'>$packageNo</a>",
                    "count" => $key + 1,
                    "company_name" => $value->company_name,
                    "email" => "<a href='mailto:$value->user_email'>$value->user_email</a>",
                    "user_login" => $value->user_login,
                    "status" => $this->buildStatus($value->status),
                    "create_time" => $value->sp_create,
                    "update_time" => $value->sp_update,
                    "edit" => "<a href='$linkEdit'>View</a>" .
                        " | " .
                        '<a href="javascript:deleteSelectPackage('.$value->select_package_id.
                        ');">Delete</a>'
                );
        }

    }

    function buildStatus($status)
    {
        $strStatus = '';
        switch ($status) {
            case 'edit':
                $strStatus .= "<b class='font-color-006cb7'>Buy Package</b>";
                break;
            case 'payment':
                $strStatus .= "<b class='font-color-FF04FF'>Payment</b>";
                break;
            case 'approve':
                $strStatus .= "<b class='font-color-4BB748'>Approve</b>";
                break;
            case 'cancel':
                $strStatus .= "<b class='font-color-999'>Cancel</b>";
                break;
            case 'expire':
                $strStatus .= "<b class='font-color-999'>Expire<b>";
                break;
        }
        return $strStatus;
    }

    function checkStatus($status)
    {
        switch ($status) {
            case "approve":
                return "<span style='background-color:green;color:white'>Approve</span>";
        }
        return "<span style='background-color:blue;color:white'>No Approve</span>";
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
        if ('approve-list' != $page && 'approve-list-na' != $page)
            return;
        ?>
        <style type="text/css">
            .wp-list-table .column-id {
                width: 1%;
            }

            .wp-list-table .column-count {
                width: 5%;
            }
        </style><?php
    }

    function no_items()
    {
        _e('No approve found, dude.');
    }

    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'count':
            case 'id':
            case 'company_name':
            case 'user_login':
//            case 'user_nicename':
//            case 'passport_no':
            case 'email':
            case 'status':
            case 'create_time':
            case 'update_time':
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
            'id' => array('id', true),
            'company_name' => array('company_name', true),
            'user_login' => array('user_login', true),
            'user_nicename' => array('user_nicename', true),
            'status' => array('status', true),
            'create_time' => array('create_time', true),
            'update_time' => array('update_time', true),
            'email' => array('email', true),
        );
        return $sortable_columns;
    }

    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'count' => __('#', 'mylisttable'),
            'id' => __('Package No.', 'mylisttable'),
            'company_name' => __('Company name', 'mylisttable'),
            'user_login' => __('Login name', 'mylisttable'),
            'email' => __('Email', 'mylisttable'),
            'status' => __('Status', 'mylisttable'),
            'create_time' => __('Create', 'mylisttable'),
            'update_time' => __('Update', 'mylisttable'),
            'edit' => __('', 'mylisttable'),
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
        usort($this->approve_data, array(&$this, 'usort_reorder'));

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = count($this->approve_data);

        // only ncessary because we have sample data
        $this->found_data = array_slice($this->approve_data, (($current_page - 1) * $per_page), $per_page);

        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page //WE have to determine how many items to show on a page
        ));
        $this->items = $this->found_data;
    }

    function approvePackageTemplate()
    {
        global $webSiteName, $wpdb;
        $classPackage = new Package($wpdb);
        $packageID = empty($_REQUEST['package_id']) ? 0 : $_REQUEST['package_id'];
        $employerID = empty($_REQUEST['employer_id']) ? 0 : $_REQUEST['employer_id'];
        $packageNo = str_pad($packageID, 5, '0', STR_PAD_LEFT);
        $paymentFile = $classPackage->getPaymentFilePath($packageID);
        $paymentFileName = $paymentFile ? basename($paymentFile) : '';
        $arraySelectPackage = $packageID ? $classPackage->getSelectPackage($employerID, $packageID) : null;
        $isApprove = $packageID ? $arraySelectPackage[0]->status : '';
        ?>
        <script>
            var user_id = <?php echo $employerID; ?>;
            var str_loading = '<div class="img_loading"><img src="<?php
        bloginfo('template_directory'); ?>/libs/images/loading.gif" width="40"/></div>';
        </script>
        <link rel="stylesheet" type="text/css"
              href="<?php echo get_template_directory_uri(); ?>/libs/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/libs/css/style.css"/>
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/jquery.1.11.1.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrap.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrapValidator.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/header.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/libs/css/jasny-bootstrap.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/jasny-bootstrap.min.js"></script>
        <script>
            function setApprove() {
                if ($("#attach_payment").val() == '') {
                    alert("กรุณาเลือกไฟล์ หลังฐานการชำระเงิน");
                    $("#attach_payment").click();
                    return false;
                }
                showImgLoading();
                $.ajax({
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    url: '',
                    data: {
                        post_package: 'true',
                        type_post: 'approve_package',
                        status_package: 'approve',
                        package_id: <?php echo $packageID; ?>
                    },
                    success: function (data) {
                        hideImgLoading();
                        alert(data.msg);
                        if (!data.error) {
                            window.location.reload();
                        }
                    }
                })
                    .fail(function () {
                        hideImgLoading();
                        alert("เกิดข้อผิดพลาด");
                    });
                return false;
            }
            $(document).ready(function () {
                $('#attach_payment').change(function () {
                    if ($(this).val() != '') {
                        var formData = new FormData();
                        formData.append('payment_file', $(this)[0].files[0]);
                        formData.append('post_package', 'true');
                        formData.append('type_post', 'file_package_payment');
                        formData.append('package_id', '<?php echo $packageID; ?>');
                        formData.append('employer_id', user_id);
                        showImgLoading();
                        $.ajax({
                            url: '',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function (result) {
                                hideImgLoading();
                                alert(result.msg);
                            },
                            error: function (result) {
                                alert(result.responseText);
                                hideImgLoading();
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }
                });
            })
        </script>
        <div class="wrap">
            <h2>Package No. <?php echo $packageNo; ?></h2>
            <section class="container-fluid" style="margin-top: 10px;">

                <div class="container wrapper">
                    <div class="row">
                        <div class="form-group col-md-12" style="">
                            <?php
                            echo $classPackage->buildHtmlFormNewPackage($packageID, $employerID);
                            //                        require_once(get_template_directory() . "/libs/pages/package-new.php");
                            ?>

                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right">
                                <label for="attach_payment">Attach Payment File</label><br/>
<!--                                <small>(PDF File)</small>-->
                            </div>
                            <div class="col-md-8">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <?php if ($isApprove != 'approve' && !$paymentFile): ?>
                                    <span class="btn btn-default btn-file">

                                        <span class="fileinput-new"><span
                                                class="glyphicon glyphicon glyphicon-file"></span> Select file</span>
                                        <span class="fileinput-exists"><span
                                                class="glyphicon glyphicon glyphicon-file"></span> Change</span>

                                        <input type="file" name="attach_payment" id="attach_payment"
                                                value="<?php echo $paymentFile; ?>">
                                    </span>
                                    <?php endif; ?>
                                    <span class="fileinput-filename"><?php echo $paymentFile ?
                                            "<a href='$paymentFile' target='_blank'>$paymentFileName</a>" : '';?></span>
                                    <a href="#" id="delete_file" class="close fileinput-exists" data-dismiss="fileinput"
                                       style="float: none">&times;</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <?php if ($isApprove == 'payment'): ?>
                            <button type="button" class="btn btn-primary pull-right"
                                    onclick="$('#frm_package').submit();">Save changes
                            </button>
                            <button type="button" class="btn btn-success pull-right"
                                    onclick="setApprove();">Set Approve
                            </button>
                            <?php endif; ?>
                            <a class="btn btn-default pull-left"
                               href="admin.php?page=approve-package">Back</a>

                        </div>
                    </div>
                </div>
            </section>
            <?php
            echo $classPackage->buildJavaFormNewPackage($packageID, $employerID, true);
            ?>
        </div>
    <?php
    }

} //class

