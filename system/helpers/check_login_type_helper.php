<?php  if(!defined("BASEPATH")) exit("No direct script access allowed");

    if(!function_exists("check_login_type")){
				
		function check_login_type($data_set){
			
			$CI =& get_instance();
			
		    $CI->load->database();
		    $CI->load->library("session");
		    $CI->load->helper("my_tool_helper");
		    if(empty($CI->session->userdata("check_type"))){
		    	tool_alert("非法登入或使用，請重新登入");
		    	redirect("login","refresh");

		    }

		    $data_arr = Array("email" => $data_set["email"], 
		                      "check_data" => $data_set["check_type"], 
		                      "status" => "1");
            $query = $CI->db->get_where("manger", $data_arr);
			
			if(empty($query->num_rows())){

				//$newdata = Array("Error_type" => "非法登入或使用，請重新登入");
				tool_alert("非法登入或使用，請重新登入");
				
				redirect("login","refresh");
				
			}
			
		}		
		
	}

?>