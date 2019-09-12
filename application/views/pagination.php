<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeIgniter Pagination Example with Search Query Filter</title>
    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('/assets/css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url("/assets/css/bootstrap-theme.css"); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('/assets/css/pagination.css'); ?>" rel="stylesheet">

    <!-- datepickerTW CSS -->
    <link href="<?php echo base_url('/assets/css/jquery-ui.css'); ?>" rel="stylesheet">

    <!-- timepicker CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/jquery.timepicker.css'); ?>">
    
    <!-- Jquery JS -->
    <script src="<?php echo base_url('/assets/js/jquery-3.2.1.js') ?>"></script>

    <!-- Jquery UI JS -->
    <script src="<?php echo base_url('/assets/js/jquery-ui.js'); ?>"></script>

    <!-- timepicker JS -->
    <script src="<?php echo base_url('/assets/js/jquery.timepicker.js'); ?>"></script>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="<?php echo base_url('/assets/js/ie8-responsive-file-warning.js'); ?>"></script><![endif]-->
    <script src="<?php echo base_url('/assets/js/ie-emulation-modes-warning.js'); ?>"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url('/assets/js/html5shiv.min.js'); ?>"></script>
      <script src="<?php echo base_url('/assets/js/respond.min.js'); ?>"></script>
    <![endif]-->
  </head>

    <style type="text/css">
    .bg-border {
        border: 1px solid #ddd;
        border-radius: 4px 4px;
        padding: 15px 15px;
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
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="/bs3/Examples/navbar">Default <span class="sr-only">(current)</span></a></li>
              <li><a href="#Static top">Static top</a></li>
              <li class="active"><a href="#Fixed top">坂本龍馬，你好</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<div class="container">
    <div class="starter-template">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 well">
        <?php 
        $attr = array("class" => "form-horizontal", "role" => "form", "id" => "form1", "name" => "form1");
        echo form_open("pagination/search", $attr);?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-info dropdown-toggle select_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span id="select_option_title"></span></button>
                                <ul class="dropdown-menu">
                                    <li class="seach_option" name="所有資料" value="seach_0"><a></a></li>所有資料
                                    <li class="seach_option" name="會議/活動" value="seach_1"><a>會議/活動</a></li>
                                    <li class="seach_option" name="教師" value="seach_2"><a>教師</a></li>
                                    <li class="seach_option" name="學年(期)" value="seach_3"><a>學年(期)</a></li>
                                </ul>
                            </div><!-- /btn-group -->
                            <input type="text" class="form-control" aria-label="..." placeholder="Search for Data..." value="<?php echo set_value("search_data"); ?>"  name="search_data" />
                            <input type="hidden" name="sec_option" id="sec_option">
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-md-6">
                        <input id="btn_search" name="btn_search" type="submit" class="btn btn-danger"/>
                        <a href="<?php echo base_url("pagination"); ?>" class="btn btn-primary">Show All</a>
                    </div>
                </div><!-- /.row -->
        <?php echo form_close(); ?>
        </div>
    </div>

