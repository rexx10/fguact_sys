<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>

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
          <a class="navbar-brand" href="#Fixed top">佛光大學活動資料</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown active">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">系統選單 <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo base_url("act_poj/create"); ?>">活動資料建立</a></li>
                <li><a href="<?php echo base_url("act_poj/search"); ?>">活動資料查詢</a></li>
                <li><a href="#">Another action</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="/bs3/Examples/navbar">Default <span class="sr-only">(current)</span></a></li>
              <li><a href="#Static top">Static top</a></li>
            <li class="dropdown active">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">坂本龍馬，你好 <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">系統設定</a></li>
                <li><a href="#">Another action</a></li>
                <li class="divider"></li>
                <li><a href="#">登出</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<div class="container">
    <div class="starter-template">
 
<div class="row"> 
<div class="col-lg-10 col-md-offset-1"> 
<div class="panel panel-default"> 
<div class="panel-heading"> 
<b><?php echo $datalist["title_semester"]." 學年佛光大學 ".$datalist[0]->activity_name; ?></b>
</div> 
<div class="panel-body"> 

<div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover">
                <today>            
                    <tr><td><div class="form-group">
                <label for="" class="col-sm-3 control-label text-right col-md-offset-2">學年度</label>
                
                    
                    <div class="col-md-3"><?php echo $datalist[0]->semester; ?></div>
                    
               
            </div></td></tr>
                    <tr><td><div class="form-group ">
                <label for="" class="col-sm-3 control-label text-right col-md-offset-2">活動日期</label>
                
                    <div class="col-sm-6">
                    <?php echo $datalist["activity_date"]; ?>
                    </div>
               
            </div></td></tr>
            <tr><td><div class="form-group ">
                <label for="" class="col-sm-3 control-label text-right col-md-offset-2">活動時間</label>
                
                    <div class="col-sm-6">
                    <?php echo $datalist["activity_time"]; ?>
                    </div>
               
            </div></td></tr>
            <tr><td><div class="form-group ">
                <label for="" class="col-sm-3 control-label text-right col-md-offset-2">活動名稱</label>
                
                    <div class="col-sm-6">
                    <?php echo $datalist["tmp_act_name"]; ?>
                    </div>
               
            </div></td></tr>
            <tr><td><div class="form-group ">
                <label for="" class="col-sm-3 control-label text-right col-md-offset-2">活動地點</label>
                
                    <div class="col-sm-6">
                    <?php echo $datalist[0]->activity_location; ?>
                    </div>
               
            </div></td></tr>
            <tr><td><div class="form-group ">
                <label for="" class="col-sm-3 control-label text-right col-md-offset-2">主題</label>
                
                    <div class="col-sm-6">
                    <?php echo $datalist[0]->topic; ?>
                    </div>
               
            </div></td></tr>
            <tr><td><div class="form-group ">
                <label for="" class="col-sm-3 control-label text-right col-md-offset-2">主講人所屬單位</label>
                
                    <div class="col-sm-6">
                    <?php echo $datalist[0]->speaker_dep; ?>
                    </div>
               
            </div></td></tr>
            <tr><td><div class="form-group ">
                <label for="" class="col-sm-3 control-label text-right col-md-offset-2">主講人</label>
                
                    <div class="col-sm-6">
                    <?php echo $datalist[0]->speaker_name; ?>
                    </div>
               
            </div>
                </today>
            </table>
        </div>
        </div>
         <dir class="row  col-md-offset-4">
                    <a type="button" class="btn btn-warning btn-sm" href="<?php echo base_url("act_poj/update?id=".$datalist[0]->activity_code."&hp=".$history_page); ?>" >修改活動資料</a>
                    <a type="button" class="btn btn-primary btn-sm" href="#" >新增參加人員</a>
                    <a type="button" class="btn btn-danger btn-sm" href="<?php echo base_url("act_poj".$this_history_page); ?>" >上一頁</a>
            </div>
</div> 
</div> 
</div> 
<!--/col--> 
</div> 
<!--/条件查找--> 
</div>
    

</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/assets/js/bootstrap.min.js'); ?>"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url('/assets/js/ie10-viewport-bug-workaround.js'); ?>"></script>
</body>
</html>