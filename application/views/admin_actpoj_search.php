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
        <div class="col-md-8 col-md-offset-2 well">
        <?php 
        $attr = array("class" => "form-horizontal", "role" => "form", "id" => "form1", "name" => "form1");
        echo form_open("act_poj/search_data", $attr);?>
            <div class="form-group">
                <div class="col-md-6">
                    <input class="form-control" id="search_data" name="search_data" placeholder="Search for Book Name..." type="text" value="<?php echo set_value("search_data"); ?>" />
                </div>
                <div class="col-md-6">
                    <input id="btn_search" name="btn_search" type="submit" class="btn btn-danger" value="Search" />
                    <a href="<?php echo base_url("act_poj/search"); ?>" class="btn btn-primary">Show All</a>
                </div>
            </div>
        <?php echo form_close(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2 bg-border">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>學年度</th>
                    <th>活動日期</th>
                    <th>活動時間</th>
                    <th>活動名稱</th>
                    <th class="hidden-xs">主講人</th>
                    <th class="hidden-xs">主題</th>
                    <th>動作</th>
                    </tr>
                </thead>
                <tbody>
                <?php for ($i = 0; $i < count($booklist); ++$i) { ?>
                <tr>
                    <td><?php echo ($page+$i+1); ?></td>
                    <td><?php echo $booklist[$i]->semester; ?></td>
                    <td><?php echo $booklist[$i]->activity_date; ?></td>
                    <td><?php echo date("H:i", strtotime($booklist[$i]->activity_time_start))."~".date("H:i", strtotime($booklist[$i]->activity_time_end)); ?></td>
                    <td><?php echo $booklist[$i]->activity_name; ?></td>
                    <td class="hidden-xs"><?php echo $booklist[$i]->speaker_name; ?></td>
                    <td class="hidden-xs"><?php echo $booklist[$i]->topic; ?></td>
                    <td><a type="button" class="btn btn-warning btn-xs" href="<?php echo base_url("act_poj/view_act_list?id=".$booklist[$i]->activity_code."&hp=".$history_page); ?>" />查看</a></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php echo $pagination; ?>
        </div>
    </div>
</div>
    <script type="text/javascript">
        $("#select_option_title").text("查詢方式");
        $(".seach_option").click(function(){
            $(".select_button").text($(this).attr("name"));
            $("#sec_option").val($(this).attr("value"));
        });
    </script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/assets/js/bootstrap.min.js'); ?>"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url('/assets/js/ie10-viewport-bug-workaround.js'); ?>"></script>
</body>
</html>