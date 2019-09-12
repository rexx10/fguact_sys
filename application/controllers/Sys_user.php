<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sys_user extends CI_Controller {
            
	public function __construct()
	{
		parent::__construct();
        $this->load->library("session");
        $this->load->library("user");
		$this->load->helper('url');
		$this->load->helper("my_tool_helper");
        $this->load->helper("check_login_type_helper");
		date_default_timezone_set("Asia/Taipei");
		$this->load->model('sys_user_model','person');
	}

	public function index()
	{

        $data = Array("login_name" => $this->session->userdata("login_name"), 
                      "login_firstname" => $this->session->userdata("login_firstname"), 
                      "email" => $this->session->userdata("email"), 
                      "check_type" => $this->session->userdata("check_type"), 
                      "login_level" => $this->session->userdata("login_level"));

		$data["page_title"] = "新增 / 修改 使用者資料";
        check_login_type($data);
        if(!$this->user->hasPermission("modify", strtolower(__class__)."/".strtolower(__function__))){
            $this->user->logout();
        }
        $this->load->view("actpoj_header", $data);
		$this->load->view('sys_user_view');
	}

	public function ajax_list()
	{
		if(empty($this->input->post("type", TRUE))){
		    $list = $this->person->get_datatables();
		    $data = array();
		    $no = $_POST['start'];

		    foreach ($list as $person) {
		    	$no++;
		    	$row = array();
		    	$Btn_Disable = "";
		        $Btn_Onclick_del = "";
		        $Btn_Onclick_edit = "";
			    $row[] = $person->manger_name;
		    	$row[] = $person->lastname."&nbsp;".$person->firstname;
		    	$row[] = $person->email;
		    	$row[] = ($person->date_added != "") ? date("Y-m-d H:i:s", $person->date_added) : "2017-01-01 00:00:00";

		    	//if($this->session->userdata("login_name") != "root"){
		    	    if($person->manger_name == "root"){
		    		    $Btn_Disable = "Disabled";
		    		    $Btn_Onclick_edit = "";
		    		    $Btn_Onclick_del = "";
		    	    }else{
		    	    	$Btn_Disable = "";
		    	    	$Btn_Onclick_edit = "href= javascript:void(0)  title='Edit' onclick=edit_person('".$person->manger_id."')";
		    	    	$Btn_Onclick_del = "href= javascript:void(0)  title='Delete' onclick=delete_person('".$person->manger_id."')";
		    	    }
		        //}else{
		    	    //$Btn_Disable = "";
		    	    //$Btn_Onclick_edit = "href= javascript:void(0)  title='Edit' onclick=edit_person('".$person->manger_id."')";
		    	   // $Btn_Onclick_del = "href= javascript:void(0)  title='Delete' onclick=delete_person('".$person->manger_id."')";
		        //}
			
		    	$row[] = ($person->status == "1") ? "啟用" : "未啟用";

			    //add html for action
			    $row[] = '<a class="btn btn-sm btn-primary" '.$Btn_Onclick_edit.' '.$Btn_Disable.'><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" '.$Btn_Onclick_del.' '.$Btn_Disable.'><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			    $data[] = $row;
		    }

		    $output = array(
			      			"draw" => $_POST['draw'],
				    		"recordsTotal" => $this->person->count_all(),
				    		"recordsFiltered" => $this->person->count_filtered(),
					    	"data" => $data,
			               );
		    //output to json format
		    echo json_encode($output);
		}elseif(!empty($this->input->post("type", TRUE))){
			if($this->input->post("type", TRUE) == "add"){
				$list = $this->person->get_manger_group();
			    $data = Array("data" => $list);
			    echo json_encode($data);
			}
		}

	}

	public function ajax_edit($id)
	{

		$list = $this->person->get_by_id($id);
		if($this->session->userdata("login_level") >= $list->manger_level){
		    $gid_list = $this->person->get_manger_group();
		    $data = Array("id" => $list->manger_id, 
	                      "authority" => $list->manger_group_id, 
	                      "firstname" => $list->firstname, 
	                      "lastname" => $list->lastname, 
	                      "ac_mail" => $list->email, 
	                      "authority_list" => $gid_list);
		    $data["ac_type"] = ($list->status == "1") ? "O" : "X";
		    $data["aname"] = ($list->manger_name == "root") ? "H" : "L"; 
		    $data["type_fromat"] = "O";   
		//This H is root, L is Any Level

		//$data->dob = '0000-00-00';// ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
	    }else{
		    $data["type_fromat"] = "X";
	    }
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate("add");
		$data = array(
				"firstname" => $this->input->post("firstname", TRUE),
				"lastname" => $this->input->post("lastname", TRUE),
				"email" => $this->input->post("ac_mail", TRUE),
				"userpw" => $this->input->post("password", TRUE),
				"manger_group_id" => $this->input->post("authority", TRUE), 
				"status" => $this->input->post("ac_type", TRUE)
			);
		$manger_name = $this->person->get_manger_group_name($data["manger_group_id"]);
		$data["manger_name"] = $manger_name->name;
		switch($data["manger_name"]) {
			case "Admin":
				$data["manger_level"] = "10";
				break;

			case "Manger":
				$data["manger_level"] = "5";
				break;

			case "User":
				$data["manger_level"] = "1";
				break;
			
			default:
				$data["manger_level"] = "99";
				break;
		}
		$data["userpw"] = crypt($data["userpw"], "fguact_sys");
		$data["date_added"]  = strtotime(date("Y-m-d H:i:s"));
		$data["status"] = ($data["status"] == "O") ? "1" : "0";
		$insert = $this->person->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate("update");
		$data = array(
			    "firstname" => $this->input->post("firstname", TRUE),
				"lastname" => $this->input->post("lastname", TRUE),
				"email" => $this->input->post("ac_mail", TRUE),
				"manger_group_id" => $this->input->post("authority", TRUE), 
				"status" => $this->input->post("ac_type", TRUE)
			);
		if(!empty($this->input->post("password", TRUE))){
			$data["userpw"] = crypt($this->input->post("password", TRUE), "fguact_sys");
		}
		if($this->session->userdata("login_level") != "root"){
		    $manger_name = $this->person->get_manger_group_name($data["manger_group_id"]);
		    $data["manger_name"] = $manger_name->name;
		}else{
			$data["manger_name"] = "root";
		}

		switch($data["manger_name"]) {
			case "Admin":
				$data["manger_level"] = "10";
				break;

			case "Manger":
				$data["manger_level"] = "5";
				break;

			case "User":
				$data["manger_level"] = "1";
				break;
			
			default:
				$data["manger_level"] = "99";
				break;
		}
		
		//$data["date_added"]  = strtotime(date("Y-m-d H:i:s"));
		$data["status"] = ($data["status"] == "O") ? "1" : "0";
		//print_r($data);
		$this->person->update(array('manger_id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$list = $this->person->get_by_id($id);
		if($this->session->userdata("login_level") >= $list->manger_level){
		    $this->person->delete_by_id($id);
		    echo json_encode(array("status" => TRUE, "type_fromat" => "O"));
		}else{
			echo json_encode(array("status" => FALSE, "type_fromat" => "X"));
		}
	}

	public function validators_data(){
		$data = $this->input->post(Array("id", 
	                                     "ac_mail", 
	                                     "oE-mail"), TRUE);

        if($data["oE-mail"] == $data["ac_mail"]){
            echo json_encode(array('valid' => "true"));
        }else{

        	$data = $this->person->get_validators_data($data);
        	echo json_encode(array('valid' => $data));
        }

	}


	private function _validate($crud_type)
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('firstname') == '')
		{
			$data['inputerror'][] = 'firstname';
			$data['error_string'][] = '使用者 【 名子 】 尚未輸入';
			$data['status'] = FALSE;
		}

		if($this->input->post('lastname') == '')
		{
			$data['inputerror'][] = 'lastname';
			$data['error_string'][] = '使用者 【 姓氏 】 尚未輸入';
			$data['status'] = FALSE;
		}

		if($this->input->post('ac_mail') == '')
		{
			$data['inputerror'][] = 'ac_mail';
			$data['error_string'][] = '請輸入使用者 【 電子信箱 】';
			$data['status'] = FALSE;
		}

		if(!empty($this->input->post('ac_mail'))){

			if($this->input->post('ac_mail', TRUE) != $this->input->post('oemail', TRUE) | $crud_type == "add"){
				$this->load->helper("my_tool_helper");
				if(!judg_format("4", $this->input->post('ac_mail', TRUE))){
        	        $data['inputerror'][] = 'ac_mail';
			        $data['error_string'][] = '使用者 【 電子信箱 】 格式有誤';
			        $data['status'] = FALSE;
				}
        	    if(!$this->person->get_validators_data($this->input->post('ac_mail', TRUE))){
        	        $data['inputerror'][] = 'ac_mail';
			        $data['error_string'][] = '使用者 【 電子信箱 】 重複';
			        $data['status'] = FALSE;
        	    }
			}

		}

        if($crud_type == "add"){
		    if($this->input->post('password') == '')
		    {
			    $data['inputerror'][] = 'password';
			    $data['error_string'][] = '請輸入使用者 【 密碼 】';
			    $data['status'] = FALSE;
		    }

		    if($this->input->post('confirm_password') == '')
		    {
			    $data['inputerror'][] = 'confirm_password';
		    	$data['error_string'][] = '請輸入使用者 【 確認密碼 】';
		    	$data['status'] = FALSE;
		    }
        }

		if($this->input->post('password') != $this->input->post('confirm_password')){
			$data['inputerror'][] = 'confirm_password';
			$data['error_string'][] = '使用者 【 密碼 】 和 【 確認密碼 】 不符!';
			$data['status'] = FALSE;
		}

		if($this->input->post('authority') == 'no')
		{
			$data['inputerror'][] = 'authority';
			$data['error_string'][] = '請選擇使用者 【 權限 】';
			$data['status'] = FALSE;
		}

		if($this->input->post('ac_type') == '')
		{
			$data['inputerror'][] = 'ac_type';
			$data['error_string'][] = '請選擇使用者 【 狀態 】';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}