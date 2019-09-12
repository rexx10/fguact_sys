<?php
class Act_poj extends CI_Controller {
            
    public function __construct()
    {

        parent::__construct();
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->library("session");
        $this->load->library("user");
        date_default_timezone_set("Asia/Taipei");

    }

    public function testcc(){
      //$this->load->library('controllerlist');
//print_r($this->controllerlist->getControllers());
     //echo __function__."\/".__class__;
        print_r($this->user->echom());




    }

    public function create(){
		$this->load->helper("my_tool_helper");
        $this->load->helper("check_login_type_helper");
        $data = Array("login_name" => $this->session->userdata("login_name"), 
                      "login_firstname" => $this->session->userdata("login_firstname"), 
                      "email" => $this->session->userdata("email"), 
                      "check_type" => $this->session->userdata("check_type"), 
                      "login_level" => $this->session->userdata("login_level"));
        $data["page_title"] = "活動資料-建立";
        check_login_type($data);
        if(!$this->user->hasPermission("modify", strtolower(__class__)."/".strtolower(__function__))){
            $this->user->logout();
        }
        $this->load->view("actpoj_header", $data);
    	$this->load->view("admin_actpoj_create_body");
    }

    public function create_data(){

        $multi_input_data = $this->input->post(array("semester", 
                                                     "activity_date", 
                                                     "s_activity_time", 
                                                     "e_activity_time", 
                                                     "activity_name", 
                                                     "activity_location", 
                                                     "topic", 
                                                     "speaker_dep", 
                                                     "speaker_name"), true);
        
        $this->load->helper("my_tool_helper");

        if(!empty($multi_input_data["activity_name"])){
            $act_name_arr = explode("_", $multi_input_data["activity_name"]);

            if($act_name_arr[0] == 3){
                $multi_input_data["sec_item"] = $this->input->post("sec_item", true);
            }else{
                $tmp_act_name = explode("_", $multi_input_data["activity_name"]);
                $multi_input_data["sec_item"] = $tmp_act_name[1];
            }
        }
        
        
        if(judg_empty($multi_input_data) != 0){
            tool_alert("您有".judg_empty($multi_input_data)."項資料未填寫，請檢查。");
            redirect("act_poj/create", "refresh");
        }

        $multi_input_data = clear_space($multi_input_data);

        $multi_input_data = clear_html_tag($multi_input_data);

        if(!judg_format(1, $multi_input_data["semester"])){
            tool_alert("學年填寫錯誤，請檢查。");
            redirect("act_poj/create", "refresh");
        }

        $multi_input_data["activity_date"] = roc_to_yuan($multi_input_data["activity_date"]);
                
        if(!judg_format(2, $multi_input_data["activity_date"])){
            //tool_alert("活動開始日有問題，請檢查！");
            //redirect("act_poj/create", "refresh");
            echo json_encode(array("Status" => "error", "Message" => "活動開始日有問題，請檢查！"));
        }

        if(!judg_format(3, $multi_input_data["s_activity_time"])){
            //tool_alert("活動開始時間有問題，請檢查！");
            //redirect("act_poj/create", "refresh");
            echo json_encode(array("Status" => "error", "Message" => "活動開始時間有問題，請檢查！"));
        }

        if(!judg_format(3, $multi_input_data["e_activity_time"])){
            //tool_alert("活動結束時間有問題，請檢查！");
            //redirect("act_poj/create", "refresh");
            echo json_encode(array("Status" => "error", "Message" => "活動結束時間有問題，請檢查！"));
        }

        if(!judg_datetime($multi_input_data["activity_date"], $multi_input_data["s_activity_time"], $multi_input_data["activity_date"], $multi_input_data["e_activity_time"])){
            tool_alert("活動開始時間請勿大於結束時間，請檢查！");
            redirect("act_poj/create", "refresh");
            echo json_encode(array("Status" => "error", "Message" => "活動開始時間請勿大於結束時間，請檢查！"));
        }
        $tmp_ex_activity_name = explode("_", $multi_input_data["activity_name"]);
        $multi_input_data["activity_name"] = $tmp_ex_activity_name[1];
        $tmp_ex_speaker_dep = explode("_", $multi_input_data["speaker_dep"]);
        $multi_input_data["speaker_dep"] = $tmp_ex_speaker_dep[1];
        //print_r($multi_input_data);
        $this->load->model("act_poj_model");
        $max_activity_code = $this->act_poj_model->get_max_activity_code();
        $init_today_code = date("Ymd")."0001";
        if($max_activity_code != "no_data"){
            if($max_activity_code == $init_today_code || $max_activity_code > $init_today_code ){
            
                $multi_input_data["activity_code"] = $max_activity_code + 1;
            
            }else{
            
                $multi_input_data["activity_code"] = $init_today_code;
            
            }
        }else{

            $multi_input_data["activity_code"] = $init_today_code;

        }
        
        $multi_input_data["record_datetime"] = strtotime(date("Y-m-d H:i:s"));
        //$this->act_poj_model->create_data($multi_input_data);
       //if($this->act_poj_model->create_data($multi_input_data)){

           //tool_alert("活動資料建立完成，將返回資料建立頁面。");

          // redirect("act_poj/create",'refresh');

      // }
       $data = $this->act_poj_model->create_data($multi_input_data);
        if(!empty($data)){
            echo json_encode(array("Status" => "ok"));
        }else{
            echo json_encode(array("Status" => "error"));
        }


        


    }
    public function search(){
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
        $config['base_url'] = site_url("act_poj/search");
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

        $this->load->model("act_poj_model");

        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        // get books list
        $data['booklist'] = $this->act_poj_model->get_activity_data_list($config["per_page"], $data['page'], NULL);
        $this->load->helper("my_tool_helper");
		for($i=0; $i < count($data["booklist"]); $i++){
			$data["booklist"][$i]->activity_date = yuan_to_roc($data["booklist"][$i]->activity_date);
		}
        $data['pagination'] = $this->pagination->create_links();
        $data["history_page"] = "search-".$data['page'];
        $data["page_title"] = "活動資料-查詢";


        // load view
        $this->load->view("actpoj_header", $data);
        $this->load->view("admin_actpoj_search_body");
    }

