<?php include_once("header.php"); ?>
<style type="text/css">.panel-default>.panel-heading{background-color:#BE2026;color:#fff}</style>
    <section class="container-fluid" style="margin-top: 10px;">
        <div class="container wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="jumbotron" style="background:#fff" >

                        <h1 class="text-center"><img src="libs/img/nav-logo-big.png" class=""/> TITLE</h1>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting.</p>
                    </div>


                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="candRegister">
                                <h4 class="panel-title text-center">
                                    <a class="" style="font-size: 80px;" data-toggle="collapse" data-parent="#accordion" href="#Topic1" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="glyphicon glyphicon-list-alt"></i> REGISTER HERE.
                                    </a>
                                </h4>
                            </div>
                            <div id="Topic1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <form>
                                        <h4 style="color: #BE2026">Personal Information:</h4>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistName">Name<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8"><input type="text" id="candRegistName" name="candRegistName" class="form-control"/></div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistGender">Gender<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8">
                                                <select id="candRegistGender" name="candRegistGender" class="form-control">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistDOB">Date of Birth<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8"><input type="text" id="candRegistDOB" name="candRegistDOB" class="form-control"/></div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistMobileNumber">Mobile Number<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8"><input type="text" id="candRegistMobileNumber" name="candRegistMobileNumber" class="form-control"/></div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistEmail">Email Address<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8"><input type="text" id="candRegistEmail" name="candRegistEmail" class="form-control"/></div>
                                        </div>

                                        <h4 style="color: #BE2026">Your Language Skill:</h4>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistJPSkill">Japanese language skill<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8">
                                                <select id="candRegistJPSkill" name="candRegistJPSkill" class="form-control">
                                                    <option value="None">------None------</option>
                                                    <option value="Basic">Basic</option>
                                                    <option value="Fair">Fair</option>
                                                    <option value="Intermediate">Intermediate</option>
                                                    <option value="Good">Good</option>
                                                    <option value="Fluent">Fluent</option>
                                                    <option value="Native">Native</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistJLPT">JLPT<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8">
                                                <select id="candRegistJLPT" name="candRegistJLPT" class="form-control">
                                                    <option value="None">------None------</option>
                                                    <option value="N1">N1</option>
                                                    <option value="N2">N2</option>
                                                    <option value="N3">N3</option>
                                                    <option value="N4">N4</option>
                                                    <option value="N5">N5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistENSkill">English language skill<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8">
                                                <select id="candRegistENSkill" name="candRegistENSkill" class="form-control">
                                                    <option value="None">------None------</option>
                                                    <option value="Basic">Basic</option>
                                                    <option value="Fair">Fair</option>
                                                    <option value="Intermediate">Intermediate</option>
                                                    <option value="Good">Good</option>
                                                    <option value="Fluent">Fluent</option>
                                                    <option value="Native">Native</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistENTOEIC">English TOEIC<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8"><input type="text" id="candRegistENTOEIC" name="candRegistENTOEIC" class="form-control"/></div>
                                        </div>
                                        <h4 style="color: #BE2026">Your Experiences:</h4>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistJPStudyExp">Experience studying in Japan<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8">
                                                <select id="candRegistJPStudyExp" name="candRegistJPStudyExp" class="form-control">
                                                    <option value="No">No</option>
                                                    <option value="Yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistJPWorkExp">Experience working in Japan<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8">
                                                <select id="candRegistJPWorkExp" name="candRegistJPWorkExp" class="form-control">
                                                    <option value="No">No</option>
                                                    <option value="Yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistJPCompWorkExp">Experience working in Japanese Company<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8">
                                                <select id="candRegistJPCompWorkExp" name="candRegistJPCompWorkExp" class="form-control">
                                                    <option value="No">No</option>
                                                    <option value="Yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <h4 style="color: #BE2026">Your Expectation:</h4>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistJobPosition">Job Position<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8">
                                                <select id="candRegistJobPosition" name="candRegistJobPosition" class="form-control">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistJobLocation">Job Location<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8">
                                                <select id="candRegistJobLocation" name="candRegistJobLocation" class="form-control">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4 text-left clearfix"><label for="candRegistSalary">Salary<span class="font-color-red">*</span></label></div>
                                            <div class="col-md-8"><input type="text" id="candRegistSalary" name="candRegistSalary" class="form-control"/></div>
                                        </div>

                                        <input type="submit" value="Send Profile" class="btn btn-success btn-lg col-md-12"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>

<?php include_once("footer.php"); ?>