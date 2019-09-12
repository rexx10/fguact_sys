//**************************************************
    /** Dynamic access to activity data name **/
$.ajax({
    url: "get_sact_par_num" + location.search,
    cache: false,
    type: "GET",
    dataType: 'json',
    success: function(data){ 
                            if(typeof data.spar_num != "undefined" && data.spar_num != 0){                                
                                $("#tab_participants").show();
                                $("#spar_num").text(" ( "+ data.spar_num +" )");
                            }else{
                                $("#tab_participants").hide();
                            }                        
    },
    error:function(e){}
});

//***************************************************
$(document).ready(function (){
    $("#staff_list").DataTable({
        "columns": [
                     {"data": "icount"}, 
                     {"data": "tdn"},
                     {"data": "name"},
                     {"data": "glevel"},
                     {"data": "slevel"},
                     {"data": "mail"}           
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
                url: "get_sparticipate_data" + location.search,
                type: "POST"
            }
        });
        $("#staff_list_length,#staff_list_info").hide();
        $("#staff_list").css("text-align", "left");
});
//***************************************************