<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_notification extends CI_Controller {
	
	public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('user');
        $this->load->model('tb_class');
        $this->load->model('package');
        $this->load->model('notifications');
        $this->load->model('Curriculum');
        $this->load->helper('get_data_helper');
        $this->load->helper(array('url','html','form'));

    }

    public function index(){
        $data = array();
        $data['page_name'] = 'Notifications List';
        $data['scriptname'] = 'notifications.js';
        
        // $list = $this->notifications->getAllRecords();
        // foreach ($list as $key => $value) {

        // }

        $data['notificationList'] = $this->notifications->getAllRecords();
        $class = $this->tb_class->getAllRecords();
        $classArr = array();
        foreach ($class as $key => $value) {
            $classArr[$value['class_id']] = $value['title'];
        }
        $data['class'] = $classArr;
        //$activeMenu = $this->user->getActiveMenu('Curriculum', 'main_menu');
        $rolePermission = $this->user->getRolePermission($_SESSION['LoginUserData']['role']);
        $data['active_menu'] = $activeMenu;
        $data['role_id'] = $_SESSION['LoginUserData']['role'];
        $data['permission'] = $rolePermission;

        // $data['breadCrumb'] = '<ol class="breadcrumb m-0">
        // <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
        // <li class="breadcrumb-item">Notification List</li>

        // </ol>';

        
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Notifications/notificationlist', $data);
        }
    }

    public function create(){
        $data = array();
        $data['page_name'] = 'Create Notifications';
        $data['scriptname'] = "notifications.js";
        $data['classList'] = $this->tb_class->getAllRecords();
        $data['userNotList'] = $this->notifications->GetUserNot('all','all');
        $data['userList'] = $this->user->getRows(array('role'=>5));
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="'.base_url().'Ct_notification/index">Notification List</a></li>
        <li class="breadcrumb-item active">Create Notification</li>
        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
           // die(print_r($data['userNotList']));
            $this->load->view('Notifications/create', $data);
        }
    }

    public function selectPackage(){
        $cpackage = getData('tb_class',array('package'),'class_id',$_POST['classid']);
        if(count($cpackage)>0){
            $package = json_decode($cpackage[0]['package']);
            $arr1 = array();
            foreach ($package->package as $key => $value) {
                array_push($arr1, $value);
            }
            $data['packageList'] = $arr1;
        }else{
            $data['packageList'] = array();
        }
        $this->load->view('Notifications/selectpackage',$data);
    }

    public function selectCurrDays(){
        $dayType = $_POST['daytype'];
        $class = $_POST['classid'];
        $getday = $this->Curriculum->getCurriculumDays($class);
        $classArr = array();
        $selected = array();
        if(count($getday)>0){
            foreach ($getday as $key => $value) {
                array_push($classArr, $value['curriculum_day']);
                if($dayType=='everyday'){
                    array_push($selected, $value['curriculum_day']);
                }
            }
        }
        $classArr = array_unique($classArr);
        $selected = array_unique($selected);
        asort($classArr);
        asort($selected);
        // die(print_r($selected));
        $data['curriculum_day'] = $classArr;
        $data['selected'] = $selected;
        $this->load->view('Notifications/selectday',$data);
    }

    public function selectCurrDaysEdit(){
        $dayType = $_POST['daytype'];
        $class = $_POST['classid'];
        $curriculum_day = json_decode($_POST['curriculum_day']);
        $getday = $this->Curriculum->getCurriculumDays($class);
        $classArr = array();
        $selected = array();
        if(count($getday)>0){
            foreach ($getday as $key => $value) {
                array_push($classArr, $value['curriculum_day']);
                if($dayType=='everyday'){
                    if(in_array($value['curriculum_day'], $curriculum_day)){
                        array_push($selected, $value['curriculum_day']);
                    }
                }elseif ($dayType=='specific') {
                    if(in_array($value['curriculum_day'], $curriculum_day)){
                        array_push($selected, $value['curriculum_day']);
                    }
                }
            }
        }
        $classArr = array_unique($classArr);
        $selected = array_unique($selected);
        asort($classArr);
        asort($selected);
        $data['curriculum_day'] = $classArr;
        $data['selected'] = $selected;
        $data['curriculum_day_selected'] = $curriculum_day;
        $this->load->view('Notifications/selectday',$data);
    }

    public function addnotification(){
        $for=array(); $cnt=0;
        if(empty($_POST['class_id'])){
            $arr1 = array("for"=>"class_id","message"=>"Please Select Class");
            array_push($for,$arr1);
            $cnt++;    
        }
        if(empty($_POST['daytype'])){
            $arr1 = array("for"=>"daytype","message"=>"Please Select Day Type");
            array_push($for,$arr1);
            $cnt++;       
        }

        if(empty($_POST['message'])){
          $arr1 = array("for"=>"message","message"=>"Please Enter Description");
            array_push($for,$arr1);
            $cnt++;        
        }
        // if(count($_POST['curriculum_day'])==0){
        //     $arr = array("for"=>"curriculum_day","message"=>"Please Select curriculum day");
        //     array_push($for,$arr);
        //     $cnt++;       
        // }
        // if(empty($_POST['daytype'])){
        //     $arr = array("for"=>"daytype","message"=>"Please Select Day Type");
        //     array_push($for,$arr);
        //     $cnt++;       
        // }
        if(count($_POST['usertype'])==0){
            $arr1 = array("for"=>"usertype","message"=>"Please Select Users type");
            array_push($for,$arr1);
            $cnt++;       
        }

        if($cnt==0){
            $cdayArr = array(); $userArr = array();
            if(count($_POST['curriculum_day'])>0){
              foreach ($_POST['curriculum_day'] as $key => $value) {
                array_push($cdayArr, $value);
              }
            }
            
            if(count($_POST['exusers'])>0){
              foreach ($_POST['exusers'] as $key => $value) {
                array_push($userArr, $value);
              }
            }

            $data = array("class_id"=>$_POST['class_id'],"class_day"=>json_encode($cdayArr),
                    "message"=>$_POST['message'],"created_at"=>date("Y-m-d h:i:s"),"updated_at"=>date("Y-m-d h:i:s"),
                    "userid"=>json_encode($userArr),"status"=>"1","type"=>$_POST['usertype'],"day_type"=>$_POST['daytype']);
            $insert = $this->notifications->insert($data);
            if($insert>0){
              $arr = array("status"=>true,"data"=>"","message"=>"Successfully saved");
            }else{
              $arr = array("status"=>false,"data"=>"","message"=>"Failed To Save");
            }
        }else{
            $arr = array("status"=>false,"data"=>$for[0]['for'],"message"=>$for[0]['message']);
        }

        echo json_encode($arr);
    }


    public function updatenotification(){
      $for=array(); $cnt=0;
        if(empty($_POST['class_id'])){
            $arr1 = array("for"=>"class_id","message"=>"Please Select Class");
            array_push($for,$arr1);
            $cnt++;    
        }
        if(empty($_POST['daytype'])){
            $arr1 = array("for"=>"daytype","message"=>"Please Select Day Type");
            array_push($for,$arr1);
            $cnt++;       
        }

        if(empty($_POST['descr'])){
          $arr1 = array("for"=>"message","message"=>"Please Enter Description");
            array_push($for,$arr1);
            $cnt++;        
        }
        // if(count($_POST['curriculum_day'])==0){
        //     $arr = array("for"=>"curriculum_day","message"=>"Please Select curriculum day");
        //     array_push($for,$arr);
        //     $cnt++;       
        // }
        // if(empty($_POST['daytype'])){
        //     $arr = array("for"=>"daytype","message"=>"Please Select Day Type");
        //     array_push($for,$arr);
        //     $cnt++;       
        // }
        if(count($_POST['usertype'])==0){
            $arr1 = array("for"=>"usertype","message"=>"Please Select Users type");
            array_push($for,$arr1);
            $cnt++;       
        }

        if($cnt==0){
            $cdayArr = array(); $userArr = array();
            if(count($_POST['curriculum_day'])>0){
              foreach ($_POST['curriculum_day'] as $key => $value) {
                array_push($cdayArr, $value);
              }
            }
            
            if(count($_POST['exusers'])>0){
              foreach ($_POST['exusers'] as $key => $value) {
                array_push($userArr, $value);
              }
            }

            $data = array("class_id"=>$_POST['class_id'],"class_day"=>json_encode($cdayArr),
                    "message"=>$_POST['message'],"created_at"=>date("Y-m-d h:i:s"),"updated_at"=>date("Y-m-d h:i:s"),
                    "userid"=>json_encode($userArr),"type"=>$_POST['usertype'],"day_type"=>$_POST['daytype']);
            $insert = $this->notifications->update($data,$_POST['id']);
            if($insert>0){
              $arr = array("status"=>true,"data"=>"","message"=>"Successfully updated");
            }else{
              $arr = array("status"=>false,"data"=>"","message"=>"Failed To update");
            }
        }else{
            $arr = array("status"=>false,"data"=>$for[0]['for'],"message"=>$for[0]['message']);
        }

        echo json_encode($arr);
    }

    public function edit($id){
     $data = array();
     $data['page_name'] = 'Edit Notifications';
     $data['scriptname'] = "notifications.js";
     $data['notificationData'] = $this->notifications->getAllRecords($id);
     $data['userNotList'] = $this->notifications->GetUserNot('all','all');
     $data['classList'] = $this->tb_class->getAllRecords();
     $data['userList'] = $this->user->getRows(array('role'=>5));
     $data['id'] = $id;
     $data['breadCrumb'] = '<ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="'.base_url().'Ct_notification/index">Notification List</a></li>
        <li class="breadcrumb-item active">Edit Notification</li>
        </ol>';
     // $data['breadCrumb'] = '<ol class="breadcrumb m-0">
     // <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
     // <li class="breadcrumb-item"><a href="'.base_url().'Ct_package/index">Package</a></li>
     // <li class="breadcrumb-item active">Create Package</li>
     // </ol>';
     if (!isset($_SESSION['username'])) {
        $this->load->view('login');
    } else {
        $this->load->view('Notifications/edit', $data);
    }
}

