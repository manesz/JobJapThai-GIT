<?php 
include_once('header.php');
include_once("libs/nav.php");
?>
<section class="container-fluid" style="margin-top: 10px;">

        <div class="container wrapper">
            <div class="row">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="col-md-8">

                    <div class="clearfix" style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
                        <h5 class="pull-left" style="">
                            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/icon-title.png" style="height: 25px;"/>
                            <span class="font-color-BF2026" style="" ><?php the_title(); ?></span>
                        </h5>
                        <div class="clearfix" style="margin-top: 20px;"></div>

                        <?php the_content();?>

                    </div>

                    <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png" style="width: 100%; height: auto;"/>

                </div>
<?php endwhile; endif;?>
                <?php include_once(get_template_directory()."/libs/sidebar.php"); ?>
            </div>
        </div>

    </section>
<?php include_once('footer.php');?>