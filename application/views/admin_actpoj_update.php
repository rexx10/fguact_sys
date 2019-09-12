<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/Content/AssetsBS3/img/favicon.ico">

    <title><?php echo $page_title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('/assets/css/bootstrap.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('/assets/css/starter-template.css'); ?>" rel="stylesheet">

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
        <div class="modal-header text-center">
            <h1>活動資料 修改</h1>  
        </div>
      <div class="starter-template">
        <!--/form start -->
        <form class="form-horizontal col-sm-8 col-md-offset-2 " role="form" method="POST" action="<?php echo base_url("/act_poj/update_data") ?>">
            <div class="form-group">
                <label for="semester" class="col-sm-3 control-label">學年</label>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control semester" id="semester" name="semester" value="<?php echo $update_data_list[0]->semester; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">活動日期</label>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control activity_date" id="s_activity_date" placeholder="活動日期" name="activity_date" value="<?php echo $update_data_list["activity_date"]; ?>" title="請輸入活動日期" autocomplete="off">
                    </div>                    
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">活動時間</label>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="text" class="form-control activity_time" id="s_activity_time" placeholder="開始時間" value="<?php echo $update_data_list["activity_time_start"]; ?>" name="s_activity_time" autocomplete="off">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control activity_time" id="e_activity_time" placeholder="結束時間" value="<?php echo $update_data_list["activity_time_end"]; ?>" name="e_activity_time" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">活動名稱</label>
                <div class="row">
                    <div class="col-sm-6">
                        <select class="form-control up_activity_name" id="up_activity_name" name="activity_name">
                            <option value="0" selected="selected"> --請選擇-- </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">項次</label>
                <div class="row">
                    <div class="col-sm-6">
                        <select class="form-control up_sec_item" id="up_sec_item" name="sec_item" disabled>
                             <option value="0" selected="selected"> --請選擇-- </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">地點</label>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="activity_location" value="<?php echo $update_data_list[0]->activity_location; ?>" placeholder="地點" name="activity_location">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">主題</label>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="topic" value="<?php echo $update_data_list[0]->topic; ?>" placeholder="主題" name="topic">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">主講人所屬單位</label>
                <div class="row">
                    <div class="col-sm-6">
                        <select class="form-control up_speaker_dep" id="up_speaker_dep" name="speaker_dep">
                             <option value="0" selected="selected"> --請選擇-- </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">主講人</label>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="speaker_name" value="<?php echo $update_data_list[0]->speaker_name; ?>" placeholder="主講人" name="speaker_name">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <input type="hidden" name="id" value="<?php echo $update_data_list[0]->activity_code;  ?>">
                    <input type="hidden" name="hp" value="<?php echo $history_page;  ?>">
                    <button type="submit" class="btn btn-success">確定</button>
                    <a type="button" class="btn btn-primary" href="<?php echo base_url($this_history_page."?id=".$update_data_list[0]->activity_code)."&hp=".$history_page; ?>" >取消</a>
                </div>
        
            </div>
            </form>
      </div>
    </div><!-- /.container -->

    <!-- Form Page JavaScr -->
    <script src="<?php echo base_url('/assets/js/min_go_date.js'); ?>"></script>
    <script src="<?php echo base_url('/assets/js/js_lib.js'); ?>"></script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/assets/js/bootstrap.min.js'); ?>"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url('/assets/js/ie10-viewport-bug-workaround.js'); ?>"></script>
  </body>
</html>