/**
 * Created by Administrator on 13/12/2557.
 */
var check_from_post = false;
$(document).ready(function () {
    $("#frm_none_member").bootstrapValidator({
        feedbackIcons: {
            message: 'This value is not valid',
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        }, excluded: [':disabled'],
        fields: {
            year_of_work_exp: {
                validators: {
                    integer: {
                        message: 'The value is not an number'
                    }
                }
            },
            last_month_salary: {
                validators: {
                    integer: {
                        message: 'The value is not an number'
                    }
                }
            },
            attach_resume: {
                validators: {
                    file: {
                        type: 'application/pdf',
                        maxSize: 5 * 1024 * 1024,
                        message: 'The selected file is not valid or check maximum size.!'
                    }
                }
            }
        }
    })
        .on('success.form.bv', function (e) {
            if (!check_from_post) {
                // Prevent form submission
                e.preventDefault();

                // Get the form instance
                var $form = $(e.target);

                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');
                //var data = $form.serialize();
                //
                var attach_resume = $("#attach_resume")[0].files[0];
                //data += "&attach_resume=" + attach_resume;


                var formData = new FormData();
                formData.append("attach_resume", attach_resume);
                $("input", $form).each(function(i) {
                    formData.append($(this).attr("name"), $(this).val());
                });

                $("select", $form).each(function(i) {
                    formData.append($(this).attr("name"), $(this).val());
                });
                // Use Ajax to submit form data
                showImgLoading();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    url: url_post,
                    data: formData,
                    success: function (result) {
                        hideImgLoading();
                        if (!result.error) {
                            $('#modal_none_member').modal('hide');
                            resetForm();
                        }
                        showModalMessage(result.msg, "Message");
                        check_from_post = false;
                    },
                    error: function (result) {
                        showModalMessage("Error:\n" + result.responseText, "Error");
                        hideImgLoading();
                        check_from_post = false;
                    }
                });
                //$.ajax({
                //    type: "GET",
                //    dataType: 'json',
                //    cache: false,
                //    url: url_post,
                //    data: data,
                //        success: function (result) {
                //            hideImgLoading();
                //            if (!result.error) {
                //                $('#modal_none_member').modal('hide');
                //                resetForm();
                //            }
                //            showModalMessage(result.msg, "Message");
                //            check_from_post = false;
                //        },
                //        error: function (result) {
                //            alert("Error:\n" + result.responseText);
                //            hideImgLoading();
                //            check_from_post = false;
                //        }
                //    });
            }
            check_from_post = true;
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
        }).keypress(function (e) {
            if (e.keyCode == 13)
                return false;
        });

    $("#btn_reset_from").click(function () {
        resetForm();
    });
});

function resetForm() {
    var $frm = $("#frm_none_member");
    $($frm).closest('form').find('input[type=text], input[type=file], textarea, select').val('');
    $("#delete_file").click();


    $("input[type=text], input[type=file], select, textarea", $frm).each(function () {
        if ($(this).attr("required"))
            $($frm).bootstrapValidator('revalidateField', this.id);
    });

}
