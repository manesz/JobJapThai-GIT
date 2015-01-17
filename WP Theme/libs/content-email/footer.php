<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 17/1/2558
 * Time: 20:54 น.
 */

$objClassContact = new Contact($wpdb);
$getContact = $objClassContact->getContact(1);
if ($getContact) {
    $getContact = $getContact[0];
}
?>
<!-- =============== START FOOTER =============== -->
<div class='movableContent'>
    <table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td colspan="3" height='48'></td>
        </tr>
        <tr>
            <td width='90'></td>
            <td width='400' align='center' style='text-align: center;'>
                <table width='400' cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td>
                            <div class='contentEditableContainer contentTextEditable'>
                                <div class='contentEditable'
                                     style='text-align: center;color:#AAAAAA;'>
                                    <p>
                                        Sent by info@jobjapthai.com <br/>
                                        JobJapThai Co., Ltd.<br/>
                                        1 Infinite Loop Cupertino, CA 95014<br/>
                                        Tel. +6686 627 0681<br/>
                                        <a href="mailto:contact@jobjapthai.com">contact@jobjapthai.com</a>
                                        <!--                                                                <a href="[FORWARD]" style='color:#AAAAAA;'>Forward-->
                                        <!--                                                                    to a friend</a> <br/>-->
                                        <!--                                                                <a href="[UNSUBSCRIBE]"-->
                                        <!--                                                                   style='color:#AAAAAA;'>Unsubscribe</a>-->
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td width='90'></td>
        </tr>
    </table>
</div>

<div class='movableContent'>
    <table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td colspan="3" height='40'></td>
        </tr>
        <tr>
            <td width='195'></td>
            <td width='190' align='center' style='text-align: center;'>
                <table width='190' cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td width='20'></td>
                        <?php if (!empty($getContact->link_facebook)): ?>
                            <td width='40'>
                                <div class='contentEditableContainer contentFacebookEditable'>
                                    <div class='contentEditable'
                                         style='text-align: center;color:#AAAAAA;'>
                                        <a href="<?php echo $getContact->link_facebook; ?>" target="_blank">
                                            <img src="http://ideacorners.com/files/cust-logo/jobjapthai-social-fb.png" alt="facebook"
                                                 width='40' height='40' data-max-width="40"
                                                 data-customIcon="true"></a>
                                    </div>
                                </div>
                            </td>
                            <td width='10'></td>
                        <?php endif;
                        if (!empty($getContact->link_twitter)):
                            ?>
                            <td width='40'>
                                <div class='contentEditableContainer contentTwitterEditable'>
                                    <div class='contentEditable'
                                         style='text-align: center;color:#AAAAAA;'>
                                        <a href="<?php echo $getContact->link_twitter; ?>" target="_blank">
                                            <img src="http://ideacorners.com/files/cust-logo/jobjapthai-social-ggp.png" alt="twitter"
                                                 width='40' height='40' data-max-width="40"
                                                 data-customIcon="true">
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td width='10'></td>

                        <?php endif;
                        if (!empty($getContact->link_ggp)):
                            ?>
                            <td width='40'>
                                <div class='contentEditableContainer contentImageEditable'>
                                    <div class='contentEditable'
                                         style='text-align: center;color:#AAAAAA;'>
                                        <a href="<?php echo $getContact->link_ggp; ?>" target="_blank">
                                            <img src="http://ideacorners.com/files/cust-logo/jobjapthai-social-tw.png" alt="Pinterest"
                                                 width='40' height='40' data-max-width="40">
                                        </a>
                                    </div>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                </table>
            </td>
            <td width='195'></td>
        </tr>
        <tr>
            <td colspan="3" height='40'></td>
        </tr>
    </table>
</div>
<!-- =============== END FOOTER =============== -->