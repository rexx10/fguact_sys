<?php 
class Logout_model extends CI_Model{
    
	public function __construct(){
		
		parent::__construct();
		
	}

    public function logout($data_set){
    	//
		$data = Array("check_data" => "");
        $this->db->where("email", $data_set["email"]);
        $this->db->update("manger", $data); 
		
		return TRUE;
    }
}
?>