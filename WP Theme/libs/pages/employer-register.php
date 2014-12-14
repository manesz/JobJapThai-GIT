<?php
if (is_user_logged_in()) {
    $classEmployer = new Employer($wpdb);
    global $current_user;
    get_currentuserinfo();
    $userID = $current_user->ID;
    $metaUser = get_user_meta($userID);
//    var_dump($metaUser);
    $arrayCompanyInfo = $classEmployer->getCompanyInfo($userID);
    $arrayPackage = $classEmployer->getPackage($userID);
    if ($arrayCompanyInfo) {
        extract((array)$arrayCompanyInfo[0]);
    }
//    var_dump($arrayCompanyInfo);

    $isLogin = true;
} else {
    $userID = 0;
    $isLogin = false;
    $current_user = null;
}

?>

<section class="container-fluid" style="margin-top: 10px;">
<script>
    var site_url = '<?php echo get_site_url(); ?>/';
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
<input type="hidden" id="employer_id" name="employer_id" value="<?php echo $userID; ?>">
<input type="hidden" id="employer_post" name="employer_post" value="true">
<input type="hidden" id="check_post" name="check_post"
       value="<?php echo $isLogin ? "edit" : "add"; ?>">
<h5 class="bg-ddd padding-10 clearfix">Username and Password</h5>


<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerUsername">Username<span
                class="font-color-red">*</span></label></div>
    <div class="col-md-10">
        <input type="text" class="form-control"
               maxlength="20"
               data-bv-stringlength="true"
               data-bv-stringlength-min="4"
               data-bv-message="The username is not valid" id="employerUsername" name="employerUsername"
               required data-bv-notempty-message="The username is required and cannot be empty"
               pattern="^[a-zA-Z0-9]+$" data-bv-regexp-message="The username can only consist of alphabetical, number"
               <?php if ($isLogin){ ?>disabled
               value="<?php echo $current_user->user_login; ?>"<?php } ?>/>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerEmail">Email<span
                class="font-color-red">*</span></label></div>
    <div class="col-md-10">
        <input type="email" id="employerEmail" name="employerEmail"
               class="form-control"
               <?php if ($isLogin){ ?>disabled
               value="<?php echo $current_user->user_email; ?>"<?php } ?>
               data-bv-emailaddress="true"
               required data-bv-emailaddress-message="The input is not a valid email address"/>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerPassword">Password<span
                class="font-color-red">*</span></label></div>
    <div class="col-md-10">
        <input type="password" id="employerPassword" name="employerPassword"
               class="form-control"
            <?php echo $isLogin ? '' : 'required'; ?>
               data-bv-stringlength="true"
               data-bv-stringlength-min="8"
               data-bv-identical="true"
               data-bv-identical-field="employerConfirmPassword"
               data-bv-identical-message="The password and its confirm are not the same"/>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerConfirmPassword">Confirm
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

    <div class="form-group col-md-12">
        <div class="col-md-2 text-right clearfix"><label for="employerSelectPackage">Select
                Package<span class="font-color-red">*</span></label></div>
        <div class="col-md-10">
            <select id="employerSelectPackage" name="employerSelectPackage" class="form-control">
                <option>---------------- Please select package ----------------</option>
            </select>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="col-md-2 text-right clearfix"><label for="employerSelectPeriod">Select
                Period<span class="font-color-red">*</span></label></div>
        <div class="col-md-10">
            <select id="employerSelectPeriod" name="employerSelectPeriod" class="form-control">
                <option>---------------- Please select period ----------------</option>
            </select>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="col-md-12"><input type="button" class="btn btn-primary col-md-12"
                                      value="Calculate Price" data-toggle="modal"
                                      data-target="#calForm"/></div>
    </div>
    <div class="clearfix"></div>
<?php endif; ?>

<!-- ----------------------------------------- Section : Company information for contact -->
<h5 class="bg-ddd padding-10 clearfix">Company information for contact</h5>

