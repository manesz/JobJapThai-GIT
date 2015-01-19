<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
//add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
/*function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}*/


$classEmployer = new Employer($wpdb);

// let's create the function for the custom type
function custom_post_job()
{
    // creating (registering) the custom type
    register_post_type('job', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
        // let's now add all the options for this post type
        array('labels' => array(
            'name' => __('Job', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Job', 'bonestheme'), /* This is the individual type */
            'all_items' => __('All Job', 'bonestheme'), /* the all items menu item */
            'add_new' => __('Add New', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('Add New Job', 'bonestheme'), /* Add New Display Title */
            'edit' => __('Edit', 'bonestheme'), /* Edit Dialog */
            'edit_item' => __('Edit Post Types', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('New Post Type', 'bonestheme'), /* New Display Title */
            'view_item' => __('View Post Type', 'bonestheme'), /* View Display Title */
            'search_items' => __('Search Post Type', 'bonestheme'), /* Search Custom Type Title */
            'not_found' => __('Nothing found in the Database.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
            'description' => __('This is the example custom post type', 'bonestheme'), /* Custom Type Description */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 6, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon' => get_stylesheet_directory_uri() . '/libs/images/custom-post-icon.png', /* the icon for the custom post type menu */
            'rewrite' => array('slug' => 'job', 'with_front' => false), /* you can specify its url slug */
            'has_archive' => 'job', /* you can rename the slug here */
            'capability_type' => 'post',
            'hierarchical' => false,
            /* the next one is important, it tells what's enabled in the post editor */
            'supports' => array(
                'title',
                'editor',
//                'author',
                'thumbnail',
//                'excerpt',
//                'trackbacks',
//                'custom-fields',
//                'comments',
//                'revisions',
//                'sticky'
            )
        ) /* end of options */
    ); /* end of register post type */


    function meta_job_option()
    {
        global $post, $classEmployer;
        $getEmployerID = empty($_GET['employer_id'])? "": $_GET['employer_id'];
        $custom = get_post_custom($post->ID);
        $qualification = empty($custom["qualification"][0])? "" : $custom["qualification"][0] ;
        $job_type = empty($custom["job_type"][0])? "" : $custom["job_type"][0] ;
        $jlpt_level = empty($custom["jlpt_level"][0])? "" : $custom["jlpt_level"][0] ;
        $job_location = empty($custom["job_location"][0])? "" : $custom["job_location"][0] ;
        $japanese_skill = empty($custom["japanese_skill"][0])? "" : $custom["japanese_skill"][0] ;
        $salary = empty($custom["salary"][0])? "" : $custom["salary"][0] ;
        $working_day = empty($custom["working_day"][0])? "" : $custom["working_day"][0] ;
        $company_id = empty($custom["company_id"][0])? $getEmployerID : $custom["company_id"][0] ;
        $highlight_jobs = empty($custom["highlight_jobs"][0])? "" : $custom["highlight_jobs"][0] ;


        $objCompany = $classEmployer->getCompanyInfo();
        ?>
        <style>
            .select-width {
                width: 300px;
            }
        </style>
        <link href="<?php echo get_template_directory_uri(); ?>/libs/js/libs/select2/select2.css" rel="stylesheet"/>
        <script src="<?php echo get_template_directory_uri(); ?>/libs/js/libs/select2/select2.js"></script>
        <script>
            var $ = jQuery;
            $(document).ready(function () {
                $("#company_id").select2();
            });
        </script>
        <table>
            <tr>
                <td><label for="company_id">Company:</label></td>
                <td>
                    <select id="company_id" name="company_id" class="select-width">
                        <option value="">--Select--</option>
                        <?php if ($objCompany)foreach ($objCompany as $value): ?>
                            <option value="<?php echo $value->id ?>"
                                <?php echo $company_id == $value->id ? "selected" : ""; ?>
                                ><?php echo $value->company_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="highlight_jobs">Highlight jobs:</label></td>
                <td>
                    <input type="checkbox" value="<?php echo empty($highlight_jobs) ? 0 : $highlight_jobs; ?>"
                        <?php echo $highlight_jobs ? 'checked' : ''; ?>
                           name="highlight_jobs"
                           onclick="this.value=$(this).prop('checked')?1:0;">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="qualification">Qualification:</label></td>
                <td>
                    <textarea style="margin: 0px; width: 700px; height: 150px;"
                              name="qualification"><?php echo $qualification; ?></textarea>
                </td>
            </tr>
            <tr>
                <td><label for="job_type">Job Type:</label></td>
                <td>
                    <select name="job_type" class="select-width">
                        <option value="">--Select--</option>
                        <option value="Permanent" <?php echo $job_type == 'Permanent' ? 'selected' : ''; ?>
                            >Permanent
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="jlpt_level">JLPT Level:</label></td>
                <td>
                    <select name="jlpt_level" class="select-width">
                        <option value="">--Select--</option>
                        <option value="N2" <?php echo $jlpt_level == 'N2' ? 'selected' : ''; ?>
                            >N2
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="job_location">Job Location:</label></td>
                <td>
                    <select name="job_location" class="select-width">
                        <option value="">--Select--</option>
                        <option value="Bangkok" <?php echo $job_location == 'Bangkok' ? 'selected' : ''; ?>
                            >Bangkok
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="japanese_skill">Japanese Skill:</label></td>
                <td>
                    <select name="japanese_skill" class="select-width">
                        <option value="">--Select--</option>
                        <option value="Good" <?php echo $japanese_skill == 'Good' ? 'selected' : ''; ?>
                            >Good
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="salary">Salary:</label></td>
                <td><input id="salary" class="select-width"
                           name="salary" value="<?php echo $salary; ?>"/></td>
            </tr>
            <tr>
                <td><label for="working_day">Working Day:</label></td>
                <td>
                    <select name="working_day" class="select-width">
                        <option value="">--Select--</option>
                        <option value="Mon-Fri 8.00 – 17.00"
                            <?php echo $working_day == 'Mon-Fri 8.00 – 17.00' ? 'selected' : ''; ?>
                            >Mon-Fri 8.00 – 17.00
                        </option>
                    </select>
                </td>
            </tr>
        </table>
    <?php
    }

    function save_details_job()
    {
        global $post;
        if ($_POST) {
            update_post_meta($post->ID, "qualification", $_POST["qualification"]);
            update_post_meta($post->ID, "job_type", $_POST["job_type"]);
            update_post_meta($post->ID, "jlpt_level", $_POST["jlpt_level"]);
            update_post_meta($post->ID, "job_location", $_POST["job_location"]);
            update_post_meta($post->ID, "japanese_skill", $_POST["japanese_skill"]);
            update_post_meta($post->ID, "salary", $_POST["salary"]);
            update_post_meta($post->ID, "working_day", $_POST["working_day"]);
            update_post_meta($post->ID, "company_id", $_POST["company_id"]);
            update_post_meta($post->ID, "highlight_jobs", $_POST["highlight_jobs"]);
        }
        return true;
    }

    /* this adds your post categories to your custom post type */
    register_taxonomy_for_object_type('category', 'job');
    /* this adds your post tags to your custom post type */
    register_taxonomy_for_object_type('post_tag', 'job');

}

// adding the function to the Wordpress init
add_action('init', 'custom_post_job');

add_action("admin_init", "admin_init_job");
//add_action('init', 'job_register');
add_action('save_post', 'save_details_job');
//    add_action("manage_posts_custom_column", "job_custom_columns");
//    add_filter("manage_edit-job_columns", "job_edit_columns");


function admin_init_job()
{
    //    add_meta_box("price-meta", "Price", "price", "job", "side", "low");
    add_meta_box("job_option_meta", "Job Options", "meta_job_option", "job", "normal", "low");
}

/*
for more information on taxonomies, go here:
http://codex.wordpress.org/Function_Reference/register_taxonomy
*/

// now let's add custom categories (these act like categories)
register_taxonomy('custom_job_cat',
    array('job'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    array('hierarchical' => true, /* if this is true, it acts like categories */
        'labels' => array(
            'name' => __('Job Categories', 'bonestheme'), /* name of the custom taxonomy */
            'singular_name' => __('Job Category', 'bonestheme'), /* single taxonomy name */
            'search_items' => __('Search Job Categories', 'bonestheme'), /* search title for taxomony */
            'all_items' => __('All Job Categories', 'bonestheme'), /* all title for taxonomies */
            'parent_item' => __('Parent Job Category', 'bonestheme'), /* parent title for taxonomy */
            'parent_item_colon' => __('Parent Job Category:', 'bonestheme'), /* parent taxonomy title */
            'edit_item' => __('Edit Job Category', 'bonestheme'), /* edit custom taxonomy title */
            'update_item' => __('Update Job Category', 'bonestheme'), /* update title for taxonomy */
            'add_new_item' => __('Add New Job Category', 'bonestheme'), /* add new title for taxonomy */
            'new_item_name' => __('New Job Category Name', 'bonestheme') /* name title for taxonomy */
        ),
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'custom-slug'),
    )
);

// now let's add custom tags (these act like categories)
//register_taxonomy('job_tag',
//    array('job'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
//    array('hierarchical' => false, /* if this is false, it acts like tags */
//        'labels' => array(
//            'name' => __('Job Tags', 'bonestheme'), /* name of the custom taxonomy */
//            'singular_name' => __('Job Tag', 'bonestheme'), /* single taxonomy name */
//            'search_items' => __('Search Job Tags', 'bonestheme'), /* search title for taxomony */
//            'all_items' => __('All Job Tags', 'bonestheme'), /* all title for taxonomies */
//            'parent_item' => __('Parent Job Tag', 'bonestheme'), /* parent title for taxonomy */
//            'parent_item_colon' => __('Parent Job Tag:', 'bonestheme'), /* parent taxonomy title */
//            'edit_item' => __('Edit Job Tag', 'bonestheme'), /* edit custom taxonomy title */
//            'update_item' => __('Update Job Tag', 'bonestheme'), /* update title for taxonomy */
//            'add_new_item' => __('Add New Job Tag', 'bonestheme'), /* add new title for taxonomy */
//            'new_item_name' => __('New Job Tag Name', 'bonestheme') /* name title for taxonomy */
//        ),
//        'show_admin_column' => true,
//        'show_ui' => true,
//        'query_var' => true,
//    )
//);

/*
    looking for custom meta boxes?
    check out this fantastic tool:
    https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
*/