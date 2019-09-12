<?php
class Pagination_model extends CI_Model{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Taipei");
        
    }

    //fetch books
    function get_books($limit, $start, $st = NULL, $num=0)
    {
        if ($st == "NIL") $st = "";

        $sql_table = "activity_data_record, activities_participants_record";
        $join_where = "activity_data_record.activity_code = 
                       activities_participants_record.activity_code";

        switch($num){
            case "actitivy":
                //Activity, Meeting
                $sql_table = "activity_data_record";
                $or_where = "(activity_name LIKE '%".$st."%') OR 
                             (activity_sec_item LIKE '%".$st."%') OR 
                             (topic LIKE '%".$st."%')";
                $ORDER_BY = " ORDER BY activity_data_record.activity_code DESC";
                $sql_path = $sql_table." WHERE ".$or_where.$ORDER_BY;

                break;
            case "staff":
                //staff
                $sql_table = "activities_participants_record";
                $or_where = "staff_name LIKE '%".$st."%' OR 
                             activities_participants_record.mail LIKE '%".$st."%'";
                $group_by = "GROUP BY mail";
                $ORDER_BY = "AS T ORDER BY T.participants_code DESC";
                $sql_path = "(SELECT * FROM ".$sql_table." WHERE ".$or_where.$group_by.")".$ORDER_BY;

                break;
            case "semester":
                //semester
                $sql_table = "activity_data_record";
                $or_where = "(semester LIKE '%".$st."%')";
                $ORDER_BY = " ORDER BY activity_data_record.activity_code DESC";
                $sql_path = $sql_table." WHERE ".$or_where.$ORDER_BY;

                break;
            default:
                //All Table
                $or_where = "(semester LIKE '%".$st."%') OR 
                             (activity_date LIKE '%".$st."%') OR 
                             (activity_time_start LIKE '%".$st."%') OR 
                             (activity_time_end LIKE '%".$st."%') OR 
                             (activity_name LIKE '%".$st."%') OR 
                             (activity_sec_item LIKE '%".$st."%') OR 
                             (activity_location LIKE '%".$st."%') OR 
                             (topic LIKE '%".$st."%') OR 
                             (speaker_dep LIKE '%".$st."%') OR 
                             (speaker_name LIKE '%".$st."%')";
                $sql_table = "activity_data_record";
                $ORDER_BY = " ORDER BY activity_data_record.activity_code DESC";
                $sql_path = $sql_table." WHERE ".$or_where.$ORDER_BY;

                break;
        }
        
        $sql = "SELECT * FROM ".$sql_path." LIMIT ".$start.", ".$limit;

        $query = $this->db->query($sql);
        return $query->result();
    }
    
    function get_books_count($st = NULL,  $num=0){

        if ($st == "NIL") $st = "";

        $sql_table = "activity_data_record, activities_participants_record";
        $join_where = "activity_data_record.activity_code = 
                       activities_participants_record.activity_code";

        switch($num){
            case "1":
                //Activity, Meeting
                $sql_table = "activity_data_record";
                $or_where = "(activity_name LIKE '%".$st."%') OR 
                             (activity_sec_item LIKE '%".$st."%') OR 
                             (topic LIKE '%".$st."%')";

                $sql_path = $sql_table." WHERE ".$or_where;

                break;
            case "2":
                //staff
                $sql_table = "activities_participants_record";
                $or_where = "staff_name LIKE '%".$st."%' OR 
                             activities_participants_record.mail LIKE '%".$st."%'";
                $group_by = "GROUP BY mail";
                $ORDER_BY = "AS T ORDER BY T.participants_code DESC";
                $sql_path = "(SELECT * FROM ".$sql_table." WHERE ".$or_where.$group_by.")".$ORDER_BY;

                break;
            case "3":
                //semester
                $sql_table = "activity_data_record";
                $or_where = "(semester LIKE '%".$st."%')";
                $sql_path = $sql_table." WHERE ".$or_where;

                break;
            
            default:
                //All table
                $or_where = "(semester LIKE '%".$st."%') OR 
                             (activity_date LIKE '%".$st."%') OR 
                             (activity_time_start LIKE '%".$st."%') OR 
                             (activity_time_end LIKE '%".$st."%') OR 
                             (activity_name LIKE '%".$st."%') OR 
                             (activity_sec_item LIKE '%".$st."%') OR 
                             (activity_location LIKE '%".$st."%') OR 
                             (topic LIKE '%".$st."%') OR 
                             (speaker_dep LIKE '%".$st."%') OR 
                             (speaker_name LIKE '%".$st."%')";

                $sql_table = "activity_data_record";
                $sql_path = $sql_table." WHERE ".$or_where;

                break;
        }

        //$counts = "SELECT COUNT(*) FROM activities_participants_record WHERE activity_code";  //參加人數

        $sql = "SELECT * FROM ".$sql_path;
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function export_data($id, $pid = NULL, $data_type, $search_val){

        switch($data_type){
            case "by_staff":

                $table_name = "activity_data_record";
                $table_name2 = "activities_participants_record";
                $this->db->where("activity_code", $id);
                $query = $this->db->get($table_name);

                foreach($query->result() as $row){

                    if($row->activity_name == $row->activity_sec_item){

                        $data["activity_full_name"] = $row->activity_name;

                    }else{

                        $data["activity_full_name"] = $row->activity_name."-".$row->activity_sec_item;

                    }

                    $data["topic"] = $row->topic;
                    $data["semester"] = $row->semester;

                }

                $query->free_result();

                $this->db->where("activity_code", $id);
                $query = $this->db->get($table_name2);
                $data["data_count"] = count($query->result());
                $i = 0;
                foreach($query->result() as $row){
                    $data["row_data"][$i]["teach_dep_name"] = $row->teach_dep_name;
                    $data["row_data"][$i]["staff_name"] = $row->staff_name;
                    $data["row_data"][$i]["mail"] = $row->mail;
                    $i++;
                }

                $query->free_result(); 

                break;
            
            case "by_activity":


                $table_name = "activity_data_record";
                $table_name2 = "activities_participants_record";
                $or_where = "";

                if(!empty($pid)){                    
                    
                    $data["people_num"] = count($pid);

                    for($i=0; $i<count($pid); $i++){
                    
                        $or_where .= "participants_code = '".$pid[$i]."'";

                        if($i != count($pid)-1){

                            $or_where .= " OR ";

                        }

                    }

                    $ORDER_BY = " ORDER BY participants_code DESC";
                    $sql = "SELECT * FROM ".$table_name2." WHERE ".$or_where.$ORDER_BY;
                    $query = $this->db->query($sql);
                

                    foreach($query->result() as $key => $row){
                        $data["staff_name"][] = $row->staff_name;
                        $data["mail"][] = $row->mail;
                    }

                    $query->free_result();
                    $or_where1 = "";
                    $or_where = "";

                    for($i=0; $i<count($data["mail"]); $i++){
                    
                        $or_where .= "activities_participants_record.mail = '".$data["mail"][$i]."'";

                        if($i != count($pid)-1){

                            $or_where .= " OR ";

                        }

                    
                        $or_where1 = $table_name.".activity_code = ".$table_name2.".activity_code";

                        $ORDER_BY = " ORDER BY activity_data_record.semester DESC";
                        $sql = "SELECT * FROM ".$table_name.", ".$table_name2." WHERE (".$or_where1.") AND (".$or_where.")".$ORDER_BY;
                        $query = $this->db->query($sql);
                    }
                }else{
                    //
                    for($i=0; $i<count($id); $i++){
                    
                        $or_where .= "activity_code = '".$id[$i]."'";

                        if($i != count($id)-1){

                            $or_where .= " OR ";

                        }

                    }
                    $GROUP_BY = " GROUP BY mail";
                    $sql = "SELECT * FROM ".$table_name2." WHERE ".$or_where.$GROUP_BY;
                    $query = $this->db->query($sql);
                    if($query->num_rows() > 0){
                        foreach($query->result() as $key => $row){
                            $data["staff_name"][] = $row->staff_name;
                            $data["mail"][] = $row->mail;
                        }
                    }else{
                        $data["people_num"] = 0;
                        return $data;
                    }

                    $query->free_result();
                    $or_where1 = "";
                    $or_where = "";
                    $data["people_num"] = count($data["mail"]);

                    for($i=0; $i<count($data["mail"]); $i++){
                    
                        $or_where .= "activities_participants_record.mail = '".$data["mail"][$i]."'";

                        if($i != count($data["mail"])-1){

                            $or_where .= " OR ";

                        }

                    }
                        $or_where1 = $table_name.".activity_code = ".$table_name2.".activity_code";

                        $ORDER_BY = " ORDER BY activity_data_record.semester DESC";
                        $sql = "SELECT * FROM ".$table_name.", ".$table_name2." WHERE (".$or_where1.") AND (".$or_where.")".$ORDER_BY;
                        $query = $this->db->query($sql);
                    
                }


                $i=0;
                foreach($query->result() as $key => $row){
                    $data["semester"][$i] = $row->semester;
                    $data["activity_date"][$i] = $row->activity_date;

                    if($row->activity_name == $row->activity_sec_item){

                        $data["tmp_row_data"][$i]["activity_full_name"] = $row->activity_name;

                    }else{

                        $data["tmp_row_data"][$i]["activity_full_name"] = $row->activity_name."-".$row->activity_sec_item;

                    }

                    $data["college_name"][$i] = $row->college_name;
                    $data["teach_dep_name"][$i] = $row->teach_dep_name;
                    $data["topic"][$i] = $row->topic;
                    $data["tmp_mail"][$i] = $row->mail;

                    $i++;
                }

                for($i=0; $i<count($data["mail"]); $i++){                    
                    for($m=0; $m<count($data["tmp_mail"]); $m++){
                        if($data["mail"][$i] == $data["tmp_mail"][$m]){
                            $data["row_data"][$i][$m][] = $data["semester"][$m];
                            $data["row_data"][$i][$m][] = $data["activity_date"][$m];
                            $data["row_data"][$i][$m][] = $data["tmp_row_data"][$m]["activity_full_name"];
                            $data["row_data"][$i][$m][] = $data["college_name"][$m];
                            $data["row_data"][$i][$m][] = $data["teach_dep_name"][$m];
                            //$data["row_data"][$i][$m][] = $data["topic"][$m];
                            //$data["row_data"][$i][$m][] = $data["tmp_mail"][$m];
                        }
                    }

                    rsort($data["row_data"][$i]); 
                    $data["row_data"][$i]["act_count"] = count($data["row_data"][$i]);        
                }

                return $data;
                //
                break;

            case "by_semester":
                
                $table_name = "activity_data_record";
                $or_where = "";

                for($i=0; $i<count($id); $i++){
                    
                    $or_where .= "activity_code = '".$id[$i]."'";

                    if($i != count($id)-1){

                        $or_where .= " OR ";

                    }

                }

                $ORDER_BY = " ORDER BY semester DESC";
                $ORDER_BY_2 = "AS T ORDER BY T.activity_date DESC";
                $sql_script = "SELECT * FROM ".$table_name." WHERE ".$or_where.$ORDER_BY;
                $sql = "SELECT * FROM (".$sql_script.") ".$ORDER_BY_2;
                $query = $this->db->query($sql);

                if($query->result() > 0){

                    $i = 0;
                    $data["activity_total"] = count($query->result());

                    foreach($query->result() as $key => $row){

                        $data["semester_team"][] = $row->semester;
                        $data["tmp_row_data"][$i]["semester"] = $row->semester;

                        if($row->activity_name == $row->activity_sec_item){

                            $data["tmp_row_data"][$i]["activity_full_name"] = $row->activity_name;

                        }else{

                            $data["tmp_row_data"][$i]["activity_full_name"] = $row->activity_name."-".$row->activity_sec_item;

                        }

                        $data["tmp_row_data"][$i]["topic"] = $row->topic;

                        $i++;

                    }

                }

                $data["semester_team"] = array_unique($data["semester_team"]);
                rsort($data["semester_team"]);
                for($i=0; $i<count($data["tmp_row_data"]); $i++){

                    for($m=0; $m<count($data["semester_team"]); $m++){

                        if($data["tmp_row_data"][$i]["semester"] == $data["semester_team"][$m]){

                            $data["row_data"][$m][] = $data["tmp_row_data"][$i];

                        }

                   }

                }

                unset($data["tmp_row_data"]);

                break;
        }       

        return $data;

    }

    public function get_single_active_data($activity_code){
        $this->db->where("activity_code", $activity_code);
        $query = $this->db->get("activity_data_record");

        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function get_sact_par_num($id){
        //
        $this->db->where("activity_code", $id);
        $query = $this->db->get("activities_participants_record");
        return $query->num_rows();
    }

    public function get_sparticipate_data($sql){
        $query = $this->db->query($sql);

        $data = Array();
        foreach ($query->result_array() as $row ) {
            $data[] = $row;
        }
        return $data;
    }

}
?>