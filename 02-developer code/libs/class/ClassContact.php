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
              `fax` varchar(120) DEFAULT NULL,
              `address` text,
              `email` varchar(120) DEFAULT NULL,
              `title_facebook` varchar(120) DEFAULT NULL,
              `link_facebook` text,
              `title_twitter` varchar(120) DEFAULT NULL,
              `link_twitter` text,
              `title_line` varchar(120) DEFAULT NULL,
              `link_line` text,
              `qr_code_line` text,
              `title_ggp` varchar(120) DEFAULT NULL,
              `link_ggp` text,
              `latitude` varchar(50) DEFAULT NULL,
              `longitude` varchar(50) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ";
        dbDelta($sql);
    }

    public function getContact($id = 0)
    {
//        if (!$id)
//            $this->createDB();
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
                'fax' => @$fax,
                'address' => @$address,
                'title_facebook' => @$title_facebook,
                'link_facebook' => @$link_facebook,
                'title_twitter' => @$title_twitter,
                'link_twitter' => @$link_twitter,
                'title_line' => @$title_line,
                'link_line' => @$link_line,
                'qr_code_line' => @$qr_code_line,
                'title_ggp' => @$title_ggp,
                'link_ggp' => @$link_ggp,
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
                'fax' => @$fax,
                'address' => @$address,
                'email' => @$email,
                'title_facebook' => @$title_facebook,
                'link_facebook' => @$link_facebook,
                'title_twitter' => @$title_twitter,
                'link_twitter' => @$link_twitter,
                'title_line' => @$title_line,
                'link_line' => @$link_line,
                'qr_code_line' => @$qr_code_line,
                'title_ggp' => @$title_ggp,
                'link_ggp' => @$link_ggp,
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

    function buildContentHtmlEmail($post)
    {
        $send_subject = empty($post['send_subject']) ? '' : $post['send_subject'];
        $send_name = empty($post['send_name']) ? '' : $post['send_name'];
        $send_email = empty($post['send_email']) ? '' : $post['send_email'];
        $send_phone_number = empty($post['send_phone_number']) ? '' : $post['send_phone_number'];
        $send_message = empty($post['send_message']) ? '' : $post['send_message'];
        ob_start();
        ?>
        <table>
        <tr>
            <td>Subject:</td>
            <td><?php echo @$send_subject; ?></td>
        </tr>
        <tr>
            <td>Name:</td>
            <td><?php echo @$send_name; ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php echo @$send_email; ?></td>
        </tr>
        <tr>
            <td>Phone number:</td>
            <td><?php echo @$send_phone_number; ?></td>
        </tr>
        <tr>
            <td>Message:</td>
            <td><?php echo @$send_message; ?></td>
        </tr>
        </table>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
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