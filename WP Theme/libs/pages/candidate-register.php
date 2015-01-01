<?php
if (is_user_logged_in()) {
    global $current_user, $wpdb;
    $userID = $current_user->ID;
    $userType = get_user_meta($userID, 'user_type', true);
    if ($userType == "employer") {
        $isLogin = false;
        $userID = 0;
    } else {
        $isLogin = true;
        $resumeCode = str_pad($userID, 7, '0', STR_PAD_LEFT);
        $lastLogin = get_user_meta($userID, 'last_login', true);
        $lastLogin = date_i18n('d M y', strtotime($lastLogin));
        $lastUpdate = the_modified_author();
        $lastUpdate = date_i18n('d M y', strtotime($lastUpdate));
        $memberSince = $current_user->user_registered;
        $memberSince = date_i18n('d M y', strtotime($memberSince));
//        $date_format = get_option('date_format') . ' ' . get_option('time_format');
//        $the_last_login = mysql2date($date_format, $lastLogin, false);
//        echo $the_last_login;

        $classCandidate = new Candidate($wpdb);
        $objInformation = $classCandidate->getInformation($userID);
        if ($objInformation)
            extract((array)$objInformation[0]);

        $objCareerProfile = $classCandidate->getCareerProfile($userID);
        if ($objCareerProfile)
            extract((array)$objCareerProfile[0]);

        $objDesiredJob = $classCandidate->getDesiredJob($userID);
        if ($objDesiredJob)
            extract((array)$objDesiredJob[0]);

        $objSkillLanguage = $classCandidate->getSkillLanguages($userID);
        if ($objSkillLanguage)
            extract((array)$objSkillLanguage[0]);
    }
} else {
    $isLogin = false;
    $userID = 0;
}

?>
<script>
    var site_url = '<?php echo get_site_url(); ?>/';
    var is_login = <?php echo $isLogin ? 'true': 'false'; ?>;
    var post_type = '<?php echo $isLogin ? 'edit': 'add'; ?>';
    var candidate_id = <?php echo $userID; ?>;

    var information_id = <?php echo empty($objInformation)?0:$objInformation[0]->id;?>;
    var career_profile_id = <?php echo empty($objCareerProfile)?0:$objCareerProfile[0]->id;?>;
    var desired_job_id = <?php echo empty($objDesiredJob)?0:$objDesiredJob[0]->id;?>;
    var skill_languages_id = <?php echo empty($objSkillLanguage)?0:$objSkillLanguage[0]->id;?>;
</script>
<script src="<?php echo get_template_directory_uri(); ?>/libs/js/candidate.js"></script>
<section class="container-fluid" style="margin-top: 10px;">

<div class="container wrapper">
<div class="row">

<div class="col-md-8">
<?php if ($isLogin) { ?>
    <div id="sectProfile" class="col-md-12">
        <?php include_once('candidate-menu.php'); ?>
        <div class="col-md-8" style="padding-top: 10px;">
            Resume Code: <span class=".font-color-BF2026" style=""><?php echo $resumeCode; ?></span><br/>
            Status: <span class="font-color-BF2026" style="">Under verification process</span><br/>
            Last Login Date: <?php echo $lastLogin; ?><br/>
            Last update: <?php echo $lastUpdate; ?><br/>
            Member since: <?php echo $memberSince; ?><br/>
            Your resume is in the verification process <br/>
            (The process will take 1-2 working days)

        </div>
        <div class="col-md-4" style="padding-top: 10px;">
            <?php echo get_avatar($userID, 100);
            //echo do_shortcode( '[avatar_upload]');
            ?>
            <input type="button" class="btn" value="Edit">
        </div>

    </div>
<?php } ?>
<div class="clearfix"
     style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
<h5 class="pull-left" style="">
    <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png" style="height: 25px;"/>
    お知らせ
    <span class="font-color-BF2026" style="">Candidate Register</span>
</h5>

<div class="clearfix" style="margin-top: 20px;"></div>
<div id="show_message" class="col-md-12">
</div>
<?php if (!$isLogin): ?>
    <form method="post" id="form_candidate_step1" class="form-horizontal"
          data-bv-message="This value is not valid"
          data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
          data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
          data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">

        <div id="div_step1" class="col-md-12">
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
                <div class="col-md-4 text-right clearfix"><label for="step1_confirm_email">Confirm Email<span
                            class="font-color-red">*</span></label></div>
                <div class="col-md-8">
                    <input type="text" id="step1_confirm_email" name="step1_confirm_email"
                           maxlength="50"
                           class="form-control"
                           data-bv-emailaddress="true"
                           required data-bv-emailaddress-message="The input is not a valid email address"
                           data-bv-identical="true"
                           data-bv-identical-field="email"
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
            <div class="form-group col-md-12">
                <div class="col-md-4 text-right clearfix"><label for="repass">Confirm Password<span
                            class="font-color-red">*</span></label></div>
                <div class="col-md-8">
                    <input type="password" id="repass" name="repass"
                           class="form-control"
                           maxlength="50"
                           required
                           data-bv-stringlength="true"
                           data-bv-stringlength-min="8"
                           data-bv-identical="true"
                           data-bv-identical-field="pass"
                           data-bv-identical-message="The password and its confirm are not the same"
                        />
                </div>
            </div>

            <div class="form-group col-md-12" style="">
                <button id="submitStep1" type="submit" class="btn btn-primary col-md-6 pull-right">Submit Form</button>
                <button type="button" class="btn btn-default pull-right btn_reset_from" style="border: none;">Reset
                </button>
            </div>
        </div>
        <!-- END: step 1 -->
    </form>
