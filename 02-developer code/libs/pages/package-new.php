<?php
if (is_user_logged_in()) {
    global $current_user;
    get_currentuserinfo();
    $packageID = empty($_GET['package_id']) ? 0 : $_GET['package_id'];
    $userID = empty($_GET['user_id']) ? 0 : $_GET['user_id'];
    if (!$userID) {
        $userID = $current_user->ID;
    }
    $classPackage = new Package($wpdb);
    $arrayPackage = $classPackage->getPackage();
    $arraySelectPackage = $packageID ? $classPackage->getSelectPackage($userID, $packageID) : null;
    $strSelectPackage = $packageID ? $arraySelectPackage[0]->string_package : '';
    $isApprove = $packageID ? $arraySelectPackage[0]->approve : '';
} else {
    echo "Please Login";
    exit;
}
?>

<form method="post" id="frm_package">
    <div class="modal-body">
        <h4 class="bg-BF2026 font-color-fff padding-10" id="myModalLabel">Business Package</h4>

        <div class="clearfix" id="frm_package">
            <input type="hidden" id="employer_id" name="employer_id" value="<?php echo $userID; ?>">
            <input type="hidden" id="package_id" name="package_id" value="<?php echo $packageID; ?>">
            <input type="hidden" id="select_package" name="select_package" value="">
            <input type="hidden" id="post_package" name="post_package" value="true">
            <input type="hidden" id="type_post" name="type_post"
                   value="<?php echo $packageID ? 'edit' : 'add'; ?>"/>
            <table style="width: 100%;">
                <?php
                $saveName = "";
                $savePosition = 0;
                foreach ($arrayPackage as $key => $value):

                    ?>

                    <?php if ($savePosition != $value->position && $key != 0): ?>
                    <tr>
                        <td colspan="3">
                            <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                        </td>
                    </tr>
                <?php endif; ?>
                    <?php if ($savePosition != $value->position):
                    $strHeader = "";
                    $strTitle = "";
                    $countName = 0;
                    switch ($value->position) {
                        case 1:
                            $strHeader = "เลือกจำนวนตำแหน่ง";
                            $countName = 1;
                            break;
                        case 2:
                            $strHeader = 'เลือกระยะเวลา';
                            $countName = 2;
                            break;
                        case 3:
                            $strHeader = 'เลือกจำนวน <span
                    class="font-color-BF2026">Hotjob</span>';
                            $countName = 3;
                            break;
                        case 4:
                            $strHeader = 'เลือกระยะเวลาของ <span
                    class="font-color-BF2026">Auto Update</span>';
                            $countName = 4;
                            break;
                    }
                    switch ($value->position) {
                        case 1:
                            $strTitle = "จำนวนตำแหน่ง";
                            break;
                        case 2:
                            $strTitle = 'ระยะเวลา';
                            break;
                        case 3:
                            $strTitle = 'จำนวนตำแหน่ง';
                            break;
                        case 4:
                            $strTitle = 'ระยะเวลา';
                            break;
                    }
                    ?>
                    <tr>
                        <td colspan="3"><h5><?php echo "$countName. $strHeader"; ?></h5></td>
                    </tr>
                    <tr class="padding-bottom-10" style="">
                        <?php echo $classPackage->buildTd1($arrayPackage, $value->position, $strTitle); ?>
                        <?php echo $classPackage->buildTd2($arrayPackage, $value->position, $strSelectPackage); ?>
                        <?php echo $classPackage->buildTd3($arrayPackage, $value->position); ?>
                    </tr>
                <?php endif; ?>

<?php
//            $saveName = $value->name;
                    $savePosition = $value->position;
                endforeach; ?>

                <tr>
                    <td colspan="3">
                        <div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div>
                    </td>
                </tr>
                <!--
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
                -->
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
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?php if (!$isApprove): ?>
            <button type="submit" class="btn btn-primary" id="btn_save">Save changes</button>
        <?php endif; ?>
    </div>
