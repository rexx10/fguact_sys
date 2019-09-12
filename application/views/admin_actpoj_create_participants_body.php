    <div class="container">
        <div class="modal-header text-center">
            <h1>參加活動人員 建立</h1>  
        </div>
        <div class="starter-template">
            <form class="form-horizontal col-sm-12" role="form" method="POST" action="<?php echo base_url("act_poj/create_participants"); ?>">
                <div class="row col-md-offset-3">
                    <div class="col-md-8 bg-border">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">學院</label>
                            <div class="row">
                                <div class="col-sm-7">
                                    <select class="form-control college_dep" id="college_dep" name="college">
                                        <option value=" " selected="selected"> --請選擇-- </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">系所</label>
                            <div class="row">
                                <div class="col-sm-7">
                                    <select class="form-control teach_dep" id="teach_dep" name="teach_dep" disabled>
                                        <option value=" " selected="selected"> --請選擇-- </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">參加人員信箱</label>
                            <div class="row">
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="e-mail" title="參加人員信箱">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">參加人員</label>
                            <div class="row">
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="staff" title="參加人員">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="modal-header text-center">
                                <h4><b>問卷調查</b></h4>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label">1.參與本次活動的獲益程度&nbsp;&nbsp;&nbsp;</label>
                            <div class="row">
                                <div class="col-sm-5">
                                    <select class="form-control question" id="question" name="q1">
                                        <option value="" selected="selected"> --請選擇-- </option>
                                        <option value="5"> 非常滿意 </option>
                                        <option value="4"> 滿意 </option>
                                        <option value="3"> 普通 </option>
                                        <option value="2"> 不滿意 </option>
                                        <option value="1"> 非常不滿意 </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label">2.對活動整體滿意程度&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <div class="row">
                                <div class="col-sm-5">
                                    <select class="form-control question2" id="question2" name="q2">
                                        <option value="" selected="selected"> --請選擇-- </option>
                                        <option value="5"> 非常滿意 </option>
                                        <option value="4"> 滿意 </option>
                                        <option value="3"> 普通 </option>
                                        <option value="2"> 不滿意 </option>
                                        <option value="1"> 非常不滿意 </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label">3.對於活動內容的滿意程度&nbsp;&nbsp;&nbsp;</label>
                            <div class="row">
                                <div class="col-sm-5">
                                    <select class="form-control question3" id="question3" name="q3">
                                        <option value="" selected="selected"> --請選擇-- </option>
                                        <option value="5"> 非常滿意 </option>
                                        <option value="4"> 滿意 </option>
                                        <option value="3"> 普通 </option>
                                        <option value="2"> 不滿意 </option>
                                        <option value="1"> 非常不滿意 </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-5 control-label">4.對於講者安排的滿意程度&nbsp;&nbsp;&nbsp;</label>
                            <div class="row">
                                <div class="col-sm-5">
                                    <select class="form-control question4" id="question4" name="q4">
                                        <option value="" selected="selected"> --請選擇-- </option>
                                        <option value="5"> 非常滿意 </option>
                                        <option value="4"> 滿意 </option>
                                        <option value="3"> 普通 </option>
                                        <option value="2"> 不滿意 </option>
                                        <option value="1"> 非常不滿意 </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    
                
                    </div>
                </div> <!-- .row -->
                <br>
                <div class="form-group">
                    <div class="row">
                        <input type="hidden" name="id" value="<?php echo $activity_code; ?>">
                        <input type="hidden" name="hp" value="<?php echo $history_page; ?>">
                        <button type="submit" class="btn btn-success">確定</button>
                        <a type="button" class="btn btn-primary" href="<?php echo base_url("act_poj".$history_page_path); ?>" >取消</a>
                    </div>
                </div>
            </form>
        </div><!-- .starter-template -->
    </div><!-- .container -->
<script type="text/javascript">
$("form").bootstrapValidator({
        message: "尚未驗證",
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            college: {
                validators: { 
                    callback: {
                        callback: function(value, validator, $field){
                            var field_name = $($field).attr("name");
                            if($("#college_dep :selected").val() == " "){
                                //console.log($("#teach_dep").prop("disabled"));
                               // console.log(field_name);
                                return {
                                    valid: false,
                                    message: "請選擇學院",                    
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
            teach_dep: {
                validators: { 
                    callback: {
                        callback: function(value, validator, $field){
                            var field_name = $($field).attr("name");
                            if($("#teach_dep :selected").val() == " "){
                                //console.log($("#teach_dep").prop("disabled"));
                                //console.log($("#college").prop("disabled"));
                                return {
                                    valid: false,
                                    message: "請選擇系所"                      
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
            "e-mail": {                 
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
                                                return "zero";
                                            }, 
                                    "e-mail": function(validator){
                                                return $("form :input[name='e-mail']").val();
                                            }, 
                                    "id": function(validator){
                                                return $("form :input[name='id']").val();
                                            }
                        }, 
                        type: "POST", 
                        delay: 500,
                        message: "參加人員電子信箱重複"
                    }
                }
            },
            staff: {
                message: "參加人員名稱尚未驗證",
                validators: {
                    notEmpty: {
                        message: "請輸入參加人員名稱"
                    },
                    stringLength: {
                        min: 1,
                        max: 40,
                        message: "參加人員姓名長度在1到40位元"
                    }
                }
            },
            q1: {
                validators: {
                    notEmpty: {
                        message: "【 題目一 】尚未選擇"
                    }
                }
            },
            q2: {
                validators: {
                    notEmpty: {
                        message: "【 題目二 】尚未選擇"
                    }
                }
            },
            q3: {
                validators: {
                    notEmpty: {
                        message: "【 題目三 】尚未選擇"
                    }
                }
            },
            q4: {
                validators: {
                    notEmpty: {
                        message: "【 題目四 】尚未選擇"
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
        $.post("create_participants", $form.serialize(), function (data) {
            console.log(data.Status);
            if (data.Status == "ok") {
                window.location.href = "<?php echo base_url("act_poj/view_act_list"); ?>?id=" + data.id + "&hp=" + data.hp;
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
    <script src="<?php echo base_url('/assets/js/js_lib.js'); ?>"></script>
    <!-- Bootstrap core JavaScript
        ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/assets/js/bootstrap.min.js'); ?>"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url('/assets/js/ie10-viewport-bug-workaround.js'); ?>"></script>
    </body>
</html>