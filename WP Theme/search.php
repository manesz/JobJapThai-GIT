<?php include_once('header.php');?>
<?php include_once("libs/nav.php"); ?>
<?php include_once("libs/front-banner.php"); ?>
<section class="container-fluid" style="margin-top: 10px;">

        <div class="container wrapper">
            <div class="row">
                <div class="col-md-8">

                    <div class="clearfix" style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                        <h5 class="pull-left" style="">
                            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png" style="height: 25px;"/>
                            お知らせ
                            <span class="font-color-BF2026" style="" >Search Job Result</span>
                        </h5>
                        <div class="col-md-12 border-bottom-1-ddd padding-bottom-10 margin-bottom-10">
                            <form>
                                <div class="col-md-3">
                                    <span class="pull-left">Positions</span>
                                    <select id="searchList" class="pull-left form-control">
                                        <option>10</option>
                                        <option>50</option>
                                        <option>100</option>
                                        <option>All</option>
                                    </select>
                                </div>
                                <div class="col-md-push-6 col-md-3">
                                    <span class="pull-right">Sort by</span><br/>
                                    <select id="searchSort" class="pull-right form-control col-md-3">
                                        <option>Last Update</option>
                                        <option>Company Name</option>
                                        <option>Less to more competitive jobs</option>
                                        <option>More to less competitive jobs</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="clearfix" style="margin-top: 20px;"></div>

                        <ul class="job-list no-padding">
                            <?php for($i=0;$i<=6;$i++):?>
                                <li class="clearfix border-bottom-1-ddd padding-top-10 padding-bottom-10">
                                    <div class="col-md-12">
                                        <div class="col-md-2" style="padding: 0px">
                                            <a href="job-desc.php" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-logo.png" style="width: 100%;"/></a>
                                        </div>
                                        <div class="col-md-8">
                                            <h5 class="font-color-BF2026">
                                                <a href="job-desc.php" target="_blank">Japanese Interpreter (JLPT Level 2 or 1)</a>
                                            </h5>
                                            YMC Translation Center Co.,Ltd.<br/>
                                            Permanent<br/>
                                        </div>
                                        <div class="col-md-2">
                                            <br/>Aug 14, 2014<br/>
                                            Bangkok<br/>
                                        </div>
                                    </div>
                                </li>
                            <?php endfor; ?>
                        </ul>

                    </div>

                    <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png" style="width: 100%; height: auto;"/>

                </div>
                <?php include_once('libs/sidebar.php'); ?>
            </div>
        </div>

    </section>
<?php include_once('footer.php');?>