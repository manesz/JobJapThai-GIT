<?php

/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 05/02/2558
 * Time: 12:57 น.
 */
class ViewProfile
{
    private $wpdb;
    public $tableViewUser = "ics_view_user";
    public $tableViewEmployer = "ics_view_employer";

    function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    function listViewUser($id = 0, $user_id = 0, $employer_id = 0)
    {
        $strAnd = $id ? " AND id=$id" : "";
        $strAnd .= $user_id ? " AND user_id=$user_id" : "";
        $strAnd .= $employer_id ? " AND employer_id=$employer_id" : "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableViewUser
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    function listViewEmployer($id = 0, $user_id = 0, $employer_id = 0)
    {
        $strAnd = $id ? " AND id=$id" : "";
        $strAnd .= $user_id ? " AND user_id=$user_id" : "";
        $strAnd .= $employer_id ? " AND employer_id=$employer_id" : "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableViewEmployer
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    function addViewUser($user_id, $employer_id)
    {
        if (!$user_id || !$employer_id)
            return $this->returnMessage('Fail No id.', true);
        if (!$this->checkCheckViewUser($user_id, $employer_id)) {
            $sql = "
                INSERT INTO `$this->tableViewUser`
                (
                 `user_id`,
                 `employer_id`,
                 `create_datetime`,
                 `publish`
                 )
                VALUES (
                '{$user_id}',
                '{$employer_id}',
                NOW(),
                1
            );
            ";
            $result = $this->wpdb->query($sql);
            if (!$result)
                return $this->returnMessage('Add View User Fail.', true);
//        return $this->wpdb->insert_id;
        }
        return $this->returnMessage('Add View User Success.', false);
    }

    function addViewEmployer($user_id, $employer_id)
    {
        if (!$user_id || !$employer_id)
            return $this->returnMessage('Fail No id.', true);

        if (!$this->checkCheckViewEmployer($user_id, $employer_id)) {
            $sql = "
                INSERT INTO `$this->tableViewEmployer`
                (
                 `user_id`,
                 `employer_id`,
                 `create_datetime`,
                 `publish`
                 )
                VALUES (
                '{$user_id}',
                '{$employer_id}',
                NOW(),
                1
              );
            ";
            $result = $this->wpdb->query($sql);
            if (!$result)
                return $this->returnMessage('Add View Seeking for Manpower Fail.', true);
        }
//        return $this->wpdb->insert_id;
        return $this->returnMessage('Add View Seeking for Manpower Success.', false);
    }

//    public function setPublishJob($id)
//    {
//        $sql = "
//            UPDATE `$this->tableFavoriteJob`
//            SET
//              `publish` = 0,
//              `update_datetime` = NOW()
//            WHERE `id` = '{$id}';
//        ";
//        $result = $this->wpdb->query($sql);
//        if (!$result)
//            return $this->returnMessage('Sorry Edit Error.', true);
//        return $this->returnMessage('Edit Success.', false);
//    }
//
//    public function setPublishCompany($id)
//    {
//        $sql = "
//            UPDATE `$this->tableFavoriteCompany`
//            SET
//              `publish` = 0,
//              `update_datetime` = NOW()
//            WHERE `id` = '{$id}';
//        ";
//        $result = $this->wpdb->query($sql);
//        if (!$result)
//            return $this->returnMessage('Sorry Edit Error.', true);
//        return $this->returnMessage('Edit Success.', false);
//    }

    function checkCheckViewUser($user_id, $employer)
    {
        $result = $this->listViewUser(0, $user_id, $employer);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function checkCheckViewEmployer($user_id, $employer)
    {
        $result = $this->listViewEmployer(0, $user_id, $employer);
        if ($result) {
            return true;
        } else {
            return false;
        }
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