<?php
//$fxrootpath = $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';
$employerPost = isset($_POST['employer_post']) ? $_POST['employer_post'] : false;
if ($employerPost == 'true') {
    $fxrootpath = ABSPATH . 'wp-load.php';
    if (file_exists($fxrootpath)) {
        include_once($fxrootpath);
        registerEmp();
    } else {
        echo 'Set value $fxrootpath in file : pages/apply-employer-register.php ';
    }
    exit;
}

$signInPost = isset($_POST['sign_in_post']) ? $_POST['sign_in_post'] : false;
if ($signInPost == "true") {
    userSignIn();
    exit;
}
function registerEmp()
{
    global $wpdb;
    $username = isset($_POST['employerUsername']) ? $_POST['employerUsername'] : false;
    $pass = isset($_POST['employerPassword']) ? $_POST['employerPassword'] : false;
    $rePass = isset($_POST['employerConfirmPassword']) ? $_POST['employerConfirmPassword'] : false;
    $email = isset($_POST['employerEmail']) ? $_POST['employerEmail'] : false;
    //$website = isset($_POST['employerContactWebsite']) ? $_POST['employerContactWebsite'] : '';
    if ($pass != $rePass && $pass && $rePass) {
        echo '<div class="font-color-BF2026"><p>Error! Check your password and confrim password.</p></div>';
        exit;
    }
    $classEmployer = new Employer($wpdb);

    if ($_POST['check_post'] == 'add') { //add
        $userData = array(
            'user_login' => $username,
            'user_pass' => $pass,
            'user_email' => $email
        );
        $user_id = wp_insert_user($userData);
        if (!is_wp_error($user_id)) {
            $user_type = 'employer';
            add_user_meta($user_id, 'user_type', $user_type);

            if ($_POST['check_post'] == 'add') {
                $postData = $_POST;
                $postData['employer_id'] = $user_id;
                $result = $classEmployer->addCompanyInfo($postData);
                if (!$result) {
                    wp_revoke_user($user_id);
                    wp_delete_user($user_id);
                    echo '<div class="font-color-BF2026"><p>Error add company information for contact.</p></div>';
                    exit;
                }
            }
        }
    } else { //edit
        $userData = array(
            'user_pass' => $pass,
        );
        if ($pass && $rePass) //change pass
            $user_id = wp_update_user($userData);
        else
            $user_id = $_POST['employer_id'];
        $result = $classEmployer->editCompanyInfo($_POST);
        if (!$result) {
            echo '<div class="font-color-BF2026"><p>Error edit company information for contact.</p></div>';
            exit;
        }
        echo 'success';
        exit;
    }

//On success
    if (!is_wp_error($user_id)) {
        setUserLogin($user_id);
        echo 'success';
//        header('Location: ' . get_site_url() . '/edit-resume/');
    } else {
        $error_string = $user_id->get_error_message();
        echo '<div class="font-color-BF2026"><p>' . $error_string . '</p></div>';
        //echo 'create user error :<a href="' . get_site_url() . '/employer-register/">Click for retry</a>';
    }
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

function userSignIn()
{
    $userName = isset($_POST['username']) ? $_POST['username'] : false;
    $pass = isset($_POST['password']) ? $_POST['password'] : false;
    $user = get_user_by('email', $userName);
    if ($user) {
        $userName = $user->user_login;
    }

    $dateSignOn = array();
    $dateSignOn['user_login'] = $userName;
    $dateSignOn['user_password'] = $pass;
    $dateSignOn['remember'] = false;
    $user = wp_signon($dateSignOn, false);
    if (is_wp_error($user))
        echo $user->get_error_message();
    else {
//        setUserLogin($user);
        update_usermeta($user->ID, 'last_login', current_time('mysql'));
        $userType = get_user_meta($user->ID, 'user_type', true);
        if ($userType == "employer")
            header('Location: ' . get_site_url() . '/edit-resume/');
        else if ($userType == 'candidate') {
            header('Location: ' . get_site_url() . '/candidate/');
        } else {
            header('Location: ' . get_site_url() . '/');
        }
    }
}