</form>
<script>
    <?php if($isApprove): ?>
    $('select').prop('disabled', 'disabled');
    <?php endif; ?>

    <?php echo $classPackage->buildJsArrayPrice($arrayPackage); ?>
    var jsHookCalPackage = {
        <?php echo $classPackage->buildJsParameter($arrayPackage); ?>

        jopPackSum: 0,
        jopTax: 0,
        jopPackAllSum: 0,
        init: function () {
            jsHookCalPackage.updateVal();
            jsHookCalPackage.addEvent();
//            proselect.init();
        },
        addEvent: function () {
            <?php echo $classPackage->buildJsEvent($arrayPackage); ?>
        },
        updateVal: function () {
            jsHookCalPackage.jopPackSum = <?php echo $classPackage->buildJsCalValue($arrayPackage); ?>;
            jsHookCalPackage.jopTax = jsHookCalPackage.jopPackSum * 0.07;
            jsHookCalPackage.jopPackAllSum = jsHookCalPackage.jopPackSum + jsHookCalPackage.jopTax;

            <?php echo $classPackage->buildJsSumValue($arrayPackage); ?>

            $('.jj-allsum').text(jsHookCalPackage.formatDollar(jsHookCalPackage.jopPackSum));
            $('.jj-taxsum').text(jsHookCalPackage.formatDollar(jsHookCalPackage.jopTax));
            $('.jj-alltaxsum').text(jsHookCalPackage.formatDollar(jsHookCalPackage.jopPackAllSum));

            jsHookCalPackage.addStringPackage();
        },
        addStringPackage: function () {
            var strSelectPackage = <?php echo $classPackage->buildJsStrSelectPackage($arrayPackage); ?>;
            $("#select_package").val(strSelectPackage);
        },
        formatDollar: function (num) {
            var p = num.toFixed(2).split(".");
            return p[0].split("").reverse().reduce(function (acc, num, i, orig) {
                    return num + (i && !(i % 3) ? "," : "") + acc;
                }, "") + "." + p[1];
        }
    };
    /*var jsHookCalPackage = {
     jobpackage: 600,
     jobpackagedate: 1,
     superjobdate: 0,
     hotjobpackage: 0,
     hotjobpackagedate: 0,
     joppacksum: 0,
     joptax: 0,
     joppackallsum: 0,
     init: function () {
     jsHookCalPackage.updateVal();
     jsHookCalPackage.addEvent();
     proselect.init();
     },
     addEvent: function () {
     $('#employerCalPositionAmount').on('change', function () {
     jsHookCalPackage.jobpackage = $(this).val();
     jsHookCalPackage.updateVal();
     return false;
     });
     $('#employerCalDuration').on('change', function () {
     jsHookCalPackage.jobpackagedate = $(this).val();
     jsHookCalPackage.updateVal();
     return false;
     });
     },
     updateVal: function () {
     jsHookCalPackage.joppacksum = (jsHookCalPackage.jobpackage * jsHookCalPackage.jobpackagedate) + jsHookCalPackage.superjobdate + (jsHookCalPackage.hotjobpackage * jsHookCalPackage.hotjobpackagedate);
     jsHookCalPackage.joptax = jsHookCalPackage.joppacksum * 0.07;
     jsHookCalPackage.joppackallsum = jsHookCalPackage.joppacksum + jsHookCalPackage.joptax;
     $('.sumjobpack').text(jsHookCalPackage.formatDollar(jsHookCalPackage.jobpackage * jsHookCalPackage.jobpackagedate));
     $('.jj-allsum').text(jsHookCalPackage.formatDollar(jsHookCalPackage.joppacksum));
     $('.jj-taxsum').text(jsHookCalPackage.formatDollar(jsHookCalPackage.joptax));
     $('.jj-alltaxsum').text(jsHookCalPackage.formatDollar(jsHookCalPackage.joppackallsum));

     },
     formatDollar: function (num) {
     var p = num.toFixed(2).split(".");
     return p[0].split("").reverse().reduce(function (acc, num, i, orig) {
     return  num + (i && !(i % 3) ? "," : "") + acc;
     }, "") + "." + p[1];
     }
     };*/
    var check_post_package = false;
    $(document).ready(function () {
        jsHookCalPackage.init();
        $("#frm_package").submit(function () {
            if (!check_post_package) {
                showImgLoading();
                $.ajax({
                    type: "POST",
                    url: '',
                    data: $(this).serialize(),
                    success: function (result) {
                        if (result != 'success') {
                            alert(result);
                        } else {
                            showListPackage();
                            $('#modal_package').modal('hide');

                            $(".modal-backdrop").remove();
                        }
                        hideImgLoading();
                        check_post_package = false;
                    },
                    error: function (result) {
                        alert("Error:\n" + result.responseText);
                        hideImgLoading();
                        check_post_package = false;
                    }
                });
            }
            check_post_package = true;
            return false;
        });
    });
</script>