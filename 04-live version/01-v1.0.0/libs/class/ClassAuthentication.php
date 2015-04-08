<?php

/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 2/1/2558
 * Time: 16:28 น.
 */
class Authentication
{
    private $wpdb;

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    function signin($post)
    {
        $userName = isset($post['username']) ? $post['username'] : false;
        $pass = isset($post['password']) ? $post['password'] : false;
        $user = get_user_by('email', $userName);
        if ($user) {
            $userName = $user->user_login;
        }

        $dateSignOn = array();
        $dateSignOn['user_login'] = $userName;
        $dateSignOn['user_password'] = $pass;
        $dateSignOn['remember'] = false;
        $user = wp_signon($dateSignOn, false);
        if (is_wp_error($user)) //$user->get_error_message()
            return $this->returnMessage(
                '<p><strong>ERROR</strong>: The password you entered for the username <strong>' .
                $userName . '</strong> is incorrect.
                <a href="#" data-toggle="modal" data-target="#modalForget"
                onclick="closeModalMessage();">Lost your password</a>?</p>', true);
        else {
            if (!$this->checkIsConfirm($user->ID)) {
                wp_logout();
                return $this->returnMessage(
                    '<p>Sorry, your Email has not been confirmed.<br/>Please check your email inbox.', true);
            }
            update_user_meta($user->ID, 'last_login', current_time('mysql'));
            $userType = get_user_meta($user->ID, 'user_type', true);
            if ($userType == "employer")
                return $this->returnMessage(get_site_url() . '/edit-profile/', false, false);
            else if ($userType == 'candidate') {
                return $this->returnMessage(get_site_url() . '/candidate/', false, false);
            } else {
                return $this->returnMessage(get_site_url() . '/', false, false);
            }
        }
    }

//    Confirm register

    function getUserByKey($key)
    {
        $args = array(
            'meta_key' => 'activation_key',
            'meta_value' => $key,
        );
        $user = get_users($args);
        return $user[0];
    }

    function checkUserByKey($key)
    {
        $args = array(
//            'blog_id'      => $GLOBALS['blog_id'],
//            'role'         => '',
            'meta_key' => 'activation_key',
            'meta_value' => $key,
//            'meta_compare' => '',
//            'meta_query'   => array(),
//            'include'      => array(),
//            'exclude'      => array(),
//            'orderby'      => 'login',
//            'order'        => 'ASC',
//            'offset'       => '',
//            'search'       => '',
//            'number'       => '',
//            'count_total'  => false,
//            'fields'       => 'all',
//            'who'          => ''
        );
        $user = get_users($args);
        if (empty($user)) {
            return false;
        } else {
            return true;
        }
    }

    function checkIsConfirm($user_id)
    {
        $result = get_user_meta($user_id, 'activation_confirm', true);
        if (empty($result)) {
            update_user_meta($user_id, 'activation_confirm', 'true');
            return true;
        }
        return empty($result) || $result == 'true' ? true : false;
    }

    function updateActivationConfirm($user_id)
    {
        update_user_meta($user_id, 'activation_confirm', 'true');
    }

//    End Confirm Register

    public function forgetPassWord($post)
    {

        $username = trim($post['user_login']);
        $error = "";
        if (username_exists($username)) {
            $user_exists = true;
            $user_data = get_user_by('login', $username);
        } elseif (email_exists($username)) {
            $user_exists = true;
            $user_data = get_user_by('email', $username);
        } else {
            $user_exists = false;
            $error = '<p>' . __('Username or Email was not found, try again!') . '</p>';
        }
        if ($user_exists) {
            $email = $user_data->user_email;
            $random_password = wp_generate_password(12, false);
            //$user = get_user_by('email', $email);

            $update_user = wp_update_user(array(
                    'ID' => $user_data->ID,
                    'user_pass' => $random_password
                )
            );

            // if  update user return true then lets send user an email containing the new password
            if ($update_user) {
                $to = $email;
                $subject = 'Your new password';
                $sender = get_option('name');

                $message = 'Your new password is: ' . $random_password;

                $headers[] = 'MIME-Version: 1.0' . "\r\n";
                $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers[] = "X-Mailer: PHP \r\n";
                $headers[] = 'From: ' . $sender . ' < ' . $email . '>' . "\r\n";

                $mail = wp_mail($to, $subject, $message, $headers);
                if ($mail) {
                    $success = 'Check your email address for you new password.';
                    return $this->returnMessage($success, false);
                }

            } else {
                $error = 'Oops something went wrong updaing your account.';
                return $this->returnMessage($error, true);
            }

        }
        return $this->returnMessage($error, true);

    }

    function checkUserForForgetPassWord($user_login)
    {

        $username = trim($user_login);
        $error = "";
        if (username_exists($username)) {
            $user_exists = true;
            $user_data = get_user_by('login', $username);
        } elseif (email_exists($username)) {
            $user_exists = true;
            $user_data = get_user_by('email', $username);
        } else {
            $user_exists = false;
            $error = '<p>' . __('Username or Email was not found, try again!') . '</p>';
        }
        if ($user_exists) {
            return $this->returnMessage(array('msg'=> '', 'user_data'=>$user_data), false, true, false);
        }
        return $this->returnMessage($error, true, true, false);

    }

    function returnMessage($msg, $error, $show_div = true, $json = true)
    {
        if ($error) {
            $message = array('msg' => $show_div ? '<div class="font-color-BF2026"><p>' . $msg . '</p></div>' : $msg,
                'error' => $error);
        } else {
            if (is_array($msg)) {
                $arrayReturn = $msg;
                $arrayReturn['msg'] = $show_div ? '<div class="font-color-4BB748"><p>' . @$msg['msg'] . '</p></div>' : $msg['msg'];
                $arrayReturn['error'] = false;
                $message = $arrayReturn;
            } else {
                $message = array('msg' => $show_div ? '<div class="font-color-4BB748"><p>' . $msg . '</p></div>' : $msg,
                    'error' => $error);
            }
        }
        return $json ? json_encode($message) : $message;
    }
}