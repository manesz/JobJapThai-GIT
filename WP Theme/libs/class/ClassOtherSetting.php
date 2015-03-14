<?php

class OtherSetting
{
    private $wpdb;
    private $pathSaveFile = "";
    public $nameWorkingDay = "working_day";


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

    function saveWorkingDay($data)
    {
        $pathSaveFile = $this->pathSaveFile;
        $arrContent = $this->getDataFromFile($this->nameWorkingDay);
        $arrContent[$this->nameWorkingDay] = $data;
        $strContent = serialize($arrContent);
        $result = file_put_contents($pathSaveFile, $strContent);
        if ($result) {
            return json_encode(array('error' => false, 'message' => 'Save success'));
        }
        return json_encode(array('error' => true, 'message' => 'Save error'));

    }

    function convertWorkingDayToArray()
    {
        $arrContent = $this->getDataFromFile($this->nameWorkingDay);
        $contentWorkingDay = $arrContent[$this->nameWorkingDay];
        $contentWorkingDay = str_replace(',', ' ', $contentWorkingDay);
        $stringWorkingDay = trim(preg_replace('/\n+/', ',', $contentWorkingDay));
        $arrayWorkingDay = explode(',', $stringWorkingDay);
        return $arrayWorkingDay;
    }

    function buildWorkingDayToSelect($select = "", $class = "form-control")
    {
        $arrayWorkingDay = $this->convertWorkingDayToArray();
        ob_start();
        ?>
        <select id="working_day" name="working_day" class="<?php echo $class; ?>" required="">
            <option value="">--Select--</option>
            <?
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