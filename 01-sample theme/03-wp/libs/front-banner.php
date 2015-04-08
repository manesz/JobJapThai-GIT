<?php

$classBannerSlide = new BannerSlide($wpdb);
$arrayBanner = $classBannerSlide->getList();

?>
<section class="container-fluid" style="">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <?php foreach ($arrayBanner as $key => $value): ?>
                            <div class="item <?php echo $key == 0 ? 'active' : ""; ?>">
                                <a href="<?php echo $value->link; ?>" target="_blank">
                                    <img src="<?php echo $value->image_path; ?>"
                                         alt="" style="width: 100%; height: 350px;">
                                </a>
                            </div>
                        <?php endforeach; ?>
                        <!--                        <div class="item active">-->
                        <!--                            <img src="-->
                        <!--                        --><?php //echo get_template_directory_uri(); ?><!--/libs/img/slide-01.png" alt="..."-->
                        <!--                                 style="width: 100%;">-->
                        <!---->
                        <!--                            <div class="carousel-caption">...</div>-->
                        <!--                        </div>-->
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</section><!-- END : section.container-fluid -->