    public function search_data(){
        // get search string
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
        $search = ($this->input->post("search_data"))? $this->input->post("search_data") : "NIL";

        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
        $this->load->model("act_poj_model");
        // pagination settings
        $config = array();
        $config['base_url'] = site_url("act_poj/search_data/$search");
        $config['total_rows'] = $this->act_poj_model->get_activity_count($search);
        $config['per_page'] = "5";
        $config["uri_segment"] = 4;
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

        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        // get books list
        $data['booklist'] = $this->act_poj_model->get_activity_data_list($config['per_page'], $data['page'], $search);
        $this->load->helper("my_tool_helper");
		for($i=0; $i < count($data["booklist"]); $i++){
			$data["booklist"][$i]->activity_date = yuan_to_roc($data["booklist"][$i]->activity_date);
		}
		
        $data['pagination'] = $this->pagination->create_links();
        $data["history_page"] = "search_data-".$data['page'];
        $data["page_title"] = "活動資料-查詢";
        // load view
        $this->load->view("actpoj_header", $data);
        $this->load->view("admin_actpoj_search_body");
    }

    public function view_act_list(){
        //
        $this->load->helper("check_login_type_helper");
        $data = Array("login_name" => $this->session->userdata("login_name"), 
                      "login_firstname" => $this->session->userdata("login_firstname"), 
                      "email" => $this->session->userdata("email"), 
                      "check_type" => $this->session->userdata("check_type"), 
                      "login_level" => $this->session->userdata("login_level"));
        check_login_type($data);

        $activity_code = $this->input->get("id", true);
        $this->load->model("act_poj_model");
        $data["datalist"] = $this->act_poj_model->get_update_data($activity_code);
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
        $data["history_page"] = $this->input->get("hp", true);
        $history_page_arr = explode("-", $data["history_page"]);
        $data["this_history_page"] = "/".$history_page_arr[0]."/".$history_page_arr[1];

        $data["page_title"] = "活動資料-查看";
        
        //load view
        $this->load->view("actpoj_header", $data);
        $this->load->view("admin_actpoj_view_body");
    }