<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerContactPerson">Contact
            person</label></div>
    <div class="col-md-10">
        <input type="text" id="employerContactPerson" required
               value="<?php echo empty($contact_person) ? "" : $contact_person; ?>"
               name="employerContactPerson" class="form-control"/>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerContactCompanyName">Company
            name<span class="font-color-red">*</span></label></div>
    <div class="col-md-10">
        <input type="text" id="employerContactCompanyName"
               value="<?php echo empty($company_name) ? "" : $company_name; ?>"
               name="employerContactCompanyName" class="form-control"
               required/>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerContactBusinessType">Business
            Type<span class="font-color-red">*</span></label></div>
    <div class="col-md-10">
        <select id="employerContactBusinessType" name="employerContactBusinessType" required
                class="form-control">
            <option value="">---------------- Please select type ----------------</option>
            <option value="1" <?php if (isset($business_type)) echo $business_type == '1' ? "selected" : ""; ?>>Business
                type
            </option>
        </select>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerContactCompanyProfile">Company
            profile<br/>and business oparation</label></div>
    <div class="col-md-10">
        <textarea id="employerContactCompanyProfile"
                  name="employerContactCompanyProfile" class="form-control"
                  rows="10"><?php echo empty($company_profile_and_business_oparation) ?
                "" : $company_profile_and_business_oparation; ?></textarea>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerContactWalfare">Walfare and
            Benefit</label></div>
    <div class="col-md-10">
        <textarea id="employerContactWalfare" name="employerContactWalfare"
                  class="form-control" rows="10"><?php
            echo empty($walfare_and_benefit) ?
                "" : $walfare_and_benefit; ?></textarea>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerContactApplyMedtod">Apply
            method</label></div>
    <div class="col-md-10">
        <textarea id="employerContactApplyMedtod"
                  name="employerContactApplyMedtod" class="form-control"
                  rows="10"><?php
            echo empty($apply_method) ?
                "" : $apply_method; ?></textarea>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerContactAddress">Address <span
                class="font-color-red">*</span></label></div>
    <div class="col-md-10">
        <textarea id="employerContactAddress" name="employerContactAddress"
                  class="form-control" rows="10" required><?php
            echo empty($address) ?
                "" : $address; ?></textarea>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"></div>
    <div class="col-md-10">
        <div class="col-md-6">
            <input type="radio" id="employerContactCountryThailand" required
                   name="employerContactCountry" value="thailand" <?php
            if (isset($contact_country)) echo $contact_country == 'thailand' ? "checked" : "";
            ?>/>
            <label for="employerContactCountryThailand">Thailand</label>
        </div>
        <div class="col-md-6">
            <input type="radio" id="employerContactCountryOversea" required
                   name="employerContactCountry"
                   value="oversea" <?php
            if (isset($contact_country)) echo $contact_country == 'oversea' ? "checked" : "";
            ?>/>
            <label for="employerContactCountryOversea" class="text-left">Oversea</label>
        </div>
        <div class="col-md-12">
            <input type="checkbox" id="employerContactIndustrialPark"
                   name="employerContactIndustrialPark"
                   onclick="this.value=$(this).prop('checked')?1:0;"
                <?php if (isset($contact_industrial_park))
                    echo $contact_industrial_park ? 'checked value="1"' : 'value="0"'; ?>/>
            <label for="employerContactIndustrialPark">Within and industrial park</label>
        </div>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerContactProvince">Province<span
                class="font-color-red">*</span></label></div>
    <div class="col-md-10">
        <select id="employerContactProvince" name="employerContactProvince"
                class="form-control" required>
            <option value="">---------------- Please select ----------------</option>
            <option value="1" <?php if (isset($province)) echo $province == '1' ? "selected" : ""; ?>>กทม</option>
        </select>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerContactDistinct">District<span
                class="font-color-red">*</span></label></div>
    <div class="col-md-10">
        <select id="employerContactDistinct" name="employerContactDistinct"
                class="form-control" required>
            <option value="">---------------- Please select ----------------</option>
            <option value="1" <?php if (isset($district)) echo $district == '1' ? "selected" : ""; ?>>กทม</option>
        </select>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerContactSubDistinct">Sub
            district<span class="font-color-red">*</span></label></div>
    <div class="col-md-10">
        <select id="employerContactSubDistinct" name="employerContactSubDistinct"
                class="form-control" required>
            <option value="">---------------- Please select ----------------</option>
            <option value="1" <?php if (isset($sub_district)) echo $sub_district == '1' ? "selected" : ""; ?>>กทม
            </option>
        </select>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label
            for="employerContactPostcode">Postcode</label></div>
    <div class="col-md-10">
        <input type="text" id="employerContactPostcode" name="employerContactPostcode"
               class="form-control" required
               value="<?php echo empty($postcode) ? "" : $postcode; ?>"/>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerContactTel">Tel<span
                class="font-color-red">*</span></label></div>
    <div class="col-md-10">
        <input type="text" id="employerContactTel" name="employerContactTel"
               class="form-control"
               value="<?php echo empty($tel) ? "" : $tel; ?>" required/>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerContactFax">Fax</label></div>
    <div class="col-md-10">
        <input type="text" id="employerContactFax" name="employerContactFax"
               class="form-control"
               value="<?php echo empty($fax) ? "" : $fax; ?>"/>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label for="employerContactEmail">Email</label>
    </div>
    <div class="col-md-10">
        <input type="text" id="employerContactEmail" name="employerContactEmail"
               class="form-control"
               value="<?php echo empty($email) ? "" : $email; ?>"
               data-bv-emailaddress="true"
               data-bv-emailaddress-message="The input is not a valid email address"/>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label
            for="employerContactWebsite">Website</label></div>
    <div class="col-md-10">
        <input type="text" id="employerContactWebsite" name="employerContactWebsite"
               class="form-control"
               value="<?php echo empty($website) ? "" : $website; ?>"/>
    </div>
