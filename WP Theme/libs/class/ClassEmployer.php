<?php

class Employer
{
    private $wpdb;
    public $tableUser = "";
    public $tableUserMeta = "";
    public $tableEmployerPackage = "ics_employer_package";
    public $tableCompanyInfo = "ics_company_information_for_contact";
    public $tableRequestProfile = "ics_request_profile";
    public $countValue = 0;
    public $classPagination = null;
    public $banner_path = 'banner_path';
    public $logo_path_name = 'logo_path';

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

    function getUserSelectPackage($id = 0, $order_by = "")
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
            'meta_key' => 'user_type',
            'meta_value' => 'employer',
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
        $strAnd = "";
        if ($employer_id) {
            if (is_array($employer_id)) {
                $strAnd .= " AND b.employer_id IN (" . implode(', ', $employer_id) . ")";
            } else {
                $strAnd .= " AND b.employer_id=$employer_id";
            }
        }
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
        $getPostBackend = empty($post['post_backend']) ? false : $post['post_backend'];
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
            add_user_meta($user_id, "activation_confirm", $getPostBackend ? "true" : "false");
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
        $pass = empty($_REQUEST['employerPassword']) ? false : $_REQUEST['employerPassword'];
        $rePass = empty($_REQUEST['employerConfirmPassword']) ? false : $_REQUEST['employerConfirmPassword'];
        $getPostBackend = empty($_REQUEST['post_backend']) ? false : $_REQUEST['post_backend'];
        $employer_id = empty($_REQUEST['employer_id']) ? false : $_REQUEST['employer_id'];
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
        } elseif ($getPostBackend && $pass) {
            $user = $this->getUser($employer_id);
            wp_set_password($pass, $user->ID);
//            if ($user && wp_check_password($rePass, $user->data->user_pass, $user->ID)) {
//
//            } else {
//                return $this->returnMessage('Error check old password.', true);
//            }
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

    function getStatusJob($job_id)
    {
        return get_post_status($job_id);
    }

    function buildHtmlApplyJob($employer_id)
    {
        $classApply = new Apply($this->wpdb);
        $classPackage = new Package($this->wpdb);

        $argc = array(
            'post_type' => "job",
            'post_status' => array('publish', 'draft'),
            'meta_key' => 'employer_id',
            'meta_value' => $employer_id,
            'orderby' => 'modified',
            'order' => 'DESC',
        );
        $loopJobs = new WP_Query($argc);
        ob_start();
        ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <?php if ($loopJobs->have_posts()):
                while ($loopJobs->have_posts()) :
                    $loopJobs->the_post();
                    $postID = get_the_id();
                    $customField = get_post_custom($postID);

                    $dateCreate = $classPackage->getDateCreateJob($postID);
                    $dayDisplay = $classPackage->getDayDisplay($postID);
                    $checkDisplayPost = $classPackage->checkDisplayJob($dateCreate, $dayDisplay);
                    $employer_id = empty($customField["employer_id"][0]) ? '' : $customField["employer_id"][0];

//                    if ($employer_id):
                        $getApplyJob = $classApply->listCandidateApplyJob($postID, 0, $employer_id);
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne<?php echo $postID; ?>">
                                <h4 class="panel-title">
                                    <a class="tab_panel" data-toggle="collapse" data-parent="#accordion"
                                       href="#panel<?php echo $postID; ?>"
                                       aria-expanded="true"
                                       aria-controls="collapseOne">
                                        <span class="font-color-BF2026"><?php the_title(); ?>(<?php echo count($getApplyJob); ?>)</span>
                                    </a>
                                </h4>
                            </div>
                            <div id="panel<?php echo $postID; ?>" class="panel-collapse collapse" role="tabpanel"
                                 aria-labelledby="headingOne<?php echo $postID; ?>">
                                <table border="0" class="table table-hover">
                                    <tr>
                                        <td>Name</td>
                                        <td>Degree</td>
                                        <td>University / Institute</td>
                                        <td>Japanese Skill</td>
                                        <td>View</td>
                                    </tr>
                                    <?php
                                    foreach ($getApplyJob as $value) :
                                        ?>
                                        <tr>
                                            <td><?php echo "$value->title$value->first_name $value->last_name" ?></td>
                                            <td><?php echo $value->degree; ?></td>
                                            <td><?php echo $value->university; ?></td>
                                            <td><?php echo $value->japanese_skill; ?></td>
                                            <td>
                                                <a onclick="viewCandidateProfile(<?php echo $value->user_id; ?>)"
                                                   data-toggle="modal" data-target="#modal_candidate_profile" href="#">
                                                    View Profile</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    <?php //endif; ?>
                <?php endwhile; endif; ?>
        </div>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function buildHtmlCompanyInfo($data)
    {
        if ($data)
            extract($data);

        $directions = empty($directions) ? false : $directions;
        if ($directions) {
            list($lat, $long) = explode(",", $directions);
            $lat = trim($lat);
            $long = trim($long);
        } else {
            $lat = "13.755716";
            $long = "100.501589";
        }
        ob_start();
        ?>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&language=th"></script>
        <script type="text/javascript">
            var geocoder = new google.maps.Geocoder();
            var lat_lng = new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $long; ?>);
            var loadDefaultLocation = <?php echo $directions ? "true": 'false'; ?>;

            function geocodePosition(pos) {
                geocoder.geocode({
                    latLng: pos
                }, function (responses) {
                    if (responses && responses.length > 0) {
                        updateMarkerAddress(responses[0].formatted_address);
                    } else {
                        updateMarkerAddress('Cannot determine address at this location.');
                    }
                });
            }

            function updateMarkerStatus(str) {
                document.getElementById('markerStatus').innerHTML = str;
            }

            function updateMarkerPosition(latLng) {
//                document.getElementById('info').innerHTML = [
//                    latLng.lat(),
//                    latLng.lng()
//                ].join(', ');

//                $("#current_location").text(latLng.lat() + ", " + latLng.lng());
//                document.getElementById('current_location').value = [
//                    latLng.lat(),
//                    latLng.lng()
//                ].join(', ');
                if (loadDefaultLocation) {
                    document.getElementById('employerContactDirections').value = [
                        latLng.lat(),
                        latLng.lng()
                    ].join(', ');
                }
                loadDefaultLocation = true;
            }

            function updateMarkerAddress(str) {
                document.getElementById('address').innerHTML = str;
            }

            function initialize() {
                var map = new google.maps.Map(document.getElementById('mapCanvas'), {
                    zoom: 14,
                    center: lat_lng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                var marker = new google.maps.Marker({
                    position: lat_lng,
                    title: 'Point A',
                    map: map,
                    draggable: true
                });

                // Update current position info.
                updateMarkerPosition(lat_lng);
                geocodePosition(lat_lng);

                // Add dragging event listeners.
                google.maps.event.addListener(marker, 'dragstart', function () {
                    updateMarkerAddress('Dragging...');
                });

                google.maps.event.addListener(marker, 'drag', function () {
                    updateMarkerStatus('Dragging...');
                    updateMarkerPosition(marker.getPosition());
                });

                google.maps.event.addListener(marker, 'dragend', function () {
                    updateMarkerStatus('Drag ended');
                    geocodePosition(marker.getPosition());
                });
            }

            // Onload handler to fire off the app.
            function setGoogleMap() {
                google.maps.event.addDomListener(window, 'load', initialize);
            }

            function setLocation() {
                var getLatLong = document.getElementById('employerContactDirections').value;
                if (!getLatLong)
                    return;
                var spLatLong = getLatLong.split(",");
                var latitude = parseFloat(spLatLong[0].trim());
                var longitude = parseFloat(spLatLong[1].trim());
                lat_lng = new google.maps.LatLng(latitude, longitude);
                initialize();
            }

            setGoogleMap();
        </script>
        <style>
            #mapCanvas {
                width: 500px;
                height: 400px;
                float: left;
            }

            #infoPanel {
                float: left;
                margin-left: 10px;
            }

            #infoPanel div {
                margin-bottom: 5px;
            }
        </style>

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
        <!--        <div class="form-group col-md-12">-->
        <!--            <div class="col-md-2 text-right clearfix"><label for="employerContactApplyMedtod">Apply-->
        <!--                    method</label></div>-->
        <!--            <div class="col-md-10">-->
        <!--                <textarea id="employerContactApplyMedtod"-->
        <!--                          name="employerContactApplyMedtod" class="form-control"-->
        <!--                          rows="10">--><?php
                                                   //                    echo empty($apply_method) ?
                                                   //                        "" : $apply_method;
                                                   ?><!--</textarea>-->
        <!--            </div>-->
        <!--        </div>-->
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
                    <label for="employerContactCountryThailand">Thailand to list province of thai</label>
                </div>
                <div class="col-md-6">
                    <input type="radio" id="employerContactCountryOversea" required
                           name="employerContactCountry"
                           value="japan" <?php
                    if (!empty($contact_country)) echo $contact_country == 'japan' ? "checked" : "";
                    ?>/>
                    <label for="employerContactCountryOversea" class="text-left">Japan to list province of japan</label>
                </div>
                <!--                <div class="col-md-12">-->
                <!--                    <input type="checkbox" id="employerContactIndustrialPark"-->
                <!--                           name="employerContactIndustrialPark"-->
                <!--                           onclick="this.value=$(this).prop('checked')?1:0;"-->
                <!--                        --><?php //if (!empty($contact_industrial_park))
                //                            echo $contact_industrial_park ? 'checked value="1"' : 'value="0"';
                ?><!--/>-->
                <!--                    <label for="employerContactIndustrialPark">Within and industrial park</label>-->
                <!--                </div>-->
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
                <!--                <textarea id="employerContactDirections" name="employerContactDirections"-->
                <!--                          class="form-control" rows="10">-->
                <?php //echo empty($directions) ? "" : $directions;
                ?><!--</textarea>-->
                <!--                <input type="hidden" name="employerContactDirections"-->
                <!--                       id="employerContactDirections" value="-->
                <?php //echo empty($directions) ? "" : $directions;
                ?><!--">-->

                <div id="mapCanvas" class="col-md-8"></div>
                <div id="infoPanel" class="col-md-5">
                    <b>Marker status:</b>

                    <div id="markerStatus"><i>Click and drag the marker.</i></div>

                    <b>Current position:</b>
                    <input type="text" id="employerContactDirections"
                           name="employerContactDirections" class="form-control"
                           value="<?php echo empty($directions) ? "" : $directions; ?>">
                    <!--                    <textarea id="current_location" class="form-control"></textarea>-->
                    <a class="btn btn-primary pull-right" onclick="setLocation();return false;">Set Location
                    </a>

                    <div class="clearfix"></div>
                    <b>Closest matching address:</b>

                    <div id="address"></div>
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
        <?php /*
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
        */
        ?>
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

    function buildFormPostJob($post_id = 0)
    {
        $classQueryPostJob = new QueryPostJob($this->wpdb);
        $objClassOtherSetting = new OtherSetting($this->wpdb);
        $classCandidate = new Candidate($this->wpdb);
        $classPackage = new Package($this->wpdb);
        $user_id = get_current_user_id();
//        $getCompanyInfo = $this->getCompanyInfo(0, $user_id);
        $employer_id = $user_id;
        $getPost = null;
        $custom = null;
        if ($post_id) {
            $getPost = get_post($post_id);
            $custom = get_post_custom($post_id);
            $post_type = 'edit';
        } else {
            $post_type = 'add';
        }
        $qualification = empty($custom["qualification"][0]) ? "" : $custom["qualification"][0];
        $highlight_jobs = empty($custom["highlight_jobs"][0]) ? "" : $custom["highlight_jobs"][0];
        $job_type = empty($custom["job_type"][0]) ? "" : $custom["job_type"][0];
        $jlpt_level = empty($custom["jlpt_level"][0]) ? "" : $custom["jlpt_level"][0];
        $job_location = empty($custom["job_location"][0]) ? "" : $custom["job_location"][0];
        $japanese_skill = empty($custom["japanese_skill"][0]) ? "" : $custom["japanese_skill"][0];
        $salary = empty($custom["salary"][0]) ? "" : $custom["salary"][0];
        $working_day = empty($custom["working_day"][0]) ? "" : $custom["working_day"][0];
        $arrayLocation = $classQueryPostJob->getArraySubCatLocation();

        $getListJapaneseSkill = $classCandidate->japanese_skill;

        $featureImage = get_the_post_thumbnail($post_id);
        ob_start();
        ?>

        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/post-job.js"></script>
        <?php if ($classPackage->getTotalPost($user_id) > 0 || $post_id): ?>
        <form id="form_post_job" method="POST"
              class="form-horizontal">
            <input type="hidden" name="post_job" value="true">
            <input type="hidden" name="post_type" value="<?php echo $post_type; ?>">
            <input type="hidden" name="employer_id" value="<?php echo $employer_id; ?>">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

            <div class="form-group col-md-12">
                <div class="col-md-2 text-right clearfix">
                    <label for="feature_image"><?php _e('Image:', 'framework') ?></label></div>
                <div class="col-md-10">
                    <div></div>
                    <div class="fileinput fileinput-new" data-provides="fileinput" style="width: 100%;">
                        <div id="preview" class="fileinput-preview thumbnail col-md-10" data-trigger="fileinput"
                             style="width: 100%; height: 200px;"><?php echo $featureImage; ?></div>
                        <div>
                        <span class="btn btn-default btn-file">
                            <span class="fileinput-new">Select image</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="file" id="feature_image" onchange="setFeatureImage(this);"
                                   class="ephoto-upload" accept="image/jpeg"></span>
                            <a href="#" class="btn btn-default <?php
                            echo $featureImage ? "" : "fileinput-exists"; ?>"
                               data-dismiss="fileinput"
                               onclick="removeFeatureImage(this);">Remove</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-2 text-right clearfix">
                    <label for="postTitle"><?php _e('Job Title:', 'framework') ?><span
                            class="font-color-red">*</span></label></div>
                <div class="col-md-10">
                    <input type="text" class="form-control"
                           maxlength="20"
                           data-bv-stringlength="true"
                           data-bv-stringlength-min="4"
                           data-bv-message="Job title is not valid" id="postTitle"
                           name="postTitle"
                           required
                           value="<?php echo $getPost ? $getPost->post_title : ""; ?>"
                           data-bv-notempty-message="Job title is required and cannot be empty"/>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-2 text-right clearfix">
                    <label for="postContent"><?php _e('Job Content:', 'framework') ?></label></div>
                <div class="col-md-10">
                    <textarea name="postContent" id="postContent" rows="8" cols="30"
                              class="form-control"><?php echo $getPost ? $getPost->post_content : ""; ?></textarea>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-2 text-right clearfix">
                    <label for="qualification"><?php _e('Qualification:', 'framework') ?></label></div>
                <div class="col-md-10">
                    <textarea name="qualification" id="qualification" rows="8" cols="30"
                              class="form-control"><?php echo $qualification; ?></textarea>
                </div>
            </div>
            <?php if ($classPackage->getTotalHotJob($employer_id) > 0 || $post_type == "edit" && $highlight_jobs): ?>
                <div class="form-group col-md-12">
                    <div class="col-md-2 text-right clearfix">
                        <label for="job_type"><?php _e('Highlight jobs:', 'framework') ?></div>
                    <div class="col-md-10">
                        <input type="checkbox" value="<?php echo empty($highlight_jobs) ? 0 : $highlight_jobs; ?>"
                            <?php echo $highlight_jobs ? 'checked' : ''; ?>
                               name="highlight_jobs"
                               onclick="this.value=$(this).prop('checked')?1:0;">
                    </div>
                </div>
            <?php endif; ?>
            <div class="form-group col-md-12">
                <div class="col-md-2 text-right clearfix">
                    <label for="job_type"><?php _e('Job Type:', 'framework') ?><span
                            class="font-color-red">*</span></label></div>
                <div class="col-md-10">
                    <select id="job_type" name="job_type" class="form-control" required="">
                        <option value="">--Select--</option>
                        <option value="Permanent"
                            <?php echo $job_type == 'Permanent' ? "selected" : ""; ?>>Permanent
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-2 text-right clearfix">
                    <label for="jlpt_level"><?php _e('JLPT Level:', 'framework') ?><span
                            class="font-color-red">*</span></label></div>
                <div class="col-md-10">
                    <select id="jlpt_level" name="jlpt_level" class="form-control" required="">
                        <option value="">--Select--</option>
                        <?php foreach ($classCandidate->jlpt as $value): ?>
                            <option <?php echo $value == $jlpt_level ? "selected" : ""; ?>
                                value="<?php echo $value; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-2 text-right clearfix">
                    <label for="job_location"><?php _e('Job Location:', 'framework') ?><span
                            class="font-color-red">*</span></label></div>
                <div class="col-md-10">
                    <select id="job_location" name="job_location" class="form-control" required="">
                        <option value="">--Select--</option>
                        <?php foreach ($arrayLocation as $value): ?>
                            <option value="<?php echo $value->term_taxonomy_id; ?>"
                                <?php echo $value->term_taxonomy_id == $job_location ? 'selected' : ''; ?>
                                ><?php echo $value->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-2 text-right clearfix">
                    <label for="japanese_skill"><?php _e('Japanese Skill:', 'framework') ?><span
                            class="font-color-red">*</span></label></div>
                <div class="col-md-10">
                    <select id="japanese_skill" name="japanese_skill" class="form-control" required="">
                        <option value="">--Select--</option>
                        <?php foreach ($getListJapaneseSkill as $value): ?>
                            <option value="<?php echo $value; ?>"
                                <?php echo $japanese_skill == $value ? 'selected' : ''; ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-2 text-right clearfix">
                    <label for="salary"><?php _e('Salary:', 'framework') ?></label></div>
                <div class="col-md-10">
                    <input id="salary" class="form-control" placeholder="Exp: 15,000 บาท"
                           name="salary" value="<?php echo $salary; ?>">
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-2 text-right clearfix">
                    <label for="working_day"><?php _e('Working Day:', 'framework') ?><span
                            class="font-color-red">*</span></label></div>
                <div class="col-md-10">
                    <?php echo $objClassOtherSetting->buildWorkingDayToSelect($working_day); ?>
                </div>
            </div>
            <div class="form-group col-md-12" style="">
                <button type="submit"
                        class="btn btn-primary col-md-6 pull-right"><?php _e('Submit', 'framework') ?></button>
                <button type="reset" class="btn btn-default pull-right" style="border: none;">Reset</button>
                <?php if ($post_id): ?>
                    <a type="button" class="btn btn-info pull-right"
                       href="Javascript:loadPostJob('');">Cancel </a>
                <?php endif; ?>
            </div>
        </form>

        <script
            src="<?php echo get_template_directory_uri(); ?>/libs/js/libs/bootstrap-wysihtml5/js/wysihtml5-0.3.0.js"></script>
        <!--        <script src="--><?php //echo get_template_directory_uri(); ?><!--/libs/js/libs/bootstrap-wysihtml5/js/jquery-1.7.2.min.js"></script>-->
        <!--        <script src="--><?php //echo get_template_directory_uri(); ?><!--/libs/js/libs/bootstrap-wysihtml5/js/bootstrap.min.js"></script>-->
        <script
            src="<?php echo get_template_directory_uri(); ?>/libs/js/libs/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js"></script>


        <script>
            $('#postContent').wysihtml5();
        </script>
    <?php else: ?>
        <a class="btn btn-success" href="edit-profile/"><span class="glyphicon glyphicon-shopping-cart"></span> Buy Package</a>
    <?php endif; ?>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function uploadLogoImage($file, $image_x = 150)
    {
        $handle = new Upload($file);
        $upload_dir = wp_upload_dir();
//        echo get_template_directory() . '/library/res/save_data.txt';
        $dir_dest = $upload_dir['basedir'] . '/avatar' . $upload_dir['subdir'];

        $dir_pics = get_site_url() . "/" . 'wp-content/uploads/avatar' . $upload_dir['subdir'];
        $arrayReturn = array();
        $filePath = 'wp-content/uploads/avatar' . $upload_dir['subdir'];;
        if ($handle->uploaded) {
            $handle->image_resize = true;
            $handle->image_ratio_y = true;
            $handle->image_x = $image_x;

            // yes, the file is on the server
            // now, we start the upload 'process'. That is, to copy the uploaded file
            // from its temporary location to the wanted location
            // It could be something like $handle->Process('/home/www/my_uploads/');
            $handle->Process($dir_dest);

            // we check if everything went OK
            if ($handle->processed) {
                $dir_pics .= '/' . $handle->file_dst_name;
                $filePath .= '/' . $handle->file_dst_name;
                $arrayReturn['error'] = false;
                // everything was fine !
                $msgReturn = '<p class="result">';
                $msgReturn .= '  <b>File uploaded with success</b><br />';
                $msgReturn .= '  File: <a target="_blank" href="' . $dir_pics . '">' .
                    $handle->file_dst_name . '</a>';
                $msgReturn .= '   (' . round(filesize($handle->file_dst_pathname) / 256) / 4 . 'KB)';
                $msgReturn .= '</p>';
            } else {
                $arrayReturn['error'] = true;
                // one error occured
                $msgReturn = '<p class="result">';
                $msgReturn .= '  <b>File not uploaded to the wanted location</b><br />';
                $msgReturn .= '  Error: ' . $handle->error . '';
                $msgReturn .= '</p>';
            }

            // we delete the temporary files
            $handle->Clean();

        } else {
            $arrayReturn['error'] = true;
            // if we're here, the upload file failed for some reasons
            // i.e. the server didn't receive the file
            $msgReturn = '<p class="result">';
            $msgReturn .= '  <b>File not uploaded on the server</b><br />';
            $msgReturn .= '  Error: ' . $handle->error . '';
            $msgReturn .= '</p>';
        }
        $arrayReturn['msg'] = $msgReturn;
        $arrayReturn['path'] = $filePath;
        return $arrayReturn;
    }

    function deleteOldLogo($user_id)
    {
        $path = get_user_meta($user_id, $this->logo_path_name, true);
        if (empty($path))
            return true;
        $file_headers = @get_headers(get_site_url() . "/" . $path);
        if ($file_headers[0] != 'HTTP/1.1 404 Not Found') {
            return unlink($path);
        }
        return true;
    }

    function getLogoPath($user_id)
    {
        $haveImage = true;
        $pathImage = get_user_meta($user_id, $this->logo_path_name, true);
        $pathNonAvatar = get_template_directory_uri() . "/libs/images/non-image.png";

        if (empty($pathImage)) {
            $pathImage = $pathNonAvatar;
            $haveImage = false;
        } else {
            $file_headers = @get_headers(get_site_url() . "/" . $pathImage);
            if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
                $pathImage = $pathNonAvatar;
                $haveImage = false;
            } else {
                $pathImage = get_site_url() . "/" . $pathImage;
            }
        }
        return array(
            'path' => $pathImage,
            'have_image' => $haveImage
        );
    }

    function setLogoPath($user_id, $path)
    {
        return update_user_meta($user_id, $this->logo_path_name, $path);
    }

    function getBannerPath($user_id)
    {
        $haveImage = true;
        $pathImage = get_user_meta($user_id, $this->banner_path, true);
        $pathNonImage = get_template_directory_uri() . "/libs/images/non-image.png";
        if (empty($pathImage)) {
            $pathImage = $pathNonImage;
            $haveImage = false;
        } else {
            $file_headers = @get_headers(get_site_url() . "/" . $pathImage);
            if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
                $pathImage = $pathNonImage;
                $haveImage = false;
            } else {
                $pathImage = get_site_url() . "/" . $pathImage;
            }
        }
        return array(
            'path' => $pathImage,
            'have_image' => $haveImage
        );
    }

    function uploadBannerImage($file, $employer_id, $image_x = 700)
    {
        $handle = new Upload($file);
        $upload_dir = wp_upload_dir();
//        echo get_template_directory() . '/library/res/save_data.txt';
        $dir_dest = $upload_dir['basedir'] . '/banner/' . $employer_id . $upload_dir['subdir'];

        $dir_pics = get_site_url() . "/" . 'wp-content/uploads/banner/' . $employer_id . $upload_dir['subdir'];

        $arrayReturn = array();
        $filePath = 'wp-content/uploads/banner/' . $employer_id . $upload_dir['subdir'];;
        if ($handle->uploaded) {
            $handle->image_resize = true;
            $handle->image_ratio_y = true;
            $handle->image_x = $image_x;

            // yes, the file is on the server
            // now, we start the upload 'process'. That is, to copy the uploaded file
            // from its temporary location to the wanted location
            // It could be something like $handle->Process('/home/www/my_uploads/');
            $handle->Process($dir_dest);

            // we check if everything went OK
            if ($handle->processed) {
                $dir_pics .= '/' . $handle->file_dst_name;
                $filePath .= '/' . $handle->file_dst_name;
                $arrayReturn['error'] = false;
                // everything was fine !
                $msgReturn = '<p class="result">';
                $msgReturn .= '  <b>File uploaded with success</b><br />';
                $msgReturn .= '  File: <a target="_blank" href="' . $dir_pics . '">' .
                    $handle->file_dst_name . '</a>';
                $msgReturn .= '   (' . round(filesize($handle->file_dst_pathname) / 256) / 4 . 'KB)';
                $msgReturn .= '</p>';
            } else {
                $arrayReturn['error'] = true;
                // one error occured
                $msgReturn = '<p class="result">';
                $msgReturn .= '  <b>File not uploaded to the wanted location</b><br />';
                $msgReturn .= '  Error: ' . $handle->error . '';
                $msgReturn .= '</p>';
            }

            // we delete the temporary files
            $handle->Clean();

        } else {
            $arrayReturn['error'] = true;
            // if we're here, the upload file failed for some reasons
            // i.e. the server didn't receive the file
            $msgReturn = '<p class="result">';
            $msgReturn .= '  <b>File not uploaded on the server</b><br />';
            $msgReturn .= '  Error: ' . $handle->error . '';
            $msgReturn .= '</p>';
        }
        $arrayReturn['msg'] = $msgReturn;
        $arrayReturn['path'] = $filePath;
        return $arrayReturn;
    }

    function setBannerPath($user_id, $path)
    {
        return update_user_meta($user_id, $this->banner_path, $path);
    }

    function deleteOldBanner($user_id)
    {
        $path = get_user_meta($user_id, $this->banner_path, true);
        if (empty($path))
            return true;
        $file_headers = @get_headers(get_site_url() . "/" . $path);
        if ($file_headers[0] != 'HTTP/1.1 404 Not Found') {
            return unlink($path);
        }
        return true;
    }

    function uploadImage($file)
    {
        $handle = new Upload($file);
        $upload_dir = wp_upload_dir(); //var_dump($upload_dir);exit;
//        echo get_template_directory() . '/library/res/save_data.txt';
        $dir_dest = $upload_dir['path']; //"D:\Dropbox\work\jobjapthai/wp-content/uploads/2015/01"

        $dir_pics = $upload_dir['url']; // "http://127.0.0.1:11001/jobjapthai/wp-content/uploads/2015/01"
        $arrayReturn = array();
        //$filePath = 'wp-content/uploads/avatar' . $upload_dir['subdir'];;
        if ($handle->uploaded) {
            $handle->image_resize = true;
            $handle->image_ratio_y = true;
            $handle->image_x = 800;

            // yes, the file is on the server
            // now, we start the upload 'process'. That is, to copy the uploaded file
            // from its temporary location to the wanted location
            // It could be something like $handle->Process('/home/www/my_uploads/');
            $handle->Process($dir_dest);

            // we check if everything went OK
            if ($handle->processed) {
                $dir_pics .= '/' . $handle->file_dst_name;
//                $filePath .= '/' . $handle->file_dst_name;
                $arrayReturn['error'] = false;
                // everything was fine !
                $msgReturn = '<p class="result">';
                $msgReturn .= '  <b>File uploaded with success</b><br />';
                $msgReturn .= '  File: <a target="_blank" href="' . $dir_pics . '">' .
                    $handle->file_dst_name . '</a>';
                $msgReturn .= '   (' . round(filesize($handle->file_dst_pathname) / 256) / 4 . 'KB)';
                $msgReturn .= '</p>';
            } else {
                $arrayReturn['error'] = true;
                // one error occured
                $msgReturn = '<p class="result">';
                $msgReturn .= '  <b>File not uploaded to the wanted location</b><br />';
                $msgReturn .= '  Error: ' . $handle->error . '';
                $msgReturn .= '</p>';
            }

            // we delete the temporary files
            $handle->Clean();

        } else {
            $arrayReturn['error'] = true;
            // if we're here, the upload file failed for some reasons
            // i.e. the server didn't receive the file
            $msgReturn = '<p class="result">';
            $msgReturn .= '  <b>File not uploaded on the server</b><br />';
            $msgReturn .= '  Error: ' . $handle->error . '';
            $msgReturn .= '</p>';
        }
        $arrayReturn['msg'] = $msgReturn;
        $arrayReturn['url'] = $dir_pics;
        return $arrayReturn;
    }

    function setFeatureImage($post_id, $image_url)
    {
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image_url);
        $filename = basename($image_url);
        if (wp_mkdir_p($upload_dir['path']))
            $file = $upload_dir['path'] . '/' . $filename;
        else
            $file = $upload_dir['basedir'] . '/' . $filename;
        file_put_contents($file, $image_data);
