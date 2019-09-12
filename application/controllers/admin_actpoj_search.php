<?php
class Admin_actpoj_search extends CI_Controller {
            
    public function __construct()
    {

        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('pagination');
        $this->load->model('pagination_model');
        date_default_timezone_set("Asia/Taipei");

    }

    public function index(){
    	//
    }


}