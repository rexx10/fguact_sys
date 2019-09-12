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