<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service_request extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();
        $this->load->helper('service_request');
        $this->serviceReq = 'service_request';
        $this->customerList = 'user_register';
        $this->defectData = 'defect_details';
        $this->trailerType = 'trailer_type';
        $this->serviceStatus = 'service_status';
    }

    public function serviceReqlist() {
        $this->db->select('*');
        $this->db->from($this->serviceReq);
        if(isset($_SESSION['LoginUserData'])){
            if($_SESSION['LoginUserData']['is_admin']=="1"){
            }else{
                $this->db->where("region",$_SESSION['LoginUserData']['city']);
            }    
        }
        $this->db->order_by("s_status","asc");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function SearchReq($params=array()){
        $this->db->select("*");
        $this->db->from($this->serviceReq);
        if($_SESSION['LoginUserData']['is_admin']=="1"){
        }else{
            $this->db->where("region",$_SESSION['LoginUserData']['city']);
        }

        if(isset($params['status'])){
            if($params['status']=="all"){
            }else{
                $this->db->where("s_status",$params['status']);
            }
        }

        if(isset($params['tech'])){
            if($params['tech']=="all"){
            }else{
                $this->db->where("technician",$params['tech']);
            }
            
        }

        if(isset($params['state'])){
            if($params['state']=="all"){
            }else{
                $this->db->where("s_state",$params['state']);
            }
        }

        if(isset($params['city'])){
            if(empty($params['city'])){
            }else{
                $this->db->where("region",$params['city']);
            }
        }

        $this->db->order_by("s_status asc,created_date desc");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;

    }

    public function getRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->serviceReq);
        $this->db->where('ser_id', $params['ser_id']);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function getRowData($id){
        $this->db->select('*');
        $this->db->from($this->serviceReq);
        $this->db->where("ser_id",$id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function CustomerList($id=""){
        $this->db->select('*');
        $this->db->from($this->customerList);
        if($id!=""){
            $this->db->where("id",$id);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function DefectList($id=""){
        $this->db->select('*');
        $this->db->from($this->defectData);
        if($id!=""){
            $this->db->where("dd_id",$id);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;   
    }

    public function trailerList($id=""){
        $this->db->select('*');
        $this->db->from($this->trailerType);
        if($id!=""){
            $this->db->where("tt_id",$id);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;   
    }

    public function insert($data){
        $insert = $this->db->insert($this->serviceReq, $data);
        return $insert ? $this->db->insert_id() : false;
    }

    public function update($data, $id) {
        
        if (!array_key_exists('modified_date', $data)) {
            $data['modified_date'] = date("Y-m-d H:i:s");
        }
        $update = $this->db->update($this->serviceReq, $data, array('ser_id' => $id));
        return $update ? true : false;
    }

     public function delete($id) {
        //update user from users table
        $delete = $this->db->delete('service_request', array('ser_id' => $id));
        //return the status
        return $delete ? true : false;
    }

    public function CheckData($param=array()){
        $flag=true;
        $drContact = str_replace("+91|", "", $_POST['drivercontact']);
        $drContactLen = strlen($drContact);
        $altCon = str_replace("+91|", "", $_POST['alt_contact']);
        if(empty($_POST['vehicleLoc'])){
            $arr = array("status"=>false,"data"=>"vehicleLoc","message"=>"Please Enter Vehicle Location");
            $flag=false;
        }else if(empty($_POST['vehicleregno'])){
            $arr = array("status"=>false,"data"=>"vehicleregno","message"=>"Please Enter Vehicle Registration Number");
            $flag=false;
        }else if(empty($_POST['vehicleregdate'])){
            $arr = array("status"=>false,"data"=>"vehicleregdate","message"=>"Please Enter Vehicle Registration date");
            $flag=false;
        }else if(empty($_POST['kmrun'])){
            $arr = array("status"=>false,"data"=>"kmrun","message"=>"Please Enter Vehicle Kilometer Runs");
            $flag=false;
        }else if(empty($_POST['trailertype'])){
            $arr = array("status"=>false,"data"=>"trailertype","message"=>"Please Choose Trailer Type");
            $flag=false;
        }else if(empty($drContact)){
            $arr = array("status"=>false,"data"=>"drivercontact","message"=>"Please Enter Driver Contact Number");
            $flag=false;
        }else if($drContactLen!=10){
            $arr = array("status"=>false,"data"=>"drivercontact","message"=>"Please Enter 10 Digit Driver Contact Number");
            $flag=false;
        }else if(!isset($_POST['customer1'])){
            $arr = array("status"=>false,"data"=>"customer1","message"=>"Please Select Customer or Add New Customer");
            $flag=false;
        }else if($_POST['customer1']=="existcust"){
            if(empty($_POST['customer'])){
                $arr = array("status"=>false,"data"=>"customer","message"=>"Please Choose Customer");
                $flag=false;                      
            }else{
                 $arr = array("status"=>true,"data"=>"","message"=>"");
                $flag=true;
            }
        }else if($_POST['customer1']=="newcust"){
            $Contact = str_replace("+91|", "", $_POST['contact']);
            $ContactLen = strlen($Contact);
            $ckCon1 = $this->user->checkMobile($Contact);
            $email = ($_POST["email"]);
            $ckEmail = $this->user->checkEmail($email);
            $Contact2 = str_replace("+91|", "", $_POST['alt_contact']);
            if(!empty($Contact2)){
                $ContactLen2 = strlen($Contact2);
                $ckCon = $this->user->checkMobile($Contact2);    
            }else{
                $ckCon=0;
            }
            
            if(empty($_POST['cname'])){
                $arr = array("status"=>false,"data"=>"cname","message"=>"Please Enter Customer Name");
                $flag=false;
            }else if(empty($_POST['gender'])){
                $arr = array("status"=>false,"data"=>"gender","message"=>"Please Select Customer Gender");
                $flag=false;
            }else if(empty($Contact)){
                $arr = array("status"=>false,"data"=>"contact","message"=>"Please Enter Customer Contact Number");
                $flag=false;
            }else if($ContactLen!=10){
                $arr = array("status"=>false,"data"=>"contact","message"=>"Please Enter 10 digit Customer Contact Number");
                $flag=false;
            }else if($ckCon1>0){
                $arr = array("status"=>false,"data"=>"contact","message"=>"Contact Number Exist");
                $flag=false;    
            }else if(!empty($altCon) && $ContactLen2!=10){
                $arr = array("status"=>false,"data"=>"alt_contact","message"=>"Please Enter 10 digit Customer Alternate Contact Number");
                $flag=false;
            }else if($Contact==$Contact2){
                $arr = array("status"=>false,"data"=>"alt_contact","message"=>"Both Customer Contact Numbers are Same");
                $flag=false;
            }else if($ckCon>0){
                $arr = array("status"=>false,"data"=>"alt_contact","message"=>"Alternate Contact Number Exist");
                $flag=false;
            }else if(empty($_POST['email'])){
                $arr = array("status"=>false,"data"=>"email","message"=>"Please Enter Customer Email");
                $flag=false;  
            }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $arr = array("status"=>false,"data"=>"email","message"=>"Please Enter valid Email Address");
                    $flag=false;
            }else if($ckEmail>0){
                    $arr = array("status"=>false,"data"=>"email","message"=>"Email Address is Exist!");
                    $flag=false;
            }else if(empty($_POST['address'])){
                $arr = array("status"=>false,"data"=>"address","message"=>"Please Enter Customer Address");
                $flag=false;
            }else if(empty($_POST['state'])){
                $arr = array("status"=>false,"data"=>"state","message"=>"Please Select Cutomer's State");
                $flag=false;
            }else if(empty($_POST['city'])){
                $arr = array("status"=>false,"data"=>"city","message"=>"Please Select Cutomer's City");
                $flag=false;
            }else if(empty($_POST['zipcode'])){
                $arr = array("status"=>false,"data"=>"zipcode","message"=>"Please Enter Zipcode");
                $flag=false;
            }else if(empty($_POST['country'])){
                $arr = array("status"=>false,"data"=>"country","message"=>"Please Enter Country");
                $flag=false;
            }else{
                $arr = array("status"=>true,"data"=>"","message"=>"inner");                
                $flag=true;
            }
            // if($flag==true){
                return json_encode($arr);
            // }else{
                // return json_encode($arr);    
            // }
            
        }else{
            // echo "1";
            // if($flag==true){
               $arr = array("status"=>true,"data"=>"","message"=>"outer");
                
            // }else{
            //     $arr = array("status"=>false,"data"=>"","message"=>"");
                
            // }    
            // return json_encode($arr);            
        }

        return json_encode($arr);
   }
   
    public function Service_Status($status){
        $this->db->select("ss_id");
        $this->db->from($this->serviceStatus);
        $this->db->where('ss_id',$status);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }  



    public function ServiceRef(){
        $this->db->select_max('inc_id');
        $this->db->from($this->serviceReq);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function GetDefectData($id){
        $this->db->select('*');
        $this->db->from('defect_details');
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function GetTrailerData($id){
        $this->db->select('*');
        $this->db->from('trailer_type');
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function GetServicestatusData($id=""){
        $this->db->select('*');
        $this->db->from('service_status');
        if($id!=""){
            $this->db->where("ss_id",$id);
            $query = $this->db->get();
            $result = $query->row();
        }else{
            $query = $this->db->get();
            $result = $query->result_array();
        }
        
        return $result;
    }

    public function GetStateData($id){
        $this->db->select('*');
        $this->db->from('states');
        $this->db->where("st_id",$id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function GetCityData($id){
        $this->db->select('*');
        $this->db->from('cities');
        $this->db->where("ct_id",$id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function AssginToTech($serid,$tech){
        // print_r($tech);
        // $tech = json_encode($tech);
        $arr = array("ser_id");
        // $data = $this->Service_request->getRows($arr);
        // if(empty($data))

        $Qry = "UPDATE service_request SET technician='".$tech."',s_status='2' WHERE ser_id='".$serid."'"; 
        $exe = $this->db->query($Qry);
        // $res = $exe->result_array(); 
        // return $res;
    }

      public function getCityState($city){
        $state = $this->user->citiesData($city);
        $cityList = $this->user->cities($state[0]['st_id']);
        return $cityList;
   }

   public function UpdateRegion($param=array()){
        $update = "UPDATE service_request SET transf_region='".$param['city']."',transf_note='".$param['note']."',transf_date='".date("Y-m-d h:i:s")."',transf_by='".$_SESSION['loginId']."' WHERE ser_id='".$param['id']."'";
        $query = $this->db->query($update);
        return $update ? true : false;
   }

   public function GetAllService($type,$loginid,$isAdmin=""){
        $this->db->select("ser_id");
        $this->db->from($this->serviceReq);
        if($isAdmin=="1"){

        }else{
            $where = "(region='".$loginid."' OR transf_region='".$loginid."')";
            $this->db->where($where);
        }
        if($type=="all"){

        }else{
            $this->db->where("s_status",$type);    
        }
        
        $query = $this->db->get();
        // echo $loginid;
        // die();
        // print_r($this->db->last_query());    
        // die();
        $result = $query->num_rows();
        return $result;    
   }



}