//        $file = $image_url;

        $wp_filetype = wp_check_filetype($filename, null);
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment($attachment, $file, $post_id);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        wp_update_attachment_metadata($attach_id, $attach_data);

        set_post_thumbnail($post_id, $attach_id);
        return true;
    }

    function deleteOldThumbnail($post_id)
    {
        $existing = get_post_thumbnail_id($post_id);
        if ($existing)
            wp_delete_attachment($existing, true);
        return true;
    }

    function addPostJob($post, $status = "publish")
    {
        $userID = get_current_user_id();
        $postTitle = empty($post['postTitle']) ? '' : $post['postTitle'];
        $postContent = empty($post['postContent']) ? '' : $post['postContent'];

        $qualification = empty($post['qualification']) ? '' : $post['qualification'];
        $job_type = empty($post['job_type']) ? '' : $post['job_type'];
        $jlpt_level = empty($post['jlpt_level']) ? '' : $post['jlpt_level'];
        $job_location = empty($post['job_location']) ? '' : $post['job_location'];
        $japanese_skill = empty($post['japanese_skill']) ? '' : $post['japanese_skill'];
        $salary = empty($post['salary']) ? '' : $post['salary'];
        $working_day = empty($post['working_day']) ? '' : $post['working_day'];
        $employer_id = empty($post['employer_id']) ? '' : $post['employer_id'];
        $highlight_jobs = empty($post['highlight_jobs']) ? '' : $post['highlight_jobs'];


        $post_information = array(
            'post_author' => $userID,
            'post_title' => wp_strip_all_tags($postTitle),
            'post_content' => $postContent,
            'post_type' => 'job',
            'post_status' => $status
        );
        $postID = wp_insert_post($post_information);
        if (!$postID)
            return $this->returnMessage($postID->get_error_message(), true);

        $classPackage = new Package($this->wpdb);
        $result = $classPackage->addApplyPost($employer_id, $postID);
        if (!$result)
            return $this->returnMessage("You are no package post job.", true);

        if ($highlight_jobs == 1) {
            $checkHaveHotJob = $classPackage->checkHaveHotJob($postID);
            if ($checkHaveHotJob) {
                $result = $classPackage->addApplyHotJob($postID);
                if (!$result)
                    return $this->returnMessage("Error apply Highlight job package.", true);
            } else
                return $this->returnMessage("You are no package Highlight job.", true);
        }

        //we now use $pid (post id) to help add out post meta data
        add_post_meta($postID, "qualification", $qualification);
        add_post_meta($postID, "job_type", $job_type);
        add_post_meta($postID, "jlpt_level", $jlpt_level);
        add_post_meta($postID, "job_location", $job_location);
        add_post_meta($postID, "japanese_skill", $japanese_skill);
        add_post_meta($postID, "salary", $salary);
        add_post_meta($postID, "working_day", $working_day);
        add_post_meta($postID, "employer_id", $employer_id);
        add_post_meta($postID, "highlight_jobs", $highlight_jobs);

        if ($status != 'publish')
            return $postID;
        return $this->returnMessage("Add Job success.", false);
    }

    function editPostJob($post)
    {
        $userID = get_current_user_id();
        $postID = empty($post['post_id']) ? false : $post['post_id'];
        $postTitle = empty($post['postTitle']) ? '' : $post['postTitle'];
        $postContent = empty($post['postContent']) ? '' : $post['postContent'];

        $qualification = empty($post['qualification']) ? '' : $post['qualification'];
        $job_type = empty($post['job_type']) ? '' : $post['job_type'];
        $jlpt_level = empty($post['jlpt_level']) ? '' : $post['jlpt_level'];
        $job_location = empty($post['job_location']) ? '' : $post['job_location'];
        $japanese_skill = empty($post['japanese_skill']) ? '' : $post['japanese_skill'];
        $salary = empty($post['salary']) ? '' : $post['salary'];
        $working_day = empty($post['working_day']) ? '' : $post['working_day'];
        $employer_id = empty($post['employer_id']) ? '' : $post['employer_id'];
        $highlight_jobs = empty($post['highlight_jobs']) ? '' : $post['highlight_jobs'];

        $getOldHighlightJob = get_post_meta($postID, 'highlight_jobs', true);
        $classPackage = new Package($this->wpdb);
        if ($highlight_jobs == 1) {
            if ($getOldHighlightJob != 1) {
                $checkHaveHotJob = $classPackage->checkHaveHotJob($postID);
                if ($checkHaveHotJob) {
                    $result = $classPackage->addApplyHotJob($postID);
                    if (!$result)
                        return $this->returnMessage("Error apply Highlight job package.", true);
                } else
                    return $this->returnMessage("You are no package Highlight job.", true);
            }
        } else {
            if ($getOldHighlightJob == 1) {
                $result = $classPackage->removeApplyHotJob($postID);
                if (!$result)
                    return $this->returnMessage("Error apply Highlight job package.", true);
            }
        }

        $post_information = array(
            'ID' => $postID,
            'post_author' => $userID,
            'post_title' => wp_strip_all_tags($postTitle),
            'post_content' => $postContent,
            'post_type' => 'job',
            'post_status' => 'publish'
        );

        $result = wp_update_post($post_information);
        if (!$result)
            return $this->returnMessage($result->get_error_message(), true);
        update_post_meta($postID, "qualification", $qualification);
        update_post_meta($postID, "job_type", $job_type);
        update_post_meta($postID, "jlpt_level", $jlpt_level);
        update_post_meta($postID, "job_location", $job_location);
        update_post_meta($postID, "japanese_skill", $japanese_skill);
        update_post_meta($postID, "salary", $salary);
        update_post_meta($postID, "working_day", $working_day);
        update_post_meta($postID, "employer_id", $employer_id);
        update_post_meta($postID, "highlight_jobs", $highlight_jobs);
        return $this->returnMessage("Edit Job success.", false);
    }

    function deletePosJob($post_id, $status = 'draft')
    {
        $userID = get_current_user_id();
//        switch ($status) {
//            case 0:
//                $status = "draft";
//                break;
//            case 1:
//                $status = "publish";
//                break;
//            case 'delete' :
//                $status = "trash";
//                break;
//        }
        $post_information = array(
            'ID' => $post_id,
            'post_author' => $userID,
            'post_status' => $status
        );

        $result = wp_update_post($post_information);
        if (!$result)
            return $this->returnMessage($result->get_error_message(), true);
        return $this->returnMessage("Delete Job success.", false);
    }

    function addRequestProfile($candidate_id, $employer_id)
    {

        $sql = "
            INSERT INTO `$this->tableRequestProfile` (
              `candidate_id`,
              `employer_id`,
              `create_datetime`,
              `publish`
            )
            VALUES
              (
                '{$candidate_id}',
                '{$employer_id}',
                NOW(),
                1
              );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return $this->wpdb->insert_id;
    }

    function searchCandidate($post)
    {
        $classCandidate = new Candidate($this->wpdb);
        $degree = empty($post['degree']) ? false : $post['degree'];
        $university = empty($post['university']) ? false : $post['university'];
        $japanese_skill = empty($post['japanese_skill']) ? false : $post['japanese_skill'];

        $getCandidate = $classCandidate->searchCandidateByEmployer($degree, $university, $japanese_skill);
        ob_start();
        ?>
        <table border="0" class="table table-hover">
            <tr>
                <td>Name</td>
                <td>Degree</td>
                <td>University / Institute</td>
                <td>Japanese Skill</td>
                <td>Request</td>
            </tr>
            <?php
            if ($getCandidate) {
                foreach ($getCandidate as $value) :
                    $name = "$value->title $value->first_name $value->last_name";
                    $strDataRequestProfile = "{" .
                        "can_id: $value->candidate_id," .
                        "can_name: '$name'," .
                        "degree:'$value->degree'," .
                        "university:'$value->university'," .
                        "japanese_skill:'$value->japanese_skill'" .
                        "}";
                    ?>
                    <tr>
                        <td><?php echo $name; ?>
                            <?php echo $value->request ? "<i class='glyphicon glyphicon-star font-color-BF2026'></i>" : ""; ?>
                        </td>
                        <td><?php echo $value->degree; ?></td>
                        <td><?php echo $value->university; ?></td>
                        <td><?php echo $value->japanese_skill; ?></td>
                        <td>
                            <?php if ($value->request): ?>
                                <a class="btn btn-default" style="cursor: default;">Requested</a>
                            <?php else: ?>
                                <a class="btn btn-success" data-target="#modal_confirm_request_profile"
                                   data-toggle="modal"
                                   onclick="data_candidate=<?php echo $strDataRequestProfile; ?>;setDataCandidate();"
                                   href="#">Request Profile</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach;
            } else {
                ?>
                <tr>
                    <td colspan="5" style="text-align:center; ">No Result.</td>
                </tr>
            <?php
            }

            ?>
        </table>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function returnMessage($msg, $error, $json = true)
    {
        $arrayReturn = array();
        if (is_array($msg)) {
            $arrayReturn = $msg;
            $msg = $msg['msg'];
        }
        if ($error) {
            $arrayReturn['msg'] = '<div class="font-color-BF2026"><p>' . $msg . '</p></div>';
            $arrayReturn['error'] = $error;
        } else {
            $arrayReturn['msg'] = '<div class="font-color-4BB748"><p>' . $msg . '</p></div>';
            $arrayReturn['error'] = $error;
        }
        return $json ? json_encode($arrayReturn) : $arrayReturn;
    }
}