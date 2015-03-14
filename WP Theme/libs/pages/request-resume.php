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

        $getRequestResume = $classCandidate->getRequestResumeByEmployer($userID);

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
                    <h5 class="bg-ddd padding-10 clearfix"><?php the_title() ?> List</h5>
                    <table border="1" class="table table-hover">
                        <tr>
                            <td>Name</td>
                            <td>Degree</td>
                            <td>University / Institute</td>
                            <td>Japanese Skill</td>
                            <td>Status</td>
                        </tr>
                        <?php foreach ($getRequestResume as $value):
                            $name = "$value->title $value->first_name $value->last_name";?>
                            <tr>
                                <td>
                                    <?php echo $name; ?>
                                    <?php if ($value->approve): ?>
                                        <a onclick="viewCandidateProfile(<?php echo $value->candidate_id; ?>)"
                                           data-toggle="modal" data-target="#modal_candidate_profile" href="#">
                                            view</a>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $value->degree; ?></td>
                                <td><?php echo $value->university; ?></td>
                                <td><?php echo $value->japanese_skill; ?></td>
                                <td>
                                    <span
                                        class="<?php echo $value->approve ? "font-color-4BB748" : "font-color-BF2026"; ?>"
                                        ><?php echo $value->approve ? "approve" : "non approve"; ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

                <?php require_once("banner1.php"); ?>

            </div>
        </div>

    </div>
</section>