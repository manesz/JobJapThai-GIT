var check_from_post = false;
var post_id = 0;
$(function () {
    formValidate();
});

function setFeatureImage(elm) {
    if ($(elm).val() != '') {
        var formData = new FormData();
        formData.append('feature_image', $(elm)[0].files[0]);
        formData.append('post_job', 'true');
        formData.append('post_type', 'feature_image');
        formData.append('post_id', post_id);
        showImgLoading();
        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (result) {
                hideImgLoading();
                showModalMessage(result.msg, 'Message');
                if (!result.error) {
                    if (post_id == 0) {
                        post_id = result.post_id;
                        loadPostJob(result.post_id);
                    }
                    $('#frm_query_list_job').submit();
                }
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
}

function formValidate() {

    $("#form_post_job").bootstrapValidator({
        feedbackIcons: {
            message: 'This value is not valid',
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        }, excluded: [':disabled'],
        fields: {
//            salary: {
//                validators: {
//                    integer: {
//                        message: 'The value is not an number'
//                    }
//                }
//            }
        }})
        .on('success.form.bv', function (e) {
            if (!check_from_post) {
                // Prevent form submission
                e.preventDefault();

                // Get the form instance
                var $form = $(e.target);

                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');
                var data = $form.serialize();
//                data += "&" + data_for_post;
//                if (is_page_backend)
//                    data += "&post_backend=true";
                // Use Ajax to submit form data
                showImgLoading();
                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    cache: false,
                    url: url_post,
                    data: data,
                    success: function (result) {
                        hideImgLoading();
                        showModalMessage(result.msg, "Message Post Job");
                        if (!result.error) {
                            $('#frm_query_list_job').submit();
                            loadPostJob('');
                            post_id = result.post_id;
                        }
                    },
                    error: function (result) {
                        showModalMessage("Error:\n" + result.responseText);
                        hideImgLoading();
                        check_from_post = false;
                    }
                });
            }
            check_from_post = true;
        })
        .on('error.field.bv', function (e, data) {
            if (data.bv.getSubmitButton()) {
                data.bv.disableSubmitButtons(false);
            }
        })
        .on('success.field.bv',function (e, data) {
            if (data.bv.getSubmitButton()) {
                data.bv.disableSubmitButtons(false);
            }
        }).keypress(function (e) {
            if (e.keyCode == 13)
                return false;
        });
}

var check_delete_post_job = false;
function deletePostJob(postID) {
    if (check_delete_post_job)
        return;
    if (!confirm("คุณต้องการลบ Job ใช่หรือไม่"))
        return;
    showImgLoading();
    $.ajax({
        type: "GET",
        dataType: 'json',
        cache: false,
        url: url_post,
        data: {
            post_job: 'true',
            post_type: 'delete',
            post_id: postID
        },
        success: function (result) {
            hideImgLoading();
            showModalMessage(result.msg, "Message Post Job");
            check_delete_post_job = false;
            $('#frm_query_list_job').submit();
        },
        error: function (result) {
            hideImgLoading();
            showModalMessage("Error:\n" + result.responseText);
            check_delete_post_job = false;
        }
    });
    check_delete_post_job = true;
}

function loadPostJob(postID) {
    if (postID != '') {
        $("#head_text_edit_job").html("Edit Post Job");
    } else {
        $("#head_text_edit_job").html("Add New Post Job");
    }
    showImgLoading();
    var $frm = $("#form_post_job");
    $("#div_form_job").load(url_post + "?post_job=true&post_type=load_edit&post_id=" + postID, function () {
        $("#postTitle").focus();
        if (postID != '')
            post_id = postID;
        hideImgLoading();
        formValidate();
    })
}

function clearForm() {
//    var $frm = $("#form_post_job");
//    $("input[type=text], select, textarea", $frm).each(function () {
//            $(this).
//        });
}