/**
 * Created by Administrator on 13/12/2557.
 */
/*
 $(document).ready(function() {
 $('#frm_employer_register').bootstrapValidator();
 });
 $(document).on("click", "#btn_save", function (e) {
 var frm = $('#frm_employer_register');
 var data = frm.serialize();
 var url = frm.attr('action');
 showImgLoading();
 //    alert(url);
 $.ajax({
 type: "POST",
 url: url,
 data: data,
 success: function (result) {
 if (result != 'success') {
 scrollToTop();
 $("#show_message").html(result);
 } else {
 alert(result);
 }
 hideImgLoading();
 },
 error: function (result) {
 alert("Error:\n" + result.responseText);
 hideImgLoading();
 }
 });
 });
 */
//$(document).on("submit", "#frm_employer_register", function (e) {
//    //$("#btn_save").click();
//    var data = $(this).serialize();
//    var ids = [];
//    $('.employerContactOption').each(function(i, e) {
//        ids.push($(this).val());
//    });
//    data = data + "&employerContactOption=" + ids;
//    alert(data);
//    return false;
//});

$(document).on("click", ".edit_package", function (e) {
    var packageID = $(this).attr('data');
    showAddPackage(packageID);
});

$(document).ready(function () {
    $('#frm_employer_register')
        .bootstrapValidator()
        .on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            var data = $form.serialize();
            var ids = [];
            $('.employerContactOption').each(function (i, e) {
                ids.push($(this).val());
            });
//            data = data + "&employerContactOption=" + ids;
            data += "&" + $.param({
                employerContactOption: ids
            });
            // Use Ajax to submit form data
            showImgLoading();
            $.ajax({
                type: "POST",
                url: $form.attr('action'),
                data: data,
                success: function (result) {
                    if (!is_login) {
                        showModalMessage(result, "Message Add Candidate");
                        window.location.href = site_url + "edit-resume";
                    }
                    else {
                        showModalMessage(result, "Message Edit Candidate");
                    }
                    hideImgLoading();
                },
                error: function (result) {
                    alert("Error:\n" + result.responseText);
                    hideImgLoading();
                }
            });
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

    $("#new_package").click(function () {
        showAddPackage();
    });
});

function showAddPackage(package_id) {
    package_id = package_id | false;
    var strUrl = ajaxPageurl + "?new_package=true";
    strUrl += package_id ? "&package_id=" + package_id : "";
    $(".modal-content").load(strUrl);
}

function showListPackage() {
    $("#list_package").load(ajaxPageurl + "?list_package=true");
}