<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 31/12/2557
 * Time: 11:09 น.
 */

get_template_part("header");
get_template_part("libs/nav");

global $current_user, $wpdb;
$userID = $current_user->ID;
$classEmployer = new Employer($wpdb);
$classCandidate = new Candidate($wpdb);
$classFavorite = new Favorite($wpdb);
$classPackage = new Package($wpdb);
$classApply = new Apply($wpdb);

$postID = get_the_id();
$customField = get_post_custom($postID);
$qualification = empty($customField["qualification"][0]) ? '' : $customField["qualification"][0];
$job_type = empty($customField["job_type"][0]) ? '' : $customField["job_type"][0];
$jlpt_level = empty($customField["jlpt_level"][0]) ? '' : $customField["jlpt_level"][0];
$job_location = empty($customField["job_location"][0]) ? '' : $customField["job_location"][0];
$japanese_skill = empty($customField["japanese_skill"][0]) ? '' : $customField["japanese_skill"][0];
$salary = empty($customField["salary"][0]) ? '' : $customField["salary"][0];
$working_day = empty($customField["working_day"][0]) ? '' : $customField["working_day"][0];
$employer_id = empty($customField["employer_id"][0]) ? 0 : $customField["employer_id"][0];

$dateCreate = $classPackage->getDateCreateJob($postID);
$dayDisplay = $classPackage->getDayDisplay($postID);
$checkDisplayPost = $classPackage->checkDisplayJob($dateCreate, $dayDisplay);
$getStatusJob = $classEmployer->getStatusJob($postID);
if ($userID != $employer_id)
    if (!$checkDisplayPost || !$employer_id || $getStatusJob != 'publish') {
        wp_redirect(home_url('404.php'), 302);
        exit;
    }

$url = wp_get_attachment_url(get_post_thumbnail_id($postID));
$userType = "";
if (empty($url)) {
    $thumbnail = false;
//    $thumbnail = get_template_directory_uri() . "/libs/img/blank-logo.png";
} else {
    $thumbnail = $url;
}
$getBanner = $classEmployer->getBannerPath($employer_id);
if ($getBanner['have_image']) {
    $banner = $getBanner['path'];
} else
    $banner = false;
$getDataCompany = $employer_id ? $classEmployer->getCompanyInfo(0, $employer_id) : false;
if ($getDataCompany) {
    extract((array)$getDataCompany[0]);
    $empEmail = $getDataCompany[0]->email;
}
if (is_user_logged_in()) {
    $isJobFavorite = $classFavorite->checkJobIsFavorite($userID, $postID);
    $isJobApply = $classApply->checkJobIsApply($userID, $postID);
    $userType = get_user_meta($userID, 'user_type', true);
} else {
    $isJobFavorite = false;
    $isJobApply = false;
}
$isAdmin = current_user_can('manage_options');


$directions = empty($directions) ? false : $directions;
if ($directions)
    list($lat, $long) = explode(",", $directions);
