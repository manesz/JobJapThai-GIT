<?php

class OtherSetting
{
    private $wpdb;
    private $pathSaveFile = "";
    public $nameWorkingDay = "working_day";
    public $namePositionList = "position_list";
    public $nameJobLocation = "job_location";


    function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
        $this->pathSaveFile = get_template_directory() . '/libs/res/save_data.txt';
    }

    function getDataFromFile($strFileName)
    {
        $pathSaveFile = $this->pathSaveFile;
        if (file_exists($pathSaveFile)) {
            $getContent = file_get_contents($pathSaveFile);
            $arrContent = unserialize($getContent);
            return $arrContent;
        } else {
            $arrContent = array($strFileName => '');
            $default_content = serialize($arrContent);
            file_put_contents($pathSaveFile, $default_content);
            return $arrContent;
        }
    }

    function saveData($data1, $data2, $data3)
    {
        $pathSaveFile = $this->pathSaveFile;
        $arrContent[$this->nameWorkingDay] = $data1;
        $arrContent[$this->namePositionList] = $data2;
        $arrContent[$this->nameJobLocation] = $data3;
        $strContent = serialize($arrContent);
        $result = file_put_contents($pathSaveFile, $strContent);
        if ($result) {
            return json_encode(array('error' => false, 'message' => 'Save success'));
        }
        return json_encode(array('error' => true, 'message' => 'Save error'));
    }

    function dataToArray($name)
    {
        $arrContent = $this->getDataFromFile($name);
        $contentWorkingDay = $arrContent[$name];
        $contentWorkingDay = str_replace(',', ' ', $contentWorkingDay);
        $stringWorkingDay = trim(preg_replace('/\n+/', ',', $contentWorkingDay));
        $arrayWorkingDay = explode(',', $stringWorkingDay);
        return $arrayWorkingDay;
    }

    function buildWorkingDayToSelect($name, $select = "", $class = "form-control")
    {
        $arrayWorkingDay = $this->dataToArray($name);
        ob_start();
        ?>
        <select id="working_day" name="<?php echo $name; ?>" class="<?php echo $class; ?>" required="">
            <option value="">--Select--</option>
            <?php
            foreach ($arrayWorkingDay as $value) {
                ?>
                <option value="<?php echo $value; ?>"
                    <?php echo $select == $value? "selected": ""; ?>
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
}