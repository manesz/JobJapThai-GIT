<?php
global $wpdb;
get_template_part("libs/front-banner");
$getKey = empty($_REQUEST['key']) ? "" : $_REQUEST['key'];
$authen = new Authentication($wpdb);
?>
<section class="container-fluid" style="margin-top: 10px;">

    <div class="container wrapper">
        <div class="row">
            <div class="col-md-12">

                <div class="clearfix"
                     style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                    <div class="col-md-12 border-bottom-1-ddd padding-bottom-10 margin-bottom-10">
                        <?php if (!$authen->checkUserByKey($getKey)): ?>
                            Sorry, can not find your link.
                        <?php
                        else:
                            $getUser = $authen->getUserByKey($getKey);
                            if ($authen->checkIsConfirm($getUser->ID)) {
                                ?>
                                Sorry, your link has been verified.
                            <?php
                            } else {
                                    $authen->updateActivationConfirm($getUser->ID);
                                ?>
                                You have verified your Email success. Thank You.<br/>
                                (Your verified Email is <?php echo $getUser->user_email; ?>)
                            <?php
                            }
                            ?>
                        <?php endif; ?>
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