</div>
<div class="form-group col-md-12">
    <div class="col-md-2 text-right clearfix"><label
            for="employerContactDirections">Directions</label></div>
    <div class="col-md-10">
        <textarea id="employerContactDirections" name="employerContactDirections"
                  class="form-control" rows="10"><?php echo empty($directions) ? "" : $directions; ?></textarea>
    </div>
</div>
<div class="clearfix"></div>

<!-- ----------------------------------------- Section : Option for keep resume profile -->
<h5 class="bg-ddd padding-10 clearfix">Option for keep resume profile</h5>

<div class="form-group col-md-12">
    <?php
    if (isset($options)) {
        list($option1, $option2, $option3) = explode(',', $options);
    } else {
        list($option1, $option2, $option3) = array(0, 0, 0);
    }
    ?>
    <input type="checkbox" class="employerContactOption" id="option1"
           onclick="this.value=$(this).prop('checked')?1:0;"
        <?php echo $option1 ? 'checked value="1"': 'value="0"' ?>/> Store resume on
    Jobjapthai.com <span class="font-color-BF2026">(viewmore)</span><br/>
    <input type="checkbox" class="employerContactOption" id="option2"
           onclick="this.value=$(this).prop('checked')?1:0;"
        <?php echo $option2 ? 'checked value="1"': 'value="0"' ?>/> Receive resume in English
    only<br/>
    <input type="checkbox" class="employerContactOption" id="option3"
           onclick="this.value=$(this).prop('checked')?1:0;"
        <?php echo $option3 ? 'checked value="1"': 'value="0"' ?>/> Check this box to receive
    resume by Email in HTML format <span
        class="font-color-BF2026">(click to see sample)</span><br/>
    otherwise the resume will be send to you in plain text format <span
        class="font-color-BF2026">(click to see sample)</span>
</div>
<div class="clearfix"></div>
<hr/>

