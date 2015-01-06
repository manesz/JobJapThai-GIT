<?php

if (!session_id())
    session_start();
global $wpdb;
if ($_REQUEST) {
    $sendTo = 'ruxchuk@gmail.com'; //email info
    $sendEmailContactUs = empty($_REQUEST['send_email_contact_us']) ? false : $_REQUEST['send_email_contact_us'];
    if ($sendEmailContactUs == 'true') {
        extract($_REQUEST);
        if ($_SESSION['captcha_contact_us']['code'] != @$security_code) {
            echo 'error_captcha';
        } else {
            function wp_mail_set_content_type()
            {
                return "text/html";
            }

            add_filter('wp_mail_content_type', 'wp_mail_set_content_type');
            $subject = "Email Contact Us from $send_name";
            ob_start();
            require_once("content-email/contact-us-email.php");
            $message = ob_get_contents();
            ob_end_clean();
            $result = wp_mail($sendTo, $subject, $message);
            if ($result)
                echo 'success';
            else echo 'fail';
        }
        exit;
    }

//    if (is_user_logged_in()) {
    $newPackage = empty($_REQUEST['new_package']) ? false : $_REQUEST['new_package'];
    $listPackage = empty($_REQUEST['list_package']) ? false : $_REQUEST['list_package'];
    $postPackage = empty($_REQUEST['post_package']) ? false : $_REQUEST['post_package'];
    if ($newPackage == 'true') {
        require_once("pages/package-new.php");
        exit;
    }
    if ($listPackage == 'true') {
        require_once("pages/package-list.php");
        exit;
    }
    if ($postPackage == 'true') {
        $classPackage = new Package($wpdb);
        $postType = $_REQUEST['type_post'];
        if ($postType == 'add') {
            $result = $classPackage->addSelectPackage($_REQUEST);
            if ($result)
                echo 'success';
            else echo 'fail';
        } else if ($postType == 'edit') {
            $result = $classPackage->editSelectPackage($_REQUEST);
            if ($result)
                echo 'success';
            else echo 'fail';
        }
        exit;
    }

    $candidatePost = empty($_REQUEST['candidate_post']) ? false : $_REQUEST['candidate_post'];
    if ($candidatePost == 'true') {
        $classCandidate = new Candidate($wpdb);
        $postType = $_REQUEST['post_type'];
        switch ($postType) {
            case "add":
                $result = $classCandidate->addCandidate($_REQUEST);
                echo $result;
                break;
            case "edit":
                break;
            case "get_education":
                $result = $classCandidate->buildEducationTable($_REQUEST['candidate_id']);
                echo $result;
                break;
            case "get_work_experience":
                $result = $classCandidate->buildWorkExperienceTable($_REQUEST['candidate_id']);
                echo $result;
                break;
            case "add_education":
                $result = $classCandidate->addEducation($_REQUEST);
                if ($result)
                    echo 'success';
                else echo 'fail';
                break;
            case "add_work_experience":
                $result = $classCandidate->addWorkExperience($_REQUEST);
                if ($result)
                    echo 'success';
                else echo 'fail';
                break;

            //Edit
            case "edit_information":
                $result = $classCandidate->editInformation($_REQUEST);
                echo $result;
                break;
            case "edit_career_profile":
                $result = $classCandidate->editCareerProfile($_REQUEST);
                echo $result;
                break;
            case "edit_desired_job":
                $result = $classCandidate->editDesiredJob($_REQUEST);
                echo $result;
                break;
            case "edit_education":
                $result = $classCandidate->editEducation($_REQUEST);
                echo $result;
                break;
            case "edit_work_experience":
                $result = $classCandidate->editWorkExperience($_REQUEST);
                echo $result;
                break;
            case "edit_skill_languages":
                $result = $classCandidate->editSkillLanguages($_REQUEST);
                echo $result;
                break;
            //End edit
        }
        exit;
    }

    //Favorite
    $favorite = empty($_REQUEST['favorite']) ? false : $_REQUEST['favorite'];
    if ($favorite == 'true') {
        $classFavorite = new Favorite($wpdb);
        if ($_REQUEST['favorite_type'] == 'job') {
            if ($_REQUEST['is_favorite'] == 'true') {
                $result = $classFavorite->addFavJob($_REQUEST['user_id'], $_REQUEST['id'], $_REQUEST['company_id']);
                echo $result;
            } else {
                $result = $classFavorite->setPublishJob($_REQUEST['fav_id']);
                echo $result;
            }
        } else if ($_REQUEST['favorite_type'] == 'company') {
            if ($_REQUEST['is_favorite'] == 'true') {
                $result = $classFavorite->addFavCompany($_REQUEST['user_id'], $_REQUEST['id']);
                echo $result;
            } else {
                $result = $classFavorite->setPublishCompany($_REQUEST['fav_id']);
                echo $result;
            }
        }
        exit;
    }
    //End Favorite


    //Apply
    $applyPost = empty($_REQUEST['apply_post']) ? false : $_REQUEST['apply_post'];
    if ($applyPost == 'true') {
        $classApply = new Apply($wpdb);
        if ($_REQUEST['apply_type'] == 'job') {
            if ($_REQUEST['is_apply'] == 'true') {
                $result = $classApply->addApplyJob($_REQUEST['user_id'], $_REQUEST['id'], $_REQUEST['company_id']);
                echo $result;
            } else {
                $result = $classApply->setPublishJob($_REQUEST['apply_id']);
                echo $result;
            }
        } else if ($_REQUEST['apply_type'] == 'company') {
            if ($_REQUEST['is_apply'] == 'true') {
                $result = $classApply->addApplyCompany($_REQUEST['user_id'], $_REQUEST['id']);
                echo $result;
            } else {
                $result = $classApply->setPublishCompany($_REQUEST['apply_id']);
                echo $result;
            }
        }
        exit;
    }
    //End Apply


    $query_list_job_post = empty($_REQUEST['query_list_job_post']) ? false : $_REQUEST['query_list_job_post'];
    if ($query_list_job_post == 'true') {
        $classQueryPostJob = new QueryPostJob($wpdb);
        $getType = $_REQUEST['type'];
        switch ($getType) {
            case "favorite":
                $argc = $classQueryPostJob->queryFavoriteJob($_REQUEST['user_id']);
                break;
            case "apply":
                $argc = $classQueryPostJob->queryApplyJob($_REQUEST['user_id']);
                break;
            case "search":
                $argc = $classQueryPostJob->querySearchJob();
                break;
        }
        echo $classQueryPostJob->buildListJob($argc);
        exit;
    }


    //Forget pass
    if (isset($_REQUEST['reset_pass'])) {

        $classAuthentication = new Authentication($wpdb);
        echo $classAuthentication->forgetPassWord($_REQUEST);
        exit;
    }
    //End Forget pass

//    }

    $signInPost = isset($_POST['sign_in_post']) ? $_POST['sign_in_post'] : false;
    if ($signInPost == "true") {
        $classAuthentication = new Authentication($wpdb);
        echo $classAuthentication->signin($_POST);
        exit;
    }
}