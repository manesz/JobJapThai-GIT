<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 7/11/2557
 * Time: 14:14 น.
 */

$objClassContact = new Contact($wpdb);
function add_contact_menu_items()
{
    add_submenu_page(
        'ics_theme_settings',
        'Contact',
        'Contact',
        'manage_options',
        'contact',
        'render_contact_page'
    );
}


add_action('admin_menu', 'add_contact_menu_items');

function render_contact_page()
{
    global $objClassContact;
    global $webSiteName;
    $arrayContact = $objClassContact->getContact();
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
    if ($arrayContact) {
        extract((array)$arrayContact[0]);
    }
    ?>
    <script type="text/javascript"
            src="<?php bloginfo('template_directory'); ?>/library/js/contact.js"></script>
    <form id="contact-post" method="post">
        <input type="hidden" name="contact_post" id="contact_post" value="true"/>

        <div class="wrap">
            <div id="icon-themes" class="icon32"><br/></div>

            <h2><?php _e(@$webSiteName . ' theme controller', 'wp_toc'); ?></h2>

            <p><?php echo @$webSiteName; ?> business website theme &copy; developer by <a href="http://www.ideacorners.com"
                                                                                          target="_blank">IdeaCorners
                    Developer</a></p>
            <!-- If we have any error by submiting the form, they will appear here -->
            <?php settings_errors('tab1-errors'); ?>
            <h2>Contact</h2>

            <div class="tb-insert">
                <table class="wp-list-table widefat" cellspacing="0" width="100%">
                    <tbody id="the-list-edit">
                    <tr class="alternate">
                        <td><label for="massage">Massage :</label></td>
                        <td colspan="3">
                        <textarea cols="80" rows="3"
                                id="massage" name="massage"><?php echo $massage; ?></textarea>
                        </td>
                    </tr>
                    <tr class="alternate">
                        <td><label for="tel">Tel :</label></td>
                        <td><input type="text" id="tel" name="tel"
                                   value="<?php echo $tel; ?>"/></td>
                        <td><label for="email">Email :</label></td>
                        <td><input type="text" id="email" name="email"
                                   value="<?php echo $email; ?>"/></td>
                    </tr>
                    <tr class="alternate">
                        <td><label for="fax">Fax :</label></td>
                        <td><input type="text" id="fax" name="fax"
                                   value="<?php echo $fax; ?>"/></td>
                        <td><label for="address">Address :</label></td>
                        <td><textarea id="address" name="address"><?php echo $address; ?></textarea></td>
                    </tr>
                    <tr class="alternate">
                        <td><label for="title_facebook">Title Facebook :</label></td>
                        <td><input type="text" id="title_facebook" name="title_facebook"
                                   value="<?php echo $title_facebook; ?>"/></td>
                        <td><label for="title_twitter">Title Twitter :</label></td>
                        <td><input type="text" id="title_twitter" name="title_twitter"
                                   value="<?php echo $title_twitter; ?>"/></td>
                    </tr>
                    <tr class="alternate">
                        <td><label for="link_facebook">Link Facebook :</label></td>
                        <td><input type="text" id="link_facebook" name="link_facebook"
                                   value="<?php echo $link_facebook; ?>"/></td>
                        <td><label for="link_twitter">Link Twitter :</label></td>
                        <td><input type="text" id="link_twitter" name="link_twitter"
                                   value="<?php echo $link_twitter; ?>"/></td>
                    </tr>
                    <tr class="alternate">
                        <td><label for="qr_code_line">Url QR Code Line :</label></td>
                        <td colspan="3">
                            <input type="text" id="qr_code_line" name="qr_code_line"
                                               value="<?php echo $qr_code_line; ?>"/>
                            <input type="button" value="Upload Image" class="button btn_upload_image"
                                   data-tbx-id="qr_code_line">
                        </td>
                    </tr>
                    <tr class="alternate">
                        <td><label for="title_line">Title line :</label></td>
                        <td><input type="text" id="title_line" name="title_line"
                                   value="<?php echo $title_line; ?>"/></td>
                        <td><label for="title_ggp">Title Google+ :</label></td>
                        <td><input type="text" id="title_ggp" name="title_ggp"
                                   value="<?php echo $title_ggp; ?>"/></td>
                    </tr>
                    <tr class="alternate">
                        <td><label for="link_line">Link Line :</label></td>
                        <td><input type="text" id="link_line" name="link_line"
                                   value="<?php echo $link_line; ?>"/></td>
                        <td><label for="link_ggp">Link Google+ :</label></td>
                        <td><input type="text" id="link_ggp" name="link_ggp"
                                   value="<?php echo $link_ggp; ?>"/></td>
                    </tr>
                    <tr class="alternate">
                        <td><label for="latitude">Latitude :</label></td>
                        <td><input type="text" id="latitude" name="latitude"
                                   value="<?php echo $latitude; ?>"/></td>
                        <td><label for="longitude">Longitude :</label></td>
                        <td><input type="text" id="longitude" name="longitude"
                                   value="<?php echo $longitude; ?>"/></td>
                    </tr>
                    </tbody>
                </table>
                <input type="submit" class="button-primary" value="Save">
            </div>
        </div>
    </form>
<?php
}