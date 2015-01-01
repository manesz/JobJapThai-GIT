<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 11/01/2558
 * Time: 10:03 น.
 */

class Favorite
{
    private $wpdb;
    public $tableFavoriteJob = "ics_favorite_job";
    public $tableFavoriteCompany = "ics_favorite_company";

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    public function listFavJob($id = 0, $job_id = 0, $user_id = 0)
    {
        $strAnd = $id ? " AND id=$id": "";
        $strAnd .= $job_id ? " AND job_id=$job_id": "";
        $strAnd .= $user_id ? " AND user_id=$user_id": "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableFavoriteJob
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function listFavCompany($id = 0, $company_id = 0, $user_id = 0)
    {
        $strAnd = $id ? " AND id=$id": "";
        $strAnd .= $company_id ? " AND company_id=$company_id": "";
        $strAnd .= $user_id ? " AND user_id=$user_id": "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableFavoriteCompany
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function addFavJob($user_id, $job_id) {
        if (!$user_id || !$job_id)
            return '<div class="font-color-BF2026"><p>Fail No id.</p></div>';
        $sql = "
            INSERT INTO `$this->tableFavoriteJob`
            (
             `user_id`,
             `job_id`,
             `create_datetime`,
             `update_datetime`,
             `publish`)
            VALUES (
            '{$user_id}',
            '{$job_id}',
            NOW(),
            NOW(),
            1
        );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
//        return $this->wpdb->insert_id;
        return '<div class="font-color-4BB748"><p>Favorite Success.</p></div>';
    }

    public function addFavCompany($user_id, $company_id) {
        if (!$user_id || !$company_id)
            return '<div class="font-color-BF2026"><p>Fail No id.</p></div>';
        $sql = "
            INSERT INTO `$this->tableFavoriteCompany`
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
        return '<div class="font-color-4BB748"><p>Favorite Success.</p></div>';
    }

    public function setPublishJob($id)
    {
        $sql = "
            UPDATE `$this->tableFavoriteJob`
            SET
              `publish` = 0,
              `update_datetime` = NOW()
            WHERE `id` = '{$id}';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return '<div class="font-color-BF2026"><p>Sorry Edit Error.</p></div>';
        return '<div class="font-color-4BB748"><p>Edit Success.</p></div>';
    }

    public function setPublishCompany($id)
    {
        $sql = "
            UPDATE `$this->tableFavoriteCompany`
            SET
              `publish` = 0,
              `update_datetime` = NOW()
            WHERE `id` = '{$id}';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return '<div class="font-color-BF2026"><p>Sorry Edit Error.</p></div>';
        return '<div class="font-color-4BB748"><p>Edit Success.</p></div>';
    }

    public function checkJobIsFavorite($user_id, $job_id) {
        $result = $this->listFavJob(0, $job_id, $user_id);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function checkCompanyIsFavorite($user_id, $company_id) {
        $result = $this->listFavCompany(0, $company_id, $user_id);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}