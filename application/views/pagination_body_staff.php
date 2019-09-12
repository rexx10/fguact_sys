    <div class="row">
        <div class="col-md-8 col-md-offset-2 bg-border">
            <div class="navbar-form navbar-left hidden-xs">
                <div class="form-group">
                    <select class="form-control" name="data_type" id="data_type">
                        <option value="0">資料格式</option>
                        <option value="by_staff">人員清單</option>
                        <option value="by_activity">教師活動</option>
                        <option value="by_semester">學年/學期</option>
                    </select>
                    <select class="form-control" name="export_type" id="export_type">
                        <option value="0">匯出方式</option>
                        <option value="to_pdf">PDF</option>
                        <option value="to_print">列印</option>
                    </select> 
                    <input type="hidden" name="seach_val" id="seach_val">                
                </div>
                <button type="submit" class="btn btn-success" id="f_export">匯出</button>
            </div>
            <table class="table table-striped table-hover text-left" width="100%">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="CheckAll" id="CheckAll"></th>
                        <th>#</th>
                        <th>學院</th>
                        <th>系所</th>
                        <th>參加人員姓名</th>
                        <th>E-MAIL</th>
                    </tr>
                </thead>
                <tbody>
                <?php for ($i = 0; $i < count($booklist); ++$i) { ?>
                <tr>
                    <th><input type="checkbox" name="ac[]" value="<?php echo $booklist[$i]->activity_code."-".$booklist[$i]->participants_code; ?>"></th>
                    <td><?php echo ($page+$i+1); ?></td>
                    <td><?php echo $booklist[$i]->college_name; ?></td>
                    <td><?php echo $booklist[$i]->teach_dep_name; ?></td>
                    <td><?php echo $booklist[$i]->staff_name; ?></td>
                    <td><?php echo $booklist[$i]->mail; ?></td>
                    <!--<td><a type="button" class="btn btn-warning btn-xs" href="#" >查看</a></td>-->
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

        
        $("#export_type").click(function(){
            if($("#export_type").val() == "to_print"){
                $("#f_export").text("列印");
            }else{
                $("#f_export").text("匯出");
            }
        });
        $("#f_export").click(function(){
            if($("#data_type").val() == 0){
                alert("請選擇資料匯出格式!");
                return false;
            }
            if($("#export_type").val() == 0){
                alert("請選擇資料匯出方式!");
                return false;
            }

            var cbxVehicle = new Array();
            $('input:checkbox:checked[name="ac[]"]').each(function(i){

                cbxVehicle[i] = this.value; 

            });
            if(cbxVehicle.length == 0){
                alert("尚未選取資料!");
                return false;
            }

            //switch($("#export_type").val()){
                //case "to_pdf":
                    //window.location.href = "getvalu?id=" + cbxVehicle + "&data_typ=" + $("#data_typ").val();
                    window.open("<?php echo base_url("pagination/"); ?>export_data?id=" + cbxVehicle + "&data_type=" + $("#data_type").val() + "&export_type=" + $("#export_type").val() + "&tmp_search_val=" + $("#tmp_search_val").val());
                    //break;

                //case "to_print":
                 //   break;

            //}
        });
       

        
    $(document).ready(function(){
        $("#CheckAll").click(function(){
            if($("#CheckAll").prop("checked")){//如果全選按鈕有被選擇的話（被選擇是true）
                $("input[name='ac[]']").each(function(){
                    $(this).prop("checked",true);//把所有的核取方框的property都變成勾選
                });
            }else{
                $("input[name='ac[]']").each(function(){
                    $(this).prop("checked",false);//把所有的核方框的property都取消勾選
                });
            }
        });
        $("input[name='ac[]']").click(function(){
            $("#CheckAll").prop("checked", false);
        });

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