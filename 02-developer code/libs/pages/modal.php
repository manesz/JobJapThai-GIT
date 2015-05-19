<!-- Modal -->
<div class="modal fade" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">What are you want to register.</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-6 btn">
                    <a href="<?php echo get_permalink(get_page_by_title('Seeking for Job Register')); ?>">Seeking for Job</a>
                </div>
                <div class="col-md-6 btn">
                    <a href="<?php echo get_permalink(get_page_by_title('Seeking for Manpower Register')); ?>">Seeking for Manpower</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalForget" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Are you forget username or password.</h4>
            </div>
            <div class="modal-body" id="lost_password">
                <div class="col-md-12">
                    <p class="message">Please enter your username or email address. You will receive a link to create a
                        new password via email.</p>
                    <div id="message_lost_password"></div>
                    <form name="lostpasswordform" id="lostpasswordform"
                          action="<?php echo wp_lostpassword_url(); ?>" method="post">
                        <input type="hidden" name="user-cookie" value="1" />
                        <input type="hidden" name="reset_pass" value="1" />
                        <p>
                            <label for="user_login">Username or E-mail:<br>
                                <input type="text" onkeypress="$('#message_lost_password').html('');"
                                       name="user_login" id="user_login" class="form-control" value=""
                                       size="20"></label>
                        </p>
                        <p class="submit"><input type="submit" name="wp-submit" id="wp-submit"
                                                 class="btn btn-default" value="Get New Password">
                        </p>
                    </form>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_show_message" tabindex="-1" role="dialog"
     aria-labelledby="myModalMassage" aria-hidden="true"
     style="font-size: 12px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalMassage">Error</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_candidate_profile" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Seeking for Job Profile</h4>
            </div>
            <div class="modal-body" id="body_candidate_profile">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END: Modal -->