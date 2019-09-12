<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="icon" href="<?php echo base_url("assets/images/fguact.png") ?>">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" type="text/css" />
    
    <style type="text/css">
    @font-face {
  font-family: NewFont;
  src: url(<?php echo base_url("assets/fonts/FFF_Tusj.ttf"); ?>);
    }
    #login-form .input-group, #login-form .form-group {
        margin-top: 30px;
    }
    
    #login-form .btn-default {
        background-color: #EEE;
    }
    
    .brand {
        color: #CCC;
    }
    </style>
</head>
<body>
<div class="container" style="margin-top: 30px;">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <form id="login-form" method="post" action="<?php echo base_url("login/login") ?>" role="form">
                    <legend style="font-family: NewFont;font-size: 30px;">Login</legend>
                    <?php if (isset($login_Error)) { ?>
                    <div class="alert alert-danger text-center"><?php echo "登錄失敗！電子郵件ID或密碼錯誤！"; ?></div>
                    <?php } 
                          $CI =& get_instance();
                          $CI->load->library("session");
                          if(!empty($CI->session->userdata("check_error"))){
                    ?>
                    <div class="alert alert-danger text-center"><?php echo $CI->session->userdata("check_error"); ?></div>
                    <?php
                          }
                          $unsession_data_set = array("check_error", 
                                                      "__ci_last_regenerate"); 
                          $CI->session->unset_userdata($unsession_data_set);
                          $CI->session->sess_destroy();
                    ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="text" name="email" placeholder="Enter your email-id" required class="form-control" />
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" name="password" placeholder="Password" required class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block" />
                    </div>
                    <!--<div class="form-group">
                        <hr/>
                        <div class="col-sm-6" style="padding: 0;">New user? <a href="#">Sign Up here</a></div>
                        <div class="col-sm-6 text-right brand" style="padding: 0;">kodingmadesimple.com</div>
                    </div>-->
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>