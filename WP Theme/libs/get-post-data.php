<?php

if (!session_id())
    session_start();
global $wpdb;
if ($_REQUEST) {
    $sendTo = 'ruxchuk@gmail.com'; //email info
    if ($_REQUEST['send_email_contact_us'] == 'true') {
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
    if ($_REQUEST['new_package'] == 'true') {
        require_once("pages/package-new.php");
        exit;
    } else if ($_REQUEST['list_package'] == 'true') {
        require_once("pages/package-list.php");
        exit;
    } else if ($_REQUEST['post_package'] == 'true') {
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

    if ($_REQUEST['candidate_post'] == 'true') {
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
    if ($_REQUEST['favorite'] == 'true') {
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
    if ($_REQUEST['apply_post'] == 'true') {
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


//    }
}