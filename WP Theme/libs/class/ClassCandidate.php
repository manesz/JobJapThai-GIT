<?php

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
                    <td><a href="javascript:educationSetValue(<?php echo $strSetValueForEdit; ?>);">Edit</a>|<a>Delete</a></td>
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
                ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td>From: <?php echo $value->employment_period_from; ?>
                    To: <?php echo $value->employment_period_to; ?></td>
                    <td><?php echo $value->company_name; ?></td>
                    <td><?php echo $value->position; ?></td>
                    <td><?php echo number_format($value->month_salary); ?></td>
                    <td><?php echo $value->job_duties; ?></td>
                    <td><a>Edit</a>|<a>Delete</a></td>
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
        update_usermeta($user_id, 'last_login', current_time('mysql'));
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
        return 'success';
    }

    public function addCompanyInfo($post)
    {
        $employer_id = isset($post['employer_id']) ? $post['employer_id'] : false;
        $contact_person = isset($post['employerContactPerson']) ? $post['employerContactPerson'] : false;
        $company_name = isset($post['employerContactCompanyName']) ? $post['employerContactCompanyName'] : false;
        $business_type = isset($post['employerContactBusinessType']) ? $post['employerContactBusinessType'] : false;
        $company_profile_and_business_oparation = isset($post['employerContactCompanyProfile']) ? $post['employerContactCompanyProfile'] : false;
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
              `company_profile_and_business_oparation`,
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
                '{$company_profile_and_business_oparation}',
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

    public function editCompanyInfo($post)
    {
        $employer_id = isset($post['employer_id']) ? $post['employer_id'] : false;
        $contact_person = isset($post['employerContactPerson']) ? $post['employerContactPerson'] : false;
        $company_name = isset($post['employerContactCompanyName']) ? $post['employerContactCompanyName'] : false;
        $business_type = isset($post['employerContactBusinessType']) ? $post['employerContactBusinessType'] : false;
        $company_profile_and_business_oparation = isset($post['employerContactCompanyProfile']) ? $post['employerContactCompanyProfile'] : false;
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
              `company_profile_and_business_oparation` = '{$company_profile_and_business_oparation}',
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


//    public function delete($id)
//    {
//        $sql = "
//            UPDATE $this->tableBannerSlide
//            SET publish = 0
//            WHERE 1
//            AND id = {$id};
//        ";
//        if ($id) {
//            $result = $this->wpdb->query($sql);
//            return $result;
//        } else {
//            return FALSE;
//        }
//    }
}