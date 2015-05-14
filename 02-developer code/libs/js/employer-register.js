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
 type: "GET",
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
var is_page_backend = false;
$(document).on("click", ".edit_package", function (e) {
    var packageID = $(this).attr('data');
    showAddPackage(packageID);
});

$(document).ready(function () {
    showListPackage();
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
                dataType: 'json',
                cache: false,
                type: "GET",
                url: $form.attr('action'),
                data: data,
                success: function (result) {
                    hideImgLoading();
                    showModalMessage(result.msg, "Message Employer");
                    if (!is_login && !result.error) {
                        if (!is_page_backend)
                            setTimeout(function () {
                                window.location.href = url_post + "register-success/?mail_confirm=" +
                                    $("#employerEmail").val()
                            }, 3000);
                        else $("#btn_success").show();
                    }
                },
                error: function (result) {
                    showModalMessage(result.responseText, "Error");
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

    $('#employer_image').change(function () {
        if ($(this).val() != '') {
            var formData = new FormData();
            formData.append('logo_image', $(this)[0].files[0]);
            formData.append('employer_post', 'true');
            formData.append('post_type', 'logo_image');
            formData.append('employer_id', user_id);
            showImgLoading();
            $.ajax({
                url: '',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (result) {
                    showModalMessage(result.msg, 'Message');
                    path_avatar = result.path;
                    hideImgLoading();
                },
                error: function (result) {
                    showModalMessage(result.responseText, 'Message');
                    hideImgLoading();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });

    $('#banner_image').change(function () {
        if ($(this).val() != '') {
            var formData = new FormData();
            formData.append('image_banner', $(this)[0].files[0]);
            formData.append('employer_post', 'true');
            formData.append('post_type', 'image_banner');
            formData.append('employer_id', user_id);
            showImgLoading();
            $.ajax({
                url: '',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (result) {
                    showModalMessage(result.msg, 'Message');
//                    path_avatar = result.path;
                    hideImgLoading();
                },
                error: function (result) {
                    showModalMessage(result.responseText, 'Message');
                    hideImgLoading();
                },
                cache: false,
                contentType: false,
                processData: false
            });

        }
    });
});

function removeAvatarImage($elm) {
    showImgLoading();
    $.ajax({
        dataType: 'json',
        cache: false,
        type: "GET",
        url: '',
        data: {
            employer_post: 'true',
            post_type: 'delete_avatar',
            employer_id: user_id
        },
        success: function (result) {
            hideImgLoading();
            showModalMessage(result.msg, "Message Employer");
            if (!result.error) {
                $($elm).addClass('fileinput-exists');
            }
        },
        error: function (result) {
            showModalMessage(result.responseText, "Error");
            hideImgLoading();
        }
    });
}

function removeBannerImage($elm) {
    showImgLoading();
    $.ajax({
        dataType: 'json',
        cache: false,
        type: "GET",
        url: '',
        data: {
            employer_post: 'true',
            post_type: 'delete_banner',
            employer_id: user_id
        },
        success: function (result) {
            hideImgLoading();
            showModalMessage(result.msg, "Message Employer");
            if (!result.error) {
                $($elm).addClass('fileinput-exists');
            }
        },
        error: function (result) {
            showModalMessage(result.responseText, "Error");
            hideImgLoading();
        }
    });
}

function showAddPackage(package_id, user_id) {
    package_id = package_id | false;
    user_id = user_id | false;
    var strUrl = "?new_package=true";
    strUrl += package_id ? "&package_id=" + package_id + "&user_id=" + user_id: "&user_id=" + user_id;
    $(".modal-content").load(strUrl);
}

function showListPackage() {
    $("#list_package").load("?list_package=true");
}