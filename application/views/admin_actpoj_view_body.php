    <div class="container">
        <div class="starter-template">
            <div class="row"> 
                <div class="col-lg-15"> 
                   <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#hometab" role="tab" data-toggle="tab">活動資料</a></li>
                        <li id="tab_participants" style="display:none;"><a href="#list_of_participants" role="tab" data-toggle="tab">參加人員名單<span id="act_par_num"></span></a></li>
                    </ul>
                   <!-- Nav tabs end -->
               <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="hometab">
                        <div class="panel panel-default"> 
                            <div class="panel-heading"> 
                                <b><?php echo $datalist["title_semester"]." 學年佛光大學 ".$datalist[0]->activity_name; ?></b>
                            </div> 
                            <div class="panel-body"> 
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-hover  text-left">
                                            <today>            
                                                <tr><td>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label text-right col-md-offset-2">學年度</label>
                
                    
                                                        <div class="col-md-3"><?php echo $datalist[0]->semester; ?></div>
                                                    </div>
                                                </td></tr>
                                                <tr><td>
                                                    <div class="form-group ">
                                                        <label for="" class="col-sm-3 control-label text-right col-md-offset-2">活動日期</label>
                
                                                        <div class="col-sm-6"><?php echo $datalist["activity_date"]; ?></div>
                                                    </div>
                                                </td></tr>
                                                <tr><td>
                                                    <div class="form-group ">
                                                        <label for="" class="col-sm-3 control-label text-right col-md-offset-2">活動時間</label>
                                                        <div class="col-sm-6"><?php echo $datalist["activity_time"]; ?></div>
                                                    </div>
                                                </td></tr>
                                                <tr><td>
                                                    <div class="form-group ">
                                                        <label for="" class="col-sm-3 control-label text-right col-md-offset-2">活動名稱</label>
                                                        <div class="col-sm-6"><?php echo $datalist["tmp_act_name"]; ?></div>
                                                    </div>
                                                </td></tr>
                                                <tr><td>
                                                    <div class="form-group ">
                                                        <label for="" class="col-sm-3 control-label text-right col-md-offset-2">活動地點</label>
                                                        <div class="col-sm-6"><?php echo $datalist[0]->activity_location; ?></div>
                                                    </div>
                                                </td></tr>
                                                <tr><td>
                                                    <div class="form-group ">
                                                        <label for="" class="col-sm-3 control-label text-right col-md-offset-2">主題</label>
                                                        <div class="col-sm-6"><?php echo $datalist[0]->topic; ?></div>
                                                    </div>
                                                </td></tr>
                                                <tr><td>
                                                    <div class="form-group ">
                                                        <label for="" class="col-sm-3 control-label text-right col-md-offset-2">主講人所屬單位</label>
                                                        <div class="col-sm-6"><?php echo $datalist[0]->speaker_dep; ?></div>
                                                    </div>
                                                </td></tr>
                                                <tr><td>
                                                    <div class="form-group ">
                                                        <label for="" class="col-sm-3 control-label text-right col-md-offset-2">主講人</label>
                                                        <div class="col-sm-6"><?php echo $datalist[0]->speaker_name; ?></div>
                                                    </div>
                                                <tr><td>
                                           </today>
                                       </table>
                                   </div>
                               </div>
                           </div> 
                       </div>
                   </div>
                   <!-- Tab pane list_of_participants start -->
                   <div class="tab-pane" id="list_of_participants"><BR>

                       <table cellpadding="1" cellspacing="1" id="staff_list" class="display" width="100%">
                           <thead>
                              <tr>
                                  <th>#</th>
                                  <th>科系</th>
                                  <th>姓名</th>
                                  <th>獲益程度</th>
                                  <th>滿意程度</th>
                                  <th>信箱</th>
                                  <th>動作</th>
                              </tr>
                           </thead>
                       </table>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">新增</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <select class="form-control" id="up_college_dep" name="up_college" placeholder="學院">
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="up_teach_dep" name="up_teach_dep" placeholder="系所">
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="up_staff_mail" name="up_staff_mail" placeholder="參加人員信箱">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="up_staff_name" name="up_staff_name" placeholder="參加人員">
                </div>
                <div class="form-group">
                    <h4>問卷調查 修改</h4>
                </div>
                <br>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">1.參與本次活動的獲益程度&nbsp;&nbsp;&nbsp;</label>
                    <div class="row">
                        <div class="col-sm-3 col-md-offset-3">
                            <select class="form-control" id="up_q1" name="up_q1"></select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">2.對於活動整體的滿意程度&nbsp;&nbsp;&nbsp;</label>
                    <div class="row">
                        <div class="col-sm-3 col-md-offset-3">
                            <select class="form-control" id="up_q2" name="up_q2"></select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">3.對於活動內容的滿意程度&nbsp;&nbsp;&nbsp;</label>
                    <div class="row">
                        <div class="col-sm-3 col-md-offset-3">
                            <select class="form-control" id="up_q3" name="up_q3"></select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-5 control-label">4.對於講者安排的滿意程度&nbsp;&nbsp;&nbsp;</label>
                    <div class="row">
                        <div class="col-sm-3 col-md-offset-3">
                            <select class="form-control" id="up_q4" name="up_q4"></select>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <input type="hidden" id="pcode" name="pcode">
                <input type="hidden" id="omail" name="omail">
                <button type="button" class="btn btn-danger" data-dismiss="modal">關閉</button>
                <button type="button" class="btn btn-primary" id="btnEdit">存檔</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">



</script>
                    </div>
                    <!-- Tab pane list_of_participants End -->
                    <BR>
                <div class="row">
                    <a type="button" class="btn btn-warning btn-sm" href="<?php echo base_url("act_poj/update?id=".$datalist[0]->activity_code."&hp=".$history_page); ?>" >修改活動資料</a>
                    <a type="button" class="btn btn-primary btn-sm" href="<?php echo base_url("act_poj/participants_form?id=".$datalist[0]->activity_code."&hp=".$history_page); ?>" >新增參加人員</a>
                    <a type="button" class="btn btn-success btn-sm" href="<?php echo base_url("act_poj".$this_history_page); ?>" >上一頁</a>
                </div>
            </div> 
            <!--/col--> 
        </div> 
        <!--/条件查找--> 
    </div>
    

</div>
    <script type="text/javascript">
        var omail = $("#up_staff_mail").val();
        $("#myModal").bootstrapValidator({
        message: "尚未驗證",
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            up_staff_name: {
                validators: {
                    notEmpty: {
                        message: "【 參加人員 】尚未輸入"
                    }
                }
            },
            up_staff_mail: {                 
                validators: {
                    notEmpty: {
                        message: "請輸入參加人員電子信箱"
                    },
                    emailAddress: {
                        message: "參加人員電子信箱格式錯誤"
                    },
                    remote: {
                        url: "validators_data",
                        async: false,
                        data: {
                                    stype: function(validator){
                                                return "1";
                                            }, 
                                    "pcode": function(validator){
                                                return $("#pcode").val();
                                            },
                                    "oE-mail": function(validators){
                                                return $("#omail").val();
                                    }
                        }, 
                        type: "POST", 
                        delay: 500,
                        message: "參加人員電子信箱重複"
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
                            var field_name = $($field).attr('name');
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
    });
    </script>
    <!-- Form Page JavaScript -->
    <script src="<?php echo base_url('/assets/js/js_lib.js'); ?>"></script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/assets/js/bootstrap.min.js'); ?>"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url('/assets/js/ie10-viewport-bug-workaround.js'); ?>"></script>
</body>
</html>