<?php

global $current_user, $wpdb;
$classEmployer = new Employer($wpdb);
$classCandidate = new Candidate($wpdb);
$getDegreeGroup = $classCandidate->getEducation(0, 0, " GROUP BY degree");
$getUniversityGroup = $classCandidate->getEducation(0, 0, " GROUP BY university");
$getJapaneseSkill = $classCandidate->japanese_skill;


if (is_user_logged_in()) {
    $classPackage = new Package($wpdb);
    get_currentuserinfo();
    $userID = $current_user->ID;
    $userType = get_user_meta($userID, 'user_type', true);
    if ($userType) {
        $isLogin = true;
        if ($userType == 'employer') {
        } else if ($userType == 'candidate') {
            $isLogin = false;
        }
//        $arrayPackage = $classPackage->getPackage();
//        $arraySelectPackage = $classPackage->getSelectPackage($userID);
//        var_dump($arraySelectPackage);

    } else {
        $isLogin = false;
    }

} else {
    $userID = 0;
}

if (!$isLogin) {
    wp_redirect(home_url());
    exit;
}
?>
<script>
    var employer_id = <?php echo $userID; ?>;
</script>
<script src="<?php echo get_template_directory_uri(); ?>/libs/js/candidate_list.js"></script>
<section class="container-fluid" style="margin-top: 10px;">

    <div class="container wrapper">
        <div class="row">
            <div class="col-md-12">

                <div class="clearfix"
                     style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                    <h5 class="pull-left" style="">
                        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png"
                             style="height: 25px;"/>
                        お知らせ
                        <span class="font-color-BF2026" style=""><?php the_title() ?></span>
                    </h5>

                    <div class="clearfix" style="margin-top: 20px;"></div>
                    <?php if (is_user_logged_in()) {
                        include_once('emp_menu.php');
                    } ?>
                    <hr/>
                    <h5 class="bg-ddd padding-10 clearfix">Search Seeking for Job</h5>

                    <form id="frm_search_candidate" method="post">
                        <input type="hidden" name="post_type" value="search_candidate">
                        <input type="hidden" name="employer_post" value="true">
                        <input type="hidden" name="employer_id" value="<?php echo $userID; ?>">
                        Degree:
                        <select name="degree" id="degree">
                            <option value=""></option>
                            <?php foreach ($getDegreeGroup as $value): ?>
                                <option value="<?php echo $value->degree; ?>"
                                    ><?php echo $value->degree; ?></option>
                            <?php endforeach; ?>
                        </select>
                        University / Institute: <select name="university" id="university">
                            <option value=""></option>
                            <?php foreach ($getUniversityGroup as $value): ?>
                                <option value="<?php echo $value->university; ?>"
                                    ><?php echo $value->university; ?></option>
                            <?php endforeach; ?>
                        </select>
                        Japanese Skill: <select name="japanese_skill" id="japanese_skill">
                            <option value=""></option>
                            <?php foreach ($getJapaneseSkill as $value): ?>
                                <option value="<?php echo $value; ?>"
                                    ><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="">Search</button>
                    </form>
                    <div id="list_search_candidate"></div>
                </div>

                <?php require_once("banner1.php"); ?>

            </div>
        </div>

    </div>

    <div class="modal fade" id="modal_confirm_request_profile" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">What are you want to request profile.</h4>
                </div>
                <div class="modal-body">
                    <table border="0" class="table">
                        <tr>
                            <td>Name</td>
                            <td>Degree</td>
                            <td>University / Institute</td>
                            <td>Japanese Skill</td>
                        </tr>
                        <tr>
                            <td id="show_can_name">Name</td>
                            <td id="show_can_degree">Degree</td>
                            <td id="sho_can_university">University / Institute</td>
                            <td id="show_skill">Japanese Skill</td>
                        </tr>
                    </table>
                    <button type="button" class="btn btn-info" data-dismiss="modal"
                            onclick="addRequestProfile();">OK
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>