    <style type="text/css">
    i{
      padding: 0 0 0 0;
    }
    </style>
    <div class="container">
        <h1 style="font-size:20pt"><?php echo $page_title; ?></h1>
        <br />
        <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> 新增使用者</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> 刷新</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>權限</th>
                    <th>姓名</th>
                    <th>帳號</th>
                    <th>新增時間</th>
                    <th>狀態</th>
                    <th style="width:125px;">操作</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>權限</th>
                <th>姓名</th>
                <th>帳號</th>
                <th>新增時間</th>
                <th>狀態</th>
                <th>操作</th>
            </tr>
            </tfoot>
        </table>
    </div>



<script type="text/javascript">

var save_method; //for save method string
var table;


$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('sys_user/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],

    });

    //datepicker
    //$('.datepicker').datepicker({
       // autoclose: true,
        //format: "yyyy-mm-dd",
        //todayHighlight: true,
        //orientation: "top auto",
       // todayBtn: true,
        //todayHighlight: true,  
    //});

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});

function ac_type(){
    //
    $('[name="ac_type"]').append("<option value= X  selected= selected>停用</option>+<option value= O >啟用</option>");

}



function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('[name="authority"], [name="ac_type"]').empty();
    var jsonData = {"type": "add"};

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('sys_user/ajax_list')?>",
        data: jsonData, 
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="authority"], #btnSave').attr('disabled', false);
            $('[name="authority"]').append("<option value= no > -- 請選擇 -- </option>");
            for(i=0; i<data.data.length; i++){
                $('[name="authority"]').append("<option value='"+data.data[i].authority_id+"'>"+data.data[i].authority_name+"</option>");
            }
            //console.log(data.data.length);

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('資料有誤，請聯絡程式設計師');
        }
    });
    
    ac_type();
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text("新增帳號"); // Set Title to Bootstrap modal title
}

function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('[name="authority"], [name="ac_type"]').empty();


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('sys_user/ajax_edit/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data.type_fromat == "O"){
                $('[name="id"]').val(data.id);
                $('[name="firstname"]').val(data.firstname);
                $('[name="lastname"]').val(data.lastname);
                $('[name="ac_mail"], [name="oemail"]').val(data.ac_mail);
                $('[name="ac_type"]').val();
                ac_type();
                if(data.ac_type == "O"){
                    $('[name="ac_type"] option[value=O]').attr('selected', 'selected');
                }
            
                if(data.aname == "L"){
                    for(i=0; i<data.authority_list.length; i++){
                        var like_key = null;
                        if(data.authority_list[i].authority_id == data.authority){
                            like_key = "selected='selected'";
                        }
                        $('[name="authority"]').append("<option value='"+data.authority_list[i].authority_id+"' "+ like_key +">"+data.authority_list[i].authority_name+"</option>");
                    }
                    $('[name="authority"], #btnSave').attr('disabled', false);

                }else if(data.aname == "H"){
                    $('[name="authority"]').append("<option>root</option>").attr('disabled', true);
                    $("#btnSave").attr('disabled', true);
                
                }

                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text("編輯帳號"); // Set title to Bootstrap modal title
            }else{
                alert("權限不足，無法進行修改！！");
            }

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('無法取得該名使用者資料，請聯絡程式設計師');
        }
    });
    
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('sys_user/ajax_add')?>";
    } else {
        url = "<?php echo site_url('sys_user/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function delete_person(id)
{
    if(confirm('是否確定刪除該名使用者?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('sys_user/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                if(data.type_fromat == "O"){
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                }else{
                    alert("權限不足，無法進行修改！！");
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('刪除失敗，請聯絡程式設計師');
            }
        });

    }
}

</script>

<!-- Bootstrap modal -->

<div class="modal fade" id="modal_form" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <input type="hidden" value="" name="oemail"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">姓</label>
                            <div class="col-md-9">
                                <input name="lastname" placeholder="Last Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">名</label>
                            <div class="col-md-9">
                                <input name="firstname" placeholder="First Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">信箱</label>
                            <div class="col-md-9">
                                <input name="ac_mail" placeholder="E-Mail" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">密碼</label>
                            <div class="col-md-9">
                                <input name="password" placeholder="Password" class="form-control"  type="password">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">確認密碼</label>
                            <div class="col-md-9">
                                <input name="confirm_password" placeholder="Confirm Password" class="form-control"  type="password">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">權限</label>
                            <div class="col-md-9">
                                <select name="authority" class="form-control">
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">狀態</label>
                            <div class="col-md-9">
                                <select name="ac_type" class="form-control">
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
</body>
</html>

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/assets/js/bootstrap.min.js'); ?>"></script>