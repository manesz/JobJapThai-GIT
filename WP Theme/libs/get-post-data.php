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

    //Employer

//    if (is_user_logged_in()) {
    $newPackage = empty($_REQUEST['new_package']) ? false : $_REQUEST['new_package'];
    $listPackage = empty($_REQUEST['list_package']) ? false : $_REQUEST['list_package'];
    $postPackage = empty($_REQUEST['post_package']) ? false : $_REQUEST['post_package'];
    $postJob = empty($_REQUEST['post_job']) ? false : $_REQUEST['post_job'];
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
    if ($postJob) {
        $postType = empty($_REQUEST['post_type']) ? false : $_REQUEST['post_type'];
        if ($postType == 'add') {
            $result = $classEmployer->addPostJob($_REQUEST);
        } else if ($postType == 'edit') {
            $result = $classEmployer->editPostJob($_REQUEST);
        } else if ($postType == 'delete') {
            $result = $classEmployer->deletePosJob($_REQUEST['post_id']);
        } else if ($postType == 'load_edit') {
            $result = $classEmployer->buildFormPostJob('edit');
        } else if ($postType == 'feature_image') {
            if ($_REQUEST['post_id'] == 0) {
                $post_id = $classEmployer->addPostJob(array(), 'draft');
            } else {
                $post_id = $_REQUEST['post_id'];
                $classEmployer->deleteOldThumbnail($post_id);
            }
            $result = $classEmployer->uploadImage($_FILES['feature_image']);
            if (!$result['error']) {
                if ($classEmployer->setFeatureImage($post_id, $result['url'])){
                    $result['post_id'] = $post_id;
                }
            }
            $result = $classEmployer->returnMessage($result, $result['error']);
        }
        echo $result;
        exit;
    }

    $employerPost = empty($_REQUEST['employer_post']) ? false : $_REQUEST['employer_post'];
    if ($employerPost == 'true') {
        $classEmployer = new Employer($wpdb);
        $postType = empty($_REQUEST['post_type']) ? false : $_REQUEST['post_type'];
        $getPostBackend = empty($_REQUEST['post_backend']) ? false : $_REQUEST['post_backend'];
        if ($postType == 'add') {
            $result = $classEmployer->employerRegister($_REQUEST);
            if (!$result['error'] && !$getPostBackend) {
                //$this->setUserLogin($user_id);
                $_REQUEST['key'] = $result['key'];
                ob_start();
                require_once("content-email/register_confirmation.php");
                $message = ob_get_contents();
                ob_end_clean();

                if (!wp_mail($_REQUEST['employerEmail'], "Register Confirmation from Job Jap Thai", $message)) {
                    echo $classEmployer->returnMessage("Sorry error send email.", true);
                }
            }
            echo $classEmployer->returnMessage($result, $result['error'], true);
        } else if ($postType == 'edit') {
            echo $classEmployer->editEmployer($_REQUEST);
        }
        exit;
    }
    //End Employer

    //Candidate
    $candidatePost = empty($_REQUEST['candidate_post']) ? false : $_REQUEST['candidate_post'];
    if ($candidatePost == 'true') {
        $classCandidate = new Candidate($wpdb);
        $postType = empty($_REQUEST['post_type']) ? false : $_REQUEST['post_type'];
        $getPostBackend = empty($_REQUEST['post_backend']) ? false : $_REQUEST['post_backend'];
        switch ($postType) {
            case "register":
                $result = $classCandidate->addCandidate($_REQUEST);

                if (!$result['error'] && !$getPostBackend) {
                    //$this->setUserLogin($user_id);
                    $_REQUEST['key'] = $result['key'];
                    ob_start();
                    require_once("content-email/register_confirmation.php");
                    $message = ob_get_contents();
                    ob_end_clean();

                    if (!wp_mail($_REQUEST['email'], "Register Confirmation from Job Jap Thai", $message)) {
                        echo $classCandidate->returnMessage("Sorry error send email.", true);
                    }
                }
                //var_dump($result);
                echo $classCandidate->returnMessage($result, $result['error'], true);
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
                    echo $classCandidate->returnMessage("Add education success.", false);
                else echo $classCandidate->returnMessage("Add education fail.", true);
                break;
            case "add_work_experience":
                $result = $classCandidate->addWorkExperience($_REQUEST);
                if ($result)
                    echo $classCandidate->returnMessage("Add work experience success.", false);
                else echo $classCandidate->returnMessage("Add work experience fail.", true);
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
            case "image_avatar":
                $result = $classCandidate->uploadAvatarImage($_FILES['image_avatar']);
                if (!$result['error']) {
                    if (!$classCandidate->deleteOldAvatar($_REQUEST['candidate_id'])) {
                        echo $classCandidate->returnMessage("Error delete old image.", true);
                        exit;
                    }
                    $classCandidate->addAvatarPath($_REQUEST['candidate_id'], $result['path']);
                }
                echo $classCandidate->returnMessage($result, $result['error']);
                break;
            //End edit

            //Delete
            case "delete_education":
                $result = $classCandidate->deleteEducation($_REQUEST);
                echo $result;
                break;
            case "delete_work_experience":
                $result = $classCandidate->deleteWorkExperience($_REQUEST);
                echo $result;
                break;
            //End Delete
        }
        exit;
    }
    // END Candidate

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
            case "highlight_jobs":
                $argc = $classQueryPostJob->queryHighlightJobs();
                break;
            case "post_job":
                $argc = $classQueryPostJob->queryPostJob($_REQUEST['user_id']);
                break;
        }
        echo $classQueryPostJob->buildListJob($argc);
        exit;
    }


    //Forget pass
    if (isset($_REQUEST['reset_pass'])) {

        $classAuthentication = new Authentication($wpdb);
        $result = $classAuthentication->checkUserForForgetPassWord($_REQUEST['user_login']);
        if ($result['error']) {
            echo $classAuthentication->returnMessage($result, true);
        } else {
            $_REQUEST['user_data'] = $result['user_data'];
            $user_data = $result['user_data'];
            $email = $user_data->user_email;

            $random_password = wp_generate_password(12, false);
            $update_user = wp_update_user(array(
                    'ID' => $user_data->ID,
                    'user_pass' => $random_password
                )
            );
            if (!$update_user) {
                echo $this->returnMessage('Oops something went wrong updaing your account.', true);
            } else {
                $_REQUEST['user_login'] = $user_data->user_login;
                $_REQUEST['new_pass'] = $random_password;
                function wp_mail_set_content_type()
                {
                    return "text/html";
                }

                add_filter('wp_mail_content_type', 'wp_mail_set_content_type');
                ob_start();
                require_once("content-email/forget_password.php");
                $message = ob_get_contents();
                ob_end_clean();
                if (!wp_mail($email, "Forget password from Job Jap Thai", $message)) {
                    echo $classAuthentication->returnMessage("Sorry error send email.", true);
                } else {
                    echo $classAuthentication->returnMessage("Check your email address for you new password.", false);
                }
            }
        }
        exit;
    }
    //End Forget pass

//    }

    $signInPost = isset($_REQUEST['sign_in_post']) ? $_REQUEST['sign_in_post'] : false;
    if ($signInPost == "true") {
        $classAuthentication = new Authentication($wpdb);
        echo $classAuthentication->signin($_REQUEST);
        exit;
    }
}