<?php

include('class.upload.php');

class Candidate
{
    private $wpdb;
    public $tableUser = "";
    public $tableUserMeta = "";
    public $tableInformation = "ics_candidate_information";
    public $tableCareerProfile = "ics_candidate_career_profile";
    public $tableDesiredJob = "ics_candidate_desired_job";
    public $tableEducation = "ics_candidate_education";
    public $tableWorkExperience = "ics_candidate_work_experience";
    public $tableYourExperience = "ics_candidate_your_experiences";
    public $tableSkillLanguages = "ics_candidate_skill_languages";
    public $tableRequestProfile = "ics_request_profile";
    public $tableCompanyInfo = "ics_company_information_for_contact";
    public $avatar_path_name = 'avatar_path';
    public $japanese_skill = array("Basic", "Fair", "Intermediate", "Good", "Fluent", "Native", "None");
    public $japanese_speaking = array("Basic", "Fair", "Intermediate", "Good", "Fluent", "Native", "None");
    public $japanese_reading = array("Basic", "Fair", "Intermediate", "Good", "Fluent", "Native", "None");
    public $japanese_writing = array("Basic", "Fair", "Intermediate", "Good", "Fluent", "Native", "None");
    public $english_speaking = array("Basic", "Fair", "Intermediate", "Good", "Fluent", "Native", "None");
    public $english_reading = array("Basic", "Fair", "Intermediate", "Good", "Fluent", "Native", "None");
    public $english_writing = array("Basic", "Fair", "Intermediate", "Good", "Fluent", "Native", "None");
    public $toeic_toefl_ielts = array("TOEIC", "TOEFL", "IELTS");
    public $jlpt = array("N1", "N2", "N3", "N4", "N5", "None");
    public $english_skill = array("Basic", "Fair", "Intermediate", "Good", "Fluent", "Native", "None");
    public $resumePath = "resume_path";

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
        $this->tableUser = $this->wpdb->users;
        $this->tableUserMeta = $this->wpdb->usermeta;
    }

    function getListUser($candidate_id = 0, $order_by = "", $user_type = "candidate")
    {
        $strAnd = $candidate_id ? " AND a.ID=$candidate_id" : "";
        $sql = "
            SELECT
              a.*,
              b.*,
              b.id as can_id
            FROM
              $this->tableUser a
            INNER JOIN
              $this->tableInformation b
            ON (a.ID = b.candidate_id)
            INNER JOIN
              $this->tableUserMeta c
            ON (
              c.user_id = a.ID
              AND c.meta_key = 'user_type'
              AND c.meta_value='$user_type'
              )
            WHERE 1
            $strAnd
            $order_by
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    function getListUserPreRegister($candidate_id = 0, $order_by = "", $user_type = "candidate")
    {
        $strAnd = $candidate_id ? " AND a.ID=$candidate_id" : "";
        $sql = "
            SELECT
              a.*,
              b.*,
              b.id as can_id,
              d.*,
              e.*,
              f.*
            FROM
              $this->tableUser a
            INNER JOIN
              $this->tableInformation b
            ON (a.ID = b.candidate_id)
            INNER JOIN
              $this->tableUserMeta c
            ON (
              c.user_id = a.ID
              AND c.meta_key = 'user_type'
              AND c.meta_value='$user_type'
              )
            INNER JOIN $this->tableYourExperience d
            ON (
              a.ID = d.candidate_id
            )
            INNER JOIN $this->tableSkillLanguages e
            ON (
              a.ID = e.candidate_id
            )
            INNER JOIN $this->tableDesiredJob F
            ON (
              a.ID = f.candidate_id
            )
            WHERE 1
            $strAnd
            GROUP BY a.ID
            $order_by
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    function getUser($candidate_id = 0, $email = false)
    {
        $getUser = get_userdata($candidate_id);
        return $getUser;
    }

    function searchCandidateByEmployer($degree = false, $university = false, $japanese_skill = false)
    {
        $strAnd = $degree ? " AND b.degree='$degree'" : "";
        $strAnd .= $university ? " AND b.university='$university'" : "";
        $strAnd .= $japanese_skill ? " AND d.japanese_skill='$japanese_skill'" : "";
        $sql = "
            SELECT
              a.*,
              b.*,
              c.*,
              d.*,
              e.publish AS request
            FROM
            $this->tableInformation a
            INNER JOIN $this->tableEducation b
            ON (a.candidate_id = b.candidate_id AND b.publish = 1)
            INNER JOIN (
                SELECT candidate_id, MAX(id) AS max_id
                FROM $this->tableEducation
                WHERE publish = 1
                GROUP BY candidate_id
            ) c ON (a.candidate_id = c.candidate_id AND c.max_id = b.id)
            INNER JOIN $this->tableSkillLanguages d
            ON (a.candidate_id = d.candidate_id AND d.publish = 1)
            LEFT JOIN $this->tableRequestProfile e
            ON (a.candidate_id = e.candidate_id AND e.publish = 1)
            WHERE 1
            AND a.publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    function getRequestResumeByEmployer($employer_id = 0, $candidate_id = 0)
    {
        $strAnd = $employer_id ? " AND e.employer_id=$employer_id" : "";
        $strAnd .= $candidate_id ? " AND a.candidate_id=$candidate_id" : "";
        $sql = "
            SELECT
              a.*,
              b.*,
              c.*,
              d.*,
              e.*
            FROM
            $this->tableInformation a
            INNER JOIN $this->tableEducation b
            ON (a.candidate_id = b.candidate_id AND b.publish = 1)
            INNER JOIN (
                SELECT candidate_id, MAX(id) AS max_id
                FROM $this->tableEducation
                WHERE publish = 1
                GROUP BY candidate_id
            ) c ON (a.candidate_id = c.candidate_id AND c.max_id = b.id)
            INNER JOIN $this->tableSkillLanguages d
            ON (a.candidate_id = d.candidate_id AND d.publish = 1)
            INNER JOIN $this->tableRequestProfile e
            ON (a.candidate_id = e.candidate_id AND e.publish = 1)
            WHERE 1
            AND a.publish = 1
            $strAnd
            ORDER BY e.id DESC
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    function getRequestResumeByCandidate($employer_id = 0, $candidate_id = 0, $str_order = " ORDER BY b.id DESC")
    {
        $strAnd = $employer_id ? " AND a.employer_id=$employer_id" : "";
        $strAnd .= $candidate_id ? " AND b.candidate_id=$candidate_id" : "";
        $strAnd .= $str_order;
        $sql = "
            SELECT
              a.*,
              b.*,
              b.id AS req_id,
              b.create_datetime AS req_date
            FROM
            $this->tableCompanyInfo a
            INNER JOIN $this->tableRequestProfile b
            ON (a.employer_id = b.employer_id AND b.publish = 1)
            WHERE 1
            AND a.publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    function setApproveRequestProfile($request_id)
    {
        $sql = "
            UPDATE $this->tableRequestProfile
            SET
              `approve` = 1,
              `update_datetime` = NOW()
            WHERE `id` = $request_id;
        ";
        $result = $this->wpdb->query($sql);
        if ($result)
            return $this->returnMessage("Send profile success.", false);
        else return $this->returnMessage("Send profile fail.", true);
    }

    function buildViewCandidateProfile($candidate_id)
    {
        $current_user = $this->getUser($candidate_id);
        $objInformation = $this->getInformation($candidate_id);
        if ($objInformation)
            extract((array)$objInformation[0]);

        $objSkillLanguage = $this->getSkillLanguages($candidate_id);
        if ($objSkillLanguage)
            extract((array)$objSkillLanguage[0]);
        $userType = get_user_meta($candidate_id, 'user_type', true);
        $getResumePath = get_user_meta($candidate_id, $this->resumePath, true);
        if ($userType == 'none_member') {
            $isNoneMember = true;
        } else $isNoneMember = false;
        ob_start();
        ?>
        <div class="panel-group" id="accordion" role="tablist">
            <?php if ($isNoneMember && $getResumePath): ?>
                <div class="panel panel-default" id="panel_career_profile">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="tab_panel collapsed" data-toggle="collapse" data-parent=""
                               href=""
                               aria-expanded="false" aria-controls="collapseTwo">
                                Attach Resume
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse in" role="tabpanel"
                         aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <a href="<?php echo $getResumePath; ?>"
                               target="_blank"><?php echo basename($getResumePath); ?></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="panel panel-default" id="panel_information">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a class="tab_panel" data-toggle="collapse" data-parent="#accordion"
                           href="#candPersonalInformation"
                           aria-expanded="true"
                           aria-controls="collapseOne">
                            PERSONAL INFORMATION
                        </a>
                    </h4>
                </div>
                <div id="candPersonalInformation" class="panel-collapse collapse in" role="tabpanel"
                     aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right clearfix"><label for="candEmail">Email</label></div>
                            <div class="col-md-8">
                                <span class="form-control"><a
                                        href="mailto:<?php echo $current_user->user_email; ?>"><?php echo $current_user->user_email; ?></a></span>
                            </div>
                        </div>
                        <?php if (!$isNoneMember): ?>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="title">Title</label></div>
                                <div class="col-md-8">
                                    <span class="form-control"><?php echo empty($title) ? "" : $title; ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right clearfix"><label for="first_name">First Name</label>
                            </div>
                            <div class="col-md-8">
                                <span class="form-control"><?php echo empty($first_name) ? "" : $first_name; ?></span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right clearfix"><label for="last_name">Surname / Last
                                    Name</label></div>
                            <div class="col-md-8">
                                <span class="form-control"><?php echo empty($last_name) ? "" : $last_name; ?></span>
                            </div>
                        </div>
                        <?php if (!$isNoneMember): ?>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="gender">Gender</label></div>
                                <div class="col-md-8">
                                    <span class="form-control"><?php echo empty($gender) ? "" : $gender; ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="date_of_birth">Date of
                                        birth</label>
                                </div>
                                <div class="col-md-8">
                                <span
                                    class="form-control"><?php echo empty($date_of_birth) ? "" : $date_of_birth; ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right clearfix"><label for="phone">Phone / Mobile</label></div>
                            <div class="col-md-8">
                                <span maxlength="50"
                                      id="phone" name="phone"
                                      class="form-control"><?php echo empty($phone) ? '' : $phone; ?></span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right clearfix"><label for="nationality">Nationality</label></div>
                            <div class="col-md-8">
                                <span class="form-control"><?php echo empty($nationality) ? "" : $nationality; ?></span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right clearfix"><label for="county">Country</label></div>
                            <div class="col-md-8">
                                <span class="form-control"><?php echo empty($county) ? "" : $county; ?></span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right clearfix"><label for="province">Province</label></div>
                            <div class="col-md-8">
                                <span class="form-control"><?php echo empty($province) ? "" : $province; ?></span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right clearfix"><label for="district">District</label></div>
                            <div class="col-md-8">
                                <span class="form-control"><?php echo empty($district) ? "" : $district; ?></span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right clearfix"><label for="city">City / Locality</label></div>
                            <div class="col-md-8">
                                <span class="form-control"><?php echo empty($city) ? "" : $city; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default" id="panel_career_profile">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="tab_panel collapsed" data-toggle="collapse" data-parent="#accordion"
                           href="#candCareerProfile"
                           aria-expanded="false" aria-controls="collapseTwo">
                            CAREER PROFILE
                        </a>
                    </h4>
                </div>
                <div id="candCareerProfile" class="panel-collapse collapse in" role="tabpanel"
                     aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <?php echo $this->buildCareerProfileTable($candidate_id, false); ?>
                    </div>
                </div>
            </div>

            <?php if (!$isNoneMember): ?>
                <div class="panel panel-default" id="panel_desired_job">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="tab_panel collapsed" data-toggle="collapse" data-parent="#accordion"
                               href="#candDesiredJob"
                               aria-expanded="false" aria-controls="collapseThree">
                                DESIRED JOB
                            </a>
                        </h4>
                    </div>
                    <div id="candDesiredJob" class="panel-collapse collapse in"
                         role="tabpanel" aria-labelledby="headingThree">

                        <div class="panel-body">
                            <?php echo $this->buildDesiredJobTable($candidate_id, false); ?>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default" id="panel_education">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="tab_panel collapsed" data-toggle="collapse" data-parent="#accordion"
                               href="#candEDUCATION"
                               aria-expanded="false" aria-controls="collapseThree">
                                EDUCATION
                            </a>
                        </h4>
                    </div>
                    <div id="candEDUCATION" class="panel-collapse collapse in"
                         role="tabpanel" aria-labelledby="headingThree">

                        <div class="panel-body">
                            <?php echo $this->buildEducationTable($candidate_id, false); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default" id="panel_work_experience">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="tab_panel collapsed" data-toggle="collapse" data-parent="#accordion"
                               href="#candWorkExperience"
                               aria-expanded="false" aria-controls="collapseThree">
                                WORK EXPERIENCE
                            </a>
                        </h4>
                    </div>
                    <div id="candWorkExperience" class="panel-collapse collapse in" role="tabpanel"
                         aria-labelledby="headingThree">
                        <div class="panel-body">
                            <?php echo $this->buildWorkExperienceTable($candidate_id, false); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="tab_panel collapsed" data-toggle="collapse" data-parent="#accordion"
                               href="#candSkillLanguages"
                               aria-expanded="false" aria-controls="collapseThree">
                                SKILL'S / LANGUAGES
                            </a>
                        </h4>
                    </div>
                    <div id="candSkillLanguages" class="panel-collapse collapse in" role="tabpanel"
                         aria-labelledby="headingThree">
                        <div class="panel-body">
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="japanese_skill">Japanese
                                        Skill</label></div>
                                <div class="col-md-8">
                            <span
                                class="form-control"><?php echo empty($japanese_skill) ? "" : $japanese_skill; ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="japanese_speaking">Japanese
                                        Speaking</label></div>
                                <div class="col-md-8">
                            <span
                                class="form-control"><?php echo empty($japanese_speaking) ? "" : $japanese_speaking; ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="japanese_reading">Japanese
                                        Reading</label></div>
                                <div class="col-md-8">
                            <span
                                class="form-control"><?php echo empty($japanese_reading) ? "" : $japanese_reading; ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="japanese_writing">Japanese
                                        Writing</label></div>
                                <div class="col-md-8">
                            <span
                                class="form-control"><?php echo empty($japanese_writing) ? "" : $japanese_writing; ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="toeic_toefl_ielts">TOEIC / TOEFL /
                                        IELTS</label></div>
                                <div class="col-md-8">
                            <span
                                class="form-control"><?php echo empty($toeic_toefl_ielts) ? "" : $toeic_toefl_ielts; ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"></div>
                                <div class="col-md-8">
                            <span
                                class="form-control"><?php echo empty($toeic_toefl_ielts_score) ? "" : $toeic_toefl_ielts_score; ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="english_speaking">English
                                        Speaking</label></div>
                                <div class="col-md-8">
                            <span
                                class="form-control"><?php echo empty($english_speaking) ? "" : $english_speaking; ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="english_reading">English
                                        Reading</label></div>
                                <div class="col-md-8">
                            <span
                                class="form-control"><?php echo empty($english_reading) ? "" : $english_reading; ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="english_writing">English
                                        Writing</label></div>
                                <div class="col-md-8">
                            <span
                                class="form-control"><?php echo empty($english_writing) ? "" : $english_writing; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function buildPreferredPositionsList()
    {
        $getDesiredJob = $this->getDesiredJob(0, 0, " AND expect_month_salary !='' ORDER BY id DESC");
        ob_start();
        ?>
        <ul class="clearfix no-padding">
            <?php foreach ($getDesiredJob as $value): ?>
                <li>
                    <div class="col-md-12 no-padding">
                        <span class="pull-left"><?php echo $value->job_type; ?></span>
                        <span
                            class="pull-right font-color-BF2026"><?php echo number_format($value->expect_month_salary); ?></span>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php

        $strBuild = ob_get_contents();
        ob_end_clean();
        return $strBuild;
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

    public function getCareerProfile($candidate_id = 0, $id = 0, $str_order = "")
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
            $str_order
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function getDesiredJob($candidate_id = 0, $id = 0, $str_and = "")
    {
        $strAnd = $candidate_id ? " AND candidate_id=$candidate_id" : "";
        $strAnd .= $id ? " AND id=$id" : "";
        $strAnd .= $str_and ? " $str_and" : "";
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

    function getEducation($candidate_id = 0, $id = 0, $str_order = "")
    {
        $strAnd = $candidate_id ? " AND candidate_id=$candidate_id" : "";
        $strAnd .= $id ? " AND id=$id" : "";
        $strAnd .= $str_order ? " $str_order" : "";
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


    function buildHtmlFormRegister()
    {
        ob_start();
        ?>
        <form method="post" id="form_candidate_step1" class="form-horizontal"
              data-bv-message="This value is not valid"
              data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
              data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
              data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">

            <div id="div_step1" class="col-md-12">
                <div id="div_step1" class="col-md-12">
                    <div class="col-md-4 text-right">
                        <label for="attach_resume">Attach resume</label><br/>
                        <small>(size max. 5MB)</small>
                    </div>
                    <div class="col-md-8">
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <span class="btn btn-default btn-file">
                                            <span class="fileinput-new"><span
                                                    class="glyphicon glyphicon glyphicon-file"></span>Select PDF file</span>
                                            <span class="fileinput-exists"><span
                                                    class="glyphicon glyphicon glyphicon-file"></span> Change</span>
                                            <input type="file" name="attach_resume" id="attach_resume"
                                                   accept="application/pdf">
                                        </span>
                            <span class="fileinput-filename"></span>
                            <a href="#" id="delete_file" class="close fileinput-exists" data-dismiss="fileinput"
                               style="float: none">&times;</a>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="col-md-4 text-right clearfix"><label for="first_name">Name<span
                                class="font-color-red">*</span></label></div>
                    <div class="col-md-8">
                        <input type="text" id="first_name" name="first_name" class="form-control"
                               maxlength="50" required=""
                            />
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="col-md-4 text-right clearfix"><label for="phone">Mobile<span
                                class="font-color-red">*</span></label></div>
                    <div class="col-md-8">
                        <input type="text" id="phone" name="phone" class="form-control"
                               maxlength="50" required=""
                            />
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="col-md-4 text-right clearfix"><label for="email">Email<span
                                class="font-color-red">*</span></label></div>
                    <div class="col-md-8">
                        <input type="text" id="email" name="email" class="form-control"
                               maxlength="50"
                               data-bv-emailaddress="true"
                               required data-bv-emailaddress-message="The input is not a valid email address"
                            />
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="col-md-4 text-right clearfix"><label for="line_id">Line ID</label></div>
                    <div class="col-md-8">
                        <input type="text" id="line_id" name="line_id" class="form-control"
                               maxlength="50"
                            />
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="col-md-4 text-right clearfix"><label for="step1_pass">Password<span
                                class="font-color-red">*</span></label>
                    </div>
                    <div class="col-md-8">
                        <input type="password" id="pass" name="pass" class="form-control"
                               maxlength="50"
                               required
                               data-bv-stringlength="true"
                               data-bv-stringlength-min="8"
                            />
                    </div>
                </div>

                <div class="form-group col-md-12" style="">
                    <button id="submitStep1" type="submit" class="btn btn-primary col-md-6 pull-right">Submit Form
                    </button>
<!--                    <button type="reset" class="btn btn-default pull-right btn_reset_from" style="border: none;">-->
<!--                        Reset-->
<!--                    </button>-->
                </div>
            </div>
            <!-- END: step 1 -->
        </form>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;

    }

    function candidateMenu()
    {
        $siteUrl = get_site_url();
        ob_start();
        ?>
        <div class="btn-group">
            <a href="<?php echo $siteUrl; ?>/candidate"
               class="btn btn-default <?php echo is_page("candidate-register") || is_page("candidate") ? 'active' : ''; ?>">Edit
                Resume</a>
            <a href="<?php echo $siteUrl; ?>/applied-job" class="btn btn-default <?php
            echo is_page("applied-job") ? 'active' : ''; ?>">Applied Job</a>
            <a href="<?php echo $siteUrl; ?>/favorite-job" class="btn btn-default <?php
            echo is_page("favorite-job") ? 'active' : ''; ?>">Favorite Job</a>
            <a href="<?php echo $siteUrl; ?>/favorite-employer" class="btn btn-default <?php
            echo is_page("favorite-employer") ? 'active' : ''; ?>">Favorite Employer</a>
            <a href="<?php echo $siteUrl; ?>/request-profile-by-company" class="btn btn-default <?php
            echo is_page("request-profile-by-company") ? 'active' : ''; ?>">Request Profile By Company</a>
            <!--            <a href="#" class="btn btn-default">Account Setting</a>-->
        </div>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }


    function buildHtmlEditProfile1($user_id, $is_backend = false)
    {
        $current_user = $this->getUser($user_id);
        $isLogin = true;
        $resumeCode = str_pad($user_id, 7, '0', STR_PAD_LEFT);
        $lastLogin = get_user_meta($user_id, 'last_login', true);
        $lastLogin = date_i18n('d M y', strtotime($lastLogin));
        $lastUpdate = get_the_modified_author();
        $lastUpdate = date_i18n('d M y', strtotime($lastUpdate));
        $memberSince = $current_user->user_registered;
        $memberSince = date_i18n('d M y', strtotime($memberSince));
        $get_image_avatar = $this->getAvatarPath($user_id);
        $str_image_avatar = "<img src='$get_image_avatar[path]' />";
        ob_start();
        ?>
        <script>
            <?php if ($isLogin): ?>
            $(document).ready(function () {
                $('#image_avatar').change(function () {
                    if ($(this).val() != '') {
                        var formData = new FormData();
                        formData.append('image_avatar', $(this)[0].files[0]);
                        formData.append('candidate_post', 'true');
                        formData.append('post_type', 'image_avatar');
                        formData.append('candidate_id', <?php echo $user_id; ?>);
                        showImgLoading();
                        $.ajax({
                            url: '',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function (result) {
                                showModalMessage(result.msg, 'Message Candidate');
                                path_avatar = result.path;
                                hideImgLoading();
                            },
                            error: function (result) {
                                showModalMessage(result.responseText, 'Message Candidate');
                                hideImgLoading();
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });

                    }
                });
            });
            <?php endif; ?>
        </script>
        <div id="sectProfile" class="col-md-12">
            <?php echo $is_backend ? "" : $this->candidateMenu(); ?>
            <div class="col-md-8" style="padding-top: 10px;">
                Resume Code: <span class=".font-color-BF2026" style=""><?php echo $resumeCode; ?></span><br/>
                <?php /*Status: <span class="font-color-BF2026" style="">Under verification process</span><br/> */ ?>
                Last Login Date: <?php echo $lastLogin; ?><br/>
                Last update: <?php echo $lastUpdate; ?><br/>
                Member since: <?php echo $memberSince; ?><br/>
                Your resume is in the verification process <br/>
                (The process will take 1-2 working days)

            </div>
            <div class="col-md-4" style="padding-top: 10px;">
                <?php //echo get_avatar($user_id, 100);
                //echo do_shortcode( '[avatar_upload]');
                ?>
                <!--            <input type="button" class="btn" value="Edit">-->
                <form>
                    <div></div>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div id="preview" class="fileinput-preview thumbnail" data-trigger="fileinput"
                             style="width: 150px;height: 150px;"><?php echo $str_image_avatar; ?></div>
                        <div>
                        <span class="btn btn-default btn-file">
                            <span class="fileinput-new">Select image</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="file" id="image_avatar" class="ephoto-upload" accept="image/jpeg"></span>
                            <a href="#" class="btn btn-default <?php
                            echo $get_image_avatar['have_image'] ? "" : "fileinput-exists";?>"
                               data-dismiss="fileinput"
                               onclick="removeAvatarImage(this);">Remove</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function buildHtmlEditProfile2($user_id, $is_backend = false, $edit = false)
    {
        $classOtherSetting = new OtherSetting($this->wpdb);
        $current_user = $this->getUser($user_id);
        $objInformation = $this->getInformation($user_id);
        if ($objInformation)
            extract((array)$objInformation[0]);

//        $objCareerProfile = $this->getCareerProfile($user_id);
//        if ($objCareerProfile)
//            extract((array)$objCareerProfile[0]);

//        $objDesiredJob = $this->getDesiredJob($user_id);
//        if ($objDesiredJob)
//            extract((array)$objDesiredJob[0]);
        $getResumePath = get_user_meta($user_id, $this->resumePath, true);
        $objSkillLanguage = $this->getSkillLanguages($user_id);
        if ($objSkillLanguage)
            extract((array)$objSkillLanguage[0]);
        ob_start();
        ?>
        <div id="div_step2" class="col-md-12">
            <div class="panel panel-default" id="panel_career_profile">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="tab_panel collapsed" data-toggle="collapse" data-parent=""
                           href=""
                           aria-expanded="false" aria-controls="collapseTwo">
                            Attach Resume
                        </a>
                    </h4>
                </div>
                <div class="panel-collapse collapse in" role="tabpanel"
                     aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <a href="<?php echo $getResumePath; ?>"
                           target="_blank"><?php echo basename($getResumePath); ?></a>
                    </div>
                </div>
            </div>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default" id="panel_information">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a class="tab_panel" data-toggle="collapse" data-parent="#accordion"
                               href="#candPersonalInformation"
                               aria-expanded="true"
                               aria-controls="collapseOne">
                                PERSONAL INFORMATION
                            </a>
                        </h4>
                    </div>
                    <div id="candPersonalInformation" class="panel-collapse collapse in" role="tabpanel"
                         aria-labelledby="headingOne">
                        <form method="post" id="form_candidate1" class="form-horizontal form_candidate">
                            <input type="hidden" name="information_id"
                                   value="<?php echo empty($objInformation) ? 0 : $objInformation[0]->id; ?>">
                            <input type="hidden" name="post_backend"
                                   value="<?php echo $is_backend ? 'true' : ''; ?>">

                            <div class="panel-body">
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="candEmail">User Name<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <span class="form-control"><?php echo $current_user->user_login; ?></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="candEmail">Email<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <span class="form-control"><?php echo $current_user->user_email; ?></span>
                                    </div>
                                </div>
                                <?php if (!$is_backend): ?>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-right clearfix"><label for="old_password">Old Password<span
                                                    class="font-color-red">*</span></label></div>
                                        <div class="col-md-8">
                                            <input type="password" id="old_password" name="old_password"
                                                   class="form-control"
                                                   data-bv-stringlength="true"
                                                   data-bv-stringlength-min="8"
                                                   maxlength="50"
                                                />
                                        </div>
                                    </div>

                                <?php endif; ?>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="new_password">New
                                            Password<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <input type="password" id="new_password" name="new_password"
                                               class="form-control"
                                               maxlength="50"
                                               data-bv-stringlength="true"
                                               data-bv-stringlength-min="8"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="title">Title<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <?php echo $classOtherSetting->buildDataToSelect($classOtherSetting->nameTitle, $title);?>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="first_name">First Name<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="first_name" name="first_name" class="form-control"
                                               maxlength="50"
                                               required="" value="<?php echo empty($first_name) ? "" : $first_name; ?>"
                                            />
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="last_name">Surname / Last
                                            Name<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="50"
                                               id="last_name" name="last_name" class="form-control"
                                               value="<?php echo empty($last_name) ? "" : $last_name; ?>"
                                               required/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="gender">Gender<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <select id="gender" name="gender" class="form-control" required>
                                            <option value="1" <?php echo $gender == "1" ? "selected" : ""; ?>>Male
                                            </option>
                                            <option value="2" <?php echo $gender == "2" ? "selected" : ""; ?>>Female
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="date_of_birth">Date of
                                            birth<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="20"
                                               id="date_of_birth" name="date_of_birth" class="form-control datepicker"
                                               required placeholder="dd/mm/yyyy | Ex. 23/02/1980"
                                               value="<?php echo empty($date_of_birth) ? '' : $date_of_birth; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="phone">Phone / Mobile<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="50"
                                               id="phone" name="phone" class="form-control" required
                                               value="<?php echo empty($phone) ? '' : $phone; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="line_id">Line ID</label></div>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="50"
                                               id="line_id" name="line_id" class="form-control"
                                               value="<?php echo empty($line_id) ? '' : $line_id; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="nationality">Nationality<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <select id="nationality" name="nationality" class="form-control" required>
                                            <option>Thailand</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="county">Country<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8"><select id="county" name="county" class="form-control"
                                                                  required>
                                            <option>Thailand</option>
                                        </select></div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="province">Province<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <?php
                                        $provinces = $classOtherSetting->getProvinces();
                                        if ($provinces) {
                                            ?>
                                            <select id="province" name="province" class="form-control"
                                                    required>
                                                <option value="0" selected="selected">---------------- Please select
                                                    ----------------
                                                </option>
                                                <?php foreach ($provinces as $value) {
                                                    ?>
                                                    <option <?php if (!empty($province)) echo $value->PROVINCE_ID == $province ? "selected" : ""; ?>
                                                    value="<?php echo $value->PROVINCE_ID; ?>"><?php echo $value->PROVINCE_NAME; ?></option><?php } ?>
                                            </select>
                                        <?php } else { ?> ลงฐานข้อมูล จังหวัดที่ <?php echo get_template_directory() . '/libs/res/thailand.sql' ?><?php } ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-12" id="aupher-select">
                                    <div class="col-md-4 text-right clearfix">
                                        <label for="district">District<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <select id="district" name="district"
                                                class="form-control" required>
                                            <option value="0">---------------- Please select ----------------</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12" id="distinct-select">
                                    <div class="col-md-4 text-right clearfix"><label for="sub_distinct">City /
                                            Locality<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <select id="sub_distinct" name="city"
                                                class="form-control" required>
                                            <option value="0">---------------- Please select ----------------</option>
                                        </select>
                                    </div>
                                </div>
                                <?php if ($is_backend): ?>
                                    <div class="form-group col-md-12" id="distinct-select">
                                        <div class="col-md-4 text-right clearfix"><label
                                                for="description">Description</label></div>
                                        <div class="col-md-8">
                                            <textarea class="form-control" id="description"
                                                      rows="8"
                                                      name="description"><?php echo empty($description) ? '' : $description; ?></textarea>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group col-md-12" style="">
                                    <button type="submit" class="btn btn-primary col-md-6 pull-right btn_submit_form">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-default pull-right btn_reset_from"
                                            style="border: none;">
                                        reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel panel-default" id="panel_career_profile">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="tab_panel collapsed" data-toggle="collapse" data-parent="#accordion"
                               href="#candCareerProfile"
                               aria-expanded="false" aria-controls="collapseTwo">
                                CAREER PROFILE
                            </a>
                        </h4>
                    </div>
                    <div id="candCareerProfile" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingTwo">
                        <form method="post" id="form_candidate2" class="form-horizontal form_candidate">
                            <input type="hidden" id="career_profile_id" name="career_profile_id" value="0">
                            <input type="hidden" id="post_type" name="post_type" value="add_career_profile"/>
                            <input type="hidden" name="candidate_id" value="<?php echo $user_id; ?>"/>

                            <div class="panel-body">
                                <div id="career_profile_list"></div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="year_of_work_exp">Year of Work
                                            Exp.<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="year_of_work_exp" name="year_of_work_exp"
                                               class="form-control" required=""
                                               placeholder="Year(s)" maxlength="50"
                                               value="<?php echo empty($year_of_work_exp) ? "" : $year_of_work_exp; ?>"/>
                                    <span
                                        class="font-color-red">please enter only number No.(-) or (.) and space.</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="last_position">Lasted
                                            Position<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="50" required=""
                                               id="last_position" name="last_position" class="form-control"
                                               value="<?php echo empty($last_position) ? "" : $last_position; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="last_industry">Lasted
                                            Industry<span
                                                class="font-color-red">*</span></label>
                                    </div>

                                    <div class="col-md-8">
                                        <input type="text" maxlength="50" required=""
                                               id="last_industry" name="last_industry" class="form-control"
                                               value="<?php echo empty($last_industry) ? "" : $last_industry; ?>"/>
                                    </div>
                                </div>
                                <!--                        <div class="form-group col-md-12">-->
                                <!--                            <div class="col-md-4 text-right clearfix"><label for="last_function">Lasted-->
                                <!--                                    Function</label>-->
                                <!--                            </div>-->
                                <!--                            <div class="col-md-8">-->
                                <!--                                <select id="last_function" name="last_function" class="form-control"-->
                                <!--                                    required="">-->
                                <!--                                    <option>xxxx</option>-->
                                <!--                                </select>-->
                                <!--                            </div>-->
                                <!--                        </div>-->
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="last_month_salary">Last
                                            Monthly
                                            Salary<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="last_month_salary" name="last_month_salary"
                                               class="form-control" required=""
                                               placeholder="THB" maxlength="50"
                                               value="<?php echo empty($last_month_salary) ? "" : $last_month_salary; ?>"/>
                                        <span class="font-color-red">please enter only number No.(-) or (.) and space example: 15000 or 20000, 100000</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 text-right">
                                    <input type="button" class="btn btn-default"
                                           value="Reset"
                                           onclick="resetPanelCareerProfileValue('reset');"/>
                                    <input type="button" class="btn btn-info"
                                           id="btn_cancel" value="Cancel" style="display: none;"
                                           onclick="$(this).hide();resetPanelCareerProfileValue('cancel');"/>
                                    <input type="submit" class="btn btn-success"
                                           onclick="data_for_post = $.param({
                                        candidate_post: 'true'
                                    });
                                    check_career_profile_post = true;"
                                           id="btn_add" value="Add"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel panel-default" id="panel_desired_job">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="tab_panel collapsed" data-toggle="collapse" data-parent="#accordion"
                               href="#candDesiredJob"
                               aria-expanded="false" aria-controls="collapseThree">
                                YOUR DESIRED JOB
                            </a>
                        </h4>
                    </div>
                    <div id="candDesiredJob" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingThree">
                        <form method="post" id="form_candidate3" class="form-horizontal form_candidate">
                            <input type="hidden" id="desired_job_id" name="desired_job_id" value="0">
                            <input type="hidden" id="post_type" name="post_type" value="add_desired_job"/>
                            <input type="hidden" name="candidate_id" value="<?php echo $user_id; ?>"/>

                            <div class="panel-body">
                                <div id="desired_job_list"></div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="industry">Industry<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="50" required=""
                                               id="industry" name="industry" class="form-control"
                                               value="<?php echo empty($industry) ? "" : $industry; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="job_position">Job
                                            Position<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <?php echo $classOtherSetting->buildDataToSelect('job_position',
                                            empty($job_position) ? "" : $job_position); ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="job_type">Job Type<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="50" required=""
                                               id="job_type" name="job_type" class="form-control"
                                               value="<?php echo empty($job_type) ? "" : $job_type; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="expect_month_salary">Expect
                                            Monthly
                                            Salary<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="expect_month_salary" name="expect_month_salary"
                                               class="form-control"
                                               placeholder="THB" maxlength="50"
                                               value="" required=""/>
                                        <span class="font-color-red">please enter only number No.(-) or (.) and space example: 15000 or 20000, 100000</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="available_to_work">Are you
                                            available to
                                            work
                                            ?<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="50" required=""
                                               id="available_to_work" name="available_to_work" class="form-control"
                                               value="<?php echo empty($available_to_work) ? "" : $available_to_work; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="start_date">Start Date<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="start_date" name="start_date" maxlength="20"
                                               class="form-control datepicker" placeholder="dd/mm/yyyy" required=""
                                               value=""/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 text-right">
                                    <input type="button" class="btn btn-default"
                                           value="Reset"
                                           onclick="resetPanelDesiredJobValue('reset');"/>
                                    <input type="button" class="btn btn-info"
                                           id="btn_cancel" value="Cancel" style="display: none;"
                                           onclick="resetPanelDesiredJobValue('cancel');"/>
                                    <input type="submit" class="btn btn-success"
                                           onclick="data_for_post = $.param({
                                        candidate_post: 'true'
                                    });
                                    check_desired_job_post = true;"
                                           id="btn_add" value="Add"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel panel-default" id="panel_education">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="tab_panel collapsed" data-toggle="collapse" data-parent="#accordion"
                               href="#candEDUCATION"
                               aria-expanded="false" aria-controls="collapseThree">
                                EDUCATION
                            </a>
                        </h4>
                    </div>
                    <div id="candEDUCATION" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingThree">
                        <form method="post" id="form_candidate4" class="form-horizontal form_candidate">
                            <input type="hidden" id="post_type" name="post_type" value="add_education"/>
                            <input type="hidden" id="education_id" name="education_id" value="0"/>
                            <input type="hidden" name="candidate_id" value="<?php echo $user_id; ?>"/>

                            <div class="panel-body">
                                <div id="education_list"></div>
                                <span>Please provide details of education institutions, dates attended and qualification attained.</span>

                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="degree">Degree<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="50" required=""
                                                         id="degree" name="degree" class="form-control"
                                                         value="<?php echo empty($degree) ? "" : $degree; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="university">University /
                                            Institute<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <input type="text" id="university" name="university" maxlength="80"
                                               class="form-control" placeholder="" required/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="education_period_from">Education
                                            Period<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="education_period_from" name="education_period_from"
                                               maxlength="50"
                                               class="form-control datepicker" placeholder="From: dd/mm/yyyy"
                                               required=""/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix">
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="education_period_to" name="education_period_to"
                                               maxlength="20"
                                               class="form-control datepicker" placeholder="To: dd/mm/yyyy"
                                               required=""/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="grade_gpa">Grade / GPA<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="grade_gpa" name="grade_gpa" class="form-control"
                                               placeholder="" required="" maxlength="20"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 text-right">
                                    <input type="button" class="btn btn-default"
                                           value="Reset"
                                           onclick="resetPanelEducationValue('reset');"/>
                                    <input type="button" class="btn btn-info"
                                           id="btn_cancel_education" value="Cancel" style="display: none;"
                                           onclick="$(this).hide();resetPanelEducationValue('cancel');"/>
                                    <input type="submit" class="btn btn-success"
                                           id="btn_add_education" value="Add Education"/>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="panel panel-default" id="panel_work_experience">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="tab_panel collapsed" data-toggle="collapse" data-parent="#accordion"
                               href="#candWorkExperience"
                               aria-expanded="false" aria-controls="collapseThree">
                                WORK EXPERIENCE
                            </a>
                        </h4>
                    </div>
                    <div id="candWorkExperience" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingThree">
                        <form method="post" id="form_candidate5" class="form-horizontal form_candidate">
                            <input type="hidden" id="post_type" name="post_type" value="add_work_experience"/>
                            <input type="hidden" id="work_experience_id" name="work_experience_id" value="0"/>
                            <input type="hidden" name="candidate_id" value="<?php echo $user_id; ?>"/>

                            <div class="panel-body">
                                <div id="work_experience_list"></div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="employment_period_from">Employment
                                            Period<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="employment_period_from" name="employment_period_from"
                                               class="form-control" maxlength="20"
                                               placeholder="From: mm/yyyy" required=""/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"></div>
                                    <div class="col-md-8">
                                        <input type="text" id="employment_period_to" name="employment_period_to"
                                               class="form-control" maxlength="20"
                                               placeholder="To: mm/yyyy" required=""/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="company_name">Company
                                            Name<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="company_name" name="company_name" class="form-control"
                                               placeholder="" required="" maxlength="80"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="position">Position<span
                                                class="font-color-red">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="position" name="position" class="form-control"
                                               placeholder="" required="" maxlength="50"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="month_salary">Monthly
                                            Salary<span
                                                class="font-color-red">*</span></label></div>
                                    <div class="col-md-8">
                                        <input type="text" id="month_salary" name="month_salary" class="form-control"
                                               placeholder="" required="" maxlength="50"/>
                                        <span class="font-color-red">please enter only number No.(-) or (.) and space example: 15000 or 20000, 100000</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="job_duties">Job Duties</label>
                                    </div>
                                    <div class="col-md-8">
                                <textarea id="job_duties" name="job_duties" class="form-control"
                                          rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 text-right">
                                    <input type="button" class="btn btn-default"
                                           value="Reset"
                                           onclick="resetPanelWorkExperienceValue('reset');"/>
                                    <input type="button" class="btn btn-info"
                                           id="btn_cancel_work_experience" value="Cancel" style="display: none;"
                                           onclick="$(this).hide();resetPanelWorkExperienceValue('cancel');"/>
                                    <input type="submit" class="btn btn-success"
                                           id="btn_add_work_experience" value="Add Work Experience"/>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="tab_panel collapsed" data-toggle="collapse" data-parent="#accordion"
                               href="#candSkillLanguages"
                               aria-expanded="false" aria-controls="collapseThree">
                                SKILL'S / LANGUAGES
                            </a>
                        </h4>
                    </div>
                    <div id="candSkillLanguages" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingThree">
                        <form method="post" id="form_candidate6" class="form-horizontal form_candidate">
                            <input type="hidden" name="skill_languages_id"
                                   value="<?php echo empty($objSkillLanguage) ? 0 : $objSkillLanguage[0]->id; ?>">

                            <div class="panel-body">
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="japanese_skill">Japanese
                                            Skill</label><span
                                            class="font-color-red">*</span></div>
                                    <div class="col-md-8">
                                        <select id="japanese_skill" name="japanese_skill" class="form-control"
                                                required="">
                                            <option value=""></option>
                                            <?php foreach ($this->japanese_skill as $value): ?>
                                                <option <?php echo $value == $japanese_skill ? "selected" : ""; ?>
                                                    value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="japanese_speaking">Japanese
                                            Speaking</label><span class="font-color-red">*</span></div>
                                    <div class="col-md-8">
                                        <select id="japanese_speaking" name="japanese_speaking" class="form-control"
                                                required="">
                                            <option value=""></option>
                                            <?php foreach ($this->japanese_speaking as $value): ?>
                                                <option <?php echo $value == $japanese_speaking ? "selected" : ""; ?>
                                                    value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="japanese_reading">Japanese
                                            Reading</label><span class="font-color-red">*</span></div>
                                    <div class="col-md-8">
                                        <select id="japanese_reading" name="japanese_reading" class="form-control"
                                                required="">
                                            <option value=""></option>
                                            <?php foreach ($this->japanese_reading as $value): ?>
                                                <option <?php echo $value == $japanese_reading ? "selected" : ""; ?>
                                                    value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="japanese_writing">Japanese
                                            Writing</label><span class="font-color-red">*</span></div>
                                    <div class="col-md-8">
                                        <select id="japanese_writing" name="japanese_writing" class="form-control"
                                                required="">
                                            <option value=""></option>
                                            <?php foreach ($this->japanese_writing as $value): ?>
                                                <option <?php echo $value == $japanese_writing ? "selected" : ""; ?>
                                                    value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="toeic_toefl_ielts">TOEIC /
                                            TOEFL /
                                            IELTS</label><span class="font-color-red">*</span></div>
                                    <div class="col-md-8">

                                        <select id="toeic_toefl_ielts" name="toeic_toefl_ielts" class="form-control"
                                                required="">
                                            <option value=""></option>
                                            <?php foreach ($this->toeic_toefl_ielts as $value): ?>
                                                <option <?php echo $value == $toeic_toefl_ielts ? "selected" : ""; ?>
                                                    value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"></div>
                                    <div class="col-md-8">
                                        <input type="text" id="toeic_toefl_ielts_score" name="toeic_toefl_ielts_score"
                                               class="form-control" placeholder="Your Score: 999" required=""
                                               maxlength="50"
                                               value="<?php echo empty($toeic_toefl_ielts_score) ? "" : $toeic_toefl_ielts_score; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="english_speaking">English
                                            Speaking</label><span
                                            class="font-color-red">*</span></div>
                                    <div class="col-md-8">
                                        <select id="english_speaking" name="english_speaking" class="form-control"
                                                required="">
                                            <option value=""></option>
                                            <?php foreach ($this->english_speaking as $value): ?>
                                                <option <?php echo $value == $english_speaking ? "selected" : ""; ?>
                                                    value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="english_reading">English
                                            Reading</label><span class="font-color-red">*</span></div>
                                    <div class="col-md-8">
                                        <select id="english_reading" name="english_reading" class="form-control"
                                                required="">
                                            <option value=""></option>
                                            <?php foreach ($this->english_reading as $value): ?>
                                                <option <?php echo $value == $english_reading ? "selected" : ""; ?>
                                                    value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-4 text-right clearfix"><label for="english_writing">English
                                            Writing</label><span class="font-color-red">*</span></div>
                                    <div class="col-md-8">
                                        <select id="english_writing" name="english_writing" class="form-control"
                                                required="">
                                            <option value=""></option>
                                            <?php foreach ($this->english_writing as $value): ?>
                                                <option <?php echo $value == $english_writing ? "selected" : ""; ?>
                                                    value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-12" style="">
                                    <button type="submit" class="btn btn-primary col-md-6 pull-right btn_submit_form">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-default pull-right btn_reset_from"
                                            style="border: none;">
                                        reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <script>

            var ajaxPageurl = '<?php echo get_home_url() ?>/';
            var ajaxDropurl = '<?php echo get_template_directory_uri() . '/libs/ajax'; ?>/';
            var proselect = {
                proval: 0,
                amval: 0,
                init: function () {
                    proselect.proval = $('#province').val();
                    proselect.selectProvince();
                    proselect.setEvent();
                },
                setEvent: function () {
                    $('#province').on('change', proselect.selectProvince);
                },
                selectProvince: function () {
                    proselect.proval = $('#province').val();
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
                        $('#district').append(mytxt);
                    });
                    if ($('#district').html()) {
                        proselect.selectAmphor();
                    }
                    $('#district').unbind('change');
                    $('#district').on('change', proselect.selectAmphor);
                },
                clearampporSelect: function () {
                    $('#district option[value!=0]').remove();
                    $('#district').val(0);
                    proselect.clearDistinctSelect();
                },
                clearDistinctSelect: function () {
                    $('#sub_distinct option[value!=0]').remove();
                    $('#sub_distinct').val(0);
                    $('#distinct-select').css('display', 'none');
                },
                selectAmphor: function () {
                    proselect.amval = $('#district').val();
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
                        $('#sub_distinct').append(mytxt);
                    });
                }
            };
            $(document).ready(function () {
                proselect.init();
            });
        </script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function buildCareerProfileTable($candidate_id = 0, $edit = true)
    {
        $objData = $this->getCareerProfile($candidate_id);
        ob_start();
        ?>
        <table border="1" class="table table-bordered table-hover">
            <tr>
                <td>#</td>
                <td>Year of Work Exp.</td>
                <td>Lasted Position</td>
                <td>Lasted Industry</td>
                <!--                <td>Lasted Function</td>-->
                <td>Last Monthly Salary</td>
                <?php if ($edit): ?>
                    <td style="width: 95px;"></td>
                <?php endif; ?>
            </tr>
            <?php foreach ($objData as $key => $value):
                $id = $key + 1;
                $strSetValueForEdit = "{" .
                    "id:$value->id," .
                    "year_of_work_exp:'$value->year_of_work_exp'," .
                    "last_position:'$value->last_position'," .
                    "last_industry:'$value->last_industry'," .
                    //"last_function:'$value->last_function'," .
                    "last_month_salary:'$value->last_month_salary'" .
                    "}";
                ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $value->year_of_work_exp; ?></td>
                    <td><?php echo $value->last_position; ?></td>
                    <td><?php echo $value->last_industry; ?></td>
                    <!--                    <td>--><?php //echo $value->last_function;
                    ?><!--</td>-->
                    <td><?php echo $value->last_month_salary; ?></td>
                    <?php if ($edit): ?>
                        <td>
                            <a href="javascript:careerProfileSetValue(<?php echo $strSetValueForEdit; ?>);">Edit</a> |
                            <a href="javascript:deleteCareerProfile(<?php echo $value->id; ?>);">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
        $strTable = ob_get_contents();
        ob_end_clean();

        return $strTable;
    }

    function buildDesiredJobTable($candidate_id = 0, $edit = true)
    {
        $objData = $this->getDesiredJob($candidate_id);
        ob_start();
        ?>
        <table border="1" class="table table-bordered table-hover">
            <tr>
                <td>#</td>
                <td>Industry</td>
                <td>Job Position</td>
                <td>Job Type</td>
                <td>Expect Monthly <br/>Salary</td>
                <td>Are you available <br/>to work ?</td>
                <td>Start Date</td>
                <?php if ($edit): ?>
                    <td style="width: 95px;"></td>
                <?php endif; ?>
            </tr>
            <?php foreach ($objData as $key => $value):
                $id = $key + 1;
                $strSetValueForEdit = "{" .
                    "id:$value->id," .
                    "industry:'$value->industry'," .
                    "job_position:'$value->job_position'," .
                    "job_type:'$value->job_type'," .
                    "expect_month_salary:'$value->expect_month_salary'," .
                    "available_to_work:'$value->available_to_work'," .
                    "start_date:'$value->start_date'" .
                    "}";
                ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $value->industry; ?></td>
                    <td><?php echo $value->job_position; ?></td>
                    <td><?php echo $value->job_type; ?></td>
                    <td><?php echo $value->expect_month_salary; ?></td>
                    <td><?php echo $value->available_to_work; ?></td>
                    <td><?php echo $value->start_date; ?></td>
                    <?php if ($edit): ?>
                        <td>
                            <a href="javascript:desiredJobSetValue(<?php echo $strSetValueForEdit; ?>);">Edit</a> |
                            <a href="javascript:deleteDesiredJob(<?php echo $value->id; ?>);">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
        $strTable = ob_get_contents();
        ob_end_clean();

        return $strTable;
    }

    public function buildEducationTable($candidate_id = 0, $edit = true)
    {
        $objEducation = $this->getEducation($candidate_id);
        ob_start();
        ?>
        <table border="1" class="table table-bordered table-hover">
            <tr>
                <td>#</td>
                <td>Degree</td>
                <td>University / Institute</td>
                <td>Education Period</td>
                <td>Grade / GPA</td>
                <?php if ($edit): ?>
                    <td style="width: 95px;"></td>
                <?php endif; ?>
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
                    <?php if ($edit): ?>
                        <td>
                            <a href="javascript:educationSetValue(<?php echo $strSetValueForEdit; ?>);">Edit</a> |
                            <a href="javascript:deleteEducation(<?php echo $value->id; ?>);">Delete</a>
                        </td>
                    <?php endif; ?>
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

    public function buildWorkExperienceTable($candidate_id = 0, $edit = true)
    {
        $objEducation = $this->getWorkExperience($candidate_id);
        ob_start();
        ?>
        <table border="1" class="table table-bordered table-hover">
            <tr>
                <td>#</td>
                <td>Employment Period</td>
                <td>Company Name</td>
                <td>Position</td>
                <td>Monthly Salary</td>
                <td>Job Duties</td>
                <?php if ($edit): ?>
                    <td style="width: 95px;"></td>
                <?php endif; ?>
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
                    <?php if ($edit): ?>
                        <td>
                            <a href="javascript:workExperienceSetValue(<?php echo $strSetValueForEdit; ?>);">Edit</a>|
                            <a href="javascript:deleteWorkExperience(<?php echo $value->id; ?>);">Delete</a>
                        </td>
                    <?php endif; ?>
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

    function addInformation($post)
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
        $line_id = empty($line_id) ? false : $line_id;
        $description = empty($description) ? false : $description;
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
                `line_id`,
                `nationality`,
                `county`,
                `province`,
                `district`,
                `city`,
                `description`,
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
                '{$line_id}',
                '{$nationality}',
                '{$county}',
                '{$province}',
                '{$district}',
                '{$city}',
                '{$description}',
                NOW(),
                1
            );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return $this->wpdb->insert_id;
    }

    function addCareerProfile($post)
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

    function addDesiredJob($post)
    {
        extract($post);
        $candidate_id = empty($candidate_id) ? false : $candidate_id;
        $industry = empty($industry) ? false : $industry;
        $job_position = empty($job_position) ? false : $job_position;
        $job_location = empty($job_location) ? false : $job_location;
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
                `job_position`,
                `job_location`,
                `job_type`,
                `expect_month_salary`,
                `available_to_work`,
                `start_date`,
                `create_datetime`,
                `publish`)
            VALUES (
                '{$candidate_id}',
                '{$industry}',
                '{$job_position}',
                '{$job_location}',
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

    function addYourExperience($post)
    {
        extract($post);
        $candidate_id = empty($candidate_id) ? false : $candidate_id;
        $candRegistJPStudyExp = empty($candRegistJPStudyExp) ? false : $candRegistJPStudyExp;
        $candRegistJPWorkExp = empty($candRegistJPWorkExp) ? false : $candRegistJPWorkExp;
        $candRegistJPCompWorkExp = empty($candRegistJPCompWorkExp) ? false : $candRegistJPCompWorkExp;
        if (!$candidate_id)
            return false;
        $sql = "
            INSERT INTO `$this->tableYourExperience` (
                `candidate_id`,
                `studying_in_japan`,
                `working_in_japan`,
                `working_in_japan_company`,
                `create_datetime`,
                `publish`)
            VALUES (
                '{$candidate_id}',
                '{$candRegistJPStudyExp}',
                '{$candRegistJPWorkExp}',
                '{$candRegistJPCompWorkExp}',
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

    function addPreRegister($post)
    {
        $fxrootpath = ABSPATH . 'wp-load.php';
        if (!file_exists($fxrootpath)) {
            return $this->returnMessage('Error path file "wp-load.php"', true, false);
        }
        include_once($fxrootpath);
        extract($post);
        $email = empty($email) ? false : $email;
        $pass = "1234asdf";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->returnMessage('Invalid email format.', true, false);
        }
        list($username) = explode('@', $email);
        $generatedKey = sha1(mt_rand(10000, 99999) . time() . $email);
        $userData = array(
            'user_login' => $username,
            'user_pass' => $pass,
            'user_email' => $email,
        );
        $user_id = wp_insert_user($userData);

        $user_type = 'candidate';
        if (!is_wp_error($user_id)) {
            add_user_meta($user_id, 'user_type', $user_type);
            add_user_meta($user_id, 'user_status', 'Under verification process');
            add_user_meta($user_id, "activation_key", $generatedKey);
            add_user_meta($user_id, "activation_confirm", "true");
            $postData = $post;
            $postData['candidate_id'] = $user_id;
            $result = $this->addInformation($postData);
            if (!$result) {
                wp_revoke_user($user_id);
                wp_delete_user($user_id);
                return $this->returnMessage('Error add information for contact.', true, false);
            }
            $result = $this->addSkillLanguages($postData);
            if (!$result) {
                wp_revoke_user($user_id);
                wp_delete_user($user_id);
                return $this->returnMessage('Error add Skill Languages for contact.', true, false);
            }
            $result = $this->addYourExperience($postData);
            if (!$result) {
                wp_revoke_user($user_id);
                wp_delete_user($user_id);
                return $this->returnMessage('Error add Your Experience for contact.', true, false);
            }
            $result = $this->addDesiredJob($postData);
            if (!$result) {
                wp_revoke_user($user_id);
                wp_delete_user($user_id);
                return $this->returnMessage('Error add Desired Job for contact.', true, false);
            }
            $message = array(
                "msg" => 'Register Success.',
                'key' => $generatedKey,
                'pass' => $pass,
                'candidate_id' => $user_id
            );
            return $this->returnMessage($message, false, false);
        } else {
            $error_string = $user_id->get_error_message();
            return $this->returnMessage($error_string, true, false);
        }
    }

    function addCandidate($post)
    {
        $fxrootpath = ABSPATH . 'wp-load.php';
        if (!file_exists($fxrootpath)) {
            return $this->returnMessage('Error path file "wp-load.php"', true, false);
        }
        include_once($fxrootpath);
        extract($post);
        $getPostBackend = empty($post['post_backend']) ? false : $post['post_backend'];
        $email = empty($email) ? false : $email;
        //$pass = "jjt_password";
        $pass = empty($pass) ? false : $pass;
        $rePass = empty($rePass) ? false : $rePass;
        if ($pass != $rePass && $pass && $rePass) {
            return $this->returnMessage('Error! Check your password and confirm password.', true, false);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->returnMessage('Invalid email format.', true, false);
        }
        list($username) = explode('@', $email);
        $generatedKey = sha1(mt_rand(10000, 99999) . time() . $email);
        $userData = array(
            'user_login' => $username,
            'user_pass' => $pass,
            'user_email' => $email,
        );
        $user_id = wp_insert_user($userData);

        $user_type = 'candidate';
        if (!is_wp_error($user_id)) {
            add_user_meta($user_id, 'user_type', $user_type);
            add_user_meta($user_id, 'user_status', 'Under verification process');
            add_user_meta($user_id, "activation_key", $generatedKey);
            add_user_meta($user_id, "activation_confirm", $getPostBackend ? "true" : "false");
            $postData = $post;
            $postData['candidate_id'] = $user_id;
            $result = $this->addInformation($postData);
            if (!$result) {
                wp_revoke_user($user_id);
                wp_delete_user($user_id);
                return $this->returnMessage('Error add information for contact.', true, false);
            }
//            $result = $this->addCareerProfile($postData);
//            if (!$result) {
//                wp_revoke_user($user_id);
//                wp_delete_user($user_id);
//                return $this->returnMessage('Error add Career Profile for contact.', true, false);
//            }
//            $result = $this->addDesiredJob($postData);
//            if (!$result) {
//                wp_revoke_user($user_id);
//                wp_delete_user($user_id);
//                return $this->returnMessage('Error add Desired Job for contact.', true, false);
//            }
            $result = $this->addSkillLanguages($postData);
            if (!$result) {
                wp_revoke_user($user_id);
                wp_delete_user($user_id);
                return $this->returnMessage('Error add Skill Languages for contact.', true, false);
            }
            $message = array("msg" => 'Register Success.', 'key' => $generatedKey, 'candidate_id' => $user_id);
            return $this->returnMessage($message, false, false);
        } else {
            $error_string = $user_id->get_error_message();
            if ($user_id->get_error_code() == "existing_user_login") {
                $getUser = get_user_by('email', $email);
                $getUserType = get_user_meta($user_id, 'user_type');
                if ($getUserType == "none_member") {
                    $user_id = $getUser->ID;
                    update_user_meta($user_id, 'user_type', $user_type);
                    update_user_meta($user_id, 'user_status', 'Under verification process');
                    update_user_meta($user_id, "activation_key", $generatedKey);
                    update_user_meta($user_id, "activation_confirm", $getPostBackend ? "true" : "false");

                    $message = array("msg" => 'Register Success.', 'key' => $generatedKey, 'candidate_id' => $user_id);
                    return $this->returnMessage($message, false, false);
                }
            }
            return $this->returnMessage($error_string, true, false);
        }
    }

    function addNoneMember($post)
    {
        $fxrootpath = ABSPATH . 'wp-load.php';
        if (!file_exists($fxrootpath)) {
            return $this->returnMessage('Error path file "wp-load.php"', true, false);
        }
        include_once($fxrootpath);
        extract($post);
        $email = empty($nm_email) ? false : $nm_email;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->returnMessage('Invalid email format.', true, false);
        }
        list($username) = explode('@', $email);
        $generatedKey = sha1(mt_rand(10000, 99999) . time() . $email);
        $userData = array(
            'user_login' => $username,
            'user_pass' => $generatedKey,
            'user_email' => $email,
        );
        $user_id = wp_insert_user($userData);
        if (!is_wp_error($user_id)) {
            $user_type = 'none_member';
            add_user_meta($user_id, 'user_type', $user_type);
            add_user_meta($user_id, 'user_status', 'Under verification process');
            add_user_meta($user_id, "activation_key", $generatedKey);
            add_user_meta($user_id, "activation_confirm", "false");
            $postData = $post;
            $postData['candidate_id'] = $user_id;
            $result = $this->addInformation($postData);
            if (!$result) {
                wp_revoke_user($user_id);
                wp_delete_user($user_id);
                return $this->returnMessage('Error add information for contact.', true, false);
            }
            $result = $this->addCareerProfile($postData);
            if (!$result) {
                wp_revoke_user($user_id);
                wp_delete_user($user_id);
                return $this->returnMessage('Error add Career Profile for contact.', true, false);
            }
            $message = array(
                "msg" => 'Apply job success.',
                'key' => $generatedKey,
                'candidate_id' => $user_id
            );
            return $this->returnMessage($message, false, false);
        } else {
            $getUser = get_user_by('email', $email);
            $user_id = $getUser->ID;
            $postData = $post;
            $postData['candidate_id'] = $user_id;

            $result = $this->editInformationForNoneMember($postData);
            if (!$result) {
                return $this->returnMessage('Error Personal details.', true, false);
            }

            $getCareerProfile = $this->getCareerProfile($user_id, " ORDER BY id DESC");
            if (!$getCareerProfile) {
                $result = $this->addCareerProfile($postData);
                if (!$result) {
                    return $this->returnMessage('Error add Career Profile.', true, false);
                }
            } else {
                $postData['career_profile_id'] = $getCareerProfile[0]->id;
                $result = $this->editCareerProfile($postData, false);
                if ($result['error']) {
                    return $this->returnMessage($result, $result['error'], false);
                }
            }
            $message = array(
                "msg" => 'Apply job success.',
                'key' => $generatedKey,
                'candidate_id' => $user_id
            );
            return $this->returnMessage($message, false, false);
        }
    }

    function setAttachResumePath($candidate_id, $path)
    {
        update_user_meta($candidate_id, $this->resumePath, $path);
    }

    function convertFileName($file, $candidate_id){
        $pathInfo = pathinfo($file['name']);
        $fileType = $pathInfo['extension'];
//        $fileName = $pathInfo['name'];
//        $fileName = iconv("UTF-8", "windows-874", $fileName);
//        $fileName = utf8_encode($fileName);
//        $fileName = mb_convert_encoding($fileName, 'windows-874');
        $fileName = date_i18n("Y-m-d_Hms_") . $candidate_id;
        $file['name'] = "resume_$fileName.$fileType";
        return $file;
    }

    function addAttachResume($file, $candidate_id)
    {
        $file = $this->convertFileName($file, $candidate_id);
        $handle = new Upload($file);
        $upload_dir = wp_upload_dir();
        $dir_dest = $upload_dir['basedir'] . "/resume/$candidate_id/";

        $dir_file = $upload_dir['baseurl'] . "/resume/$candidate_id/";
        $arrayReturn = array();
//        $filePath = 'wp-content/uploads/avatar' . $upload_dir['subdir'];;
        if ($handle->uploaded) {
//            $handle->image_resize = true;
//            $handle->image_ratio_y = true;
//            $handle->image_x = $image_x;

            // yes, the file is on the server
            // now, we start the upload 'process'. That is, to copy the uploaded file
            // from its temporary location to the wanted location
            // It could be something like $handle->Process('/home/www/my_uploads/');
            $handle->Process($dir_dest);

            // we check if everything went OK
            if ($handle->processed) {
                $dir_file .= $handle->file_dst_name;
//                $filePath .= '/' . $handle->file_dst_name;
                $arrayReturn['error'] = false;
                // everything was fine !
                $msgReturn = '<p class="result">';
                $msgReturn .= '  <b>File uploaded with success</b><br />';
                $msgReturn .= '  File: <a target="_blank" href="' . $dir_file . '">' .
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
        $arrayReturn['path'] = $dir_file;
        return $arrayReturn;
    }

    function editInformation($post)
    {
        extract($post);
        $candidate_id = empty($candidate_id) ? 0 : $candidate_id;
        $post_backend = empty($post_backend) ? false : $post_backend;
        $information_id = empty($information_id) ? false : $information_id;
        $new_password = empty($new_password) ? false : $new_password;
        $old_password = empty($old_password) ? false : $old_password;
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
        $line_id = empty($line_id) ? false : $line_id;
        if ($post_backend)
            $description = empty($description) ? "''" : "'$description'";
        else $description = "`description`";

        if (!$information_id) {
            $information_id = $this->addInformation($post);
            if (!$information_id)
                return $this->returnMessage('Error not Information id.', true);
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
                  `line_id` = '{$line_id}',
                  `nationality` = '{$nationality}',
                  `county` = '{$county}',
                  `province` = '{$province}',
                  `district` = '{$district}',
                  `city` = '{$city}',
                  `description` = $description,
                  `update_datetime` = NOW()
                WHERE `id` = '$information_id';
            ";
            $result = $this->wpdb->query($sql);
            if (!$result)
                return $this->returnMessage('Sorry Edit Error.', true);

            if ($new_password) { //echo $new_password;echo $old_password;
                $current_user = $this->getUser($candidate_id);
                $user = get_user_by('login', $current_user->user_login);
                $checkOldPass = $post_backend ? true : wp_check_password($old_password, $user->data->user_pass, $user->ID);
                if ($user && $checkOldPass) {
                    wp_set_password($new_password, $user->ID);
                    if (!$post_backend)
                        return $this->returnMessage('<script>setTimeout(function(){window.location.reload()}, 3000);</script>Edit Success.', false);
                } else {
                    return $this->returnMessage('Error check old password.', true);
                }
            }
        }/*
        if ($post_backend == "true") {
            update_user_meta($candidate_id, "activation_confirm", "true");
        }*/
        return $this->returnMessage('Edit Success.', false);
    }

    function editInformationForNoneMember($post)
    {
        extract($post);
        $candidate_id = empty($candidate_id) ? false : $candidate_id;
        $first_name = empty($first_name) ? false : $first_name;
        $last_name = empty($last_name) ? false : $last_name;
        $phone = empty($phone) ? false : $phone;
        $nationality = empty($nationality) ? false : $nationality;
        $county = empty($county) ? false : $county;
        $province = empty($province) ? false : $province;
        $district = empty($district) ? false : $district;
        $city = empty($city) ? false : $city;

        $sql = "
            UPDATE `$this->tableInformation`
            SET
              `first_name` = '{$first_name}',
              `last_name` = '{$last_name}',
              `phone` = '{$phone}',
              `nationality` = '{$nationality}',
              `county` = '{$county}',
              `province` = '{$province}',
              `district` = '{$district}',
              `city` = '{$city}',
              `update_datetime` = NOW()
            WHERE `candidate_id` = '$candidate_id';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return true;
    }

    function editCareerProfile($post, $return_json = true)
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
                return $this->returnMessage('Error add Career Profile.', true, $return_json);
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
                return $this->returnMessage('Sorry Edit Error.', true, $return_json);
        }
        return $this->returnMessage('Edit Success.', false, $return_json);
    }

    function editDesiredJob($post)
    {
        extract($post);
        $desired_job_id = empty($desired_job_id) ? false : $desired_job_id;
        $industry = empty($industry) ? false : $industry;
        $job_position = empty($job_position) ? false : $job_position;
        $job_location = empty($job_location) ? false : $job_location;
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
                return $this->returnMessage('Error add Desired Job.', true);
        } else {
            $sql = "
            UPDATE `$this->tableDesiredJob`
            SET
              `industry` = '{$industry}',
              `job_position` = '{$job_position}',
              `job_location` = '{$job_location}',
              `job_type` = '{$job_type}',
              `expect_month_salary` = '{$expect_month_salary}',
              `available_to_work` = '{$available_to_work}',
              `start_date` = '{$start_date}',
              `update_datetime` = NOW()
            WHERE `id` = '$desired_job_id';
        ";
            $result = $this->wpdb->query($sql);
            if (!$result)
                return $this->returnMessage('Sorry Edit Error.', true);
        }
        return $this->returnMessage('Edit Success.', false);
    }

    function editEducation($post)
    {
        extract($post);
        $education_id = empty($education_id) ? false : $education_id;
        $degree = empty($degree) ? false : $degree;
        $university = empty($university) ? false : $university;
        $education_period_from = empty($education_period_from) ? false : $education_period_from;
        $education_period_to = empty($education_period_to) ? false : $education_period_to;
        $grade_gpa = empty($grade_gpa) ? false : $grade_gpa;
        if (!$education_id)
            return $this->returnMessage('Error no id.', true);
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
            return $this->returnMessage('Sorry Edit Error.', true);
        return $this->returnMessage('Edit Success.', false);
    }

    function editYourExperience($post)
    {
        extract($post);
        $candidate_id = empty($candidate_id) ? false : $candidate_id;
        $candRegistJPStudyExp = empty($candRegistJPStudyExp) ? false : $candRegistJPStudyExp;
        $candRegistJPWorkExp = empty($candRegistJPWorkExp) ? false : $candRegistJPWorkExp;
        $candRegistJPCompWorkExp = empty($candRegistJPCompWorkExp) ? false : $candRegistJPCompWorkExp;
        if (!$candidate_id)
            return $this->returnMessage('Error no id.', true);
        $sql = "
            UPDATE `$this->tableYourExperience`
            SET
              `studying_in_japan` = '{$candRegistJPStudyExp}',
              `working_in_japan` = '{$candRegistJPWorkExp}',
              `working_in_japan_company` = '{$candRegistJPCompWorkExp}',
              `update_datetime` = NOW()
            WHERE `id` = '$candidate_id';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return $this->returnMessage('Sorry Edit Error.', true);
        return $this->returnMessage('Edit Success.', false);
    }

    function deleteCareerProfile($post)
    {
        extract($post);
        $career_profile_id = empty($career_profile_id) ? false : $career_profile_id;
        if (!$career_profile_id)
            return $this->returnMessage('Error no id.', true);
        $sql = "
            UPDATE `$this->tableCareerProfile`
            SET
              `update_datetime` = NOW(),
              `publish` = 0
            WHERE `id` = '$career_profile_id';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return $this->returnMessage('Sorry Edit Error.', true);
        return $this->returnMessage('Delete Success.', false);
    }

    function deleteDesiredJob($post)
    {
        extract($post);
        $desired_job_id = empty($desired_job_id) ? false : $desired_job_id;
        if (!$desired_job_id)
            return $this->returnMessage('Error no id.', true);
        $sql = "
            UPDATE `$this->tableDesiredJob`
            SET
              `update_datetime` = NOW(),
              `publish` = 0
            WHERE `id` = '$desired_job_id';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return $this->returnMessage('Sorry Edit Error.', true);
        return $this->returnMessage('Delete Success.', false);
    }

    function deleteEducation($post)
    {
        extract($post);
        $education_id = empty($education_id) ? false : $education_id;
        if (!$education_id)
            return $this->returnMessage('Error no id.', true);
        $sql = "
            UPDATE `$this->tableEducation`
            SET
              `update_datetime` = NOW(),
              `publish` = 0
            WHERE `id` = '$education_id';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return $this->returnMessage('Sorry Edit Error.', true);
        return $this->returnMessage('Delete Success.', false);
    }

    function editWorkExperience($post)
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
            return 'Error no id.';
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
            return $this->returnMessage('Sorry Edit Error.', true);
        return $this->returnMessage('Edit Success.', false);
    }

    function deleteWorkExperience($post)
    {
        extract($post);
        $work_experience_id = empty($work_experience_id) ? false : $work_experience_id;
        if (!$work_experience_id)
            return $this->returnMessage('Error no id.', true);
        $sql = "
            UPDATE `$this->tableWorkExperience`
            SET
              `update_datetime` = NOW(),
              `publish` = 0
            WHERE `id` = '$work_experience_id';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return $this->returnMessage('Sorry Edit Error.', true);
        return $this->returnMessage('Delete Success.', false);
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
                return $this->returnMessage('Error add Skill Languages.', true);
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
                return $this->returnMessage('Sorry Edit Error.', true);
        }
        return $this->returnMessage('Edit Success.', false);
    }

    function uploadAvatarImage($file, $image_x = 150)
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

    function setAvatarPath($user_id, $path)
    {
        return update_user_meta($user_id, $this->avatar_path_name, $path);
    }

    function getAvatarPath($user_id, $employer = false)
    {
        $haveImage = true;
        $pathImage = get_user_meta($user_id, $this->avatar_path_name, true);
        if ($employer)
            $pathNonAvatar = get_template_directory_uri() . "/libs/images/non-image.png";
        else
            $pathNonAvatar = get_template_directory_uri() . "/libs/images/non-avatar.jpg";
//        if (empty($path)) {
//            return $pathNonAvatar;
//        }
//        $file_headers = @get_headers(get_site_url() . "/" . $path);
//        if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
//            return $pathNonAvatar;
//        }

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

    function deleteOldAvatar($user_id)
    {
        $path = get_user_meta($user_id, $this->avatar_path_name, true);
        if (empty($path))
            return true;
        $file_headers = @get_headers(get_site_url() . "/" . $path);
        if ($file_headers[0] != 'HTTP/1.1 404 Not Found') {
            return unlink($path);
        }
        return true;
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