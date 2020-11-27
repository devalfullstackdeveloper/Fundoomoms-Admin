<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_dashboard extends CI_Controller {

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

        $this->load->model('user');
        $this->load->helper('get_data_helper');  
        $this->load->model('bookcall');  
        $this->load->model('tb_class'); 
        $this->load->model('curriculum');
        $this->load->helper(array('url','html','form','html'));
    }   

    public function index() {
        $data = array();
        $data['page_name'] = 'Dashboard';
        $data['cdnstylescript'] = array('https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css');
        $data['cdnscript'] = array('https://cdn.jsdelivr.net/momentjs/latest/moment.min.js','https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js');
        $data['scriptname'] = 'dashboard.js';
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Welcome to FundooMoms.</li>
                                        </ol>';
        
        
        $activeMenu = $this->user->getActiveMenu('Dashboard', 'main_menu');
        
        if(isset($_SESSION['LoginUserData']['role'])){
            $rolePermission = $this->user->getRolePermission($_SESSION['LoginUserData']['role']);
        }else{
            $rolePermission = "";
        }
       
        
        $data['active_menu'] = $activeMenu;
        if(isset($_SESSION['LoginUserData']['role'])){
            $data['role_id'] = $_SESSION['LoginUserData']['role'];
        }
        $data['permission'] = $rolePermission;

        // die(print_r($_SESSION));
        
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('dashboard', $data);
        }
        
    }

    public function UserLogin(){
        $data = array();
        $data['page_name'] = 'Dashboard';
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Welcome to FundooMoms.</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('userLogin');
        } else {
            $this->load->view('dashboard', $data);
        }
    }

    public function LoginUser(){
         $this->form_validation->set_rules('username', 'User Name', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Username and Password Field is Required');
            header("Location:" . base_url());
        } else {
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Password must be at least 6 Characters');
                header("Location:" . base_url());
            } else {
                $email = $_POST['username'];
                $password = $_POST['password'];
                if (!empty($email) && !empty($password)) {

                    $user = $this->user->checkLogin($email, md5($password), 1, false);
                    if (count($user) > 0) {
                        $params = array(
                            "username" => $email,
                            "loginId" => $user['id'],
                            "LoginUserData" => $user
                        );
                        $this->session->set_userdata($params);
                        print_r($_POST);
                        if(isset($_POST['remember'])){
                            setcookie('YORKUSEREMAIL', $email, time() + (86400 * 30), "/"); // 86400 = 1 day
                            setcookie('YORKUSERPASS', $password, time() + (86400 * 30), "/"); // 86400 = 1 day
                        }else{
                            setcookie("YORKUSEREMAIL", "",time() - 3600 , "/");
                            setcookie("YORKUSERPASS", "",time() - 3600 , "/");
                        }
                        // echo $_COOKIE['YORKUSERPASS'];
                        header("Location:" . base_url());
                    } else {
                        $this->session->set_flashdata('error', 'Please Enter Valid Username or Password');
                        header("Location:" . base_url());
                    }
                }
            }
        }
    }

    public function login() {
        /*         * * Form Validation */
        $this->form_validation->set_rules('username', 'User Name', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Username and Password Field is Required');
            header("Location:" . base_url());
        } else {
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', 'Password must be at least 6 Characters');
                header("Location:" . base_url());
            } else {
                $email = $_POST['username'];
                $password = $_POST['password'];
                if (!empty($email) && !empty($password)) {

                    $user = $this->user->checkLogin($email, md5($password), 1);
                    if (count($user) > 0) {
                        $params = array(
                            "username" => $email,
                            "loginId" => $user['id'],
                            "LoginUserData" => $user
                        );
                        $this->session->set_userdata($params);
                        print_r($_POST);
                        if(isset($_POST['remember'])){
                            setcookie('YORKUSEREMAIL', $email, time() + (86400 * 30), "/"); // 86400 = 1 day
                            setcookie('YORKUSERPASS', $password, time() + (86400 * 30), "/"); // 86400 = 1 day
                        }else{
                            setcookie("YORKUSEREMAIL", "",time() - 3600 , "/");
                            setcookie("YORKUSERPASS", "",time() - 3600 , "/");
                        }
                        // echo $_COOKIE['YORKUSERPASS'];
                        header("Location:" . base_url());
                    } else {
                        $this->session->set_flashdata('error', 'Please Enter Valid Username or Password');
                        header("Location:" . base_url());
                    }
                }
            }
        }
    }

    public function createUser() {
        $data = array();
        $data['page_name'] = 'Add New Mom';
        $data['classList'] = $this->tb_class->getAllRecords();
        $data['scriptname'] = "createuser.js";
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_dashboard/viewUser">Mom\'s List</a></li>
                                            <li class="breadcrumb-item active">Create Mom\'s</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('User_Management/craeteUser', $data);
        }
    }

    public function cityFromState() {
        $state = $_POST['state'];
        if(isset($_POST['city'])){
            $result = $this->user->cities($state,$_POST['city']);
        }else{
            $result = $this->user->cities($state);
        }
        
        echo json_encode($result, TRUE);
    }

    public function viewUser() {
        $data = array();
        $data['page_name'] = "Mom's List";
        $data['userList'] = $this->user->getRows(array('role'=>5));
        $data['classList'] = $this->tb_class->getAllRecords();
        $data['cdnstylescript'] = array('https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css');
        $data['cdnscript'] = array('https://cdn.jsdelivr.net/momentjs/latest/moment.min.js','https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js');
        $data['scriptname'] = 'viewuser.js';
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Mom\'s List</li>
                                            <li class="breadcrumb-item active">Mom\'s</li>
                                        </ol>';
        $activeMenu = $this->user->getActiveMenu('Mom\'s', 'main_menu');
        $rolePermission = $this->user->getRolePermission($_SESSION['LoginUserData']['role']);
        $data['active_menu'] = $activeMenu;
        $data['role_id'] = $_SESSION['LoginUserData']['role'];
        $data['permission'] = $rolePermission;
        $data['totActiveMoms'] = $this->user->totActiveMoms();
        $data['totEarlyChild1'] = $this->user->totEarlyChild1();
        $data['totEarlyChild2'] = $this->user->totEarlyChild2();

        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('User_Management/viewUser', $data);
        }
    }


    public function loaduserList(){
        $data = array();
        $updateView = $this->user->updateUserIsView();
        $data['userList'] = $this->user->SearchUser($_POST['start'],$_POST['end'],$_POST['class'],$_POST['access'],$_POST['status']);
        // $status = 'inactive';
        $inactive = getInactiveUser();
        // print_r($inactive);
        // $data['userList'] = $this->user->SearchUser($_POST['month'],$_POST['class'],$_POST['access'],$status);
        $data['classList'] = $this->tb_class->getAllRecords();
        $data['start'] = $_POST['start'];
        $data['end'] = $_POST['end'];
        $data['fmonth'] = $_POST['month'];
        $data['cClass'] = $_POST['class'];
        $data['access'] = $_POST['access'];
        $data['status'] = $_POST['status'];
        if(count($data['userList'])>0){
            foreach ($data['userList'] as $key => $value) {
                if($_POST['status']=="all"){
                }else if($_POST['status']=='active'){
                    if(in_array($value['id'], $inactive)){
                        unset($data['userList'][$key]);
                    }
                    // $data['userList'][$key]['actStatus'] = 'active';
                }else if($_POST['status']=='inactive'){
                    if(in_array($value['id'], $inactive)){
                    }else{
                        unset($data['userList'][$key]);
                    }
                    // $data['userList'][$key]['actStatus'] = 'in-active';
                }
                
            }
        }
        // foreach ($data['userList'] as $key => $value) {
        //     echo $value['id']."<br>";
        // }
        // die();
        $this->load->view("User_Management/userlistLoad",$data);
    }

    public function addUser() {

         $for = array(); $cnt=0; 

        foreach ($_POST as $key => $value) {
            if(empty($value) || ctype_space($value)){
                if($key=="isSend"){   
                }else{
                    $nm = '';
                    if($key == "parentsname"){
                        $nm = 'Parents Name';
                    }elseif ($key == "email") {
                        $nm = 'Email';
                    }elseif ($key == "child_name") {
                        $nm = 'Child Name';
                    }elseif ($key == "child_age") {
                        $nm = 'Child Age';
                    }elseif ($key == "mobile") {
                        $nm = 'Mobile Number';
                    }elseif ($key == "password") {
                        $nm = 'Password';
                    }
                    $arr = array("for"=>$key,"message"=>"Please Enter ".$nm);
                    array_push($for,$arr);
                    $cnt++;
                }
            }
            if($key=="mobile"){
                $mobile = str_replace("+91|", "", $value);
                // $mobile = $value;
                if(!empty($mobile)){

                    $checkMobile = $this->user->checkMobile($mobile);
                    if(strlen($mobile)!=10){
                        $arr = array("for"=>$key,"message"=>"Please Enter Valid Contact Number");
                        array_push($for,$arr);
                        $cnt++;
                    }else if($checkMobile>0){
                        $arr = array("for"=>$key,"message"=>"Contact Number Exist");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }else if(empty($mobile)){
                    $arr = array("for"=>$key,"message"=>"Please Enter Contact Number");
                    array_push($for,$arr);
                    $cnt++;
                }
            }
            if($key=="password"){
                if(!empty($value)){
                    if(strlen($value)<6){
                        $arr = array("for"=>$key,"message"=>"Password Must be Atleaset 6 characters");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }
            }

            if($key=="email"){
                if(!empty($value)){
                    $checkEmail = $this->user->checkEmail($value);
                    if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                        $arr = array("for"=>$key,"message"=>"Please Enter Valid Email Address");
                        array_push($for,$arr);
                        $cnt++;
                    }else if($checkEmail>0){
                        $arr = array("for"=>$key,"message"=>"Email Address Exist");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }
            }

        }
        $fileName = "";
        if(!empty($_FILES['userImg']['name'])){
            $config['upload_path']          = './uploads/user_img/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['file_name']            = 'UserImg'."".date("Ymdhis")."".rand(10,100)."";
            $config['max_size']             =  '1024';
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload('userImg'))
            {
                
                $uploadedImage = $this->upload->data();
                $ext = pathinfo($uploadedImage['file_name']);
                $fileName =str_replace("./", "", $config['upload_path']."".$config['file_name'].".".$ext['extension']);
            }else{
                
                $imgerr = "";
                $errors = $this->upload->display_errors();
                
                if($errors=='The filetype you are attempting to upload is not allowed.'){
                    $arr = array("for"=>"userImg","message"=>"Please Upload Valid Image File");
                    array_push($for,$arr);
                    $cnt++;
                }else if($errors='The file you are attempting to upload is larger than the permitted size.'){
                    $arr = array("for"=>"userImg","message"=>"Image Should Not be greter than 1MB");
                    array_push($for,$arr);
                    $cnt++; 
                }
               // $arr = array("for"=>"userImg","message"=>$this->upload->display_errors());
            }
        }

        if($cnt==0){
            $length = 64;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            /* Token End */
            /* Generate OTP */
            $digits = 4;
            $i = 0; //counter
            $pin = ""; //our default pin is blank.
            while ($i < $digits) {
                $pin .= mt_rand(0, 9);
                $i++;
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
            $created_by = $_SESSION['loginId'];
            $userData = array(
                'name' => ucfirst($_POST['parentsname']),
                'child_name' => ucfirst($_POST['child_name']),
                'child_age' => $_POST['child_age'],
                'mobile' => str_replace("+91|", "", $_POST['mobile']),
                'email' => $_POST['email'],
                'password' => md5($_POST['password']),
                'token' => $randomString,
                'role' => '5',
                'ref_id' => $ref_id,
                'inc_id' => $inCr,
                'created_by' => $created_by,
                'status' => '1',
                'package' => '2',
                'class' => $_POST['class'],
                'user_img' => $fileName,
                'access' => '1',
                'pwd'=>$_POST['password'],
                'is_view' => '0'
            );

             
                   

            $insert = $this->user->insert($userData);            
            if($insert>0){
                $addPay = array("user_id"=>$insert,"transaction_id"=>"00123","payment_amount"=>"300","created_date"=>date("Y-m-d h:i:s"),"pay_status"=>"0");
                $addPay = $this->user->addPayment($addPay);
                if($_POST['isSend']=="1"){
                    // $html = "<!DOCTYPE html>
                    // <html>
                    // <head>
                    //     <title></title>
                    // </head>
                    // <body>
                    //     <p>Dear user</p>
                    //     <p>Your New FundooMoms Account has been created.</p>
                    //     <p>Please use below credential for login</p>
                    //     <p>username : ".$_POST['email']." <br> password : ".$_POST['password']."</p>
                    // </body>
                    // </html>";
                    $html = $this->getRegisterEmailTemplate($_POST['email'], $_POST['password'], $_POST['parentsname']);
                    $sendData = array("to"=>$_POST['email'],"subject"=>"FundooMoms Registration Success","html"=>$html);

                    $sendMail = $this->sendHashMail($sendData);
                    $arr1 = array("status"=>true,"data"=>"","message"=>"Successfully Send");
                }else{
                    $arr1 = array("status"=>true,"data"=>"","message"=>"Successfully saved");
                }
            }else{
                $arr1 = array("status"=>false,"data"=>"isSend","message"=>"Failed To Save! Please Try Again");
            }
        }else{
            $arr1 = array("status"=>false,"data"=>$for[0]['for'],"message"=>$for[0]['message']);
        }

        echo json_encode($arr1);

        die();

        $name = strip_tags($_POST['userName']);
        $child_name = $_POST['child_name'];
        $child_age = $_POST['child_age'];
        $mobile = strip_tags($_POST['mobile']);
        $email = strip_tags($_POST['email']);
        $password = $_POST['password'];
        
        /*
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $zipcode = $_POST['zipcode'];
        $lat = ($_POST['latitude'] != NULL && $_POST['latitude'] != "") ? $_POST['latitude'] : "";
        $long = ($_POST['langitude'] != NULL && $_POST['langitude'] != "") ? $_POST['langitude'] : "";
        $altmobile = $_POST['alt_mobile'];
       */
       
        $created_by = $_SESSION['loginId'];
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

        $chkEmai = $this->user->checkEmail($email);
        $chkMobile = $this->user->checkMobile($mobile);

        if ($chkEmai > 0) {
            $this->session->set_flashdata('error', 'Email is Already Exist.');
            header("Location:" . base_url() . "Ct_dashboard/createUser");
        } elseif ($chkMobile > 0) {
            $this->session->set_flashdata('error', 'Mobile is Already Exist.');
            header("Location:" . base_url() . "Ct_dashboard/createUser");
        } else {
            /* For Token */
            $length = 64;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            /* Token End */
            /* Generate OTP */
            $digits = 4;
            $i = 0; //counter
            $pin = ""; //our default pin is blank.
            while ($i < $digits) {
                $pin .= mt_rand(0, 9);
                $i++;
            }
            /* Insert user data */
            $userData = array(
                'name' => $name,
                'child_name' => $child_name,
            	'child_age' => $child_age,
                'mobile' => $mobile,
                'email' => $email,
                'password' => md5($password),
                'token' => $randomString,
                /*
                'gender' => $gender,
                'address' => $address,
                'state' => $state,
                'city' => $city,
                'zipcode' => $zipcode,
                'otp' => $pin,
                'latitude' => $lat,
                'longitude' => $long,
                'alt_mobile' => $altmobile,
                */
                'role' => '5',
                'ref_id' => $ref_id,
                'inc_id' => $inCr,
                'created_by' => $created_by,
                'status' => '1'
            );
            $insert = $this->user->insert($userData);
            if ($insert) {
                $this->session->set_flashdata('success', 'Mom\'s Created Successfully.');
                header("Location:" . base_url() . "Ct_dashboard/viewUser");
            } else {
                $this->session->set_flashdata('error', 'Something Wrong. Please Try Again.');
                header("Location:" . base_url() . "Ct_dashboard/createUser");
            }
        }
    }
    
    public function blockUser() {
        $id = $_POST['userid'];
		$update = $this->user->update(array('status'=>'0','token'=>''), $id);
        if($update>0){
            $arr = array("status"=>true,"data"=>"","message"=>"Moms blocked Successfully");
        }else{
            $arr = array("status"=>true,"data"=>"","message"=>"Something went wrong! Please try again.");
        }

        echo json_encode($arr);
	}
	
	public function unblockUser($id = "") {
		$id = $_POST['userid'];
        $update = $this->user->update(array('status'=>'1'), $id);
        if($update>0){
            $arr = array("status"=>true,"data"=>"","message"=>"Moms Unblocked Successfully");
        }else{
            $arr = array("status"=>true,"data"=>"","message"=>"Something went wrong! Please try again.");
        }

        echo json_encode($arr);
	}

    public function editUser($id = "") {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userData = array();
            $userData['name'] = $_POST['userName'];
            $userData['child_name'] = $_POST['child_name'];
            $userData['child_age'] = $_POST['child_age'];
            $userData['email'] = $_POST['email'];
            $userData['mobile'] = $_POST['mobile'];
           	$userData['created_by'] = $_SESSION['loginId'];
            if (!empty($_POST['password'])) {
                $userData['password'] = md5($_POST['password']);
            }

            // Check if the given email and mobile already exists
            $chkEmai = $this->user->checkEmail($_POST['email'], $_POST['id']);
            $chkMobile = $this->user->checkMobile($_POST['mobile'], $_POST['id']);
            if ($chkEmai > 0) {
                $this->session->set_flashdata('error', 'Email is Already Exist.');
                header("Location:" . base_url() . "Ct_dashboard/editUser/" . $_POST['id']);
            } elseif ($chkMobile > 0) {
                $this->session->set_flashdata('error', 'Mobile is Already Exist.');
                header("Location:" . base_url() . "Ct_dashboard/editUser/" . $_POST['id']);
            } else {
                $update = $this->user->update($userData, $_POST['id']);
                $this->session->set_flashdata('success', 'Record Updated Successfully');
                header("Location:" . base_url() . "Ct_dashboard/viewUser");
            }
        } else {
            $param = array("id" => $id);
            $data = array();
            $userData = $this->user->getRows($param);
            $data['page_name'] = 'Edit Moms';
            $data['userData'] = $userData;
            $data['classList'] = $this->tb_class->getAllRecords();
            $data['scriptname'] = "createuser.js";
            /*
            $data['state'] = $this->user->states();
            $data['cities'] = $this->user->cities($userData['state']);
            */
            $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_dashboard/viewUser">Mom\'s List</a></li>
                                            <li class="breadcrumb-item active">Edit Mom\'s</li>
                                        </ol>';
            if (!isset($_SESSION['username'])) {
                $this->load->view('login');
            } else {
                $this->load->view('User_Management/editUser', $data);
            }
        }
    }

    public function UpdateUser(){
        $for = array(); $cnt=0; 

        foreach ($_POST as $key => $value) {
            if(empty($value)){
                if($key=="isSend" || $key=="password"){   
                }else{
                    $arr = array("for"=>$key,"message"=>"Please Enter ".$key);
                    array_push($for,$arr);
                    $cnt++;
                }
            }
            if($key=="mobile"){
                $mobile = str_replace("+91|", "", $value);
                if(!empty($mobile)){

                    $checkMobile = $this->user->checkMobile($mobile,$_POST['id']);
                    if(strlen($mobile)!=10){
                        $arr = array("for"=>$key,"message"=>"Please Enter Valid Contact Number");
                        array_push($for,$arr);
                        $cnt++;
                    }else if($checkMobile>0){
                        $arr = array("for"=>$key,"message"=>"Contact Number Exist");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }else if(empty($mobile)){
                    $arr = array("for"=>$key,"message"=>"Please Enter Contact Number");
                    array_push($for,$arr);
                    $cnt++;
                }
            }
            if($key=="password"){
                if(!empty($value)){
                    if(strlen($value)<6){
                        $arr = array("for"=>$key,"message"=>"Password Must be Atleaset 6 characters");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }
            }

            if($key=="email"){
                if(!empty($value)){
                    $checkEmail = $this->user->checkEmail($value,$_POST['id']);
                    if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                        $arr = array("for"=>$key,"message"=>"Please Enter Valid Email Address");
                        array_push($for,$arr);
                        $cnt++;
                    }else if($checkEmail>0){
                        $arr = array("for"=>$key,"message"=>"Email Address Exist");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }
            }

        }
        $fileName = "";
        if(!empty($_FILES['userImg']['name'])){
            $config['upload_path']          = './uploads/user_img/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['file_name']            = 'UserImg'."".date("Ymdhis")."".rand(10,100)."";
            $config['max_size']             =  '1024';
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload('userImg'))
            {
                
                $uploadedImage = $this->upload->data();
                $ext = pathinfo($uploadedImage['file_name']);
                $fileName =str_replace("./", "", $config['upload_path']."".$config['file_name'].".".$ext['extension']);
            }else{
                
                $imgerr = "";
                $errors = $this->upload->display_errors();
                
                if($errors=='The filetype you are attempting to upload is not allowed.'){
                    $arr = array("for"=>"userImg","message"=>"Please Upload Valid Image File");
                    array_push($for,$arr);
                    $cnt++;
                }else if($errors='The file you are attempting to upload is larger than the permitted size.'){
                    $arr = array("for"=>"userImg","message"=>"Image Should Not be greter than 1MB");
                    array_push($for,$arr);
                    $cnt++; 
                }
               // $arr = array("for"=>"userImg","message"=>$this->upload->display_errors());
            }
        }
        

        if($cnt==0){
            $length = 64;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            /* Token End */
            /* Generate OTP */
            $digits = 4;
            $i = 0; //counter
            $pin = ""; //our default pin is blank.
            while ($i < $digits) {
                $pin .= mt_rand(0, 9);
                $i++;
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
            $created_by = $_SESSION['loginId'];
            $userData = array(
                'name' => ucfirst($_POST['parentsname']),
                'child_name' => ucfirst($_POST['child_name']),
                //'child_age' => $_POST['child_age'],
                'mobile' => str_replace("+91|", "", $_POST['mobile']),
                'email' => $_POST['email'],
                // 'password' => md5($_POST['password']),
                //'token' => $randomString,
                'role' => '5',
                //'ref_id' => $ref_id,
                //'inc_id' => $inCr,
                //'created_by' => $created_by,
                //'status' => '1',
                //'package' => '2',
                'class' => $_POST['class'],
            );

            if(!empty($fileName)){
                $userData['user_img'] = $fileName;
            }

             
                   

            $insert = $this->user->update($userData,$_POST['id']);            
            if($insert>0){
                //$addPay = array("user_id"=>$insert,"transaction_id"=>"00123","payment_amount"=>"300","created_date"=>date("Y-m-d h:i:s"));
                //$addPay = $this->user->addPayment($addPay);
                if($_POST['isSend']=="1"){
                    $html = "<!DOCTYPE html>
                    <html>
                    <head>
                        <title></title>
                    </head>
                    <body>
                        <p>Dear user</p>
                        <p>Your New FundooMoms Account has been created.</p>
                        <p>Please use below credential for login</p>
                        <p>username : ".$_POST['email']." <br> password : ".$_POST['password']."</p>
                    </body>
                    </html>";
                    $sendData = array("to"=>$_POST['email'],"subject"=>"FundooMoms Registration Success","html"=>$html);
                   
                    $sendMail = $this->sendHashMail($sendData);
                    
                    $arr1 = array("status"=>true,"data"=>"","message"=>"Successfully Send");
                }else{
                    $arr1 = array("status"=>true,"data"=>"","message"=>"Successfully Updated");
                }
            }else{
                $arr1 = array("status"=>false,"data"=>"isSend","message"=>"Failed To Save! Please Try Again");
            }
        }else{
            $arr1 = array("status"=>false,"data"=>$for[0]['for'],"message"=>$for[0]['message']);
        }

        echo json_encode($arr1); 
    }

    public function deleteUser() {
        $id = $_POST['id'];
        $return = $this->user->delete($id);
        echo $return;
    }

    public function logout() {
        $redirect = base_url();
        $this->session->unset_userdata("username");
        $this->session->sess_destroy();
        header("Location:" . $redirect);
    }

    public function UpdateRefIdofUser(){
        $this->user->SetUserRef();
    }

    public function CustomerDetail($id){
        $param = array("id" => $id);
            $data = array();
            $userData = $this->user->getRows($param);
            
            $data['page_name'] = $userData['name'];
            $data['userData'] = $userData;
            $data['scriptname'] = 'userdetails.js';
            $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                             <li class="breadcrumb-item"><a href="'.base_url().'Ct_dashboard/viewUser">Mom\'s List</a></li>
                                            <li class="breadcrumb-item active">View user</li>
                                        </ol>';
            if (!isset($_SESSION['username'])) {
                $this->load->view('login');
            } else {
                $this->load->view('User_Management/viewuserdetail', $data);
            }
    }

    public function CustomerServiceSearch(){
        
        $this->load->view("User_Management/userservice");
    }

	public function ForgotPassword($token = ""){
        if($token != ""){
            $data = array();
            $userData = $this->user->userInfoFromToken($token);
            if(!isset($userData) || $userData == ""){
                $this->session->set_flashdata('error', 'invalid URL, Try again Later.');
                $this->load->view('changePassword'); 
            }else{
                $data['userData'] = $userData;
                $this->load->view('changePassword', $data);            
            }
        }else{
            $this->load->view('forgotpassword');            
        }
    }
    
    public function resetPassword(){
        $password = $_POST['password'];
        $confPassword = $_POST['confirmPassword'];
        $userid = $_POST['userId'];
        
        $length = 64;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
        if($password != $confPassword){
            $this->session->set_flashdata('error', 'Password and Confirm Password Does not Match.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $userData = array();
            $userData['password'] = md5($password);
            $userData['token'] = $randomString;
            $update = $this->user->update($userData, $userid);
            $this->session->set_flashdata('success', 'Password Reset Successfully.');
            header("Location:" . base_url());
        }
    }

    public function VerifyForgotEmail(){
        $email = $_POST['email'];
        $CheckEmailExist = $this->user->GetUserInfoByParams(array("email"=>$email,'is_admin'=>'1'));
        if(count($CheckEmailExist)>0){
            $userID = $CheckEmailExist[0]['id'];
            $token = md5($userID)."_".bin2hex(random_bytes(25));
            $created_at = date("Y-m-d h:i:s");
            $expiry = date("Y-m-d h:i:s",strtotime("+1 day", strtotime($created_at)));

            $tokenArr = array("user_id"=>$userID,"token"=>$token,"created_at"=>$created_at,"expiry"=>$expiry,"token_status"=>"active");
            $insert = $this->user->SetForgorPassToken($tokenArr);
            
            /*For Forgot Password URL */
            $userToken = $CheckEmailExist[0]['token'];
            $url = base_url().'Ct_dashboard/ForgotPassword/'.$userToken;

            if($insert){
                $subject = 'FundooMoms Password Reset';
                $html = '<p>Hi '.$CheckEmailExist[0]['name']."</p>";
                $html .="<p>Please Visit Link Below To Reset Your Password</p>";
                $html .="<p><a href='".$url."'>Click Here</a></p>";

                $send = $this->sendHashMail(array("to"=>$CheckEmailExist[0]['email'],"subject"=>$subject,"html"=>$html));
                // die($send);
                // if($send){
                    
                    $this->session->set_flashdata('success', 'Please Check Your Email! Password Reset Link Send To your Email');
                    header("Location:" . base_url()."Ct_dashboard/ForgotPassword"); 
                // }else{
                //     $this->user->RemoveForgotPassToken($insert);
                //     $this->session->set_flashdata('error', 'Something Went wrong in Sending Mail! Please Try Again');
                //     header("Location:" . base_url()."Ct_dashboard/ForgotPassword");
                // }
            }else{
                $this->session->set_flashdata('error', 'Something Went wrong! Please Try Again');
                header("Location:" . base_url()."Ct_dashboard/ForgotPassword");
            }
        }else{
            $this->session->set_flashdata('error', 'Email Id Not Exist');
            header("Location:" . base_url()."Ct_dashboard/ForgotPassword");
        }
    }

    public function loadMomRequest(){
        $data['requestList'] = $this->bookcall->getrequestUser($_POST['momsid']);
        $this->load->view('User_Management/user_request',$data);
    }

    public function LoadRequestDetail(){
        $data['requestData'] = $this->bookcall->getRows($_POST['bookid'],array());
        $this->load->view("User_Management/user_request_detail",$data);
    }

     public function LoadDashMoms(){
        // $data['month'] = $this->input->post('month');
        $data['grandmoms'] = $this->user->countDashBoradMoms($_POST['start'],$_POST['end'],'grand');
        $data['active'] = $this->user->countDashBoradMoms($_POST['start'],$_POST['end'],'active');
        // print_r($data);
        $this->load->view("Loadfiles/dashboardmoms",$data);
    }

    public function LoadDashCharte1(){
        // $data['month'] = $this->input->post('month');
        $data['freedemo'] = $this->user->dashBoradMomsChart($_POST['start'],$_POST['end'],'freedemo');
        $data['fullcourse'] = $this->user->dashBoradMomsChart($_POST['start'],$_POST['end'],'fullcourse');
        $this->load->view("Loadfiles/dashchart1",$data);   
    }

    public function LoadDashClassChart(){
        // $data['month'] = $this->input->post('month');
        $class = $this->tb_class->getAllRecords();
        $data = array();
        $classData = array();
        foreach ($class as $key => $value) {
            $classData[$value['class_id']] = $this->user->DashClassChart($_POST['start'],$_POST['end'],$value['class_id']);
        }
        $data['data'] = $classData; 
        // die(print_r($data));
        $this->load->view("Loadfiles/classchart1",$data);   
    }

    public function getUserNotification(){
        
      $data = array();
            
            $data['page_name'] = "User Notification";

            // $data['userData'] = $userData;
            // $data['scriptname'] = 'userdetails.js';
            $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_dashboard/viewUser">Mom\'s List</a></li>
                                            <li class="breadcrumb-item active">View user</li>
                                        </ol>';
            

        

        // die(print_r($users));

        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('pendingusers', $data);
        } 
        
    }

    public function loadUserNotification(){
        $class = $_POST['class'];
        $access = $_POST['access'];
        $ntype = $_POST['ntype'];
        // die($class);
        // $payment = getMultiWhere("payment_details",array('payment_id','user_id','created_date','pay_status','current_day'),array(),'','user_id','desc',"1");
        $payment = $this->user->getuserPayment($class,$access);
        $today = date("Y-m-d");
        $users = array();
         foreach ($payment as $key => $value) {

             // if(count($user)>0){


                 // die($user[0]['class']);
                 $classDay = getData('tb_class',array('c_days'),'class_id',$value['class']);
                 $created_date = $value['created_date'];
                 $end_date = date("Y-m-d",strtotime("+".$classDay[0]['c_days']." days",strtotime($created_date)));
                 if($today<=$end_date){
                     // $Interval = $this->getDateInterVal($created_date,$end_date,"3");
                     // if(count($Interval)>0){
                        $fifteen = date("Y-m-d",strtotime("+15 days",strtotime($created_date)));
                        $curDay = (!empty($value['current_day'])) ? date("Y-m-d",strtotime("+".$value['current_day']." days",strtotime($value['created_date']))) : '';
                        // echo $curDay."<br>";
                        $fifteen2 = (!empty($curDay)) ? date("Y-m-d",strtotime("+15 days",strtotime($curDay))) : '';
                        // echo $fifteen2."<br>";
                        if($today>$fifteen){
                            if(empty($value['current_day'])){
                                if($ntype=='all'){
                                    $users[$key]['noused'] = $value['user_id'];
                                }else if($ntype=='0'){
                                    $users[$key]['noused'] = $value['user_id'];
                                }else if($ntype=='1'){
                                    $users[$key]['noused'] = '';
                                }
                            }else if((int)$value['current_day']<15){
                                if($ntype=="all"){
                                    $users[$key]['noahed'] = $value['user_id'];
                                }else if($ntype=="0"){
                                    $users[$key]['noahed'] = '';
                                }else if($ntype=="1"){
                                    $users[$key]['noahed'] = $value['user_id'];    
                                }
                            }
                        }else if(!empty($fifteen2)){
                            if($today>$fifteen2){
                                if($ntype=="all"){
                                    $users[$key]['noahed'] = $value['user_id'];
                                }else if($ntype=="0"){
                                    $users[$key]['noahed'] = '';
                                }else if($ntype=="1"){
                                    $users[$key]['noahed'] = $value['user_id'];
                                }
                                
                            }
                        }

                     // }
                 }
             // }

             }
         $data['classList'] = getMultiWhere('tb_class',array(),array());
         // echo $ntype."<br>";

         // foreach ($users as $key => $value) {

         //     if($ntype=="all"){
         //     }else if($ntype=="0"){
         //        unset($users[$key]['noahed']); 
         //        unset($users[$key]);
         //     }else if($ntype=="1"){
         //        unset($users[$key]['noused']);
         //        unset($users[$key]);
         //    }

         // }

         // print_r($users);
        $data['users'] = $users; 
         $this->load->view('Loadfiles/usernotification', $data);
        } 
        
     public function getDateInterVal($start_date,$end_date,$interval){
        $today = date("Y-m-d");
        $begin = new DateTime($start_date);
        $end = new DateTime($end_date);

        $interval = DateInterval::createFromDateString($interval.' day');
        $period = new DatePeriod($begin, $interval, $end);

        $dateArr = array();
        foreach ($period as $dt) {
            if($today==$dt->format("Y-m-d")){
                array_push($dateArr, $dt->format("Y-m-d"));
            }
        }
        return $dateArr;
    }

    public function ExportMomsList($month,$class,$access){
        // require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

        $month = $month;
        $year = date("Y");
        $class = $class;
        $access = $access;
        $listInfo = $this->user->SearchUser($month,$class,$access);
        // die(print_r($listInfo));
        $fileName = 'MomsList-'."".$month."".time().'.csv';
        $this->load->library('excel');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Parents Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Child Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Class');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Validity');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Mobile Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Curriculum Completed Days');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Access');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Created date');

        $rowCount = 2;
        foreach ($listInfo as $list) {
            $class = getData('tb_class',array('title'),'class_id',$list['class']);
            $payment = getData('payment_details',array('user_id,pay_status'),'user_id',$list['id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list['ref_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['child_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, (count($class)>0) ? $class[0]['title'] : 'N/A');
            if(count($payment)>0){
                $validity = getValidity($list['id']);
                if(isset($validity) && $validity != ""){
                    
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $validity['validity']);
                }else{
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'N/A');
                }                                            
            }else{
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'N/A');
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['mobile']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['email']);
            if(count($payment)>0){
                $validity = getValidity($list['id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $validity['completed']);
            }else{
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'N/A');
            }
            if(count($payment)> 0){
                if($payment[0]['pay_status'] > 0){
                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Full Course');
                }else{
                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Free Demo');
                }
            }else{
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'N/A');
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $list['added_on']);
            $rowCount++;
        }

        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output');

        // redirect(base_url().'Ct_dashboard/viewUser');

    }

    public function ExportMomsDetails($id){
        $userData = getData('user_register',array(),'id',$id);
        $fileName = 'USER-'.''.$userData[0]['ref_id'].'.csv';
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Parents Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Child Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Child age');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Email Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Class');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Mobile Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Access');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Validity');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Completed Days');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Created Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Payment Date');

        $rowCount = 2;
        foreach ($userData as $list) {
            $class = getData('tb_class',array('title'),'class_id',$list['class']);
            $payment = getData('payment_details',array('user_id,pay_status,created_date'),'user_id',$list['id']);

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list['ref_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['child_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['child_age']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, (count($class)>0) ? $class[0]['title'] : 'N/A');
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['mobile']);
            if(count($payment)> 0){
                if($payment[0]['pay_status'] > 0){
                    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Full Course');
                }else{
                    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Free Demo');
                }
            }else{
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'N/A');
            }

             if(count($payment)>0){
                $validity = getValidity($list['id']);
                if(isset($validity) && $validity != ""){
                    
                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $validity['validity']);
                }else{
                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'N/A');
                }                                            
            }else{
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'N/A');
            }

            if(count($payment)>0){
                $validity = getValidity($list['id']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $validity['completed']);
            }else{
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'N/A');
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $list['added_on']);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $payment[0]['created_date']);
            $rowCount++;
        }

        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output');

    }

    public function AdminProfile($id){
        $loginId = $_SESSION['loginId'];
        $data = array();
        $data['page_name'] = 'Admin Profile';
        $data['userData'] = getData('user_register',array(),'id',$loginId);
        $data['scriptname'] = "adminprofile.js";
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item active">admin profile</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('User_Management/admin_profile', $data);
        }
    }

    public function SaveAdminProfile(){
        $for = array(); $cnt=0;
        if(empty($_POST['username'])){
            $arr = array("for"=>"username","message"=>"Please Enter Username");
            array_push($for,$arr);
            $cnt++;
        }

        if(!empty($_POST['password'])){
            if($_POST['password']!=$_POST['cpassword']){
                $arr = array("for"=>"cpassword","message"=>"Password not matched with confirm password");
                array_push($for,$arr);
                $cnt++;       
            }
        }

        $fileName = "";
        if(!empty($_FILES['userImg']['name'])){
            $config['upload_path']          = './uploads/user_img/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['file_name']            = 'UserImg'."".date("Ymdhis")."".rand(10,100)."";
            $config['max_size']             =  '1024';
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload('userImg'))
            {
                
                $uploadedImage = $this->upload->data();
                $ext = pathinfo($uploadedImage['file_name']);
                $fileName =str_replace("./", "", $config['upload_path']."".$config['file_name'].".".$ext['extension']);
            }else{
                
                $imgerr = "";
                $errors = $this->upload->display_errors();
                
                if($errors=='The filetype you are attempting to upload is not allowed.'){
                    $arr = array("for"=>"userImg","message"=>"Please Upload Valid Image File");
                    array_push($for,$arr);
                    $cnt++;
                }else if($errors='The file you are attempting to upload is larger than the permitted size.'){
                    $arr = array("for"=>"userImg","message"=>"Image Should Not be greter than 1MB");
                    array_push($for,$arr);
                    $cnt++; 
                }
               // $arr = array("for"=>"userImg","message"=>$this->upload->display_errors());
            }
        }

        if($cnt==0){
            $userData['email'] = $_POST['username'];
            if($fileName!=""){
                $userData['user_img'] = $fileName;
            }
            if(!empty($_POST['password'])){
                $userData['password'] = md5($_POST['password']);
                $userData['pwd'] = $_POST['password'];
            }
            // print_r($userData);
            $insert = $this->user->update($userData,$_POST['userId']);
            if($insert>0){
                //$redirect = base_url();
                $this->session->unset_userdata("username");
                $this->session->sess_destroy();
                $arr1 = array("status"=>true,"data"=>"","message"=>"Profile Updated Successfully");
            }else{
                $arr1 = array("status"=>true,"data"=>"","message"=>"Failed to Update Profile");
            }
        }else{
            $arr1 = array("status"=>false,"data"=>$for[0]['for'],"message"=>$for[0]['message']);
        }
        echo json_encode($arr1);

    }


    public function load_dashboard_request(){
        if(isset($_POST['fromlist'])){
            $viewReq = $this->bookcall->viewRequest();    
        }
        

        if(!$_POST['start']){

            $data['requestList'] = $this->bookcall->getSearchRecords($_POST['start'],$_POST['end'],$_POST['fclass'],$_POST['fstatus']);
            $data['fclass'] = $_POST['fclass'];
            // $data['fmonth'] = $_POST['fmonth'];
            $data['fstatus'] = $_POST['fstatus'];
            $data['start'] = $_POST['start'];
            $data['end'] = $_POST['end'];
        }else{
            // if($_POST['fclass']=="all"){
            //     $class = "all";
            // }else{
            //     $class1 = $this->bookcall->getUserClass($_POST['fclass']);
            //     $class = $class1['id'];
            // }
            // if($_POST['fstatus']=="all"){
            //     $status="all";
            // }else{
            //     $status = $this->bookcall->getbookstatuswise($_POST['fstatus']);
            // }
            // die($class);
            $data['requestList'] = $this->bookcall->getSearchRecords($_POST['start'],$_POST['end'],$_POST['fclass'],$_POST['fstatus']);
            $data['fclass'] = $_POST['fclass'];
            // $data['fmonth'] = $_POST['fmonth'];
            $data['fstatus'] = $_POST['fstatus'];
            $data['start'] = $_POST['start'];
            $data['end'] = $_POST['end'];
        }
        
        $data['classList'] = $this->tb_class->getAllRecords();

        
        $this->load->view('requestbookdashboard',$data);
    }


   
    
    public function sendHashMail($arr = []) {
        $to = $arr['to'];
        $sub = $arr['subject'];
                
        $html = $arr['html'];
        // die(print_r($arr));
        // $html = '<p>userName : '.$arr['username'].'</p><br>';
        // $html .= '<p>Password : '.$arr['password'].'</p>';
                
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'mail.aarnaapps.com',
            'smtp_port' => 587,
            'smtp_user'  => 'test1@aarnaapps.com', 
            'smtp_pass'  => 'rJrp~RH2(mEF', 
            'mailtype'  => 'html',
            'charset'    => 'iso-8859-1',
            'wordwrap'   => TRUE
        );        
        // $config = array(
        //     'protocol'  => 'smtp',
        //     'smtp_host' => 'ssl://smtp.gmail.com',
        //     'smtp_port' => 465,
        //     'smtp_user'  => 'desaikinjal2304@gmail.com', 
        //     'smtp_pass'  => 'ITIDOL@123', 
        //     'mailtype'  => 'html',
        //     'charset'    => 'iso-8859-1',
        //     'wordwrap'   => TRUE
        // );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('info@fundoomoms.com');
        $this->email->to($to);
        $this->email->subject($sub);
        $this->email->message($html);
        $this->email->send();
        if($this->email->send())
        {
            // echo "sended";
            return 1;

        }else{
            // echo "not sended";
            return 0;
        } 
            
        ##########################################################
    }

    public function getRegisterEmailTemplate($email, $password, $parentsname){
    	$html = '<table class="nl-container" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #FFFFFF;width: 100%" cellpadding="0" cellspacing="0">
    <tbody>
        <tr style="vertical-align: top">
            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">

                <div style="background-color:#DEDEDE;">
                    <div style="margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;" class="block-grid ">
                        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#fff;">
                            <div class="col num12" style="min-width: 320px;max-width: 500px;display: table-cell;vertical-align: top;">
                                <div style="background-color: transparent; width: 100% !important;">
                                    <div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:20px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                        <div style="padding-right: 0px;  padding-left: 0px;">
                                            <div align="center" class="img-container center  autowidth  " style="padding-right: 0px;  padding-left: 0px;">

                                                <a href="https://www.fundoomoms.com/" target="_blank">
                                                    <img class="center  autowidth " align="center" border="0" src="https://www.fundoomoms.com/wp-content/uploads/2020/07/fundoomoms-logo.png" alt="" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 143px" width="143"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="background-color:#DEDEDE;">
                        <div style="margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;" class="block-grid ">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#fff;">
                                <div class="col num12" style="min-width: 320px;max-width: 500px;display: table-cell;vertical-align: top;">
                                    <div style="background-color: transparent; width: 100% !important;">
                                        <div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 20px; padding-left: 30px;">

                                            <div class="">
                                                <div style="color:#555555;font-family:Arial, \'Helvetica Neue\', Helvetica, sans-serif;line-height:180%; padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 10px;">
                                                    <hr style="padding-left: 30px ;padding-right: 30px ;">
                                                    <!------------------------------- Add Content Here  ---------------------------->
                                                    <div style="padding-top:20px;font-size:12px;line-height:22px;color:#555555;font-family:Arial, \'Helvetica Neue\', Helvetica, sans-serif;text-align:left;">
                                                        <p style="margin: 0;font-size: 12px;line-height: 22px">
                                                            <span style="font-size: 14px; line-height: 25px;">Dear '.$parentsname.',</span></p>
                                                        <p style="margin: 0;font-size: 12px;line-height: 22px">
                                                            <span style="font-size: 14px; line-height: 25px;">
                                                            	<p>Your New FundooMoms Account has been created. Please use below credential for login</p>
    															<p>Username : '.$email.' <br> Password : '.$password.'</p>
                                                            </span>
                                                        </p>
                                                        <p style="padding-top:10px;margin: 0;font-size: 12px;line-height: 22px">
                                                            <span style="font-size: 14px; line-height: 25px;"><strong>Regards,</strong></span>
                                                            <br><span style="font-size: 14px; line-height: 25px;">Fundoomoms.</span>
                                                        </p>
                                                    </div>
                                                    <!------------------------------- Add Content Here  ----------------------------> 
                                                </div>
                                            </div>

                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="background-color:#DEDEDE;">
                        <div style="margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #2C1633;" class="block-grid ">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#2C1633;">
                                <div style="min-width: 320px;max-width: 500px;display: table-cell;vertical-align: top;">
                                    <div style="background-color: transparent; width: 100% !important;">
                                        <div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">

                                            <div class="">
                                                <div style="color:#ffffff;line-height:200%;font-family:Arial, \'Helvetica Neue\', Helvetica, sans-serif; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
                                                    <div style="font-size:12px;line-height:24px;text-align:center;color:#ffffff;font-family:Arial, \'Helvetica Neue\', Helvetica, sans-serif;">
                                                        <p style="margin: 0;font-size: 14px;line-height: 24px;text-align: center;">
                                                            <a style="font-size: 14px;text-decoration: underline;color:#fff;text-align: center;" href="https://www.fundoomoms.com/" target="_blank">FundooMoms</a>
                                                        </p>
                                                    </div>
                                                    <div style="line-height: 24px;font-size: 14px;color:#fff ;font-family:Arial, \'Helvetica Neue\', Helvetica, sans-serif;text-align: center;"><p style="margin: 0;font-size: 14px;line-height: 24px;text-align: center;"></p>
                                                    </div>
                                                    <div style="font-size:12px;line-height:24px;text-align:center;color:#ffffff;font-family:Arial, \'Helvetica Neue\', Helvetica, sans-serif;text-align: center;"></div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </td>
        </tr>
    </tbody>
</table>';
return $html;
    }


    public function testMail() {
        $to = "amitkayasth6@gmail.com";
        $sub = "Test Mail";
                
        // $html = $arr['html'];
        // die(print_r($arr));
        $html = '<p>userName : </p><br>';
        // $html .= '<p>Password : '.$arr['password'].'</p>';
                
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'mail.aarnaapps.com',
            'smtp_port' => 587,
            'smtp_user'  => 'test1@aarnaapps.com', 
            'smtp_pass'  => 'rJrp~RH2(mEF', 
            'mailtype'  => 'html',
            'charset'    => 'iso-8859-1',
            'wordwrap'   => TRUE
        );        
        // $config = array(
        //     'protocol'  => 'smtp',
        //     'smtp_host' => 'ssl://smtp.gmail.com',
        //     'smtp_port' => 465,
        //     'smtp_user'  => 'desaikinjal2304@gmail.com', 
        //     'smtp_pass'  => 'ITIDOL@123', 
        //     'mailtype'  => 'html',
        //     'charset'    => 'iso-8859-1',
        //     'wordwrap'   => TRUE
        // );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('info@fundoomoms.com');
        $this->email->to($to);
        $this->email->subject($sub);
        $this->email->message($html);
        echo "<pre>";
        print_r($this->email->send());
        echo "</pre>";
        exit();
        $this->email->send();

        if($this->email->send())
        {
            // echo "sended";
            return 1;

        }else{
            // echo "not sended";
            return 0;
        } 
            
        ##########################################################
    }
}

