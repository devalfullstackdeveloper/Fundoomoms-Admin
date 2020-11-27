<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_userManagement extends CI_Controller {

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
        $this->load->helper("service_request");

        $this->load->model('role');
        $this->load->model('user');
        $this->load->model('Service_request');
        $this->load->model('UserManagement');
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
        } else {
            $data = array();
            $data['page_name'] = 'Service Request';
            $data['scriptname'] = "servicereq.js";
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

    public function userView($role){
        $data = array();
        $rolename = $this->role->GetRowData($role,"role_name")->role_name;
        $data['page_name'] = $rolename;
        $data['scriptname'] = "userdetails.js";
        $data['userlist'] = $this->UserManagement->UsersList($role);
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">Welcome to York Transport Equipment (Asia) Pte Ltd.</li>
                                    </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('User_Management/roleuserList', $data);
        }
    }

    public function createRoleUser(){
        $data = array();
        $data['page_name'] = 'Create User';
        $data['scriptname'] = "userdetails.js";
        $data['roleList'] = $this->role->roleList();
        $data['state'] = $this->user->states();
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Users </li>
                                            <li class="breadcrumb-item active">Create User</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('User_Management/createRoleUser', $data);
        }
    }
    
    public function RoleUserView($id){
        $param = array("id" => $id);
        $data = array();
        $userData = $this->user->getRows($param);
        $rolename = $this->role->GetRowData($userData['role'],"role_name");
        // print_r($rolename);
        $data['page_name'] = $rolename->role_name;
        // print_r($data);
        $data['userData'] = $userData;
        $data['scriptname'] = 'viewuserdetail.js';
        $data['state'] = $this->user->states();
        $data['cities'] = $this->user->cities($userData['state']);
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                        <li class="breadcrumb-item">Customer</li>
                                        <li class="breadcrumb-item active">Customer Details</li>
                                    </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('User_Management/viewRoleuser', $data);
        }
    }

    public function addRoleUser(){
        $flag = false; $cnt=0; $fileName="";
        $for=array();
        foreach ($_POST as $key => $value) {
            if(empty($value)){
                if($key=="alt_mobile"){}else{
                $arr = array("for"=>$key,"msg"=>"Please Enter ".$key);
                array_push($for,$arr);
                $cnt++;
                }
            }
            if($key=="mobile"){
                if(!empty($value)){
                    $checkMobile = $this->user->checkMobile($value);
                    if(strlen($value)!=10){
                        $arr = array("for"=>$key,"msg"=>"Please Enter Valid Contact Number");
                        array_push($for,$arr);
                        $cnt++;
                    }else if($checkMobile>0){
                        $arr = array("for"=>$key,"msg"=>"Contact Number Exist");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }
            }
            if($key=="email"){
                if(!empty($value)){
                    $checkEmail = $this->user->checkEmail($value);
                    if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                        $arr = array("for"=>$key,"msg"=>"Please Enter Valid Email Address");
                        array_push($for,$arr);
                        $cnt++;
                    }else if($checkEmail>0){
                        $arr = array("for"=>$key,"msg"=>"Email Address Exist");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }
            }
            if($key=="alt_mobile"){
                if(!empty($value)){
                $checkMobile = $this->user->checkMobile($value);
                    if(strlen($value)!=10){
                        $arr = array("for"=>$key,"msg"=>"Please Enter Valid Alternate Contact Number");
                        array_push($for,$arr);
                        $cnt++;
                    }else if($checkMobile>0){
                        $arr = array("for"=>$key,"msg"=>"Alternate Contact Number Exist");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }
            }
            if($key=="zipcode"){
                if(strlen($value)!=6){
                    $arr = array("for"=>$key,"msg"=>"Please Enter Valid 6 digit zipcode");
                    array_push($for,$arr);
                    $cnt++;
                }
            }
        }

        if(!empty($_FILES['userImg']['name'])){
            $path = 'uploads/user_img/';
            $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
            $file_tmpname = $_FILES['userImg']['tmp_name'];
            $file_ext = pathinfo($_FILES['userImg']['name'], PATHINFO_EXTENSION); 
            $file_name = date("Ymd")."".rand(10,100)."USERPHOTO.".$file_ext; 
            $filepath = $path.$file_name;
            $file_size = filesize($file_tmpname);
            $file_size = round($file_size*1024/2);
            if(in_array(strtolower($file_ext), $allowed_types)) { 
                if( move_uploaded_file($file_tmpname, $filepath)) { 
                    $fileName.=$path . $file_name;
                }  
                else {                      
                    $arr = array("for"=>$_FILES['userImg'],"msg"=>"Profile Picure Not Uploaded Properly! Please Try Again");
                  array_push($for,$arr);
                  $cnt++;
                } 
            }else if($file_size>30){
                $arr = array("for"=>$_FILES['userImg'],"msg"=>"File Size Can not Be Greter Than 30 KB");
              array_push($for,$arr);
              $cnt++;
            }else{
              $arr = array("for"=>$_FILES['userImg'],"msg"=>"Please Upload .Jpeg or .Jpg or .Png Files For Profile Picture");
              array_push($for,$arr);
              $cnt++;  
            }
        }

        if($cnt>0){
            $flag=false;
        }else{
            $flag=true;
        }

        if($flag==true){

            $length = 64;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            $incr = $this->user->UserRef($_POST['role'])->inc_id;
            $prefix = $this->user->rolePrefix($_POST['role'])->prefix;
            // $incr['inc_id'] = 9;
            if($incr>0){
                
                $ref_id = $prefix.sprintf('%03d',($incr + 1));
                $inCr = ($incr + 1);
            }else{
                $ref_id = $prefix."001";
                $inCr = 1;
            }

            if(isset($_POST['userStatus'])){
                $ust = $_POST['userStatus'];
            }else{
                $ust="0";
            }
            /* Generate Password */
            $digits = 6;
            $i = 0; //counter
            $pin = ""; //our default pin is blank.
            while($i < $digits){
                $pin .= mt_rand(0, 9);
                $i++;
            }

            $newuser = array("name"=>$_POST['name'],"mobile"=>$_POST['mobile'],"email"=>$_POST['email'],
                            "token"=>$randomString,"address"=>$_POST['address'],"city"=>$_POST['city'],
                            "state"=>$_POST['state'],"zipcode"=>$_POST['zipcode'],"country"=>$_POST['country'],
                            "alt_mobile"=>$_POST['alt_mobile'],"added_on"=>date("Y-m-d h:i:s"),"ref_id"=>$ref_id,
                            "inc_id"=>$inCr,"role"=>$_POST['role'],"status"=>$ust,"created_by"=>$_SESSION['loginId'],
                            "latitude"=>$_POST['latitude'],"longitude"=>$_POST['langitude'],"is_admin"=>"0",
                            "user_img"=>$fileName,"password"=>md5($pin));
            $insert = $this->user->insert($newuser);
            if($insert){
                $arr = array(
                            'to' => $_POST['email'],
                            'password' => $pin
                            );
                $rt = $this->sendHashMail($arr);
                $arr1 = array("status"=>true,"data"=>"","message"=>"");
            }else{
                if(!empty($_FILES['userImg']['name'])){
                   unlink(base_url().$fileName);
                }
                $arr1 = array("status"=>false,"data"=>"","message"=>"Something Went Wrong! Please Try Again");
            }

        }else{  
            $arr1 = array("status"=>false,"data"=>$for[0]['for'],"message"=>$for[0]['msg']); 
        }
        echo json_encode($arr1);
    }


    public function EditUserRole($id){
        $data = array();
        $data['page_name'] = 'Edit User';
        $data['scriptname'] = "userdetails.js";
        $data['userData'] = $this->UserManagement->getRow($id);
        $data['roleList'] = $this->role->roleList();
        $data['state'] = $this->user->states();
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Users </li>
                                            <li class="breadcrumb-item active">Edit User</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('User_Management/editRoleUser', $data);
        }
    }


    public function UpdateUserRole(){
        $flag = false; $cnt=0; $fileName="";
        $for=array();
        foreach ($_POST as $key => $value) {
            if(empty($value)){
                if($key=="alt_mobile"){}else{
                $arr = array("for"=>$key,"msg"=>"Please Enter ".$key);
                array_push($for,$arr);
                $cnt++;
                }
            }
            if($key=="mobile"){
                if(!empty($value)){
                    $checkMobile = $this->user->checkMobile($value,$_POST['id']);
                    if(strlen($value)!=10){
                        $arr = array("for"=>$key,"msg"=>"Please Enter Valid Contact Number");
                        array_push($for,$arr);
                        $cnt++;
                    }else if($checkMobile>0){
                        $arr = array("for"=>$key,"msg"=>"Contact Number Exist");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }
            }
            if($key=="email"){
                if(!empty($value)){
                    $checkEmail = $this->user->checkEmail($value,$_POST['id']);
                    if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                        $arr = array("for"=>$key,"msg"=>"Please Enter Valid Email Address");
                        array_push($for,$arr);
                        $cnt++;
                    }else if($checkEmail>0){
                        $arr = array("for"=>$key,"msg"=>"Email Address Exist");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }
            }
            if($key=="alt_mobile"){
                if(!empty($value)){
                $checkMobile = $this->user->checkMobile($value,$_POST['id']);
                    if(strlen($value)!=10){
                        $arr = array("for"=>$key,"msg"=>"Please Enter Valid Alternate Contact Number");
                        array_push($for,$arr);
                        $cnt++;
                    }else if($checkMobile>0){
                        $arr = array("for"=>$key,"msg"=>"Alternate Contact Number Exist");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }
            }
            if($key=="zipcode"){
                if(strlen($value)!=6){
                    $arr = array("for"=>$key,"msg"=>"Please Enter Valid 6 digit zipcode");
                    array_push($for,$arr);
                    $cnt++;
                }
            }
        }

        if(!empty($_FILES['userImg']['name'])){
            $path = 'uploads/user_img/';
            $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
            $file_tmpname = $_FILES['userImg']['tmp_name'];
            $file_ext = pathinfo($_FILES['userImg']['name'], PATHINFO_EXTENSION); 
            $file_name = date("Ymd")."".rand(10,100)."USERPHOTO.".$file_ext; 
            $filepath = $path.$file_name;
            $file_size = filesize($file_tmpname);
            $file_size = round($file_size*1024/2);
            if(in_array(strtolower($file_ext), $allowed_types)) { 
                if( move_uploaded_file($file_tmpname, $filepath)) { 
                    $fileName.=$path . $file_name;
                }  
                else {                      
                    $arr = array("for"=>$_FILES['userImg'],"msg"=>"Profile Picure Not Uploaded Properly! Please Try Again");
                  array_push($for,$arr);
                  $cnt++;
                } 
            }else if($file_size>30){
                $arr = array("for"=>$_FILES['userImg'],"msg"=>"File Size Can not Be Greter Than 30 KB");
              array_push($for,$arr);
              $cnt++;
            }else{
              $arr = array("for"=>$_FILES['userImg'],"msg"=>"Please Upload .Jpeg or .Jpg or .Png Files For Profile Picture");
              array_push($for,$arr);
              $cnt++;  
            }
        }

        if($cnt>0){
            $flag=false;
        }else{
            $flag=true;
        }

        if($flag==true){

            $length = 64;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            $incr = $this->user->UserRef($_POST['role'])->inc_id;
            $prefix = $this->user->rolePrefix($_POST['role'])->prefix;
            // $incr['inc_id'] = 9;
            // if($incr>0){
                
            //     $ref_id = $prefix.sprintf('%03d',($incr + 1));
            //     $inCr = ($incr + 1);
            // }else{
            //     $ref_id = $prefix."001";
            //     $inCr = 1;
            // }

            if(isset($_POST['userStatus'])){
                $ust = $_POST['userStatus'];
            }else{
                $ust="0";
            }

            $newuser = array("name"=>$_POST['name'],"mobile"=>$_POST['mobile'],"email"=>$_POST['email'],
                            "token"=>$randomString,"address"=>$_POST['address'],"city"=>$_POST['city'],
                            "state"=>$_POST['state'],"zipcode"=>$_POST['zipcode'],"country"=>$_POST['country'],
                            "alt_mobile"=>$_POST['alt_mobile'],"role"=>$_POST['role'],"status"=>$ust,
                            "latitude"=>$_POST['latitude'],"longitude"=>$_POST['langitude'],"is_admin"=>"0",
                            "user_img"=>$fileName);
            $insert = $this->user->update($newuser,$_POST['id']);
            if($insert){
                $arr1 = array("status"=>true,"data"=>"","message"=>"");
            }else{
                if(!empty($_FILES['userImg']['name'])){
                   unlink(base_url().$fileName);
                }
                $arr1 = array("status"=>false,"data"=>"","message"=>"Something Went Wrong! Please Try Again");
            }

        }else{  
            $arr1 = array("status"=>false,"data"=>$for[0]['for'],"message"=>$for[0]['msg']); 
        }
        echo json_encode($arr1);
    }

    public function DeleteRoleUser(){
        $id = $_POST['id'];
        $delete = $this->user->delete($id);
        echo json_encode($delete);
    }
    
    public function sendHashMail($arr = []) {
		$to = $arr['to'];
		$sub = 'Thanks for registering with us';
                
//		$html = $this->htmlTemplate();
		$html = '<p>Password : '.$arr['password'].'</p>';
                    
        $config = array(
			'protocol'  => 'smtp',
			'smtp_host' => 'mail.itidoltechnologies.com',
			'smtp_port' => 587,
			'smtp_user'  => 'test@itidoltechnologies.com', 
			'smtp_pass'  => '123456', 
			'mailtype'  => 'html',
			'charset'    => 'iso-8859-1',
			'wordwrap'   => TRUE
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('info@fundoomoms.com');
		$this->email->to($to);
		$this->email->subject($sub);
		$this->email->message($html);
		$this->email->send();
		if($this->email->send())
		{
                    return 1;
                } 
                return 0;
		##########################################################
	}

}