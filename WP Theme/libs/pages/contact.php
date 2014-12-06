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
                        <?php $_SESSION['captcha_contact_us'] = contact_us_captcha();?>
                        <form id="form_contact_us" method="post">
                            <div class="col-md-12 form-group">
                                <label for="send_subject">Subject</label>
                                <select id="send_subject" name="send_subject" class="form-control">
                                    <option>----------------</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="send_name">Name</label>
                                <input type="text" id="send_name" name="send_name" class="form-control"
                                       maxlength="50"/>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="send_email">Email</label>
                                <input type="email" id="send_email" name="send_email" class="form-control"
                                    maxlength="50"/>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="send_phone_number">Phone Number</label>
                                <input type="text" id="send_phone_number" name="send_phone_number"
                                       maxlength="50"
                                       class="form-control"/>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="send_message">Message</label>
                                <textarea id="send_message" name="send_message" class="form-control"
                                          rows="10"></textarea>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="security_code">Security Code</label>
                                <input type="text" class="form-control" placeholder=""
                                       id="security_code" name="security_code" autocomplete="off">
                                <img class="" src="<?php echo $_SESSION['captcha_contact_us']['image_src']; ?>"/>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="submit" class="btn btn-success col-md-12" value="Submit"/>
                            </div>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>

</section>
<script>

    var send_mail_contact_us = false;
    $(document).ready(function () {
        /*
         var defaults = {
         containerID: 'toTop', // fading element id
         containerHoverID: 'toTopHover', // fading element hover id
         scrollSpeed: 1200,
         easingType: 'linear'
         };
         */
        $("#form_contact_us").submit(function () {
            var $this = this;
            if (send_mail_contact_us)
                return false;

            var charCheck = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            var checkEmail = charCheck.test(this.send_email.value);
            if ($this.send_subject.value == "") {
                alert("Please add your subject.");
                $this.send_subject.focus();
            } else if ($this.send_name.value == "") {
                alert("Please add your name.");
                $this.send_name.focus();
            } else if ($this.send_email.value == "" || !checkEmail) {
                alert("Please add your email.");
                $this.send_email.focus();
            } else if ($this.send_message.value == "" ) {
                alert("Please add your message.");
                $this.send_message.focus();
            } else if ($this.security_code.value == "") {
                alert("Please add security code.");
                $this.security_code.focus();
            } else {
                var data = $($this).serialize();
                data = data + '&' + $.param({
                    send_email_contact_us: 'true'
                });
                showImgLoading();
                send_mail_contact_us = true;
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: '',
                    data: data,
                    success: function (result) {
                        if (result == 'error_captcha') {
                            alert("Please check security code.");
                            $this.security_code.focus();
                        }else if(result == 'success') {
                            alert("Send success.\nThank you.");
                            window.location.reload();
                        } else {
                            alert(result);
                        }
                        send_mail_contact_us = false;
                        hideImgLoading();
                    }
                })
                    .done(function () {
                        //alert("second success");
                    })
                    .fail(function () {
                        alert("เกิดข้อผิดพลาด");
                        hideImgLoading();
                    })
                    .always(function () {
                        //alert("finished");
                    });
            }
            return false;
        });
    });
</script>