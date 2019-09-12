    <div class="container">
        <div class="starter-template">
            <div class="row"> 
                <div class="col-lg-15"> 
                   <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#hometab" role="tab" data-toggle="tab">活動資料</a></li>
                        <li id="tab_participants" style="display:none;"><a href="#list_of_participants" role="tab" data-toggle="tab">參加人員名單<span id="spar_num"></span></a></li>
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
                              </tr>
                           </thead>
                       </table>

                    </div>
                    <!-- Tab pane list_of_participants End -->
                    <BR>
                <div class="row">
                    <a type="button" class="btn btn-success btn-sm" href="<?php echo base_url("pagination".$previous_page); ?>" >上一頁</a>
                </div>
            </div> 
            <!--/col--> 
        </div> 
        <!--/条件查找--> 
    </div>
</div>
    <!-- Form Page JavaScript -->
    <script src="<?php echo base_url('/assets/js/pagination_js_lib.js'); ?>"></script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/assets/js/bootstrap.min.js'); ?>"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url('/assets/js/ie10-viewport-bug-workaround.js'); ?>"></script>
</body>
</html>