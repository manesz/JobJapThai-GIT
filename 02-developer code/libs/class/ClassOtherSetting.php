<?php

class OtherSetting
{
    private $wpdb;
    private $pathSaveFile = "";
    public $nameWorkingDay = "working_day";
    public $namePositionList = "job_position";
    public $nameJobLocation = "job_location";
    public $nameJobType = "job_type";
    public $nameTitle = "title";


    function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
        $this->pathSaveFile = get_template_directory() . '/libs/res/save_data.txt';
    }

    function getDataFromFile($strFileName = null)
    {
        $pathSaveFile = $this->pathSaveFile;
        if (file_exists($pathSaveFile)) {
            $getContent = file_get_contents($pathSaveFile);
            $arrContent = unserialize($getContent);
            return $arrContent;
        } else {
            $arrContent = $strFileName ? array($strFileName => '') : array();
            $default_content = serialize($arrContent);
            file_put_contents($pathSaveFile, $default_content);
            return $arrContent;
        }
    }

    function saveData($name, $data)
    {
        $pathSaveFile = $this->pathSaveFile;
        $allData = $this->getDataFromFile();
        $allData[$name] = $data;
        $strContent = serialize($allData);
        $result = file_put_contents($pathSaveFile, $strContent);
        if ($result) {
            return true;
        }
        return false;
    }

    function dataToArray($name)
    {
        $arrContent = $this->getDataFromFile($name);
        $contentWorkingDay = $arrContent[$name];
        $contentWorkingDay = str_replace(',', ' ', $contentWorkingDay);
        $stringWorkingDay = trim(preg_replace('/\n+/', ',', $contentWorkingDay));
        $arrayWorkingDay = explode(',', $stringWorkingDay);
        $arrayWorkingDay = array_map('trim',$arrayWorkingDay);
        return $arrayWorkingDay;
    }

    function buildDataToSelect($name, $select = "", $class = "col-md-12 form-control", $require = true)
    {
        $require = $require? "required": "";
        $arrData = $this->dataToArray($name);
        ob_start();
        ?>
        <select id="<?php echo $name; ?>" name="<?php echo $name; ?>" class="<?php echo $class; ?>"
            <?php echo $require; ?>>
            <option value="">--Select--</option>
            <?php
            foreach ($arrData as $value) {
                ?>
                <option value="<?php echo $value; ?>"
                    <?php echo $select == $value ? "selected" : ""; ?>
                    ><?php echo $value; ?></option>
            <?php
            }
            ?>
        </select>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    public function getProvinces($id = false)
    {
        $strAnd = $id ? " AND PROVINCE_ID = '$id'" : "";
        $sql = "
          SELECT * FROM `province` WHERE 1
          $strAnd
          ORDER BY PROVINCE_NAME ASC
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function getDistrict($id = false)
    {
        $strAnd = $id ? " AND AMPHUR_ID = '$id'" : "";
        $sql = "
          SELECT * FROM `amphur`
          WHERE 1
          $strAnd
          ORDER BY AMPHUR_NAME ASC
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    public function getCity($id = false)
    {
        $strAnd = $id ? " AND DISTRICT_ID = '$id'" : "";
        $sql = "
          SELECT * FROM `district`
          WHERE 1
          $strAnd
          ORDER BY DISTRICT_NAME ASC
        ";
        $result = $this->wpdb->get_results($sql);
        return $result;
    }

    function getProvincesName($id){//จังหวัด
        $result = $this->getProvinces($id);
        return $result[0]->PROVINCE_NAME;
    }

    function getDistrictName($id){//อำเภอ
        $result = $this->getDistrict($id);
        return $result[0]->AMPHUR_NAME;
    }

    function getCityName($id){//ตำบล
        $result = $this->getCity($id);
        return $result[0]->DISTRICT_NAME;
    }
}