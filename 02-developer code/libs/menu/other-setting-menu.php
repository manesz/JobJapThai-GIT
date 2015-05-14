<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 7/11/2557
 * Time: 14:14 น.
 */
function add_other_setting_menu_items()
{
    add_submenu_page(
        'ics_theme_settings',
        'Other Setting',
        'Other Setting',
        'manage_options',
        'other_setting',
        'render_other_setting_page'
    );
}

function render_other_setting_page()
{
    global $wpdb;
    $classOthSetting = new OtherSetting($wpdb);
    $arrOthSetting = $classOthSetting->getDataFromFile($classOthSetting->nameWorkingDay);
    require_once('header.php');
    ?>
    <script type="text/javascript"
            src="<?php bloginfo('template_directory'); ?>/libs/js/other-settings.js"></script>
    <h2>Other Setting</h2>
    <hr/>
    <form id="other_setting_post" method="post">
        <input type="hidden" name="other_setting_post" value="true"/>

        <div class="tb-insert">
            <table class="wp-list-table widefat" cellspacing="0" width="100%">
                <tbody id="the-list-edit">
                <tr class="alternate">
                    <td><label for="<?php echo $classOthSetting->nameTitle; ?>">Title:</label></td>
                    <td>
                                <textarea cols="80" rows="10"
                                          id="<?php echo $classOthSetting->nameTitle; ?>" name="<?php echo $classOthSetting->nameTitle; ?>"><?php
                                    echo empty($arrOthSetting[$classOthSetting->nameTitle]) ? "" :
                                        $arrOthSetting[$classOthSetting->nameTitle];

                                    ?></textarea>
                    </td>
                </tr><tr class="alternate">
                    <td><label for="<?php echo $classOthSetting->nameWorkingDay; ?>">Working Day:</label></td>
                    <td>
                                <textarea cols="80" rows="10"
                                          id="working_day" name="<?php echo $classOthSetting->nameWorkingDay; ?>"><?php
                                    echo empty($arrOthSetting[$classOthSetting->nameWorkingDay]) ? "" :
                                        $arrOthSetting[$classOthSetting->nameWorkingDay];

                                    ?></textarea>
                    </td>
                </tr>
                <tr class="alternate">
                    <td><label for="<?php echo $classOthSetting->namePositionList; ?>">Position List:</label></td>
                    <td>
                                <textarea cols="80" rows="10"
                                          id="<?php echo $classOthSetting->namePositionList; ?>" name="<?php echo $classOthSetting->namePositionList; ?>"><?php
                                    echo empty($arrOthSetting[$classOthSetting->namePositionList]) ? "" :
                                        $arrOthSetting[$classOthSetting->namePositionList];
                                    ?></textarea>
                    </td>
                </tr>
                <tr class="alternate">
                    <td><label for="<?php echo $classOthSetting->nameJobLocation; ?>">Job Location:</label></td>
                    <td>
                                <textarea cols="80" rows="10"
                                          id="<?php echo $classOthSetting->nameJobLocation; ?>" name="<?php echo $classOthSetting->nameJobLocation; ?>"><?php
                                    echo empty($arrOthSetting[$classOthSetting->nameJobLocation]) ? "" :
                                        $arrOthSetting[$classOthSetting->nameJobLocation];
                                    ?></textarea>
                    </td>
                </tr>
                <tr class="alternate">
                    <td colspan="2" align="center">
                        <input type="submit" class="button-primary" value="Save">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </form>
<?php
}

add_action('admin_menu', 'add_other_setting_menu_items');