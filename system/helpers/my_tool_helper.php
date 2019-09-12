<?php


if(!function_exists("judg_format")){

    function judg_format($num, $data){

        switch($num){
            case 1:    //judg semester
                if (preg_match("/^[1-9]\d{1,2}-[1-2]$/", $data)) {
                    return true;
                }else{
                    return false;
                }
                break;

            case 2:    //judg date
                $YYYY_MM_DD = '/^(\d(([02468][048])|([13579][26]))\-((((0[13578])|(1[02]))\-((0[1-9])|([1-2][0-9])|(3[01])))|(((0[469])|(11))\-((0[1-9])|([1-2][0-9])|(30)))|(02\-((0[1-9])|([1-2][0-9])))))|(\d(([02468][1235679])|([13579][01345789]))\-((((0[13578])|(1[02]))\-((0[1-9])|([1-2][0-9])|(3[01])))|(((0[469])|(11))\-((0[1-9])|([1-2][0-9])|(30)))|(02\-((0[1-9])|(1[0-9])|(2[0-8])))))$/';
    
                if(!(preg_match($YYYY_MM_DD, $data))){
                    return false;
                }else{
                    return true;
                }
                break;
            case 3:    //judg time
                if(preg_match("/^[0-2]\d{0,1}:[0-6]\d{0,1}$/", $data)){
                    return true;
                }else{
                    return false;
                }
                break;
            case 4:    //judg mail
                if(preg_match("/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", $data)){
                    return true;
                }else{
                    return false;
                }
                break;
            }

    }

}

if(!function_exists("judg_empty")){
    
    function judg_empty($multi_data_arr){
        $empty_num = 0;

        foreach($multi_data_arr as $key => $value){
            if(empty($value)){
                //$input_key[] = $key;
                $input_val[] = 0;
            }else{
                $input_val[] = $value;
            }
        }

        for($i=1; $i<count($input_val); $i++){
            if(empty($input_val[$i])){
                $empty_num += 1;
            }
        }
        return $empty_num;

    }

}

if(!function_exists("clear_space")){

    function clear_space($data){
             
        foreach ($data as $key => $value) {
            $trim_data[$key] = trim($value);
        }

        return $trim_data;
    }

}

if(!function_exists("judg_datetime")){

    function judg_datetime($s_date, $s_time, $e_date, $e_time){
  
        $s_datetime = $s_date." ".$s_time;
        $e_datetime = $e_date." ".$e_time;
        if(strtotime($s_datetime) <= strtotime($e_datetime)){
            return true;
        }else{
            return false;
        }

    }

}

if(!function_exists("clear_html_tag")){

    function clear_html_tag($data){
        //clear HTML Tag
        foreach ($data as $key => $value) {
            $clear_html_tag_data[$key] = strip_tags($value);
        }
        return $clear_html_tag_data;
    }

}

if(!function_exists("roc_to_yuan")){

        function roc_to_yuan($roc_date){

            $roc_date_arr = explode("-", $roc_date);
            $yuan_date = ($roc_date_arr[0] + 1911)."-".$roc_date_arr[1]."-".$roc_date_arr[2];
            return $yuan_date;

        }

}

if(!function_exists("yuan_to_roc")){

        function yuan_to_roc($roc_date){

            $roc_date_arr = explode("-", $roc_date);
            $yuan_date = ($roc_date_arr[0] -1911)."-".$roc_date_arr[1]."-".$roc_date_arr[2];
            return $yuan_date;

        }

}

if(!function_exists("tool_alert")){

    function tool_alert($this_val){
        echo "<link rel='icon' href='".base_url("assets/images/fguact.png")."'>";
        echo "<script>";
        echo "alert('".$this_val."');";
       // echo "history.go(-1)";
        echo "</script>";
    }
    
}

if(!function_exists("close_window")){

    function close_window(){
        echo "<script>";
        echo "window.close();";
        echo "</script>";
    }
    
}

if(!function_exists("trimfloat")){

    function trimfloat($f, $use_input = 0){

        $s = "".$f;
        if(!preg_match("/^[.]*$/",$s)) { //無小數點的情況
            return ($use_input == 1) ? $s : $s;
        }
        list($n1, $n2) = preg_split("\.", $s);
 
        if (intval($n2) == 0) { //小數點後為0的情況
            return ($use_input == 1) ? $n1 : $n1;
        }
        while (substr($n2, -1) == "0") {
            $n2 = substr($n2,0,strlen($n2)-1);
        }
        if ($use_input == 1) {
            return $n1.".".$n2;
        } else {
            return $n1.".".$n2;
        }
    }
    
}

?>