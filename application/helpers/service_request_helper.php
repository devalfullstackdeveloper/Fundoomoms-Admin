<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



 function RoleWiseUserData($role){

 	$ci=& get_instance();
	$ci->load->database();

	$ci->db->select("id, name");
	$ci->db->where("status","1");
	if($_SESSION['LoginUserData']['is_admin']=="1"){
    }else{
    	$ci->db->where("city",$_SESSION['LoginUserData']['city']);
    }
	$ci->db->where("role",$role);
	$ci->db->order_by("name","asc");
	$query = $ci->db->get("user_register");
	$result = $query->result_array();
	return $result;
}

 function User_Status_Wise_Service_Request($userid,$status,$usertype){
 	$ci=& get_instance();
	$ci->load->database();

	$ci->db->select("ser_id");
	$ci->db->where("s_status",$status);
	if($usertype=="technician"){
		$ci->db->where("technician",$userid);	
	}
	$query = $ci->db->get("service_request");
	$result = $query->num_rows();
	return $result;
	
 }

 function GetAllCities(){
 	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select("*");
	$ci->db->where("status","1");
	$query = $ci->db->get("states");
	$result = $query->result_array();
	return $result;
 }

?>