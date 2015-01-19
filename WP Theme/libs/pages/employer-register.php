<?php
if (is_user_logged_in()) {
    global $current_user, $wpdb;
    get_currentuserinfo();
    $userID = $current_user->ID;
    $single = true;
    $userType = get_user_meta($userID, 'user_type', $single);
    $dataEmployer = null;
    $classEmployer = new Employer($wpdb);
    if ($userType) {
        $isLogin = true;
        if ($userType == 'employer') {
            $metaUser = get_user_meta($userID);
            $arrayCompanyInfo = $classEmployer->getCompanyInfo(0, $userID);
            if ($arrayCompanyInfo) {
                extract((array)$arrayCompanyInfo[0]);
                $dataEmployer = (array)$arrayCompanyInfo[0];
            }
        } else if ($userType == 'candidate') {
            $isLogin = false;
        }
        $classPackage = new Package($wpdb);
//        $arrayPackage = $classPackage->getPackage();
//        $arraySelectPackage = $classPackage->getSelectPackage($userID);
//        var_dump($arraySelectPackage);
    } else {
        $isLogin = false;
    }

} else {
    $userID = 0;
    $isLogin = false;
    $current_user = null;
}
?>

<section class="container-fluid" style="margin-top: 10px;">
    <script>
        var site_url = '<?php echo get_site_url(); ?>/';
        var is_login = <?php echo $isLogin? "true": "false"; ?>;
    </script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/employer-register.js"></script>

    <div class="container wrapper">
        <!--<div class="form-group">-->
        <div class="row">
            <div class="col-md-12">

                <div class="clearfix"
                     style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                    <h5 class="pull-left" style="">
                        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png"
                             style="height: 25px;"/>
                        お知らせ
                        <span class="font-color-BF2026" style=""><?php the_title() ?></span>
                    </h5>

                    <div class="clearfix" style="margin-top: 20px;"></div>
                    <form action="<?php echo get_site_url(); ?>/apply-employer-register/" method="post"
                          id="frm_employer_register" class="form-horizontal"
                          data-bv-message="This value is not valid"
                          data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                          data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                          data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                        <!-- ---------------------------------------------------------------- Section : username -->
                        <?php if ($isLogin) {
                            include_once('emp_menu.php');
                        }?>
                        <input type="hidden" name="employer_id" value="<?php echo $userID; ?>">
                        <input type="hidden" name="employer_post" value="true">
                        <input type="hidden" name="post_type"
                               value="<?php echo $isLogin ? "edit" : "add"; ?>">
                        <h5 class="bg-ddd padding-10 clearfix">Username and Password</h5>


                        <div class="form-group col-md-12">
                            <div class="col-md-2 text-right clearfix"><label for="employerUsername">Username<span
                                        class="font-color-red">*</span></label></div>
                            <div class="col-md-10">
                                <?php if ($isLogin): ?>
                                    <span class="form-control"><?php echo $current_user->user_login; ?></span>
                                <?php else: ?>
                                    <input type="text" class="form-control"
                                           maxlength="20"
                                           data-bv-stringlength="true"
                                           data-bv-stringlength-min="4"
                                           data-bv-message="The username is not valid" id="employerUsername"
                                           name="employerUsername"
                                           required
                                           data-bv-notempty-message="The username is required and cannot be empty"
                                           pattern="^[a-zA-Z0-9]+$"
                                           data-bv-regexp-message="The username can only consist of alphabetical, number"/>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-2 text-right clearfix"><label for="employerEmail">Email<span
                                        class="font-color-red">*</span></label></div>
                            <div class="col-md-10">

                                <?php if ($isLogin): ?>
                                    <span class="form-control"><?php echo $current_user->user_email; ?></span>
                                <?php else: ?>
                                    <input type="email" id="employerEmail" name="employerEmail"
                                           class="form-control"
                                           data-bv-emailaddress="true"
                                           required
                                           data-bv-emailaddress-message="The input is not a valid email address"/>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-2 text-right clearfix">
                                <label for="employerPassword"><?php echo $isLogin ? "Old " : ""; ?>Password<span
                                        class="font-color-red">*</span></label></div>
                            <div class="col-md-10">
                                <input type="password" id="employerPassword" name="employerPassword"
                                       class="form-control"
                                    <?php echo $isLogin ? '' : 'required'; ?>
                                       data-bv-stringlength="true"
                                       data-bv-stringlength-min="8"/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-2 text-right clearfix">
                                <label for="employerConfirmPassword"><?php echo $isLogin ? "New" : "Confirm"; ?>
                                    password<span class="font-color-red">*</span></label></div>
                            <div class="col-md-10">
                                <input type="password"
                                       id="employerConfirmPassword"
                                       name="employerConfirmPassword" class="form-control"
                                    <?php echo $isLogin ? '' : 'required'; ?>
                                       data-bv-stringlength="true"
                                       data-bv-stringlength-min="8"
                                       data-bv-identical="true"
                                       data-bv-identical-field="employerPassword"
                                       data-bv-identical-message="The password and its confirm are not the same"/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <?php if ($isLogin): ?>
                            <!-- ----------------------------------------------------------------- Section : package -->
                            <h5 class="bg-ddd padding-10 clearfix">Package</h5>
                            <div id="list_package">

                                <!--        <div class="form-group col-md-12">-->
                                <!--            <div class="col-md-2 text-right clearfix"><label for="employerSelectPackage">Select-->
                                <!--                    Package<span class="font-color-red">*</span></label></div>-->
                                <!--            <div class="col-md-10">-->
                                <!--                <select id="employerSelectPackage" name="employerSelectPackage" class="form-control">-->
                                <!--                    <option>---------------- Please select package ----------------</option>-->
                                <!--                </select>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <div class="form-group col-md-12">-->
                                <!--            <div class="col-md-2 text-right clearfix"><label for="employerSelectPeriod">Select-->
                                <!--                    Period<span class="font-color-red">*</span></label></div>-->
                                <!--            <div class="col-md-10">-->
                                <!--                <select id="employerSelectPeriod" name="employerSelectPeriod" class="form-control">-->
                                <!--                    <option>---------------- Please select period ----------------</option>-->
                                <!--                </select>-->
                                <!--            </div>-->
                                <!--        </div>-->
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-12">
                                    <input type="button" class="btn btn-primary col-md-12"
                                           value="New Package" data-toggle="modal" id="new_package"
                                           data-target="#modal_package"/>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        <?php endif; ?>

                        <!-- ----------------------------------------- Section : Company information for contact -->
                        <h5 class="bg-ddd padding-10 clearfix">Company information for contact</h5>


                        <?php echo $classEmployer->buildHtmlCompanyInfo($dataEmployer); ?>

                        <div class="form-group col-md-12" style="">
                            <div id="show_message"></div>
                            <button type="submit" id="btn_submit" class="btn btn-primary col-md-6 pull-right">Submit
                            </button>
                            <button type="reset" class="btn btn-default pull-right" style="border: none;">Reset</button>
                        </div>

                    </form>

                </div>

                <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png"
                     style="width: 100%; height: auto;"/>

            </div>
            <!--</div>-->
        </div>
    </div>