    public function participants_form(){
        //
        $this->load->helper("check_login_type_helper");
        $data = Array("login_name" => $this->session->userdata("login_name"), 
                      "login_firstname" => $this->session->userdata("login_firstname"), 
                      "email" => $this->session->userdata("email"), 
                      "check_type" => $this->session->userdata("check_type"), 
                      "login_level" => $this->session->userdata("login_level"));
        check_login_type($data);
        
        $this->load->model("act_poj_model");
        $data["activity_code"] = $this->input->get("id", true);

        $data["history_page"] = $this->input->get("hp", true);
        $get_activity_code = $this->act_poj_model->get_update_data($data["activity_code"]);
        
        if(empty($get_activity_code[0])){
            //
            redirect("act_poj/create", "refresh");
        }

        $data["history_page_path"] = "/view_act_list?id=".$data["activity_code"]."&hp=".$data["history_page"];
        $data["page_title"] = "參加活動人員-建立";

        $this->load->view("actpoj_header", $data);
        $this->load->view("admin_actpoj_create_participants_body");

    }

    public function create_participants(){
        //
        $multi_data = $this->input->post(array("id", 
                                               "college", 
                                               "teach_dep", 
                                               "staff", 
                                               "e-mail"), true);


        $questionnaire = $this->input->post(array("q1", 
                                                  "q2", 
                                                  "q3", 
                                                  "q4"), true);
        $hp = $this->input->post("hp", true);

        $this->load->helper("my_tool_helper");

        if(!empty(judg_empty($multi_data)) || !empty(judg_empty($questionnaire))){
            //tool_alert("您有".(judg_empty($multi_data)+judg_empty($questionnaire))."項資訊未填。");
            //redirect("act_poj/participants_form?id=".$multi_data["id"]."&hp=".$hp, "refresh");
            echo json_encode(array("Status" => "error", "Message" => "您有".(judg_empty($multi_data)+judg_empty($questionnaire))."項資訊未填。"));
        }

        $college_arr = explode("_", $multi_data["college"]);
        $multi_data["college"] = $college_arr[1];

        $multi_data = clear_space($multi_data);
        $multi_data = clear_html_tag($multi_data);
        $multi_data["record_datetime"] = strtotime(date("Y-m-d H:i:s"));
        $multi_data["questionnaire"] = $questionnaire["q1"]."-".$questionnaire["q2"]."-".$questionnaire["q3"]."-".$questionnaire["q4"];
        $multi_data["gain_level"] = $questionnaire["q1"];
        $multi_data["satisfaction_level"] = round(($questionnaire["q2"] + $questionnaire["q3"] + $questionnaire["q4"]) / 3, 2);
        $init_activity_code = $multi_data["id"]."0001";
        $this->load->model("act_poj_model");
        $participants_code_maxnum = $this->act_poj_model->search_participants_max_order($multi_data["id"]);

        if($participants_code_maxnum != "no_data"){
            if($participants_code_maxnum == $init_activity_code || $participants_code_maxnum > $init_activity_code){
                $multi_data["p_code"] = number_format($participants_code_maxnum + 1, 0, "", "");
            }else{
                $multi_data["p_code"] = $init_activity_code;
            }

        }else{
            //
            $multi_data["p_code"] = $init_activity_code;
        }

        

        $this->act_poj_model->create_participants($multi_data);
        //if($this->act_poj_model->create_satisfaction_survey($multi_data)){
           //redirect("act_poj/view_act_list?id=".$multi_data["id"]."&hp=".$hp, "refresh");
        //}
        $data = $this->act_poj_model->create_satisfaction_survey($multi_data);
        if(!empty($data)){
            echo json_encode(array("Status" => "ok", "id" => $multi_data["id"], "hp" => $hp));
        }else{
            echo json_encode(array("Status" => "error"));
        }
    }
	
