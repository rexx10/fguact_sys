var this_selval;
function semseter_list(num)
{   /** Get Republic of China **/
    var school_yeqr_ar = new Array;
    var today = new Date();
    var this_year = today.getFullYear() - 1911;
    var this_month = today.getMonth() + 1;
    switch(num)
    {
        case 0:
            var semester_arr = new Array;
    
            for(i = 2; i > 0 ; i--)
            {            
                var this_school_year = this_year - i;
                for(j = 1; j <= 2; j++)
                {           
                    semester_arr[semester_arr.length] = this_school_year + "-" + j;
                }                
            }
            for(k = 0; k < 2; k++)
            {              
                var this_school_year = this_year + k;
                for(n = 1; n <= 2; n++)
                {    
                    semester_arr[semester_arr.length] = this_school_year + "-" + n;
                }                
            }

            return semester_arr;
            break;

         case 1:
             var this_semester = "";
             if(this_month >= 8 && this_month <= 12)
             {   //Get this semester
                return this_semester = this_year + "-" + 1;
             }
             else if(this_month >= 1 && this_month <= 7)
             {
                return this_semester = (this_year - 1) + "-" + 2;
             }
             break;
    }
}



function call_tmp_teach_dep(a, b){
    //
    var i = 0;
    $.ajax({
        url: "teach_dep_list?co_id=" + a,
        cache: false,
        type: "POST",
        dataType: "json",
        success: function function_name(data) {
            //依據第一層回傳的值去改變第二層的內容
            while (i < data.teach_dep_list.length) {
                if(b == data.teach_dep_list[i]){
                    var this_sel_type = "selected='selected'";
                }else{
                    var this_sel_type = "";
                }
                $("#up_teach_dep").append("<option value='" + data.teach_dep_list[i] + "' " + this_sel_type + ">" + data.teach_dep_list[i] + "</option>");
                i++;
            }
        }, 
    error:function(e){}
    });
}



function _editFun(pcode, staff_name, mail, c_name, tdn, history_q) {

    var history_q_arr = history_q.split("-");
    var data = "";
    var counts = 0;


    $('#up_college_dep').empty();
    $('#up_teach_dep').empty();
    //** Dynamic access to activity data name **//
    $.ajax({
    url: "college_dep_list",
    cache: false,
    type: "POST",
    dataType: 'json',
    success: function(data){ 
                                for(i=0; i<data.college_dep_id.length;i++){
                                    if(c_name == data.college_dep[i]){
                                        var this_sel_type = "selected='selected'";
                                        //this_selval = data.sel_activity_name;
                                    }else{
                                        var this_sel_type = "";
                                    }
                                    $("#up_college_dep").append("<option value='"+data.college_dep_id[i]+"_"+data.college_dep[i]+"'" + this_sel_type + ">"+data.college_dep[i]+"</option>");

                                }
                                if(counts == 0){
                                    call_tmp_teach_dep($('#up_college_dep option:selected').val(), tdn);
                                }

},
    error:function(e){}
});
    //** ******* **//
         //** ****** **/

         $("#up_college_dep").change(function() {
            //更動第一層時第二層清空
             $('#up_teach_dep').empty().append("<option value=''> --請選擇-- </option>").attr('disabled', true);

             var i = 0;
             $.ajax({
                 url: "teach_dep_list?co_id=" + $('#up_college_dep option:selected').val(),
                 cache: false,
                 type: "GET",
                 dataType: 'json',
                 success: function(data) {
                     //當第一層回到預設值時，第二層回到預設位置
                     if (data == "no_data" || $("#up_college_dep").val() == 0) {
                         $('#up_teach_dep').val($('#up_teach_dep option:first').val()).attr('disabled', true);
                     }else{
                         $('#up_teach_dep').empty();
                         $('#up_teach_dep').attr('disabled', false);
                         //依據第一層回傳的值去改變第二層的內容
                         while (i < data.teach_dep_list.length) {
                             $("#up_teach_dep").append("<option value='" + data.teach_dep_list[i] + "'>" + data.teach_dep_list[i] + "</option>");
                             i++;
                         }
                     }
                     
                 },
                 error: function(xhr, status, msg) {
                     console.error(xhr);
                     console.error(msg);
                 }
            });
        });
//** ******* **/
    var question = new Array("非常滿意", "滿意" , "普通", "不滿意", "非常不滿意");
    
    
    for(i=0; i<history_q_arr.length; i++){
        //
        var ov_list = "";
        for(n=0; n<question.length; n++){
            var this_sel_type = "";
            if((history_q_arr.length-history_q_arr[i]) == [n-1]){
                this_sel_type = "selected='selected'";
            }else{
                this_sel_type = "";
            }
            ov_list = ov_list + "<option value='" + [question.length-n] + "' " + this_sel_type + ">" + question[n] + "</option>";

        }
        
        $("#up_q"+[i+1]).empty("");
        $("#up_q"+[i+1]).append(ov_list);
    }
    
    $("#up_staff_mail").val(mail);
    $("#up_staff_name").val(staff_name);
    $("#pcode").val(pcode);
    $("#omail").val(mail);
    $("#myModalLabel").text("參加活動人員 修改");
    $("#myModal").modal("show");

}
var oTable;

