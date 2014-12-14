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
                        <?php for($i=0;$i<=5;$i++):?>
                            <li class="clearfix border-bottom-1-ddd padding-top-10 padding-bottom-10">
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-8 no-padding">
                                        <a href="#"><h5 class="font-color-BF2026">Being on time for work, and other things we sacrifice for our morning coffee</h5></a>
                                        <p>British people are renowned for their ability to queue. Add to this their burgeoning love of coffee shops, and a tenth of Brits are turning up late to work.
                                        More than one in 10 people prioritise their morning cup of joe over getting to the office on time, a new study has found. Younger workers are even more lax: around a quarter of people between the ages of 16 and 34 said that stopping for coffee has made them late for work, compared with around 5pc of people over the age of 45.</p>
                                    </div>
                                    <div class="col-md-4" style="padding: 0px">
                                        <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/libs/img/news-01.png" style="width: 100%;"/></a>
                                    </div>
                                </div>
                            </li>
                        <?php endfor; ?>
                        </ul>

                    </div>

                    <img src="<?php echo get_template_directory_uri(); ?>/libs/img/blank-banner-ads-01.png" style="width: 100%; height: auto;"/>

                </div>

                <?php include_once('../sidebar.php'); ?>
            </div>
        </div>

    </section>