	public function update_participants(){
	    //
        $updata = $this->input->post(array(
                                 "pcode", 
                                 "up_college", 
                                 "up_teach_dep", 
                                 "up_staff_mail", 
                                 "up_staff_name"
                                 ), true);
        //print_r($updata);
        $questionnaire = $this->input->post(Array("up_q1", 
                                                "up_q2", 
                                                "up_q3", 
                                                "up_q4"), true);
        $up_college_arr = explode("_", $updata["up_college"]);
        $updata["up_college"] = $up_college_arr[1];
        $this->load->helper("my_tool_helper");

       if(!empty(judg_empty($updata)) || !empty(judg_empty($questionnaire))){
           echo json_encode(array("message" => array("type" => 0, "error_message" => "您有 ".(judg_empty($updata)+judg_empty($questionnaire))." 項資訊未填！")));
           exit();
       }

        if(!judg_format(4, $updata["up_staff_mail"])){
            //
             echo json_encode(array("message" => array("type" => 0, "error_message" => "E-MAIL 有誤!")));
            exit();
        }


        $updata = clear_space($updata);
        $updata = clear_html_tag($updata);
        $updata["modify_datetime"] = strtotime(date("Y-m-d H:i:s"));
        $updata["questionnaire"] = $questionnaire["up_q1"]."-".$questionnaire["up_q2"]."-".$questionnaire["up_q3"]."-".$questionnaire["up_q4"];
        $updata["gain_level"] = $questionnaire["up_q1"];
        $updata["satisfaction_level"] = round(($questionnaire["up_q2"] + $questionnaire["up_q3"] + $questionnaire["up_q4"]) / 3, 2);

        $this->load->model("act_poj_model");
        $this->act_poj_model->update_participants($updata);
        if($this->act_poj_model->update_satisfaction_survey($updata)){
            echo json_encode(array("message" => array("type" => 1)));
        }else{
            echo json_encode(array("message" => array("type" => 0, "error_message" => "存檔失敗，請聯絡系統管理員！")));
        }
			
	}
    public function del_participants(){
        $id = $this->input->post("pcode", true);

        $this->load->model("act_poj_model");
        $this->act_poj_model->del_participants($id);
        if($this->act_poj_model->del_satisfaction_survey($id)){
           echo 1;
        }else{
            echo 0;
        }
    }

    public function del_activity_data(){
        //
        $id = $this->input->post("id", true);
        $this->load->model("act_poj_model");
        if($this->act_poj_model->del_activity_data($id)){
            echo true;
        }else{
            echo false;
        }
    }

    public function update(){

        $this->load->helper("check_login_type_helper");
        $data = Array("login_name" => $this->session->userdata("login_name"), 
                      "login_firstname" => $this->session->userdata("login_firstname"), 
                      "email" => $this->session->userdata("email"), 
                      "check_type" => $this->session->userdata("check_type"), 
                      "login_level" => $this->session->userdata("login_level"));
        check_login_type($data);

        $activity_code = $this->input->get("id", true);//
        $this->load->model("act_poj_model");
        $data["update_data_list"] = $this->act_poj_model->get_update_data($activity_code);
        $tmp_actdate_arr = explode("-", $data["update_data_list"][0]->activity_date);
        $data["update_data_list"]["activity_date"] = ($tmp_actdate_arr[0]-1911)."-".$tmp_actdate_arr[1]."-".$tmp_actdate_arr[2];
        $data["update_data_list"]["activity_time_start"] = date("H:i", strtotime($data["update_data_list"][0]->activity_time_start));
        $data["update_data_list"]["activity_time_end"] = date("H:i", strtotime($data["update_data_list"][0]->activity_time_end));
        $data["this_history_page"] = "act_poj/view_act_list";
        $data["history_page"] = $this->input->get("hp", true);
        $data["page_title"] = "活動資料-修改";
        
        //load view
        $this->load->view("actpoj_header", $data);
        $this->load->view("admin_actpoj_update_body");

    }

