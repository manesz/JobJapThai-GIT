<?php 
include_once('header.php');
include_once("libs/nav.php");
?>
<section class="container-fluid" style="margin-top: 10px;">

        <div class="container wrapper">
            <div class="row">
                <div class="col-md-8">

                    <div class="clearfix" style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                        <h5 class="pull-left" style="">
                            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png" style="height: 25px;"/>
                            お知らせ
                            <span class="font-color-BF2026" style="" >JobJapThai News Updates</span>
                        </h5>
                        <div class="clearfix" style="margin-top: 20px;"></div>

                        <ul class="news-list">
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <li class="clearfix border-bottom-1-ddd padding-top-10 padding-bottom-10">
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-8 no-padding">
                                        <a href="<?php echo get_permalink()?>"><h5 class="font-color-BF2026"><?php the_title(); ?></h5></a>
                                        <?php the_excerpt(); ?>
                                    </div>
                                    <div class="col-md-4" style="padding: 0px">
                                        <a href="<?php echo get_permalink()?>" class="img-tmb"><?php the_post_thumbnail( 'news-thumb' );?></a>
                                    </div>
                                </div>
                            </li>
                        <?php endwhile; endif;?>
                        </ul>

                    </div>

                    <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png" style="width: 100%; height: auto;"/>

                </div>

                <?php include_once('libs/sidebar.php'); ?>
            </div>
        </div>

    </section>
<?php include_once('footer.php');?>