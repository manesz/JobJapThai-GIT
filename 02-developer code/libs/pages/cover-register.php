<?php
//include_once("header.php");
global $wpdb;
$classCandidate = new Candidate($wpdb);
$classOthSetting = new OtherSetting($wpdb);
?>
<style type="text/css">.panel-default>.panel-heading{background-color:#BE2026;color:#fff}</style>
<script>
    var check_from_post = false;
    $(document).ready(function () {
        $("#form_candidate").bootstrapValidator({
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
                    var data = $form.serialize();
//                    data += "&" + data_for_post;
//                    if (is_page_backend)
//                        data += "&post_backend=true";
                    // Use Ajax to submit form data
//                alert(data);return;
                    showImgLoading();
                    $.ajax({
                        type: "GET",
                        dataType: 'json',
                        cache: false,
                        url: url_post,
                        data: data,
                        success: function (result) {
                            hideImgLoading();
                            if (!result.error) {
                                alert("Thank your for register");
                                window.location.reload();
                            } else {
                                alert(result.msg);
                            }
                            check_from_post = false;
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
            .on('success.field.bv', function (e, data) {
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
    });
</script>


<section class="container-fluid" style="margin-top: 10px;">
    <div class="container wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron" style="background: #fff">

                    <h1 class="text-center"><img
                            src="<?php echo get_template_directory_uri(); ?>/libs/img/nav-logo-big.png" class=""/> TITLE
                    </h1>

                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                        been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                        galley of type and scrambled it to make a type specimen book. It has survived not only five
                        centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                        It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                        passages, and more recently with desktop publishing software like Aldus PageMaker including
                        versions of Lorem Ipsum.</p>

                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                        been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                        galley of type and scrambled it to make a type specimen book. It has survived not only five
                        centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                        It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                        passages, and more recently with desktop publishing software like Aldus PageMaker including
                        versions of Lorem Ipsum.</p>

                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                        been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                        galley of type and scrambled it to make a type specimen book. It has survived not only five
                        centuries, but also the leap into electronic typesetting.</p>
                </div>


                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="candRegister">
                            <h4 class="panel-title text-center">
                                <a class="" style="font-size: 80px;" data-toggle="collapse" data-parent="#accordion"
                                   href="#Topic1" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="glyphicon glyphicon-list-alt"></i> REGISTER HERE.
                                </a>
                            </h4>
                        </div>
                        <div id="Topic1" class="panel-collapse collapse in" role="tabpanel"
                             aria-labelledby="headingOne">
                            <div class="panel-body">
                                <form method="post" id="form_candidate" class="form-horizontal">
                                    <input type="hidden" id="pre_register" name="pre_register" value="true">
                                    <h4 style="color: #BE2026">Personal Information:</h4>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label
                                                for="first_name">Name<span
                                                    class="font-color-red">*</span></label></div>
                                        <div class="col-md-8">
                                            <input type="text" id="first_name" required=""
                                                   name="first_name" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label for="gender">Gender<span
                                                    class="font-color-red">*</span></label></div>
                                        <div class="col-md-8">
                                            <select id="gender" name="gender" required=""
                                                    class="form-control">
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label for="date_of_birth">Date of
                                                birth<span
                                                    class="font-color-red">*</span></label></div>
                                        <div class="col-md-8">
                                            <input type="text" maxlength="20"
                                                   id="date_of_birth" name="date_of_birth"
                                                   class="form-control datepicker"
                                                   required placeholder="dd/mm/yyyy | Ex. 23/02/1980"
                                                   value=""/>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label for="phone">Phone / Mobile<span
                                                    class="font-color-red">*</span></label></div>
                                        <div class="col-md-8">
                                            <input type="text" maxlength="50"
                                                   id="phone" name="phone" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label for="email">Email
                                                Address<span class="font-color-red">*</span></label></div>
                                        <div class="col-md-8">
                                            <input type="text" id="email" name="email" class="form-control"
                                                   maxlength="50"
                                                   data-bv-emailaddress="true"
                                                   required
                                                   data-bv-emailaddress-message="The input is not a valid email address"
                                                />
                                        </div>
                                    </div>

                                    <h4 style="color: #BE2026">Your Language Skill:</h4>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label for="japanese_reading">Japanese
                                                Reading</label><span class="font-color-red">*</span></div>
                                        <div class="col-md-8">
                                            <select id="japanese_reading" name="japanese_reading" class="form-control"
                                                    required="">
                                                <option value=""></option>
                                                <?php foreach ($classCandidate->japanese_reading as $value): ?>
                                                    <option
                                                        value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label for="japanese_writing">Japanese
                                                Writing</label><span class="font-color-red">*</span></div>
                                        <div class="col-md-8">
                                            <select id="japanese_writing" name="japanese_writing" class="form-control"
                                                    required="">
                                                <option value=""></option>
                                                <?php foreach ($classCandidate->japanese_writing as $value): ?>
                                                    <option
                                                        value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label for="toeic_toefl_ielts">TOEIC /
                                                TOEFL /
                                                IELTS</label><span class="font-color-red">*</span></div>
                                        <div class="col-md-8">

                                            <select id="toeic_toefl_ielts" name="toeic_toefl_ielts" class="form-control"
                                                    required="">
                                                <option value=""></option>
                                                <?php foreach ($classCandidate->toeic_toefl_ielts as $value): ?>
                                                    <option
                                                        value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"></div>
                                        <div class="col-md-8">
                                            <input type="text" id="toeic_toefl_ielts_score"
                                                   name="toeic_toefl_ielts_score"
                                                   class="form-control" placeholder="Your Score: 999" required=""
                                                   maxlength="20"
                                                   value=""/>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label for="english_speaking">English
                                                Speaking</label><span
                                                class="font-color-red">*</span></div>
                                        <div class="col-md-8">
                                            <select id="english_speaking" name="english_speaking" class="form-control"
                                                    required="">
                                                <option value=""></option>
                                                <?php foreach ($classCandidate->english_speaking as $value): ?>
                                                    <option
                                                        value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label for="english_reading">English
                                                Reading</label><span class="font-color-red">*</span></div>
                                        <div class="col-md-8">
                                            <select id="english_reading" name="english_reading" class="form-control"
                                                    required="">
                                                <option value=""></option>
                                                <?php foreach ($classCandidate->english_reading as $value): ?>
                                                    <option
                                                        value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label for="english_writing">English
                                                Writing</label><span class="font-color-red">*</span></div>
                                        <div class="col-md-8">
                                            <select id="english_writing" name="english_writing" class="form-control"
                                                    required="">
                                                <option value=""></option>
                                                <?php foreach ($classCandidate->english_writing as $value): ?>
                                                    <option
                                                        value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <h4 style="color: #BE2026">Your Experiences:</h4>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label for="candRegistJPStudyExp">Experience
                                                studying in Japan<span class="font-color-red">*</span></label></div>
                                        <div class="col-md-8">
                                            <select id="candRegistJPStudyExp" name="candRegistJPStudyExp"
                                                    class="form-control" required="">
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label for="candRegistJPWorkExp">Experience
                                                working in Japan<span class="font-color-red">*</span></label></div>
                                        <div class="col-md-8">
                                            <select id="candRegistJPWorkExp" name="candRegistJPWorkExp"
                                                    class="form-control" required="">
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label
                                                for="candRegistJPCompWorkExp">Experience working in Japanese
                                                Company<span
                                                    class="font-color-red">*</span></label></div>
                                        <div class="col-md-8">
                                            <select id="candRegistJPCompWorkExp" name="candRegistJPCompWorkExp"
                                                    class="form-control" required="">
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <h4 style="color: #BE2026">Your Expectation:</h4>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label
                                                for="<?php echo $classOthSetting->namePositionList; ?>">Job
                                                Position<span class="font-color-red">*</span></label></div>
                                        <div class="col-md-8">
                                            <?php echo $classOthSetting->buildWorkingDayToSelect($classOthSetting->namePositionList) ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label
                                                for="<?php echo $classOthSetting->nameJobLocation; ?>">Job
                                                Location<span class="font-color-red">*</span></label></div>
                                        <div class="col-md-8">
                                            <?php echo $classOthSetting->buildWorkingDayToSelect($classOthSetting->nameJobLocation); ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4 text-left clearfix"><label
                                                for="candRegistSalary">Salary<span
                                                    class="font-color-red">*</span></label></div>
                                        <div class="col-md-8">
                                            <input type="text" id="candRegistSalary" required=""
                                                   name="candRegistSalary" class="form-control"
                                                maxlength="20"/>
                                        </div>
                                    </div>

                                    <input type="submit" value="Send Profile"
                                           class="btn btn-success btn-lg col-md-12"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
