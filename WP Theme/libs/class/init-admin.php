<?php
function register_checkpage_menu_page()
{
    add_submenu_page('tools.php', 'Checkpage init', 'Checkpage init', 3, 'checkpage-init', 'my_custom_submenu_page_callback');
}

add_action('admin_menu', 'register_checkpage_menu_page');
function my_custom_submenu_page_callback()
{
    if (!isset($init_page)) {
        include_once('init-page-config.php');
    }
    ?>
    <link rel="stylesheet" type="text/css"
          href="<?php echo get_template_directory_uri(); ?>/libs/css/bootstrap.min.css">
    <!--<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrap.min.js"></script>-->
    <h1>Checkpage init</h1>
    <ul>
        <?php
        for ($i = 0; $i < count($init_page); $i++) {
            //echo $init_page[$i]['post_title'];
            ?>
            <li class="pagelist"><h4><?php echo $init_page[$i]['post_title']; ?></h4>
            <?php $page = get_page_by_title($init_page[$i]['post_title']);
            if (!isset($page->ID)) {
                ?>
                <input class="arrid" value="<?= $i ?>" type="hidden"/>
                <button type="button" class="btn btn-default jjcreatepage">Create Page</button></li>
            <?php
            }
        }
        ?>
    </ul>
    <div class="clear"></div>
    <style type="text/css">
        li.pagelist {
            width: 150px;
            height: 150px;
            border: 1px #eee solid;
            background: #fff;
            float: left;
            margin: 10px 10px 0 0;
            text-align: center
        }

        li.pagelist h4 {
            padding: 0
        }

        .clear {
            clear: both
        }
    </style>

    <script type="text/javascript">
        var homesite = '<?php echo get_home_url();?>/';
        var removeobj = null;
        var checkpage = {
            init: function () {
                checkpage.setEvent();
            },
            setEvent: function () {
                jQuery('.jjcreatepage').on('click', function () {
                    removeobj = jQuery(this);
                    removeobj.text('Loading...');
                    jQuery('.jjcreatepage').attr('disabled', 'disabled');
                    jQuery.getJSON(homesite, {adminPage: 'updatepage', arrid: jQuery(this).parent().find('input.arrid').val()}, checkpage.ajaxSuss);
                    return false;
                });
            },
            ajaxSuss: function (data) {
                if (data['error'] !== 'error') {
                    removeobj.remove();
                    jQuery('.jjcreatepage').removeAttr('disabled');
                }
            },
            onready: function () {
                checkpage.init();
            }
        }
        jQuery(document).ready(checkpage.onready);
    </script>
<?php
}

function adminUpdatePage()
{
    $arrid = isset($_GET['arrid']) ? $_GET['arrid'] : false;
    $arr = NULL;
    if (!isset($init_page)) {
        include_once('init-page-config.php');
    }
    if (current_user_can('edit_pages')) {
        $my_post = $init_page[$arrid];
        wp_insert_post($my_post);
        $arr = array('error' => 'none');
    } else {
        $arr = array('error' => 'error');
    }
    header('Content-Type: application/json');
    echo json_encode($arr);
    exit();
}

function jj_login($username, $pass, $remember = false)
{
    $creds = array();
    $creds['user_login'] = $username;
    $creds['user_password'] = $pass;
    $creds['remember'] = $remember;
    $user = wp_signon($creds, false);
    if (is_wp_error($user)) {
        echo $user->get_error_message();
    } else {
        wp_redirect(get_site_url() . '/edit-resume/');
    }
    exit();
}

$adminPage = isset($_GET['adminPage']) ? $_GET['adminPage'] : false;
if ($adminPage) {
    $getCheckAdminMenu = htmlentities($adminPage);
    if ($getCheckAdminMenu == "updatepage") {
        adminUpdatePage();
        exit();
    } else if ($getCheckAdminMenu == "checklogin") {
        $username = isset($_POST['username']) ? $_POST['username'] : FALSE;
        $pass = isset($_POST['password']) ? $_POST['password'] : FALSE;
        $remember = isset($_POST['remember']) ? $_POST['remember'] : FALSE;
        if ($username) {
            jj_login($username, $pass, $remember);
        } else {
            echo 'userlogin null';
        }
    } else if ($getCheckAdminMenu == "getamphor") {
        include_once(get_template_directory() . '/libs/ajax/getamphor.php');
    }

}