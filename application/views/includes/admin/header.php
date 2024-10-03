<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title><?php echo strip_tags ( $title ) ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="MobileOptimized" content="320">
    <link rel="shortcut icon" href="<?php echo base_url ( '/assets/img/favicon.png' ) ?>"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="<?php echo base_url () ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo base_url () ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo base_url () ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet"
          type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="<?php echo base_url () ?>assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url () ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url () ?>assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url () ?>assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url () ?>assets/css/themes/default.css" rel="stylesheet" type="text/css"
          id="style_color"/>
    <!-- END THEME STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="<?php echo base_url () ?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url () ?>assets/plugins/select2/select2_metro.css"/>
    <link rel="stylesheet" href="<?php echo base_url () ?>assets/plugins/data-tables/DT_bootstrap.css"/>
    <!-- END PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url () ?>assets/plugins/bootstrap-datepicker/css/datepicker.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url () ?>assets/plugins/bootstrap-timepicker/compiled/timepicker.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url () ?>assets/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url () ?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url () ?>assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css"/>
    
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url () ?>assets/fontawesome-free-5.5.0-web/css/all.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url () ?>assets/fontawesome-free-5.5.0-web/css/fontawesome.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url () ?>assets/font-awesome/css/font-awesome.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url () ?>assets/spectrum/spectrum.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url () ?>assets/css/jquery.ui.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url ( '/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css' ) ?>"/>
    <link href="<?php echo base_url () ?>assets/css/custom.css?ver=<?php echo rand () ?>" rel="stylesheet"
          type="text/css"/>
    <script src="<?php echo base_url () ?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>

</head>
<style>
    .form-body {
        background: #f5f5f5;
    }

    .loader {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 999;
        background: rgba(187, 195, 192, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader img {
        margin: 250px auto 0 auto;
        display: block;
        float: none;
        text-align: CENTER;
    }

    .user {
        padding-top: 6px;
        font-size: 16px;
        font-weight: 600;
    }
</style>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
<div class="loader">
    <a href="javascript:void(0)" style="position: absolute;top: 45px;right: 25px;" onclick="close_loader()">
        <i class="fa fa-times-circle-o fa-3x"></i>
    </a>
    <i class="fa fa-cog fa-spin fa-5x fa-fw"></i>
    
<!--    <img src="--><?php //echo base_url () ?><!--/assets/img/loader.gif">-->
</div>
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="header-inner">
        <!-- BEGIN LOGO -->
        <a class="navbar-brand" href="<?php echo base_url () ?>"
           style="color: #fff;font-size: 25px;padding-left: 15px;">
            <?php echo site_slug ?>
        </a>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:void(0);" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <img src="<?php echo base_url () ?>assets/img/menu-toggler.png" alt=""/>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <ul class="nav navbar-nav pull-right">
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <li class="dropdown user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                   data-close-others="true">
                    <span class="username">
					<?php echo get_logged_in_user () -> name ?>
				</span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?php echo base_url ( '/user/profile/' . get_logged_in_user_id () ) ?>">
                            <i class="fa fa-cogs"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url ( 'logout' ) ?>">
                            <i class="fa fa-key"></i> Log Out
                        </a>
                    </li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->