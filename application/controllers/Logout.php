<?php
class Logout extends CI_Controller {
            
    public function __construct(){

        parent::__construct();
        $this->load->database();

    }

    public function index(){
		
		$this->load->library("session");
        $unsession_data_set = array("check_type", 
                                    "email", 
                                    "login_name", 
                                    "login_firstname", 
                                    "login_lastname", 
                                    "login_level", 
                                    "__ci_last_regenerate");
        
        $unset_dataset = Array("email" => $this->session->userdata("email"), 
                               "check_type" => $this->session->userdata("check_type"));

        $this->load->model("logout_model");
		$check_login = $this->logout_model->logout($unset_dataset);

		$this->session->unset_userdata($unsession_data_set);
		$this->session->sess_destroy();
		redirect("login", "refresh");

    }

    public function login(){
    	//
    }

}