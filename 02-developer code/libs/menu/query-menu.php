<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 09/05/2558
 * Time: 12:14 น.
 */
function add_query_menu_items()
{
    add_submenu_page(
        'ics_theme_settings',
        'Query',
        'Query',
        'manage_options',
        'query',
        'render_query_page'
    );
}

function render_query_page()
{
    global $wpdb;
    require_once('header.php');
    ?>
    <script type="text/javascript"
            src="<?php bloginfo('template_directory'); ?>/libs/js/query-menu.js"></script>
            <h2>Query Menu</h2>
            <hr/>
            <form id="query_post" method="post">
                <input type="hidden" name="query_backend_post" value="true"/>
                <div class="tb-insert">
                    <table class="wp-list-table widefat" cellspacing="0" width="100%">
                        <tbody id="the-list-edit">
                        <tr class="alternate">
                            <td><label for="working_day">Query:</label></td>
                            <td colspan="3">
                                <textarea cols="80" rows="10"
                                          id="query_txt" name="query_txt"></textarea>
                            </td>
                        </tr>
                        <tr class="alternate">
                            <td><label for="working_day">Result:</label></td>
                            <td colspan="3" id="result_show"><textarea cols="80" rows="10"
                                          id="result" disabled ></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                            <input type="submit" class="button-primary" value="Run"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
<?php
}

add_action('admin_menu', 'add_query_menu_items');