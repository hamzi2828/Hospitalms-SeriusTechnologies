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
    <meta name="MobileOptimized" content="320">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="<?php echo base_url () ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo base_url () ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo base_url () ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet"
          type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url () ?>assets/plugins/select2/select2_metro.css"/>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="<?php echo base_url () ?>assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url () ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url () ?>assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url () ?>assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url () ?>assets/css/themes/default.css" rel="stylesheet" type="text/css"
          id="style_color"/>
    <link href="<?php echo base_url () ?>assets/css/pages/login-soft.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url () ?>assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<?php
    if ( !empty( $background ) ) {
        $backgroundImage = $background -> login_background;
    }
    else {
        $backgroundImage = base_url ( '/assets/img/slider_blue_03.jpg' );
    }
    if ( !empty( $logo ) ) {
        $logoImage = $logo -> logo;
    }
    else {
        $logoImage = '';
    }
?>
<body class="login" style="background: url(<?php echo $backgroundImage ?>); background-size: cover">
<!-- BEGIN LOGO -->
<div class="logo" style="margin-top: 25px;">
    <img src="<?php echo $logoImage ?>" alt="" style="width: 10%;"/>
</div>
<!-- END LOGO -->
