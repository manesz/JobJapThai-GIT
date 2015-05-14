<?php

class Package
{
    private $wpdb;
    public $tablePackage = "ics_employer_package";
    public $tableSelectPackage = "ics_employer_select_package";
    public $tableCompanyInfo = "ics_company_information_for_contact";
    public $tableRequestProfile = "ics_request_profile";
    public $tableApplyHotJob = "ics_apply_hot_job";
    public $strDateCreate = 'start_display';
    public $numDayDisplay = 'num_day_display';
    public $dayAutoUpdate = 'day_auto_update';
    public $strSelectPackagePostID = "select_package_post_id";
    public $strSelectHotJobID = "select_package_hot_job_id";
    public $tableUser = "";

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
        $this->tableUser = $this->wpdb->users;
    }

    function getPackage($id = 0, $position = 0)
    {
        $strAnd = $id ? " AND id=$id" : "";
        $strAnd .= $position ? " AND position=$position" : "";
        $sql = "
            SELECT
              *
            FROM `$this->tablePackage`
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $myRows = $this->wpdb->get_results($sql);
        return $myRows;
    }

    function getSelectPackage($employer_id = 0, $id = 0, $approve = 0, $status = "")
    {
        $strAnd = $employer_id ? " AND employer_id=$employer_id" : "";
        $strAnd .= $id ? " AND id=$id" : "";
        $strAnd .= $approve ? " AND approve=$approve" : "";
        $strAnd .= $status ? " AND status='$status'" : "";
        $sql = "
            SELECT
              *
            FROM `$this->tableSelectPackage`
            WHERE 1
            AND publish=1
            $strAnd
            ORDER BY id DESC
        ";
        $myRows = $this->wpdb->get_results($sql);
        return $myRows;
    }

    function getUserSelectPackage($id = 0, $employer_id = 0, $approve = "", $status = "", $order_by = "")
    {
        $strAnd = $id ? " AND a.id=$id" : "";
        $strAnd .= $employer_id ? " AND a.employer_id=$employer_id" : "";
        $strAnd .= $approve ? " AND a.approve=$approve" : "";
        $strAnd .= $status ? " AND a.status='$status'" : "";
        $sql = "
            SELECT
              a.*,
              b.*,
              c.*,
              c.id AS select_package_id
            FROM
              $this->tableUser a
            INNER JOIN
              $this->tableCompanyInfo b
            ON (a.ID = b.employer_id)
            INNER JOIN
              $this->tableSelectPackage c
            ON (a.ID = c.employer_id)
            WHERE 1
            $strAnd
            $order_by
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function buildTd1($array_package, $position, $title = "")
    {
        if (!$array_package)
            return '';
        $strTd = '<td class="col-md-3">';
        $checkAddHead1 = false;
        $checkAddHead2 = false;
        foreach ($array_package as $key => $value) {
            if ($value->position == $position) {
                //if (!$checkAddHead1 && $value->type == 1) {
                //$checkAddHead1 = true;
                $strTd .= '
                    <label for="select_package' . $value->position . '" class=" margin-top-10">' . $title;
                $strTd .= $value->require ? '<span
                        class="font-color-red">*</span></label>' : '';
                break;
//                    } else if (!$checkAddHead2 && $value->type == 2) {
//                        $checkAddHead2 = true;
//                        $strTd .= '
//                        <br/><label for="select_package' . $value->position . '" class=" margin-top-10">' . $value->title;
//                        $strTd .= $value->require ? '<span
//                            class="font-color-red">*</span></label>' : '';
//                    }
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
                //if ($value->type == 1) {
                if (!$checkAddHead1) {
                    $checkAddHead1 = true;
                    $strTd .= '<select id="select_package' . $value->position . '" name="select_package' . $value->position . '"
                        class="form-control margin-top-10">';
                }
                $strTd .= '<option value="' . $value->id . '" ' . $isSelect . '>' . $value->text . '</option>';
//                } else if ($value->type == 2) {
//                    if (!$checkAddHead2) {
//                        $checkAddHead2 = true;
//                        $strTd .= '</select><select id="select_package' . $value->position . '" name="select_package' . $value->position . '"
//                        class="form-control margin-top-10">';
//                    }
//                    $strTd .= '<option value="' . $value->id . '" ' . $isSelect . '>' . $value->text . '</option>';
//                }
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
            if ($value->position != $saveName) {
//                $price = $value->price;
//                foreach($selectPosition as $value2) {
//                    list($selectIsMulti) = explode(',', $value2);
//                    list($selectID) = explode(':', $selectIsMulti);
//                    if ($selectID == $value->id) $price = 'selected';
//                }
//                $strPrice = str_replace('.00', '', $price);
                $strJs .= "select_package$value->position: array_price[$('#select_package$value->position').val()],
                ";
            }
            $saveName = $value->position;
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
            if ($value->position != $saveName) {
                $strJs .= "
                $('#select_package$value->position').on('change', function () {
                    jsHookCalPackage.select_package$value->position = array_price[$(this).val()];
                    jsHookCalPackage.updateVal();
                    return false;
                });
                ";
            }
            $saveName = $value->position;
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
//                if ($value2->type == 1 && !$checkType1) {
                $checkType1 = true;
                $strJs = "jsHookCalPackage.select_package$value2->position";
                break;
//                }
//                if ($value2->type == 2 && !$checkType2) {
//                    $checkType2 = true;
//                    $strJs = "($strJs * jsHookCalPackage.select_package$value2->position)";
//                }
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
//                        if ($value2->type == 1 && !$checkType1) {
                        $checkType1 = true;
                        $strJs = "$('#select_package$value2->position').val() + ':' + array_price[$('#select_package$value2->position').val()]";
                        break;
//                        }
//                        if ($value2->type == 2 && !$checkType2) {
//                            $checkType2 = true;
//                            $strJs = "$strJs + ',' + $('#select_package$value2->position').val() + ':' + array_price[$('#select_package$value2->position').val()]";
//                        }
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

    private function getValuePackageByID($array_package, $id)
    {
        foreach ($array_package as $value) {
            if ($value->id == $id) {
                return $value->value;
            }
        }
        return false;
    }

    private function getTextPackageByID($array_package, $id)
    {
        $strReturn = "";
        foreach ($array_package as $value) {
            if ($value->id == $id) {
                return $value;
            }
        }
        return $strReturn;
    }

    function buildTdList($array_package, $str_select_package, $package_id, $status)
    {
        $strTd = "";
        $arrPosition = explode('|', $str_select_package);

        list($idText, $price, $strTime) = explode(':', $arrPosition[0]);
        $strText = $this->getTextPackageByID($array_package, $idText);
        $strTd .= "<td>$strText->text / ";

        list($idText, $price, $strTime) = explode(':', $arrPosition[1]);
        $strText = $this->getTextPackageByID($array_package, $idText);
        $strTd .= "$strText->text</td>";

        list($idText, $price, $strTime) = explode(':', $arrPosition[2]);
        $strText = $this->getTextPackageByID($array_package, $idText);
        $strTd .= "<td>$strText->text</td>";

        list($idText, $price, $strTime) = explode(':', $arrPosition[3]);
        $strText = $this->getTextPackageByID($array_package, $idText);
        $strTd .= "<td>$strText->text</td>";

        /*foreach ($arrPosition as $value) {
//            $arrExp1 = explode(',', $value);
            list($idText, $price, $strTime) = explode(':', $value);
            $strText = $this->getTextPackageByID($array_package, $idText);
            $strTd .= "<td>$strText->text";

            if (!empty($value) && $strText->price > 0) {
//                list($idTime) = explode(':', $arrExp1[1]);
                $strTime = $this->getTextPackageByID($array_package, $strTime);
//                $strTd .= "/$strTime->text</td>";
            } else {
                $strTd .= "</td>";
            }
//            $strTd .= $strTime ? "/$strTime</td>" : "</td>";
        }*/
        switch ($status) {
            case 'edit':
                $strTd .= "<td>$status</td>";
                $strTd .= "<td><a href='#' data-toggle=\"modal\"
        class='edit_package' data='$package_id' data-target=\"#modal_package\">Edit</a></td>";
                break;
            case 'payment':
                $strTd .= "<td>$status</td>";
                break;
            case 'approve':
                $strTd .= "<td><p class='font-color-4BB748'>$status</p></td>";
                break;
            case 'expire':
                $strTd .= "<td><p class='font-color-BF2026'>$status</p></td>";
                break;
        }
        return $strTd;
    }

    function convertStrSelectPackage($str_select)
    {
        $array_package = $this->getPackage();
        $arrPosition = explode('|', $str_select);
        $arraySavePosition = array();
        foreach ($arrPosition as $value) {
//            $arrExp1 = explode(',', $value);
            list($idText) = explode(':', $value);
            $getValPrice = $this->getPricePackageByID($array_package, $idText);
            $getValue = $this->getValuePackageByID($array_package, $idText);
            $strSelect = "$idText:$getValPrice:$getValue";
//            if (!empty($arrExp1[1])) {
//                list($idTime) = explode(':', $arrExp1[1]);
//                $getValTime = $this->getPricePackageByID($array_package, $idTime);
//                $strSelect = "$strSelect,$idTime:$getValTime";
//            }
            $arraySavePosition[] = $strSelect;
        }
        $newStrSelectPackage = implode('|', $arraySavePosition);
        return $newStrSelectPackage;
    }

    function addSelectPackage($post)
    {
        extract($post);
        if (empty($select_package))
            return false;
        if (empty($employer_id))
            return false;
        $newStrSelectPackage = $this->convertStrSelectPackage($select_package);
//        var_dump($newStrSelectPackage);exit;
        $result = $this->wpdb->insert(
            $this->tableSelectPackage,
            array(
                'employer_id' => $employer_id,
                'string_package' => $newStrSelectPackage,
                'status' => 'approve',
                'approve' => 1,
                'create_datetime' => date_i18n('Y-m-d H:i:s'),
                'update_datetime' => '0000-00-00 00:00:00',
                'publish' => 1,
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%d',
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
        if (empty($package_id))
            return false;
        if (empty($select_package))
            return false;
        /*$arrPosition = explode('|', $select_package);
        $arraySavePosition = array();
        foreach ($arrPosition as $value) {
            $exStr = explode(',', $value);
            $text = empty($exStr[0])? null: $exStr[0];
            $time = empty($exStr[1])? null: $exStr[1];

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
        $newStrSelectPackage = implode('|', $arraySavePosition);*/
        $newStrSelectPackage = $this->convertStrSelectPackage($select_package);
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

    function addPackage($post)
    {
        extract($post);
        $position = empty($position) ? false : $position;
        $text = empty($p_text) ? false : $p_text;
        $value = empty($p_value) ? false : $p_value;
        $price = empty($p_price) ? false : $p_price;
        $description = empty($description) ? false : $description;
        $require = empty($p_require) ? false : $p_require;
        $sql = "
          INSERT INTO `$this->tablePackage`
            (
             `position`,
             `text`,
             `value`,
             `price`,
             `description`,
             `require`,
             `create_datetime`,
             `publish`
             )
            VALUES (
            '{$position}',
            '{$text}',
            '{$value}',
            '{$price}',
            '{$description}',
            '{$require}',
            NOW(),
            1);
        ";

        $result = $this->wpdb->query($sql);
        if (!$result)
            return false;
        return $this->wpdb->insert_id;
    }

    function editPackage($post)
    {
        extract($post);
        $package_id = empty($package_id) ? false : $package_id;
        $position = empty($position) ? false : $position;
        $text = empty($p_text) ? false : $p_text;
        $value = empty($p_value) ? false : $p_value;
        $price = empty($p_price) ? false : $p_price;
        $description = empty($description) ? false : $description;
        $require = empty($p_require) ? false : $p_require;

        $sql = "
            UPDATE $this->tablePackage
            SET
              `position` = '{$position}',
             `text` = '{$text}',
             `value` = '{$value}',
             `price` = '{$price}',
             `description` = '{$description}',
             `require` = '{$require}',
             `update_datetime` = NOW()
            WHERE `id` = $package_id;
        ";
        $result = $this->wpdb->query($sql);
        return $result;
    }

    function deletePackage($id)
    {
        $sql = "
            UPDATE $this->tablePackage
            SET
             `publish` = 0,
             `update_datetime` = NOW()
            WHERE `id` = $id;
        ";
        $result = $this->wpdb->query($sql);
        return $result;
    }

    function buildTabPosition($position = 1)
    {
        $getPackage = $this->getPackage(0, $position);
        ob_start();
        ?>
        <div class="tb-insert">
            <table class="table table-hover table-border">
                <tr>
                    <td>#</td>
                    <td>Text</td>
                    <td>Value</td>
                    <td>Price</td>
                    <td>Require</td>
                    <td>Edit</td>
                </tr>
                <?php foreach ($getPackage as $key => $value):
                    $count = $key + 1;
                    $strForEdit = "{" .
                        "count:$count," .
                        "id:$value->id," .
                        "text:'$value->text'," .
                        "value:'$value->value'," .
                        "price:'$value->price'," .
                        "require:'$value->require'," .
                        "description:'$value->description'," .
                        "}";
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $value->text; ?></td>
                        <td><?php echo $value->value; ?></td>
                        <td><?php echo $value->price; ?></td>
                        <td><input type="checkbox" disabled <?php echo $value->require ? "checked" : ""; ?>></td>
                        <td><a href="#" onclick="setValuePackage(<?php echo $strForEdit; ?>);return false;">edit</a> |
                            <a href="#" onclick="deletePackage(<?php echo $value->id; ?>);return false;">delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function getApplyHotJob($id = 0, $post_id = 0, $package_id = 0)
    {
        $strAnd = $id ? " AND id = $id" : "";
        $strAnd .= $post_id ? " AND job_id = $post_id" : "";
        $strAnd .= $package_id ? " AND package_id = $package_id" : "";
        $sql = "
            SELECT
              *
            FROM `$this->tableApplyHotJob`
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $myRows = $this->wpdb->get_results($sql);
        return $myRows;
    }

    function addCountPost($select_package_id)
    {
        $sql = "
            UPDATE $this->tableSelectPackage
            SET
             `count_post` = `count_post`+1,
             `update_datetime` = NOW()
            WHERE `id` = $select_package_id;
        ";
        $result = $this->wpdb->query($sql);
        return $result;
    }

    function addCountHotJob($select_package_id)
    {
        $sql = "
            UPDATE $this->tableSelectPackage
            SET
             `count_hotjob` = `count_hotjob`+1,
             `update_datetime` = NOW()
            WHERE `id` = $select_package_id;
        ";
        $result = $this->wpdb->query($sql);
        return $result;
    }

    function returnCountHotJob($select_package_id)
    {
        $sql = "
            UPDATE $this->tableSelectPackage
            SET
             `count_hotjob` = `count_hotjob`-1,
             `update_datetime` = NOW()
            WHERE `id` = $select_package_id
            AND status='approve';
        ";
        $result = $this->wpdb->query($sql);
        return $result;
    }

    function returnCountPost($select_package_id)
    {
        $sql = "
            UPDATE $this->tableSelectPackage
            SET
             `count_post` = `count_post`-1,
             `update_datetime` = NOW()
            WHERE `id` = $select_package_id;
        ";
        $result = $this->wpdb->query($sql);
        return $result;
    }

    function addApplyPost($employer_id, $post_id)
    {
        $getTotalPost = $this->getTotalPost($employer_id);
        if ($getTotalPost > 0) {
            $getSelectPackage = $this->getSelectPackage($employer_id, 0, 1, "approve");
            if ($getSelectPackage) {
                $selectPackageID = $getSelectPackage[0]->id;
                $strSelectPackage = $getSelectPackage[0]->string_package;
                $dayValuePackage = $this->getTotalDay($strSelectPackage);
                $getDayAutoUpdate = $this->getDayAutoUpdate($strSelectPackage);
                $result = $this->addCountPost($selectPackageID);
                if ($result) {
                    update_post_meta($post_id, $this->strSelectPackagePostID, $selectPackageID);
                    update_post_meta($post_id, $this->strSelectHotJobID, $selectPackageID);
                    $this->setJobDayDisplay($post_id, $dayValuePackage);
                    $this->setDayAutoUpdate($post_id, $getDayAutoUpdate);
                    return true;
                }
            }
        }
        return false;
    }


    function addApplyHotJob($post_id)
    {
        $getSelectPackageHotJobID = get_post_meta($post_id, $this->strSelectHotJobID, true);
        return $this->addCountHotJob($getSelectPackageHotJobID);
//        $getTotalHotJob = $this->getTotalHotJob($employer_id);
//        $getApplyHotJob = $this->getApplyHotJob(0, $post_id);
//        if ($getApplyHotJob)
//            return true;
        /* if ($getTotalHotJob > 0) {
             $getSelectPackage = $this->getSelectPackage($employer_id, 0, 1, "approve");
             if ($getSelectPackage) {
                 $selectPackageID = $getSelectPackage[0]->id;
 //            }
 //            $sql = "
 //              INSERT INTO `$this->tableApplyHotJob`
 //                (
 //                 `user_id`,
 //                 `job_id`,
 //                 `package_id`,
 //                 `create_datetime`,
 //                 `publish`
 //                 )
 //                VALUES (
 //                '{$employer_id}',
 //                '{$post_id}',
 //                '{$selectPackageID}',
 //                NOW(),
 //                1);
 //            ";
 //            $result = $this->wpdb->query($sql);
 //            if ($result) {
                 update_post_meta($post_id, $this->strSelectHotJobID, $selectPackageID);
                 return $this->addCountHotJob($selectPackageID);
             }
         }
         return false;*/
    }

    function removeApplyHotJob($post_id)
    {
        $selectPackageID = get_post_meta($post_id, $this->strSelectHotJobID, true);
//        $getApplyHotJob = $this->getApplyHotJob(0, $post_id, $selectPackageID);
//        if (!$getApplyHotJob)
//            return true;
        /*$applyHotJobID = $getApplyHotJob[0]->id;
        $sql = "
            UPDATE $this->tableApplyHotJob
            SET
             `update_datetime` = NOW(),
             `publish` = 0
            WHERE `id` = $applyHotJobID;
        ";
        $result = $this->wpdb->query($sql);
        if ($result) {*/
        return $this->returnCountHotJob($selectPackageID);
        // }
//        return false;
    }

    function getDateCreateJob($job_id)
    {
        return get_post_meta($job_id, $this->strDateCreate, true);
    }

    function getDayDisplay($job_id)
    {
        return get_post_meta($job_id, $this->numDayDisplay, true);
    }

    function setJobDayDisplay($post_id, $day)
    {
//        $getOldDay = get_post_meta($this->numDayDisplay, $post_id, true);
//        $getOldDay = $getOldDay ? $getOldDay : 0;
        update_post_meta($post_id, $this->strDateCreate, date_i18n('Y-m-d H:i:s'));
        update_post_meta($post_id, $this->numDayDisplay, $day);
        $this->updateJob($post_id);
    }

    function getTotalDay($str_select_package)
    {
        $exp1 = explode('|', $str_select_package);
        $exp2 = explode(':', $exp1[1]);
        return $exp2[2];
    }

    function getMaxPost($str_select_package)
    {
        list($position1) = explode('|', $str_select_package);
        $exp1 = explode(':', $position1);
        return $exp1[2];
    }

    function getMaxHotJob($str_select_package)
    {
        $expPosition = explode('|', $str_select_package);
        $exp1 = explode(':', $expPosition[2]);
        return $exp1[2];
    }

    function checkAutoUpdate($str_select_package)
    {
        $expPosition = explode('|', $str_select_package);
        $exp1 = explode(':', $expPosition[3]);
        return $exp1[2] ? true : false;
    }

    function getDayAutoUpdate($str_select_package)
    {
        $expPosition = explode('|', $str_select_package);
        $exp1 = explode(':', $expPosition[3]);
        return $exp1[2];
    }

    function setDayAutoUpdate($post_id, $day = 0)
    {
        update_post_meta($post_id, $this->dayAutoUpdate, $day);
    }

    function checkHavePackage($employer_id)
    {
        $getPackage = $this->getSelectPackage($employer_id, 0, 1);
        if (!$getPackage)
            return false;
        foreach ($getPackage as $value) {
            if ($value->status == 'approve')
                return true;
        }
        return false;
    }

    function checkHaveHotJob($post_id)
    {
        $getSelectHotJobID = get_post_meta($post_id, $this->strSelectHotJobID, true);
        $getSelectPackage = $this->getSelectPackage(0, $getSelectHotJobID);
        $strSelectPackage = $getSelectPackage[0]->string_package;
        $getMaxHotJob = $this->getMaxHotJob($strSelectPackage);
        $curHotJob = $getSelectPackage[0]->count_hotjob;
        if ($curHotJob < $getMaxHotJob)
            return true;
        return false;
    }

    function getTotalPost($employer_id)
    {
        $getPackage = $this->getSelectPackage($employer_id, 0, 1);
        if (!$getPackage)
            return 0;
        $totalPost = 0;
        foreach ($getPackage as $value) {
            $countPost = $value->count_post;
            $strSelectPackage = $value->string_package;
            $maxPost = $this->getMaxPost($strSelectPackage);
            $totalPost += $maxPost - $countPost;
        }
        return $totalPost;
    }

    function getTotalHotJob($employer_id)
    {
        $getPackage = $this->getSelectPackage($employer_id, 0, 1);
        if (!$getPackage)
            return 0;
        $totalPost = 0;
        foreach ($getPackage as $value) {
            $count = $value->count_hotjob;
            $strSelectPackage = $value->string_package;
            $max = $this->getMaxHotJob($strSelectPackage);
            $totalPost += $max - $count;
        }
        return $totalPost;
    }

    function checkDisplayJob($date_create, $day_display)
    {
        $dateNow = date_i18n('Y-m-d H:i:s');
        $date1 = new DateTime($dateNow);
        $date2 = new DateTime($date_create);
        $diff = $date2->diff($date1);
        if ($diff->days >= $day_display)
            return false;
        return true;
    }

    function setPackageForJob($post_id)
    {
        $employer_id = get_post_meta($post_id, 'employer_id', true);
        $result = $this->addApplyPost($employer_id, $post_id);
        if ($result) {
            update_post_meta($post_id, "highlight_jobs", 0);
            return $this->returnMessage("Set package for job success.", false);
        }
        return $this->returnMessage("You are no package post job.", true);
    }

    function buildTotalPackage($user_id)
    {
        ob_start();
        ?>
        <div class="col-md-12 border-bottom-1-ddd no-padding"
             style="padding-bottom: 10px !important;">
            Your have package<br/>
            - Post Jobs :<?php echo $this->getTotalPost($user_id); ?><br/>
            - Set hot jobs :<?php echo $this->getTotalHotJob($user_id); ?>
        </div>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    //------------Auto Update---------------//
    function updateJob($post_id)
    {//echo $this->wpdb->posts;exit;
        $table = $this->wpdb->posts;
        $sql = "UPDATE `$table` SET
                                    `post_date` = NOW()
                                    WHERE `ID` = '$post_id'";
        return $this->wpdb->query($sql);
    }

    //------------End Auto Update---------------//

    function returnMessage($msg, $error, $json = true)
    {
        $arrayReturn = array();
        if (is_array($msg)) {
            $arrayReturn = $msg;
            $msg = $msg['msg'];
        }
        if ($error) {
            $arrayReturn['msg'] = $msg;
            $arrayReturn['error'] = $error;
        } else {
            $arrayReturn['msg'] = $msg;
            $arrayReturn['error'] = $error;
        }
        return $json ? json_encode($arrayReturn) : $arrayReturn;
    }
}