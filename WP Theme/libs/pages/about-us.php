<section class="container-fluid" style="margin-top: 10px;"><div class="container wrapper">
            <div class="row">
                <div class="col-md-12">

                    <div class="clearfix" style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 20px; margin-bottom: 10px;">
                        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/nav-logo-big.png" class=""/>
                        <h4 class="font-color-BF2026 margin-top-20" style="">เกี่ยวกับทีมงานผู้ก่อตั้งเว็บไซต์ Jobjapthai.com</h4>
                        <?php if (have_posts()) : while (have_posts()) : the_post(); the_content(); endwhile; endif;?>

                    </div>

                </div>

            </div>
        </div>

    </section>