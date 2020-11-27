<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function getData($table,$params=array(),$where_id,$where_value){

 	$ci=& get_instance();
	$ci->load->database();

	if(count($params)>0){
		$cols = implode(',',$params);
		$ci->db->select($cols);
	}else{
		$ci->db->select("*");
	}
	$ci->db->from($table);
	$ci->db->where($where_id,$where_value);
	$query = $ci->db->get();
	$result = $query->result_array();
	return $result;
}

function getCountCur($class){
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('curriculum_day');
    $ci->db->from('curriculum');
    $ci->db->where('curriculum_class',$class);
    $ci->db->group_by('curriculum_day');
    $query = $ci->db->get();
    $result = $query->num_rows();
    return $result;
}

function getValidity($userid){
	$ci=& get_instance();
	$ci->load->database();
	$data = array();
	$userData = getData('user_register',array('class','package'),'id',$userid);
	if($userData[0]['class']!=""){
		$class = getData('tb_class',array(),'class_id',$userData[0]['class']);
	    $package = getData('tb_package',array('type','days'),'package_id',$userData[0]['package']);
	    $payment = getData('payment_details',array(),'user_id',$userid);
	    
	    if($package[0]['type']=="free"){
	        $data['total_days'] = $package[0]['days'];
	    }else{
	        $data['total_days'] = $class[0]['c_days'];
	    }

	    if($payment[0]['pay_status'] == 1){
		    // $firstDay = date("Y-m-d",strtotime(($payment[0]['created_date'])));/* Daxit Change*/
		    $firstDay = date("Y-m-d",strtotime(($payment[0]['payment_date'])));/* Daxit Change*/
		    // $last_days = date("Y-m-d h:i:s",strtotime("+".$data['total_days']." day", strtotime($payment[0]['created_date'])));
		    $last_days = date("Y-m-d",strtotime("+365 day", strtotime($payment[0]['payment_date'])));

		    $date1 = date_create(date("Y-m-d"));
		    $date2 = date_create($last_days);
		    $date3 = date_create($firstDay);
		    
		    $diff  = date_diff($date2,$date3);
		    $diff1 = date_diff($date1,$date3);
		    $diff2 = $diff->format("%a") - $diff1->format("%a");
		    $diff3 = $diff->format("%a") - $diff2;
		    // $data['validity'] = $diff->format("%a")."/365";

	    	$data['validity'] = ($diff3>0) ? $diff3."/365" : "1/365";
	    }else{
	    	// $data['validity'] = "0/365";
	    	// $firstDay = date("Y-m-d",strtotime(($payment[0]['created_date'])));/* Daxit Change*/
		    $firstDay = date("Y-m-d",strtotime(($payment[0]['created_date'])));/* Daxit Change*/
		    // $last_days = date("Y-m-d h:i:s",strtotime("+".$data['total_days']." day", strtotime($payment[0]['created_date'])));
		    $last_days = date("Y-m-d",strtotime("+365 day", strtotime($payment[0]['created_date'])));

		    $date1 = date_create(date("Y-m-d"));
		    $date2 = date_create($last_days);
		    $date3 = date_create($firstDay);
		    
		    $diff  = date_diff($date2,$date3);
		    $diff1 = date_diff($date1,$date3);
		    $diff2 = $diff->format("%a") - $diff1->format("%a");
		    $diff3 = $diff->format("%a") - $diff2;
		    // $data['validity'] = $diff->format("%a")."/365";
		    
	    	$data['validity'] = ($diff3>0) ? $diff3."/365" : "1/365";
	    }
	    
	    $data['completed'] = ($payment[0]['current_day']=="") ? "1/".$data['total_days'] : $payment[0]['current_day']."/".$data['total_days'];
	}
	return $data;
}

function statusText($status){
        switch ($status) {
            case '1':
                $text = "New";
                break;
            case '2':
                $text = "Reschedule Call";
                break;
            case '3':
                $text = "Pending";
                break;    
            case '4':
                $text = "Follow Up";
                break;
            case '5':
                $text = "Overdue";
                break;
            case '6':
            	$text = "Completed";
            	break;            
            default:
                $text = "";
                break;
        }
       return $text;     
}

function getMultiWhere($table,$params=array(),$where=array(),$count="",$orderby="",$sortorder="",$orwhere=""){
	$ci=& get_instance();
	$ci->load->database();

	if(count($params)>0){
		$cols = implode(',',$params);
		$ci->db->select($cols);
	}else{
		$ci->db->select("*");
	}
	$ci->db->from($table);
	if(count($where)>0){
		foreach ($where as $key => $value) {
			$ci->db->where($key,$value);
		}
	}
	if(!empty($orwhere)){
		$where1 = "(pay_status='0' or pay_status='1')";
		$ci->db->where($where1);
	}
	if(!empty($orderby)){
		$ci->db->order_by($orderby,$sortorder);
	}
	$query = $ci->db->get();
	if(!empty($count)){
		$result = $query->num_rows();
	}else{
		$result = $query->result_array();	
	}
	return $result;
}

function getData2($type){
	// $ci=& get_instance();
	// $ci->load->database();

 //    $ci->db->select('payment_id,user_id,created_date,pay_status,current_day');
 //    $ci->db->from('payment_details');
 //    if(!empty($type)){
 //        if($type=="1"){
 //            $where = "(pay_status='0' or pay_status='1')";
 //            $ci->db->where($where);
 //        }else if($type=="0"){
 //            $ci->db->where("pay_status","0");
 //        }
 //    }
 //    $ci->db->order_by('user_id','desc');
 //    $query = $ci->db->get();
 //    $result = $query->result_array();
 //    return $result;
}

function test(){
	echo "1";
}

function getInactiveUser(){
		$ci=& get_instance();
		$ci->load->database();

        $ci->db->select("created_date,current_day,user_id");
        $ci->db->from('payment_details');

        $query1 = $ci->db->get();
        $result = $query1->result_array();
        $ids = array();
        if(count($result)>0){
            $today = date("Y-m-d");
            foreach ($result as $key => $value) {
                if(empty($value['current_day'])){
                    $fifteen = date("Y-m-d",strtotime("+15 days",strtotime($value['created_date'])));
                    if($today>$fifteen){
                        array_push($ids,$value['user_id']);
                    }
                }else{
                    if($value['current_day']>=15){
                        $current_day = date("Y-m-d",strtotime("+".$value['current_day']." days",strtotime($value['created_date'])));
                        $fifteen = date("Y-m-d",strtotime("+15 days",strtotime($current_day)));
                        $chkF = $value['current_day']+15;
                        if($today>$fifteen){
                            if($value['current_day']<$chkF){
                                array_push($ids,$value['user_id']);
                            }
                        }
                    }else{
                        $fifteen = date("Y-m-d",strtotime("+15 days",strtotime($value['created_date'])));
                        if($today>$fifteen){
                            if($value['current_day']<15){
                                array_push($ids,$value['user_id']);
                            }
                        }
                    }
                }
            }
        }
        $ids = array_unique($ids);
        // $implode = implode(",", $ids);
        return $ids;
    }


    