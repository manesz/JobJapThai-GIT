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
//        $this->createDB();
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

    public function getSelectPackage($employer_id = 0, $id = 0)
    {
        $strAnd = $employer_id ? " AND employer_id=$employer_id" : "";
        $strAnd .= $id ? " AND id=$id" : "";
        $sql = "
            SELECT
              *
            FROM `$this->tableSelectPackage`
            WHERE 1
            AND publish=1
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

    public function buildTd2($array_package, $position, $str_select_package)
    {
        if (!$array_package)
            return '';
        $strTd = '<td class="col-md-7">';
        $checkAddHead1 = false;
        $checkAddHead2 = false;
        $selectPosition = explode('|', $str_select_package);
        foreach ($array_package as $key => $value) {
            if ($value->position == $position) {
                $isSelect = '';
                foreach ($selectPosition as $value2) {
                    list($selectIsMulti) = explode(',', $value2);
                    list($selectID) = explode(':', $selectIsMulti);
                    if ($selectID == $value->id) $isSelect = 'selected';
                }
                if ($value->type == 1) {
                    if (!$checkAddHead1) {
                        $checkAddHead1 = true;
                        $strTd .= '<select id="' . $value->name . '" name="' . $value->name . '"
                        class="form-control margin-top-10">';
                    }
                    $strTd .= '<option value="' . $value->id . '" ' . $isSelect . '>' . $value->text . '</option>';
                } else if ($value->type == 2) {
                    if (!$checkAddHead2) {
                        $checkAddHead2 = true;
                        $strTd .= '</select><select id="' . $value->name . '" name="' . $value->name . '"
                        class="form-control margin-top-10">';
                    }
                    $strTd .= '<option value="' . $value->id . '" ' . $isSelect . '>' . $value->text . '</option>';
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
//        $selectPosition = explode('|', $str_select_package);
        foreach ($array_package as $key => $value) {
            if ($value->name != $saveName) {
//                $price = $value->price;
//                foreach($selectPosition as $value2) {
//                    list($selectIsMulti) = explode(',', $value2);
//                    list($selectID) = explode(':', $selectIsMulti);
//                    if ($selectID == $value->id) $price = 'selected';
//                }
//                $strPrice = str_replace('.00', '', $price);
                $strJs .= "$value->name: array_price[$('#$value->name').val()],
                ";
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
                    jsHookCalPackage.$value->name = array_price[$(this).val()];
                    jsHookCalPackage.updateVal();
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
                    $strJs = "jsHookCalPackage.$value2->name";
                }
                if ($value2->type == 2 && !$checkType2) {
                    $checkType2 = true;
                    $strJs = "($strJs * jsHookCalPackage.$value2->name)";
                }
            }
        }
        return $strJs;
    }

    public function buildJsStrSelectPackage($array_package)
    {
        if (!$array_package)
            return 0;
        $arrJs = array();
        $savePosition = '';
        foreach ($array_package as $value1) {
            if ($value1->position != $savePosition) {
                $checkType1 = false;
                $checkType2 = false;
                $strJs = "";
                foreach ($array_package as $value2) {
                    if ($value2->position == $value1->position) {
                        if ($value2->type == 1 && !$checkType1) {
                            $checkType1 = true;
                            $strJs = "$('#$value2->name').val() + ':' + array_price[$('#$value2->name').val()]";
                        }
                        if ($value2->type == 2 && !$checkType2) {
                            $checkType2 = true;
                            $strJs = "$strJs + ',' + $('#$value2->name').val() + ':' + array_price[$('#$value2->name').val()]";
                        }
                    }
                }
                if ($strJs)
                    $arrJs[] = $strJs;
            }
            $savePosition = $value1->position;
        }
        $strReturn = implode(" + '|' + ", $arrJs);
        return $strReturn ? $strReturn : "''";
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
                $('.sum_position$value1->position').text(jsHookCalPackage.formatDollar($strCal));" : "";
            }
            $savePosition = $value1->position;
        }
        return $strReturn;
    }

    private function getPricePackageByID($array_package, $id)
    {
        foreach ($array_package as $value) {
            if ($value->id == $id) {
                return $value->price;
            }
        }
        return false;
    }

    private function getTextPackageByID($array_package, $id)
    {
        $strReturn = "";
        foreach ($array_package as $value) {
            if ($value->id == $id) {
                return $value->text;
            }
        }
        return $strReturn;
    }

    public function buildTdList($array_package, $str_select_package, $package_id)
    {
        $strTd = "";
        $arrPosition = explode('|', $str_select_package);
        foreach ($arrPosition as $value) {
            list($text, $time) = explode(',', $value);
            list($idText) = explode(':', $text);
            if ($time) {
                list($idTime) = explode(':', $time);
                $strTime = $this->getTextPackageByID($array_package, $idTime);
            } else {
                $strTime = "";
            }
            $strText = $this->getTextPackageByID($array_package, $idText);
            $strTd .= "<td>$strText";
            $strTd .= $strTime ? "/$strTime</td>" : "</td>";
        }
        $strTd .= "<td>--</td>";
        $strTd .= "<td><a href='#' data-toggle=\"modal\"
        class='edit_package' data='$package_id' data-target=\"#modal_package\">Edit</a></td>";
        return $strTd;
    }

    public function addSelectPackage($post)
    {
        extract($post);

        $array_package = $this->getPackage();
        $arrPosition = explode('|', $select_package);
        $arraySavePosition = array();
        foreach($arrPosition as $value) {
            list($text, $time) = explode(',', $value);
            list($idText) = explode(':', $text);
            $getValPrice = $this->getPricePackageByID($array_package, $idText);
            $strSelect = "$idText:$getValPrice";
            if ($time) {
                list($idTime) = explode(':', $time);
                $getValTime = $this->getPricePackageByID($array_package, $idTime);
                $strSelect = "$strSelect,$idTime:$getValTime";
            }
            $arraySavePosition[] = $strSelect;
        }
        $newStrSelectPackage = implode('|', $arraySavePosition);
        $result = $this->wpdb->insert(
            $this->tableSelectPackage,
            array(
                'employer_id' => $employer_id,
                'string_package' => $newStrSelectPackage,
                'create_datetime' => date_i18n('Y-m-d H:i:s'),
                'update_datetime' => '0000-00-00 00:00:00',
                'publish' => 1,
            ),
            array(
                '%d',
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

    public function editSelectPackage($post)
    {
        extract($post);
        if (empty($employer_id))
            return false;
        $array_package = $this->getPackage();
        $arrPosition = explode('|', $select_package);
        $arraySavePosition = array();
        foreach($arrPosition as $value) {
            list($text, $time) = explode(',', $value);
            list($idText) = explode(':', $text);
            $getValPrice = $this->getPricePackageByID($array_package, $idText);
            $strSelect = "$idText:$getValPrice";
            if ($time) {
                list($idTime) = explode(':', $time);
                $getValTime = $this->getPricePackageByID($array_package, $idTime);
                $strSelect = "$strSelect,$idTime:$getValTime";
            }
            $arraySavePosition[] = $strSelect;
        }
        $newStrSelectPackage = implode('|', $arraySavePosition);
        $result = $this->wpdb->update(
            $this->tableSelectPackage,
            array(
                'employer_id' => $employer_id,
                'string_package' => $newStrSelectPackage,
                'update_datetime' => date_i18n('Y-m-d H:i:s'),
                'publish' => 1,
            ),
            array('id' => $package_id),
            array(
                '%d',
                '%s',
                '%s',
                '%d',
            ),
            array('%d')
        );
        if ($result) {
            return true;
        }
        return false;
    }
}