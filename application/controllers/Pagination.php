<?php
class Pagination extends CI_Controller {
            
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->helper("my_tool_helper");
        $this->load->database();
        $this->load->library('pagination');
        $this->load->library("session");
        $this->load->library("user");
        $this->load->model('pagination_model');
        date_default_timezone_set("Asia/Taipei");

    }

    public function index(){

        $this->load->helper("check_login_type_helper");
        $data = Array("login_name" => $this->session->userdata("login_name"), 
                      "login_firstname" => $this->session->userdata("login_firstname"), 
                      "email" => $this->session->userdata("email"), 
                      "check_type" => $this->session->userdata("check_type"), 
                      "login_level" => $this->session->userdata("login_level"));
        check_login_type($data);
        if(!$this->user->hasPermission("modify", strtolower(__class__)."/".strtolower(__function__))){
            $this->user->logout();
        }
        //pagination settings
        $config['base_url'] = site_url('pagination/index');
        $config['total_rows'] = $this->db->count_all("activity_data_record");
        $config['per_page'] = "5";
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"]/$config["per_page"];
        $config["num_links"] = floor($choice);

        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '«';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        // get books list
        $data['booklist'] = $this->pagination_model->get_books($config["per_page"], $data['page'], NULL);
        
		for($i=0; $i < count($data["booklist"]); $i++){
			$data["booklist"][$i]->activity_date = yuan_to_roc($data["booklist"][$i]->activity_date);
		}
		
        $data['pagination'] = $this->pagination->create_links();
        $data["previous_page"] = "search-".$data['page'];
        $data["page_title"] = "一般活動資料";
        if($this->user->hasPermission("modify", strtolower(__class__)."/".strtolower(__function__))){
            $data["check_login_type"] = "O";
        }else{
            $data["check_login_type"] = "X";
        }
        // load view
        $this->load->view('actpoj_header',$data);
        $this->load->view("pagination_container");
        $this->load->view("pagination_body");
    }
    
    function search(){

        $this->load->helper("check_login_type_helper");
        $data = Array("login_name" => $this->session->userdata("login_name"), 
                      "login_firstname" => $this->session->userdata("login_firstname"), 
                      "email" => $this->session->userdata("email"), 
                      "check_type" => $this->session->userdata("check_type"), 
                      "login_level" => $this->session->userdata("login_level"));
        check_login_type($data);
        if(!$this->user->hasPermission("modify", strtolower(__class__)."/".strtolower(__function__))){
            $this->user->logout();
        }
        // get search string
        $search = ($this->input->post("search_data"))? $this->input->post("search_data") : "NIL";
        $search_num = ($this->input->post("sec_option"))? $this->input->post("sec_option") : "0";
        $data["sec_option"] = "";
        if(!empty($this->input->post("sec_option", true))){
            //$search_num_arr = explode("_", $this->input->post("sec_option", true));
            switch ($this->input->post("sec_option", true)) {
                case "seach_1":
                    $data["sec_option"] = "actitivy";
                    break;
                
                case "seach_2":
                    $data["sec_option"] = "staff";
                    break;

                case "seach_3":
                    $data["sec_option"] = "semester";
                    break;

                default:
                    $data["sec_option"] = "";
                    break;
            }
            $search_num = $data["sec_option"];
        }else{
            $search_num = "0";
        }
        if(!empty($this->uri->segment(4))){
            if($this->uri->segment(4) != "NIL"){
                $data["sec_option"] = $this->uri->segment(4);
            }
        }

        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;

        // pagination settings
        $config = array();
        $config['base_url'] = site_url("pagination/search/$search/".$data["sec_option"]);
        $config['total_rows'] = $this->pagination_model->get_books_count($search, $search_num);
        $config['per_page'] = "5";
        $config["uri_segment"] = 5;
        $choice = $config["total_rows"]/$config["per_page"];
        $config["num_links"] = floor($choice);

        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        // get books list
        $data['booklist'] = $this->pagination_model->get_books($config['per_page'], $data['page'], $search, $search_num);


		$data["search_val"] = NULL;
        $data['pagination'] = $this->pagination->create_links();
        $data["previous_page"] = "search-".$data['page'];
        $data["page_title"] = "一般活動資料";
        $data["search_val"] = $search;

        if($this->user->hasPermission("modify", strtolower(__class__)."/".strtolower(__function__))){
            $data["check_login_type"] = "O";
        }else{
            $data["check_login_type"] = "X";
        }

        // load view

        switch($search_num){
            case "actitivy":

                for($i=0; $i < count($data["booklist"]); $i++){
                    $data["booklist"][$i]->activity_date = yuan_to_roc($data["booklist"][$i]->activity_date);
                }

                $this->load->view('actpoj_header', $data);
                $this->load->view("pagination_container");
                $this->load->view("pagination_body");
                break;

            case "staff":

                $this->load->view('actpoj_header', $data);
                $this->load->view("pagination_container");
                $this->load->view("pagination_body_staff");
                break;

            case "semester":

                for($i=0; $i < count($data["booklist"]); $i++){
                    $data["booklist"][$i]->activity_date = yuan_to_roc($data["booklist"][$i]->activity_date);
                }

                $this->load->view('actpoj_header', $data);
                $this->load->view("pagination_container");
                $this->load->view("pagination_body");
                break;
            
            default:

                for($i=0; $i < count($data["booklist"]); $i++){
                    $data["booklist"][$i]->activity_date = yuan_to_roc($data["booklist"][$i]->activity_date);
                }

                $this->load->view('actpoj_header', $data);
                $this->load->view("pagination_container");
                $this->load->view("pagination_body");
                break;
        }
    }

    public function export_data(){

        $export_code = explode(",", $this->input->get("id", true));
        //print_r($export_code);
        //echo "<BR>";
        $data_type = $this->input->get("data_type", true);
       // echo "<BR>";
        $data["export_type"] = $this->input->get("export_type", true);
        //echo "<BR>";
        $tmp_search_val = $this->input->get("tmp_search_val", true);
       // echo "<BR>";
        


        if(strpos($export_code[0], "-")){
            for($i=0; $i<count($export_code); $i++){
               $tmp_explode_data = explode("-", $export_code[$i]);
               $export_code[$i] = $tmp_explode_data[0];
               $export_pcode[$i] = $tmp_explode_data[1];
            }
        }else{
            $export_pcode = "";
        }
        
        if($data["export_type"] == "to_pdf"){

            $this->load->library("Pdf_lib");
            $data["pdf_file_name"] = date("YmdHis");
            $data["pdf"] = new CI_Pdf_lib("", "mm", "A4", true, "UTF-8", false);

        }
        $all_data_count = "";
        switch ($data_type) {
            case "by_staff":
                $export_code = array_unique($export_code);
                rsort($export_code);
                //echo "<BR>";
                //print_r($export_code);
                for($i=0; $i < count($export_code); $i++){

                    $data["data_list"][$i] = $this->pagination_model->export_data(
                                                                                  $export_code[$i], 
                                                                                  "", 
                                                                                  $data_type, 
                                                                                  $tmp_search_val
                                                                                  );
                    $all_data_count += $data["data_list"][$i]["data_count"];

                }
                //print_r($data["data_list"]);
                if($all_data_count == "0"){
                    tool_alert("無人員資料，請重新查詢！！");
                    close_window();
                }else{
                    $this->load->view("export_data", $data);
                }


                break;
            
            case "by_activity":
                $data["data_list"] = $this->pagination_model->export_data(
                                                                          $export_code, 
                                                                          $export_pcode, 
                                                                          $data_type, 
                                                                          $tmp_search_val
                                                                          );
                //print_r($data["data_list"]);
                if($data["data_list"]["people_num"] == "0"){
                    tool_alert("無相關人員參加活動資料，請重新查詢！！");
                    close_window();
                }else{
                    $this->load->view("export_data1", $data);
                }
                break;
            
            case "by_semester":
                $export_code = array_unique($export_code);
                rsort($export_code);
                //echo "<BR>";
                //print_r($export_code);
                $data["data_list"] = $this->pagination_model->export_data(
                                                                          $export_code, 
                                                                          "", 
                                                                          $data_type, 
                                                                          $tmp_search_val
                                                                          );
                //print_r($data["data_list"]);
                $this->load->view("export_data2", $data);
                break;
        }

       // $this->load->view("export_data", $data);
    }

    public function act_data_view(){
        //

        $this->load->helper("check_login_type_helper");
        $data = Array("login_name" => $this->session->userdata("login_name"), 
                      "login_firstname" => $this->session->userdata("login_firstname"), 
                      "email" => $this->session->userdata("email"), 
                      "check_type" => $this->session->userdata("check_type"), 
                      "login_level" => $this->session->userdata("login_level"));
        check_login_type($data);
        
        $activity_code = $this->input->get("id", true);
        $data["datalist"] = $this->pagination_model->get_single_active_data($activity_code);
        $tmp_semester_arr = explode("-", $data["datalist"][0]->semester);
        $data["datalist"]["title_semester"] = $tmp_semester_arr[0];

        if($data["datalist"][0]->activity_name ==  $data["datalist"][0]->activity_sec_item){
             $data["datalist"]["tmp_act_name"] = $data["datalist"][0]->activity_name;
        }else{
            $data["datalist"]["tmp_act_name"] = $data["datalist"][0]->activity_name." - ".$data["datalist"][0]->activity_sec_item;
        }

        $tmp_actdate_arr = explode("-", $data["datalist"][0]->activity_date);
        $data["datalist"]["activity_date"] = ($tmp_actdate_arr[0]-1911)."-".$tmp_actdate_arr[1]."-".$tmp_actdate_arr[2];

        $data["datalist"]["activity_time"] = date("H:i", strtotime($data["datalist"][0]->activity_time_start))."~".date("H:i", strtotime($data["datalist"][0]->activity_time_end));
        $data["previous_page"] = $this->input->get("pre_p", true);
        $previous_page_arr = explode("-", $data["previous_page"]);
        $data["previous_page"] = "/".$previous_page_arr[0]."/".$previous_page_arr[1];

        $data["page_title"] = "活動資料-查看";
        
        //load view
        $this->load->view("actpoj_header", $data);
        $this->load->view("pagination_view_body");
    }

    public function get_sact_par_num(){
        $id = $this->input->get("id", true);
        $spar_num["spar_num"] = $this->pagination_model->get_sact_par_num($id);
        echo json_encode($spar_num);
    }

    public function get_sparticipate_data(){
        //
        //print_r($this->input->post());
        if(!empty($this->input->post())){
            $draw = $this->input->post("draw", TRUE);
            $tmp_orderByColumnIndex = $this->input->post("order", TRUE);
            $orderByColumnIndex = $tmp_orderByColumnIndex[0]['column'];

            $tmp_columns = $this->input->post("columns", TRUE);
            //echo $orderBy = $tmp_columns[$orderByColumnIndex]['data'];
            $orderBy = "activities_satisfaction_survey_record.participants_code";
            $tmp_orderType = $this->input->post("order", TRUE);
            $orderType = $tmp_orderType[0]["dir"];

            $start = $this->input->post("start", TRUE);
            $num_l = $start;
            $length = 10;//$this->input->post("length", TRUE);
            $recordsTotal = count($this->pagination_model->get_sparticipate_data("SELECT * FROM activities_participants_record WHERE activity_code = '".$this->input->get("id", TRUE)."'"));
        
            if(!empty($this->input->post("search", TRUE))){
                $tmp_search = $this->input->post("search", TRUE);
                //print_r($tmp_search);

                //print_r($tmp_search);
                $tb_list = array("activities_participants_record.college_name", "activities_participants_record.teach_dep_name", "activities_participants_record.staff_name", "activities_participants_record.mail");

                if(!empty($tmp_search["value"])){
                    for($i=0; $i<count($tb_list);$i++){
                        $column = $tb_list[$i];//we get the name of each column using its index from POST request
                        $where[] = $column." LIKE '%".$tmp_search["value"]."%'";
                    }
                
                    $sql_joinkw = "(activities_participants_record.participants_code = activities_satisfaction_survey_record.participants_code AND activities_satisfaction_survey_record.activity_code = '".$this->input->GET("id", TRUE)."') AND (";

                    $where = "WHERE ".$sql_joinkw.implode(" OR " , $where).")";// id like '%searchValue%' or name like '%searchValue%' ....
                    /* End WHERE */
                    $tb_name = "activities_participants_record, activities_satisfaction_survey_record";

                    $sql = sprintf("SELECT * FROM %s %s", $tb_name, $where);//Search query without limit clause (No pagination)
                
                    $recordsFiltered = count($this->pagination_model->get_sparticipate_data($sql));//Count of search result
                    $sql = sprintf("SELECT * FROM %s %s ORDER BY %s %s limit %d , %d ", $tb_name, $where , $orderBy, $orderType, $start, $length);
                    $data = $this->pagination_model->get_sparticipate_data($sql);
                    for ($i=0; $i < count($data); $i++) { 
                        $num_l++;
                        $data[$i]["icount"] = $num_l;   
                        $data[$i]["name"] = $data[$i]["staff_name"];
                        $data[$i]["glevel"] = $data[$i]["gain_level"];
                        $slevel_arr = explode("." ,$data[$i]["satisfaction_level"]);
                        if($slevel_arr[1] == "00"){
                            $data[$i]["slevel"] = $slevel_arr[0];
                        }else{
                            $data[$i]["slevel"] = $data[$i]["satisfaction_level"];
                        }
                        $data[$i]["pcode"] = $data[$i]["participants_code"];    //參加單號
                        $data[$i]["c_name"] = $data[$i]["college_name"];    //學院
                        $data[$i]["tdn"] = $data[$i]["teach_dep_name"];    //系所
                        $data[$i]["history_q"] =$data[$i]["questionnaire"];
                    }
                }else{

                    $sql_ajoin = "activities_participants_record, activities_satisfaction_survey_record WHERE activities_participants_record.participants_code = activities_satisfaction_survey_record.participants_code AND activities_satisfaction_survey_record.activity_code = '".$this->input->GET("id", TRUE)."'";
                    $sql = sprintf("SELECT * FROM %s ORDER BY %s %s limit %d , %d ", $sql_ajoin, $orderBy, $orderType, $start, $length);
                    $data = $this->pagination_model->get_sparticipate_data($sql);
                    //$data["name"] = $data["staff_name"];
                
                    for ($i=0; $i < count($data); $i++) { 
                        $num_l++;
                        $data[$i]["icount"] = $num_l;                   
                        $data[$i]["name"] = $data[$i]["staff_name"];
                        $data[$i]["glevel"] = $data[$i]["gain_level"];
                        $slevel_arr = explode("." ,$data[$i]["satisfaction_level"]);
                        if($slevel_arr[1] == "00"){
                            $data[$i]["slevel"] = $slevel_arr[0];
                        }else{
                            $data[$i]["slevel"] = $data[$i]["satisfaction_level"];
                        }
                        $data[$i]["pcode"] = $data[$i]["participants_code"];    //參加單號
                        $data[$i]["c_name"] = $data[$i]["college_name"];    //學院
                        $data[$i]["tdn"] = $data[$i]["teach_dep_name"];    //系所
                        $data[$i]["history_q"] =$data[$i]["questionnaire"];

                    }
                    $recordsFiltered = $recordsTotal;
                }
            }

            $response = array("draw" => intval($draw),
                               "recordsTotal" => $recordsTotal,
                               "recordsFiltered" => $recordsFiltered,
                               "data" => $data);

            echo json_encode($response);

        }else{
            echo "NO POST Query from DataTable";
        }
    }

}
?>