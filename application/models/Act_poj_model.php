<?php
class Act_poj_model extends CI_Model{

    function __construct()
    {
        parent::__construct();
    }

    public function create_data($input_data)
    {

        $data = array("activity_code" => $input_data["activity_code"], 
                      "semester" => $input_data["semester"], 
                      "activity_date" => $input_data["activity_date"], 
                      "activity_time_start" => $input_data["s_activity_time"], 
                      "activity_time_end" => $input_data["e_activity_time"], 
                      "activity_name" => $input_data["activity_name"], 
                      "activity_sec_item" => $input_data["sec_item"], 
                      "activity_location" => $input_data["activity_location"], 
                      "topic" => $input_data["topic"], 
                      "speaker_dep" => $input_data["speaker_dep"], 
                      "speaker_name" => $input_data["speaker_name"], 
                      "record_datetime" => $input_data["record_datetime"]);

        $this->db->insert("activity_data_record", $data);

        return true;
    }

    public function get_activity_data_list($limit, $start, $st = NULL){
      
        if ($st == "NIL") $st = "";
        $or_where = "(semester like '%".$st."%') OR (activity_date like '%".$st."%') OR (activity_time_start like '%".$st."%') OR (activity_time_end like '%".$st."%') OR (activity_name like '%".$st."%') OR (activity_sec_item like '%".$st."%') OR (activity_location like '%".$st."%') OR (topic like '%".$st."%') OR (speaker_dep like '%".$st."%') OR (speaker_name like '%".$st."%')";
        $sql = "select * from activity_data_record where ".$or_where." ORDER BY activity_code DESC LIMIT " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query->result();

    }

    public function get_activity_count($st = NULL){

        if ($st == "NIL") $st = "";
        $or_where = "(semester like '%".$st."%') OR (activity_date like '%".$st."%') OR (activity_time_start like '%".$st."%') OR (activity_time_end like '%".$st."%') OR (activity_name like '%".$st."%') OR (activity_sec_item like '%".$st."%') OR (activity_location like '%".$st."%') OR (topic like '%".$st."%') OR (speaker_dep like '%".$st."%') OR (speaker_name like '%".$st."%')";
        $sql = "select * from activity_data_record where ".$or_where;
        $query = $this->db->query($sql);
        return $query->num_rows();

    }

    public function search_participants_max_order($id){
        // 取得參加者最大單號
        $sql = "SELECT * FROM activities_participants_record WHERE participants_code=(SELECT max(participants_code) FROM activities_participants_record WHERE activity_code = '".$id."')";
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            foreach($query->result() as $row){

                $max_code = $row->participants_code;
            
            }
        }else{
            $max_code = "no_data";
        }

