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
    $objClassOtherSetting = new OtherSetting($wpdb);
    $arrayOtherSetting = $objClassOtherSetting->getDataFromFile($objClassOtherSetting->nameWorkingDay);
    require_once ('header.php');
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
                            <td><label for="working_day">Working Day:</label></td>
                            <td colspan="3">
                                <textarea cols="80" rows="10"
                                          id="working_day" name="working_day"><?php
    echo $arrayOtherSetting[$objClassOtherSetting->nameWorkingDay];
    ?></textarea>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <input type="submit" class="button-primary" value="Save">
                </div>
            </form>
        </div>
<?php
}

add_action('admin_menu', 'add_other_setting_menu_items');