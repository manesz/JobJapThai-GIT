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

class Pre_Register extends WP_List_Table
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
        $result = $classCandidate->getListUserPreRegister();
        $siteUrl = home_url();
        foreach ($result as $key => $value) {
            $strEdit = '
            <a class="btn_delete_candidate" href="#" pm-id="' . $value->ID . '">Delete</a> ';
            if ($this->searchInArray((array)$value))
                $this->candidate_data[] = array(
                    "id" => $value->ID,
                    "count" => $key + 1,
                    "name" => "<a href='?page=pre-register-list&page_type=edit&candidate_id=$value->ID'
                >$value->title $value->first_name $value->last_name</a>",
                    "user_login" => $value->user_login,
//                "user_nicename" => $value->user_nicename,
                    "email" => $value->user_email,
                    "create_time" => $value->create_datetime,
                    "update_time" => $value->update_datetime,
                    //"fav_job" => '<a href="' . $siteUrl . '/wp-admin/post-new.php?post_type=job&candidate_id=' . $value->can_id . '">view</a>',
//                    "apply_job" => '<a href="?page=pre-register-list&candidate-edit=true&id=' . $value->ID . '">view</a>',
//                    "edit" => '<a href="?page=pre-register-list&page_type=edit&candidate_id=' . $value->ID . '">Edit</a>|
//                    <a class="btn_delete_candidate" href="#" pm-id="' . $value->ID . '">Delete</a>',
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
        if ('pre-register-list' != $page && 'pre-register-list-na' != $page)
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
        <!--                src="--><?php //bloginfo('template_directory');
        ?><!--/library/js/candidate_edit.js"></script>-->

        <!--        <link rel="stylesheet" href="--><?php //bloginfo('template_directory');
        ?><!--/library/css/flip-clock/flipclock.css">-->
        <!--        <script src="--><?php //bloginfo('template_directory');
        ?><!--/library/js/flip-clock/flipclock.js"></script>-->
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
            case 'create_time':
            case 'update_time':
//            case 'fav_job':
//            case 'apply_job':
//            case 'edit':
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
            'create_time' => array('create_time', true),
            'update_time' => array('update_time', true),
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
            'create_time' => __('Create Time', 'mylisttable'),
            'update_time' => __('Update Time', 'mylisttable'),
//            'fav_job' => __('Favorite Job', 'mylisttable'),
//            'apply_job' => __('Apply Job', 'mylisttable'),
//            'edit' => __('Delete', 'mylisttable'),
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
        $classOthSetting = new OtherSetting($wpdb);
        $userID = empty($_GET['candidate_id']) ? 0 : $_GET['candidate_id'];

        $isLogin = false;
        if ($userID) {
            $isLogin = true;
            $userData = $classCandidate->getListUserPreRegister($userID);
            $userData = $userData[0];
//            extract($userData);
        } else $userData = null;
        ?>
        <link rel="stylesheet" type="text/css"
              href="<?php echo get_template_directory_uri(); ?>/libs/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/libs/css/style.css"/>
        <h2><?php echo $isLogin ? "Edit" : "Add New"; ?>Pre Register</h2>

        <section class="container-fluid" style="margin-top: 10px;">

            <div class="container wrapper">
                <div class="row">
                    <h4 style="color: #BE2026">Personal Information:</h4>

                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label
                                for="first_name">Name<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <input type="text" id="first_name" required=""
                                   name="first_name" class="form-control"
                                   value="<?php echo empty($userData->first_name) ? "" : $userData->first_name; ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label for="gender">Gender<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <select id="gender" name="gender" required=""
                                    class="form-control">
                                <option
                                    value="1" <?php if (!empty($userData->gender)) echo $userData->gender == 1 ? 'selected' : ''; ?>>
                                    Male
                                </option>
                                <option
                                    value="2" <?php if (!empty($userData->gender)) echo $userData->gender == 2 ? 'selected' : ''; ?>>
                                    Female
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label for="date_of_birth">Date of
                                birth<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <input type="text" maxlength="20"
                                   id="date_of_birth" name="date_of_birth"
                                   class="form-control datepicker"
                                   required placeholder="dd/mm/yyyy | Ex. 23/02/1980"
                                   value="<?php echo empty($userData->date_of_birth) ? "" : $userData->date_of_birth; ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label for="phone">Phone / Mobile<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <input type="text" maxlength="50"
                                   id="phone" name="phone" class="form-control"
                                   value="<?php echo empty($userData->phone) ? "" : $userData->phone; ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label for="email">Email
                                Address<span class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <input type="text" id="email" name="email" class="form-control"
                                   maxlength="50"
                                   data-bv-emailaddress="true"
                                   required
                                   data-bv-emailaddress-message="The input is not a valid email address"
                                   value="<?php echo empty($userData->user_email) ? "" : $userData->user_email; ?>"/>
                        </div>
                    </div>

                    <h4 style="color: #BE2026">Your Language Skill:</h4>

                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label for="japanese_reading">Japanese
                                Reading</label><span class="font-color-red">*</span></div>
                        <div class="col-md-8">
                            <select id="japanese_reading" name="japanese_reading" class="form-control"
                                    required="">
                                <option value=""></option>
                                <?php foreach ($classCandidate->japanese_reading as $value): ?>
                                    <option
                                        value="<?php echo $value; ?>"
                                        <?php if (!empty($userData->japanese_reading))
                                            echo $userData->japanese_reading == $value ? 'selected' : ''; ?>
                                        ><?php echo $value; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label for="japanese_writing">Japanese
                                Writing</label><span class="font-color-red">*</span></div>
                        <div class="col-md-8">
                            <select id="japanese_writing" name="japanese_writing" class="form-control"
                                    required="">
                                <option value=""></option>
                                <?php foreach ($classCandidate->japanese_writing as $value): ?>
                                    <option
                                        value="<?php echo $value; ?>"
                                        <?php if (!empty($userData->japanese_writing))
                                            echo $userData->japanese_writing == $value ? 'selected' : ''; ?>><?php echo $value; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label for="toeic_toefl_ielts">TOEIC /
                                TOEFL /
                                IELTS</label><span class="font-color-red">*</span></div>
                        <div class="col-md-8">

                            <select id="toeic_toefl_ielts" name="toeic_toefl_ielts" class="form-control"
                                    required="">
                                <option value=""></option>
                                <?php foreach ($classCandidate->toeic_toefl_ielts as $value): ?>
                                    <option
                                        value="<?php echo $value; ?>"
                                        <?php if (!empty($userData->toeic_toefl_ielts))
                                            echo $userData->toeic_toefl_ielts == $value ? 'selected' : ''; ?>><?php echo $value; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"></div>
                        <div class="col-md-8">
                            <input type="text" id="toeic_toefl_ielts_score"
                                   name="toeic_toefl_ielts_score"
                                   class="form-control" placeholder="Your Score: 999" required=""
                                   maxlength="20"
                                   value="<?php echo empty($userData->toeic_toefl_ielts_score) ? "" : $userData->toeic_toefl_ielts_score; ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label for="english_speaking">English
                                Speaking</label><span
                                class="font-color-red">*</span></div>
                        <div class="col-md-8">
                            <select id="english_speaking" name="english_speaking" class="form-control"
                                    required="">
                                <option value=""></option>
                                <?php foreach ($classCandidate->english_speaking as $value): ?>
                                    <option
                                        value="<?php echo $value; ?>"
                                        <?php if (!empty($userData->english_speaking))
                                            echo $userData->english_speaking == $value ? 'selected' : ''; ?>><?php echo $value; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label for="english_reading">English
                                Reading</label><span class="font-color-red">*</span></div>
                        <div class="col-md-8">
                            <select id="english_reading" name="english_reading" class="form-control"
                                    required="">
                                <option value=""></option>
                                <?php foreach ($classCandidate->english_reading as $value): ?>
                                    <option
                                        value="<?php echo $value; ?>"
                                        <?php if (!empty($userData->english_reading))
                                        echo $userData->english_reading == $value ? 'selected' : ''; ?>><?php echo $value; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label for="english_writing">English
                                Writing</label><span class="font-color-red">*</span></div>
                        <div class="col-md-8">
                            <select id="english_writing" name="english_writing" class="form-control"
                                    required="">
                                <option value=""></option>
                                <?php foreach ($classCandidate->english_writing as $value): ?>
                                    <option
                                        value="<?php echo $value; ?>"
                                        <?php if (!empty($userData->english_writing))
                                            echo $userData->english_writing == $value ? 'selected' : ''; ?>><?php echo $value; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <h4 style="color: #BE2026">Your Experiences:</h4>

                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label for="candRegistJPStudyExp">Experience
                                studying in Japan<span class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <select id="candRegistJPStudyExp" name="candRegistJPStudyExp"
                                    class="form-control" required="">
                                <option value="No"
                                    <?php if (!empty($userData->studying_in_japan))
                                        echo $userData->studying_in_japan == 'No' ? 'selected' : ''; ?>>No</option>
                                <option value="Yes"
                                    <?php if (!empty($userData->studying_in_japan))
                                        echo $userData->studying_in_japan == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label for="candRegistJPWorkExp">Experience
                                working in Japan<span class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <select id="candRegistJPWorkExp" name="candRegistJPWorkExp"
                                    class="form-control" required="">
                                <option value="No"
                                    <?php if (!empty($userData->working_in_japan))
                                        echo $userData->working_in_japan == 'No' ? 'selected' : ''; ?>>No</option>
                                <option value="Yes"
                                    <?php if (!empty($userData->working_in_japan))
                                        echo $userData->working_in_japan == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label
                                for="candRegistJPCompWorkExp">Experience working in Japanese
                                Company<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <select id="candRegistJPCompWorkExp" name="candRegistJPCompWorkExp"
                                    class="form-control" required="">
                                <option value="No"
                                    <?php if (!empty($userData->working_in_japan_company))
                                        echo $userData->working_in_japan_company == 'No' ? 'selected' : ''; ?>>No</option>
                                <option value="Yes"
                                    <?php if (!empty($userData->working_in_japan_company))
                                        echo $userData->working_in_japan_company == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                    <h4 style="color: #BE2026">Your Expectation:</h4>

                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label
                                for="<?php echo $classOthSetting->namePositionList; ?>">Job
                                Position<span class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <?php echo $classOthSetting->buildWorkingDayToSelect('job_position', empty($userData->job_position)? null :$userData->job_position) ?>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label
                                for="<?php echo $classOthSetting->nameJobLocation; ?>">Job
                                Location<span class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <?php echo $classOthSetting->buildWorkingDayToSelect("job_location", empty($userData->job_location)? null :$userData->job_location); ?>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-left clearfix"><label
                                for="candRegistSalary">Salary<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <input type="text" id="candRegistSalary" required=""
                                   name="candRegistSalary" class="form-control"
                                   maxlength="20"
                                   value="<?php echo empty($userData->toeic_toefl_ielts_score) ? "" : $userData->toeic_toefl_ielts_score; ?>"/>
                        </div>
                    </div>

                    <div class="form-group col-md-12" style="">
                        <a href="?page=pre-register-list" class="btn btn-info col-md-3 pull-right">Back</a>
                    </div>
                </div>
            </div>
        </section>
    <?php
    }

} //class

