<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_User{
	private $email;
	private $manger_name;
	private $permission = array();

	public function __construct(){
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library("session");

		if(!empty($CI->session->userdata("email"))){
			$CI->db->where("email", (int)$CI->session->userdata("email"));
			$CI->db->where("check_data", $CI->session->userdata("check_type"));
			$CI->db->where("status", "1");
			$query = $CI->db->get("manger");

			if($query->num_rows()){
				$row = $query->row_array(); 
				$this->mail = $row["email"];
				$this->manger_name = $row["manger_name"];
				$this->manger_group_id = $row["manger_group_id"];

				$up_data = Array("ip" => $CI->input->ip_address());
				$CI->db->where("email", $this->mail);
				$CI->db->update("manger", $up_data);

				$query = "";
				$CI->db->where("manger_group_id", $this->manger_group_id);
				$CI->db->select("permission");
				$query = $CI->db->get("manger_group");

				if($query->num_rows() > 0){
					$row = "";
					$row = $query->row_array();
					$user_group_query = $row["permission"];
				}

				$permissions = json_decode($user_group_query, TRUE);

				if(is_array($permissions)){
					foreach($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}

			}else{
				//$CI->load->library("logout");
				//$CI->logout->logout();
				$this->logout();
			}

		}
	}

	public function logout(){

		$CI =& get_instance();
        $unsession_data_set = array("check_type", 
                                    "email", 
                                    "login_name", 
                                    "login_firstname", 
                                    "login_lastname", 
                                    "login_level", 
                                    "__ci_last_regenerate");
        
        $unset_dataset = Array("email" => $CI->session->userdata("email"), 
                               "check_type" => $CI->session->userdata("check_type"));

        $CI->load->model("logout_model");
		$check_login = $CI->logout_model->logout($unset_dataset);

		$CI->session->unset_userdata($unsession_data_set);
		//$CI->session->sess_destroy();
		$CI->session->set_userdata(Array("check_error" => "登入資料驗證失敗"));
		redirect("login", "refresh");

	}

	public function hasPermission($key, $value){
		if(isset($this->permission[$key])){
			return in_array($value, $this->permission[$key]);
		}else{
			return false;
		}
	}

	public function echom(){
		return $this->permission;
	}
}

?>