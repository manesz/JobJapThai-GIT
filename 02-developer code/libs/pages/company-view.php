<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 31/12/2557
 * Time: 11:38 น.
 */

get_template_part("header");
get_template_part("libs/nav");
?>

<section class="container-fluid" style="margin-top: 10px;">

    <div class="container wrapper">
        <div class="row">
            <div class="col-md-8">

                <div class="clearfix"
                     style="border: 1px #ddd solid; border-radius: 5px; background: #fff; padding: 10px; margin-bottom: 10px;">

                    <img src="libs/img/job-desc-01.jpg" style="width: 100%"/>

                    <h4 class="font-color-BF2026 clearfix" style="">
                        <span class="pull-left">BJC - Berli jucker Public Company Limited.</span>
                            <span class="pull-right">
                                <i class="glyphicon glyphicon-star font-color-BF2026"></i>
                                <button class="btn btn-warning" style="background: #BF2026; border: none;">Edit</button>
                            </span>
                    </h4>
                    <hr/>
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 30%">Company Website:</td>
                            <td style="width: 70%">http://www.bjc.co.th</td>
                        </tr>
                        <tr>
                            <td style="width: 30%">Address:</td>
                            <td style="width: 70%">99 Soi Rubia Sukhumvit 42, Phrakanong, Klongtoey, Bangkok 10110</td>
                        </tr>
                        <tr>
                            <td style="width: 30%">Tel:</td>
                            <td style="width: 70%">02-367-1410</td>
                        </tr>
                        <tr>
                            <td style="width: 30%">Fax:</td>
                            <td style="width: 70%">02-367-1594</td>
                        </tr>
                        <tr>
                            <td style="width: 30%">Email:</td>
                            <td style="width: 70%">pattarat@bjc.co.th, kusumad@bjc.co.th</td>
                        </tr>
                        <tr>
                            <td style="width: 30%">Contact:</td>
                            <td style="width: 70%">K. Kusuma duangpornprasert (ploy)</td>
                        </tr>
                    </table>
                    <hr/>
                    <h5><strong>Company Profile</strong></h5>

                    <p>
                        When the roots are strong, nothing can stop the growth.<br/><br/>

                        Founded in 1882, BJC has today a nationwide presence; a part of everyday life for every Thai who
                        uses and relies on our products and services.
                        BJC is a leading trading and manufacturing company with a staff is over 5,000 and annual sales
                        of 20billions baht, we enjoy a reputation for superior services and products. And as a highly
                        dynamic business group with several subsidiaries we currently invite high-caliber and
                        professional candidates to join this vibrantly active enterprise.<br/><br/>

                        For our supply chain: The BJC Group's five core business areas are:<br/>
                        1.Industrial Supply Chain<br/>
                        2.Consumer Supply Chain<br/>
                        3.Healthcare Supply Chain<br/><br/>

                        Build your career with one of the best in the business.
                        BJC is searching for high potential employees in many areas such as accounting, marketing,
                        medical, chemical, engineering, printing technology etc.
                    </p>
                    <hr/>
                    <h5 class="font-color-BF2026">All Job List</h5>

                    <div class="col-md-12 border-bottom-1-ddd no-padding" style="padding-bottom: 10px !important;">
                        <form>
                            <div class="col-md-3 no-padding">
                                <span class="pull-left">Positions</span>
                                <select id="searchList" class="pull-left form-control">
                                    <option>10</option>
                                    <option>50</option>
                                    <option>100</option>
                                    <option>All</option>
                                </select>
                            </div>
                            <div class="col-md-push-6 col-md-3 no-padding">
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

                    <ul class="job-list no-padding">
                        <?php for ($i = 0; $i <= 6; $i++): ?>
                            <li class="clearfix border-bottom-1-ddd padding-top-10 padding-bottom-10">
                                <div class="col-md-12">
                                    <div class="col-md-2" style="padding: 0px">
                                        <a href="job-desc.php" target="_blank"><img src="libs/img/blank-logo.png"
                                                                                    style="width: 100%;"/></a>
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="font-color-BF2026">
                                            <a href="job-desc.php" target="_blank">Japanese Interpreter (JLPT Level 2 or
                                                1)</a>
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

                    <div class="col-md-12 margin-top-20">
                        <button type="button" id="applyNow" name="applyNow" class="btn btn-default no-border col-md-2">
                            <span class="glyphicon glyphicon-ok"></span>
                            apply now
                        </button>
                        <button type="button" id="addFavorite" name="addFavorite"
                                class="btn btn-default no-border col-md-2">
                            <span class="glyphicon glyphicon-star"></span>
                            add favorite
                        </button>
                        <button type="button" id="viewAllFavorite" name="viewAllFavorite"
                                class="btn btn-default no-border col-md-2">
                            <span class="glyphicon glyphicon-folder-open"></span>
                            all favorite
                        </button>
                        <button type="button" id="map" name="map" class="btn btn-default no-border col-md-2">
                            <span class="glyphicon glyphicon-map-marker"></span>
                            map
                        </button>
                        <button type="button" id="print" name="print" class="btn btn-default no-border col-md-2">
                            <span class="glyphicon glyphicon-print"></span>
                            print
                        </button>
                        <button type="button" id="share" name="share" class="btn btn-default no-border col-md-2">
                            <span class="glyphicon glyphicon-share"></span>
                            share
                        </button>
                    </div>

                </div>

                <img src="libs/img/blank-banner-ads-01.png" style="width: 100%; height: auto;"/>

            </div>

            <?php get_template_part("libs/pages/sidebar"); ?>
        </div>
    </div>

</section>

<?php get_template_part("footer"); ?>