function _editFunAjax(){
var pcode = $("#pcode").val();
var up_college = $("#up_college_dep").val();
var up_teach_dep = $("#up_teach_dep").val();
var up_staff_mail = $("#up_staff_mail").val();
var up_staff_name = $("#up_staff_name").val();
var up_q1 = $("#up_q1").val();
var up_q2 = $("#up_q2").val();
var up_q3 = $("#up_q3").val();
var up_q4 = $("#up_q4").val();
var jsonData = {
    "pcode": pcode,
    "up_college": up_college,
    "up_teach_dep": up_teach_dep,
    "up_staff_mail": up_staff_mail,
    "up_staff_name": up_staff_name,
    "up_q1": up_q1, 
    "up_q2": up_q2, 
    "up_q3": up_q3, 
    "up_q4": up_q4
};
$.ajax({
    url: "update_participants",
    cache: false,
    type: "POST",
    data: jsonData, 
    dataType: "json",
    success: function (data) {
        if (data.message.type) {
            $("#myModal").modal("hide");
            resetFrom();
            oTable.ajax.reload();
        } else {
            alert(data.message.error_message);
        }
    }
});
}
function resetFrom() {
$('form').each(function (index) {
    $('form')[index].reset();
});
}

function _deleteFun(pcode){
    if(confirm("是否確定要刪除？")){
        $.ajax({
            url: "del_participants",
            data: {"pcode": pcode},
            type: "post",
            success: function (backdata){
                if(backdata){
                    oTable.ajax.reload();
                }else{
                    alert("删除失败");
                }
            }, 
            error: function (error){
                console.log(error);
            }
        });
    }
}


