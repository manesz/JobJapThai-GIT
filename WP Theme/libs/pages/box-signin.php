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
              id="frm_sigin" class="form-horizontal">
            <input type="hidden" name="sign_in_post" value="true">

            <div class="form-group clearfix" style="margin-bottom: 10px;">
                <label for="username" class="col-md-4" style="font-size: 12px; padding-right: 0px;">Email/Username
                    :</label>

                <div class="col-md-8"><input id="username" name="username" required=""
                                             class="form-control"></div>
            </div>
            <div class="form-group clearfix" style="margin-bottom: 10px;">
                <label for="password" class="col-md-4" style="font-size: 12px; padding-right: 0px;">Password :</label>

                <div class="col-md-8"><input id="password" name="password" required=""
                                             type="password" class="form-control"></div>
            </div>

            <div class="form-group clearfix" style="margin-bottom: 10px;">
                <button type="submit" class="btn btn-success pull-right" style="margin-right: 15px;">Signin</button>
                <button type="button" class="btn btn-default pull-right" onclick="resetFormSigin();"
                        style="margin-right: 15px; border: none;">reset
                </button>
            </div>

            <hr/>

            <div class="form-group clearfix text-right" style="margin-bottom: 10px; padding-right: 15px;">
                <a href="#" data-toggle="modal" data-target="#modalRegister">register</a> /
                <a href="#" data-toggle="modal" data-target="#modalForget">forget username or password</a>
            </div>

        </form>
    <?php else: ?>
        <div class="form-group clearfix" style="margin-bottom: 10px;">
            <label for="username" class="col-md-4" style="font-size: 12px; padding-right: 0px;">Hello! :</label>

            <div class="col-md-8"><a
                    href="<?php echo $urlEditResume; ?>"><?php echo $displayName; ?></a></div>
        </div>

        <hr/>

        <div class="form-group clearfix text-right" style="margin-bottom: 10px; padding-right: 15px;">
            <a class="btn btn-info" href="<?php echo wp_logout_url(home_url()); ?>" role="button">Logout</a>
        </div>
    <?php endif; ?>
</div>
<script>
    function resetFormSigin() {
        $("#frm_sigin #username").val('');
        $("#frm_sigin #password").val('');
        $("#frm_sigin #username").focus();
        var $frm = $('#frm_sigin');
        $($frm).bootstrapValidator('revalidateField', 'username');
        $($frm).bootstrapValidator('revalidateField', 'password');
    }
    var check_sigin = false;
    $(document).ready(function () {
//        $("#frm_sigin").submit(function(){
//
////            return false;
//        });
        $('#frm_sigin').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }
        }).on('success.form.bv', function (e) {
            if (!check_sigin) {
                // Prevent form submission
                e.preventDefault();

                // Get the form instance
                var $form = $(e.target);

                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');
                var data = $form.serialize();
                // Use Ajax to submit form data
                showImgLoading();
                $.ajax({
                    type: "GET",
                    url: '',
                    cache: false,
                    dataType: 'json',
                    data: data,
                    success: function (result) {
                        hideImgLoading();
                        if (!result.error) {
//                            closeModalMessage();
                            showModalMessage('<div class="font-color-4BB748"><p>Log in success</p></div>', 'Log in');
//                            window.location.href = result.msg;
                            setTimeout(function () {
                                window.location.href = result.msg;
                            }, 2000);
                            return true;
                        }
                        showModalMessage(result.msg, 'Login Fail');
                        check_sigin = false;
                    },
                    error: function (result) {
                        showModalMessage("Error:\n" + result.responseText);
                        hideImgLoading();
                        check_sigin = false;
                    }
                });
            }
            check_sigin = true;
        })
            .on('error.field.bv', function (e, data) {
                if (data.bv.getSubmitButton()) {
                    data.bv.disableSubmitButtons(false);
                }
            })
            .on('success.field.bv', function (e, data) {
                if (data.bv.getSubmitButton()) {
                    data.bv.disableSubmitButtons(false);
                }
            });
    });
</script>