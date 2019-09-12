    <div class="container">
        <div class="modal-header text-center">
            <h1>活動資料 建立</h1>  
        </div>
      <div class="starter-template">
        <!--/form start -->
        <form class="form-horizontal col-sm-8 col-md-offset-2" role="form" method="POST" action="<?php echo base_url("/act_poj/create_data"); ?>">
            <div class="form-group">
                <label for="semester" class="col-sm-3 control-label">學年</label>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control semester" id="semester" name="semester">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">活動日期</label>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control activity_date" id="s_activity_date" placeholder="活動日期" name="activity_date" title="請輸入活動日期" autocomplete="off">
                    </div>                    
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">活動時間</label>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="text" class="form-control activity_time" id="s_activity_time" placeholder="開始時間" name="s_activity_time" autocomplete="off">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control activity_time" id="e_activity_time" placeholder="結束時間" name="e_activity_time" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">活動名稱</label>
                <div class="row">
                    <div class="col-sm-6">
                        <select class="form-control activity_name" id="activity_name" name="activity_name">
                            <option value="0" selected="selected"> --請選擇-- </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">項次</label>
                <div class="row">
                    <div class="col-sm-6">
                        <select class="form-control sec_item" id="sec_item" name="sec_item" disabled>
                             <option value="0" selected="selected"> --請選擇-- </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">地點</label>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="activity_location" placeholder="地點" name="activity_location">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">主題</label>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="topic" placeholder="主題" name="topic">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">主講人所屬單位</label>
                <div class="row">
                    <div class="col-sm-6">
                        <select class="form-control speaker_dep" id="speaker_dep" name="speaker_dep">
                             <option value="0" selected="selected"> --請選擇-- </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">主講人</label>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="speaker_name" placeholder="主講人" name="speaker_name">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <dir class="row">
                    <button type="submit" class="btn btn-success">確定</button>
                    <a type="button" class="btn btn-primary" href="<?php echo base_url("act_poj/search"); ?>" >取消</a>
                </dir>
            </div>
        </form>
      </div>
    </div><!-- /.container -->
    <script type="text/javascript">
        $("form").bootstrapValidator({
        message: "尚未驗證",
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            semester: {
                validators: {
                    notEmpty: {
                        message: "【 學年 】尚未輸入"
                    }, 
                    stringLength: {
                        min: 3,
                        max: 5,
                        message: "【 學年 】資料長度在3到5位元"
                    },
                    regexp: {
                        regexp: /^[1-9]\d{1,2}-[1-2]$/,
                        message: "【 學年 】資料格式錯誤，範例：100-1"
                    }
                }
            },
            activity_date: {
                validators: {
                    notEmpty: {
                        message: "【 活動日期 】尚未選擇"
                    }
                }
            },
            s_activity_time: {                 
                validators: {
                    notEmpty: {
                        message: "【 活動開始時間 】尚未選擇"
                    }
                }
            },
            e_activity_time: {                 
                validators: {
                    notEmpty: {
                        message: "【 活動結束時間 】尚未選擇"
                    }
                }
            },
            activity_name: {
                validators: {
                    notEmpty: {
                        message: "【 活動名稱 】尚未選擇"
                    }
                }
            },
            sec_item: {
                validators: {
                    callback: {
                        callback: function(value, validator, $field){
                            //console.log( $("#activity_name :selected").text());
                            var field_name = $($field).attr("name");
                            if($("#activity_name :selected").text() == "雲水雅會" & $("#sec_item :selected").val() == 0){
                                return {
                                    valid: false,
                                    message: "【 活動項次 】尚未選擇"
                                }
                            }else{
                                $("form").bootstrapValidator("resetField", field_name )
                                     .bootstrapValidator("updateStatus", field_name, "NOT_VALIDATED");
                                $("form").bootstrapValidator("disableSubmitButtons", false);
                                return true;
                            }
                        }
                    }
                }
            },
            activity_location: {
                validators: {
                    notEmpty: {
                        message: "【 地點 】尚未輸入"
                    }, 
                    stringLength: {
                        min: 1,
                        max: 20,
                        message: "【 地點 】資料長度在1到20位元"
                    }
                }
            },
            topic: {
                validators: {
                    notEmpty: {
                        message: "【 主題 】尚未輸入"
                    }, 
                    stringLength: {
                        min: 1,
                        max: 50,
                        message: "【 地點 】資料長度在1到50位元"
                    }
                }
            },
            speaker_dep: {
                validators: {
                    notEmpty: {
                        message: "【 主講人所屬單位 】尚未選擇"
                    }
                }
            },
            speaker_name: {
                validators: {
                    notEmpty: {
                        message: "【 主講人姓名 】尚未輸入"
                    }, 
                    stringLength: {
                        min: 1,
                        max: 50,
                        message: "【 主講人姓名 】資料長度在1到20位元"
                    }
                }
            }
        }
    }).on('success.form.bv', function (e) {
        // Prevent form submission
        e.preventDefault();
        // Get the form instance
        var $form = $(e.target);
        // Get the BootstrapValidator instance
        var bv = $form.data('bootstrapValidator');
        // Use Ajax to submit form data
        $.post("create_data", $form.serialize(), function (data) {
            console.log(data.Status);
            if (data.Status == "ok") {
                window.location.href = "<?php echo base_url("act_poj/create"); ?>";
            }
            else if (data.Status == "error") {
                alert(data.Message);
            }
            else {
                alert("未知错误");
            }
        }, "json");
    });
    </script>

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

