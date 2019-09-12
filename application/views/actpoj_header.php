<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<?php echo base_url("assets/images/fguact.png") ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/Content/AssetsBS3/img/favicon.ico">

    <title><?php echo $page_title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url("/assets/css/bootstrap.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("/assets/css/bootstrap-theme.css"); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('/assets/css/starter-template.css'); ?>" rel="stylesheet">

    <!-- Bootstrap Validator CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css/bootstrapValidator.css"); ?>">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('/assets/css/pagination.css'); ?>" rel="stylesheet">

    <!-- datepickerTW CSS -->
    <link href="<?php echo base_url("/assets/css/jquery-ui.css"); ?>" rel="stylesheet">

    <!-- timepicker CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css/jquery.timepicker.css"); ?>">
    
    <link rel="stylesheet" type="text/css"  href="<?php echo base_url("/assets/css/jquery.dataTables.min.css"); ?>"/>


    <!-- Jquery JS -->
    <script src="<?php echo base_url('/assets/js/jquery-3.2.1.js') ?>"></script>

    <!-- Jquery UI JS -->
    <script src="<?php echo base_url('/assets/js/jquery-ui.js'); ?>"></script>

    <!-- Bootstrap validator JS -->
    <script src="<?php echo base_url("/assets/js/bootstrapValidator.js"); ?>"></script>

    <!-- timepicker JS -->
    <script src="<?php echo base_url('/assets/js/jquery.timepicker.js'); ?>"></script>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="<?php echo base_url('/assets/js/ie8-responsive-file-warning.js'); ?>"></script><![endif]-->
    <script src="<?php echo base_url('/assets/js/ie-emulation-modes-warning.js'); ?>"></script>
    <script src="<?php echo base_url('/assets/js/jquery.dataTables.min.js'); ?>"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url('/assets/js/html5shiv.min.js'); ?>"></script>
      <script src="<?php echo base_url('/assets/js/respond.min.js'); ?>"></script>
    <![endif]-->


    <style type="text/css">
    .panel-heading{
        font-size: 30px;
        text-align: center;
    }
    .panel-body{
        font-size: 17px;
    }
    .bg-border {
        border: 1px solid #ddd;
        border-radius: 4px 4px;
        padding: 15px 15px;
    }
    i{
      padding: 0 20px 0 0;
    }
    </style>

  </head>
  
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="
          <?php 

               if(!empty($login_level)){
                    if($login_level > 1){
                        echo base_url("act_poj/search");
                    }else{
                        echo base_url("pagination");
                    }
                }else{
                    echo "#Fixed top";
                }

          ?>
          ">佛光大學活動資料</a>

        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown active">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">活動選單 <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
              <?php 
                  $CI =& get_instance();
                  $CI->load->library("user");
                  if($CI->user->hasPermission("access", "act_poj/create")){
              ?>
                <li><a href="<?php echo base_url("act_poj/create"); ?>">活動資料建立</a></li>
              <?php
                  }
                  if($CI->user->hasPermission("access", "act_poj/search")){
              ?>
                <li><a href="<?php echo base_url("act_poj/search"); ?>">活動資料查詢</a></li>
                <!--<li><a href="#">Another action</a></li>-->
                <li class="divider"></li>
              <?php
                  }
                  if($CI->user->hasPermission("access", "pagination/index")){
              ?>
                <li><a href="<?php echo base_url("pagination"); ?>">一般活動資料查詢</a></li>
                <!--<li><a href="#">One more separated link</a></li>-->
              <?php
                  } 
              ?>
              </ul>
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
              <!--<li class="active"><a href="/bs3/Examples/navbar">Default <span class="sr-only">(current)</span></a></li>
              <li><a href="#Static top">Static top</a></li>-->
            <li class="dropdown active">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $login_firstname." (".$login_name.") "; ?>，你好 <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
              <?php if($CI->user->hasPermission("access", "sys_set/index")){ ?>
                <li><a href="<?php echo base_url("sys_set"); ?>">系統設定</a></li>
                <li class="divider"></li>
              <?php } ?>
                <li><a href="<?php echo base_url("logout"); ?>">登出</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>