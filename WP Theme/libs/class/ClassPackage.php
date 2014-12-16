<?php

class Package
{
    private $wpdb;
    private $tablePackage = "ics_employer_package";
    private $tableSelectPackage = "ics_employer_select_package";

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    function createDB()
    {
        $sql = "
            DROP TABLE IF EXISTS $this->tablePackage;
            CREATE TABLE `$this->tablePackage` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `type` int(1) DEFAULT '1' COMMENT '1=package, 2=time',
              `position` int(11) DEFAULT NULL,
              `name` varchar(120) DEFAULT NULL,
              `title` varchar(120) DEFAULT NULL,
              `text` varchar(120) DEFAULT NULL,
              `price` decimal(10,2) DEFAULT '0.00',
              `description` text,
              `require` int(1) DEFAULT '0',
              `create_datetime` datetime DEFAULT NULL,
              `update_datetime` datetime DEFAULT NULL,
              `publish` int(1) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ";
        dbDelta($sql);
    }

    public function getPackage($id = 0)
    {
//        if (!$id)
        $this->createDB();
        $strAnd = $id ? " AND id=$id" : "";
        $sql = "
            SELECT
              *
            FROM `$this->tablePackage`
            WHERE 1
            $strAnd
        ";
        $myRows = $this->wpdb->get_results($sql);
        return $myRows;
    }

    public function buildTd1($array_package, $position)
    {
        if (!$array_package)
            return '';
        $strTd = '<td class="col-md-3">';
        $checkAddHead1 = false;
        $checkAddHead2 = false;
        foreach ($array_package as $key => $value) {
            if ($value->position == $position) {
                if (!$checkAddHead1 && $value->type == 1) {
                    $checkAddHead1 = true;
                    $strTd .= '
                    <label for="' . $value->name . '" class=" margin-top-10">' . $value->title;
                    $strTd .= $value->require ? '<span
                        class="font-color-red">*</span></label>' : '';
                } else if (!$checkAddHead2 && $value->type == 2) {
                    $checkAddHead2 = true;
                    $strTd .= '
                    <br/><label for="' . $value->name . '" class=" margin-top-10">' . $value->title;
                    $strTd .= $value->require ? '<span
                        class="font-color-red">*</span></label>' : '';
                }
            }
        }
        $strTd .= '</td>';
        return $strTd;
    }

    public function buildTd2($array_package, $position)
    {
        if (!$array_package)
            return '';
        $strTd = '<td class="col-md-7">';
        $checkAddHead1 = false;
        $checkAddHead2 = false;
        foreach ($array_package as $key => $value) {
            if ($value->position == $position) {
                if ($value->type == 1) {
                    if (!$checkAddHead1) {
                        $checkAddHead1 = true;
                        $strTd .= '<select id="' . $value->name . '" name="' . $value->name . '"
                        class="form-control margin-top-10">';
                    }
                    $strTd .= '<option value="' . $value->id . '">' . $value->text . '</option>';
                } else if ($value->type == 2) {
                    if (!$checkAddHead2) {
                        $checkAddHead2 = true;
                        $strTd .= '</select><select id="' . $value->name . '" name="' . $value->name . '"
                        class="form-control margin-top-10">';
                    }
                    $strTd .= '<option value="' . $value->id . '">' . $value->text . '</option>';
                }
            }
        }
        $strTd .= '</select></td>';
        return $strTd;
    }

    public function buildTd3($array_package, $position)
    {
        if (!$array_package)
            return '';
        $strTd = '<td class="col-md-4">';
        $checkAddHead1 = false;
        foreach ($array_package as $key => $value) {
            if ($value->position == $position) {
                if (!$checkAddHead1) {
                    $checkAddHead1 = true;
                    $valueBath = $value->require ? $value->price : 0;
                    $strTd .= '<span class="sum_position' . $position . '">' . $valueBath . '</span> บาท';
                }
            }
        }
        $strTd .= '</td>';
        return $strTd;
    }

    public function buildJsParameter($array_package)
    {
        if (!$array_package)
            return '';
        $strJs = '';
        $saveName = '';
        foreach ($array_package as $key => $value) {
            if ($value->name != $saveName) {
                $strPrice = str_replace('.00', '', $value->price);
                $strJs .= "$value->name: $strPrice,";
            }
            $saveName = $value->name;
        }
        return $strJs;
    }

    public function buildJsEvent($array_package)
    {
        if (!$array_package)
            return '';
        $strJs = '';
        $saveName = '';
        foreach ($array_package as $key => $value) {
            if ($value->name != $saveName) {
                $strJs .= "
                $('#$value->name').on('change', function () {
                    jshook.$value->name = array_price[$(this).val()];
                    jshook.updateVal();
                    return false;
                });
                ";
            }
            $saveName = $value->name;
        }
        return $strJs;
    }

    private function buildStrCalTime($array_package, $position)
    {
        $checkType1 = false;
        $checkType2 = false;
        $strJs = "";
        foreach ($array_package as $value2) {
            if ($value2->position == $position) {
                if ($value2->type == 1 && !$checkType1) {
                    $checkType1 = true;
                    $strJs = "jshook.$value2->name";
                }
                if ($value2->type == 2 && !$checkType2) {
                    $checkType2 = true;
                    $strJs = "($strJs * jshook.$value2->name)";
                }
            }
        }
        return $strJs;
    }

    public function buildJsCalValue($array_package)
    {
        if (!$array_package)
            return 0;
        $arrJs = array();
        $savePosition = '';
        foreach ($array_package as $value1) {
            if ($value1->position != $savePosition) {
                $strJs = $this->buildStrCalTime($array_package, $value1->position);
                if ($strJs)
                    $arrJs[] = $strJs;
            }
            $savePosition = $value1->position;
        }
        $strReturn = implode(' + ', $arrJs);
        return $strReturn ? $strReturn : 0;
    }

    public function buildJsArrayPrice($array_package)
    {
        $strJs = "var array_price = [];";
        foreach ($array_package as $value1) {
            $strPrice = str_replace('.00', '', $value1->price);
            $strJs .= "
            array_price[$value1->id] = $strPrice;";
        }
        return $strJs;
    }

    public function buildJsSumValue($array_package)
    {
        if (!$array_package)
            return '';
        $savePosition = '';
        $strReturn = "";
        foreach ($array_package as $value1) {
            if ($value1->position != $savePosition) {
                $strCal = $this->buildStrCalTime($array_package, $value1->position);
                $strReturn .= $strCal ? "
                $('.sum_position$value1->position').text(jshook.formatDollar($strCal));" : "";
            }
            $savePosition = $value1->position;
        }
        return $strReturn;
    }

    public function addPackage($post)
    {
        extract($post);
        $result = $this->wpdb->insert(
            $this->tablePackage,
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

    public function editPackage($post)
    {
        extract($post);
        $this->wpdb->update(
            $this->tablePackage,
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
}