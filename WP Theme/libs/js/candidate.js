/**
 * Created by Administrator on 13/12/2557.
 */
var data_for_post = $.param({
    candidate_post: 'true',
    post_type: 'add'
});
var check_from_post = false;
var check_education_post = false;
var check_work_experience_post = false;
var index_post = 1;
$(document).ready(function () {
    $("#form_candidate_step1, .form_candidate").bootstrapValidator({
        feedbackIcons: {
            message: 'This value is not valid',
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        }, excluded: [':disabled'],
        fields: {
            employment_period_from: {
                validators: {
                    regexp: {
                        regexp: /^(0[1-9]|1[012])[\-\/.](\d{4})$/,
                        message: 'The value is not a valid'
                    }
                }
            },
            employment_period_to: {
                validators: {
                    regexp: {
                        regexp: /^(0[1-9]|1[012])[\-\/.](\d{4})$/,
                        message: 'The value is not a valid'
                    }
                }
            },
            expect_month_salary: {
                validators: {
                    integer: {
                        message: 'The value is not an number'
                    }
                }
            },
            expect_month_salary: {
                validators: {
                    integer: {
                        message: 'The value is not an number'
                    }
                }
            },
            month_salary: {
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
            toeic_toefl_ielts_score: {
                validators: {
                    integer: {
                        message: 'The value is not an number'
                    }
                }
            },
            year_of_work_exp: {
                validators: {
                    integer: {
                        message: 'The value is not an number'
                    }
                }
            },
            date_of_birth: {
                validators: {
                    date: {
                        format: 'DD/MM/YYYY',
                        message: 'The value is not a valid date'
                    }
                }
            },
            start_date: {
                validators: {
                    date: {
                        format: 'DD/MM/YYYY',
                        message: 'The value is not a valid date'
                    }
                }
            },
            education_period_from: {
                validators: {
                    date: {
                        trigger: 'change keyup',
                        format: 'DD/MM/YYYY',
                        message: 'The value is not a valid date'
                    }
                }
            },
            education_period_to: {
                validators: {
                    date: {
                        format: 'DD/MM/YYYY',
                        message: 'The value is not a valid date'
                    }
                }
            }
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
                data += "&" + data_for_post;
                // Use Ajax to submit form data
//                alert(data);return;
                showImgLoading();
                $.ajax({
                    type: "POST",
                    url: '',
                    data: data,
                    success: function (result) {
                        if (!is_login) {
                            showModalMessage(result, "Message Add Candidate");
                            window.location.reload();
                        }
                        else {
                            showModalMessage(result, "Message Edit Candidate");
                        }

                        if (check_education_post) {
                            getEducation();
//                            $("#panel_education").find('input[type=text], textarea').val('');
//                            $('#panel_education:input[type=text]:first').select();
                        }
                        if (check_work_experience_post) {
                            getWorkExperience();
//                            $("#panel_work_experience").find('input[type=text], textarea').val('');
//                            $('#panel_work_experience:input[type=text]:first').select();
                        }

                        check_from_post = false;
                        check_education_post = false;
                        check_work_experience_post = false;
                        hideImgLoading();
                    },
                    error: function (result) {
                        alert("Error:\n" + result.responseText);
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

    $('.datepicker')
        .on('changeDate', function (e) {
            var $frm = $(this).closest('form');
            // Revalidate the date when user change it
            if ($(this).attr("required"))
                $($frm).bootstrapValidator('revalidateField', this.id);
        });

    $(".tab_panel").click(function () {
        index_post = $(this).index(".tab_panel") + 1;
    });

    $(".btn_submit_form").click(function () {
//        var $frm = $('#form_candidate' + index_post);
        switch (index_post) {
            case 1:
                data_for_post = $.param({
                    candidate_post: 'true',
                    post_type: 'edit_information',
                    candidate_id: candidate_id,
                    information_id: information_id
                });
                break;
            case 2:
                data_for_post = $.param({
                    candidate_post: 'true',
                    post_type: 'edit_career_profile',
                    candidate_id: candidate_id,
                    career_profile_id: career_profile_id
                });
                 break;
            case 3:
                data_for_post = $.param({
                    candidate_post: 'true',
                    post_type: 'edit_desired_job',
                    candidate_id: candidate_id,
                    desired_job_id: desired_job_id
                });
                 break;
            case 6:
                data_for_post = $.param({
                    candidate_post: 'true',
                    post_type: 'edit_skill_languages',
                    candidate_id: candidate_id,
                    skill_languages_id: skill_languages_id
                });
                 break;
        }
    });
    $("#btn_add_education").click(function () {
        data_for_post = $.param({
            candidate_post: 'true'
        });
        check_education_post = true;
    });
    $("#btn_add_work_experience").click(function () {
        data_for_post = $.param({
            candidate_post: 'true'
        });
        check_work_experience_post = true;
    });

    $('.btn_reset_from').click(function () {
        var $frm = $('#form_candidate' + index_post);
        $frm.find(':input[type=text]:not([type=hidden]), textarea').val('');
        $frm.find('input:first').focus().select();
        $("input[type=text], select, textarea", $frm).each(function () {
            if ($(this).attr("required"))
                $($frm).bootstrapValidator('revalidateField', this.id);
        });
    });

    if (is_login) {
        getEducation();
        getWorkExperience();
    }
});

function getEducation() {
    showImgLoading();
    $.ajax({
        type: "POST",
        url: '',
        data: {
            candidate_post: 'true',
            post_type: 'get_education',
            candidate_id: candidate_id
        },
        success: function (result) {
            $("#education_list").html(result);
            hideImgLoading();
        },
        error: function (result) {
            alert("Error:\n" + result.responseText);
            hideImgLoading();
        }
    });
}

function getWorkExperience() {
    showImgLoading();
    $.ajax({
        type: "POST",
        url: '',
        data: {
            candidate_post: 'true',
            post_type: 'get_work_experience',
            candidate_id: candidate_id
        },
        success: function (result) {
            $("#work_experience_list").html(result);
            hideImgLoading();
        },
        error: function (result) {
            alert("Error:\n" + result.responseText);
            hideImgLoading();
        }
    });
}

function educationSetValue(data) {
    $("#education_id").val(data.id);
    $("#degree").val(data.degree);
    $("#university").val(data.university);
    $("#education_period_from").val(data.education_period_from);
    $("#education_period_to").val(data.education_period_to);
    $("#grade_gpa").val(data.grade_gpa);

    $("#btn_cancel_education").show();
    $("#btn_add_education").val('Edit Education');
    $("#form_candidate4 #post_type").val('edit_education');

    var $frm = $("#form_candidate4");
    $("input[type=text], select, textarea", $frm).each(function () {
        if ($(this).attr("required"))
            $($frm).bootstrapValidator('revalidateField', this.id);
    });
}

function workExperienceSetValue(data) {
    $("#work_experience_id").val(data.id);
    $("#employment_period_from").val(data.employment_period_from);
    $("#employment_period_to").val(data.employment_period_to);
    $("#company_name").val(data.company_name);
    $("#position").val(data.position);
    $("#month_salary").val(data.month_salary);
    $("#job_duties").val(data.job_duties);

    $("#btn_cancel_work_experience").show();
    $("#btn_add_work_experience").val('Edit work_experience');
    $("#form_candidate5 #post_type").val('edit_work_experience');

    var $frm = $("#form_candidate5");
    $("input[type=text], select, textarea", $frm).each(function () {
        if ($(this).attr("required"))
            $($frm).bootstrapValidator('revalidateField', this.id);
    });
}

function resetPanelEducationValue(type) {
    var $frm = $("#form_candidate4");
    $($frm).closest('form').find('input[type=text], textarea').val('');
    if (type == 'cancel') {
        $('#form_candidate4 #post_type').val('add_education');
        $('#btn_add_education').val('Add Education');
    }
    $("input[type=text], select, textarea", $frm).each(function () {
        if ($(this).attr("required"))
            $($frm).bootstrapValidator('revalidateField', this.id);
    });
}

function resetPanelWorkExperienceValue(type) {
    var $frm = $("#form_candidate5");
    $($frm).closest('form').find('input[type=text], textarea').val('');
    if (type == 'cancel') {
        $('#form_candidate5 #post_type').val('add_work_experience');
        $('#btn_add_work_experience').val('Add Work Experience');
    }
    $("input[type=text], select, textarea", $frm).each(function () {
        if ($(this).attr("required"))
            $($frm).bootstrapValidator('revalidateField', this.id);
    });
}