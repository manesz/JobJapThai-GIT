<footer>
    <div class="container-fluid clearfix" style="background: #fff; padding-top: 20px; margin-top: 10px; ">
        <div class="col-md-3">
            <ul class="clearfix" style="list-style: none; margin-bottom: 20px; border: none;">
                <li><span style="color: #BF2026">Job Seeker</span></li>
                <li>Store Resume (Member)</li>
                <li>Search Job</li>
                <li>All Category</li>
                <li>Overseas Jobs</li>
                <li>Industrial Jobs</li>
                <li>Disability Jobs</li>
                <li>Feature Guide</li>
            </ul>

            <ul class="clearfix" style="list-style: none; border: none;">
                <li><span style="color: #BF2026">Employers</span></li>
                <li>Post Job</li>
                <li>Advertise Rate</li>
                <li>Search Resume</li>
                <li>Feature Guide</li>
            </ul>
        </div>
        <div class="col-md-3">
            <ul class="clearfix" style="list-style: none; border: none;">
                <li><span style="color: #BF2026">Category</span></li>
                <li>Marketing</li>
                <li>Sales</li>
                <li>Technicians</li>
                <li>Customer Service / Support / PR</li>
                <li>Finance / Accounting</li>
                <li>HR / Training</li>
                <li>Production / QA, QC / Manufacturing</li>
                <li>Construction / Survey / Architecture</li>
                <li>Interior Design</li>
                <li>Engineering</li>
                <li>Messenger / Driver / Delivery</li>
                <li>Food and Beverage / Chef / Cook</li>
                <li>Bar Tender / Waiter</li>
                <li>Part-Time Jobs</li>
            </ul>
        </div>
        <div class="col-md-3">
            <ul class="clearfix" style="list-style: none; border: none;">
                <li><span style="color: #BF2026">Location</span></li>
                <li>Jobs in Bangkok</li>
                <li>Jobs in Chachoengsao</li>
                <li>Jobs in Chonburi</li>
                <li>Jobs in Nonthaburi</li>
                <li>Jobs in Pathum Thani</li>
                <li>Jobs in Ratonh</li>
                <li>Jobs in Samut Prakan</li>
                <li>Jobs in Samut Sakhon</li>
            </ul>
        </div>
        <div class="col-md-3">
            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/nav-logo.png"/>
            <p style="margin: 50px 0 50px 0; ">
                JobJapThai Co., Ltd.<br/>
                1 Infinite Loop Cupertino, CA 95014<br/>
                Tel. +6686 627 0681<br/>
                contact@jobjapthai.com
            </p>
            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/social-fb.png"/>
            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/social-tw.png"/>
            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/social-ggp.png"/>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="container-fluid bg-f3f3f4 clearfix margin-top-10">
        <div class="col-md-6">
            <p class="text-left">Copyright 2014 <span class="font-color-BF2026">JobJapThai.com</span> All right reserved</p>
        </div>
        <div class="col-md-6">
            <ul class="sitemaps pull-right no-margin">
                <li class="no-margin" style="float: left; width: auto;">Home</li>
                <li class="no-margin" style="float: left; width: auto;">About Us</li>
                <li class="no-margin" style="float: left; width: auto;">Contact Us</li>
                <li class="no-margin" style="float: left; width: auto;">JobJapThai News</li>
                <li class="no-margin" style="float: left; width: auto;">Sitemaps</li>
            </ul>
        </div>
    </div>

</footer><!-- END : footers.container-fluid -->

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?php echo get_template_directory_uri(); ?>/libs/js/jquery.1.11.1.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrapValidator.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrap-modal.js"></script>

<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/libs/js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="<?php echo get_template_directory_uri(); ?>/libs/js/ie-emulation-modes-warning.js"></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/libs/js/html5shiv.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/libs/js/respond.min.js"></script>
<![endif]-->

<script>
var wppage = {
	init:function(){
		wppage.addEvent();
	},
	addEvent:function(){
		$('.carousel').carousel({
            interval: 5000
        });	
		$('#myTab a').on('click',function(e){
			e.preventDefault()
            $(this).tab('show','fast');
		});
	},
	onready:function(){
		wppage.init();
	}
};
$(document).ready(wppage.onready);
</script>

</body>
</html>