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
            update_user_meta($user->ID, 'last_login', current_time('mysql'));
            $userType = get_user_meta($user->ID, 'user_type', true);
            if ($userType == "employer")
                return $this->returnMessage(get_site_url() . '/edit-resume/', false, false);
            else if ($userType == 'candidate') {
                return $this->returnMessage(get_site_url() . '/candidate/', false, false);
            } else {
                return $this->returnMessage(get_site_url() . '/', false, false);
            }
        }
    }

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
            $user = get_user_by('email', $email);

            $update_user = wp_update_user(array(
                    'ID' => $user->ID,
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

    private function returnMessage($msg, $error, $show_div = true)
    {
        if ($error) {
            return json_encode(array('msg' => $show_div ? '<div class="font-color-BF2026"><p>' . $msg . '</p></div>' : $msg,
                'error' => $error));
        } else {
            return json_encode(array('msg' => $show_div ? '<div class="font-color-4BB748"><p>' . $msg . '</p></div>' : $msg,
                'error' => $error));
        }
    }
}