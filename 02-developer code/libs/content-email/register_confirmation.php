<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14/1/2558
 * Time: 13:10 น.
 */
global $wpdb;
function wp_mail_set_content_type()
{
    return "text/html";
}
add_filter('wp_mail_content_type', 'wp_mail_set_content_type');

$getKey = $_REQUEST['key'];
$urlConfirm = home_url() . "/confirm-register?key=$getKey";
$objClassContact = new Contact($wpdb);
$getContact = $objClassContact->getContact(1);
if ($getContact) {
    $getContact = $getContact[0];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Register Confirmation.</title>
    <style type="text/css">
        body {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            -webkit-text-size-adjust: 100% !important;
            -ms-text-size-adjust: 100% !important;
            -webkit-font-smoothing: antialiased !important;
        }

        .tableContent img {
            border: 0 !important;
            display: block !important;
            outline: none !important;
        }

        a {
            color: #382F2E;
        }

        p, h1, h2, ul, ol, li, div {
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            font-weight: normal;
            background: transparent !important;
            border: none !important;
        }

        .contentEditable h2.big, .contentEditable h1.big {
            font-size: 26px !important;
        }

        .contentEditable h2.bigger, .contentEditable h1.bigger {
            font-size: 37px !important;
        }

        td, table {
            vertical-align: top;
        }

        td.middle {
            vertical-align: middle;
        }

        a.link1 {
            font-size: 13px;
            color: #27A1E5;
            line-height: 24px;
            text-decoration: none;
        }

        a {
            text-decoration: none;
        }

        .link2 {
            color: #ffffff;
            border-top: 10px solid #27A1E5;
            border-bottom: 10px solid #27A1E5;
            border-left: 18px solid #27A1E5;
            border-right: 18px solid #27A1E5;
            border-radius: 3px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            background: #27A1E5;
        }

        .link3 {
            color: #555555;
            border: 1px solid #cccccc;
            padding: 10px 18px;
            border-radius: 3px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            background: #ffffff;
        }

        .link4 {
            color: #27A1E5;
            line-height: 24px;
        }

        h2, h1 {
            line-height: 20px;
        }

        p {
            font-size: 14px;
            line-height: 21px;
            color: #AAAAAA;
        }

        .contentEditable li {

        }

        .appart p {

        }

        .bgItem {
            background: #ffffff;
        }

        .bgBody {
            background: #ffffff;
        }

        img {
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
            width: auto;
            max-width: 100%;
            clear: both;
            display: block;
            float: none;
        }

    </style>


    <script type="colorScheme" class="swatch active">
{
    "name":"Default",
    "bgBody":"ffffff",
    "link":"27A1E5",
    "color":"AAAAAA",
    "bgItem":"ffffff",
    "title":"444444"
}

    </script>


</head>
<body paddingwidth="0" paddingheight="0" bgcolor="#d1d3d4"
      style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;"
      offset="0" toppadding="0" leftpadding="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableContent bgBody" align="center"
       style='font-family:Helvetica, sans-serif;'>
<!-- =============== START HEADER =============== -->

<tr>
<td align='center'>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td class="bgItem" align="center">
            <table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td class='movableContentContainer' align="center">

                        <div class='movableContent'>
                            <table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td height='15'></td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="580" border="0" cellspacing="0" cellpadding="0"
                                               align="center">
                                            <tr>
                                                <td width='400'>
                                                    <div class='contentEditableContainer contentImageEditable'>
                                                        <div class='contentEditable'>
                                                            <a href="<?php echo home_url(); ?>"><img
                                                                    src="<?php echo get_template_directory_uri(); ?>/libs/img/nav-logo-big.png"
                                                                    alt="Logo"
                                                                    data-default="placeholder"></a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width='180'></td>
                                                <td valign="middle" style='vertical-align: middle;'
                                                    width='150'>
                                                    <div class='contentEditableContainer contentTextEditable'>
                                                        <div class='contentEditable'
                                                             style='text-align: right;'>
<!--                                                            <a href="[SHOWEMAIL]" class='link1'>Open in your-->
<!--                                                                browser</a>-->
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height='15'></td>
                                </tr>
                                <tr>
                                    <td>
                                        <hr style='height:1px;background:#DDDDDD;border:none;'>
                                    </td>
                                </tr>
                            </table>
                        </div>


                        <!-- =============== END HEADER =============== -->
                        <!-- =============== START BODY =============== -->

                        <div class='movableContent'>
                            <table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td height='40'></td>
                                </tr>
                                <tr>
                                    <td style='border: 1px solid #EEEEEE; border-radius:6px;-moz-border-radius:6px;-webkit-border-radius:6px'>
                                        <table width="480" border="0" cellspacing="0" cellpadding="0"
                                               align="center">
                                            <tr>
                                                <td height='25'></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class='contentEditableContainer contentTextEditable'>
                                                        <div class='contentEditable'
                                                             style='text-align: left;'>
                                                            <h2 style="font-size: 20px;">Register Confirmation.</h2>
                                                            <br>

                                                            <p>ขอบคุณสำหรับการสมัครสมาชิก www.jobjapthai.com กรุณายืนยันการสมัครด้วยการคลิก link ด้านล่างนี้</p><br/><br/>
                                                            <p><a href="<?php echo $urlConfirm; ?>"
                                                                  target="_blank"><?php echo $urlConfirm; ?></a> </p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height='24'></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class='movableContent'>
                            <table width="580" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td height='40'></td>
                                </tr>
                                <tr>
                                    <td>
                                        <hr style='height:1px;background:#DDDDDD;border:none;'>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- =============== END BODY =============== -->
                        <?php require_once("footer.php"); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</td>
</tr>
</table>

</body>
</html>
