<?php
get_template_part("libs/front-banner");
$getEmail = empty($_REQUEST['mail_confirm']) ? "" : $_REQUEST['mail_confirm'];

?>
<section class="container-fluid" style="margin-top: 10px;">

    <div class="container wrapper">
        <div class="row">
            <div class="col-md-12">

                <div class="clearfix"
                     style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                    <div class="col-md-12 border-bottom-1-ddd padding-bottom-10 margin-bottom-10">
                        You have verified your Email as log in. Please enter "Email&Password" to log in.<br/>
                        (Your verified Email is <?php echo $getEmail; ?>)
                    </div>
                    <div class="col-md-12 border-bottom-1-ddd padding-bottom-10 margin-bottom-10">
                        <a class="btn" href="<?php echo home_url(); ?>">Go to Log in</a>
                    </div>
                    <div class="clearfix" style="margin-top: 20px;"></div>
                </div>

            </div>
            <div class="col-md-8">
                <?php get_template_part("libs/pages/banner2"); ?>
            </div>
            <div class="col-md-4">
                <?php get_template_part("libs/pages/banner3"); ?>
            </div>
        </div>
    </div>

</section>