    public function update_data(){

        if(empty($this->input->post("id", true)) || empty($this->input->post("hp", true))){
            redirect("act_poj/search", "refresh");
        }

        $history_page = $this->input->post("hp", true);

        $multi_update_data = $this->input->post(array("semester", 
                                                      "activity_date", 
                                                      "s_activity_time", 
                                                      "e_activity_time", 
                                                      "activity_name", 
                                                      "activity_location", 
                                                      "topic", 
                                                      "speaker_dep", 
                                                      "speaker_name"), true);

        $multi_update_data["activity_code"] = $this->input->post("id", true);

        $this->load->helper("my_tool_helper");

        if(!empty($multi_update_data["activity_name"])){
            $act_name_arr = explode("_", $multi_update_data["activity_name"]);

            if($act_name_arr[0] == 3){
                $multi_update_data["sec_item"] = $this->input->post("sec_item", true);
            }else{
                $tmp_act_name = explode("_", $multi_update_data["activity_name"]);
                $multi_update_data["sec_item"] = $tmp_act_name[1];
            }
        }
        
        
        if(judg_empty($multi_update_data) != 0){
            tool_alert("您有".judg_empty($multi_update_data)."項資料未填寫，請檢查。");
            redirect("act_poj/update?id=".$multi_update_data["activity_code"]."&hp=".$history_page, "refresh");
        }

        $multi_update_data = clear_space($multi_update_data);

        $multi_update_data = clear_html_tag($multi_update_data);

        if(!judg_format(1, $multi_update_data["semester"])){
            tool_alert("學年填寫錯誤，請檢查。");
            redirect("act_poj/update?id=".$multi_update_data["activity_code"]."&hp=".$history_page, "refresh");
        }

        $multi_update_data["activity_date"] = roc_to_yuan($multi_update_data["activity_date"]);
                
        if(!judg_format(2, $multi_update_data["activity_date"])){
            tool_alert("活動開始日有問題，請檢查！");
            redirect("act_poj/update?id=".$multi_update_data["activity_code"]."&hp=".$history_page, "refresh");
        }

        if(!judg_format(3, $multi_update_data["s_activity_time"])){
            tool_alert("活動開始時間有問題，請檢查！");
            redirect("act_poj/update?id=".$multi_update_data["activity_code"]."&hp=".$history_page, "refresh");
        }

        if(!judg_format(3, $multi_update_data["e_activity_time"])){
            tool_alert("活動結束時間有問題，請檢查！");
            redirect("act_poj/update?id=".$multi_update_data["activity_code"]."&hp=".$history_page, "refresh");
        }

        if(!judg_datetime($multi_update_data["activity_date"], $multi_update_data["s_activity_time"], $multi_update_data["activity_date"], $multi_update_data["e_activity_time"])){
            tool_alert("活動開始時間請勿大於結束時間，請檢查！");
            redirect("act_poj/update?id=".$multi_update_data["activity_code"]."&hp=".$history_page, "refresh");

        }
        $tmp_ex_activity_name = explode("_", $multi_update_data["activity_name"]);
        $multi_update_data["activity_name"] = $tmp_ex_activity_name[1];
        $tmp_ex_speaker_dep = explode("_", $multi_update_data["speaker_dep"]);
        $multi_update_data["speaker_dep"] = $tmp_ex_speaker_dep[1];

        $multi_update_data["modify_datetime"] = strtotime(date("Y-m-d H:i:s"));

        //print_r($multi_input_data);
        $this->load->model("act_poj_model");
       // echo date("Y-m-d H:i:s");

        //print_r($multi_update_data);
        //["record_datetime"] = strtotime(date("Y-m-d H:i:s"));
        //$this->act_poj_model->update_data($multi_update_data);
        //$this->act_poj_model->create_data($multi_input_data);
        if($this->act_poj_model->update_data($multi_update_data)){

            redirect("act_poj/view_act_list?id=".$multi_update_data["activity_code"]."&hp=".$history_page, "refresh");

        }


    }

    public function activity_name()
    {

    	$this->load->model("act_poj_model");

    	$activity_data = $this->act_poj_model->get_activity_name();

        if(!empty($this->input->get("id", true)) && !empty($this->input->get("sel", true))){

            if($this->input->get("sel", true) == "au1"){
                $activity_code = $this->input->get("id", true);
                $this->load->model("act_poj_model");
                $activity_datalist = $this->act_poj_model->get_update_data($activity_code);
                foreach ($activity_datalist[0] as $key => $value) {
                    if($key == "activity_name"){
                        $activity_data["sel_activity_name"] = $value;
                    }
                    if($key == "activity_sec_item"){
                        $activity_data["sel_activity_sec_item"] = $value;
                    }
                }

                if($activity_data["sel_activity_name"] != $activity_data["sel_activity_sec_item"]){
                    $activity_subdatalist = $this->act_poj_model->get_activity_sub_name();
                    foreach ($activity_subdatalist as $key => $value) {
                        $activity_data["sec_item"] = $value;
                    }
                }
            }

        }

        //echo "<BR>";
       echo Json_encode($activity_data);


    }

