<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_service_request extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->helper('service_request');

        $this->load->model('user');
        $this->load->model('Service_request');
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
        } else {
            $data = array();
            $data['page_name'] = 'Service Request';
            $data['scriptname'] = "servicereqlist.js";
            $data['serviceReqlist'] = $this->Service_request->serviceReqlist();
            $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Welcome to York Transport Equipment (Asia) Pte Ltd.</li>
                                        </ol>';
            if (!isset($_SESSION['username'])) {
                $this->load->view('login');
            } else {
                $this->load->view('Service_request/view', $data);
            }
        }
    }

    public function SearchAjax(){
        $result = $this->Service_request->SearchReq($_POST);
        $data['serviceReqlist'] = $result;
        if(isset($_POST['status'])){
            $data['statusType'] = $_POST['status'];    
            $data['techdata'] = $_POST['tech'];
        }else if(isset($_POST['state'])){
            $data['s_state'] = $_POST['state'];
            $data['s_city'] = $_POST['city'];
        }
        $data['technician'] = RoleWiseUserData('4');
        $data['stateList'] = GetAllCities();
        $this->load->view("Service_request/loadservice",$data);
    }

    
    public function create(){
        $data = array();
        $data['page_name'] = 'Service Request ';
        $data['scriptname'] = "servicereq.js";
        $data['customerlist'] = $this->Service_request->CustomerList();
        $data['stateList'] = $this->user->states();
        $data['defectData'] = $this->Service_request->DefectList();
        $data['trailerData'] = $this->Service_request->trailerList();
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Service Request </li>
                                            <li class="breadcrumb-item active">Create Service Request</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Service_request/create', $data);
        }
    }

    public function AssignService($id){
        $data = array();
        $data['page_name'] = 'Service Request ';
        $data['scriptname'] = "assignreq.js";
        // $data['customerlist'] = $this->Service_request->CustomerList();
        $data['ServiceData'] = $this->Service_request->getRowData($id);
        $cityList = $this->Service_request->getCityState($data['ServiceData']->region);
        $data['CityList'] = $cityList;
        $data['stateList'] = $this->user->states();
        $data['serviceStatus'] = $this->Service_request->GetServicestatusData();
        $data['techlist'] = $this->user->getRows(array("role"=>"4"));
        $data['defectData'] = $this->Service_request->DefectList();
        $data['trailerData'] = $this->Service_request->trailerList();
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Service Request </li>
                                            <li class="breadcrumb-item active">Create Service Request</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Service_request/assign', $data);
        }
    }

    public function AssignToTech(){
        $assign = $this->Service_request->AssginToTech($_POST['sid'],$_POST['tech']);
    }

    public function ChangeRegion(){
        $flag=false; $cnt=0; $farr = array();
        if(empty($_POST['changecity'])){
            $arr1 = array("for"=>"changecity","message"=>"Please Select Region");
            array_push($farr, $arr1);
            $cnt++;
        }
        if(empty($_POST['note'])){
            $arr1 = array("for"=>"note","message"=>"Please Enter Note.");
            array_push($farr, $arr1);
            $cnt++;
        }
        if($cnt==0){
            $flag=true;
        }else{
            $flag=false;
        }
        if($flag==true){
            $param = array("id"=>$_POST['serid'],"city"=>$_POST['changecity'],"note"=>$_POST['note']);
            $updateReg = $this->Service_request->UpdateRegion($param);
            if($updateReg){
                $arr = array("status"=>true,"data"=>"","message"=>"Region Changed SuccessFully");
            }else{
                $arr = array("status"=>false,"data"=>"","message"=>"Something Went Wrong! Please Try Again");
            }    
        }else{
            $arr = array("status"=>false,"data"=>"","message"=>$farr[0]['message']);
        }
        
        echo json_encode($arr);
    }


   

   public function inserServiceRequest(){
        $ckData = json_decode($this->Service_request->CheckData($_POST));
        // print_r($ckData->status);
        if($ckData->status){

            $defetPhoto = "";
            $serialPhoto = "";

            $flag=true;
            $msg = "";
            $errFor= "";
            $path = 'uploads/serviceRequest/';

            $allowed_types = array('jpg', 'png', 'jpeg', 'gif');

            if ($_FILES["serialPhoto"]["name"] != '') {
                $test = explode('.', $_FILES["serialPhoto"]["name"]);
                $ext = end($test);
                if($ext=="jpg" || $ext =="jpeg" ||$ext=="png"){
                    $name = "AxleSNP"."_".date("YMD")."".rand(100, 999) . '.' . $ext;
                    
                    $urlArr = explode("/", $_SERVER['REQUEST_URI']);
                    $url = "/vehicleserviceapp/";
                    $location = $_SERVER['DOCUMENT_ROOT']. $url . $path . $name;
                    if(move_uploaded_file($_FILES["serialPhoto"]["tmp_name"], $location)){
                        // echo "uploaded";
                        $serialPhoto.=$path . $name;
                        $flag=true;
                    }else{
                        // echo "Not Upload";
                        $msg .= "Axle Serial Number Plate Photo Not Uploaded Properly! Please Try Again";
                        $serialPhoto.="";
                        $errFor.="serialPhoto";
                        $flag=false;
                    }
                }else{
                    $msg .="Please Upload only Image File For Axle Serial Number Plate Photo";
                    $flag=false;
                    $errFor.="serialPhoto";
                }
            }

            $msg1 = "";
            if(!empty($_FILES['defectphoto']['name'])) { 
                $upload_dir = 'uploads/serviceRequest/';
                foreach ($_FILES['defectphoto']['tmp_name'] as $key => $value) {
                    $file_tmpname = $_FILES['defectphoto']['tmp_name'][$key]; 
                    $file_name = "DefectPhoto".date("YMD")."".$_FILES['defectphoto']['name'][$key]; 
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                    $filepath = $upload_dir.$file_name; 

                    if(in_array(strtolower($file_ext), $allowed_types)) { 
                        if( move_uploaded_file($file_tmpname, $filepath)) { 
                            $defetPhoto.=$path . $file_name.",";
                            $flag=true; 
                        }  
                        else {                      
                            $msg1 = "Defect Photo Not Uploaded Properly! Please Try Again";
                            $serialPhoto.="";
                            $errFor.="serialPhoto";
                            $flag=false;  
                        } 
                    }else{
                        $msg1 ="Please Upload only Image File For Defect Photo, Uploaded File May Contain Ivalid Image File.";
                        $flag=false;
                        $errFor.="serialPhoto";
                    }
                }
                $msg.=$msg1;
            }

            if($flag==true){

            $incr1 = $this->Service_request->ServiceRef()->inc_id;
            $sStatus = $this->Service_request->Service_Status('1')->ss_id;

            if($incr1>0){
                $ref_id1 = "SCRQ".sprintf('%03d',($incr1 + 1));
                $inCr1 = ($incr1 + 1);
            }else{
                $ref_id1 = "SCRQ001";
                $inCr1 = 1;
            }

            if($_POST['customer1']=="newcust"){
                $length = 64;
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                if(empty($_POST['email'])){
                    $email = NULL;
                }else{
                    $email = $_POST['email'];
                }

                if(empty($_POST['alt_contact'])){
                    $alt_mobile = NULL;
                }else{
                    $alt_mobile = str_replace("+91|", "", $_POST['alt_contact']);
                }

                $incr = $this->user->UserRef('5')->inc_id;
                $prefix = $this->user->rolePrefix('5')->prefix;
                // $incr['inc_id'] = 9;
                if($incr>0){
                    
                    $ref_id = $prefix.sprintf('%03d',($incr + 1));
                    $inCr = ($incr + 1);
                }else{
                    $ref_id = $prefix."001";
                    $inCr = 1;
                }



                $drivercontact = str_replace("+91|", "", $_POST['drivercontact']);
                $vehregNo = trim(str_replace("|", "", $_POST['vehicleregno']));
                $contact1 = str_replace("+91|", "", $_POST['contact']);
                $s_state = $this->Service_request->GetCityData($_POST['region']);

                $newuser = array("name"=>$_POST['cname'],"mobile"=>$contact1,"email"=>$email,"token"=>$randomString,"gender"=>$_POST['gender'],"address"=>$_POST['address'],"city"=>$_POST['city'],"state"=>$_POST['state'],"zipcode"=>$_POST['zipcode'],
                            "country"=>$_POST['country'],"alt_mobile"=>$alt_mobile,"added_on"=>date("Y-m-d h:i:s"),"ref_id"=>$ref_id,"inc_id"=>$inCr,"role"=>'5',"status"=>"1","created_by"=>$_SESSION['loginId']);
                $insertUser = $this->user->insert($newuser);
                if($insertUser){
                    $serArr = array("vehicle_location"=>$_POST['vehicleLoc'],"veh_regno"=>$vehregNo,"veh_regdate"=>$_POST['vehicleregdate'],"trailer_type"=>$_POST['trailertype'],"defect_detail"=>$_POST['defect'],"defect_photo"=>'',"a_sno_plate"=>'',"driver_contact"=>$drivercontact,"customer"=>$insertUser,"created_date"=>date("Y-m-d h:i:s"),"km_run"=>$_POST['kmrun'],"created_by"=>$_SESSION['loginId'],"a_sno_plate"=>$serialPhoto,"defect_photo"=>$defetPhoto,"ref_id"=>$ref_id1,"inc_id"=>$inCr1,"s_status"=>$sStatus,"region"=>$_POST['region'],"new_cust"=>"1","s_state"=>$s_state->st_id);
                    $inserSer = $this->Service_request->insert($serArr);
                    if($inserSer){
                        $arr = array("status"=>true,"data"=>"","message"=>"Service Request Created SucessFully");            
                    }else{
                        $delUser = $this->user->delete($insertUser);
                        $arr = array("status"=>true,"data"=>"","message"=>"Something Went Wrong!Please Try Again");            
                    }
                }else{
                    $arr = array("status"=>true,"data"=>"","message"=>"Something Went Wrong!Please Try Again");
                }
            }else{
                $vehregNo = trim(str_replace("|", "", $_POST['vehicleregno']));
                $drivercontact = str_replace("+91|", "", $_POST['drivercontact']);
                $s_state = $this->Service_request->GetCityData($_POST['region']);
               $serArr = array("vehicle_location"=>$_POST['vehicleLoc'],"veh_regno"=>$vehregNo,"veh_regdate"=>$_POST['vehicleregdate'],"trailer_type"=>$_POST['trailertype'],"defect_detail"=>$_POST['defect'],"defect_photo"=>'',"a_sno_plate"=>'',"driver_contact"=>$drivercontact,"customer"=>$_POST['customer'],"created_date"=>date("Y-m-d h:i:s"),"km_run"=>$_POST['kmrun'],"created_by"=>$_SESSION['loginId'],"a_sno_plate"=>$serialPhoto,"defect_photo"=>$defetPhoto,"ref_id"=>$ref_id1,"inc_id"=>$inCr1,"s_status"=>$sStatus,"region"=>$_POST['region'],"s_state"=>$s_state->st_id);
                    $inserSer = $this->Service_request->insert($serArr);
                    if($inserSer){
                        $arr = array("status"=>true,"data"=>"","message"=>"Service Request Created SucessFully");            
                    }else{
                        $delUser = $this->user->delete($insertUser);
                        $arr = array("status"=>true,"data"=>"","message"=>"Something Went Wrong!Please Try Again");            
                    } 
            }

        }else{
            $arr = array("status"=>false,"data"=>$errFor,"message"=>$msg);    
        }
            
        }else{
            $arr = array("status"=>false,"data"=>$ckData->data,"message"=>$ckData->message);
        }
        echo json_encode($arr);
   }

   public function edit($id=""){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ckData = json_decode($this->Service_request->CheckData($_POST));
        // print_r($ckData->status);
        if($ckData->status){

            $rowData = $this->Service_request->getRowData($_POST['id']);

            $defetPhoto = "";
            $serialPhoto = "";

            $flag=true;
            $msg = "";
            $errFor= "";
            $path = 'uploads/serviceRequest/';

            $allowed_types = array('jpg', 'png', 'jpeg', 'gif');

            if ($_FILES["serialPhoto"]["name"] != '') {
                $test = explode('.', $_FILES["serialPhoto"]["name"]);
                $ext = end($test);
                if($ext=="jpg" || $ext =="jpeg" ||$ext=="png"){
                    $name = "AxleSNP"."_".date("YMD")."".rand(100, 999) . '.' . $ext;
                    
                    $urlArr = explode("/", $_SERVER['REQUEST_URI']);
                    $url = "/vehicleserviceapp/";
                    $location = $_SERVER['DOCUMENT_ROOT']. $url . $path . $name;
                    if(move_uploaded_file($_FILES["serialPhoto"]["tmp_name"], $location)){
                        // echo "uploaded";
                        $serialPhoto.=$path . $name;
                        $flag=true;
                    }else{
                        // echo "Not Upload";
                        $msg .= "Axle Serial Number Plate Photo Not Uploaded Properly! Please Try Again";
                        $serialPhoto.="";
                        $errFor.="serialPhoto";
                        $flag=false;
                    }
                }else{
                    $msg .="Please Upload only Image File For Axle Serial Number Plate Photo";
                    $flag=false;
                    $errFor.="serialPhoto";
                }
            }else{
                $serialPhoto.=$rowData->a_sno_plate;
            }

            $msg1 = "";

           // print_r($_FILES['defectphoto']);
           // die();

            if($_FILES['defectphoto']['name'][0]!="") { 
                    
                $upload_dir = 'uploads/serviceRequest/';
                foreach ($_FILES['defectphoto']['tmp_name'] as $key => $value) {
                    $file_tmpname = $_FILES['defectphoto']['tmp_name'][$key]; 
                    $file_name = "DefectPhoto".date("YMD")."".$_FILES['defectphoto']['name'][$key]; 
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

                    $filepath = $upload_dir.$file_name; 

                    if(in_array(strtolower($file_ext), $allowed_types)) { 
                        if( move_uploaded_file($file_tmpname, $filepath)) { 
                            $defetPhoto.=$path . $file_name.",";
                            $flag=true; 
                        }  
                        else {                      
                            $msg1 = "Defect Photo Not Uploaded Properly! Please Try Again";
                            $defetPhoto.="";
                            $errFor.="defectphoto";
                            $flag=false;  
                        } 
                    }else{
                        $msg1 ="Please Upload only Image File For Defect Photo, Uploaded File May Contain Ivalid Image File.";
                        $flag=false;
                        $errFor.="defectphoto";
                    }
                }
                $msg.=$msg1;
            }else{
                $flag = true;
                $defetPhoto.=$rowData->defect_photo;
            }

            if($flag==true){

            $incr1 = $this->Service_request->ServiceRef()->inc_id;
            $sStatus = $this->Service_request->Service_Status('1')->ss_id;

            // if($incr1>0){
            //     $ref_id1 = "SCRQ".sprintf('%03d',($incr1 + 1));
            //     $inCr1 = ($incr1 + 1);
            // }else{
            //     $ref_id1 = "SCRQ001";
            //     $inCr1 = 1;
            // }

            if($_POST['customer1']=="newcust"){
                $length = 64;
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                if(empty($_POST['email'])){
                    $email = NULL;
                }else{
                    $email = $_POST['email'];
                }

                if(empty($_POST['alt_contact'])){
                    $alt_mobile = NULL;
                }else{
                    $alt_mobile = str_replace("+91|", "", $_POST['alt_contact']);
                }

                $incr = $this->user->UserRef('5')->inc_id;
                $prefix = $this->user->rolePrefix('5')->prefix;
                // $incr['inc_id'] = 9;
                if($incr>0){
                    
                    $ref_id = $prefix.sprintf('%03d',($incr + 1));
                    $inCr = ($incr + 1);
                }else{
                    $ref_id = $prefix."001";
                    $inCr = 1;
                }



                $drivercontact = str_replace("+91|", "", $_POST['drivercontact']);
                $vehregNo = trim(str_replace("|", "", $_POST['vehicleregno']));
                $contact1 = str_replace("+91|", "", $_POST['contact']);
                $s_state = $this->Service_request->GetCityData($_POST['region']);
                $newuser = array("name"=>$_POST['cname'],"mobile"=>$contact1,"email"=>$email,"token"=>$randomString,"gender"=>$_POST['gender'],"address"=>$_POST['address'],"city"=>$_POST['city'],"state"=>$_POST['state'],"zipcode"=>$_POST['zipcode'],
                            "country"=>$_POST['country'],"alt_mobile"=>$alt_mobile,"added_on"=>date("Y-m-d h:i:s"),"ref_id"=>$ref_id,"inc_id"=>$inCr,"role"=>'5',"status"=>"1","created_by"=>$_SESSION['loginId']);
                $insertUser = $this->user->insert($newuser);
                if($insertUser){
                    $serArr = array("vehicle_location"=>$_POST['vehicleLoc'],"veh_regno"=>$vehregNo,"veh_regdate"=>$_POST['vehicleregdate'],"trailer_type"=>$_POST['trailertype'],"defect_detail"=>$_POST['defect'],"defect_photo"=>'',"a_sno_plate"=>'',"driver_contact"=>$drivercontact,"customer"=>$insertUser,"created_date"=>date("Y-m-d h:i:s"),"km_run"=>$_POST['kmrun'],"created_by"=>$_SESSION['loginId'],"a_sno_plate"=>$serialPhoto,"defect_photo"=>$defetPhoto,"region"=>$_POST['region'],"new_cust"=>"1","s_state"=>$s_state->st_id);
                    $inserSer = $this->Service_request->update($serArr,$_POST['id']);
                    if($inserSer){
                        $arr = array("status"=>true,"data"=>"","message"=>"Service Request Updated SucessFully");            
                    }else{
                        $delUser = $this->user->delete($insertUser);
                        $arr = array("status"=>true,"data"=>"","message"=>"Something Went Wrong!Please Try Again");            
                    }
                }else{
                    $arr = array("status"=>true,"data"=>"","message"=>"Something Went Wrong!Please Try Again");
                }
            }else{
                $vehregNo = trim(str_replace("|", "", $_POST['vehicleregno']));
                $drivercontact = str_replace("+91|", "", $_POST['drivercontact']);
                $s_state = $this->Service_request->GetCityData($_POST['region']);
               $serArr = array("vehicle_location"=>$_POST['vehicleLoc'],"veh_regno"=>$vehregNo,"veh_regdate"=>$_POST['vehicleregdate'],"trailer_type"=>$_POST['trailertype'],"defect_detail"=>$_POST['defect'],"defect_photo"=>'',"a_sno_plate"=>'',"driver_contact"=>$drivercontact,"customer"=>$_POST['customer'],"created_date"=>date("Y-m-d h:i:s"),"km_run"=>$_POST['kmrun'],"created_by"=>$_SESSION['loginId'],"a_sno_plate"=>$serialPhoto,"defect_photo"=>$defetPhoto,"region"=>$_POST['region'],"s_state"=>$s_state->st_id);
                    $inserSer = $this->Service_request->update($serArr,$_POST['id']);
                    if($inserSer){
                        $arr = array("status"=>true,"data"=>"","message"=>"Service Request Updated SucessFully");            
                    }else{
                        $delUser = $this->user->delete($insertUser);
                        $arr = array("status"=>true,"data"=>"","message"=>"Something Went Wrong!Please Try Again");            
                    } 
            }

        }else{
            $arr = array("status"=>false,"data"=>$errFor,"message"=>$msg);    
        }
            
        }else{
            $arr = array("status"=>false,"data"=>$ckData->data,"message"=>$ckData->message);
        }
        echo json_encode($arr);
        }else{
            $param = array("ser_id" => $id);
            $data = array();
            $userData = $this->Service_request->getRows($param);
            $data['page_name'] = 'Edit Service Request ';
            $data['scriptname'] = "servicereq.js";
            $data['customerlist'] = $this->Service_request->CustomerList();
            $data['stateList'] = $this->user->states();
            $data['defectData'] = $this->Service_request->DefectList();
            $data['trailerData'] = $this->Service_request->trailerList();
            $data['serviceData'] = $userData;
            $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Service Request </li>
                                            <li class="breadcrumb-item active">Edit Service Request</li>
                                        </ol>';
            if (!isset($_SESSION['username'])) {
                $this->load->view('login');
            } else {
                $this->load->view('Service_request/edit', $data);
            }
        }
   }

   public function deleteService() {
        $id = $_POST['id'];
        $return = $this->Service_request->delete($id);
        echo $return;
   }

   
}