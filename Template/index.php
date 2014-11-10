<?php include_once("header.php"); ?>
<?php include_once("nav.php"); ?>
<?php include_once("front-banner.php"); ?>

<section class="container-fluid" style="margin-top: 10px;">

    <div class="container wrapper">
        <div class="row">
            <div class="col-md-8">
                <div class="clearfix" style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">

                    <h4 class="pull-left" style="font-size: 16px !important;">
                        <img src="libs/img/icon-title.png" style="height: 25px;"/>
                        お知らせ
                        <span style="font-size: 16px !important; color: #BF2026; " >Highlight jobs</span>
                    </h4>
                    <div class="pull-right" style="font-size: 12px; margin-top: 15px;"><a>一覧を見る ></a></div>
                    <div class="clearfix"></div>

                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <?php for($i=0; $i<=2; $i++): ?>
                            <div class="item <?php if($i == 0): echo "active"; endif?>">

                                <ul class="job-list" style="padding: 0px;">
                                    <?php for($j=0; $j<=3; $j++):?>
                                    <li class="col-md-6 clearfix">
                                        <div class="col-md-4" style="padding: 0px;">
                                            <a href="job-desc.php" target="_blank"><img src="libs/img/blank-logo.png" style="width: 100%"/></a>
                                        </div>
                                        <div class="col-md-8" style="padding: 0 0 0 10px;">
                                            <h4 style="font-size: 14px !important; color: #BF2026"><a href="job-desc.php" target="_blank">Call Center Representative (Japanese/English) JLPT Level 2</a></h4>
                                            <p class="font-size-12">
                                                <span class="font-color-4D94CC">Bangkok</span><br/>
                                                Permanent<br/>
                                                4 August, 2014
                                            </p>
                                        </div>
                                    </li>
                                    <?php endfor; ?>
                                </ul>

                            </div>
                            <?php endfor; ?>
                        </div>

                        <!-- Controls -->
<!--                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">-->
<!--                            <span class="glyphicon glyphicon-chevron-left"></span>-->
<!--                        </a>-->
<!--                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">-->
<!--                            <span class="glyphicon glyphicon-chevron-right"></span>-->
<!--                        </a>-->
                    </div>

                </div>

                <div class="clearfix" style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px;">
                    <h4 class="pull-left" style="font-size: 16px !important;">
                        <img src="libs/img/icon-title.png" style="height: 25px;"/>
                        メリット
                        <span style="font-size: 16px !important; color: #BF2026; " >News jobs update</span>
                    </h4>
                    <div class="pull-right" style="font-size: 12px; margin-top: 15px;"><a>一覧を見る ></a></div>
                    <div class="clearfix"></div>

                    <ul class="job-list no-padding">
                        <?php for($i=0;$i<=6;$i++):?>
                        <li class="clearfix border-bottom-1-ddd padding-top-10 padding-bottom-10">
                            <div class="col-md-12">
                                <div class="col-md-2" style="padding: 0px">
                                    <a href="job-desc.php" target="_blank"><img src="libs/img/blank-logo.png" style="width: 100%;"/></a>
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

                <img src="libs/img/blank-banner-ads-01.png" style="width: 100%; height: auto; margin-top: 10px;"/>
            </div>

            <?php include_once("sidebar.php"); ?>

        </div>
    </div>

</section><!-- END : section.container-fluid -->

<?php include_once("footer.php"); ?>
