<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sys_set extends CI_Controller {
            
    public function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->library("session");
        $this->load->library("user");
        $this->load->helper("check_login_type_helper");

    }

    public function index(){
        //
        $data = Array("login_name" => $this->session->userdata("login_name"), 
                      "login_firstname" => $this->session->userdata("login_firstname"), 
                      "email" => $this->session->userdata("email"), 
                      "check_type" => $this->session->userdata("check_type"), 
                      "login_level" => $this->session->userdata("login_level"));

        check_login_type($data);
        if(!$this->user->hasPermission("modify", strtolower(__class__)."/".strtolower(__function__))){
            $this->user->logout();
        }
        redirect("sys_user", "refresh");

    }

}