<?php

if (is_user_logged_in()) {
    $isLogin = true;
    global $current_user;
    $userID = $current_user->ID;
    $displayName = $current_user->display_name;
    $userType = get_user_meta($userID, 'user_type', true);
    if ($userType == 'employer') {
        $urlEditResume = get_site_url() . "/edit-resume";
    } else if ($userType == "candidate") {
        $urlEditResume = get_site_url() . "/candidate";
    } else
        $urlEditResume = get_site_url() . "/wp-admin";
} else {
    $isLogin = false;
}
?>
<div class="clearfix"
     style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding-bottom: 10px; margin-bottom: 10px;">
    <div style="background: #BF2026; margin: 20px 0 10px 0; padding : 5px; color: #fff;">における求職者ログイン Job Seeker Log in
    </div>
    <?php if (!$isLogin): ?>
    <form action="<?php echo get_site_url(); ?>/apply-employer-register/" method="post"
        id="frm_sigin">
        <input type="hidden" name="sign_in_post" value="true">

        <div class="form-group clearfix" style="margin-bottom: 10px;">
            <label for="username" class="col-md-4" style="font-size: 12px; padding-right: 0px;">Email/Username
                :</label>

            <div class="col-md-8"><input id="username" name="username" class="form-control"></div>
        </div>
        <div class="form-group clearfix" style="margin-bottom: 10px;">
            <label for="password" class="col-md-4" style="font-size: 12px; padding-right: 0px;">Password :</label>

            <div class="col-md-8"><input id="password" name="password" type="password" class="form-control"></div>
        </div>

        <div class="form-group clearfix" style="margin-bottom: 10px;">
            <button type="submit" class="btn btn-success pull-right" style="margin-right: 15px;">Signin</button>
            <button type="button" class="btn btn-default pull-right" style="margin-right: 15px; border: none;">reset
            </button>
        </div>

        <hr/>

        <div class="form-group clearfix text-right" style="margin-bottom: 10px; padding-right: 15px;">
            <a href="#" data-toggle="modal" data-target="#modalRegister">register</a> /
            <a href="#" data-toggle="modal" data-target="#modalForget">forget username or password</a>
        </div>

    </form>
    <?php else:?>
        <div class="form-group clearfix" style="margin-bottom: 10px;">
            <label for="username" class="col-md-4" style="font-size: 12px; padding-right: 0px;">Hello! :</label>

            <div class="col-md-8"><a
                    href="<?php echo $urlEditResume; ?>"><?php echo $displayName; ?></a></div>
        </div>

        <hr/>

        <div class="form-group clearfix text-right" style="margin-bottom: 10px; padding-right: 15px;">
            <a class="btn btn-info" href="<?php echo wp_logout_url(home_url()); ?>" role="button">Logout</a>
        </div>
    <?php endif;?>
</div>
<script>
    $(document).ready(function(){
        $("#frm_sigin").submit(function(){
            alert(44)
            return false;
        });
    });
</script>