<div class="form-group col-md-12" style="">
    <div id="show_message"></div>
    <button type="submit" id="btn_submit" class="btn btn-primary col-md-6 pull-right">Submit</button>
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
<div class="modal fade" id="calForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     style="font-size: 12px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="bg-BF2026 font-color-fff padding-10" id="myModalLabel">Business Package</h4>

                <form class="clearfix">
                    <table style="width: 100%;">
                        <tr>
                            <td colspan="3"><h5>1. เลือกจำนวนตำแหน่ง และระยะเวลา</h5></td>
                        </tr>
                        <tr class="padding-bottom-10" style="">
                            <td class="col-md-3">
                                <label for="employerCalPositionAmount" class=" margin-top-10">จำนวนตำแหน่ง<span
                                        class="font-color-red">*</span></label><br/>
                                <label for="employerCalDuration" class=" margin-top-10">ระยะเวลา<span
                                        class="font-color-red">*</span></label>
                            </td>
                            <td class="col-md-7">
                                <select type="text" id="employerCalPositionAmount" name="employerCalPositionAmount"
                                        class="form-control margin-top-10">
                                    <option value="600">Business Package : 1 ตำแหน่งงาน</option>
                                    <option value="800">Business Package : 3 ตำแหน่งงาน</option>
                                </select>
                                <select type="text" id="employerCalDuration" name="employerCalDuration"
                                        class="form-control margin-top-10">
                                    <option value="1">2 สัปดาห์</option>
                                    <option value="2">1 เดือน</option>
                                    <option value="4">2 เดือน</option>
                                </select>
                            </td>
                            <td class="col-md-2"><span class="sumjobpack">600</span> บาท</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><h5>2. เลือกระยะเวลา <span class="font-color-BF2026">Super Hotjob</span>
                                </h5></td>
                        </tr>
                        <tr>
                            <td class="col-md-3">
                                <label for="employerCalSuperHotJobDuration">ระยะเวลา</label>
                            </td>
                            <td class="col-md-7">
                                <select id="employerCalSuperHotJobDuration" name="employerCalSuperHotJobDuration"
                                        class="form-control">
                                    <option value="0">--------------------</option>
                                    <option value="1500">3 วัน</option>
                                    <option value="1800">6 วัน</option>
                                </select>
                            </td>
                            <td class="col-md-2"><span class="superhotjobduration">0</span> บาท</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><h5>3. เลือกประเภท และระยะเวลาของ <span
                                        class="font-color-BF2026">Hotjob</span></h5></td>
                        </tr>
                        <tr>
                            <td class="col-md-3">
                                <label for="employerCalHotJobType" class="">ประเภท</label><br/><br/>
                                <label for="employerCalHotJobDuration" class="">ระยะเวลา</label>
                            </td>
                            <td class="col-md-7">
                                <select type="text" id="employerCalHotJobType" name="employerCalHotJobType"
                                        class="form-control margin-top-10">
                                    <option value="0" selected="selected">-----------------------</option>
                                    <option value="600">Business Package : 1 ตำแหน่งงาน</option>
                                    <option value="800">Business Package : 3 ตำแหน่งงาน</option>
                                </select>
                                <select type="text" id="employerCalHotJobDuration" name="employerCalHotJobDuration"
                                        class="form-control margin-top-10">
                                    <option value="1">2 สัปดาห์</option>
                                    <option value="2">1 เดือน</option>
                                    <option value="4">2 เดือน</option>
                                </select>
                            </td>
                            <td class="col-md-2"><span class="hotjobduration">0</span> บาท</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><h5>4. เลือกระยะเวลาของ <span class="font-color-BF2026">Urgent</span>
                                    (บนเว็บไซต์ และ Mobile Application)</h5></td>
                        </tr>
                        <tr>
                            <td class="col-md-3">
                                <label for="employerCalUrgentDuration" class="">ระยะเวลา</label>
                            </td>
                            <td class="col-md-7">
                                <select type="text" id="employerCalUrgentDuration" name="employerCalUrgentDuration"
                                        class="form-control margin-top-10">
                                    <option>---------------------</option>
                                </select>
                            </td>
                            <td class="col-md-2"> 0 บาท</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-10 text-right" colspan="2">Sub Total</td>
                            <td class="col-md-2"><span class="jj-allsum">600</span> บาท</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-10 text-right" colspan="2">+ Vat (7%)</td>
                            <td class="col-md-2"><span class="jj-taxsum">0</span> บาท</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-10 text-right" colspan="2"><strong>ยอดสุทธิ</strong></td>
                            <td class="col-md-2"><span class="jj-alltaxsum">0</span> บาท</td>
                        </tr>
                        <tr>
                            <td class="col-md-3"></td>
                            <td class="col-md-7"></td>
                            <td class="col-md-2"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_save">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var jshook = {
        jobpackage: 600,
        jobpackagedate: 1,
        superjobdate: 0,
        hotjobpackage: 0,
        hotjobpackagedate: 0,
        joppacksum: 0,
        joptax: 0,
        joppackallsum: 0,
        init: function () {
            jshook.updateVal();
            jshook.addEvent();
        },
        addEvent: function () {
            $('#employerCalPositionAmount').on('change', function () {
                jshook.jobpackage = $(this).val();
                jshook.updateVal();
                return false;
            });
            $('#employerCalDuration').on('change', function () {
                jshook.jobpackagedate = $(this).val();
                jshook.updateVal();
                return false;
            });
        },
        updateVal: function () {
            jshook.joppacksum = (jshook.jobpackage * jshook.jobpackagedate) + jshook.superjobdate + (jshook.hotjobpackage * jshook.hotjobpackagedate);
            jshook.joptax = jshook.joppacksum * 0.07;
            jshook.joppackallsum = jshook.joppacksum + jshook.joptax;
            $('.sumjobpack').text(jshook.formatDollar(jshook.jobpackage * jshook.jobpackagedate));
            $('.jj-allsum').text(jshook.formatDollar(jshook.joppacksum));
            $('.jj-taxsum').text(jshook.formatDollar(jshook.joptax));
            $('.jj-alltaxsum').text(jshook.formatDollar(jshook.joppackallsum));

        },
        formatDollar: function (num) {
            var p = num.toFixed(2).split(".");
            return p[0].split("").reverse().reduce(function (acc, num, i, orig) {
                return  num + (i && !(i % 3) ? "," : "") + acc;
            }, "") + "." + p[1];
        }
    };
</script>