?>
    <section class="container-fluid" style="margin-top: 10px;">

        <div class="container wrapper">
            <div class="row">
                <div class="col-md-8">

                    <div class="clearfix"
                         style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                        <?php if ($thumbnail): ?>
                            <img src="<?php echo $thumbnail; ?>"
                                 style="width: 100%"/>
                        <?php endif; ?>
                        <?php if ($banner): ?>
                            <img src="<?php echo $banner; ?>"
                                 style="width: 100%"/>
                        <?php endif; ?>
                        <h4 class="font-color-3 clearfix" style="">
                            <span class="pull-left"><?php the_title(); ?></span>
                                <span class="pull-right" id="icon_fav" style="<?php
                                if (!is_user_logged_in() || !$userType == "candidate" || !$isAdmin) {
                                    if (!$isJobFavorite) {
                                        echo 'display: none;';
                                    }
                                }
                                ?>">
                                    <i class="glyphicon glyphicon-star font-color-BF2026"></i>
                                </span>
                        </h4>
                        <?php if ($employer_id): ?>
                            <h5 class="font-color-BF2026 clearfix"
                                style=""><?php echo empty($company_name) ? "" : $company_name; ?>
                                <a href="<?php echo get_site_url(); ?>/company-profile?id=<?php echo $employer_id; ?>"
                                   target="_blank">(View company profile)</a></h5>
                        <?php endif; ?>
                        <hr/>
                        <?php if (!empty($company_profile_and_business_operation)): ?>
                            <h5><strong>Company Profile</strong></h5>

                            <p>
                                <?php echo empty($company_profile_and_business_operation) ? "" : nl2br($company_profile_and_business_operation); ?>
                            </p>
                        <?php endif; ?>
                        <div class="jumbotron clearfix">
                            <h5><strong>Job Detail</strong></h5>
                            <table style="width: 100%">
                                <tr>
                                    <td style="50%">Date Posted :</td>
                                    <td style="50%"><?php the_date('d F, Y'); ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">Category :</td>
                                    <td style="50%"><?php
                                        $categories = get_the_category();
                                        $separator = ' ';
                                        $output = '';
                                        if ($categories) {
                                            foreach ($categories as $category) {
                                                $output .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $category->name)) . '">' . $category->cat_name . '</a>' . $separator;
                                            }
                                            echo trim($output, $separator);
                                        } ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">Job Type :</td>
                                    <td style="50%"><?php echo $job_type; ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">JLPT LEVEL :</td>
                                    <td style="50%"><?php echo $jlpt_level; ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">JOB LOCATION :</td>
                                    <td style="50%"><?php echo $job_location; ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">JAPANESE SKILLS :</td>
                                    <td style="50%"><?php echo $japanese_skill; ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">Salary :</td>
                                    <td style="50%"><?php echo is_numeric($salary) ? number_format($salary) : $salary; ?></td>
                                </tr>
                                <tr>
                                    <td style="50%">Working Day :</td>
                                    <td style="50%"><?php echo $working_day; ?></td>
                                </tr>
                            </table>
                        </div>

                        <h5><strong>Job Description</strong></h5>

                        <p>
                            <?php the_content(); ?>
                        </p>
                        <?php if ($qualification): ?>
                            <h5 class="margin-top-20"><strong>Qualification</strong></h5>

                            <p><?php echo nl2br($qualification); ?></p>
                        <?php endif; ?>
                        <h5 class="margin-top-20">
                            <strong>Contact</strong></h5>

                        <p>
                            <?php
                            echo empty($company_name) ? "" : $company_name . "<br/>";
                            echo empty($walfare_and_benefit) ? "" : nl2br($walfare_and_benefit) . "<br/>";
                            echo empty($apply_method) ? "" : nl2br($apply_method) . "<br/>";
                            echo empty($address) ? "" : nl2br($address) . "<br/>";
                            echo empty($tel) ? "" : "Tel. $tel<br/>";
                            echo empty($fax) ? "" : "Fax. $fax<br/>";
                            echo empty($empEmail) ? "" : "E-mail. $empEmail<br/>";
                            echo empty($website) ? "" : "Website: <a target='_blank' href='$website'>$website</a><br/>";
                            //E-mail. pattarat@bjc.co.th, kusumad@bjc.co.th-->
                            ?>
                        </p>

                        <div class="col-md-12 margin-top-20">
                            <?php if (!is_user_logged_in()): ?>
                                <a type="button" data-toggle="modal" data-target="#modal_choice_register"
                                   class="btn btn-default no-border col-md-2">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    apply now
                                </a>
                            <?php endif; ?>
                            <?php if ($userType == 'candidate'): ?>
                                <button type="button" id="applyNow" name="applyNow"
                                        class="btn btn-default no-border col-md-2">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    apply now
                                </button>
                                <button type="button" id="addFavorite" name="addFavorite"
                                        class="btn btn-default no-border col-md-2">
                                    <span class="glyphicon glyphicon-star"></span>
                                    add favorite
                                </button>
                                <a href="<?php echo get_site_url(); ?>/favorite-job" id="viewAllFavorite"
                                   name="viewAllFavorite"
                                   class="btn btn-default no-border col-md-2">
                                    <span class="glyphicon glyphicon-bookmark"></span>
                                    all favorite
                                </a>
                            <?php endif; ?>
                            <?php if ($directions): ?>
                                <button type="button" id="map" name="map"
                                        data-toggle="modal" data-target="#modal_map"
                                        class="btn btn-default no-border col-md-2">
                                    <span class="glyphicon glyphicon-map-marker"></span>
                                    map
                                </button>
                            <?php endif; ?>
                            <button type="button" id="print" name="print"
                                    data-toggle="modal" data-target="#modal_print"
                                    class="btn btn-default no-border col-md-2">
                                <span class="glyphicon glyphicon-print"></span>
                                print
                            </button>
                            <button type="button" id="share" name="share"
                                    data-toggle="modal" data-target="#modal_share"
                                    class="btn btn-default no-border col-md-2">
                                <span class="glyphicon glyphicon-share"></span>
                                share
                            </button>
                        </div>
                    </div>

                    <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png"
                         style="width: 100%; height: auto;"/>

                </div>

                <?php get_template_part("libs/pages/sidebar"); ?>
            </div>
        </div>

    </section>

    <div class="modal fade" id="modal_map" tabindex="-1" role="dialog"
         aria-labelledby="myModalMassage" aria-hidden="true"
         style="font-size: 12px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalMassage">
                        <span class="glyphicon glyphicon-map-marker"></span>Map</h4>
                </div>
                <div class="modal-body">
                    <?php if ($directions): ?>
                        <script
                            src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&language=th"></script>
                        <script type="text/javascript">
                            var geocoder = new google.maps.Geocoder();
                            var latitude = <?php echo $lat; ?>;
                            var longitude = <?php echo $long; ?>;
                            var lat_lng = new google.maps.LatLng(latitude, longitude);
                            var map;
                            var address_content = "";
                            function geocodePosition(pos) {
                                geocoder.geocode({
                                    latLng: pos
                                }, function (responses) {
                                    if (responses && responses.length > 0) {
                                        address_content = responses[0].formatted_address;
                                    } else {
                                        address_content = 'Cannot determine address at this location.';
                                    }
                                });
                            }
                            function initialize() {
                                var mapOptions = {
                                    scaleControl: true,
                                    center: new google.maps.LatLng(latitude, longitude),
                                    zoom: 14
                                };

                                map = new google.maps.Map(document.getElementById('mapCanvas'),
                                    mapOptions);

                                var marker = new google.maps.Marker({
                                    map: map,
                                    position: map.getCenter()
                                });
//                            var address = geocodePosition(marker.getPosition());
                                var infowindow = new google.maps.InfoWindow();
                                var linkFullMap = 'http://maps.google.com/?q=' + latitude + "," + longitude;
                                var contentMap = '<h4><?php echo empty($company_name) ? "" : $company_name; ?></h4>';
                                contentMap += "<br/><b>Address:</b> " + address_content + "<br/>" +
                                "<b>Position:</b> " + marker.getPosition() +
                                ' <a target="_blank" href="' +
                                linkFullMap + '" title="View full map">view</a>';
                                infowindow.setContent(contentMap);
                                google.maps.event.addListener(marker, 'click', function () {
                                    infowindow.open(map, marker);
                                });
                            }
                            geocodePosition(lat_lng);
                            google.maps.event.addDomListener(window, 'load', initialize);

                            $(document).ready(function () {
                                $('#modal_map').on('shown.bs.modal', function () {
                                    var currentCenter = map.getCenter();  // Get current center before resizing
                                    google.maps.event.trigger(map, "resize");
                                    map.setCenter(currentCenter); // Re-set previous center
                                });
                            })
                        </script>
                        <style>
                            #mapCanvas {
                                /*width: 500px;*/
                                height: 400px;
                                /*float: left;*/
                            }
                        </style>
                        <div id="mapCanvas" class="center"></div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_print" tabindex="-1" role="dialog"
         aria-labelledby="myModalMassage" aria-hidden="true"
         style="font-size: 12px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalMassage"><span class="glyphicon glyphicon-print"></span>Print
                    </h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_share" tabindex="-1" role="dialog"
         aria-labelledby="modal_share" aria-hidden="true"
         style="font-size: 12px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="modal_share"><span class="glyphicon glyphicon-share"></span>Share
                    </h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php if (!is_user_logged_in()): ?>

    <div class="modal fade" id="modal_choice_register" tabindex="-1" role="dialog"
         aria-labelledby="modal_choice_register" aria-hidden="true"
         style="font-size: 12px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="modal_choice_register">
                        <span class="glyphicon glyphicon-ok"></span>Apply for job
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-5 ">
                        <a class="col-md-12 btn btn-default" href="candidate-register/">Register</a>
                    </div>
                    <div class="col-md-2">
                        OR
                    </div>
                    <div class="col-md-5">
                        <a href="#" class="col-md-12 btn btn-default" data-toggle="modal"
                           data-target="#modal_none_member"
                           data-dismiss="modal">Apply Without Login</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/libs/css/jasny-bootstrap.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/jasny-bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/candidate-none-member.js"></script>

    <div class="modal fade" id="modal_none_member" tabindex="-1" role="dialog"
         aria-labelledby="modal_none_member" aria-hidden="true"
         style="font-size: 12px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="modal_none_member">
                        <span class="glyphicon glyphicon-paperclip"></span>Apply job for none member
                    </h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="frm_none_member" class="form-horizontal">
                        <input type="hidden" name="candidate_post" value="true">
                        <input type="hidden" name="post_type" value="none_member">
                        <input type="hidden" name="job_id" value="<?php echo $postID; ?>">
                        <input type="hidden" name="employer_id" value="<?php echo $employer_id; ?>">

                        <h5 class="bg-ddd padding-10 col-md-12">Resume</h5>

                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right">
                                <label for="attach_resume">Attach resume</label><br/>
                                <small>(size max. 5MB)</small>
                            </div>
                            <div class="col-md-8">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <span class="btn btn-default btn-file">
                                        <span class="fileinput-new"><span
                                                class="glyphicon glyphicon glyphicon-file"></span> Select file</span>
                                        <span class="fileinput-exists"><span
                                                class="glyphicon glyphicon glyphicon-file"></span> Change</span>
                                        <input type="file" name="attach_resume" id="attach_resume"
                                               accept="application/pdf">
                                    </span>
                                    <span class="fileinput-filename"></span>
                                    <a href="#" id="delete_file" class="close fileinput-exists" data-dismiss="fileinput"
                                       style="float: none">&times;</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="bg-ddd padding-10  col-md-12">Personal details</h5>

                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right ">
                                <label for="first_name">First Name</label><span class="font-color-red">*</span></div>
                            <div class="col-md-8">
                                <input type="text" id="first_name" name="first_name"
                                       class="form-control" required="" maxlength="50"/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right ">
                                <label for="last_name">Surname / Last Name</label>
                                <span class="font-color-red">*</span></div>
                            <div class="col-md-8">
                                <input type="text" id="last_name" name="last_name"
                                       class="form-control" required="" maxlength="50"/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right ">
                                <label for="nationality">Nationality</label>
                                <span class="font-color-red">*</span></div>
                            <div class="col-md-8">
                                <input type="text" id="nationality" name="nationality"
                                       class="form-control" required="" maxlength="50"/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right ">
                                <label for="county">Country</label>
                                <span class="font-color-red">*</span></div>
                            <div class="col-md-8">
                                <input type="text" id="county" name="county"
                                       class="form-control" required="" maxlength="50"/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right ">
                                <label for="province">Province</label>
                                <span class="font-color-red">*</span></div>
                            <div class="col-md-8">
                                <input type="text" id="province" name="province"
                                       class="form-control" required="" maxlength="50"/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right ">
                                <label for="district">District</label>
                                <span class="font-color-red">*</span></div>
                            <div class="col-md-8">
                                <input type="text" id="district" name="district"
                                       class="form-control" required="" maxlength="50"/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right ">
                                <label for="city">City / Locality</label>
                                <span class="font-color-red">*</span></div>
                            <div class="col-md-8">
                                <input type="text" id="city" name="city"
                                       class="form-control" required="" maxlength="50"/>
                            </div>
                        </div>
                        <h5 class="bg-ddd padding-10  col-md-12">Contact details</h5>

                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right ">
                                <label for="nm_email">Email</label>
                                <span class="font-color-red">*</span></div>
                            <div class="col-md-8">
                                <input type="text" id="nm_email" name="nm_email" class="form-control"
                                       maxlength="50"
                                       data-bv-emailaddress="true"
                                       required data-bv-emailaddress-message="The input is not a valid email address"
                                    />
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right ">
                                <label for="phone">Phone / Mobile</label>
                                <span class="font-color-red">*</span></div>
                            <div class="col-md-8">
                                <input type="text" id="phone" name="phone"
                                       class="form-control" required="" maxlength="50"/>
                            </div>
                        </div>
                        <h5 class="bg-ddd padding-10  col-md-12">Career profile</h5>

                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right ">
                                <label for="year_of_work_exp">Year of Work Exp.</label>
                                <span class="font-color-red">*</span></div>
                            <div class="col-md-8">
                                <input type="text" id="year_of_work_exp" name="year_of_work_exp"
                                       class="form-control" required=""
                                       placeholder="Year(s)" maxlength="5"/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right ">
                                <label for="last_position">Lasted Position</label>
                                <span class="font-color-red">*</span></div>
                            <div class="col-md-8">
                                <input type="text" id="last_position" name="last_position"
                                       class="form-control" required="" maxlength="50"/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right ">
                                <label for="last_industry">Lasted Industry</label>
                                <span class="font-color-red">*</span></div>
                            <div class="col-md-8">
                                <input type="text" id="last_industry" name="last_industry"
                                       class="form-control" required="" maxlength="50"/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-4 text-right ">
                                <label for="last_month_salary">Last Monthly Salary
                                </label>
                                <span class="font-color-red">*</span></div>
                            <div class="col-md-8">
                                <input type="text" id="last_month_salary" name="last_month_salary"
                                       class="form-control" required="" maxlength="20"/>
                            </div>
                        </div>

                        <div class="form-group col-md-12" style="">
                            <button type="submit" class="btn btn-primary col-md-6 pull-right">Submit
                            </button>
                            <a id="btn_reset_from" class="btn btn-default pull-right"
                               style="border: none;">
                                reset
                            </a>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
    <script>
        var is_job_favorite = <?php echo $isJobFavorite? "true": "false"; ?>;
        var is_job_apply = <?php echo $isJobApply ? "true": "false"; ?>;
        $(document).ready(function () {
            $("#addFavorite").click(function () {
                if (is_job_favorite) {
                    showModalMessage('<div class="font-color-4BB748"><p>Favorite Success.</p></div>',
                        "Message Job View");
                } else {
                    showImgLoading();
                    $.ajax({
                        type: "GET",
                        dataType: 'json',
                        url: '',
                        data: {
                            favorite: 'true',
                            favorite_type: 'job',
                            user_id: <?php echo $userID; ?>,
                            employer_id: <?php echo $employer_id; ?>,
                            id: <?php echo $postID; ?>,
                            is_favorite: 'true'
                        },
                        success: function (result) {
                            hideImgLoading();
                            showModalMessage(result.msg, "Message Job View");
                            if (!result.error) {
                                is_job_favorite = true;
                                $("#icon_fav").show();
                            }
                        }
                    })
                        .fail(function () {
                            hideImgLoading();
                            showModalMessage('<div class="font-color-BF2026"><p>Sorry Favorite Error.</p></div>',
                                "Message Job View");
                        });
                }
                return false;
            });

            $("#applyNow").click(function () {
                if (is_job_apply) {
                    showModalMessage('<div class="font-color-4BB748"><p>Apply Success.</p></div>',
                        "Message Job View");
                } else {
                    showImgLoading();
                    $.ajax({
                        type: "GET",
                        dataType: 'json',
                        url: '',
                        data: {
                            apply_post: 'true',
                            apply_type: 'job',
                            user_id: <?php echo $userID; ?>,
                            id: <?php echo $postID; ?>,
                            employer_id: <?php echo $employer_id; ?>,
                            is_apply: 'true'
                        },
                        success: function (result) {
                            hideImgLoading();
                            showModalMessage(result.msg, "Message Job View");
                            if (!result.error) {
                                is_job_apply = true;
                            }
                        }
                    })
                        .fail(function () {
                            hideImgLoading();
                            showModalMessage('<div class="font-color-BF2026"><p>Sorry Apply Error.</p></div>',
                                "Message Job View");
                        });
                }
                return false;
            });
        });
    </script>

<?php get_template_part("footer"); ?>