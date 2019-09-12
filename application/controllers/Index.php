<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct(){
		
		parent::__construct();
		$this->load->database();
		date_default_timezone_set('Asia/Taipei');
	}

	public function index()
	{
		echo "Hello World!!";
	}
}
