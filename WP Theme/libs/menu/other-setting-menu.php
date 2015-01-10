<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 7/11/2557
 * Time: 14:14 น.
 */

$objClassOtherSetting = new OtherSetting($wpdb);
function add_contact_menu_items()
{
    add_submenu_page(
        'ics_theme_settings',
        'Other Setting',
        'Other Setting',
        'manage_options',
        'contact',
        'render_contact_page'
    );
}


add_action('admin_menu', 'add_contact_menu_items');

function render_contact_page()
{
    global $objClassOtherSetting;
    global $webSiteName;
    $arrayOtherSetting = $objClassOtherSetting->getOtherSetting();
    $massage = "";
    $tel = "";
    $address = "";
    $fax = "";
    $email = "";
    $title_facebook = "";
    $link_facebook = "";
    $title_twitter = "";
    $link_twitter = "";
    $title_line = "";
    $link_line = "";
    $qr_code_line = "";
    $title_ggp = "";
    $link_ggp = "";
    $latitude = "";
    $longitude = "";
    if ($arrayOtherSetting) {
        extract((array)$arrayOtherSetting[0]);
    }
    ?>
    <script type="text/javascript"
            src="<?php bloginfo('template_directory'); ?>/libs/js/contact.js"></script>

        <div class="wrap">
            <div id="icon-themes" class="icon32"><br/></div>

            <h2><?php _e(@$webSiteName . ' theme controller', 'wp_toc'); ?></h2>

            <p><?php echo @$webSiteName; ?> business website theme &copy; developer by <a href="http://www.ideacorners.com"
                                                                                          target="_blank">IdeaCorners
                    Developer</a></p>
            <!-- If we have any error by submiting the form, they will appear here -->

            <h2>Other Setting</h2>
            <hr/>
            <form id="other_setting_post" method="post">
                <input type="hidden" name="other_setting_post" value="true"/>

                <div class="tb-insert">
                    <table class="wp-list-table widefat" cellspacing="0" width="100%">
                        <tbody id="the-list-edit">
                        <tr class="alternate">
                            <td><label for="pro_title">Title Promotion :</label></td>
                            <td colspan="3">
                                <textarea cols="80" rows="3"
                                          id="pro_title" name="title"><?php
                                    $arrTitle = $objClassOtherSetting->getTitlePromotion();
                                    echo $arrTitle['promotion_title'];
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