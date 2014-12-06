<?php

$objClassContact = new Contact($wpdb);
$arrayContact = $objClassContact->getContact(1);
if ($arrayContact) {
    extract((array)$arrayContact[0]);
}
$latitude = @$latitude ? $latitude : "13.7245995";
$longitude = @$longitude ? $longitude : "100.6331106";
$mapSrc = "http://maps.google.com/maps?z=12&t=m&q=loc:$latitude+-$longitude";
?>
<section class="container-fluid" style="margin-top: 10px;">

    <div class="container wrapper">
        <div class="row">
            <div class="col-md-12">
                <script>
                    function initialize() {
                        var myLatlng = new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>);
                        var myOptions = {
                            zoom: 15,
                            center: myLatlng,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                        var marker = new google.maps.Marker({
                            position: myLatlng,
                            map: map,
                            title:"JobJapThai"
                        });
                    }

                    function loadScript() {
                        var script = document.createElement("script");
                        script.type = "text/javascript";
                        script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&' +
                            'callback=initialize';
                        document.body.appendChild(script);
                    }

                    window.onload = loadScript;


                </script>
                <div id="map_canvas" class="content-wrapper no-padding" width="100%"
                     height="450" frameborder="0" style="border:0;height: 450px;">
                </div>

                <div class="clearfix content-wrapper" style="">

                    <div class="col-md-6">
                        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/nav-logo-big.png" class=""/>
                        <h4 class="font-color-BF2026 margin-top-20" style="">เกี่ยวกับทีมงานผู้ก่อตั้งเว็บไซต์
                            Jobjapthai.com</h4><?php if (have_posts()) : while (have_posts()) : the_post();
                            the_content(); endwhile; endif; ?>
                    </div>
                    <div class="col-md-6">
                        <form>
                            <div class="col-md-12 form-group">
                                <label for="contactSubject">Subject</label>
                                <select id="contactSubject" name="contactSubject" class="form-control">
                                    <option>----------------</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="contactName">Name</label>
                                <input type="text" id="contactName" name="contactName" class="form-control"/>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="contactEmail">Email</label>
                                <input type="email" id="contactEmail" name="contactEmail" class="form-control"/>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="contactPhone">Phone Number</label>
                                <input type="text" id="contactPhone" name="contactPhone" class="form-control"/>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="contactMessage">Message</label>
                                <textarea id="contactMessage" name="contactMessage" class="form-control"
                                          rows="10"></textarea>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="button" class="btn btn-success col-md-12" value="Submit"/>
                            </div>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>

</section>