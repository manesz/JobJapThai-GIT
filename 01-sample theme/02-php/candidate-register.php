<?php include_once("header.php"); ?>
<?php include_once("nav.php"); ?>


    <section class="container-fluid" style="margin-top: 10px;">

        <div class="container wrapper">
            <div class="row">

                <div id="frmRegister" class="col-md-8">

                    <div id="sectButton" class="clearfix" style="padding-bottom: 20px;">
                        <input type="button" id="editResume" class="btn col-md-4" value="Edit Resume"/>
                        <input type="button" id="appliedJob" class="btn col-md-4" value="Applied Job"/>
                        <input type="button" id="favoriteJob" class="btn col-md-4" value="Favorite Job"/>
                        <input type="button" id="viewCompany" class="btn col-md-4" value="View by Company"/>
                        <input type="button" id="accountSetting" class="btn col-md-4" value="Account Setting"/>

                    </div>
                    <div id="sectionEditProfile" class="col-md-12">
                        <div class="col-md-8" style="padding-top: 10px;">
                            Resume Code: <span class=".font-color-BF2026" style="">3838352</span><br/>
                            Status: <span class="font-color-BF2026" style="">Under verification process</span><br/>
                            Last Login Date: 8 Sep 14<br/>
                            Last update: 8 Sep 14<br/>
                            Member since: 8 Sep 14<br/>
                            Your resume is in the verification process <br/>
                            (The process will take 1-2 working days)

                        </div>
                        <div class="col-md-4" style="padding-top: 10px;">
                            <img src="libs/img/blank-logo.png" class="img-circle" style="width: 100px; height: 100px;"/>
                            <input type="file" class="btn" value="">
                        </div>
                    </div>

                    <div class="clearfix" style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                        <h5 class="pull-left" style="">
                            <img src="libs/img/icon-title.png" style="height: 25px;"/>
                            お知らせ
                            <span class="font-color-BF2026" style="" >Employer Register</span>
                        </h5>
                        <div class="clearfix" style="margin-top: 20px;"></div>

                        <form>
                        <div id="regisStep1" class="col-md-12">
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="candRegisStep1Email">Email<span class="font-color-red">*</span></label></div>
                                <div class="col-md-8"><input type="text" id="candRegisStep1Email" name="candRegisStep1Email" class="form-control"/></div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="candRegisStep1ConfirmEmail">Email<span class="font-color-red">*</span></label></div>
                                <div class="col-md-8"><input type="text" id="candRegisStep1ConfirmEmail" name="candRegisStep1ConfirmEmail" class="form-control"/></div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="candRegisStep1Password">Email<span class="font-color-red">*</span></label></div>
                                <div class="col-md-8"><input type="password" id="candRegisStep1Password" name="candRegisStep1Password" class="form-control"/></div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-md-4 text-right clearfix"><label for="candRegisStep1ConfirmPassword">Email<span class="font-color-red">*</span></label></div>
                                <div class="col-md-8"><input type="password" id="candRegisStep1ConfirmPassword" name="candRegisStep1ConfirmPassword" class="form-control"/></div>
                            </div>

                            <div class="form-group col-md-12" style="">
                                <button id="submitStep1" type="button" class="btn btn-primary col-md-6 pull-right">Submit Form</button>
                                <button type="reset" class="btn btn-default pull-right" style="border: none;">reset</button>
                            </div>
                        </div><!-- END: step 1 -->
                        <div id="regisStep2" class="col-md-12">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#candPersonalInformation" aria-expanded="true" aria-controls="collapseOne">
                                                PERSONAL INFORMATION
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="candPersonalInformation" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candEmail">Email<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><input type="text" id="candEmail" name="candEmail" class="form-control"/></div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candPassword">Password<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><input type="password" id="candPassword" name="candPassword" class="form-control"/></div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candConfirmPassword">Confirm Password<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><input type="password" id="candConfirmPassword" name="candConfirmPassword" class="form-control"/></div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candTitle">Title<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><select id="candTitle" name="candTitle" class="form-control"><option>Mr.</option></select> </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candFName">First Name<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><input type="text" id="candFName" name="candFName" class="form-control"/></div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candLName">Surname / Last Name<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><input type="text" id="candLName" name="candLName" class="form-control"/></div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candGender">Gender<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><select id="candGender" name="candGender" class="form-control"><option>Male</option><option>Female</option></select> </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candDOB">Date of birth<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><input type="text" id="candDOB" name="candDOB" class="form-control datepicker"/></div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candPhone">Phone / Mobile<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><input type="text" id="candPhone" name="candPhone" class="form-control"/></div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candNationality">Nationality<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><select id="candNationality" name="candNationality" class="form-control"><option>Thailand</option></select> </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candCountry">Country<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><select id="candCountry" name="candCountry" class="form-control"><option>Thailand</option></select> </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candProvince">Province<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><select id="candProvince" name="candProvince" class="form-control"><option>Thailand</option></select> </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candDistrict">District<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><select id="candDistrict" name="candDistrict" class="form-control"><option>Thailand</option></select> </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candCity">City / Locality<span class="font-color-red">*</span></label></div>
                                                <div class="col-md-8"><select id="candCity" name="candCity" class="form-control"><option>Thailand</option></select> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#candCareerProfile" aria-expanded="false" aria-controls="collapseTwo">
                                                CAREER PROFILE
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="candCareerProfile" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="panel-body">
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candYearOfWorkExp">Year of Work Exp.</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="candYearOfWorkExp[0]" name="candYearOfWorkExp[]" class="form-control" placeholder="Year(s)"/>
                                                    <span class="font-color-red">please enter only number No.(-) or (.) and space.</span>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candLastPosition">Lasted Position</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="candLastPosition[0]" name="candLastPosition[]" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candLastIndustry">Lasted Industry</label></div>
                                                <div class="col-md-8">
                                                    <select id="candLastIndustry" name="candLastIndustry" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candLastFunction">Lasted Function</label></div>
                                                <div class="col-md-8">
                                                    <select id="candLastFunction" name="candLastFunction" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candYearOfWorkExp">Last Monthly Salary</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="candYearOfWorkExp[0]" name="candYearOfWorkExp[]" class="form-control" placeholder="THB"/>
                                                    <span class="font-color-red">please enter only number No.(-) or (.) and space example: 15000 or 20000, 100000</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#candDesiredJob" aria-expanded="false" aria-controls="collapseThree">
                                                YOUR DESIRED JOB
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="candDesiredJob" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candDesiredIndustry">Industry</label></div>
                                                <div class="col-md-8">
                                                    <select id="candDesiredIndustry" name="candDesiredIndustry" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candDesiredFunction">Job Function</label></div>
                                                <div class="col-md-8">
                                                    <select id="candDesiredFunction" name="candDesiredFunction" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candDesiredType">Job Type</label></div>
                                                <div class="col-md-8">
                                                    <select id="candDesiredType" name="candDesiredType" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candDesiredSalary">Expect Monthly Salary</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="candDesiredSalary[0]" name="candDesiredSalary[]" class="form-control" placeholder="THB"/>
                                                    <span class="font-color-red">please enter only number No.(-) or (.) and space example: 15000 or 20000, 100000</span>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candDesiredAvalibleWork">Are you avaliable to work ?</label></div>
                                                <div class="col-md-8">
                                                    <select id="candDesiredAvalibleWork" name="candDesiredAvalibleWork" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candDesiredStartDate">Start Date</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="candDesiredStartDate[0]" name="candDesiredStartDate[]" class="form-control datepicker" placeholder=""/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#candEDUCATION" aria-expanded="false" aria-controls="collapseThree">
                                                EDUCATION
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="candEDUCATION" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            <span>Please provide details of education institutions, dates attended and qualification attained.</span>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candEducationDegree">Degree</label></div>
                                                <div class="col-md-8">
                                                    <select id="candEducationDegree" name="candEducationDegree" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candEducationUniversity">University / Intitute</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="candEducationUniversity[0]" name="candEducationUniversity[]" class="form-control" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candEducationPeriod">Education Period</label></div>
                                                <div class="col-md-8">
                                                    <label for="candEducationPeriodFrom">From:</label>
                                                    <input type="text" id="candEducationPeriodFrom[0]" name="candEducationPeriodFrom[]" class="form-control datepicker" placeholder=""/>
                                                    <label for="candEducationPeriodTo">To:</label>
                                                    <input type="text" id="candEducationPeriodTo[0]" name="candEducationPeriodTo[]" class="form-control datepicker" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candEducationGrade">Grade / GPA</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="candEducationGrade[0]" name="candEducationGrade[]" class="form-control" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 text-right">
                                                <input type="button" class="btn btn-success" value="Add Education"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#candWorkExperience" aria-expanded="false" aria-controls="collapseThree">
                                                WORK EXPERIENCE
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="candWorkExperience" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candWorkPeriod">Employment Period</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="candWorkPeriodFrom[0]" name="candWorkPeriodFrom[]" class="form-control" placeholder="From: mm/yyyy"/>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="candWorkPeriodTo[0]" name="candWorkPeriodTo[]" class="form-control" placeholder="To: mm/yyyy"/>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candWorkCompanyName">Company Name</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="candWorkCompanyName[0]" name="candWorkCompanyName[]" class="form-control" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candWorkPosition">Position</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="candWorkPosition[0]" name="candWorkPosition[]" class="form-control" placeholder=""/>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candWorkSalary">Monthly Salary</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="candWorkSalary[0]" name="candWorkSalary[]" class="form-control" placeholder=""/>
                                                    <span class="font-color-red">please enter only number No.(-) or (.) and space example: 15000 or 20000, 100000</span>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candWorkDuties">Job Duties</label></div>
                                                <div class="col-md-8">
                                                    <textarea id="candWorkDuties" name="candWorkDuties" class="form-control" rows="10"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 text-right">
                                                <input type="button" class="btn btn-success" value="Add Work Experience"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#candSkillLanguages" aria-expanded="false" aria-controls="collapseThree">
                                                SKILL'S / LANGUAGES
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="candSkillLanguages" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candWorkSkillJapSkill">Japanese Skill</label><span class="font-color-red">*</span></div>
                                                <div class="col-md-8">
                                                    <select id="candWorkSkillJapSkill" name="candWorkSkillJapSkill" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candWorkSkillJapSpeaking">Japanese Speaking</label><span class="font-color-red">*</span></div>
                                                <div class="col-md-8">
                                                    <select id="candWorkSkillJapSpeaking" name="candWorkSkillJapSpeaking" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candWorkSkillJapReading">Japanese Reading</label><span class="font-color-red">*</span></div>
                                                <div class="col-md-8">
                                                    <select id="candWorkSkillJapReading" name="candWorkSkillJapReading" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candWorkSkillJapWriting">Japanese Writing</label><span class="font-color-red">*</span></div>
                                                <div class="col-md-8">
                                                    <select id="candWorkSkillJapWriting" name="candWorkSkillJapWriting" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candWorkSkillJapTOEIC">TOEIC / TOEFL / IELTS</label><span class="font-color-red">*</span></div>
                                                <div class="col-md-8">
                                                    <select id="candWorkSkillJapTOEIC" name="candWorkSkillJapTOEIC" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="candWorkSkillJapTOEICScore" name="candWorkSkillJapTOEICScore" class="form-control" placeholder="Your Score: 999"/>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candWorkSkillEngSpeaking">Englisg Speaking</label><span class="font-color-red">*</span></div>
                                                <div class="col-md-8">
                                                    <select id="candWorkSkillEngSpeaking" name="candWorkSkillEngSpeaking" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candWorkSkillEngReading">Englisg Reading</label><span class="font-color-red">*</span></div>
                                                <div class="col-md-8">
                                                    <select id="candWorkSkillEngReading" name="candWorkSkillEngReading" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class="col-md-4 text-right clearfix"><label for="candWorkSkillEngWriting">Englisg Writing</label><span class="font-color-red">*</span></div>
                                                <div class="col-md-8">
                                                    <select id="candWorkSkillEngWriting" name="candWorkSkillEngWriting" class="form-control"><option>xxxx</option></select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group col-md-12" style="">
                                <button id="submitStep2" type="button" class="btn btn-primary col-md-6 pull-right">Submit Form</button>
                                <button type="reset" class="btn btn-default pull-right" style="border: none;">reset</button>
                            </div>

                        </div><!-- END: step 2 -->

                        </form>

                    </div>

                    <img src="libs/img/blank-banner-ads-01.png" style="width: 100%; height: auto;"/>

                </div>

                <?php include_once("sidebar.php"); ?>
            </div>
        </div>

    </section>

    <!-- Modal -->
    <div class="modal fade" id="calForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="font-size: 12px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="bg-BF2026 font-color-fff padding-10" id="myModalLabel">Business Package</h4>
                    <form class="clearfix">
                        <table style="width: 100%;">
                            <tr><td colspan="3"><h5>1. เลือกจำนวนตำแหน่ง และระยะเวลา</h5></td></tr>
                            <tr class="padding-bottom-10" style="">
                                <td class="col-md-3">
                                    <label for="employerCalPositionAmount" class=" margin-top-10">จำนวนตำแหน่ง<span class="font-color-red">*</span></label><br/>
                                    <label for="employerCalDuration" class=" margin-top-10">ระยะเวลา<span class="font-color-red">*</span></label>
                                </td>
                                <td class="col-md-7">
                                    <select type="text" id="employerCalPositionAmount" name="employerCalPositionAmount" class="form-control margin-top-10">
                                        <option>Business Package : 1 ตำแหน่งงาน</option>
                                    </select>
                                    <select type="text" id="employerCalDuration" name="employerCalDuration" class="form-control margin-top-10">
                                        <option>2 สัปดาห์</option>
                                    </select>
                                </td>
                                <td class="col-md-4">600 บาท</td>
                            </tr>
                            <tr><td colspan="3"><div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div></td></tr>
                            <tr><td colspan="3"><h5>2. เลือกระยะเวลา <span class="font-color-BF2026">Super Hotjob</span></h5></td></tr>
                            <tr>
                                <td class="col-md-3">
                                    <label for="employerCalSuperHotJobDuration">ระยะเวลา</label>
                                </td>
                                <td class="col-md-7">
                                    <select id="employerCalSuperHotJobDuration" name="employerCalSuperHotJobDuration" class="form-control">
                                        <option>--------------------</option>
                                    </select>
                                </td>
                                <td class="col-md-4">0 บาท</td>
                            </tr>
                            <tr><td colspan="3"><div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div></td></tr>
                            <tr><td colspan="3"><h5>3. เลือกประเภท และระยะเวลาของ <span class="font-color-BF2026">Hotjob</span></h5></td></tr>
                            <tr>
                                <td class="col-md-3">
                                    <label for="employerCalHotJobType" class="">ประเภท</label><br/><br/>
                                    <label for="employerCalHotJobDuration" class="">ระยะเวลา</label>
                                </td>
                                <td class="col-md-7">
                                    <select type="text" id="employerCalHotJobType" name="employerCalHotJobType" class="form-control margin-top-10">
                                        <option>Business Package : 1 ตำแหน่งงาน</option>
                                    </select>
                                    <select type="text" id="employerCalHotJobDuration" name="employerCalHotJobDuration" class="form-control margin-top-10">
                                        <option>2 สัปดาห์</option>
                                    </select>
                                </td>
                                <td class="col-md-4"> 0 บาท</td>
                            </tr>
                            <tr><td colspan="3"><div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div></td></tr>
                            <tr><td colspan="3"><h5>4. เลือกระยะเวลาของ <span class="font-color-BF2026">Urgent</span> (บนเว็บไซต์ และ Mobile Application)</h5></td></tr>
                            <tr>
                                <td class="col-md-3">
                                    <label for="employerCalUrgentDuration" class="">ระยะเวลา</label>
                                </td>
                                <td class="col-md-7">
                                    <select type="text" id="employerCalUrgentDuration" name="employerCalUrgentDuration" class="form-control margin-top-10">
                                        <option>---------------------</option>
                                    </select>
                                </td>
                                <td class="col-md-4"> 0 บาท</td>
                            </tr>
                            <tr><td colspan="3"><div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div></td></tr>
                            <tr>
                                <td class="col-md-8 text-right" colspan="2">Sub Total</td>
                                <td class="col-md-4">600 บาท</td>
                            </tr>
                            <tr><td colspan="3"><div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div></td></tr>
                            <tr>
                                <td class="col-md-8 text-right" colspan="2">+ Vat (7%)</td>
                                <td class="col-md-4">42 บาท</td>
                            </tr>
                            <tr><td colspan="3"><div class="border-bottom-1-ddd margin-top-10 margin-bottom-10"></div></td></tr>
                            <tr>
                                <td class="col-md-8 text-right" colspan="2"><strong>ยอดสุทธิ</strong></td>
                                <td class="col-md-4">642 บาท</td>
                            </tr>
                            <tr>
                                <td class="col-md-3"></td>
                                <td class="col-md-7"></td>
                                <td class="col-md-4"></td>
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

<script>

    function toggleChevron(e) {
        $(e.target)
            .prev('.panel-heading')
            .find("i.indicator")
            .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
    }
    $('.in').collapse({hide: true})

    // in cadidate register page
</script>

<?php include_once("footer.php"); ?>