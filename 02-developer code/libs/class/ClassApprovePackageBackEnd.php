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
        $siteUrl = home_url();
        foreach ($result as $key => $value) {
            if ($this->searchInArray((array)$value))
                $this->approve_data[] = array(
                    "id" => $value->ID,
                    "count" => $key + 1,
                    "company_name" => $value->company_name,
                    "email" => $value->user_email,
                    "user_login" => $value->user_login,
                    "status" => $this->checkStatus($value->status),
                    "create_time" => $value->create_datetime,
                    "update_time" => $value->update_datetime,
                    "edit" => '<a href="#" data-toggle="modal" id="new_package" onclick="showAddPackage('. $value->select_package_id .', ' .$value->ID.')"
                                                   data-target="#modal_package">View</a>'.
                    " | ".
                        '<a class="btn_delete_employer" href="#" pm-id="' . $value->ID . '">Delete</a>',
                    'approve' => '<a></a>'
                );
        }

    }

    //function build

    function checkStatus($status)
    {
        switch($status){
            case "approve": return "<span style='background-color:green;color:white'>Approve</span>";
            case "": return "";
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
        if ('employer-list' != $page && 'employer-list-na' != $page)
            return;
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

        ?>
        </pre>
        <div class="wrap"><h2>Approve</h2>

    <?php
    }

} //class

