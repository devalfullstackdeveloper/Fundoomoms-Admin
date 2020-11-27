 <?php
error_reporting(0);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Authentication extends REST_Controller {

    public function __construct() {
        parent::__construct();

        // Load the user model
        $this->load->model('user');
        $this->load->model('curriculum');
        $this->load->helper('get_data_helper');
        $this->load->model('tb_class');
        $this->load->model('lesson');
        $this->load->model('bookcall');
        $this->load->model('Help');
        $this->load->model('notifications');
        $this->load->helper(array('url','html','form','html'));
    }
    
   

    public function state_get() {
        $states = $this->user->states();
        if(count($states) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'States List',
                'data' => $states
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'No States Available.'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function city_post() {
        $state = $_POST['state_id'];
        $cities = $this->user->cities($state);
        if(count($cities) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'Cities List',
                'data' => $cities
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'No Cities Available.'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function login_post() {
        // Get the post data
        $mobile = $this->post('mobile');
        $password = $this->post('password');

        // Validate the post data
        if (!empty($mobile) && !empty($password)) {

            // Check if any user exists with the given credentials
//            $con['returnType'] = 'single';
//            $con['conditions'] = array(
//                'email' => $email,
//                'password' => md5($password),
//                'status' => 1
//            );
//            $user = $this->user->getRows($con);
            $user = $this->user->checkLogin($mobile, md5($password), 0, true);
            // die(print_r($user));
            $payment = $this->user->getPaymentDetail($user[0]['id']);
            // if(count($payment)>0){
            //     $user['payment_id'] = $payment['transaction_id'];
            // }else{
            //     $user['payment_id'] = "";
            // }
            if (count($user) > 0) {
                $payment1 = getData('payment_details',array(),'user_id',$user[0]['id']); 
                $ustatus = $user[0]['status'];

                if((count($payment1)>0) && ($ustatus=="0")){
                    $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Your account is blocked by administrator!'], REST_Controller::HTTP_BAD_REQUEST);
                }else if(count($payment1)==0){
                    $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Mobile Number is not registered.'], REST_Controller::HTTP_BAD_REQUEST);
                }else if((count($payment1)>0) && ($ustatus=="1")){
                    $imgUrl = "";
                        foreach ($user as $key => $value) {
                            $user[$key]['user_img'] = base_url()."".$value['user_img'];   
                        }

                        if(count($user)>0){

                            if(count($payment)>0){

                                $user[0]['payment_id'] = $payment['payment_id'];
                                
                                $today = date("Y-m-d");
                                // die($payment['pay_status']);
                                if($payment['pay_status']==0){
                                    $class = getData('tb_class',array('free_days'),'class_id',$user[0]['class']);
                                    $lastDate = date("Y-m-d",strtotime("+".$class[0]['free_days']." days",strtotime($payment['created_date'])));
                                    // if($payment['current_day']>2){
                                    if($payment['current_day']>$class[0]['free_days']){
                                        $user[0]['access'] = false;
                                    }else{
                                        $user[0]['access'] = ($today>$lastDate) ? false : true;
                                    }
                                    
                                    $user[0]['pay_status'] = false;
                                }else{

                                    $class = getData('tb_class',array('c_days'),'class_id',$user[0]['class']);
                                    if(count($class)>0){

                                        $lastDate1 = date("Y-m-d",strtotime("+".$class[0]['c_days']." days",strtotime($payment['created_date'])));
                                        $today1 = date("Y-m-d");
                                        // die($lastDate1);
                                        $user[0]['access'] = ($today1>$lastDate1) ? false : true;
                                    }else{
                                        $user[0]['access'] = ($today>$lastDate) ? false : true;
                                    }
                                    $user[0]['pay_status']=true;
                                }
                                
                            }else{
                                $user[0]['payment_id'] = "";
                                $user[0]['access'] = false;
                            }
                        }
                        // $getToken = getMultiWhere('user_register',array('token'),array("token"=>$this->post('token')));
                        // if(count($getToken)>0){
                        //     $this->response(['status' => FALSE,'data'=>$user,'message' => 'Your Free Demo Period is expired.'], REST_Controller::HTTP_BAD_REQUEST);
                        // }else{
                            $tokenArr = array("token"=>$this->post('token'));
                            $userTokenUpdate = $this->user->update($tokenArr,$user[0]['id']);
                            // echo $userTokenUpdate;
                            // die();
                            // $user[0]['token'] = $this->post('token');
                            if($user[0]['access']==false){
                                $this->response(['status' => FALSE,'data'=>$user,'message' => 'Your Free Demo Period is expired.'], REST_Controller::HTTP_BAD_REQUEST);
                            }else{
                                $this->response([
                                'status' => TRUE,
                                'message' => 'User login successful.',
                                'data' => $user
                                ], REST_Controller::HTTP_OK);
                            }
                        // }
                }

                
            }else{
                // Set the response and exit
                //BAD_REQUEST (400) being the HTTP response code


                $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Wrong mobile number or password.'], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Wrong mobile number or password.'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function registration_post() {

         $for = array(); $cnt=0;

        foreach ($_POST as $key => $value) {
            if(empty($value)){
                $arr1 = array("for"=>$key,"message"=>"Please Enter ".$key);
                array_push($for, $arr1);
                $cnt++;
            }

            if($key=="mobile"){
                
                if(!empty($value)){

                    $checkMobile = $this->user->checkMobile($value);
                    if(strlen($value)!=10){
                        $arr = array("for"=>$key,"message"=>"Please Enter Valid Mobile Number");
                        array_push($for,$arr);
                        $cnt++;
                    }else if($checkMobile>0){
                        $arr = array("for"=>$key,"message"=>"Mobile Number Exist");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }else if(empty($value)){
                    $arr = array("for"=>$key,"message"=>"Please Enter Mobile Number");
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
            $config['max_size']             =  '10240';
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
                    $arr = array("for"=>"userImg","message"=>"Image should not be greter than 10MB");
                    array_push($for,$arr);
                    $cnt++; 
                }
               // $arr = array("for"=>"userImg","message"=>$this->upload->display_errors());
            }
        }

        if($cnt==0){
            
            $name = strip_tags($this->post('parent_name'));
                $mobile = strip_tags($this->post('mobile'));
                $email = strip_tags($this->post('email'));
                $password = $this->post('password');
                $childName = strip_tags($this->post('child_name'));
                $childAge = strip_tags($this->post('child_age'));
                $incr = $this->user->UserRef('5')->inc_id;
                $prefix = $this->user->rolePrefix('5')->prefix;
                if($incr>0){
                    $ref_id = $prefix.sprintf('%03d',($incr + 1));
                    $inCr = ($incr + 1);
                }else{
                    $ref_id = $prefix."001";
                    $inCr = 1;
                }
                
                // Check if the given email and mobile already exists
                // $chkEmai = $this->user->checkEmail($email);
                // $chkMobile = $this->user->checkMobile($mobile);
                
        //         if($chkEmai > 0){
        //             $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Email is Already Exist.'], REST_Controller::HTTP_BAD_REQUEST);
        // //            $this->response("Email is Already Exist.", REST_Controller::HTTP_BAD_REQUEST);
        //         }elseif ($chkMobile > 0) {
        //             $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Mobile is Already Exist.'], REST_Controller::HTTP_BAD_REQUEST);
        // //            $this->response("Mobile is Already Exist.", REST_Controller::HTTP_BAD_REQUEST);
        //         }else{



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
                    while($i < $digits){
                        $pin .= mt_rand(0, 9);
                        $i++;
                    }

                    $class = getData('tb_class',array('class_id'),'child_age',$_POST['child_age']);
                    /* Insert user data */
                    $userData = array(
                            'name' => $name,
                            'child_name' => $childName,
                            'child_age' => $childAge,
                            'mobile' => $mobile,
                            'email' => $email,
                            'password' => md5($password),
                            'token' => $_POST['token'],
                            'otp' => $pin,
                            'role' => 5,
                            'ref_id' => $ref_id,
                            'inc_id' => $inCr,
                            'created_by' => "",
                            // 'status' => '1',
                            'package' => '2',
                            'class' => (count($class)>0) ? $class[0]['class_id'] : '',
                            'user_img' => $fileName,
                            'access' => '1',
                            'pwd'=>$password,
                            'is_view' => '0'
                        );
                    $insert = $this->user->insert($userData);
                    if ($insert) {

                        $apiKey = urlencode('R+SE/qLHCkw-AN9EaE7pwUmg9yX6zyq5sZwNqEdCRJ');
                        $numbers = array('91'.$mobile);
                        // $sender = urlencode('TXTLCL');
                        $sender = 'FUNDOO';
                        // $message = rawurlencode('Thank you for registering with Fundoomoms. Your verification code is  : '.$pin." ".$_POST['haskey']);
                        // $message = $pin.' is your OTP. Thank You for registering with the FundooMoms Homeschooling App.';
                        $message = $pin.' is your OTP. Thank You for registering with the FundooMoms Homeschooling App.'.$_POST['haskey'];

                        // echo $message;
                        // die();
                        $numbers = implode(',', $numbers);                         
                        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
                        $ch = curl_init('https://api.textlocal.in/send/');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        $response = json_decode($response);
                        // $arr = array(
                        //             'to' => $email,
                        //             'password' => $password
                        //             );
                        // $rt = $this->sendMail($arr);
                        /* Sent OTP Message*/
                        
                        // Set the response and exit
                        // print_r($response);
                        // die();
                        if($response->status = 'success'){
                            $this->response([
                                'status' => TRUE,
                                'message' => 'The user has been added successfully. OTP is send to your Mobile.',
                                'data' => array('user_id'=>$insert),
                                'otp' => $pin,
                            ], REST_Controller::HTTP_OK);
                        }else{
                            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Some problems occurred, please try again.'], REST_Controller::HTTP_BAD_REQUEST);
                        }
                    } else {
                        // Set the response and exit
                        $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Some problems occurred, please try again.'], REST_Controller::HTTP_BAD_REQUEST);
                    }
                // }
        }else{
            $this->response(['status' => FALSE,'data'=>NULL,'message' => $for[0]['message']], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function user_get($id = 0) {
        // Returns all the users data if the id not specified,
        // Otherwise, a single user will be returned.
        $con = $id ? array('id' => $id) : '';
        $users = $this->user->getRows($con);

        // Check if the user data exists
        if (!empty($users)) {
            // Set the response and exit
            //OK (200) being the HTTP response code
            $this->response($users, REST_Controller::HTTP_OK);
        } else {
            // Set the response and exit
            //NOT_FOUND (404) being the HTTP response code
            $this->response([
            'status' => FALSE,
            'message' => 'No user was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function user_put() {
        $id = $this->put('id');

        // Get the post data
        $first_name = strip_tags($this->put('first_name'));
        $last_name = strip_tags($this->put('last_name'));
        $email = strip_tags($this->put('email'));
        $password = $this->put('password');
        $phone = strip_tags($this->put('phone'));

        // Validate the post data
        if (!empty($id) && (!empty($first_name) || !empty($last_name) || !empty($email) || !empty($password) || !empty($phone))) {
            // Update user's account data
            $userData = array();
            if (!empty($first_name)) {
                $userData['first_name'] = $first_name;
            }
            if (!empty($last_name)) {
                $userData['last_name'] = $last_name;
            }
            if (!empty($email)) {
                $userData['email'] = $email;
            }
            if (!empty($password)) {
                $userData['password'] = md5($password);
            }
            if (!empty($phone)) {
                $userData['phone'] = $phone;
            }
            $update = $this->user->update($userData, $id);

            // Check if the user data is updated
            if ($update) {
                // Set the response and exit
                $this->response([
                'status' => TRUE,
                'message' => 'The user info has been updated successfully.'
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response("Provide at least one user info to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function authanticateUser($token){
        $sql = "SELECT * FROM users WHERE token = '".$token."'";
        $exe = $this->db->query($sql);
        $res = $exe->result_array();
        
        if(count($res) > 0){
            return $res[0];
        }else{
            return 0;
        }
    }
    
    public function generateOTP_post(){
        $returnArr = array();
        if(isset($_POST['mobile'])){
            $mobile = $_POST['mobile'];
            $sql = "SELECT * FROM user_register WHERE mobile = '".$mobile."'";
            $exe = $this->db->query($sql);
            $res = $exe->result_array();
            if(count($res)>0){
                $digits = 4;
                $i = 0; //counter
                $pin = ""; //our default pin is blank.
                while($i < $digits){
                    $pin .= mt_rand(0, 9);
                    $i++;
                }
                $sql = "UPDATE user_register SET otp = '".$pin."' WHERE mobile = '".$mobile."'";
                $exe = $this->db->query($sql);
                
                $returnArr['success'] = 'true';
                $returnArr['data'] = array(
                    'OTP'=>$pin
                );
                $this->response([
                    'status' => TRUE,
                    'data'=>$returnArr,
                    'message' => 'OTP Successfully Sent.'
                ], REST_Controller::HTTP_OK);
//                $this->response("Mobile Is Already Exist.", REST_Controller::HTTP_BAD_REQUEST);
            }else{
                $digits = 4;
                $i = 0; //counter
                $pin = ""; //our default pin is blank.
                while($i < $digits){
                    $pin .= mt_rand(0, 9);
                    $i++;
                }
                $sql = "INSERT INTO user_register (name, mobile, otp) VALUES('', '".$mobile."', '".$pin."')";
                $exe = $this->db->query($sql);
                $insert_id = $this->db->insert_id();
                
                $returnArr['success'] = 'true';
                $returnArr['data'] = array(
                    'OTP'=>$pin
                );
                $this->response([
                    'status' => TRUE,
                    'data'=>$returnArr,
                    'message' => 'OTP Successfully Sent.'
                ], REST_Controller::HTTP_OK);
            }
        }else{
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please Enter Mobile Number.'], REST_Controller::HTTP_BAD_REQUEST);
        }        
    }
    
    public function varifyOTP_post(){
        if(isset($_POST['mobile']) && isset($_POST['otp'])){
            $sql = "SELECT * FROM user_register WHERE mobile = '".$_POST['mobile']."' AND otp = '".$_POST['otp']."'";
            $exe = $this->db->query($sql);
            $res = $exe->result_array();
            if(count($res)>0){
                $sql = "UPDATE user_register SET status = 1 WHERE mobile = '".$_POST['mobile']."' AND otp = '".$_POST['otp']."'";
                $exe = $this->db->query($sql);

                $addPay = array("user_id"=>$res[0]['id'],"transaction_id"=>"","payment_amount"=>"","created_date"=>date("Y-m-d h:i:s"),"pay_status"=>"0");
                $addPay = $this->user->addPayment($addPay);
               
                    $html = "<!DOCTYPE html>
                    <html>
                    <head>
                        <title></title>
                    </head>
                    <body>
                        <p>Dear user</p>
                        <p>Your New FundooMoms Account has been created.</p>
                        <p>Please use below credential for login</p>
                        <p>username : ".$res[0]['email']." <br> password : ".$res[0]['pwd']."</p>
                    </body>
                    </html>";

                    $html = $this->getRegisterEmailTemplate($res[0]['email'], $res[0]['pwd'], $res[0]['name']);

                    $sendData = array("to"=>$res[0]['email'],"subject"=>"FundooMoms Registration Success","html"=>$html);

                    $sendMail = $this->sendMail($sendData);

                    $data = array("payment_id"=>$addPay);

                $this->response([
                    'status' => TRUE,
                    'data'=>$data,
                    'message' => 'OTP Verified Successfully.'
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please Enter Valid OTP.'], REST_Controller::HTTP_BAD_REQUEST);
            }
            
        }else{
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please Enter Mobile Number And OTP.'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function location_post(){
        $latitude = $_POST['lat'];
        $longitude = $_POST['long'];
        $address = $this->getAddress($latitude, $longitude);
        
        if(count($address) > 0){
            /* Check State If Not Exist then Add State */
            $stateId = $this->user->addState($address['state']);
            /* Check City If Not Exist then Add City */
            $cityId = $this->user->addCity($address['city'], $stateId);

            $address = array(
                'state'=>$stateId,
                'city'=>$cityId,
                'formatted_address'=>$address['formatted_address']
            );
            $this->response(['status' => TRUE,'data'=>$address,'message' => ''], REST_Controller::HTTP_OK);            
        }else{
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Not Found'], REST_Controller::HTTP_BAD_REQUEST);
        }
        
    }
    
    public function getAddress($latitude, $longitude) {
        $resultArr = array();
        if (!empty($latitude) && !empty($longitude)) {
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($latitude) . ',' . trim($longitude) . '&sensor=true_or_false&key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s');
            $output = json_decode($geocodeFromLatLong);
            $status = $output->status;
            if($status == "OK"){
                $resultSet = $output->results;
                foreach ($resultSet[0]->address_components as $key => $value) {
                    $types = $value->types;
                    if($types[0] == "administrative_area_level_1"){
                        $resultArr['state'] = $value->long_name;
                    }
                    if($types[0] == "locality"){
                        $resultArr['city'] = $value->long_name;
                    }
                }
                $resultArr['formatted_address'] = $output->results[1]->formatted_address;
            }
        }
        return $resultArr;
    }
    
    public function resendOTP_post(){
        if(isset($_POST['mobile']) && isset($_POST['user_id'])){
            /*OTP*/
            $digits = 4;
            $i = 0; //counter
            $pin = ""; //our default pin is blank.
            while($i < $digits){
                $pin .= mt_rand(0, 9);
                $i++;
            }

            $apiKey = urlencode('R+SE/qLHCkw-AN9EaE7pwUmg9yX6zyq5sZwNqEdCRJ');
            $numbers = array('91'.$_POST['mobile']);
            $sender = urlencode('TXTLCL');
            $message = rawurlencode('Your reset password OTP for is : '.$pin." ".$_POST['haskey']);                         
            $numbers = implode(',', $numbers);                         
            $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response);

            $sql = "UPDATE user_register SET otp = '".$pin."', mobile = '".$_POST['mobile']."' WHERE id = '".$_POST['user_id']."'";
            $exe = $this->db->query($sql);
            $this->response([
                    'status' => TRUE,
                    'data'=>array("otp"=>$pin),
                    'message' => 'OTP Successfully Sent.'
                ], REST_Controller::HTTP_OK);
            
        }else{
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Something Wrong.'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function submitpayment_post(){
        if(isset($_POST['transactionid']) && isset($_POST['price_paid']) && isset($_POST['user_id'])){
           // $sql = "INSERT INTO payment_details (user_id, transaction_id, payment_amount) VALUES (".$_POST['user_id'].", '".$_POST['transactionid']."', ".$_POST['price_paid'].")";
           // $exe = $this->db->query($sql);

            $addPay = array("transaction_id"=>$_POST['transactionid'],"payment_amount"=>$_POST['price_paid'],"payment_date"=>date("Y-m-d h:i:s"),"pay_status"=>"1");
            $addPay = $this->user->UpdatePayment($addPay,$_POST['payment_id']); 

           if($addPay>0) {
			   $this->response([
	                    'status' => TRUE,
	                    'message' => 'Payment Done Successfully.'
	           ], REST_Controller::HTTP_OK); 
		   } else{
	            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Something Wrong.'], REST_Controller::HTTP_BAD_REQUEST);
	       }
        } else{
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Something Wrong.'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function nearby_post(){
        $lat = $_POST['latitide'];
        $long = $_POST['longitude'];
        $city = $_POST['city'];
        $Dealer = $_POST['dealer'];
        $distance = 10;
        
        $serviceCenter = $this->user->nearestServiceCenter($lat, $long, $distance,$city);
        if($Dealer=="1"){
            $dealer = $this->user->nearestDealer($lat, $long, $distance, $city);
        }else{
            $dealer = array();
        }
        
        if($city != ""){
            $retCity = $city;
        }else{
            if($lat != "" && $long != ""){
                $address = $this->getAddress($lat, $long);
                if(count($address) > 0){
                    $stateId = $this->user->addState($address['state']);
                    $cityId = $this->user->addCity($address['city'], $stateId);
                    $retCity = $cityId;
                }
            }
        }
        if(count($serviceCenter) > 0 || count($dealer) > 0){
            
            $returnArr['city'] = $retCity;
            $returnArr['service_center'] = $serviceCenter;
            $returnArr['dealer'] = $dealer;
            $this->response([
                    'status' => TRUE,
                    'data'=>$returnArr,
                    'message' => ''
                ], REST_Controller::HTTP_OK);
        }else{
            $returnArr['city'] = $retCity;
            $this->response(['status' => FALSE,'data'=>$returnArr,'message' => 'No Shop and Dealer Found.'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function mobileBanners_get(){
        $banners = $this->user->mobileBanners();
        // print_r($banners);
        // die();
        if(count($banners) > 0 ){
            foreach ($banners as $key => $ban) {
                $banners[$key]['mb_img'] = base_url().$ban['mb_img'];
            }
            $this->response([
                    'status' => TRUE,
                    'data'=>$banners,
                    'message' => ''
                ], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'No Baners Available.'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function forgotPassword_post(){
       $mobile = $_POST['mobile'];
       if(empty($mobile)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please Enter Mobile Number'], REST_Controller::HTTP_BAD_REQUEST);
       }else{
       $ckMobile = $this->user->getMobileNo($mobile);
       if(count($ckMobile)>0){
            $digits = 4;
            $i = 0; //counter
            $pin = ""; //our default pin is blank.
            while($i < $digits){
                $pin .= mt_rand(0, 9);
                $i++;
            }

            // $link = preg_replace("/ /", "%20", "http://smsfortius.com/api/mt/SendSMS?user=mohmaya&password=mohmaya&senderid=FIDEMO&channel=Trans&DCS=0&flashsms=0&number=91".$mobile."&text=".$pin." is the one time password (OTP) for Mohmaya Store&route=02");
            // $link = preg_replace("/ /", "%20", $link);
            // $response = json_decode(file_get_contents($link),true);

//            $sql = "UPDATE user_register SET otp = '".$pin."', mobile = '".$_POST['mobile']."' WHERE id = '".$ckMobile[0]['id']."'";

        	$apiKey = urlencode('R+SE/qLHCkw-AN9EaE7pwUmg9yX6zyq5sZwNqEdCRJ');
            $numbers = array('91'.$_POST['mobile']);
            $sender = urlencode('TXTLCL');
            $message = rawurlencode('Your reset password OTP for is : '.$pin." ".$_POST['haskey']);                         
            $numbers = implode(',', $numbers);                         
            $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response);

            $sql = "UPDATE user_register SET otp = '".$pin."' WHERE id = '".$ckMobile[0]['id']."'";
            $exe = $this->db->query($sql);
            if($exe){
               $this->response([
                    'status' => TRUE,
                    'data'=>array("otp"=>$pin,"userid"=>$ckMobile[0]['id']),
                    'message' => 'OTP Successfully Sent.'
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'data'=>'',
                    'message' => 'Something Went Wrong! Please Try Again'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            // die();
            
       }else{
        $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Mobile Number Not Registered'], REST_Controller::HTTP_BAD_REQUEST);
       }
   }
       // die();
    }

    public function VerifyForgotPassOtp_post(){
        $userid = $_POST['userid'];
        $otp = $_POST['otp'];
        if(empty($userid)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Userid is not Set! Please Check Userid'], REST_Controller::HTTP_BAD_REQUEST);
        }else if(empty($otp)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please Enter OTP'], REST_Controller::HTTP_BAD_REQUEST);
        }else{
            $verify = $this->user->verifyOtp($userid,$otp);
            if(count($verify)>0){
                $sql = "UPDATE user_register SET otp = 'NULL'  WHERE id = '".$verify[0]['id']."'";
                $exe = $this->db->query($sql);
                $this->response([
                    'status' => TRUE,
                    'data'=>array("userid"=>$verify[0]['id']),
                    'message' => 'OTP matched Successfully'
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response(['status' => FALSE,'data'=>NULL,'message' => 'OTP Not Matched.'], REST_Controller::HTTP_BAD_REQUEST);  
            }
        }
    }

    public function ChangePassword_post(){
        $userid = $_POST['userid'];
        $pass = $_POST['password'];
        $cpass = $_POST['c_password'];
        if(empty($userid)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Userid is not Set! Please Check Userid'], REST_Controller::HTTP_BAD_REQUEST);
        }else if(empty($pass)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please Enter Password'], REST_Controller::HTTP_BAD_REQUEST);
        }else if(empty($cpass)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please Enter Confirm Password'], REST_Controller::HTTP_BAD_REQUEST);
        }else if($cpass!=$pass){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Password Not Matched With Confirm Password'], REST_Controller::HTTP_BAD_REQUEST);            
        }else{

            $sql = "UPDATE user_register SET password = '".md5($pass)."' WHERE id = '".$userid."'";
            $exe = $this->db->query($sql);
            if($exe){    
                $this->response([
                    'status' => TRUE,
                    'data'=>'',
                    'message' => 'Password Changed Successfully'
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Password Not Change, Please try again.'], REST_Controller::HTTP_BAD_REQUEST);  
            }
        }
    }

    public function addcurriculum_post(){
        $cClass =   $_POST['curriculum_class'];
        $cDay   =   $_POST['curriculum_day'];
        $cLesson=   $_POST['curriculum_lesson'];
        $clDesc =   $_POST['lesson_desc'];
        $checkExist = $this->curriculum->getRows($cClass,$cDay,$cLesson);
        if(empty($cClass)){
             $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please Select Curriculum Class'], REST_Controller::HTTP_BAD_REQUEST);
        }else if(empty($cDay)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please Select Curriculum Day'], REST_Controller::HTTP_BAD_REQUEST);
        }else if(empty($cLesson)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please Select Curriculum lesson'], REST_Controller::HTTP_BAD_REQUEST);
        }else if(empty($clDesc)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please add some description'], REST_Controller::HTTP_BAD_REQUEST);
        }else if(count($checkExist)>0){

             $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Curriculum already created for this class, day and lesson'], REST_Controller::HTTP_BAD_REQUEST);   
        }else{

            $data = array("curriculum_class"=>$cClass,
                        "curriculum_day"=>$cDay,
                        "curriculum_lesson"=>$cLesson,
                        "curriculum_lesson_description"=>$clDesc
                        );

            $data['created_at'] = date("Y-m-d h:i:s");
            $data['updated_at'] = date("Y-m-d h:i:s");

            $insert = $this->curriculum->insert($data);
            if($insert>0){
                 $this->response([
                    'status' => TRUE,
                    'data'=>'',
                    'message' => 'Curriculum created Successfully'
                ], REST_Controller::HTTP_OK);
            }else{
                 $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Something went wrong! Please Try Again'], REST_Controller::HTTP_BAD_REQUEST);
            }
        }              
    }

    public function editcurriculum_get($id){
        $cid = $id;

        if(empty($cid)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Curriculum id is not set'], REST_Controller::HTTP_BAD_REQUEST);
        }else{
           $cdata = $this->curriculum->getRecords($cid,array('curriculum_id','curriculum_class','curriculum_day','curriculum_lesson','curriculum_lesson_description'));
            // die(print_r($cdata));
            if(count($cdata)>0){
                 $this->response([
                    'status' => TRUE,
                    'data'=>$cdata,
                    'message' => 'Curriculum created Successfully'
                ], REST_Controller::HTTP_OK);
            }else{
                 $this->response(['status' => FALSE,'data'=>NULL,'message' => 'No Records Found'], REST_Controller::HTTP_BAD_REQUEST);
            }
        }   
    }


    public function updatecurriculum_post(){
        $cId    =   $_POST['curriculum_id'];
        $cClass =   $_POST['curriculum_class'];
        $cDay   =   $_POST['curriculum_day'];
        $cLesson=   $_POST['curriculum_lesson'];
        $clDesc =   $_POST['lesson_desc'];
        //$checkExist = $this->curriculum->getRows($cClass,$cDay,$cLesson);
        if(empty($cClass)){
             $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please Select Curriculum Class'], REST_Controller::HTTP_BAD_REQUEST);
        }else if(empty($cDay)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please Select Curriculum Day'], REST_Controller::HTTP_BAD_REQUEST);
        }else if(empty($cLesson)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please Select Curriculum lesson'], REST_Controller::HTTP_BAD_REQUEST);
        }else if(empty($clDesc)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Please add some description'], REST_Controller::HTTP_BAD_REQUEST); 
        }else{

            $data = array("curriculum_class"=>$cClass,
                        "curriculum_day"=>$cDay,
                        "curriculum_lesson"=>$cLesson,
                        "curriculum_lesson_description"=>$clDesc
                        );

            //$data['created_at'] = date("Y-m-d h:i:s");
            $data['updated_at'] = date("Y-m-d h:i:s");

            $update = $this->curriculum->update($data,$cId);

            if($update>0){
                 $this->response([
                    'status' => TRUE,
                    'data'=>'',
                    'message' => 'Curriculum updated Successfully'
                ], REST_Controller::HTTP_OK);
            }else{
                 $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Something went wrong! Please Try Again'], REST_Controller::HTTP_BAD_REQUEST);
            }
        }              
    }

     public function classlist_post(){
        $cdata = $this->tb_class->getAllRecords();
        if(count($cdata)>0){
             $this->response([
                    'status' => TRUE,
                    'data'=>$cdata,
                    'message' => 'Curriculum created Successfully'
                ], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'No Records Found'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function lessonlist_post(){
        $lesson = $this->lesson->getAllRecords();
        if(count($lesson)>0){
             $this->response([
                    'status' => TRUE,
                    'data'=>$lesson,
                    'message' => ''
                ], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'No Records Found'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function daycurriculum_post(){
        $class = $_POST['curriculum_class'];
        $day  = $_POST['curriculum_day'];
        $data = $this->curriculum->getRows($class,$day);
        if(count($data)>0){
             foreach ($data as $key => $value) {
                 $lessonData = getData('lesson',array('lesson_title','lesson_icon'),"lesson_id",$value['curriculum_lesson']);
                 if(count($lessonData)>0){
                    $fullUrl = $_SERVER['DOCUMENT_ROOT']."".str_replace("index.php", "", $_SERVER['SCRIPT_NAME'])."".$lessonData[0]['lesson_icon'];
                    $data[$key]['lesson_title'] = $lessonData[0]['lesson_title'];
                    if(!empty($lessonData[0]['lesson_icon'])){
                        if(file_exists($fullUrl)){
                            $data[$key]['lesson_icon'] = base_url()."".$lessonData[0]['lesson_icon'];
                        }else{
                            $data[$key]['lesson_icon'] = base_url()."app-assets/images/default_lession-38x38.png";        
                        }
                    }else{
                        $data[$key]['lesson_icon'] = base_url()."app-assets/images/default_lession-38x38.png";    
                    }
                    // $data[$key]['lesson_icon'] = base_url()."".$lessonData[0]['lesson_icon'];
                 }
             }
             $this->response([
                    'status' => TRUE,
                    'data'=>$data,
                    'message' => ''
                ], REST_Controller::HTTP_OK);
        }else{
             $this->response(['status' => FALSE,'data'=>NULL,'message' => 'No Records Found'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function curriculumDesc_post(){
        $class = $_POST['curriculum_class'];
        $day  = $_POST['curriculum_day'];
        $lesson = $_POST['curriculum_lesson'];
        $id = $_POST['curriculum_id'];
        $userInfo = getData('user_register',array('token'),'id',$_POST['user_id']);
        $data = $this->curriculum->getRows($class,$day,$lesson,$id);
        if(count($data)>0){
             foreach ($data as $key => $value) {
                 $lessonData = getData('lesson',array('lesson_title','lesson_icon'),"lesson_id",$value['curriculum_lesson']);
                 if(count($lessonData)>0){
                    $data[$key]['lesson_title'] = $lessonData[0]['lesson_title'];
                    $data[$key]['lesson_icon'] = base_url()."".$lessonData[0]['lesson_icon'];

                 }
                 // print_r($value['curriculum_lesson_description']);
                 // exit();
                 $data[$key]['curriculum_lesson_description'] = stripslashes($value['curriculum_lesson_description']);
             }
             // die(print_r($data));
             $this->response([
                    'status' => TRUE,
                    'data'=>$data,
                    'message' => '',
                    'token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''
                ], REST_Controller::HTTP_OK);
        }else{
             $this->response(['status' => FALSE,'data'=>NULL,'message' => 'No Records Found','token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getClassTotalDays_post(){
        // die(print_r($_POST['user_id']));
        $getUser = $_POST['user_id'];
        $userInfo = getData('user_register',array('class','package','token'),'id',$getUser);
        if(count($userInfo)>0){
            $class = getData('tb_class',array(),'class_id',$userInfo[0]['class']);
            $package = getData('tb_package',array('type','days'),'package_id',$userInfo[0]['package']);
            $payment = $this->user->getPaymentDetail($getUser);
            $validity = getValidity($getUser);
            $validity = explode('/', $validity['validity']);
            $totValidity = ($validity[1] - $validity[0]);
            $data = array();
            $data['class_name'] = (count($class)>0) ? $class[0]['title'] : '';
            $data['class_id'] = (count($class)>0) ? $class[0]['class_id'] : '';
            $data['validity'] = $totValidity;
            $data['free_days'] = (count($class)>0) ? $class[0]['free_days'] : '';
            if(count($package)>0){
                if($package[0]['type']=="free"){
                    $data['total_days'] = $package[0]['days'];
                }else{
                    $data['total_days'] = $class[0]['c_days'];
                }    
            }else{
                $data['total_days'] = 0;
            }

            if($payment['pay_status']==1){
                $data['payment'] = true;
            }else{
                $data['payment'] = false;
            }
            $data['payment_id'] = $payment['payment_id'];
            
            
            $firstDay = date("Y-m-d",strtotime(($payment['created_date'])));
            $cdays = date("Y-m-d");
            $last_days = date("Y-m-d h:i:s",strtotime("+".$data['total_days']." day", strtotime($payment['created_date'])));
            $currentDay = "";
            $cnt=1;
            if($cdays==$firstDay){
                $currentDay = 1;
                $prevDay = 1;
            }else{
                $date1 = date_create(date("Y-m-d"));
                $date2 = date_create($firstDay);
                $diff  = date_diff($date1,$date2);
                $currentDay = $diff->format("%a")+$cnt; 
                $prevDay = $currentDay + $cnt;
            }

            
            // if(empty($payment['current_day'])){
            //     // $curDay = $currentDay;
            //     $curDay = 1;
            // }else if($payment['current_day']==$currentDay){
            //     $curDay = $currentDay + 1;
            // }else{
            //    $curDay = $payment['current_day'] + 1; 
            // }

            if(empty($payment['current_day'])){
                $curDay = 1;
            }else{
                $curDay = $payment['current_day'] + 1;
            }
            
            // if($payment['pay_status']==0 && $curDay > 2){
            if($payment['pay_status']==0 && $curDay > $class[0]['free_days']){
                $data['access'] = false;
            }else{
                $data['access'] = true;
            }

            $data['currentDay'] = ($data['total_days']>0) ? $curDay : 0;
            $data['prevDay'] = ($data['total_days']>0) ? $prevDay : 0;

            $this->response([
                        'status' => TRUE,
                        'data'=>$data,
                        'message' => '',
                        'token'=>$userInfo[0]['token']
                    ], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'No Records Found','token'=>''], REST_Controller::HTTP_BAD_REQUEST);
        }   
        
    }

    public function submitDay_post(){
        $cnt=0;
        $payment_id = $_POST['payment_id'];
        $day = $_POST['day'];

        if(empty($payment_id)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Reference id is not set !please try again'], REST_Controller::HTTP_BAD_REQUEST);
        }else if(empty($day)){
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'day is not set !please try again'], REST_Controller::HTTP_BAD_REQUEST);
        }else{
            $check = getData('payment_details',array('payment_id,pay_status,user_id'),'payment_id',$payment_id);
            if(count($check)>0){

                if(isset($check[0]['pay_status']) && $check[0]['pay_status'] == 0){

                    $getClassId = getData('user_register',array('class'),'id',$check[0]['user_id']);  
                    $freedays = getData('tb_class',array('free_days'),'class_id',$getClassId[0]['class']); 
                    $subDay = getData('payment_details',array('current_day'),'user_id',$check[0]['user_id']); 
                    if(($subDay[0]['current_day'] + 1) <= $freedays[0]['free_days']){

                        $data = array("updated_at"=>date("Y-m-d h:i:s"),"current_day"=>$day);
                        $update = $this->user->UpdatePayment($data,$payment_id);
                        
                        if($update>0){
                            $this->response([
                                    'status' => TRUE,
                                    'data'=>'',
                                    'message' => 'Your Day Completed Successfully'
                                ], REST_Controller::HTTP_OK);
                        }else{
                            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Something Went Wrong! Please try again2'], REST_Controller::HTTP_BAD_REQUEST);
                        }
                    }else{
                        $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Something Went Wrong! Please try again1'], REST_Controller::HTTP_BAD_REQUEST);
                    }
                }else{
                    $data = array("updated_at"=>date("Y-m-d h:i:s"),"current_day"=>$day);
                    $update = $this->user->UpdatePayment($data,$payment_id);
                    // die($update);
                    if($update>0){
                        $this->response([
                                'status' => TRUE,
                                'data'=>'',
                                'message' => 'Your Day Completed Successfully'
                            ], REST_Controller::HTTP_OK);
                    }else{
                        $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Something Went Wrong! Please try again'], REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
            }else{
                $this->response(['status' => FALSE,'data'=>NULL,'message' => 'Something Went Wrong! Please try again'], REST_Controller::HTTP_BAD_REQUEST);
            }
            
        }
    }

    public function bookcall_post(){
        $userid = $_POST['user_id'];
        if(empty($userid)){
             $this->response(['status' => FALSE,'data'=>NULL,'message' => 'userid is not set'], REST_Controller::HTTP_BAD_REQUEST);
        }else{
            $for = array(); $cnt=0;
            foreach ($_POST as $key => $value) {
                if(empty($value)){
                    if($key=="day_number" || $key=="lesson"){}else{
                        $arr = array("for"=>$key,"message"=>"Please Enter ".$key);
                        array_push($for, $arr);
                        $cnt++;
                    }
                }
            }
            if($cnt==0){
                $maxIncr = $this->bookcall->getLastIncr();

                if($maxIncr['max(incr)']!=""){

                    $apptId = "RB".sprintf('%04d',($maxIncr['max(incr)'] + 1));
                    $inCr = ($maxIncr['max(incr)'] + 1);
                    
                }else{
                    $apptId = "RB0001";
                    $inCr = 1;
                }
                $status_history = array("status"=>"1","hdate"=>date("Y-m-d h:i:s"));
                $data1 = array();
                array_push($data1, $status_history);    
                $data = array("appt_id"=>$apptId,"user_id"=>$userid,"prefer_time"=>$_POST['prefer_time'],
                            "current_status"=>"1","incr"=>(int)$inCr,"day_no"=>$_POST['day_number'],
                            "lesson"=>$_POST['lesson'],"message"=>$_POST['message'],"ref_id"=>"-1",
                            "created_at"=>date("Y-m-d h:i:s"),"updated_at"=>date("Y-m-d h:i:s"),
                            "request_for"=>$_POST['request_for'],"status_history"=>json_encode($data1));

                $insert = $this->bookcall->insert($data);
                if($insert>0){
                    $this->response([
                        'status' => TRUE,
                        'data'=>$insert,
                        'message' => 'Request Sent Successfully'
                    ], REST_Controller::HTTP_OK);
                }else{  
                     $this->response(['status' => FALSE,'data'=>'','message' => 'Something Went Wrong! Please Try Again'], REST_Controller::HTTP_BAD_REQUEST);
                }

                 
            }else{
                $this->response(['status' => FALSE,'data'=>$for[0]['for'],'message' => $for[0]['message']], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function bookcallUpdate_post(){
         $data = array("prefer_time"=>$_POST['prefer_time'],
                            "day_no"=>$_POST['day_number'],
                            "lesson"=>$_POST['lesson'],"message"=>$_POST['message'],
                            "updated_at"=>date("Y-m-d h:i:s"),
                            "request_for"=>$_POST['request_for']);

        $insert = $this->bookcall->update($data,$_POST['request_id']);
        if($insert>0){
            $getData = getData('book_call',array(),'book_id',$insert);
            $this->response([
                'status' => TRUE,
                'data'=>$getData,
                'message' => 'Request Updated Successfully'
            ], REST_Controller::HTTP_OK);
        }else{  
             $this->response(['status' => FALSE,'data'=>'','message' => 'Something Went Wrong! Please Try Again'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function Knowledgebase_post(){
        $data = $this->Help->gethelpMain('',array('help_id','title'));
        if(count($data)>0){ 

            $this->response([
                        'status' => TRUE,
                        'data'=>$data,
                        'message' => 'Request Sent Successfully'
                    ], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'data'=>'','message' => 'No Records Found'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getKnowledgebase_post(){
        $data = $this->Help->getAllRecords($_POST['support_id'],$_POST['type']);
         $userInfo = getData('user_register',array('token'),'id',$_POST['user_id']);
        if(count($data)>0){
             if($_POST['type']=="1"){
                $this->response([
                        'status' => TRUE,
                        'data'=>$data,
                        'message' => 'Request Sent Successfully',
                        'token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''
                    ], REST_Controller::HTTP_OK);
             }else{
                $data1 = array();

                foreach ($data as $key => $value) {
                    $extract = json_decode($value['video_url']);
                    if(count($extract)>0){
                        foreach ($extract as $key1 => $value1) {
                            array_push($data1, $value1);
                        }
                    }      
                }

                foreach ($data as $key => $value) {
                    $data[$key]['video_url'] = (count($data1)>0) ? base_url()."".$data1[0] : '';
                }
                 $this->response([
                        'status' => TRUE,
                        'data'=>$data,
                        'message' => 'Request Sent Successfully',
                        'token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''
                    ], REST_Controller::HTTP_OK);

             }
             // foreach ($data as $key => $value) {
             //     if($value['htype']=="2"){
             //        $data[$key]['video_url'] = base_url()."".$value['video_url'];
             //     }
             // }
             
        }else{
             $this->response(['status' => FALSE,'data'=>'','message' => 'No Records Found','token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function getSyllabus_post(){
        $class_id = $_POST['class_id'];
        $classT = getData("tb_class",array('title'),'class_id',$class_id);
        $data['class_title'] = (count($classT)>0) ? $classT[0]['title'] : '';
        $userInfo = getData('user_register',array('token'),'id',$_POST['user_id']);
        if(count($classT)>0){
            $syllabus = getData('tb_syllabus',array('description'),'s_for',$class_id);
            $data['syllabusData'] = (count($syllabus)>0) ? $syllabus[0]['description'] : '';
            if(count($syllabus)>0){
                $this->response([
                        'status' => TRUE,
                        'data'=>$data,
                        'message' => 'Request Sent Successfully',
                        'token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''
                    ], REST_Controller::HTTP_OK);
            }else{
                $this->response(['status' => FALSE,'data'=>'','message' => 'No Syllabus Found For this class','token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''], REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
           $this->response(['status' => FALSE,'data'=>'','message' => 'Class id is invalid','token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }


    public function UpdateProfile_post(){
        $for=array(); $cnt=0;
        foreach ($_POST as $key => $value) {
            if(empty($value)){
                $arr1 = array("for"=>$key,"message"=>"Please enter ".$key);
                array_push($for, $arr1);
                $cnt++;
            }

            if($key=="mobile"){
                
                if(!empty($value)){

                    $checkMobile = $this->user->checkMobile($value,$_POST['user_id']);
                    if(strlen($value)!=10){
                        $arr = array("for"=>$key,"message"=>"Please Enter Valid Mobile Number");
                        array_push($for,$arr);
                        $cnt++;
                    }else if($checkMobile>0){
                        $arr = array("for"=>$key,"message"=>"Mobile Number Exist");
                        array_push($for,$arr);
                        $cnt++;
                    }
                }else if(empty($value)){
                    $arr = array("for"=>$key,"message"=>"Please Enter Mobile Number");
                    array_push($for,$arr);
                    $cnt++;
                }
            }

           

            if($key=="email"){
                if(!empty($value)){
                    $checkEmail = $this->user->checkEmail($value,$_POST['user_id']);
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
            $config['max_size']             =  '10240';
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
                    $arr = array("for"=>"userImg","message"=>"Image should not be greter than 10MB");
                    array_push($for,$arr);
                    $cnt++; 
                }
               // $arr = array("for"=>"userImg","message"=>$this->upload->display_errors());
            }
        }

        if($cnt==0){
            $uData = array("email"=>$_POST['email'],"child_name"=>$_POST['child_name'],"mobile"=>$_POST['mobile']);
            if($fileName!=""){
                $uData['user_img'] = $fileName;
            }
            
            $update = $this->user->update($uData,$_POST['user_id']);
            if($update){
                $this->response([
                        'status' => TRUE,
                        'data'=>'',
                        'message' => 'Profile Updated Successfully'
                    ], REST_Controller::HTTP_OK);
            }else{
               $this->response(['status' => FALSE,'data'=>'','message' => 'Failed To Update Profile Data'], REST_Controller::HTTP_BAD_REQUEST); 
            }
        }else{
            $this->response(['status' => FALSE,'data'=>$for[0]['for'],'message' => $for[0]['message']], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function beforPayment_post(){
        $user_id = $this->post('user_id');
        $userData = getData('user_register',array('id','class'),'id',$user_id);
        if(count($userData)>0){
            $class = getData('tb_class',array(),'class_id',$userData[0]['class']);
            if(count($class)>0){
                $data = array("user_id"=>$user_id,"price"=>$class[0]['price'],"class"=>$class[0]['title'],
                    "child_age"=>$class[0]['child_age'],"class_level"=>$class[0]['c_level'],"class_days"=>$class[0]['c_days']);
                $this->response([
                        'status' => TRUE,
                        'data'=>$data,
                        'message' => 'Profile Updated Successfully'
                    ], REST_Controller::HTTP_OK);
            }else{
                $this->response(['status' => FALSE,'data'=>'','message' => 'Class Not Found'], REST_Controller::HTTP_BAD_REQUEST);    
            }
        }else{
            $this->response(['status' => FALSE,'data'=>'','message' => 'No User Account Found'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function displayPricing_post(){
      $userInfo = getData('user_register',array('token','class'),'id',$_POST['user_id']);
      $data = getMultiWhere('tb_class',array(),array('class_id'=>$userInfo[0]['class']));
      if(count($data)>0){

         foreach ($data as $key => $value) {
            $package = json_decode($value['package']);
            
            $free="";
            foreach ($package->package as $key1 => $value1) {
                // echo $value1;
                $getpdata = getData('tb_package',array('type','days'),'package_id',$value1);
                
                if(count($getpdata)>0){
                    // echo $getpdata[0]['days'];     
                    if($getpdata[0]['type']=='free'){
                        $free .= $getpdata[0]['days'];
                    // }else{
                        // $data[$key]['freedemo'] = "1";
                    }
                }
                
            }
            $data[$key]['freedemo'] = $free;
            unset($data[$key]['package']);
            unset($data[$key]['created_at']);
            unset($data[$key]['updated_at']);
         }
         // die();
         $this->response([
                        'status' => TRUE,
                        'data'=>$data,
                        'message' => 'Profile Updated Successfully',
                        'token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''
                    ], REST_Controller::HTTP_OK);

      }else{
            $this->response(['status' => FALSE,'data'=>'','message' => 'No Records Found','token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''], REST_Controller::HTTP_BAD_REQUEST);
      }
   } 


   public function notificationList_post(){
        // $userInfo = getData('user_register',array('token','class'),'id',$_POST['user_id']);
        // $notList = $this->notifications->userNotificationList(date("m"),date("Y"),$userInfo[0]['class']);
        // $payment1 = getMultiWhere('payment_details',array('pay_status'),array('user_id'=>$_POST['user_id']));
        
        // if(count($notList)>0){
        //     $notArr = array();
        //     foreach ($notList as $key => $value) {
        //         if($value['type']=="allusers"){
        //             array_push($notArr,$value['notifi_id']);
        //         }else if($value['type']=="freeusers"){
        //             if(count($payment1)>0){
        //                 if($payment1[0]['pay_status']=="0"){
        //                     array_push($notArr,$value['notifi_id']);        
        //                 }
        //             }
        //         }else if($value['type']=="premiumusers"){
        //             if(count($payment1)>0){
        //                 if($payment1[0]['pay_status']=="1"){
        //                     array_push($notArr,$value['notifi_id']);        
        //                 }
        //             }
        //         }else if($value['type']=="exusers"){
        //             $userIds = json_decode($value['userid']);
        //             if(in_array($_POST['user_id'], $userIds)){

        //                 array_push($notArr,$value['notifi_id']);        
        //             }
        //         }
        //     }
            $userInfo = getData('user_register',array('token','class','id'),'id',$_POST['user_id']);
            // $notArr = array_unique($notArr);
            
            $storeNot = $this->notifications->getUserStoredNotification($userInfo[0]['id']);
            if(count($storeNot)>0){
            $data = array();
            foreach ($storeNot as $key => $value) {
                $getD = getData('tb_admin_notify',array(),'notifi_id',$value['notifi_id']);
                if(count($getD)>0){
                    $ckNot = getMultiWhere('tb_notification_log',array('id'),array('notification_id'=>$value['notifi_id'],'user_id'=>$_POST['user_id']));
                    $data[$key]['notifi_id'] = $value['notifi_id'];
                    $data[$key]['message'] = $getD[0]['message'];
                    if(count($ckNot)>0){
                        $data[$key]['viewstatus'] = true;
                    }else{
                        $data[$key]['viewstatus'] = false;    
                    }
                    
                    $data[$key]['date_created'] = (!empty($value['created_at'])) ? date("d-m-Y",strtotime($value['created_at'])) : '';
                }
            }

            $dataArr = array();
            foreach ($data as $k => $val) {
                $dataArr[] = $val;
            }

            $data = json_encode($data);
            $this->response([
                        'status' => TRUE,
                        'data'=>$dataArr,
                        'message' => 'List Of Notifications',
                        'token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''
                    ], REST_Controller::HTTP_OK);
        }else{
             $this->response(['status' => FALSE,'data'=>'','message' => 'No Records Found','token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''], REST_Controller::HTTP_BAD_REQUEST);
        }
   }


   public function viewNotifications_post(){
        $userInfo = getData('user_register',array('token','class'),'id',$_POST['user_id']);
        $notInfo = getData('tb_admin_notify',array('notifi_id','message'),'notifi_id',$_POST['notification_id']);
        if(count($notInfo)>0){
            $ckNot = getMultiWhere('tb_notification_log',array('id'),array('notification_id'=>$notInfo[0]['notifi_id'],'user_id'=>$_POST['user_id']));
            if(count($ckNot)>0){
            }else{
                $data = array('user_id'=>$_POST['user_id'],'notification_id'=>$notInfo[0]['notifi_id'],'nstatus'=>"1",'created_at'=>date("Y-m-d h:i:s"),'updated_at'=>date("Y-m-d h:i:s"));
                $insert = $this->notifications->insertNotificationLog($data);
            }

             $this->response([
                        'status' => TRUE,
                        'data'=>$notInfo,
                        'message' => 'Notification Message',
                        'token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''
                    ], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'data'=>'','message' => 'No Records Found','token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''], REST_Controller::HTTP_BAD_REQUEST);
        }
   }

   public function removeImage_post(){
        $userInfo = getData('user_register',array('token','class'),'id',$_POST['user_id']);
        $data = array("user_img"=>"");
        $update = $this->user->update($data,$_POST['user_id']);
        if($update>0){
            $this->response([
                        'status' => TRUE,
                        'data'=>$notInfo,
                        'message' => 'Profile Image Removed Successfully',
                        'token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''
                    ], REST_Controller::HTTP_OK);
        }else{
             $this->response(['status' => FALSE,'data'=>'','message' => 'No Records Found','token'=>(count($userInfo)>0) ? $userInfo[0]['token'] : ''], REST_Controller::HTTP_BAD_REQUEST);
        }
   }


	public function sendMail($arr = []) {
		$to = $arr['to'];
        $sub = $arr['subject'];
                
//      $html = $this->htmlTemplate();
        $html = $arr['html'];
                    
  //       $config = array(
		// 	'protocol'  => 'smtp',
		// 	'smtp_host' => 'mail.itidoltechnologies.com',
		// 	'smtp_port' => 587,
		// 	'smtp_user'  => 'test@itidoltechnologies.com', 
		// 	'smtp_pass'  => '123456', 
		// 	'mailtype'  => 'html',
		// 	'charset'    => 'iso-8859-1',
		// 	'wordwrap'   => TRUE
		// );
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
}