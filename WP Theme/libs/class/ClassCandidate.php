<?php

include('class.upload.php');

class Candidate
{
    private $wpdb;
    public $tableUser = "";
    public $tableInformation = "ics_candidate_information";
    public $tableCareerProfile = "ics_candidate_career_profile";
    public $tableDesiredJob = "ics_candidate_desired_job";
    public $tableEducation = "ics_candidate_education";
    public $tableWorkExperience = "ics_candidate_work_experience";
    public $tableSkillLanguages = "ics_candidate_skill_languages";

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
        $this->tableUser = $this->wpdb->users;
    }

    public function getInformation($candidate_id = 0, $id = 0)
    {
        $strAnd = $candidate_id ? " AND candidate_id=$candidate_id" : "";
        $strAnd .= $id ? " AND id=$id" : "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableInformation
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function getCareerProfile($candidate_id = 0, $id = 0)
    {
        $strAnd = $candidate_id ? " AND candidate_id=$candidate_id" : "";
        $strAnd .= $id ? " AND id=$id" : "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableCareerProfile
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function getDesiredJob($candidate_id = 0, $id = 0)
    {
        $strAnd = $candidate_id ? " AND candidate_id=$candidate_id" : "";
        $strAnd .= $id ? " AND id=$id" : "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableDesiredJob
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function getEducation($candidate_id = 0, $id = 0)
    {
        $strAnd = $candidate_id ? " AND candidate_id=$candidate_id" : "";
        $strAnd .= $id ? " AND id=$id" : "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableEducation
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function buildEducationTable($candidate_id = 0)
    {
        $objEducation = $this->getEducation($candidate_id);
        ob_start();
        ?>
        <table border="1">
            <tr>
                <td>ID</td>
                <td>Degree</td>
                <td>University / Institute</td>
                <td>Education Period</td>
                <td>Grade / GPA</td>
                <td></td>
            </tr>
            <?php foreach ($objEducation as $key => $value):
                $id = $key + 1;
                $strSetValueForEdit = "{id:$value->id,degree:'$value->degree',university:'$value->university'" .
                    ",education_period_from:'$value->education_period_from',education_period_to:'$value->education_period_to',grade_gpa:'$value->grade_gpa'}";
                ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $value->degree; ?></td>
                    <td><?php echo $value->university; ?></td>
                    <td>From: <?php echo $value->education_period_from; ?>
                        To: <?php echo $value->education_period_to; ?></td>
                    <td><?php echo $value->grade_gpa; ?></td>
                    <td>
                        <a href="javascript:educationSetValue(<?php echo $strSetValueForEdit; ?>);">Edit</a>|<a>Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
        $strTable = ob_get_contents();
        ob_end_clean();

        return $strTable;
    }

    public function getWorkExperience($candidate_id = 0, $id = 0)
    {
        $strAnd = $candidate_id ? " AND candidate_id=$candidate_id" : "";
        $strAnd .= $id ? " AND id=$id" : "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableWorkExperience
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function buildWorkExperienceTable($candidate_id = 0)
    {
        $objEducation = $this->getWorkExperience($candidate_id);
        ob_start();
        ?>
        <table border="1">
            <tr>
                <td>ID</td>
                <td>Employment Period</td>
                <td>Company Name</td>
                <td>Position</td>
                <td>Monthly Salary</td>
                <td>Job Duties</td>
                <td></td>
            </tr>
            <?php foreach ($objEducation as $key => $value):
                $id = $key + 1;
                $strSetValueForEdit = "{id:$value->id,employment_period_from:'$value->employment_period_from',employment_period_to:'$value->employment_period_to'" .
                    ",company_name:'$value->company_name',position:'$value->position',month_salary:'$value->month_salary',job_duties:'$value->job_duties'}";
                ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td>From: <?php echo $value->employment_period_from; ?>
                        To: <?php echo $value->employment_period_to; ?></td>
                    <td><?php echo $value->company_name; ?></td>
                    <td><?php echo $value->position; ?></td>
                    <td><?php echo number_format($value->month_salary); ?></td>
                    <td><?php echo $value->job_duties; ?></td>
                    <td>
                        <a href="javascript:workExperienceSetValue(<?php echo $strSetValueForEdit; ?>);">Edit</a>|
                        <a>Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
        $strTable = ob_get_contents();
        ob_end_clean();

        return $strTable;
    }

    public function getSkillLanguages($candidate_id = 0, $id = 0)
    {
        $strAnd = $candidate_id ? " AND candidate_id=$candidate_id" : "";
        $strAnd .= $id ? " AND id=$id" : "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableSkillLanguages
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    function setUserLogin($user_id)
    {
        global $auth_secure_cookie;
        $secure_cookie = is_ssl();
        $secure_cookie = apply_filters('secure_signon_cookie', $secure_cookie, array());
        $auth_secure_cookie = $secure_cookie;
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true, $secure_cookie);
        update_user_meta($user_id, 'last_login', current_time('mysql'));
    }

    private function addInformation($post)
    {
        extract($post);
        $candidate_id = empty($candidate_id) ? false : $candidate_id;
        $title = empty($title) ? false : $title;
        $first_name = empty($first_name) ? false : $first_name;
        $last_name = empty($last_name) ? false : $last_name;
        $gender = empty($gender) ? false : $gender;
        $date_of_birth = empty($date_of_birth) ? false : $date_of_birth;
        $phone = empty($phone) ? false : $phone;
        $nationality = empty($nationality) ? false : $nationality;
        $county = empty($county) ? false : $county;
        $province = empty($province) ? false : $province;
        $district = empty($district) ? false : $district;
        $city = empty($city) ? false : $city;
        if (!$candidate_id)
            return false;
        $sql = "
            INSERT INTO `$this->tableInformation` (
                `candidate_id`,
                `title`,
                `first_name`,
                `last_name`,
                `gender`,
                `date_of_birth`,
                `phone`,
                `nationality`,
                `county`,
                `province`,
                `district`,
                `city`,
                `create_datetime`,
                `publish`)
            VALUES (
                '{$candidate_id}',
                '{$title}',
                '{$first_name}',
                '{$last_name}',
                '{$gender}',
                '{$date_of_birth}',
                '{$phone}',
                '{$nationality}',
                '{$county}',
                '{$province}',
                '{$district}',
                '{$city}',
                NOW(),
                1
            );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return $this->wpdb->insert_id;
    }

    private function addCareerProfile($post)
    {
        extract($post);
        $candidate_id = empty($candidate_id) ? false : $candidate_id;
        $year_of_work_exp = empty($year_of_work_exp) ? false : $year_of_work_exp;
        $last_position = empty($last_position) ? false : $last_position;
        $last_industry = empty($last_industry) ? false : $last_industry;
        $last_function = empty($last_function) ? false : $last_function;
        $last_month_salary = empty($last_month_salary) ? false : $last_month_salary;
        if (!$candidate_id)
            return false;
        $sql = "
            INSERT INTO `$this->tableCareerProfile` (
                `candidate_id`,
                `year_of_work_exp`,
                `last_position`,
                `last_industry`,
                `last_function`,
                `last_month_salary`,
                `create_datetime`,
                `publish`)
            VALUES (
                '{$candidate_id}',
                '{$year_of_work_exp}',
                '{$last_position}',
                '{$last_industry}',
                '{$last_function}',
                '{$last_month_salary}',
                NOW(),
                1
            );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return $this->wpdb->insert_id;
    }

    private function addDesiredJob($post)
    {
        extract($post);
        $candidate_id = empty($candidate_id) ? false : $candidate_id;
        $industry = empty($industry) ? false : $industry;
        $jop_function = empty($jop_function) ? false : $jop_function;
        $job_type = empty($job_type) ? false : $job_type;
        $expect_month_salary = empty($expect_month_salary) ? false : $expect_month_salary;
        $available_to_work = empty($available_to_work) ? false : $available_to_work;
        $start_date = empty($start_date) ? false : $start_date;
        if (!$candidate_id)
            return false;
        $sql = "
            INSERT INTO `$this->tableDesiredJob` (
                `candidate_id`,
                `industry`,
                `jop_function`,
                `job_type`,
                `expect_month_salary`,
                `available_to_work`,
                `start_date`,
                `create_datetime`,
                `publish`)
            VALUES (
                '{$candidate_id}',
                '{$industry}',
                '{$jop_function}',
                '{$job_type}',
                '{$expect_month_salary}',
                '{$available_to_work}',
                '{$start_date}',
                NOW(),
                1
            );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return $this->wpdb->insert_id;
    }

    public function addEducation($post)
    {
        extract($post);
        $candidate_id = empty($candidate_id) ? false : $candidate_id;
        $degree = empty($degree) ? false : $degree;
        $university = empty($university) ? false : $university;
        $education_period_from = empty($education_period_from) ? false : $education_period_from;
        $education_period_to = empty($education_period_to) ? false : $education_period_to;
        $grade_gpa = empty($grade_gpa) ? false : $grade_gpa;
        if (!$candidate_id)
            return false;
        $sql = "
            INSERT INTO `$this->tableEducation` (
                 `candidate_id`,
                 `degree`,
                 `university`,
                 `education_period_from`,
                 `education_period_to`,
                 `grade_gpa`,
                 `create_datetime`,
                 `publish`)
              VALUES (
                '{$candidate_id}',
                '{$degree}',
                '{$university}',
                '{$education_period_from}',
                '{$education_period_to}',
                '{$grade_gpa}',
                NOW(),
                1
              );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return $this->wpdb->insert_id;
    }

    public function addWorkExperience($post)
    {
        extract($post);
        $candidate_id = empty($candidate_id) ? false : $candidate_id;
        $employment_period_from = empty($employment_period_from) ? false : $employment_period_from;
        $employment_period_to = empty($employment_period_to) ? false : $employment_period_to;
        $company_name = empty($company_name) ? false : $company_name;
        $position = empty($position) ? false : $position;
        $month_salary = empty($month_salary) ? false : $month_salary;
        $job_duties = empty($job_duties) ? false : $job_duties;
        if (!$candidate_id)
            return false;
        $sql = "
            INSERT INTO `$this->tableWorkExperience` (
                `candidate_id`,
                `employment_period_from`,
                `employment_period_to`,
                `company_name`,
                `position`,
                `month_salary`,
                `job_duties`,
                `create_datetime`,
                `publish`)
            VALUES (
                '{$candidate_id}',
                '{$employment_period_from}',
                '{$employment_period_to}',
                '{$company_name}',
                '{$position}',
                '{$month_salary}',
                '{$job_duties}',
                NOW(),
                1
              );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return $this->wpdb->insert_id;
    }

    private function addSkillLanguages($post)
    {
        extract($post);
        $candidate_id = empty($candidate_id) ? false : $candidate_id;
        $japanese_skill = empty($japanese_skill) ? false : $japanese_skill;
        $japanese_speaking = empty($japanese_speaking) ? false : $japanese_speaking;
        $japanese_reading = empty($japanese_reading) ? false : $japanese_reading;
        $japanese_writing = empty($japanese_writing) ? false : $japanese_writing;
        $toeic_toefl_ielts = empty($toeic_toefl_ielts) ? false : $toeic_toefl_ielts;
        $toeic_toefl_ielts_score = empty($toeic_toefl_ielts_score) ? false : $toeic_toefl_ielts_score;
        $english_speaking = empty($english_speaking) ? false : $english_speaking;
        $english_reading = empty($english_reading) ? false : $english_reading;
        $english_writing = empty($english_writing) ? false : $english_writing;
        if (!$candidate_id)
            return false;
        $sql = "
            INSERT INTO `$this->tableSkillLanguages` (
                 `candidate_id`,
                 `japanese_skill`,
                 `japanese_speaking`,
                 `japanese_reading`,
                 `japanese_writing`,
                 `toeic_toefl_ielts`,
                 `toeic_toefl_ielts_score`,
                 `english_speaking`,
                 `english_reading`,
                 `english_writing`,
                 `create_datetime`,
                 `publish`)
            VALUES (
                '{$candidate_id}',
                '{$japanese_skill}',
                '{$japanese_speaking}',
                '{$japanese_reading}',
                '{$japanese_writing}',
                '{$toeic_toefl_ielts}',
                '{$toeic_toefl_ielts_score}',
                '{$english_speaking}',
                '{$english_reading}',
                '{$english_writing}',
                NOW(),
                1
              );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return $this->wpdb->insert_id;
    }

    public function addCandidate($post)
    {
        $fxrootpath = ABSPATH . 'wp-load.php';
        if (!file_exists($fxrootpath)) {
            return 'Set value $fxrootpath in file : pages/apply-employer-register.php ';
        }
        include_once($fxrootpath);
        extract($post);
        $email = empty($email) ? false : $email;
        $pass = empty($pass) ? false : $pass;
        $rePass = empty($rePass) ? false : $rePass;
        if ($pass != $rePass && $pass && $rePass) {
            return '<div class="font-color-BF2026"><p>Error! Check your password and confirm password.</p></div>';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return '<div class="font-color-BF2026"><p>Invalid email format.</p></div>';
        }
        list($username) = explode('@', $email);
        $userData = array(
            'user_login' => $username,
            'user_pass' => $pass,
            'user_email' => $email
        );
        $user_id = wp_insert_user($userData);

        if (!is_wp_error($user_id)) {
            $user_type = 'candidate';
            add_user_meta($user_id, 'user_type', $user_type);
            add_user_meta($user_id, 'user_status', 'Under verification process');
            $postData = $_POST;
            $postData['candidate_id'] = $user_id;
            $result = $this->addInformation($postData);
            if (!$result) {
                wp_revoke_user($user_id);
                wp_delete_user($user_id);
                return '<div class="font-color-BF2026"><p>Error add information for contact.</p></div>';
            }
            $result = $this->addCareerProfile($postData);
            if (!$result) {
                wp_revoke_user($user_id);
                wp_delete_user($user_id);
                return '<div class="font-color-BF2026"><p>Error add Career Profile for contact.</p></div>';
            }
            $result = $this->addDesiredJob($postData);
            if (!$result) {
                wp_revoke_user($user_id);
                wp_delete_user($user_id);
                return '<div class="font-color-BF2026"><p>Error add Desired Job for contact.</p></div>';
            }
            $result = $this->addSkillLanguages($postData);
            if (!$result) {
                wp_revoke_user($user_id);
                wp_delete_user($user_id);
                return '<div class="font-color-BF2026"><p>Error add Skill Languages for contact.</p></div>';
            }
        } else {
            $error_string = $user_id->get_error_message();
            return '<div class="font-color-BF2026"><p>' . $error_string . '</p></div>';
        }
        $this->setUserLogin($user_id);
        return '<div class="font-color-4BB748"><p>Add Success.</p></div>';
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

    public function editInformation($post)
    {
        extract($post);
        $information_id = empty($information_id) ? false : $information_id;
        $title = empty($title) ? false : $title;
        $first_name = empty($first_name) ? false : $first_name;
        $last_name = empty($last_name) ? false : $last_name;
        $gender = empty($gender) ? false : $gender;
        $date_of_birth = empty($date_of_birth) ? false : $date_of_birth;
//        if (!empty($date_of_birth)) {
//            list($dd, $mm, $yyyy) = explode('/', $date_of_birth);
//            if (checkdate($mm, $dd, $yyyy)) {
//                $date_of_birth = explode('/', $date_of_birth); //DateTime::createFromFormat('d/m/Y', $check_in);
//                $date_of_birth = $date_of_birth[2] . "-" . $date_of_birth[1] . "-" . $date_of_birth[0];
//            } else {
//                $date_of_birth = "0000-00-00";
//            }echo $date_of_birth;
//        } else {
//            $date_of_birth = "0000-00-00";
//        }
        $phone = empty($phone) ? false : $phone;
        $nationality = empty($nationality) ? false : $nationality;
        $county = empty($county) ? false : $county;
        $province = empty($province) ? false : $province;
        $district = empty($district) ? false : $district;
        $city = empty($city) ? false : $city;
        if (!$information_id) {
            $information_id = $this->addInformation($post);
            if (!$information_id)
                return '<div class="font-color-BF2026"><p>Error add Information.</p></div>';
        } else {
            $sql = "
            UPDATE `$this->tableInformation`
            SET
              `title` = '{$title}',
              `first_name` = '{$first_name}',
              `last_name` = '{$last_name}',
              `gender` = '{$gender}',
              `date_of_birth` = '{$date_of_birth}',
              `phone` = '{$phone}',
              `nationality` = '{$nationality}',
              `county` = '{$county}',
              `province` = '{$province}',
              `district` = '{$district}',
              `city` = '{$city}',
              `update_datetime` = NOW()
            WHERE `id` = '$information_id';
        ";
            $result = $this->wpdb->query($sql);
            if (!$result)
                return '<div class="font-color-BF2026"><p>Sorry Edit Error.</p></div>';
        }
        return '<div class="font-color-4BB748"><p>Edit Success.</p></div>';
    }

    public function editCareerProfile($post)
    {
        extract($post);
        $career_profile_id = empty($career_profile_id) ? false : $career_profile_id;
        $year_of_work_exp = empty($year_of_work_exp) ? false : $year_of_work_exp;
        $last_position = empty($last_position) ? false : $last_position;
        $last_industry = empty($last_industry) ? false : $last_industry;
        $last_function = empty($last_function) ? false : $last_function;
        $last_month_salary = empty($last_month_salary) ? false : $last_month_salary;
        if (!$career_profile_id) {
            $career_profile_id = $this->addCareerProfile($post);
            if (!$career_profile_id)
                return '<div class="font-color-BF2026"><p>Error add Career Profile.</p></div>';
        } else {
            $sql = "
            UPDATE `$this->tableCareerProfile`
            SET
              `year_of_work_exp` = '{$year_of_work_exp}',
              `last_position` = '{$last_position}',
              `last_industry` = '{$last_industry}',
              `last_function` = '{$last_function}',
              `last_month_salary` = '{$last_month_salary}',
              `update_datetime` = NOW()
            WHERE `id` = '$career_profile_id';
        ";
            $result = $this->wpdb->query($sql);
            if (!$result)
                return '<div class="font-color-BF2026"><p>Sorry Edit Error.</p></div>';
        }
        return '<div class="font-color-4BB748"><p>Edit Success.</p></div>';
    }

    public function editDesiredJob($post)
    {
        extract($post);
        $desired_job_id = empty($desired_job_id) ? false : $desired_job_id;
        $industry = empty($industry) ? false : $industry;
        $jop_function = empty($jop_function) ? false : $jop_function;
        $job_type = empty($job_type) ? false : $job_type;
        $expect_month_salary = empty($expect_month_salary) ? false : $expect_month_salary;
        $available_to_work = empty($available_to_work) ? false : $available_to_work;
        $start_date = empty($start_date) ? false : $start_date;
//        if (!empty($start_date)) {
//            list($dd, $mm, $yyyy) = explode('/', $start_date);
//            if (checkdate($mm, $dd, $yyyy)) {
//                $start_date = explode('/', $start_date); //DateTime::createFromFormat('d/m/Y', $check_in);
//                $start_date = $start_date[2] . "-" . $start_date[1] . "-" . $start_date[0];
//            } else {
//                $start_date = "0000-00-00";
//            }
//        } else {
//            $start_date = "0000-00-00";
//        }
        if (!$desired_job_id) {
            $desired_job_id = $this->addCareerProfile($post);
            if (!$desired_job_id)
                return '<div class="font-color-BF2026"><p>Error add Desired Job.</p></div>';
        } else {
            $sql = "
            UPDATE `$this->tableDesiredJob`
            SET
              `industry` = '{$industry}',
              `jop_function` = '{$jop_function}',
              `job_type` = '{$job_type}',
              `expect_month_salary` = '{$expect_month_salary}',
              `available_to_work` = '{$available_to_work}',
              `start_date` = '{$start_date}',
              `update_datetime` = NOW()
            WHERE `id` = '$desired_job_id';
        ";
            $result = $this->wpdb->query($sql);
            if (!$result)
                return '<div class="font-color-BF2026"><p>Sorry Edit Error.</p></div>';
        }
        return '<div class="font-color-4BB748"><p>Edit Success.</p></div>';
    }

    public function editEducation($post)
    {
        extract($post);
        $education_id = empty($education_id) ? false : $education_id;
        $degree = empty($degree) ? false : $degree;
        $university = empty($university) ? false : $university;
        $education_period_from = empty($education_period_from) ? false : $education_period_from;
        $education_period_to = empty($education_period_to) ? false : $education_period_to;
        $grade_gpa = empty($grade_gpa) ? false : $grade_gpa;
        if (!$education_id)
            return '<div class="font-color-BF2026"><p>Error no id.</p></div>';
        $sql = "
            UPDATE `$this->tableEducation`
            SET
              `degree` = '{$degree}',
              `university` = '{$university}',
              `education_period_from` = '{$education_period_from}',
              `education_period_to` = '{$education_period_to}',
              `grade_gpa` = '{$grade_gpa}',
              `update_datetime` = NOW()
            WHERE `id` = '$education_id';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return '<div class="font-color-BF2026"><p>Sorry Edit Error.</p></div>';
        return '<div class="font-color-4BB748"><p>Edit Success.</p></div>';
    }

    public function editWorkExperience($post)
    {
        extract($post);
        $work_experience_id = empty($work_experience_id) ? false : $work_experience_id;
        $employment_period_from = empty($employment_period_from) ? false : $employment_period_from;
        $employment_period_to = empty($employment_period_to) ? false : $employment_period_to;
        $company_name = empty($company_name) ? false : $company_name;
        $position = empty($position) ? false : $position;
        $month_salary = empty($month_salary) ? false : $month_salary;
        $job_duties = empty($job_duties) ? false : $job_duties;
        if (!$work_experience_id)
            return '<div class="font-color-BF2026"><p>Error no id.</p></div>';
        $sql = "
            UPDATE `$this->tableWorkExperience`
            SET
              `employment_period_from` = '{$employment_period_from}',
              `employment_period_to` = '{$employment_period_to}',
              `company_name` = '{$company_name}',
              `position` = '{$position}',
              `month_salary` = '{$month_salary}',
              `job_duties` = '{$job_duties}',
              `update_datetime` = NOW()
            WHERE `id` = '$work_experience_id';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return '<div class="font-color-BF2026"><p>Sorry Edit Error.</p></div>';
        return '<div class="font-color-4BB748"><p>Edit Success.</p></div>';
    }

    public function editSkillLanguages($post)
    {
        extract($post);
        $skill_languages_id = empty($skill_languages_id) ? false : $skill_languages_id;
        $japanese_skill = empty($japanese_skill) ? false : $japanese_skill;
        $japanese_speaking = empty($japanese_speaking) ? false : $japanese_speaking;
        $japanese_reading = empty($japanese_reading) ? false : $japanese_reading;
        $japanese_writing = empty($japanese_writing) ? false : $japanese_writing;
        $toeic_toefl_ielts = empty($toeic_toefl_ielts) ? false : $toeic_toefl_ielts;
        $toeic_toefl_ielts_score = empty($toeic_toefl_ielts_score) ? false : $toeic_toefl_ielts_score;
        $english_speaking = empty($english_speaking) ? false : $english_speaking;
        $english_reading = empty($english_reading) ? false : $english_reading;
        $english_writing = empty($english_writing) ? false : $english_writing;
        if (!$skill_languages_id) {
            $skill_languages_id = $this->addSkillLanguages($post);
            if (!$skill_languages_id)
                return '<div class="font-color-BF2026"><p>Error add Skill Languages.</p></div>';
        } else {
            $sql = "
            UPDATE `$this->tableSkillLanguages`
            SET
              `japanese_skill` = '{$japanese_skill}',
              `japanese_speaking` = '{$japanese_speaking}',
              `japanese_reading` = '{$japanese_reading}',
              `japanese_writing` = '{$japanese_writing}',
              `toeic_toefl_ielts` = '{$toeic_toefl_ielts}',
              `toeic_toefl_ielts_score` = '{$toeic_toefl_ielts_score}',
              `english_speaking` = '{$english_speaking}',
              `english_reading` = '{$english_reading}',
              `english_writing` = '{$english_writing}',
              `update_datetime` = NOW()
            WHERE `id` = '$skill_languages_id';
        ";
            $result = $this->wpdb->query($sql);
            if (!$result)
                return '<div class="font-color-BF2026"><p>Sorry Edit Error.</p></div>';
        }
        return '<div class="font-color-4BB748"><p>Edit Success.</p></div>';
    }

    function uploadAvatarImage($file)
    {
        $handle = new Upload($file);
        $upload_dir = wp_upload_dir();
//        echo get_template_directory() . '/library/res/save_data.txt';
        $dir_dest = $upload_dir['basedir'] . '/avatar' . $upload_dir['subdir'];

        $dir_pics = get_site_url() . "/"  . 'wp-content/uploads/avatar' . $upload_dir['subdir'];
        $arrayReturn = array();
        $filePath = 'wp-content/uploads/avatar' . $upload_dir['subdir'];;
        if ($handle->uploaded) {
            $handle->image_resize = true;
            $handle->image_ratio_y = true;
            $handle->image_x = 150;

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

    function addAvatarPath($user_id, $path)
    {
        return update_user_meta($user_id, 'avatar_path', $path);
    }

    function getAvatarPath($user_id)
    {
        $path = get_user_meta($user_id, 'avatar_path', true);
        $pathNonAvatar = get_template_directory_uri() . "/libs/images/non-avatar.jpg";
        if (empty($path)) {
            return $pathNonAvatar;
        }
        $file_headers = @get_headers(get_site_url() . "/"  . $path);
        if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
            return $pathNonAvatar;
        }
        return get_site_url() . "/"  . $path;
    }

    function deleteOldAvatar($user_id)
    {
        $path = get_user_meta($user_id, 'avatar_path', true);
        if (empty($path))
            return true;
        $file_headers = @get_headers(get_site_url() . "/"  . $path);
        if($file_headers[0] != 'HTTP/1.1 404 Not Found') {
            return unlink($path);
        }
        return true;
    }

    function returnMessage($msg, $error)
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
        return json_encode($arrayReturn);
    }

}