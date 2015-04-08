<?php
/**
 * The Function for our theme.
 *
 * @package Business Theme by IdeaCorners Developer
 * @subpackage ic-business
 * @author Business Themes - www.ideacorners.com
 */
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

$classBannerSlide = null;
if (!class_exists('BannerSlide')) {
    global $wpdb;
}
$classBannerSlide = new BannerSlide($wpdb);
$postPage = isset($_REQUEST['post_page']) ? $_REQUEST['post_page'] : FALSE;
$typePost = isset($_REQUEST['typePost']) ? $_REQUEST['typePost'] : FALSE;
if ($postPage == 'banner_slide') {
    if ($typePost == 'add') {
//        $callbackname = isset($_REQUEST['callback']) ? $_REQUEST['callback'] : 'callback';
        if (is_user_logged_in()) {
            $result = $classBannerSlide->addData($_REQUEST);
            if ($result) {
                $returnGallery = array('data' => 'success');
            } else {
                $returnGallery = array('data' => 'error');
            }
        } else {
            $returnGallery = array('data' => 'none');
        }
//        header('Content-type: text/json');
//        header('Content-type: application/json');
//        echo $callbackname, '(', json_encode($returnGallery), ')';
        echo json_encode($returnGallery);
        exit();
    } else if ($typePost == 'json_banner_slide') { //echo json_encode(array(55, 66));exit;
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $plimit = isset($_REQUEST['plimit']) ? $_REQUEST['plimit'] : 8;
        $callbackname = isset($_REQUEST['callback']) ? $_REQUEST['callback'] : 'callback';
        $startpage = 0;
        $pagthis = $page;
        if ($page != 1) {
            $startpage = $plimit * ($page - 1);
        }
//        $gallerylist = $classBannerSlide->getList($plimit, $startpage);
        $gallerylist = $classBannerSlide->getList();
//        echo json_encode(array($page, 66));exit;
        foreach ($gallerylist as $key) {
            $returnGallery['data'][] = $key;
        }
//$p = new pagination();
        $classBannerSlide->classPagination->Items($classBannerSlide->getCountValue());
        $classBannerSlide->classPagination->limit($plimit);
        $classBannerSlide->classPagination->target(network_site_url('/') . "");
        $classBannerSlide->classPagination->currentPage($pagthis);
        $classBannerSlide->classPagination->adjacents(3);
        $classBannerSlide->classPagination->nextLabel('<strong>Next</strong>');
        $classBannerSlide->classPagination->prevLabel('<strong>Prev</strong>');
        $classBannerSlide->classPagination->nextIcon('');
        $classBannerSlide->classPagination->prevIcon('');
        $classBannerSlide->classPagination->getOutput();
        $paginate = str_replace('...', '<span class="dot">...</span>', $classBannerSlide->classPagination->pagination);
        $returnGallery['pagination'][] = $paginate;
        header('Content-type: text/json');
        header('Content-type: application/json');
//        echo $callbackname, '(', json_encode($returnGallery), ')';
        echo json_encode($returnGallery);
        exit();
    } else if ($typePost == 'editform') {
        $galleryID = isset($_REQUEST['galleryid']) ? $_REQUEST['galleryid'] : FALSE;
        if ($galleryID) {
            $galleryRow = $classBannerSlide->getByID($galleryID);
            ?>
            <form action="" id="gallery-post-edit" method="post">
                <input name="gsort" type="hidden"
                       id="gsort" title="Sort"
                       value="<?php echo @$galleryRow->sort ?>"
                       size="3" maxlength="3"/>

                <div id="div-inner-edit">
                    <input name="typepost" type="hidden" id="typepost" value="edit"/>
                    <input type="hidden" id="galleryid" value="<?php echo @$galleryRow->id ?>"/>
                    <table class="wp-list-table widefat" cellspacing="0">
                        <tbody id="the-list-edit">
                        <tr class="alternate">
                            <td align="right" valign="middle"><strong>Link : </strong></td>
                            <td align="left" valign="top">
                                <input name="glink" type="text"
                                       id="glink"
                                       placeholder="Enter Link"
                                       title="Enter Link"
                                       value="<?php echo @$galleryRow->link ?>"
                                       size="40" maxlength="255"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <center><img src="<?php echo @$galleryRow->image_path ?>"
                                             id="imgchang" width="300" alt="" onerror="defaultImage(this);"/><br/>
                                    <input id="pathImg" type="hidden" name="pathImg" size="100"
                                           placeholder="Path Image"
                                           title="Path Image"
                                           value="<?php echo @$galleryRow->image_path ?>"/>
                                    <input id="uploadImageButton" type="button" class="button"
                                           value="Upload Image"
                                           onclick="imageUploaderAll('form#gallery-post-edit #pathImg', 'form#gallery-post-edit #imgchang');"/>
                                    <br/><font color='red'>**</font>ขนาดที่แนะนำ 960x120px
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <input type="submit" name="gallery2" value="Update"
                                       class="button-primary"/> &nbsp;<input
                                    type="button" value="Cancel" id="cancelform"
                                    class="button"/></td>
                        </tr>
                        </tbody>
                    </table>
                    <!--        <input type="button" value="New" onclick="document.location.reload(true)" class="button-primary"/>-->
                </div>
            </form>
        <?php
        }
        exit();
    } else if ($typePost == 'edit') {
        $callbackname = isset($_REQUEST['callback']) ? $_REQUEST['callback'] : 'callback';
        if (is_user_logged_in()) {
//            $gdesc = isset($_REQUEST['gdesc']) ? $_REQUEST['gdesc'] : '';
//            $gsort = isset($_REQUEST['gsort']) ? $_REQUEST['gsort'] : '';
//            $gtitle = isset($_REQUEST['gtitle']) ? $_REQUEST['gtitle'] : '';
//            $pathimg = isset($_REQUEST['pathimg']) ? $_REQUEST['pathimg'] : '';
//            $glink = isset($_REQUEST['glink']) ? $_REQUEST['glink'] : '';
            $galleryID = isset($_REQUEST['galleryid']) ? $_REQUEST['galleryid'] : FALSE;
            if ($galleryID) {
                if ($classBannerSlide->editData($_REQUEST)) {
                    $returnGallery = array('data' => 'success');
                } else {
                    $returnGallery = array('data' => 'error');
                }
            } else {
                $returnGallery = array('data' => 'none');
            }
            header('Content-type: text/json');
            header('Content-type: application/json');
            echo $callbackname, '(', json_encode($returnGallery), ')';
        }
        exit();
    } else if ($typePost == 'del') {
        $callbackname = isset($_REQUEST['callback']) ? $_REQUEST['callback'] : 'callback';
        if (is_user_logged_in()) {
            $galleryID = isset($_REQUEST['galleryid']) ? $_REQUEST['galleryid'] : FALSE;
            if ($classBannerSlide->deleteValue($galleryID)) {
                $returnGallery = array('data' => 'success');
            } else {
                $returnGallery = array('data' => 'error');
            }
        } else {
            $returnGallery = array('data' => 'none');
        }
        header('Content-type: text/json');
        header('Content-type: application/json');
        echo $callbackname, '(', json_encode($returnGallery), ')';
        exit();
    } else if ($typePost == 'update_order') {
        $result = $classBannerSlide->updateOder($_REQUEST['array_order']);
        if (!$result)
            echo 'fail';
        else
            echo 'success';
        exit;
    }
}

