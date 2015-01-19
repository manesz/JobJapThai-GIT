<?php

class Employer
{
    private $wpdb;
    public $tableUser = "";
    public $tableUserMeta = "";
    public $tableEmployerPackage = "ics_employer_package";
    public $tableCompanyInfo = "ics_company_information_for_contact";
    public $countValue = 0;
    public $classPagination = null;

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
        $this->tableUser = $this->wpdb->users;
        $this->tableUserMeta = $this->wpdb->usermeta;
    }

    public function createTable()
    {
        $sql = "
            CREATE TABLE `$this->tableEmployerPackage` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `employer_id` int(10) unsigned DEFAULT NULL,
              `position_amount` varchar(50) DEFAULT NULL,
              `duration` varchar(50) DEFAULT NULL,
              `super_hot_job_duration` varchar(50) DEFAULT NULL,
              `hot_job_type` varchar(50) DEFAULT NULL,
              `hot_job_duration` varchar(50) DEFAULT NULL,
              `urgent_duration` varchar(50) DEFAULT NULL,
              `create_datetime` datetime DEFAULT NULL,
              `update_datetime` datetime DEFAULT NULL,
              `publish` int(1) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ";
        dbDelta($sql);

        $sql = "
            CREATE TABLE `$this->tableCompanyInfo` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `employer_id` int(10) unsigned DEFAULT NULL,
              `contact_person` varchar(50) DEFAULT NULL,
              `company_name` varchar(50) DEFAULT NULL,
              `business_type` text,
              `company_profile_and_business_operation` text,
              `walfare_and_benefit` text,
              `apply_method` text,
              `address` text,
              `contact_country` text,
              `contact_industrial_park` int(11) DEFAULT '0',
              `province` text,
              `district` text,
              `sub_district` text,
              `postcode` varchar(50) DEFAULT NULL,
              `tel` varchar(50) DEFAULT NULL,
              `fax` varchar(50) DEFAULT NULL,
              `email` varchar(50) DEFAULT NULL,
              `website` text,
              `directions` text,
              `options` text,
              `create_datetime` datetime DEFAULT NULL,
              `update_datetime` datetime DEFAULT NULL,
              `publish` int(1) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ";
        dbDelta($sql);
    }

    public function getList($id = 0, $order_by = "")
    {
        $strAnd = $id ? " AND a.ID=$id" : "";
        $sql = "
            SELECT
              a.*,
              b.*,
              c.*
            FROM
              $this->tableUser a
            INNER JOIN
              $this->tableCompanyInfo b
            ON (a.ID = b.employer_id)
            INNER JOIN
              $this->tableEmployerPackage c
            ON (a.ID = c.employer_id)
            WHERE 1
            $strAnd
            $order_by
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function getListUser($employer_id = 0, $order_by = "")
    {
        /*$args = array(
//        'blog_id'      => $GLOBALS['blog_id'],
//        'role'         => '',
        'meta_key'     => 'user_type',
        'meta_value'   => 'employer',
//        'meta_compare' => '',
//        'meta_query'   => array(),
//        'include'      => array(),
//        'exclude'      => array(),
//        'orderby'      => 'login',
//        'order'        => 'ASC',
//        'offset'       => '',
//        'search'       => '',
//        'number'       => '',
//        'count_total'  => false,
//        'fields'       => 'all',
//        'who'          => ''
    );
        $getUser = get_users($args);
        return $getUser;*/
        $strAnd = $employer_id ? " AND a.ID=$employer_id" : "";
        $sql = "
            SELECT
              a.*,
              b.*,
              b.id as com_id
            FROM
              $this->tableUser a
            INNER JOIN
              $this->tableCompanyInfo b
            ON (a.ID = b.employer_id)
            INNER JOIN
              $this->tableUserMeta c
            ON (c.user_id = a.ID AND c.meta_key = 'user_type'
            AND c.meta_value='employer')
            WHERE 1
            $strAnd
            $order_by
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    function getUser($employer_id = 0)
    {
        $args = array(
//        'blog_id'      => $GLOBALS['blog_id'],
//        'role'         => '',
            'meta_key'     => 'user_type',
            'meta_value'   => 'employer',
//        'meta_compare' => '',
//        'meta_query'   => array(),
//        'include'      => array(),
//        'exclude'      => array(),
//        'orderby'      => 'login',
//        'order'        => 'ASC',
//        'offset'       => '',
//        'search'       => '',
//        'number'       => '',
//        'count_total'  => false,
//        'fields'       => 'all',
//        'who'          => ''
        );
        $getUser = get_userdata($employer_id);
        return $getUser;
    }

    public function getCompanyInfo($id = 0, $employer_id = 0, $order_by = "")
    {
        $strAnd = $employer_id ? " AND b.employer_id=$employer_id" : "";
        if ($id) {
            if (is_array($id)) {
                $strAnd .= " AND b.id IN (" . implode(', ', $id) . ")";
            } else {
                $strAnd .= " AND b.id=$id";
            }
        }
        $sql = "
            SELECT
              a.*,
              b.*,
              b.id as com_id
            FROM
              $this->tableUser a
            INNER JOIN
              $this->tableCompanyInfo b
            ON (a.ID = b.employer_id)
            INNER JOIN
              $this->tableUserMeta c
            ON (c.user_id = a.ID AND c.meta_key = 'user_type'
            AND c.meta_value='employer')
            WHERE 1
            $strAnd
            $order_by
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function getPackage($employer_id = 0)
    {
        $strAnd = $employer_id ? " AND employer_id=$employer_id" : "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableEmployerPackage
            WHERE 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    function employerRegister($post)
    {
        $fxrootpath = ABSPATH . 'wp-load.php';
        if (!file_exists($fxrootpath)) {
            return $this->returnMessage('Set value $fxrootpath in file : pages/apply-employer-register.php', true, false);
        }
        include_once($fxrootpath);
        $username = isset($post['employerUsername']) ? $post['employerUsername'] : false;
        $pass = isset($post['employerPassword']) ? $post['employerPassword'] : false;
        $rePass = isset($post['employerConfirmPassword']) ? $post['employerConfirmPassword'] : false;
        $email = isset($post['employerEmail']) ? $post['employerEmail'] : false;
        $getPostBackend = empty($_REQUEST['post_backend'])? false: $_REQUEST['post_backend'];
        //$website = isset($post['employerContactWebsite']) ? $post['employerContactWebsite'] : '';

        $email = empty($email) ? false : $email;
        $pass = empty($pass) ? false : $pass;
        $rePass = empty($rePass) ? false : $rePass;
        if ($pass != $rePass && $pass && $rePass && !$getPostBackend) {
            return $this->returnMessage('Error! Check your password and confirm password.', true, false);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->returnMessage('Invalid email format.', true, false);
        }
//        list($username) = explode('@', $email);
        $generatedKey = sha1(mt_rand(10000, 99999) . time() . $email);

        $userData = array(
            'user_login' => $username,
            'user_pass' => $pass,
            'user_email' => $email,
        );
        $user_id = wp_insert_user($userData);
        if (!is_wp_error($user_id)) {
            add_user_meta($user_id, "activation_key", $generatedKey);
            add_user_meta($user_id, "activation_confirm", $getPostBackend? "true": "false");
            $user_type = 'employer';
            add_user_meta($user_id, 'user_type', $user_type);
            $postData = $post;
            $postData['employer_id'] = $user_id;
            $result = $this->addCompanyInfo($postData);
            if (!$result) {
                wp_revoke_user($user_id);
                wp_delete_user($user_id);
                return $this->returnMessage('Error add company information for contact.', true, false);
            }

            $message = array("msg" => 'Register Success.', 'key' => $generatedKey);
            return $this->returnMessage($message, false, false);
        } else {
            $error_string = $user_id->get_error_message();
            return $this->returnMessage($error_string, true, false);
        }
    }

    function editEmployer($post)
    {
        $pass = empty($_REQUEST['employerPassword'])? false: $_REQUEST['employerPassword'];
        $rePass = empty($_REQUEST['employerConfirmPassword'])? false: $_REQUEST['employerConfirmPassword'];
        $getPostBackend = empty($_REQUEST['post_backend'])? false: $_REQUEST['post_backend'];
        $employer_id = empty($_REQUEST['employer_id'])? false: $_REQUEST['employer_id'];
        $result = $this->editCompanyInfo($post);
        if (!$result) {
            return $this->returnMessage('Error edit company information for contact.', true);
        }
        if ($pass && $rePass) { //echo $new_password;echo $old_password;
            $current_user = wp_get_current_user();
            $user = get_user_by('login', $current_user->user_login);
            if ($user && wp_check_password($rePass, $user->data->user_pass, $user->ID)) {
                wp_set_password($pass, $user->ID);
                return $this->returnMessage('<script>setTimeout(function(){window.location.reload()}, 3000);</script>Edit Success.', false);
            } else {
                return $this->returnMessage('Error check old password.', true);
            }
        } elseif($getPostBackend && $pass) {
            $user = get_user_by('ID', $employer_id);
            if ($user && wp_check_password($rePass, $user->data->user_pass, $user->ID)) {
                wp_set_password($pass, $user->ID);
            } else {
                return $this->returnMessage('Error check old password.', true);
            }
        }
        return $this->returnMessage('Edit Success.', false);
    }

    public function addCompanyInfo($post)
    {
        $employer_id = isset($post['employer_id']) ? $post['employer_id'] : false;
        $contact_person = isset($post['employerContactPerson']) ? $post['employerContactPerson'] : false;
        $company_name = isset($post['employerContactCompanyName']) ? $post['employerContactCompanyName'] : false;
        $business_type = isset($post['employerContactBusinessType']) ? $post['employerContactBusinessType'] : false;
        $company_profile_and_business_operation = isset($post['employerContactCompanyProfile']) ? $post['employerContactCompanyProfile'] : false;
        $walfare_and_benefit = isset($post['employerContactWalfare']) ? $post['employerContactWalfare'] : false;
        $apply_method = isset($post['employerContactApplyMedtod']) ? $post['employerContactApplyMedtod'] : false;
        $address = isset($post['employerContactAddress']) ? $post['employerContactAddress'] : false;
        $contact_country = isset($post['employerContactCountry']) ? $post['employerContactCountry'] : false;
        $contact_industrial_park = isset($post['employerContactIndustrialPark']) ? $post['employerContactIndustrialPark'] : 0;
        $province = isset($post['employerContactProvince']) ? $post['employerContactProvince'] : false;
        $district = isset($post['employerContactDistinct']) ? $post['employerContactDistinct'] : false;
        $sub_district = isset($post['employerContactSubDistinct']) ? $post['employerContactSubDistinct'] : false;
        $postcode = isset($post['employerContactPostcode']) ? $post['employerContactPostcode'] : false;
        $tel = isset($post['employerContactTel']) ? $post['employerContactTel'] : false;
        $fax = isset($post['employerContactFax']) ? $post['employerContactFax'] : false;
        $email = isset($post['employerContactEmail']) ? $post['employerContactEmail'] : false;
        $website = isset($post['employerContactWebsite']) ? $post['employerContactWebsite'] : false;
        $directions = isset($post['employerContactDirections']) ? $post['employerContactDirections'] : false;
        $options = isset($post['employerContactOption']) ? $post['employerContactOption'] : false;
        if ($options) {
            $options = implode(',', $options);
        }
        if (!$employer_id)
            return false;
        $sql = "
            INSERT INTO `$this->tableCompanyInfo` (
              `employer_id`,
              `contact_person`,
              `company_name`,
              `business_type`,
              `company_profile_and_business_operation`,
              `walfare_and_benefit`,
              `apply_method`,
              `address`,
              `contact_country`,
              `contact_industrial_park`,
              `province`,
              `district`,
              `sub_district`,
              `postcode`,
              `tel`,
              `fax`,
              `email`,
              `website`,
              `directions`,
              `options`,
              `create_datetime`,
              `publish`
            )
            VALUES
              (
                '{$employer_id}',
                '{$contact_person}',
                '{$company_name}',
                '{$business_type}',
                '{$company_profile_and_business_operation}',
                '{$walfare_and_benefit}',
                '{$apply_method}',
                '{$address}',
                '{$contact_country}',
                '{$contact_industrial_park}',
                '{$province}',
                '{$district}',
                '{$sub_district}',
                '{$postcode}',
                '{$tel}',
                '{$fax}',
                '{$email}',
                '{$website}',
                '{$directions}',
                '{$options}',
                NOW(),
                1
              );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return $this->wpdb->insert_id;
    }

    public function addPackage($post)
    {

    }

    function buildHtmlCompanyInfo($data)
    {
        if ($data)
            extract($data);
        ob_start();
        ?>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label for="employerContactPerson">Contact
                    person</label></div>
            <div class="col-md-10">
                <input type="text" id="employerContactPerson"
                       value="<?php echo empty($contact_person) ? "" : $contact_person; ?>"
                       name="employerContactPerson" class="form-control"/>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label for="employerContactCompanyName">Company
                    name<span class="font-color-red">*</span></label></div>
            <div class="col-md-10">
                <input type="text" id="employerContactCompanyName"
                       value="<?php echo empty($company_name) ? "" : $company_name; ?>"
                       name="employerContactCompanyName" class="form-control"
                       required/>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label for="employerContactBusinessType">Business
                    Type<span class="font-color-red">*</span></label></div>
            <div class="col-md-10">
                <select id="employerContactBusinessType" name="employerContactBusinessType" required
                        class="form-control">
                    <option value="">---------------- Please select type ----------------</option>
                    <option
                        value="1" <?php if (!empty($business_type)) echo $business_type == '1' ? "selected" : ""; ?>>
                        Business
                        type
                    </option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label for="employerContactCompanyProfile">Company
                    profile<br/>and business operation</label></div>
            <div class="col-md-10">
                <textarea id="employerContactCompanyProfile"
                          name="employerContactCompanyProfile" class="form-control"
                          rows="10"><?php echo empty($company_profile_and_business_operation) ?
                        "" : $company_profile_and_business_operation; ?></textarea>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label for="employerContactWalfare">Walfare and
                    Benefit</label></div>
            <div class="col-md-10">
                <textarea id="employerContactWalfare" name="employerContactWalfare"
                          class="form-control" rows="10"><?php
                    echo empty($walfare_and_benefit) ?
                        "" : $walfare_and_benefit; ?></textarea>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label for="employerContactApplyMedtod">Apply
                    method</label></div>
            <div class="col-md-10">
                <textarea id="employerContactApplyMedtod"
                          name="employerContactApplyMedtod" class="form-control"
                          rows="10"><?php
                    echo empty($apply_method) ?
                        "" : $apply_method; ?></textarea>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label for="employerContactAddress">Address <span
                        class="font-color-red">*</span></label></div>
            <div class="col-md-10">
                <textarea id="employerContactAddress" name="employerContactAddress"
                          class="form-control" rows="10" required><?php
                    echo empty($address) ?
                        "" : $address; ?></textarea>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"></div>
            <div class="col-md-10">
                <div class="col-md-6">
                    <input type="radio" id="employerContactCountryThailand" required
                           name="employerContactCountry" value="thailand" <?php
                    if (!empty($contact_country)) echo $contact_country == 'thailand' ? "checked" : "";
                    ?>/>
                    <label for="employerContactCountryThailand">Thailand</label>
                </div>
                <div class="col-md-6">
                    <input type="radio" id="employerContactCountryOversea" required
                           name="employerContactCountry"
                           value="oversea" <?php
                    if (!empty($contact_country)) echo $contact_country == 'oversea' ? "checked" : "";
                    ?>/>
                    <label for="employerContactCountryOversea" class="text-left">Oversea</label>
                </div>
                <div class="col-md-12">
                    <input type="checkbox" id="employerContactIndustrialPark"
                           name="employerContactIndustrialPark"
                           onclick="this.value=$(this).prop('checked')?1:0;"
                        <?php if (!empty($contact_industrial_park))
                            echo $contact_industrial_park ? 'checked value="1"' : 'value="0"'; ?>/>
                    <label for="employerContactIndustrialPark">Within and industrial park</label>
                </div>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label for="employerContactProvince">Province<span
                        class="font-color-red">*</span></label></div>
            <div class="col-md-10">
                <?php
                $provinces = $this->wpdb->get_results(
                    "SELECT * FROM `province` ORDER BY PROVINCE_NAME ASC"
                );
                if ($provinces) {
                    ?>
                    <select id="employerContactProvince" name="employerContactProvince" class="form-control"
                            required>
                        <option value="0" selected="selected">---------------- Please select ----------------</option>
                        <?php foreach ($provinces as $value) {
                            ?>
                            <option <?php if (!empty($province)) echo $value->PROVINCE_ID == $province ? "selected" : ""; ?>
                            value="<?php echo $value->PROVINCE_ID; ?>"><?php echo $value->PROVINCE_NAME; ?></option><?php } ?>
                    </select>
                <?php } else { ?> ลงฐานข้อมูล จังหวัดที่ <?php echo get_template_directory() . '/libs/res/thailand.sql' ?><?php } ?>
            </div>
        </div>
        <div class="form-group col-md-12" id="aupher-select">
            <div class="col-md-2 text-right clearfix"><label for="employerContactDistinct">District<span
                        class="font-color-red">*</span></label></div>
            <div class="col-md-10">
                <select id="employerContactDistinct" name="employerContactDistinct"
                        class="form-control" required>
                    <option value="0">---------------- Please select ----------------</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-12" id="distinct-select">
            <div class="col-md-2 text-right clearfix"><label for="employerContactSubDistinct">Sub
                    district<span class="font-color-red">*</span></label></div>
            <div class="col-md-10">
                <select id="employerContactSubDistinct" name="employerContactSubDistinct"
                        class="form-control" required>
                    <option value="0">---------------- Please select ----------------</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label
                    for="employerContactPostcode">Postcode<span class="font-color-red">*</span></label></div>
            <div class="col-md-10">
                <input type="text" id="employerContactPostcode" name="employerContactPostcode"
                       class="form-control" required
                       value="<?php echo empty($postcode) ? "" : $postcode; ?>"/>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label for="employerContactTel">Tel<span
                        class="font-color-red">*</span></label></div>
            <div class="col-md-10">
                <input type="text" id="employerContactTel" name="employerContactTel"
                       class="form-control"
                       value="<?php echo empty($tel) ? "" : $tel; ?>" required/>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label for="employerContactFax">Fax</label></div>
            <div class="col-md-10">
                <input type="text" id="employerContactFax" name="employerContactFax"
                       class="form-control"
                       value="<?php echo empty($fax) ? "" : $fax; ?>"/>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label for="employerContactEmail">Email</label>
            </div>
            <div class="col-md-10">
                <input type="text" id="employerContactEmail" name="employerContactEmail"
                       class="form-control"
                       value="<?php echo empty($email) ? "" : $email; ?>"/>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label
                    for="employerContactWebsite">Website</label></div>
            <div class="col-md-10">
                <input type="text" id="employerContactWebsite" name="employerContactWebsite"
                       class="form-control"
                       value="<?php echo empty($website) ? "" : $website; ?>"/>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="col-md-2 text-right clearfix"><label
                    for="employerContactDirections">Directions</label></div>
            <div class="col-md-10">
                <textarea id="employerContactDirections" name="employerContactDirections"
                          class="form-control" rows="10"><?php echo empty($directions) ? "" : $directions; ?></textarea>
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- ----------------------------------------- Section : Option for keep resume profile -->
        <h5 class="bg-ddd padding-10 clearfix">Option for keep resume profile</h5>

        <div class="form-group col-md-12">
            <?php
            if (!empty($options)) {
                list($option1, $option2, $option3) = explode(',', $options);
            } else {
                list($option1, $option2, $option3) = array(0, 0, 0);
            }
            ?>
            <input type="checkbox" class="employerContactOption" id="option1"
                   onclick="this.value=$(this).prop('checked')?1:0;"
                <?php echo $option1 ? 'checked value="1"' : 'value="0"' ?>/> Store resume on
            Jobjapthai.com <span class="font-color-BF2026">(viewmore)</span><br/>
            <input type="checkbox" class="employerContactOption" id="option2"
                   onclick="this.value=$(this).prop('checked')?1:0;"
                <?php echo $option2 ? 'checked value="1"' : 'value="0"' ?>/> Receive resume in English
            only<br/>
            <input type="checkbox" class="employerContactOption" id="option3"
                   onclick="this.value=$(this).prop('checked')?1:0;"
                <?php echo $option3 ? 'checked value="1"' : 'value="0"' ?>/> Check this box to receive
            resume by Email in HTML format <span
                class="font-color-BF2026">(click to see sample)</span><br/>
            otherwise the resume will be send to you in plain text format <span
                class="font-color-BF2026">(click to see sample)</span>
        </div>
        <div class="clearfix"></div>
        <hr/>
<?
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    public function editCompanyInfo($post)
    {
        $employer_id = isset($post['employer_id']) ? $post['employer_id'] : false;
        $contact_person = isset($post['employerContactPerson']) ? $post['employerContactPerson'] : false;
        $company_name = isset($post['employerContactCompanyName']) ? $post['employerContactCompanyName'] : false;
        $business_type = isset($post['employerContactBusinessType']) ? $post['employerContactBusinessType'] : false;
        $company_profile_and_business_operation = isset($post['employerContactCompanyProfile']) ? $post['employerContactCompanyProfile'] : false;
        $walfare_and_benefit = isset($post['employerContactWalfare']) ? $post['employerContactWalfare'] : false;
        $apply_method = isset($post['employerContactApplyMedtod']) ? $post['employerContactApplyMedtod'] : false;
        $address = isset($post['employerContactAddress']) ? $post['employerContactAddress'] : false;
        $contact_country = isset($post['employerContactCountry']) ? $post['employerContactCountry'] : false;
        $contact_industrial_park = isset($post['employerContactIndustrialPark']) ? $post['employerContactIndustrialPark'] : 0;
        $province = isset($post['employerContactProvince']) ? $post['employerContactProvince'] : false;
        $district = isset($post['employerContactDistinct']) ? $post['employerContactDistinct'] : false;
        $sub_district = isset($post['employerContactSubDistinct']) ? $post['employerContactSubDistinct'] : false;
        $postcode = isset($post['employerContactPostcode']) ? $post['employerContactPostcode'] : false;
        $tel = isset($post['employerContactTel']) ? $post['employerContactTel'] : false;
        $fax = isset($post['employerContactFax']) ? $post['employerContactFax'] : false;
        $email = isset($post['employerContactEmail']) ? $post['employerContactEmail'] : false;
        $website = isset($post['employerContactWebsite']) ? $post['employerContactWebsite'] : false;
        $directions = isset($post['employerContactDirections']) ? $post['employerContactDirections'] : false;
        $options = isset($post['employerContactOption']) ? $post['employerContactOption'] : false;
        if ($options) {
            $options = implode(',', $options);
        }
        if (!$employer_id)
            return false;
        $sql = "
            UPDATE `ics_company_information_for_contact`
            SET
              `contact_person` = '{$contact_person}',
              `company_name` = '{$company_name}',
              `business_type` = '{$business_type}',
              `company_profile_and_business_operation` = '{$company_profile_and_business_operation}',
              `walfare_and_benefit` = '{$walfare_and_benefit}',
              `apply_method` = '{$apply_method}',
              `address` = '{$address}',
              `contact_country` = '{$contact_country}',
              `contact_industrial_park` = '{$contact_industrial_park}',
              `province` = '{$province}',
              `district` = '{$district}',
              `sub_district` = '{$sub_district}',
              `postcode` = '{$postcode}',
              `tel` = '{$tel}',
              `fax` = '{$fax}',
              `email` = '{$email}',
              `website` = '{$website}',
              `directions` = '{$directions}',
              `options` = '{$options}',
              `update_datetime` = NOW()
            WHERE `employer_id` = '{$employer_id}';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return true;
    }

    public function editPackage($post)
    {

    }

    public function addData($post)
    {
        extract($post);
        $result = $this->wpdb->insert(
            $this->tableBannerSlide,
            array(
                //'title' => @$gtitle,
                //'description' => @$gdesc,
                'sort' => @$gsort,
                'link' => @$glink,
                'image_path' => @$pathimg,
                'create_datetime' => date_i18n("Y-m-d H:i:s"),
                'update_datetime' => date_i18n("Y-m-d H:i:s"),
                'publish' => 1,
            ),
            array(
//                '%s',
//                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
            )
        );
        if ($result) {
            return $this->wpdb->insert_id;
        }
        return false;
    }

    public function editData($data)
    {
        extract($data);
        $sql = "
            UPDATE $this->tableBannerSlide
            SET
                sort='{$gsort}',
                image_path='{$pathimg}',
                update_datetime=NOW(),
                link='{$glink}'
            WHERE 1
            AND id = {$galleryid};
        ";
        if ($galleryid) {
            $qupdate = $this->wpdb->query($sql);
            return $qupdate;
        } else {
            return FALSE;
        }
    }

    public function updateOder($array_order)
    {
        if (!$array_order)
            return true;
//        var_dump($array_order);
        $sql = "";
        foreach ($array_order as $key => $value) {
            $sort = $key + 1;
//            $sql .= "
//                UPDATE
//                  $this->tableBannerSlide
//                SET
//                    sort={$sort}
//                WHERE 1
//                AND id={$value};
//            ";

            $result = $this->wpdb->update(
                $this->tableBannerSlide,
                array(
                    'sort' => $sort,
                    'update_datetime' => date_i18n('Y-m-d H:i:s'),
                ),
                array('id' => $value),
                array('%d', '%s'),
                array('%d')

            );
//            $result = $this->wpdb->query($sql);
            if (!$result)
                return false;
        }
        return true;
    }

    public function deleteValue($id)
    {
        $sql = "
            UPDATE $this->tableBannerSlide
            SET publish = 0
            WHERE 1
            AND id = {$id};
        ";
        if ($id) {
            $result = $this->wpdb->query($sql);
            return $result;
        } else {
            return FALSE;
        }
    }

    function returnMessage($msg, $error, $json = true)
    {
        if ($error) {
            $arrayReturn = (array('msg' => '<div class="font-color-BF2026"><p>' . $msg . '</p></div>', 'error' => $error));
        } else {
            if (is_array($msg)) {
                $arrayReturn = $msg;
                $msg = $msg['msg'];
            }
            $arrayReturn['msg'] = '<div class="font-color-4BB748"><p>' . $msg . '</p></div>';
            $arrayReturn['error'] = $error;
        }
        return $json ? json_encode($arrayReturn) : $arrayReturn;
    }
}