$(document).ready(function() {

       $('.activity_time').timepicker({
                                        timeFormat: 'HH:mm',
                                        interval: 30,
                                        minTime: '0',
                                        maxTime: '23:00',
                                        defaultTime: '',
                                        startTime: '10:00',
                                        dynamic: false,    //Sorting
                                        dropdown: true,
                                        scrollbar: false    //Hide or Show Scrollabr
                                     });

    $("#semester").val(semseter_list(1));
    $("#semester").autocomplete({source: semseter_list(0)}); 

    /** Dynamic access to activity data name **/
    $.ajax({
    url: "activity_name",
    cache: false,
    type: "GET",
    dataType: 'json',
    success: function(data){ 
                                for(i=0; i<data.id.length;i++){

                                    $("#activity_name").append("<option value='"+data.id[i]+"_"+data.name[i]+"'>"+data.name[i]+"</option>");

                                }
},
    error:function(e){}
});

         /** Dynamic access to activity sub data **/
         $('#activity_name').change(function() {
            //更動第一層時第二層清空
             $('#sec_item').empty().append("<option value=''> --請選擇-- </option>").attr('disabled', true);

             var i = 0;
             $.ajax({
                 url: "activity_sub?sec_item=" + $('#activity_name option:selected').val(),
                 cache: false,
                 type: "GET",
                 dataType: 'json',
                 success: function(data) {
                     //當第一層回到預設值時，第二層回到預設位置
                     if (data == "no_data" || $("#activity_name").val() == 0) {
                         $('#sec_item').val($('#sec_item option:first').val()).attr('disabled', true);
                     }else{
                         $('#sec_item').attr('disabled', false);
                         //依據第一層回傳的值去改變第二層的內容
                         while (i < data.sec_item.length) {
                             $("#sec_item").append("<option value='" + data.sec_item[i] + "'>" + data.sec_item[i] + "</option>");
                             i++;
                         }
                     }
                     //console.log($("#activity_name").val());
                 },
                 error: function(xhr, status, msg) {
                     console.error(xhr);
                     console.error(msg);
                 }
            });
        });

    /** Get Speaker dep data **/
    $.ajax({
    url: "speaker_dep",
    cache: false,
    type: "POST",
    dataType: 'json',
    success: function(data){ 
                                for(i=0; i<data.speaker_dep.length;i++){

                                    $("#speaker_dep").append("<option value='"+data.id[i]+"_"+data.speaker_dep[i]+"'>"+data.speaker_dep[i]+"</option>");

                                }
    },
    error:function(e){}
    });

//console.log('location.pathname: '+);location.pathname
if(typeof location.pathname != "undefined" && location.pathname != 0){
    var split_arr = location.pathname.split("/");
    if(split_arr[3] == "update"){
        /** Dynamic access to update activity data name **/
        $.ajax({
        url: "activity_name" + location.search + "&sel=au1",
        cache: false,
        type: "GET",
        dataType: 'json',
        success: function(data){ 
                                for(i=0; i<data.id.length;i++){
                                    if(data.sel_activity_name == data.name[i]){
                                        var this_sel_type = "selected='selected'";
                                        this_selval = data.sel_activity_name;
                                    }else{
                                        var this_sel_type = "";
                                    }
                                    $("#up_activity_name").append("<option value='"+data.id[i]+"_"+data.name[i]+"' " + this_sel_type + " >"+data.name[i]+"</option>");

                                }
                                if(data.sel_activity_sec_item != data.sel_activity_name){
                                    $('#up_sec_item').attr('disabled', false);
                                    for(i=0; i<data.sec_item.length;i++){
                                        if(data.sec_item[i] == data.sel_activity_sec_item){
                                            var this_selected = "selected='selected'";
                                        }else{
                                            var this_selected = "";
                                        }
                                        $("#up_sec_item").append("<option value='"+data.sec_item[i]+"' " + this_selected + " >"+data.sec_item[i]+"</option>");  
                                    }
                                }
                                

        },
        error:function(e){}
        });

         /** Dynamic access to update activity sub data **/
         $('#up_activity_name').change(function() {
            //更動第一層時第二層清空
             $('#up_sec_item').empty().append("<option value=''> --請選擇-- </option>").attr('disabled', true);
             var i = 0;
             $.ajax({
                 url: "activity_sub?sec_item=" + $('#up_activity_name option:selected').val(),
                 cache: false,
                 type: "GET",
                 dataType: 'json',
                 success: function(data) {
                     //當第一層回到預設值時，第二層回到預設位置

                     if (data == "no_data" || $("#up_activity_name").val() == 0) {

                         $('#up_sec_item').val($('#up_sec_item option:first').val()).attr('disabled', true);

                     }else{

                         $('#up_sec_item').attr('disabled', false);
                         //依據第一層回傳的值去改變第二層的內容
                         while (i < data.sec_item.length) {
                             $("#up_sec_item").append("<option value='" + data.sec_item[i] + "'>" + data.sec_item[i] + "</option>");
                             i++;
                         }

                     }
                     console.log($("#up_activity_name").val());
                 },
                 error: function(xhr, status, msg) {
                     console.error(xhr);
                     console.error(msg);
                 }
            });
        });

        /** Get Update Speaker dep data **/
        $.ajax({
        url: "speaker_dep" + location.search + "&sel=au1",
        cache: false,
        type: "POST",
        dataType: 'json',
        success: function(data){ 

                                for(i=0; i<data.speaker_dep.length;i++){
                                    if(data.speaker_dep[i] == data.sel_speaker_dep){
                                        var this_selected = "selected='selected'";
                                    }else{
                                        var this_selected = "";
                                    }
                                    $("#up_speaker_dep").append("<option value='"+data.id[i]+"_"+data.speaker_dep[i] +"' " + this_selected + " >" + data.speaker_dep[i] + "</option>");

                                }
        },
        error:function(e){}
        });
     }
  }

//*************activities_participants****************
    /** Dynamic access to activity data name **/
    $.ajax({
    url: "college_dep_list",
    cache: false,
    type: "POST",
    dataType: 'json',
    success: function(data){ 
                                for(i=0; i<data.college_dep_id.length;i++){

                                    $("#college_dep").append("<option value='"+data.college_dep_id[i]+"_"+data.college_dep[i]+"'>"+data.college_dep[i]+"</option>");

                                }
},
    error:function(e){}
});

         /** Dynamic access to activity sub data **/
         $("#college_dep").change(function() {
            //更動第一層時第二層清空
             $('#teach_dep').empty().append("<option value=' '> --請選擇-- </option>").attr('disabled', true);

             var i = 0;
             $.ajax({
                 url: "teach_dep_list?co_id=" + $('#college_dep option:selected').val(),
                 cache: false,
                 type: "GET",
                 dataType: 'json',
                 success: function(data) {
                     //當第一層回到預設值時，第二層回到預設位置
                     if (data == "no_data" || $("#college_dep").val() == 0) {
                         $('#teach_dep').val($('#teach_dep option:first').val(" ")).attr('disabled', true);
                     }else{
                         $('#teach_dep').attr('disabled', false);
                         //依據第一層回傳的值去改變第二層的內容
                         while (i < data.teach_dep_list.length) {
                             $("#teach_dep").append("<option value='" + data.teach_dep_list[i] + "'>" + data.teach_dep_list[i] + "</option>");
                             i++;
                         }
                     }
                     //console.log($("#activity_name").val());
                 },
                 error: function(xhr, status, msg) {
                     console.error(xhr);
                     console.error(msg);
                 }
            });
        });


//**************************************************
    /** Dynamic access to activity data name **/
    $.ajax({
    url: "get_act_par_num" + location.search,
    cache: false,
    type: "GET",
    dataType: 'json',
    success: function(data){ 
                            if(typeof data.act_num != "undefined" && data.act_num != 0){                                
                                $("#tab_participants").show();
                                $("#act_par_num").text(" ( "+data.act_num+" )");
                            }else{
                                $("#tab_participants").hide();
                            }
                            

                            
},
    error:function(e){}
});

//***************************************************


oTable = initTable();
$("#btnEdit").click(_editFunAjax);
function initTable(){
        var table = $("#staff_list").DataTable({
            "columns": [
                {"data": "icount"}, 
                {"data": "tdn"},
                {"data": "name"},
                {"data": "glevel"},
                {"data": "slevel"},
                {"data": "mail"}, 
                {"data": "pcode", 
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html("&nbsp;&nbsp;<button type='button' class='btn btn-info btn-xs' href='javascript:void(0);' " + "onclick='_editFun(\"" + oData.pcode + "\", \"" + oData.staff_name + "\", \"" + oData.mail + "\", \"" + oData.c_name + "\", \"" + oData.tdn + "\", \"" + oData.history_q + "\")'>編輯</button>&nbsp;&nbsp;<button type='button' class='btn btn-danger btn-xs' href='javascript:void(0);' " + "onclick='_deleteFun(\"" + oData.pcode + "\")'>刪除</button>");
                    } 
                }            
            ],
            "language": {
                "sSearch": "查詢：", 
                "paginate": {
                    "previous": "上一頁",
                    "next": "下一頁"
                }, 
                "zeroRecords": "<span style='font-size:40px;'>無任何相關紀錄</span>",
             },
    "sDom": "<'row-fluid'<'span6 myBtnBox'><'span6'f>r>t<'row-fluid'<'span6'i><'span6 'p>>",
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "get_participate_data" + location.search,
                type: "POST"
            }
        });
        $("#staff_list_length,#staff_list_info").hide();
        $("#staff_list").css("text-align", "left");
        return table;
}

});

