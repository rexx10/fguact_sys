<?php 
class Login_model extends CI_Model{
    
	public function __construct(){
		
		parent::__construct();
		
	}

    public function login($data_set){
    	//
        //$this->db->where("email", $data_set["email"]);
		//$this->db->where("userpw", $data_set["password"]);
		//$this->db->where("status", "1");

		$data_arr = Array("email" => $data_set["email"], 
			              "userpw" => $data_set["password"], 
			              "status" => "1");

		$query = $this->db->get_where("manger", $data_arr);

		if(($query->num_rows() > 0)){
			
            foreach ($query->result() as $row)
            {
                $data["login_name"] = $row->manger_name;
                $data["login_firstname"] = $row->firstname;
                $data["login_lastname"] = $row->lastname;
                $data["login_level"] = $row->manger_level;
                //echo $data_set["login_name"] = $row->manger_group_id;
            }
			
		}else{
			
			$data = false;
			
		}

		return $data;
    }

    public function update_check_data($data_set){
    	//
		$data = Array("check_data" => $data_set["check_data"], 
			          "login_date" => $data_set["login_date"]);
        $this->db->where("email", $data_set["email"]);
        $this->db->update("manger", $data); 
		
		return TRUE;
    }
}
?>