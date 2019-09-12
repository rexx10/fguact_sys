<div class="container">
    <div class="starter-template">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 well text-left">
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
            <table class="table table-striped table-hover text-left">
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
                    <td><a type="button" class="btn btn-warning btn-xs" href="<?php echo base_url("act_poj/view_act_list?id=".$booklist[$i]->activity_code."&hp=".$history_page); ?>" />查看</a>&nbsp;<button type="button" class="btn btn-danger btn-xs" name="sbtn_del_<?php echo ($page+$i+1); ?>" id="sbtn_del_<?php echo ($page+$i+1); ?>" value="<?php echo $booklist[$i]->activity_code; ?>" href="">刪除</button></td>
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

        $(":input[name^='sbtn_del_']").click(function(){ 
            if(confirm("是否確定要刪除？")){
                $.ajax({
                    url: "del_activity_data",
                    data: {"id": this.value},
                    type: "post",
                    success: function (backdata){
                        if(backdata){
                            location.reload();
                        }else{
                            alert("删除失败");
                        }
                    }, 
                    error: function (error){
                        console.log(error);
                    }
                });
            }
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