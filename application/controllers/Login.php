<?php
class Login extends CI_Controller {
            
    public function __construct(){

        parent::__construct();
        $this->load->database();
	    $this->load->library("session");   //開啟session
	    date_default_timezone_set("Asia/Taipei");


    }

    public function index(){
		//
		$data = Array("title" => "佛光大學 - Login");
		if($this->session->userdata("check_type") != "" & $this->session->userdata("email") != "" & $this->session->userdata("login_name") != "" ){
			if($this->session->userdata("login_level") > "1"){
				redirect("act_poj/search", "refresh");
			}else{
				redirect("pagination", "refresh");
			}
		}
		$this->load->view("login_form", $data);

    }

    public function login(){

	    $data_set = $this->input->post(Array("email", "password"), TRUE);
		$data_set["password"] = crypt($data_set["password"], "fguact_sys");
		$this->load->model("login_model");
		$check_login = $this->login_model->login($data_set);

		if($check_login){
			//
			$data_set["check_data"] = MD5(date("Y-m-d/H:i:s")."fguact_sys");
			$data_set["login_date"] = strtotime(date("Y-m-d H:i:s"));
			$this->login_model->update_check_data($data_set);
			$session_data_set = array("check_type" => $data_set["check_data"], 
				                      "email" => $data_set["email"], 
				                      "login_name" => $check_login["login_name"], 
				                      "login_firstname" => $check_login["login_firstname"], 
				                      "login_lastname" => $check_login["login_lastname"],
				                      "login_level" => $check_login["login_level"]);
			$this->session->set_userdata($session_data_set);
			if($check_login["login_level"] > "1"){
				redirect("act_poj/search", "refresh");
			}else{
				redirect("pagination", "refresh");
			}

		}else{

			$data["login_Error"] = "login_Error";
			$this->load->view("login_form", $data);

		}

		
    }

}