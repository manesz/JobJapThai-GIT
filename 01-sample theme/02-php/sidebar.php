<aside class="col-md-4" style="">
    <div class="clearfix" style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding-bottom: 10px; margin-bottom: 10px;">
        <div style="background: #BF2026; margin: 20px 0 10px 0; padding : 5px; color: #fff;">における求職者ログイン Job Seeker Log in</div>
        <form>
            <div class="form-group clearfix" style="margin-bottom: 10px;">
                <label for="username" class="col-md-4" style="font-size: 12px; padding-right: 0px;">Email/Username :</label>
                <div class="col-md-8"><input id="username" name="username" class="form-control"></div>
            </div>
            <div class="form-group clearfix" style="margin-bottom: 10px;">
                <label for="password" class="col-md-4" style="font-size: 12px; padding-right: 0px;">Password :</label>
                <div class="col-md-8"><input id="password" name="password" type="password" class="form-control"></div>
            </div>
            <div class="form-group clearfix text-right" style="margin-bottom: 10px; padding-right: 15px;">
                <a>Forget your email</a> /
                <a>Forget password</a>
            </div>
            <div class="form-group clearfix" style="margin-bottom: 10px;">
                <button type="button" class="btn btn-success pull-right" style="margin-right: 15px;">Signin</button>
                <button type="button" class="btn btn-default pull-right" style="margin-right: 15px; border: none;">reset</button>
            </div>
        </form>
    </div>

    <div class="clearfix" style="<?php if(isset($page) && $page == "news"): echo "display: none; "; else: echo "display: block;"; endif;?> border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
        <h4 style="font-size: 16px !important;">
            <img src="libs/img/icon-title.png" style="height: 25px;"/>
            Find jobs
        </h4>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="active col-md-6 text-center" style="list-style: none; border: none;"><a href="#search" role="tab" data-toggle="tab">Search</a></li>
            <li class="col-md-6 text-center" style="list-style: none; border: none;"><a href="#advanceSearch" role="tab" data-toggle="tab">Advance Search</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="search" style="padding-top: 20px;">
                <form action="search.php" method="post">
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="location" class="" style="font-size: 12px; padding-right: 0px;">Search:</label>
                        <input type="text" id="textSearch" name="textSearch" class="form-control" placeholder="enter text search"/>
                    </div>
                    <div class="form-group clearfix text-center" style="margin: 10px 0 10px 0;">
                        <button type="submit" class="btn btn-default col-md-12" style="margin-right: 15px; border: none; background: #BF2026; color: #fff;">Find Job</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="advanceSearch">
                <form action="search.php" method="post">
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="location" class="" style="font-size: 12px; padding-right: 0px;">Location</label>
                        <select name="location" class="col-md-12 form-control"><option>All Locations</option></select>
                    </div>
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="position" class="" style="font-size: 12px; padding-right: 0px;">Position</label>
                        <select name="position" class="col-md-12 form-control"><option>All Position</option></select>
                    </div>
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="type" class="" style="font-size: 12px; padding-right: 0px;">Employer Type</label>
                        <select name="type" class="col-md-12 form-control"><option>All Type</option></select>
                    </div>
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="category" class="" style="font-size: 12px; padding-right: 0px;">Category</label>
                        <select name="category" class="col-md-12 form-control"><option>All Categories</option></select>
                    </div>
                    <div class="form-group clearfix" style="margin-bottom: 10px;">
                        <label for="subCategory" class="" style="font-size: 12px; padding-right: 0px;">Subcategory</label>
                        <select name="subCategory" class="col-md-12 form-control"><option>All Subcategory</option></select>
                    </div>
                    <div class="form-group clearfix text-center" style="margin: 10px 0 10px 0;">
                        <button type="submit" class="btn btn-default col-md-12" style="margin-right: 15px; border: none; background: #BF2026; color: #fff;">Find Job</button>
                    </div>
                </form>
            </div>
        </div>


    </div>

    <div class="clearfix" style="<?php if(isset($page) && $page == "news"): echo "display: block; "; else: echo "display: none;"; endif;?>border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">
        <h4 class="font-color-BF2026">
            <img src="libs/img/icon-title.png" style="height: 25px;"/>
            Top 5 Hilight Job
        </h4>

        <ul class="job-list no-padding margin-top-10">
            <?php for($i=0;$i<=4;$i++):?>
                <li class="clearfix border-bottom-1-ddd padding-top-10 padding-bottom-10">
                    <div class="col-md-12">
                        <div class="col-md-4" style="padding: 0px"><img src="libs/img/blank-logo.png" style="width: 100%;"/> </div>
                        <div class="col-md-8">
                            <h5 class="font-color-BF2026 no-margin">Japanese Interpreter (JLPT Level 2 or 1)</h5>
                            <p class="font-size-12">
                                <span class="font-color-4D94CC">Bangkok</span><br/>
                                Permanent<br/>
                                <span class="font-color-ddd">Aug 14, 2014</span><br/>
                            </p>
                        </div>
                    </div>
                </li>
            <?php endfor; ?>
        </ul>
    </div>

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1380481428850317&version=v2.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <div class="clearfix" style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">

        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1380481428850317&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-like-box" data-href="https://www.facebook.com/Jobjapthai" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="false"></div>

    </div>

    <img class="col-md-12 no-padding clearfix" src="libs/img/blank-banner-ads-02.png" width="100%"/>

    </div>
</aside><!-- END : aside.container-fluid -->