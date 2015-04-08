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
    public $tableCandidateInfo = "ics_candidate_information";
    public $tableCandidateInEducation = "ics_candidate_education";
    public $tableCandidateInSkill = "ics_candidate_skill_languages";

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    function listApplyJob($id = 0, $job_id = 0, $user_id = 0, $employer_id = 0, $str_order = "")
    {
        $strAnd = $id ? " AND id=$id": "";
        $strAnd .= $job_id ? " AND job_id=$job_id": "";
        $strAnd .= $user_id ? " AND user_id=$user_id": "";
        $strAnd .= $employer_id ? " AND employer_id=$employer_id": "";
        $strAnd .= $str_order ? " $str_order": "";
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

    function listCandidateApplyJob($job_id = 0, $candidate_id = 0, $employer_id = 0, $str_order = "")
    {
        $strAnd = $job_id ? " AND a.job_id=$job_id": "";
        $strAnd .= $candidate_id ? " AND a.user_id=$candidate_id": "";
        $strAnd .= $employer_id ? " AND a.employer_id=$employer_id": "";
        $strAnd .= $str_order ? " $str_order": " GROUP BY a.user_id";
        $sql = "
            SELECT
              a.*,
              b.*,
              c.*,
              d.*,
              e.*
            FROM
              $this->tableApplyJob a
            INNER JOIN $this->tableCandidateInfo b
            ON (a.user_id = b.candidate_id AND b.publish = 1)
            LEFT JOIN $this->tableCandidateInEducation c
            ON (a.user_id = c.candidate_id AND c.publish = 1)
            LEFT JOIN (
                SELECT candidate_id, MAX(id) AS max_id
                FROM $this->tableCandidateInEducation
                WHERE publish = 1
                GROUP BY candidate_id
            ) d ON (a.user_id = d.candidate_id AND d.max_id = c.id)
            LEFT JOIN $this->tableCandidateInSkill e
            ON (a.user_id = e.candidate_id AND e.publish = 1)
            WHERE 1
            AND a.publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function listApplyCompany($id = 0, $employer_id = 0, $user_id = 0)
    {
        $strAnd = $id ? " AND id=$id": "";
        $strAnd .= $employer_id ? " AND employer_id=$employer_id": "";
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

    function addApplyJob($user_id, $job_id, $employer_id, $return_json = true) {
        if (!$user_id || !$job_id || !$employer_id)
            return $this->returnMessage('Fail No id.', true);
        $sql = "
            INSERT INTO `$this->tableApplyJob`
            (
             `user_id`,
             `job_id`,
             `employer_id`,
             `create_datetime`,
             `update_datetime`,
             `publish`)
            VALUES (
            '{$user_id}',
            '{$job_id}',
            '{$employer_id}',
            NOW(),
            NOW(),
            1
        );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            $this->returnMessage('Apply Fail.', true);
//        return $this->wpdb->insert_id;
        return $this->returnMessage('Apply Success.', false, $return_json);
    }

    public function addApplyCompany($user_id, $employer_id) {
        if (!$user_id || !$employer_id)
            return $this->returnMessage('Fail No id.', true);
        $sql = "
            INSERT INTO `$this->tableApplyCompany`
            (
             `user_id`,
             `employer_id`,
             `create_datetime`,
             `update_datetime`,
             `publish`)
            VALUES (
            '{$user_id}',
            '{$employer_id}',
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

    public function checkCompanyIsApply($user_id, $employer_id) {
        $result = $this->listApplyCompany(0, $employer_id, $user_id);
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