    public function activity_sub()
    {
        $activity_id = explode("_",$this->input->get("sec_item"));
        
        $this->load->model("act_poj_model");
        $activity_sub_name = $this->act_poj_model->get_activity_sub_name($activity_id[0]);
        if($activity_sub_name != ""){

           echo Json_encode($activity_sub_name);
            //print_r($activity_sub_name);

        }else{

            $sub_name[] = "no_data";
            echo Json_encode($sub_name);
            //echo $this->input->post("activity_name");
        }
       // 
        

    }

    public function speaker_dep()
    {

        $this->load->model("act_poj_model");

        $speaker_dep_list = $this->act_poj_model->get_speaker_dep();

        if(!empty($this->input->get("id", true)) && !empty($this->input->get("sel", true))){
            //
            if($this->input->get("sel", true) == "au1"){
                //
                $activity_code = $this->input->get("id", true);
                $this->load->model("act_poj_model");
                $activity_datalist = $this->act_poj_model->get_update_data($activity_code);
                foreach ($activity_datalist[0] as $key => $value) {
                    if($key == "speaker_dep"){
                        $speaker_dep_list["sel_speaker_dep"] = $value;
                    }
                }
            }
        }

        echo Json_encode($speaker_dep_list);

    }
    public function college_dep_list(){
        //
        $this->load->model("act_poj_model");
        $college_dep_list = $this->act_poj_model->get_college_dep_list();
        echo Json_encode($college_dep_list);
        //print_r($college_dep_list);
    }
    
    public function teach_dep_list(){
        //
        $college_dep_id = explode("_", $this->input->get("co_id", true));
        $this->load->model("act_poj_model");
        $teach_dep_list = $this->act_poj_model->get_teach_dep_list($college_dep_id[0]);
        echo Json_encode($teach_dep_list);
        //print_r($teach_dep_list);
    }

    public function get_act_par_num(){
        //
        $id = $this->input->get("id", true);
        $this->load->model("act_poj_model");
        $act_num["act_num"] = $this->act_poj_model->get_act_par_num($id);
        echo json_encode($act_num);

    }
    public function get_participate_data(){
        //
        $this->load->model("act_poj_model");
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
        $recordsTotal = count($this->act_poj_model->get_participate_data("SELECT * FROM activities_participants_record WHERE activity_code = '".$this->input->get("id", TRUE)."'"));
        
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
                
                $recordsFiltered = count($this->act_poj_model->get_participate_data($sql));//Count of search result
                $sql = sprintf("SELECT * FROM %s %s ORDER BY %s %s limit %d , %d ", $tb_name, $where , $orderBy, $orderType, $start, $length);
                $data = $this->act_poj_model->get_participate_data($sql);
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
                $data = $this->act_poj_model->get_participate_data($sql);
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

    public function validators_data(){
        //
        if(!empty($this->input->post("stype", true))){
            $data = $this->input->post();

            switch($data["stype"]){
                case "zero":
                    $this->load->model("act_poj_model");
                    $data = $this->act_poj_model->validators_data($data);

                    echo json_encode(array('valid' => $data));

                    break;
                case 1:
                    if($data["oE-mail"] == $data["up_staff_mail"]){
                        echo json_encode(array('valid' => "true"));
                    }else{
                        $id_num = date("Ymd")."0000";
                        $id = str_split($data["pcode"], strlen($id_num));
                        $data["id"] = $id[0];
                        $this->load->model("act_poj_model");
                        $data = $this->act_poj_model->validators_data($data);
                    //if(!$data){
                        echo json_encode(array('valid' => $data));
                    //}else{
                      //  echo json_encode(array('valid' => "false" ));
                    //}
                    }

                    break;
            }
         
        }

    }

}