<?php

class Employer
{
    private $wpdb;
    public $tableUser = "";
    public $tableEmployerPackage = "ics_employer_package";
    public $tableCompanyInfo = "ics_company_information_for_contact";
    public $countValue = 0;
    public $classPagination = null;

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
        $this->tableUser = $this->wpdb->users;
    }

    public function createTable()
    {
        $sql = "
            CREATE TABLE `$this->tableEmployerPackage` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `employer_id` int(10) unsigned DEFAULT NULL,
              `position_amount` varchar(50) DEFAULT NULL,
              `duration` varchar(50) DEFAULT NULL,
              `super_hot_job_duration` varchar(50) DEFAULT NULL,
              `hot_job_type` varchar(50) DEFAULT NULL,
              `hot_job_duration` varchar(50) DEFAULT NULL,
              `urgent_duration` varchar(50) DEFAULT NULL,
              `create_datetime` datetime DEFAULT NULL,
              `update_datetime` datetime DEFAULT NULL,
              `publish` int(1) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ";
        dbDelta($sql);

        $sql = "
            CREATE TABLE `$this->tableCompanyInfo` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `employer_id` int(10) unsigned DEFAULT NULL,
              `contact_person` varchar(50) DEFAULT NULL,
              `company_name` varchar(50) DEFAULT NULL,
              `business_type` text,
              `company_profile_and_business_operation` text,
              `walfare_and_benefit` text,
              `apply_method` text,
              `address` text,
              `contact_country` text,
              `contact_industrial_park` int(11) DEFAULT '0',
              `province` text,
              `district` text,
              `sub_district` text,
              `postcode` varchar(50) DEFAULT NULL,
              `tel` varchar(50) DEFAULT NULL,
              `fax` varchar(50) DEFAULT NULL,
              `email` varchar(50) DEFAULT NULL,
              `website` text,
              `directions` text,
              `options` text,
              `create_datetime` datetime DEFAULT NULL,
              `update_datetime` datetime DEFAULT NULL,
              `publish` int(1) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ";
        dbDelta($sql);
    }

    public function getList($id = 0)
    {
        $strAnd = $id ? " AND a.ID=$id" : "";
        $sql = "
            SELECT
              a.*,
              b.*,
              c.*
            FROM
              $this->tableUser a
            INNER JOIN
              $this->tableCompanyInfo b
            ON (a.ID = b.employer_id)
            INNER JOIN
              $this->tableEmployerPackage c
            ON (a.ID = c.employer_id)
            WHERE 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function getListUser($employer_id = 0)
    {
        $all_meta_for_user = get_user_meta(9);
        print_r($all_meta_for_user);
    }

    public function getCompanyInfo($employer_id = 0)
    {
        $strAnd = $employer_id ? " AND employer_id=$employer_id" : "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableCompanyInfo
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function getPackage($employer_id = 0)
    {
        $strAnd = $employer_id ? " AND employer_id=$employer_id" : "";
        $sql = "
            SELECT
              *
            FROM
              $this->tableEmployerPackage
            WHERE 1
            $strAnd
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function addCompanyInfo($post)
    {
        $employer_id = isset($post['employer_id']) ? $post['employer_id'] : false;
        $contact_person = isset($post['employerContactPerson']) ? $post['employerContactPerson'] : false;
        $company_name = isset($post['employerContactCompanyName']) ? $post['employerContactCompanyName'] : false;
        $business_type = isset($post['employerContactBusinessType']) ? $post['employerContactBusinessType'] : false;
        $company_profile_and_business_operation = isset($post['employerContactCompanyProfile']) ? $post['employerContactCompanyProfile'] : false;
        $walfare_and_benefit = isset($post['employerContactWalfare']) ? $post['employerContactWalfare'] : false;
        $apply_method = isset($post['employerContactApplyMedtod']) ? $post['employerContactApplyMedtod'] : false;
        $address = isset($post['employerContactAddress']) ? $post['employerContactAddress'] : false;
        $contact_country = isset($post['employerContactCountry']) ? $post['employerContactCountry'] : false;
        $contact_industrial_park = isset($post['employerContactIndustrialPark']) ? $post['employerContactIndustrialPark'] : 0;
        $province = isset($post['employerContactProvince']) ? $post['employerContactProvince'] : false;
        $district = isset($post['employerContactDistinct']) ? $post['employerContactDistinct'] : false;
        $sub_district = isset($post['employerContactSubDistinct']) ? $post['employerContactSubDistinct'] : false;
        $postcode = isset($post['employerContactPostcode']) ? $post['employerContactPostcode'] : false;
        $tel = isset($post['employerContactTel']) ? $post['employerContactTel'] : false;
        $fax = isset($post['employerContactFax']) ? $post['employerContactFax'] : false;
        $email = isset($post['employerContactEmail']) ? $post['employerContactEmail'] : false;
        $website = isset($post['employerContactWebsite']) ? $post['employerContactWebsite'] : false;
        $directions = isset($post['employerContactDirections']) ? $post['employerContactDirections'] : false;
        $options = isset($post['employerContactOption']) ? $post['employerContactOption'] : false;
        if ($options) {
            $options = implode(',', $options);
        }
        if (!$employer_id)
            return false;
        $sql = "
            INSERT INTO `$this->tableCompanyInfo` (
              `employer_id`,
              `contact_person`,
              `company_name`,
              `business_type`,
              `company_profile_and_business_operation`,
              `walfare_and_benefit`,
              `apply_method`,
              `address`,
              `contact_country`,
              `contact_industrial_park`,
              `province`,
              `district`,
              `sub_district`,
              `postcode`,
              `tel`,
              `fax`,
              `email`,
              `website`,
              `directions`,
              `options`,
              `create_datetime`,
              `publish`
            )
            VALUES
              (
                '{$employer_id}',
                '{$contact_person}',
                '{$company_name}',
                '{$business_type}',
                '{$company_profile_and_business_operation}',
                '{$walfare_and_benefit}',
                '{$apply_method}',
                '{$address}',
                '{$contact_country}',
                '{$contact_industrial_park}',
                '{$province}',
                '{$district}',
                '{$sub_district}',
                '{$postcode}',
                '{$tel}',
                '{$fax}',
                '{$email}',
                '{$website}',
                '{$directions}',
                '{$options}',
                NOW(),
                1
              );
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return $this->wpdb->insert_id;
    }

    public function addPackage($post)
    {

    }

    public function editCompanyInfo($post)
    {
        $employer_id = isset($post['employer_id']) ? $post['employer_id'] : false;
        $contact_person = isset($post['employerContactPerson']) ? $post['employerContactPerson'] : false;
        $company_name = isset($post['employerContactCompanyName']) ? $post['employerContactCompanyName'] : false;
        $business_type = isset($post['employerContactBusinessType']) ? $post['employerContactBusinessType'] : false;
        $company_profile_and_business_operation = isset($post['employerContactCompanyProfile']) ? $post['employerContactCompanyProfile'] : false;
        $walfare_and_benefit = isset($post['employerContactWalfare']) ? $post['employerContactWalfare'] : false;
        $apply_method = isset($post['employerContactApplyMedtod']) ? $post['employerContactApplyMedtod'] : false;
        $address = isset($post['employerContactAddress']) ? $post['employerContactAddress'] : false;
        $contact_country = isset($post['employerContactCountry']) ? $post['employerContactCountry'] : false;
        $contact_industrial_park = isset($post['employerContactIndustrialPark']) ? $post['employerContactIndustrialPark'] : 0;
        $province = isset($post['employerContactProvince']) ? $post['employerContactProvince'] : false;
        $district = isset($post['employerContactDistinct']) ? $post['employerContactDistinct'] : false;
        $sub_district = isset($post['employerContactSubDistinct']) ? $post['employerContactSubDistinct'] : false;
        $postcode = isset($post['employerContactPostcode']) ? $post['employerContactPostcode'] : false;
        $tel = isset($post['employerContactTel']) ? $post['employerContactTel'] : false;
        $fax = isset($post['employerContactFax']) ? $post['employerContactFax'] : false;
        $email = isset($post['employerContactEmail']) ? $post['employerContactEmail'] : false;
        $website = isset($post['employerContactWebsite']) ? $post['employerContactWebsite'] : false;
        $directions = isset($post['employerContactDirections']) ? $post['employerContactDirections'] : false;
        $options = isset($post['employerContactOption']) ? $post['employerContactOption'] : false;
        if ($options) {
            $options = implode(',', $options);
        }
        if (!$employer_id)
            return false;
        $sql = "
            UPDATE `ics_company_information_for_contact`
            SET
              `contact_person` = '{$contact_person}',
              `company_name` = '{$company_name}',
              `business_type` = '{$business_type}',
              `company_profile_and_business_operation` = '{$company_profile_and_business_operation}',
              `walfare_and_benefit` = '{$walfare_and_benefit}',
              `apply_method` = '{$apply_method}',
              `address` = '{$address}',
              `contact_country` = '{$contact_country}',
              `contact_industrial_park` = '{$contact_industrial_park}',
              `province` = '{$province}',
              `district` = '{$district}',
              `sub_district` = '{$sub_district}',
              `postcode` = '{$postcode}',
              `tel` = '{$tel}',
              `fax` = '{$fax}',
              `email` = '{$email}',
              `website` = '{$website}',
              `directions` = '{$directions}',
              `options` = '{$options}',
              `update_datetime` = NOW()
            WHERE `employer_id` = '{$employer_id}';
        ";
        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return true;
    }

    public function editPackage($post)
    {

    }

    public function addData($post)
    {
        extract($post);
        $result = $this->wpdb->insert(
            $this->tableBannerSlide,
            array(
                //'title' => @$gtitle,
                //'description' => @$gdesc,
                'sort' => @$gsort,
                'link' => @$glink,
                'image_path' => @$pathimg,
                'create_datetime' => date_i18n("Y-m-d H:i:s"),
                'update_datetime' => date_i18n("Y-m-d H:i:s"),
                'publish' => 1,
            ),
            array(
//                '%s',
//                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
            )
        );
        if ($result) {
            return $this->wpdb->insert_id;
        }
        return false;
    }

    public function editData($data)
    {
        extract($data);
        $sql = "
            UPDATE $this->tableBannerSlide
            SET
                sort='{$gsort}',
                image_path='{$pathimg}',
                update_datetime=NOW(),
                link='{$glink}'
            WHERE 1
            AND id = {$galleryid};
        ";
        if ($galleryid) {
            $qupdate = $this->wpdb->query($sql);
            return $qupdate;
        } else {
            return FALSE;
        }
    }

    public function updateOder($array_order)
    {
        if (!$array_order)
            return true;
//        var_dump($array_order);
        $sql = "";
        foreach ($array_order as $key => $value) {
            $sort = $key + 1;
//            $sql .= "
//                UPDATE
//                  $this->tableBannerSlide
//                SET
//                    sort={$sort}
//                WHERE 1
//                AND id={$value};
//            ";

            $result = $this->wpdb->update(
                $this->tableBannerSlide,
                array(
                    'sort' => $sort,
                    'update_datetime' => date_i18n('Y-m-d H:i:s'),
                ),
                array('id' => $value),
                array('%d', '%s'),
                array('%d')

            );
//            $result = $this->wpdb->query($sql);
            if (!$result)
                return false;
        }
        return true;
    }

    public function deleteValue($id)
    {
        $sql = "
            UPDATE $this->tableBannerSlide
            SET publish = 0
            WHERE 1
            AND id = {$id};
        ";
        if ($id) {
            $result = $this->wpdb->query($sql);
            return $result;
        } else {
            return FALSE;
        }
    }
}