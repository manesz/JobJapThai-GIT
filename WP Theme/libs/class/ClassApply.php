<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 01/01/2558
 * Time: 13:34 น.
 */

class Apply
{
    private $wpdb;
    public $tableApplyJob = "ics_apply_job";
    public $tableApplyCompany = "ics_apply_company";

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    public function listApplyJob($id = 0, $job_id = 0, $user_id = 0)
    {
        $strAnd = $id ? " AND id=$id": "";
        $strAnd .= $job_id ? " AND job_id=$job_id": "";
        $strAnd .= $user_id ? " AND user_id=$user_id": "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableApplyJob
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function listApplyCompany($id = 0, $company_id = 0, $user_id = 0)
    {
        $strAnd = $id ? " AND id=$id": "";
        $strAnd .= $company_id ? " AND company_id=$company_id": "";
        $strAnd .= $user_id ? " AND user_id=$user_id": "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableApplyCompany
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function addApplyJob($user_id, $job_id, $company_id) {
        if (!$user_id || !$job_id || !$company_id)
            return $this->returnMessage('Fail No id.', true);
        $sql = "
            INSERT INTO `$this->tableApplyJob`
            (
             `user_id`,
             `job_id`,
             `company_id`,
             `create_datetime`,
             `update_datetime`,
             `publish`)
            VALUES (
            '{$user_id}',
            '{$job_id}',
            '{$company_id}',
            NOW(),
            NOW(),
            1
        );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            $this->returnMessage('Apply Fail.', true);
//        return $this->wpdb->insert_id;
        return $this->returnMessage('Apply Success.', false);
    }

    public function addApplyCompany($user_id, $company_id) {
        if (!$user_id || !$company_id)
            return $this->returnMessage('Fail No id.', true);
        $sql = "
            INSERT INTO `$this->tableApplyCompany`
            (
             `user_id`,
             `company_id`,
             `create_datetime`,
             `update_datetime`,
             `publish`)
            VALUES (
            '{$user_id}',
            '{$company_id}',
            NOW(),
            NOW(),
            1
        );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
//        return $this->wpdb->insert_id;
        return $this->returnMessage('Apply Success.', false);
    }

    public function setPublishJob($id)
    {
        $sql = "
            UPDATE `$this->tableApplyJob`
            SET
              `publish` = 0,
              `update_datetime` = NOW()
            WHERE `id` = '{$id}';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return $this->returnMessage('Sorry Edit Error.', true);
        return $this->returnMessage('Edit Success.', false);
    }

    public function setPublishCompany($id)
    {
        $sql = "
            UPDATE `$this->tableApplyCompany`
            SET
              `publish` = 0,
              `update_datetime` = NOW()
            WHERE `id` = '{$id}';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return $this->returnMessage('Sorry Edit Error.', true);
        return $this->returnMessage('Edit Success.', false);
    }

    public function checkJobIsApply($user_id, $job_id) {
        $result = $this->listApplyJob(0, $job_id, $user_id);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function checkCompanyIsApply($user_id, $company_id) {
        $result = $this->listApplyCompany(0, $company_id, $user_id);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    private function returnMessage($msg, $error) {
        if ($error) {
            return json_encode(array('msg' => '<div class="font-color-BF2026"><p>'.$msg.'</p></div>', 'error' => $error));
        } else {
            return json_encode(array('msg' => '<div class="font-color-4BB748"><p>' .$msg. '</p></div>', 'error' => $error));
        }
    }
}