add_action('admin_menu', 'theme_banner_slide_add');
function theme_banner_slide_add()
{
    add_submenu_page(
        'ics_theme_settings',
        'Banner Slide',
        'Banner Slide',
        'manage_options',
        'banner-slide',
        'theme_banner_slide_page'
    );
}

function theme_banner_slide_page()
{
    global $webSiteName;
    ?>
    <link href="<?php bloginfo('template_directory'); ?>/libs/css/tytabs.css" rel="stylesheet" type="text/css"/>
    <link href="<?php bloginfo('template_directory'); ?>/libs/css/icon.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo includes_url(); ?>css/editor.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/libs/js/banner_slide.js"></script>

    <!--Sortable-->
    <script type="text/javascript"
            src="<?php bloginfo('template_directory'); ?>/libs/js/sortable/jquery-1.10.2.js"></script>
    <script type="text/javascript"
            src="<?php bloginfo('template_directory'); ?>/libs/js/sortable/jquery-ui.js"></script>
    <!--End Sortable-->

    <input type="hidden" value="<?php bloginfo('template_directory'); ?>/libs/js/jquery.min.js" id="getjqpath"/>
    <input type="hidden" value="<?php bloginfo('template_directory'); ?>/" id="getbasepath"/>
    <div class="wrap">
    <div id="icon-themes" class="icon32"><br/></div>

    <h2><?php _e(@$webSiteName . ' theme controller', 'wp_toc'); ?></h2>

    <p><?php echo @$webSiteName; ?> business website theme &copy; developer by <a href="http://www.ideacorners.com"
                                                                                  target="_blank">IdeaCorners
            Developer</a></p>
    <!-- If we have any error by submiting the form, they will appear here -->
    <?php settings_errors('tab1-errors'); ?>
    <div>
        <!-- Tabs -->
        <div id="tabsholder">
            <div class="contents marginbot">
                <div class="tabscontent">
                    <div id="slidelist-stage">

                    </div>
                    <input type="hidden" id="siteurl" value="<?php echo network_site_url('/'); ?>"/>
                    <!--                    <ul class="sortable" id="sortable">-->
                    <!--                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</li>-->
                    <!--                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>-->
                    <!--                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>-->
                    <!--                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 4</li>-->
                    <!--                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>-->
                    <!--                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 6</li>-->
                    <!--                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 7</li>-->
                    <!--                    </ul>-->
                    <h3>Upload Banner Slide</h3>
                    <!--                        <ul id="sortable" class="sortable grid">-->
                    <!--                            <li draggable="true" id="item1">Item 1</li>-->
                    <!--                            <li draggable="true" id="item2">Item 2</li>-->
                    <!--                            <li draggable="true" id="item3">Item 3</li>-->
                    <!--                            <li draggable="true" id="item4">Item 4</li>-->
                    <!--                            <li draggable="true" id="item5">Item 5</li>-->
                    <!--                        </ul>-->
                    <style>
                        #demos section {
                            overflow: hidden;
                        }

                        .sortable {
                            width: 310px;
                            -webkit-user-select: none;
                            -moz-user-select: none;
                            -ms-user-select: none;
                            user-select: none;
                        }

                        .sortable.grid {
                            overflow: hidden;
                        }

                        .sortable li {
                            list-style: none;
                            border: 1px solid #CCC;
                            background: #F6F6F6;
                            color: #1C94C4;
                            margin: 5px;
                            padding: 5px;
                            height: 22px;
                        }

                        .sortable.grid li {
                            line-height: 80px;
                            float: left;
                            width: 80px;
                            height: 80px;
                            text-align: center;
                        }

                        .handle {
                            cursor: move;
                        }

                        .sortable.connected {
                            width: 200px;
                            min-height: 100px;
                            float: left;
                        }

                        li.disabled {
                            opacity: 0.5;
                        }

                        li.highlight {
                            background: #FEE25F;
                        }

                        li.sortable-placeholder {
                            border: 1px dashed #CCC;
                            background: none;
                        }
                    </style>
                    <div class="update-nag" id="showstatus"></div>
                    <div id="formstage">
                        <form action="" id="gallery-post" method="post">
                            <input name="gsort" type="hidden" id="gsort" value="99" size="3" maxlength="3"/>

                            <div id="div-inner">
                                <input name="typepost" type="hidden" id="typepost" value="add"/>
                                <input type="hidden" id="galleryID" value="0"/>
                                <table class="wp-list-table widefat" cellspacing="0">
                                    <tbody id="the-list">
                                    <tr class="alternate">
                                        <td align="right" valign="middle"><strong>Link: </strong></td>
                                        <td align="left" valign="top">
                                            <input name="glink" type="text" id="glink"
                                                   placeholder="Enter Link"
                                                   title="Enter Link" value="" size="40"
                                                   maxlength="255"/></td>
                                    </tr>
                                    <tr class="alternate">
                                        <td align="right" valign="middle"><strong>Path Image: </strong></td>
                                        <td>
                                            <input id="pathImg" type="text" name="pathImg" size="40"
                                                   placeholder="Path Image"
                                                   title="Path Image"/>
                                            <input id="uploadImageButton" type="button" class="button"
                                                   value="Upload Image"
                                                   onclick="imageUploader('#pathImg');"/>
                                            <input type="submit" name="gallery" value="Save" class="button-primary"/>
                                            <br/><font color='red'>**</font>ขนาดที่แนะนำ 960x120px
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--        <input type="button" value="New" onclick="document.location.reload(true)" class="button-primary"/>-->
                            </div>
                        </form>
                    </div>
                    <div id="formupdate"></div>
                </div>
            </div>
        </div>
        <!-- /Tabs -->
    </div>
    <script>
    </script>
<?php
}