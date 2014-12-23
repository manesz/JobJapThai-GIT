<?php

if (!session_id())
    session_start();
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
}