</section>

<!-- Modal -->
<div class="modal fade" id="modal_package" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true"
     style="font-size: 12px;">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
<style type="text/css">
    #aupher-select {
        display: none
    }

    #distinct-select {
        display: none
    }
</style>
<script type="text/javascript">
    var employer_id = <?php echo $userID; ?>;
    var ajaxPageurl = '<?php echo get_home_url() ?>/';
    var ajaxDropurl = '<?php echo get_template_directory_uri() . '/libs/ajax'; ?>/';
    var distinct = <?php echo empty($district) ? 0: $district; ?>;
    var sub_district = <?php echo empty($sub_district) ? 0: $sub_district; ?>;
    var proselect = {
        proval: 0,
        amval: 0,
        init: function () {
            proselect.proval = $('#employerContactProvince').val();
            proselect.selectProvince();
            proselect.setEvent();
        },
        setEvent: function () {
            $('#employerContactProvince').on('change', proselect.selectProvince);
        },
        selectProvince: function () {
            proselect.proval = $('#employerContactProvince').val();
            proselect.clearampporSelect();
            $('#aupher-select').slideUp('fast', function () {
                if (proselect.proval !== '0') {
                    $.getJSON(ajaxPageurl + '?adminPage=getamphor&type=provice', {proid: proselect.proval}, function (data) {
                        if (typeof data['hasfile'] === 'undefined') {
                            proselect.createSelect(data);
                            $('#aupher-select').slideDown('fast');
                        } else {
                            $.getJSON(ajaxDropurl + 'amphur/' + proselect.proval + '.json', function (data) {
                                proselect.createSelect(data);
                                $('#aupher-select').slideDown('fast');
                            });
                        }
                    });
                }
            });

        },
        createSelect: function (data) {
            $.each(data, function (index, dat) {
                var checkSelect = dat.AMPHUR_ID == distinct ? 'selected' : '';
                var mytxt = '<option value="' + dat.AMPHUR_ID + '" ' + checkSelect + '>' +
                    dat.AMPHUR_NAME + '</option>';
                $('#employerContactDistinct').append(mytxt);
            });
            if ($('#employerContactDistinct').html()) {
                proselect.selectAmphor();
            }
            $('#employerContactDistinct').unbind('change');
            $('#employerContactDistinct').on('change', proselect.selectAmphor);
        },
        clearampporSelect: function () {
            $('#employerContactDistinct option[value!=0]').remove();
            $('#employerContactDistinct').val(0);
            proselect.clearDistinctSelect();
        },
        clearDistinctSelect: function () {
            $('#employerContactSubDistinct option[value!=0]').remove();
            $('#employerContactSubDistinct').val(0);
            $('#distinct-select').css('display', 'none');
        },
        selectAmphor: function () {
            proselect.amval = $('#employerContactDistinct').val();
            proselect.clearDistinctSelect();
            $('#distinct-select').slideUp('fast', function () {
                if (proselect.amval != '0') {
                    $.getJSON(ajaxPageurl + '?adminPage=getamphor&type=amphur', {amid: proselect.amval}, function (data) {
                        if (typeof data['hasfile'] === 'undefined') {
                            proselect.createDistinctSelect(data);
                            $('#distinct-select').slideDown('fast');
                        } else {
                            $.getJSON(ajaxDropurl + 'district/' + proselect.amval + '.json', function (data) {
                                proselect.createDistinctSelect(data);
                                $('#distinct-select').slideDown('fast');
                            });
                        }
                    });
                }
            });
        },
        createDistinctSelect: function (data) {//console.log(data);
            $.each(data, function (index, dat) {
                var checkSelect = dat.DISTRICT_ID == sub_district ? 'selected' : '';
                var mytxt = '<option value="' + dat.DISTRICT_ID + '" ' + checkSelect + '> ' + dat.DISTRICT_NAME + '</option>';
                $('#employerContactSubDistinct').append(mytxt);
            });
        }
    };
    $(document).ready(function () {
        proselect.init();
        <?php if ($isLogin): ?>
        showListPackage();
        <?php endif;?>
    });
</script>