        return $max_code;
    }

    public function create_participants($multi_data){
        //
        $data = array("participants_code" => $multi_data["p_code"], 
                      "activity_code" => $multi_data["id"], 
                      "college_name" => $multi_data["college"], 
                      "teach_dep_name" => $multi_data["teach_dep"], 
                      "staff_name" => $multi_data["staff"], 
                      "mail" => $multi_data["e-mail"], 
                      "record_datetime" => $multi_data["record_datetime"]);
        
        $this->db->insert("activities_participants_record", $data);
        
        /**$query = $this->db->query("SELECT LAST_INSERT_ID()");

        if($query->num_rows() > 0){
           $nm = $query->result();
        }

        $obj = (array)$nm[0]; // convert the object to array
        $value = $obj["LAST_INSERT_ID()"];**/
        return TRUE;

    }
	
    public function create_satisfaction_survey($multi_data){
        //
        $data = array("participants_code" => $multi_data["p_code"], 
                      "activity_code" => $multi_data["id"], 
                      "questionnaire" => $multi_data["questionnaire"],
                      "gain_level" => $multi_data["gain_level"], 
                      "satisfaction_level" => $multi_data["satisfaction_level"], 
                      "record_datetime" => $multi_data["record_datetime"]);

        $this->db->insert("activities_satisfaction_survey_record", $data);
        return true;
    }
	
    public function update_participants($multi_data){

		    $data = array("college_name" => $multi_data["up_college"], 
                      "teach_dep_name" => $multi_data["up_teach_dep"], 
                      "staff_name" => $multi_data["up_staff_name"], 
                      "mail" => $multi_data["up_staff_mail"], 
                      "modify_datetime" => $multi_data["modify_datetime"]);

        $this->db->where("participants_code", $multi_data["pcode"]);
        $this->db->update("activities_participants_record", $data);
        return true;

	  }
	
    public function update_satisfaction_survey($multi_data){

	      $data = array("questionnaire" => $multi_data["questionnaire"], 
                      "gain_level" => $multi_data["gain_level"], 
                      "satisfaction_level" => $multi_data["satisfaction_level"], 
                      "modify_datetime" => $multi_data["modify_datetime"]);

        $this->db->where("participants_code", $multi_data["pcode"]);
        $this->db->update("activities_satisfaction_survey_record", $data);
        return true;

	  }

    public function del_participants($id){

        $this->db->delete("activities_participants_record", array("participants_code" => $id)); 
        return true;
    }

    public function del_satisfaction_survey($id){

        $this->db->delete("activities_satisfaction_survey_record", array("participants_code" => $id)); 
        return true;
    }

    public function del_activity_data($id){
        //
        $this->db->delete("activity_data_record", array("activity_code" => $id));
        $this->db->delete("activities_participants_record", array("activity_code" => $id));
        $this->db->delete("activities_satisfaction_survey_record", array("activity_code" => $id));
        return true;
    }

    public function get_update_data($activity_code){

        $this->db->where("activity_code", $activity_code);
        $query = $this->db->get("activity_data_record");

        if($query->num_rows() > 0){
            return $query->result();
        }

        

    }
    public function update_data($update_data){
        //
        $data = array("semester" => $update_data["semester"], 
                      "activity_date" => $update_data["activity_date"], 
                      "activity_time_start" => $update_data["s_activity_time"], 
                      "activity_time_end" => $update_data["e_activity_time"], 
                      "activity_name" => $update_data["activity_name"], 
                      "activity_sec_item" => $update_data["sec_item"], 
                      "activity_location" => $update_data["activity_location"], 
                      "topic" => $update_data["topic"], 
                      "speaker_dep" => $update_data["speaker_dep"], 
                      "speaker_name" => $update_data["speaker_name"],
                      "modify_datetime" => $update_data["modify_datetime"]);

        $activity_code = $update_data["activity_code"];
        $this->db->where('activity_code', $activity_code);
        $this->db->update("activity_data_record", $data); 
        return true;

    }

    public function del()
    {



    }



    public function get_activity_name()
    {
        $query = $this->db->get("activity_list");
        foreach ($query->result_array() as $row)
        {
             $row_0[] = $row['id'];
             $row_1[] = $row['activity_name'];
        }
        $rowdata["id"] = $row_0;
        $rowdata["name"] = $row_1;
        return $rowdata;
    }

    public function get_activity_sub_name($id = NULL)
    {   

        $sub_name = "";
        if(!empty($id)){
            $this->db->where("activity_id", $id);
        }
        $query = $this->db->get("sub_activity_list");
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row)
            {
                 $sub_name["sec_item"][] = $row["sub_activity_name"];
            }
            //return $sub_name;
        }

        return $sub_name;


    }

    public function get_speaker_dep()
    {

        $query = $this->db->get("administrative_dep_list");
        foreach ($query->result_array() as $row)
        {
             $row_0[] = $row['id'];
             $row_1[] = $row['company_name'];
        }
        $rowdata["id"] = $row_0;
        $rowdata["speaker_dep"] = $row_1;
        return $rowdata;

    }

    public function get_max_activity_code(){
        $sql = "SELECT * FROM activity_data_record WHERE activity_code=(SELECT max(activity_code) FROM activity_data_record)"; //找最大單號
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            foreach($query->result() as $row){

                $activity_code = $row->activity_code;
            
            }
        }else{
            $activity_code = "no_data";
        }

        return $activity_code;
    }

    public function get_college_dep_list(){
        //
        $query = $this->db->get("college_dep_list");
        foreach ($query->result_array() as $row)
        {
             $row_0[] = $row['id'];
             $row_1[] = $row['college_name'];
        }
        $data["college_dep_id"] = $row_0;
        $data["college_dep"] = $row_1;
        return $data;


    }

    public function get_teach_dep_list($college_dep_id){
        //
        $this->db->where("college_id", $college_dep_id);
        $query = $this->db->get("teaching_dep_list");
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row)
            {
                 $data["teach_dep_list"][] = $row["teach_dep_name"];
            }
            //return $sub_name;
        }

        return $data;
    }

    public function get_act_par_num($id){
        //
        $this->db->where("activity_code", $id);
        $query = $this->db->get("activities_participants_record");
        return $query->num_rows();
    }

    public function get_participate_data($sql){
        $query = $this->db->query($sql);

        $data = Array();
        foreach ($query->result_array() as $row ) {
            $data[] = $row;
        }
        return $data;
    }

    public function validators_data($data){
        //
        switch($data["stype"]){
          case "zero":
              $this->db->where("activity_code", $data["id"]);
              $this->db->where("mail", $data["e-mail"]);
              $query = $this->db->get("activities_participants_record");
              
              if($query->num_rows() > 0){
                $data = false;
              }else{
                $data = true;
              }
            break;
          
          case 1:
              $this->db->where("activity_code", $data["id"]);
              $this->db->where("mail", $data["up_staff_mail"]);
              $query = $this->db->get("activities_participants_record");
              
              if($query->num_rows() > 0){
                $data = false;
              }else{
                $data = true;
              }
            break;
        }

        return $data;
    }


}
?>