<header class="container-fluid clearfix" style="background: #fff;">
    <div class="container">
        <div class="row">
            <nav class="col-md-12">
                <!---->
				<?php
if (has_nav_menu('primary')) {
    $primenu = wp_nav_menu(array('theme_location' => 'primary', 'echo' => TRUE, 'items_wrap' => '<ul id="topnav" class="nav-menu col-md-10 col-md-push-1">%3$s</ul>', 'walker' => new themeslug_walker_nav_menu(), 'container' => ''));
echo $primenu; unset($primenu);}else{?>
<ul class="nav-menu col-md-10 col-md-push-1">
                    <li class="col-md-2"><img src="<?php echo get_template_directory_uri(); ?>/libs/img/nav-logo-big.png" class="padding-top-10 pull-right" style="margin: auto 0 auto 0;"/></li>
                    <li class="col-md-2 text-center">
                        <a href="<?php echo get_site_url();?>/">
                            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/nav-home.png" class="" style=""/>
                            <h4><span class="font-color-BF2026">ホームページ</span><br/><br/>HOME</h4>
                        </a>
                    </li>
                    <li class="col-md-2 text-center">
                        <a href="<?php echo get_permalink(get_page_by_title('Seeking for Manpower'));?>" target="_blank" class="">
                            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/nav-employer.png" style=""/>
                            <h4><span class="font-color-BF2026">雇用主</span><br/><br/>SEEKING FOR MANPOWER</h4>
                        </a>
                    </li>
                    <li class="col-md-2 text-center">
                        <a href="<?php echo get_site_url();?>/news/" target="_blank">
                            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/nav-news.png" style=""/>
                            <h4><span class="font-color-BF2026">ニュース</span><br/><br/>NEWS</h4>
                        </a>
                    </li>
                    <li class="col-md-2 text-center">
                        <a href="<?php echo get_site_url();?>/about/" target="_blank">
                            <img src="<?php echo get_template_directory_uri(); ?>/libs/img/nav-about-us.png" style=""/>
                            <h4><span class="font-color-BF2026">私達について</span><br/><br/>ABOUT US</h4>
                        </a>
                    </li>
                    <li class="col-md-2 text-center">
                        <a href="<?php echo get_site_url();?>/contact/" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/libs/img/nav-contact-us.png" style=""/>
                        <h4><span class="font-color-BF2026">私達に連絡</span><br/><br/>CONTACT US</h4>
                        </a>
                    </li>
                </ul>
<?php }?>
            </nav>
        </div>
    </div>

</header> <!-- /nav -->