<?php
global $current_user, $wpdb;
$isLogin = false;
$userID = 0;
if (is_user_logged_in()) {
    $classPackage = new Package($wpdb);
    get_currentuserinfo();
    $userID = $current_user->ID;
    $userType = get_user_meta($userID, 'user_type', true);
    if ($userType) {
        if ($userType == 'employer') {
            $isLogin = true;
        }
    }
}
if (!$isLogin) {
    wp_redirect(home_url());
    exit;
}
?>
<section class="container-fluid" style="margin-top: 10px;">

    <div class="container wrapper">
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
                    <?php if (is_user_logged_in()) {
                        include_once('emp_menu.php');
                    } ?>

                </div>

                <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png"
                     style="width: 100%; height: auto;"/>

            </div>
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
                <button type="button" class="btn btn-primary">Save changes</button>
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
                    return num + (i && !(i % 3) ? "," : "") + acc;
                }, "") + "." + p[1];
        }
    };
</script>