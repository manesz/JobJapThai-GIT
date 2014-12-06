<?php

class Contact
{
    private $wpdb;
    private $tableContact = "ics_contact";

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    function createDB()
    {
        $sql = "
            DROP TABLE IF EXISTS $this->tableContact;
            CREATE TABLE `$this->tableContact` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `massage` text,
              `tel` varchar(120) DEFAULT NULL,
              `email` varchar(120) DEFAULT NULL,
              `title_facebook` varchar(120) DEFAULT NULL,
              `link_facebook` text,
              `title_twitter` varchar(120) DEFAULT NULL,
              `link_twitter` text,
              `title_line` varchar(120) DEFAULT NULL,
              `link_line` text,
              `qr_code_line` text,
              `title_pinterest` varchar(120) DEFAULT NULL,
              `link_pinterest` text,
              `title_tripadvisor` varchar(120) DEFAULT NULL,
              `link_tripadvisor` text,
              `latitude` varchar(50) DEFAULT NULL,
              `longitude` varchar(50) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ";
        dbDelta($sql);
    }

    public function getContact($id = 0)
    {
//        $this->createDB();
        $strAnd = $id ? " AND id=$id" : "";
        $sql = "
            SELECT
              *
            FROM `$this->tableContact`
            WHERE 1
            $strAnd
        ";
        $myRows = $this->wpdb->get_results($sql);
        return $myRows;
    }

    public function checkIsContact()
    {
        $rows = $this->getContact(1);
        if ($rows) return true;
        else return false;
    }

    public function addContact($post)
    {
        extract($post);
        $result = $this->wpdb->insert(
            $this->tableContact,
            array(
                'massage' => @$massage,
                'tel' => @$tel,
                'email' => @$email,
                'title_facebook' => @$title_facebook,
                'link_facebook' => @$link_facebook,
                'title_twitter' => @$title_twitter,
                'link_twitter' => @$link_twitter,
                'title_line' => @$title_line,
                'link_line' => @$link_line,
                'qr_code_line' => @$qr_code_line,
                'title_pinterest' => @$title_pinterest,
                'link_pinterest' => @$link_pinterest,
                'title_tripadvisor' => @$title_tripadvisor,
                'link_tripadvisor' => @$link_tripadvisor,
                'latitude' => @$latitude,
                'longitude' => @$longitude,
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            )
        );
        if ($result) {
            return $this->wpdb->insert_id;
        }
        return false;
    }

    public function editContact($post)
    {
        extract($post);
        $this->wpdb->update(
            $this->tableContact,
            array(
                'massage' => @$massage,
                'tel' => @$tel,
                'email' => @$email,
                'title_facebook' => @$title_facebook,
                'link_facebook' => @$link_facebook,
                'title_twitter' => @$title_twitter,
                'link_twitter' => @$link_twitter,
                'title_line' => @$title_line,
                'link_line' => @$link_line,
                'qr_code_line' => @$qr_code_line,
                'title_pinterest' => @$title_pinterest,
                'link_pinterest' => @$link_pinterest,
                'title_tripadvisor' => @$title_tripadvisor,
                'link_tripadvisor' => @$link_tripadvisor,
                'latitude' => @$latitude,
                'longitude' => @$longitude,
            ),
            array('id' => 1),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            ),
            array('%d')
        );
        return 1;
    }
}

$objClassContact = new Contact($wpdb);
if (@$_POST) {
    if (@$_POST['contact_post']) {
        $checkIsContact = $objClassContact->checkIsContact();
        if ($checkIsContact) {
            $result = $objClassContact->editContact($_POST);
        } else {
            $result = $objClassContact->addContact($_POST);
        }
        if ($result)
            echo 'success';
        else
            echo 'fail';
        exit;
    }
}