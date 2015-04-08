<?php
global $current_user, $wpdb;
$userID = $current_user->ID;
$classEmployer = new Employer($wpdb);
$classCandidate = new Candidate($wpdb);
$classFavorite = new Favorite($wpdb);
$classApply = new Apply($wpdb);
$classViewProfile = new ViewProfile($wpdb);
$employer_id = empty($_REQUEST['id']) ? false : $_REQUEST['id'];
if ($employer_id):
    $getDataCompany = $employer_id ? $classEmployer->getCompanyInfo(0, $employer_id) : false;
//    var_dump($getDataCompany);
if ($getDataCompany):
    if ($getDataCompany) {
        extract((array)$getDataCompany[0]);
        $empEmail = $getDataCompany[0]->email;
    }

    if (is_user_logged_in()) {
        $isCompanyFavorite = $classFavorite->checkCompanyIsFavorite($userID, $employer_id);
        $isCompanyApply = $classApply->checkCompanyIsApply($userID, $employer_id);
        $userType = get_user_meta($userID, 'user_type', true);

        $classViewProfile->addViewEmployer($userID, $employer_id);
    } else {
        $isCompanyFavorite = false;
        $isCompanyApply = false;
    }
    $isAdmin = current_user_can('manage_options');

    $getLogo = $classEmployer->getLogoPath($employer_id);
    $getBanner = $classEmployer->getBannerPath($employer_id);


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
    <?php endif; ?><?php if ($getBanner['have_image']): ?>
        <img src="<?php echo $getBanner['path']; ?>"
             style="width: 100%"/>
    <?php endif; ?>
    <?php if ($getLogo['have_image']): ?>
    <img src="<?php echo $getLogo['path']; ?>"
         style="width: 100%"/>

    <h4 class="font-color-BF2026 clearfix" style="">
        <span class="pull-left"><?php echo empty($company_name) ? "" : $company_name; ?></span>
                            <span class="pull-right">
                                    <i class="glyphicon glyphicon-star font-color-BF2026" id="icon_fav" style="<?php
                                    //if ($userType == "employer") {
                                    if (!$isCompanyFavorite) {
                                        echo 'display: none;';
                                    }
                                    //}
                                    ?>"></i>
                                <?php if ($userID == $employer_id): ?>
                                    <a class="btn btn-warning" style="background: #BF2026; border: none;"
                                       href="<?php echo home_url(); ?>/edit-profile/">Edit</a>
                                <?php endif; ?>
                            </span>
    </h4>
    <hr/>
    <table style="width: 100%">
        <tr>
            <td style="width: 30%">Company Website:</td>
            <td style="width: 70%"><?php echo empty($website) ? "" : "<a target='_blank'
                                    href='$website'>$website</a>"; ?></td>
        </tr>
        <tr>
            <td style="width: 30%">Address:</td>
            <td style="width: 70%"><?php echo empty($address) ? "" : $address; ?></td>
        </tr>
        <tr>
            <td style="width: 30%">Tel:</td>
            <td style="width: 70%"><?php echo empty($tel) ? "" : $tel; ?></td>
        </tr>
        <tr>
            <td style="width: 30%">Fax:</td>
            <td style="width: 70%"><?php echo empty($fax) ? "" : $fax; ?></td>
        </tr>
        <tr>
            <td style="width: 30%">Email:</td>
            <td style="width: 70%"><?php echo empty($empEmail) ? "" : $empEmail; ?></td>
        </tr>
        <tr>
            <td style="width: 30%">Contact:</td>
            <td style="width: 70%"><?php echo empty($contact_person) ? "" : $contact_person; ?></td>
        </tr>
        <?php if ($directions): ?>
            <tr>
                <td style="width: 100%" colspan="2">
                    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&language=th"></script>
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
                </td>
            </tr>
        <?php endif; ?>
    </table>
    <hr/>
    <h5><strong>Company Profile</strong></h5>

    <p>
        <?php echo empty($company_profile_and_business_operation) ? "" : nl2br($company_profile_and_business_operation); ?>
    </p>
    <hr/>
    <h5 class="font-color-BF2026">All Job List</h5>

    <div class="col-md-12 border-bottom-1-ddd no-padding"
         style="padding-bottom: 10px !important;">
        <form>
            <div class="col-md-3 no-padding">
                <span class="pull-left">Positions</span>
                <select id="searchList" class="pull-left form-control">
                    <option>10</option>
                    <option>50</option>
                    <option>100</option>
                    <option>All</option>
                </select>
            </div>
            <div class="col-md-push-6 col-md-3 no-padding">
                <span class="pull-right">Sort by</span><br/>
                <select id="searchSort" class="pull-right form-control col-md-3">
                    <option>Last Update</option>
                    <option>Company Name</option>
                    <option>Less to more competitive jobs</option>
                    <option>More to less competitive jobs</option>
                </select>
            </div>
        </form>
    </div>
    <?php
    $argc = array(
        'post_type' => 'job',
//                                        'category_name' => 'highlight-jobs',
        //'orderby' => 'date', //name of category by slug
        //'order' => 'ASC',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        'meta_query' => array(
            array(
                'key' => 'employer_id',
                'value' => $employer_id,
                'compare' => '='
            )

        ),
    );
    $loopJobs = new WP_Query($argc);
    if ($loopJobs->have_posts()):
        ?>
        <ul class="job-list no-padding">
            <?php while ($loopJobs->have_posts()) :
                $loopJobs->the_post();
                $postID = get_the_id();
                $url = wp_get_attachment_url(get_post_thumbnail_id($postID));
                if (empty($url)) {
                    $thumbnail = get_template_directory_uri() . "/libs/img/blank-logo.png";
                } else {
                    $thumbnail = $url;
                }
                $customField = get_post_custom($postID);
                $job_type = empty($customField["job_type"][0]) ? '' : $customField["job_type"][0];
                $job_location = empty($customField["job_location"][0]) ? '' : $customField["job_location"][0];
                $employer_id = empty($customField["employer_id"][0]) ? '' : $customField["employer_id"][0];
                $getDataCompany = $employer_id ? $classEmployer->getCompanyInfo(0, $employer_id) : false;
                $company_name = $getDataCompany ? $getDataCompany[0]->company_name : "";
                ?>
                <li class="clearfix border-bottom-1-ddd padding-top-10 padding-bottom-10">
                    <div class="col-md-12">
                        <div class="col-md-2" style="padding: 0px">
                            <a href="<?php the_permalink(); ?>" target="_blank"><img
                                    src="<?php echo $thumbnail; ?>"
                                    style="width: 100%;"/></a>
                        </div>
                        <div class="col-md-8">
                            <h5 class="font-color-BF2026">
                                <a href="<?php the_permalink(); ?>"
                                   target="_blank"><?php the_title(); ?></a>
                            </h5>
                            <?php echo empty($company_name) ? "" : $company_name; ?><br/>
                            <?php echo empty($job_type) ? "" : $job_type; ?><br/>
                        </div>
                        <div class="col-md-2">
                            <br/><?php the_date('M d, Y'); ?><br/>
                            <?php echo empty($job_location) ? "" : $job_location; ?><br/>
                        </div>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>

    <?php
    if (is_user_logged_in()): ?>
        <div class="col-md-12 margin-top-20">

            <?php if ($userType == 'candidate' || $isAdmin): ?>
                <!--                                    <button type="button" id="applyNow" name="applyNow"-->
                <!--                                            class="btn btn-default no-border col-md-2">-->
                <!--                                        <span class="glyphicon glyphicon-ok"></span>-->
                <!--                                        apply now-->
                <!--                                    </button>-->
                <button type="button" id="addFavorite" name="addFavorite"
                        class="btn btn-default no-border col-md-2">
                    <span class="glyphicon glyphicon-star"></span>
                    add favorite
                </button>
                <!--                                    <button type="button" id="viewAllFavorite" name="viewAllFavorite"-->
                <!--                                            class="btn btn-default no-border col-md-2">-->
                <!--                                        <span class="glyphicon glyphicon-folder-open"></span>-->
                <!--                                        all favorite-->
                <!--                                    </button>-->
            <?php endif; ?>
            <!--                                    <button type="button" id="map" name="map"-->
            <!--                                            class="btn btn-default no-border col-md-2">-->
            <!--                                        <span class="glyphicon glyphicon-map-marker"></span>-->
            <!--                                        map-->
            <!--                                    </button>-->
            <!--                                    <button type="button" id="print" name="print"-->
            <!--                                            class="btn btn-default no-border col-md-2">-->
            <!--                                        <span class="glyphicon glyphicon-print"></span>-->
            <!--                                        print-->
            <!--                                    </button>-->
            <button type="button" id="share" name="share"
                    class="btn btn-default no-border col-md-2">
                <span class="glyphicon glyphicon-share"></span>
                share
            </button>
        </div>
    <?php endif; ?>
    </div>

    <?php require_once("banner1.php"); ?>

    </div>

    <?php get_template_part("libs/pages/sidebar"); ?>
    </div>
    </div>

    </section>

    <script>
        var is_company_favorite = <?php echo $isCompanyFavorite? "true": "false"; ?>;
        var is_company_apply = <?php echo $isCompanyApply ? "true": "false"; ?>;
        $(document).ready(function () {
            $("#addFavorite").click(function () {
                if (is_company_favorite) {
                    showModalMessage('<div class="font-color-4BB748"><p>Favorite Success.</p></div>',
                        "Message Job View");
                } else {
                    showImgLoading();
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: '',
                        data: {
                            favorite: 'true',
                            favorite_type: 'company',
                            user_id: <?php echo $userID; ?>,
                            id: <?php echo $employer_id; ?>,
                            is_favorite: 'true'
                        },
                        success: function (result) {
                            hideImgLoading();
                            showModalMessage(result.msg, "Message Job View");
                            if (!result.error) {
                                is_company_favorite = true;
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
                if (is_company_apply) {
                    showModalMessage('<div class="font-color-4BB748"><p>Apply Success.</p></div>',
                        "Message Job View");
                } else {
                    showImgLoading();
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: '',
                        data: {
                            apply_post: 'true',
                            apply_type: 'company',
                            user_id: <?php echo $userID; ?>,
                            id: <?php echo $employer_id; ?>,
                            is_apply: 'true'
                        },
                        success: function (result) {
                            hideImgLoading();
                            showModalMessage(result.msg, "Message Job View");
                            if (!result.error)
                                is_company_apply = true;
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
<?php endif; ?>
<?php endif; ?>
