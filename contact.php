<?php include_once("header.php"); ?>
<?php include_once("nav.php"); ?>

<?php $page = "news"; ?>


    <section class="container-fluid" style="margin-top: 10px;">

        <div class="container wrapper">
            <div class="row">
                <div class="col-md-12">

                    <iframe class="content-wrapper no-padding" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13.7245995!2d100.6331106,!3d13.8035017!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e2936f0aafe361%3A0x381b7b2c31e605ad!2z4LiW4LiZ4LiZIOC4l-C4suC4h-C4q-C4peC4p-C4h-C4iuC4meC4muC4lyDguJnguITguKPguJvguJDguKEgNDAwNiDguJXguLPguJrguKUg4Lio4Liy4Lil4Liy4Lii4LiyIOC4reC4s-C5gOC4oOC4rSDguJ7guLjguJfguJjguKHguJPguJHguKUg4LiI4Lix4LiH4Lir4Lin4Lix4LiUIOC4meC4hOC4o-C4m-C4kOC4oSA3MzE3MCDguJvguKPguLDguYDguJfguKjguYTguJfguKI!5e0!3m2!1sth!2s!4v1406316348876" width="100%" height="450" frameborder="0" style="border:0"></iframe>

                    <div class="clearfix content-wrapper" style="">

                        <div class="col-md-6">
                            <img src="libs/img/nav-logo-big.png" class=""/>
                            <h4 class="font-color-BF2026 margin-top-20" style="">เกี่ยวกับทีมงานผู้ก่อตั้งเว็บไซต์ Jobjapthai.com</h4>
                            <p>
                                JobJapThai Co., Ltd.<br/>
                                1 Infinite Loop Cupertino, CA 95014<br/>
                                Tel. +6686 627 0681<br/>
                                contact@jobjapthai.com
                            </p>
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
                                    <textarea id="contactMessage" name="contactMessage" class="form-control" rows="10"></textarea>
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

<?php include_once("footer.php"); ?>