public function addNotifications(){
   $class_id = $_POST['class_id'];
   $day_type = $_POST['daytype'];
   $class_day = isset($_POST['curriculum_day']) ? json_encode($_POST['curriculum_day']) : '';
   $type = $_POST['usertype'];
   $message = $_POST['message'];
   $user = array();
   if($type == 'exusers'){
    $userid = isset($_POST['exusers']) ? json_encode($_POST['exusers']) : '';
   }else{
    $userid = json_encode();
   }
   

   $data = array(
      'class_id' => $class_id, 
      'day_type'=> $day_type,
      'class_day'=>$class_day,
      'type'=>$type,
      'message'=>$message,
      'userid'=>$userid
  );
    	// $insert = $this->db->insert('tb_admin_notify', $data);
   $insert = $this->notifications->insert($data);
   header("Location: ".base_url().'Ct_notification'); 
}

public function editNotifications(){
   $class_id = $_POST['class_id'];
   $day_type = $_POST['daytype'];
   $class_day = isset($_POST['curriculum_day']) ? json_encode($_POST['curriculum_day']) : '';
   $type = $_POST['usertype'];
   $message = $_POST['message'];
   // $userid = isset($_POST['exusers']) ? json_encode($_POST['exusers']) : '';
   $user = array();
   if($type == 'exusers'){
    $userid = isset($_POST['exusers']) ? json_encode($_POST['exusers']) : '';
   }else{
    $userid = json_encode();
   }

   $data = array(
      'class_id' => $class_id, 
      'day_type'=> $day_type,
      'class_day'=>$class_day,
      'type'=>$type,
      'message'=>$message,
      'userid'=>$userid
  );
    	// $insert = $this->db->insert('tb_admin_notify', $data);
   $update = $this->notifications->update($data,$_POST['id']);
   header("Location: ".base_url().'Ct_notification'); 
}

  public function removeNotification(){
    $id=$_POST['id'];

    $delete = $this->notifications->delete($id);
    if($delete){
            $arr = array("status"=>true,"data"=>"","message"=>"Successfully Removed");
        }else{
            $arr = array("status"=>true,"data"=>"","message"=>"Failed To Removed");
        }
        echo json_encode($arr);
  }



}   