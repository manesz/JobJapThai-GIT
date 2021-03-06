<!doctype html>
<!--[if lt IE 7]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]>
<html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php bloginfo('name'); ?> &raquo; <?php is_front_page() ? bloginfo('description') : wp_title(); ?></title>
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/libs/images/apple-icon-touch.png">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/libs/css/bootstrap-datepicker.css">
    <!--[if IE]>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico"><![endif]-->
    <meta name="msapplication-TileColor" content="#f01d4f">
    <meta name="msapplication-TileImage"
          content="<?php echo get_template_directory_uri(); ?>/libs/images/win8-tile-icon.png"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"><?php $blog_title = get_bloginfo('name'); ?>
    <link rel="alternate" type="application/rss+xml" title="<?php echo $blog_title; ?>"
          href="<?php echo get_site_url(); ?>/?feed=rss2"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo get_template_directory_uri(); ?>/libs/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/libs/css/style.css"/>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/jquery.1.11.1.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrapValidator.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/bootstrap-datepicker.js"></script>
    <!--<script src="--><?php //echo get_template_directory_uri(); ?><!--/libs/js/bootstrap-modal.js"></script>-->

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/ie8-responsive-file-warning.js"></script>
    <![endif]-->
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/html5shiv.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/respond.min.js"></script>
    <![endif]-->
    <?php
    $showRegister = empty($_REQUEST['show_register']) ? false : true;
    ?>
    <script>
        $(document).ready(function () {
            $(".datepicker").datepicker();
            <?php if ($showRegister): ?>
            $("#modalRegister").modal('show');
            <?php endif; ?>
        });
        var url_post = "<?php echo home_url(); ?>/";
        var str_loading = '<div class="img_loading"><img src="<?php
    bloginfo('template_directory'); ?>/libs/images/loading.gif" width="40"/></div>';
    </script>
    <script src="<?php echo get_template_directory_uri(); ?>/libs/js/header.js"></script>


    <style type="text/css">
        .blockDiv {
            position: absolute;
            top: 0px;
            left: 0px;
            background-color: #FFF;
            width: 0px;
            height: 0px;
            z-index: 9998;
        }

        .img_loading {
            position: fixed;
            top: 40%;
            left: 50%;
            z-index: 99999!important;
        }
    </style>
</head>
<body <?php body_class(); ?> style="border-top: #ed1c24 5px solid;">
