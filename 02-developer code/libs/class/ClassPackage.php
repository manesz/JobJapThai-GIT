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
              c.id AS select_package_id,
              c.create_datetime AS sp_create,
              c.update_datetime AS sp_update
            FROM
              $this->tableUser a
            INNER JOIN
              $this->tableCompanyInfo b
            ON (a.ID = b.employer_id)
            INNER JOIN
              $this->tableSelectPackage c
            ON (a.ID = c.employer_id AND c.publish = 1)
            WHERE 1
            $strAnd
            $order_by
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function buildTdSelectPackage1($position, $view = false)
    {
        $array_package = $this->getPackage();
        if (!$array_package)
            return '';
        $strTitle = $this->getTitlePackage($position);
        $strTd = '<td class="col-md-3">';
        $checkAddHead1 = false;
        $checkAddHead2 = false;
        foreach ($array_package as $key => $value) {
            if ($value->position == $position) {
                //if (!$checkAddHead1 && $value->type == 1) {
                //$checkAddHead1 = true;
                $strTd .= '
                    <label for="select_package' . $value->position . '" class=" margin-top-10">' . $strTitle;
                if (!$view) {
                    $strTd .= $value->require ? '<span class="font-color-red">*</span>' : '';
                }
                $strTd .= "</label>";
                break;
                /*} else if (!$checkAddHead2 && $value->type == 2) {
                    $checkAddHead2 = true;
                    $strTd .= '
                    <br/><label for="select_package' . $value->position . '" class=" margin-top-10">' . $value->title;
                    $strTd .= $value->require ? '<span
                        class="font-color-red">*</span></label>' : '';
                }*/
            }
        }
        $strTd .= '</td>';
        return $strTd;
    }

    public function buildTdSelectPackage2($position, $str_select_package, $view = false)
    {
        $array_package = $this->getPackage();
        if (!$array_package)
            return '';
        $strTd = '';
        $checkAddHead1 = false;
        $checkAddHead2 = false;
        $selectPosition = explode('|', $str_select_package);
        if (!$view) {
            foreach ($array_package as $key => $value) {
                if ($value->position == $position) {
                    $isSelect = '';
                    foreach ($selectPosition as $value2) {
                        list($selectIsMulti) = explode(',', $value2);
                        list($selectID) = explode(':', $selectIsMulti);
                        if ($selectID == $value->id)
                            $isSelect = 'selected';
                    }
                    //if ($value->type == 1) {
                    if (!$checkAddHead1) {
                        $checkAddHead1 = true;
                        $strTd .= '<select id="select_package' . $value->position . '" name="select_package' . $value->position . '"
                        class="form-control margin-top-10">';
                    }
                    $strTd .= '<option value="' . $value->id . '" ' . $isSelect . '>' . $value->text . '</option>';

                    /*} else if ($value->type == 2) {
                        if (!$checkAddHead2) {
                            $checkAddHead2 = true;
                            $strTd .= '</select><select id="select_package' . $value->position . '" name="select_package' . $value->position . '"
                            class="form-control margin-top-10">';
                        }
                        $strTd .= '<option value="' . $value->id . '" ' . $isSelect . '>' . $value->text . '</option>';
                    }*/
                }
            }
            $strTd = $strTd ? "$strTd</select>" : $strTd;
        } else {
            foreach ($array_package as $key => $value) {
                if ($value->position == $position) {
                    foreach ($selectPosition as $value2) {
                        list($selectIsMulti) = explode(',', $value2);
                        list($selectID) = explode(':', $selectIsMulti);
                        if ($selectID == $value->id)
                            $strTd .= '<span>' . $value->text . '</span>';
                    }

                }
            }
        }
        $strTd = '<td class="col-md-7">' . $strTd . '</td>';
        return $strTd;
    }

    public function buildTdSelectPackage3($position, $view = false, &$price = 0, $str_select_package = '')
    {
        $array_package = $this->getPackage();
        if (!$array_package)
            return '';
        $strTd = '<td class="col-md-4">';
        $checkAddHead1 = false;
        $selectPosition = explode('|', $str_select_package);
        foreach ($array_package as $key => $value) {
            if ($value->position == $position) {
                if (!$checkAddHead1 && !$view) {
                    $checkAddHead1 = true;
                    if (!$view) {
                        $valueBath = $value->require ? $value->price : 0;
                        $strTd .= '<span class="sum_position' . $position . '">' . $valueBath . '</span> บาท';
                    }
                } else {
                    $valueBath = 0;
                    $expData = empty($selectPosition[$position - 1]) ? null : explode(':', $selectPosition[$position - 1]);
                    $selectID = empty($expData[0]) ? null : $expData[0];
                    $price = empty($expData[1]) ? null : $expData[1];
                    //list($selectID, $price) = explode(':', $selectPosition[$position - 1]);
                    if ($selectID == $value->id) {
                        $valueBath = $value->price;
                        $strTd .= '<span class="sum_position' . $position . '">' . $valueBath . '</span> บาท';
                    }
                    $price = $valueBath;
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
        $sumPrice = 0;
        $strTd = "";
        $arrPosition = explode('|', $str_select_package);

        list($idText, $price, $strTime) = explode(':', $arrPosition[0]);
        $strText = $this->getTextPackageByID($array_package, $idText);
        $strTd .= "<td>$strText->text / ";
        $sumPrice += $price;

        list($idText, $price, $strTime) = explode(':', $arrPosition[1]);
        $strText = $this->getTextPackageByID($array_package, $idText);
        $strTd .= "$strText->text</td>";
        $sumPrice += $price;

        list($idText, $price, $strTime) = explode(':', $arrPosition[2]);
        $strText = $this->getTextPackageByID($array_package, $idText);
        $strTd .= "<td>$strText->text</td>";
        $sumPrice += $price;

        list($idText, $price, $strTime) = explode(':', $arrPosition[3]);
        $strText = $this->getTextPackageByID($array_package, $idText);
        $strTd .= "<td>$strText->text</td>";
        $sumPrice += $price;

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
        $sumPrice += $sumPrice * 0.07;
        $sumPrice = number_format($sumPrice, 2);
        switch ($status) {
            case 'edit':
                $strTd .= "<td><a href='#' package-id='$package_id'" .
                    "price='$sumPrice' class='btn_confirm_package btn btn-success pull-left'>" .
                    "<span class='glyphicon glyphicon-shopping-cart'></span> Buy Package</a></td>";
                $strTd .= "<td align='center'><a href='#' data-toggle=\"modal\"
        class='edit_package btn btn-primary' data='$package_id' data-target=\"#modal_package\">Edit</a></td>";
                break;
            case 'payment':
                $strTd .= "<td><p class='font-color-FF04FF'>Payment</p></td>";
                $strTd .= "<td align='center'><a class='btn btn-danger' " .
                    "href='javascript:cancelPackage($package_id);' >Cancel</a></td>";
                break;
            case 'approve':
                $strTd .= "<td><p class='font-color-4BB748'>Approve</p></td><td align='center'>----</td>";
                break;
            case 'cancel':
                $strTd .= "<td><p class='font-color-999'>Cancel</p></td><td align='center'>----</td>";
                break;
            case 'expire':
                $strTd .= "<td><p class='font-color-999'>Expire</p></td><td align='center'>----</td>";
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

    function buildLogPackage($data)
    {
        global $current_user;
        get_currentuserinfo();
        $userID = $current_user->ID;
        $userLogin = $current_user->user_login;
        $data['editBy'] = "$userID|$userLogin";
        $data['editTime'] = date_i18n('Y-m-d H:i:s');
        return serialize($data);
    }

    function addSelectPackage($post)
    {
        extract($post);
        if (empty($select_package))
            return false;
        if (empty($employer_id))
            return false;
        $newStrSelectPackage = $this->convertStrSelectPackage($select_package);
        $data = array(
            'employer_id' => $employer_id,
            'string_package' => $newStrSelectPackage,
            'status' => 'edit',
            'approve' => 1,
            'create_datetime' => date_i18n('Y-m-d H:i:s'),
            'update_datetime' => '0000-00-00 00:00:00',
            'publish' => 1,
        );
        $strLog = $this->buildLogPackage($data);
        $data['log'] = $strLog;
        $result = $this->wpdb->insert(
            $this->tableSelectPackage,
            $data,
            array(
                '%d',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%d',
                '%s',
            )
        );
        if ($result) {
            return $this->wpdb->insert_id;
        }
        return false;
    }

    function setStatusPackage($post)
    {
        $package_id = $post['package_id'];
        $status = $post['status_package'];
        $approve = $status != 'approve' ? 0 : 1;
        $data = array(
            'approve' => $approve,
            'status' => $status,
            'update_datetime' => date_i18n('Y-m-d H:i:s'),
        );
        $strLog = $this->buildLogPackage($data);
        $sql = "
            UPDATE $this->tableSelectPackage
            SET
              `approve` = '{$approve}',
             `status` = '{$status}',
             `log` = CONCAT(IFNULL(`log`, ''), '$strLog'),
             `update_datetime` = NOW()
            WHERE `id` = $package_id;
        ";
        $result = $this->wpdb->query($sql);
        return $result;
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
        $data = array(
            'string_package' => $newStrSelectPackage,
            'update_datetime' => date_i18n('Y-m-d H:i:s')
        );
        $strLog = $this->buildLogPackage($data);
        $sql = "
            UPDATE $this->tableSelectPackage
            SET
              `string_package` = '{$newStrSelectPackage}',
             `log` = CONCAT(IFNULL(`log`, ''), '$strLog'),
             `update_datetime` = NOW()
            WHERE `id` = $package_id;
        ";
        $result = $this->wpdb->query($sql);
        return $result;
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

    function buildJavaFormNewPackage($packageID, $userID, $isBackend = false)
    {
        $arrayPackage = $this->getPackage();
        $arraySelectPackage = $packageID ? $this->getSelectPackage($userID, $packageID) : null;
//        $strSelectPackage = $packageID ? $arraySelectPackage[0]->string_package : '';
        $isApprove = "";
        if ($arraySelectPackage)
            $isApprove = $packageID ? $arraySelectPackage[0]->status : '';

        ob_start();
        ?>
        <script>
            var package_id = <?php echo $packageID; ?>;

            <?php echo $this->buildJsArrayPrice($arrayPackage); ?>
            var jsHookCalPackage = {
                <?php echo $this->buildJsParameter($arrayPackage); ?>

                jopPackSum: 0,
                jopTax: 0,
                jopPackAllSum: 0,
                init: function () {
                    jsHookCalPackage.updateVal();
                    jsHookCalPackage.addEvent();
//            proselect.init();
                },
                addEvent: function () {
                    <?php echo $this->buildJsEvent($arrayPackage); ?>
                },
                updateVal: function () {
                    jsHookCalPackage.jopPackSum = <?php echo $this->buildJsCalValue($arrayPackage); ?>;
                    jsHookCalPackage.jopTax = jsHookCalPackage.jopPackSum * 0.07;
                    jsHookCalPackage.jopPackAllSum = jsHookCalPackage.jopPackSum + jsHookCalPackage.jopTax;

                    <?php echo $this->buildJsSumValue($arrayPackage); ?>

                    $('.jj-allsum').text(jsHookCalPackage.formatDollar(jsHookCalPackage.jopPackSum));
                    $('.jj-taxsum').text(jsHookCalPackage.formatDollar(jsHookCalPackage.jopTax));
                    $('.jj-alltaxsum').text(jsHookCalPackage.formatDollar(jsHookCalPackage.jopPackAllSum));

                    jsHookCalPackage.addStringPackage();
                },
                addStringPackage: function () {
                    var strSelectPackage = <?php echo $this->buildJsStrSelectPackage($arrayPackage); ?>;
                    $("#select_package").val(strSelectPackage);
                },
                formatDollar: function (num) {
                    var p = num.toFixed(2).split(".");
                    return p[0].split("").reverse().reduce(function (acc, num, i, orig) {
                            return num + (i && !(i % 3) ? "," : "") + acc;
                        }, "") + "." + p[1];
                }
            };

            var check_post_package = false;
            $(document).ready(function () {
                jsHookCalPackage.init();

                <?php if($isApprove == 'approve'): ?>
                $('#frm_package>select').prop('disabled', 'disabled');
                <?php endif; ?>

                $("#frm_package").submit(function () {
                    if (!check_post_package) {
                        showImgLoading();
                        $.ajax({
                            type: "POST",
                            url: '',
                            data: $(this).serialize(),
                            success: function (result) {
                                if (result != 'success') {
                                    alert(result);
                                } else {
                                    <?php if (!$isBackend): ?>
                                    showListPackage();
                                    $('#modal_package').modal('hide');
                                    $(".modal-backdrop").remove();
                                    <?php else :?>
                                    alert("Save Success.");
                                    <?php endif;?>
                                }
                                hideImgLoading();
                                check_post_package = false;
                            },
                            error: function (result) {
                                alert("Error:\n" + result.responseText);
                                hideImgLoading();
                                check_post_package = false;
                            }
                        });
                    }
                    check_post_package = true;
                    return false;
                });
            });
        </script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function getTitlePackage($position)
    {

        $strTitle = "";
        switch ($position) {
            case 1:
                $strTitle = "จำนวนตำแหน่ง";
                break;
            case 2:
                $strTitle = 'ระยะเวลา';
                break;
            case 3:
                $strTitle = 'จำนวนตำแหน่ง';
                break;
            case 4:
                $strTitle = 'ระยะเวลา';
                break;
        }
        return $strTitle;
    }

    function getHeaderPackage($position)
    {
        $strHeader = "";
        switch ($position) {
            case 1:
                $strHeader = "เลือกจำนวนตำแหน่ง";
                break;
            case 2:
                $strHeader = 'เลือกระยะเวลา';
                break;
            case 3:
                $strHeader = 'เลือกจำนวน <span
                    class="font-color-BF2026">Hotjob</span>';
                break;
            case 4:
                $strHeader = 'เลือกระยะเวลาของ <span
                    class="font-color-BF2026">Auto Update</span>';
                break;
        }
        return $strHeader;
    }

    function buildHtmlFormNewPackage($packageID, $userID, $view = false)
    {
        $arrayPackage = $this->getPackage();
        $arraySelectPackage = $packageID ? $this->getSelectPackage($userID, $packageID) : null;
        $strSelectPackage = "";
        if ($arraySelectPackage)
            $strSelectPackage = $packageID ? $arraySelectPackage[0]->string_package : '';
        ob_start();
        ?>
        <?php if (!$view): ?>
        <form method="post" id="frm_package">
    <?php endif; ?>
        <h4 class="bg-BF2026 font-color-fff padding-10" id="myModalLabel">Business Package</h4>
        <div class="clearfix" id="frm_package">
            <?php if (!$view): ?>
                <input type="hidden" id="employer_id" name="employer_id" value="<?php echo $userID; ?>">
                <input type="hidden" id="package_id" name="package_id" value="<?php echo $packageID; ?>">
                <input type="hidden" id="select_package" name="select_package" value="">
                <input type="hidden" id="post_package" name="post_package" value="true">
                <input type="hidden" id="type_post" name="type_post"
                       value="<?php echo $packageID ? 'edit' : 'add'; ?>"/>
            <?php endif; ?>

            <table style="width: 100%;">
                <?php
                $savePosition = 0;
                foreach ($arrayPackage as $key => $value):
                    ?>
                    <?php if ($savePosition != $value->position && $key != 0): ?>
                    <tr>
                        <td colspan="3">
                            <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                        </td>
                    </tr>
                <?php endif; ?>
                    <?php if ($savePosition != $value->position):
                    $strHeader = $this->getHeaderPackage($value->position);
                    $countName = $value->position;
                    ?>
                    <tr>
                        <td colspan="3"><h5><?php echo "$countName. $strHeader"; ?></h5></td>
                    </tr>
                    <tr class="padding-bottom-10" style="">
                        <?php echo $this->buildTdSelectPackage1($value->position, $view); ?>
                        <?php echo $this->buildTdSelectPackage2($value->position, $strSelectPackage, $view); ?>
                        <?php echo $this->buildTdSelectPackage3($value->position); ?>
                    </tr>
                <?php endif; ?>

                    <?php
                    $savePosition = $value->position;
                endforeach; ?>

                <tr>
                    <td colspan="3">
                        <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-10 text-right" colspan="2">Sub Total</td>
                    <td class="col-md-2"><span class="jj-allsum"></span> บาท</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-10 text-right" colspan="2">+ Vat (7%)</td>
                    <td class="col-md-2"><span class="jj-taxsum"></span> บาท</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-10 text-right" colspan="2"><strong>ยอดสุทธิ</strong></td>
                    <td class="col-md-2"><span class="jj-alltaxsum"></span> บาท</td>
                </tr>
                <tr>
                    <td class="col-md-3"></td>
                    <td class="col-md-7"></td>
                    <td class="col-md-2"></td>
                </tr>
            </table>
        </div>
        <?php if (!$view): ?>
        </form>
    <?php endif; ?>

        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function buildHtmlEmailBuyPackage($package_id, $employer_id)
    {
        $arrayPackage = $this->getPackage();
        $classEmployer = new Employer($this->wpdb);
        $classOtherSetting = new OtherSetting($this->wpdb);
        $arraySelectPackage = $package_id ? $this->getSelectPackage($employer_id, $package_id) : null;
        $strSelectPackage = $package_id ? $arraySelectPackage[0]->string_package : '';

        $employerData = $classEmployer->getCompanyInfo(0, $employer_id);
        extract((array)$employerData[0]);
        ob_start();

        ?>

        <p>Business Package</p>
        <table style="width: 100%;">
            <?php
            $savePosition = 0;
            $sumPrice = 0;
            foreach ($arrayPackage as $key => $value):
                ?>
                <?php if ($savePosition != $value->position && $key != 0): ?>
                <tr>
                    <td colspan="3">
                        <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                    </td>
                </tr>
            <?php endif; ?>
                <?php if ($savePosition != $value->position):
                $strHeader = $this->getHeaderPackage($value->position);
                $countName = $value->position;
                $price = 0;
                ?>
                <tr>
                    <td colspan="3"><h3><?php echo "$countName. $strHeader"; ?></h3></td>
                </tr>
                <tr class="padding-bottom-10" style="">
                    <?php echo $this->buildTdSelectPackage1($value->position, true); ?>
                    <?php echo $this->buildTdSelectPackage2($value->position, $strSelectPackage, true); ?>
                    <?php echo $this->buildTdSelectPackage3($value->position, true, $price, $strSelectPackage);
                    $sumPrice += $price;
                    ?>
                </tr>
            <?php endif; ?>

                <?php
                $savePosition = $value->position;
            endforeach; ?>

            <tr>
                <td colspan="3">
                    <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                </td>
            </tr>
            <tr>
                <td class="col-md-10 text-right" colspan="2">Sub Total</td>
                <td class="col-md-2"><span class="jj-allsum"><?php echo number_format($sumPrice, 2); ?></span> บาท</td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                </td>
            </tr>
            <tr>
                <td class="col-md-10 text-right" colspan="2">+ Vat (7%)</td>
                <td class="col-md-2"><span class="jj-taxsum"><?php echo number_format($sumPrice * 0.07, 2); ?></span>
                    บาท
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                </td>
            </tr>
            <tr>
                <td class="col-md-10 text-right" colspan="2"><strong>ยอดสุทธิ</strong></td>
                <td class="col-md-2"><span
                        class="jj-alltaxsum"><?php echo number_format($sumPrice + ($sumPrice * 0.07), 2); ?></span> บาท
                </td>
            </tr>
            <tr>
                <td class="col-md-3"></td>
                <td class="col-md-7"></td>
                <td class="col-md-2"></td>
            </tr>
        </table>
        <hr/>
        <h3>Seeking For Manpower Profile</h3>
        <table>
            <tr>
                <td>Contact person</td>
                <td><?php echo empty($contact_person) ? "-" : $contact_person; ?></td>
            </tr>
            <tr>
                <td>Company name</td>
                <td><?php echo empty($company_name) ? "-" : $company_name; ?></td>
            </tr>
            <tr>
                <td>Business Type</td>
                <td><?php echo empty($business_type) ? "-" : $business_type; ?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><?php echo empty($address) ? "-" : $address; ?></td>
            </tr>
            <tr>
                <td>Province</td>
                <td><?php echo empty($province) ? "-" : $classOtherSetting->getProvincesName($province); ?></td>
            </tr>
            <tr>
                <td>District</td>
                <td><?php echo empty($district) ? "-" : $classOtherSetting->getDistrictName($district); ?></td>
            </tr>
            <tr>
                <td>Sub district</td>
                <td><?php echo empty($sub_district) ? "-" : $classOtherSetting->getCityName($sub_district); ?></td>
            </tr>
            <tr>
                <td>Postcode</td>
                <td><?php echo empty($postcode) ? "-" : $postcode; ?></td>
            </tr>
            <tr>
                <td>Tel</td>
                <td><?php echo empty($tel) ? "-" : $tel; ?></td>
            </tr>
            <tr>
                <td>Fax</td>
                <td><?php echo empty($fax) ? "-" : $fax; ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo empty($email) ? "-" : "<a href='mailto:$email'>$email</a>"; ?></td>
            </tr>
            <tr>
                <td>Website</td>
                <td><?php echo empty($website) ? "-" : $website; ?></td>
            </tr>
            <tr>
                <td>Directions</td>
                <td><?php if (empty($directions)): ?>
                        -
                    <?php else: ?>
                        <a href="http://maps.google.com/maps?q=<?php echo $directions; ?>">Link Map</a>

                    <?php endif; ?>
                </td>
            </tr>
        </table>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function getPaymentFilePath($package_id)
    {
        $sql = "
            SELECT * FROM $this->tableSelectPackage
            WHERE `id` = '$package_id';
        ";
        $result = $this->wpdb->get_results($sql);
        if ($result) {
            return $result[0]->payment_file;
        } else {
            return '';
        }
    }

    function setPaymentFilePath($package_id, $path)
    {
        $sql = "
            UPDATE $this->tableSelectPackage
            SET
              `payment_file` = '$path',
              `update_datetime` = NOW()
            WHERE `id` = '$package_id';
        ";
        return $this->wpdb->query($sql);
    }

    function setPublishSelectPackage($id)
    {
        $data = array(
            'publish' => 0,
            'update_datetime' => date_i18n('Y-m-d H:i:s')
        );
        $strLog = $this->buildLogPackage($data);
        $sql = "
            UPDATE $this->tableSelectPackage
            SET
             `publish` = 0,
             `log` = CONCAT(IFNULL(`log`, ''), '$strLog'),
             `update_datetime` = NOW()
            WHERE `id` = $id;
        ";
        $result = $this->wpdb->query($sql);
        return $result;
    }

    function convertFileName($file, $candidate_id)
    {
        $pathInfo = pathinfo($file['name']);
        $fileType = $pathInfo['extension'];
        $fileName = date_i18n("Y-m-d_Hms_") . $candidate_id;
        $file['name'] = "payment_$fileName.$fileType";
        return $file;
    }

    function addAttachFilePayment($file, $employer_id)
    {
        $file = $this->convertFileName($file, $employer_id);
        $handle = new Upload($file);
        $upload_dir = wp_upload_dir();
        $dir_dest = $upload_dir['basedir'] . "/payment_package/$employer_id/";

        $dir_file = $upload_dir['baseurl'] . "/payment_package/$employer_id/";
        $arrayReturn = array();
//        $filePath = 'wp-content/uploads/avatar' . $upload_dir['subdir'];;
        if ($handle->uploaded) {
//            $handle->image_resize = true;
//            $handle->image_ratio_y = true;
//            $handle->image_x = $image_x;

            // yes, the file is on the server
            // now, we start the upload 'process'. That is, to copy the uploaded file
            // from its temporary location to the wanted location
            // It could be something like $handle->Process('/home/www/my_uploads/');
            $handle->Process($dir_dest);

            // we check if everything went OK
            if ($handle->processed) {
                $dir_file .= $handle->file_dst_name;
//                $filePath .= '/' . $handle->file_dst_name;
                $arrayReturn['error'] = false;
                // everything was fine !
                $msgReturn = '<p class="result">';
                $msgReturn .= '  <b>File uploaded with success</b><br />';
                $msgReturn .= '  File: <a target="_blank" href="' . $dir_file . '">' .
                    $handle->file_dst_name . '</a>';
                $msgReturn .= '   (' . round(filesize($handle->file_dst_pathname) / 256) / 4 . 'KB)';
                $msgReturn .= '</p>';
            } else {
                $arrayReturn['error'] = true;
                // one error occured
                $msgReturn = '<p class="result">';
                $msgReturn .= '  <b>File not uploaded to the wanted location</b><br />';
                $msgReturn .= '  Error: ' . $handle->error . '';
                $msgReturn .= '</p>';
            }

            // we delete the temporary files
            $handle->Clean();

        } else {
            $arrayReturn['error'] = true;
            // if we're here, the upload file failed for some reasons
            // i.e. the server didn't receive the file
            $msgReturn = '<p class="result">';
            $msgReturn .= '  <b>File not uploaded on the server</b><br />';
            $msgReturn .= '  Error: ' . $handle->error . '';
            $msgReturn .= '</p>';
        }
        $arrayReturn['msg'] = $msgReturn;
        $arrayReturn['path'] = $dir_file;
        return $arrayReturn;
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