<?php else: ?>
    <div id="div_step2" class="col-md-12">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

    <div class="panel panel-default" id="panel_information">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a class="tab_panel" data-toggle="collapse" data-parent="#accordion" href="#candPersonalInformation"
                   aria-expanded="true"
                   aria-controls="collapseOne">
                    PERSONAL INFORMATION
                </a>
            </h4>
        </div>
        <div id="candPersonalInformation" class="panel-collapse collapse in" role="tabpanel"
             aria-labelledby="headingOne">
            <form method="post" id="form_candidate1" class="form-horizontal form_candidate">
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
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="candPassword">Password<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <input type="password" id="candPassword" name="pass" class="form-control"
                                <?php echo $isLogin ? '' : 'required'; ?>
                                   data-bv-stringlength="true"
                                   data-bv-stringlength-min="8"
                                   maxlength="50"
                                />
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="candConfirmPassword">Confirm Password<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <input type="password" id="candConfirmPassword" name="rePass"
                                   class="form-control"
                                   maxlength="50"
                                <?php echo $isLogin ? '' : 'required'; ?>
                                   data-bv-stringlength="true"
                                   data-bv-stringlength-min="8"
                                   data-bv-identical="true"
                                   data-bv-identical-field="pass"
                                   data-bv-identical-message="The password and its confirm are not the same"/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="title">Title<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8"><select id="title" name="title" class="form-control">
                                <option value="Mr." <?php echo $title == "Mr." ? "selected" : ""; ?>>Mr.</option>
                                <option value="Ms." <?php echo $title == "Ms." ? "selected" : ""; ?>>Ms.</option>
                                <option value="Mrs" <?php echo $title == "Mrs" ? "selected" : ""; ?>>Mrs</option>
                                <option value="Miss" <?php echo $title == "Miss" ? "selected" : ""; ?>>Miss</option>
                            </select></div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="first_name">First Name<span
                                    class="font-color-red">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="first_name" name="first_name" class="form-control"
                                   required="" value="<?php echo empty($first_name) ? "" : $first_name; ?>"
                                />
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="last_name">Surname / Last Name<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <input type="text" id="last_name" name="last_name" class="form-control"
                                   value="<?php echo empty($last_name) ? "" : $last_name; ?>"
                                   required/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="gender">Gender<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="1" <?php echo $gender == "1" ? "selected" : ""; ?>>Male</option>
                                <option value="2" <?php echo $gender == "2" ? "selected" : ""; ?>>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="date_of_birth">Date of birth<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <input type="text" id="date_of_birth" name="date_of_birth" class="form-control datepicker"
                                   required placeholder="dd/mm/yyyy"
                                   value="<?php echo empty($date_of_birth) ? '' : date("d/m/Y", strtotime($date_of_birth)); ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="phone">Phone / Mobile<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <input type="text" id="phone" name="phone" class="form-control" required
                                   value="<?php echo empty($phone) ? '' : $phone; ?>"/>
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
                        <div class="col-md-8"><select id="county" name="county" class="form-control" required>
                                <option>Thailand</option>
                            </select></div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="province">Province<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8"><select id="province" name="province" class="form-control" required>
                                <option>Thailand</option>
                            </select></div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="district">District<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <select id="district" name="district" class="form-control" required>
                                <option>Thailand</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="city">City / Locality<span
                                    class="font-color-red">*</span></label></div>
                        <div class="col-md-8">
                            <select id="city" name="city" class="form-control" required>
                                <option>Thailand</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-12" style="">
                        <button type="submit" class="btn btn-primary col-md-6 pull-right btn_submit_form">Save</button>
                        <button type="button" class="btn btn-default pull-right btn_reset_from" style="border: none;">reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-default" id="panel_career_profile">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <a class="tab_panel collapsed" data-toggle="collapse" data-parent="#accordion" href="#candCareerProfile"
                   aria-expanded="false" aria-controls="collapseTwo">
                    CAREER PROFILE
                </a>
            </h4>
        </div>
        <div id="candCareerProfile" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <form method="post" id="form_candidate2" class="form-horizontal form_candidate">
                <div class="panel-body">
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="year_of_work_exp">Year of Work
                                Exp.</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="year_of_work_exp" name="year_of_work_exp" class="form-control"
                                   placeholder="Year(s)"
                                   value="<?php echo empty($year_of_work_exp) ? "" : $year_of_work_exp; ?>"/>
                            <span class="font-color-red">please enter only number No.(-) or (.) and space.</span>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="last_position">Lasted Position</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="last_position" name="last_position" class="form-control"
                                   value="<?php echo empty($last_position) ? "" : $last_position; ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="last_industry">Lasted Industry</label>
                        </div>

                        <div class="col-md-8">
                            <select id="last_industry" name="last_industry" class="form-control">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="last_function">Lasted Function</label>
                        </div>
                        <div class="col-md-8">
                            <select id="last_function" name="last_function" class="form-control">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="last_month_salary">Last Monthly
                                Salary</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="last_month_salary" name="last_month_salary" class="form-control"
                                   placeholder="THB"
                                   value="<?php echo empty($last_month_salary) ? "" : $last_month_salary; ?>"/>
                            <span class="font-color-red">please enter only number No.(-) or (.) and space example: 15000 or 20000, 100000</span>
                        </div>
                    </div>

                    <div class="form-group col-md-12" style="">
                        <button type="submit" class="btn btn-primary col-md-6 pull-right btn_submit_form">Save</button>
                        <button type="button" class="btn btn-default pull-right btn_reset_from" style="border: none;">reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-default" id="panel_desired_job">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a class="tab_panel collapsed" data-toggle="collapse" data-parent="#accordion" href="#candDesiredJob"
                   aria-expanded="false" aria-controls="collapseThree">
                    YOUR DESIRED JOB
                </a>
            </h4>
        </div>
        <div id="candDesiredJob" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <form method="post" id="form_candidate3" class="form-horizontal form_candidate">
                <div class="panel-body">
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="industry">Industry</label></div>
                        <div class="col-md-8">
                            <select id="industry" name="industry" class="form-control">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="jop_function">Job Function</label></div>
                        <div class="col-md-8">
                            <select id="jop_function" name="jop_function" class="form-control">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="job_type">Job Type</label></div>
                        <div class="col-md-8">
                            <select id="job_type" name="job_type" class="form-control">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="expect_month_salary">Expect Monthly
                                Salary</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="expect_month_salary" name="expect_month_salary" class="form-control"
                                   placeholder="THB"
                                   value="<?php echo empty($expect_month_salary) ? "" : $expect_month_salary; ?>"/>
                            <span class="font-color-red">please enter only number No.(-) or (.) and space example: 15000 or 20000, 100000</span>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="available_to_work">Are you available to
                                work
                                ?</label></div>
                        <div class="col-md-8">
                            <select id="available_to_work" name="available_to_work" class="form-control">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="start_date">Start Date</label></div>
                        <div class="col-md-8">
                            <input type="text" id="start_date" name="start_date"
                                   class="form-control datepicker" placeholder="dd/mm/yyyy"
                                   value="<?php echo empty($start_date) ? "" : date("d/m/Y", strtotime($start_date)); ?>"/>
                        </div>
                    </div>

                    <div class="form-group col-md-12" style="">
                        <button type="submit" class="btn btn-primary col-md-6 pull-right btn_submit_form">Save</button>
                        <button type="button" class="btn btn-default pull-right btn_reset_from" style="border: none;">reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-default" id="panel_education">
        <div class="panel-heading" role="tab" id="headingThree">
            <h4 class="panel-title">
                <a class="tab_panel collapsed" data-toggle="collapse" data-parent="#accordion" href="#candEDUCATION"
                   aria-expanded="false" aria-controls="collapseThree">
                    EDUCATION
                </a>
            </h4>
        </div>
        <div id="candEDUCATION" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <form method="post" id="form_candidate4" class="form-horizontal form_candidate">
                <input type="hidden" id="post_type" name="post_type" value="add_education" />
                <input type="hidden" id="education_id" name="education_id" value="0" />
                <div class="panel-body">
                    <div id="education_list"></div>
                    <span>Please provide details of education institutions, dates attended and qualification attained.</span>

                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="degree">Degree</label></div>
                        <div class="col-md-8">
                            <select id="degree" name="degree" class="form-control" required="">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="university">University /
                                Institute</label></div>
                        <div class="col-md-8">
                            <input type="text" id="university" name="university"
                                   class="form-control" placeholder="" required/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="education_period_from">Education
                                Period</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="education_period_from" name="education_period_from"
                                   class="form-control datepicker" placeholder="From: dd/mm/yyyy" required=""/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix">
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="education_period_to" name="education_period_to"
                                   class="form-control datepicker" placeholder="To: dd/mm/yyyy" required=""/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="grade_gpa">Grade / GPA</label></div>
                        <div class="col-md-8">
                            <input type="text" id="grade_gpa" name="grade_gpa" class="form-control"
                                   placeholder="" required=""/>
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
        <div id="candWorkExperience" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <form method="post" id="form_candidate5" class="form-horizontal form_candidate">
                <input type="hidden" id="post_type" name="post_type" value="add_work_experience" />
                <input type="hidden" id="work_experience_id" name="work_experience_id" value="0" />
                <div class="panel-body">
                    <div id="work_experience_list"></div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="employment_period_from">Employment
                                Period</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="employment_period_from" name="employment_period_from"
                                   class="form-control"
                                   placeholder="From: mm/yyyy" required=""/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"></div>
                        <div class="col-md-8">
                            <input type="text" id="employment_period_to" name="employment_period_to"
                                   class="form-control"
                                   placeholder="To: mm/yyyy" required=""/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="company_name">Company Name</label></div>
                        <div class="col-md-8">
                            <input type="text" id="company_name" name="company_name" class="form-control"
                                   placeholder="" required=""/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="position">Position</label></div>
                        <div class="col-md-8">
                            <input type="text" id="position" name="position" class="form-control"
                                   placeholder="" required=""/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="month_salary">Monthly Salary</label></div>
                        <div class="col-md-8">
                            <input type="text" id="month_salary" name="month_salary" class="form-control"
                                   placeholder="" required=""/>
                            <span class="font-color-red">please enter only number No.(-) or (.) and space example: 15000 or 20000, 100000</span>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="job_duties">Job Duties</label></div>
                        <div class="col-md-8">
                            <textarea id="job_duties" name="job_duties" class="form-control" rows="10"></textarea>
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
        <div id="candSkillLanguages" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <form method="post" id="form_candidate6" class="form-horizontal form_candidate">
                <div class="panel-body">
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="japanese_skill">Japanese
                                Skill</label><span
                                class="font-color-red">*</span></div>
                        <div class="col-md-8">
                            <select id="japanese_skill" name="japanese_skill" class="form-control" required="">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="japanese_speaking">Japanese
                                Speaking</label><span class="font-color-red">*</span></div>
                        <div class="col-md-8">
                            <select id="japanese_speaking" name="japanese_speaking" class="form-control" required="">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="japanese_reading">Japanese
                                Reading</label><span class="font-color-red">*</span></div>
                        <div class="col-md-8">
                            <select id="japanese_reading" name="japanese_reading" class="form-control" required="">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="japanese_writing">Japanese
                                Writing</label><span class="font-color-red">*</span></div>
                        <div class="col-md-8">
                            <select id="japanese_writing" name="japanese_writing" class="form-control" required="">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="toeic_toefl_ielts">TOEIC / TOEFL /
                                IELTS</label><span class="font-color-red">*</span></div>
                        <div class="col-md-8">
                            <select id="toeic_toefl_ielts" name="toeic_toefl_ielts" class="form-control" required="">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"></div>
                        <div class="col-md-8">
                            <input type="text" id="toeic_toefl_ielts_score" name="toeic_toefl_ielts_score"
                                   class="form-control" placeholder="Your Score: 999" required=""
                                   value="<?php echo empty($toeic_toefl_ielts_score) ? "" : $toeic_toefl_ielts_score; ?>"/>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="english_speaking">English
                                Speaking</label><span
                                class="font-color-red">*</span></div>
                        <div class="col-md-8">
                            <select id="english_speaking" name="english_speaking" class="form-control" required="">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="english_reading">English
                                Reading</label><span class="font-color-red">*</span></div>
                        <div class="col-md-8">
                            <select id="english_reading" name="english_reading" class="form-control" required="">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-md-4 text-right clearfix"><label for="english_writing">English
                                Writing</label><span class="font-color-red">*</span></div>
                        <div class="col-md-8">
                            <select id="english_writing" name="english_writing" class="form-control" required="">
                                <option>xxxx</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-12" style="">
                        <button type="submit" class="btn btn-primary col-md-6 pull-right btn_submit_form">Save</button>
                        <button type="button" class="btn btn-default pull-right btn_reset_from" style="border: none;">reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    </div>
    </div>
<?php endif; ?>
</div>

<img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png"
     style="width: 100%; height: auto;"/>

</div>

<?php include_once("sidebar.php"); ?>
</div>
</div>

</section>

<style type="text/css">
    #sectProfile {
        padding-top: 10px
    }
</style>
<script>

    function toggleChevron(e) {
        $(e.target)
            .prev('.panel-heading')
            .find("i.indicator")
            .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
    }
    //    $('.in').collapse({hide: true});
    // in cadidate register page
</script>